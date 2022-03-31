<?php
/**
 * 2007-2020 Ifthenpay Lda
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
 * @copyright 2007-2020 Ifthenpay Lda
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once dirname(__FILE__) .'/vendor/autoload.php';

use PrestaShop\Module\Ifthenpay\Utility\Utility;
use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;
use PrestaShop\Module\Ifthenpay\Factory\Config\ConfigFactory;
use PrestaShop\Module\Ifthenpay\Factory\Payment\GatewayFactory;
use PrestaShop\Module\Ifthenpay\Factory\Database\DatabaseFactory;
use PrestaShop\Module\Ifthenpay\Factory\IfthenpayStrategyFactory;
use PrestaShop\Module\Ifthenpay\Factory\Models\IfthenpayModelFactory;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopFactory;
use PrestaShop\Module\Ifthenpay\Factory\Config\IfthenpayInstallerFactory;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;

class Ifthenpay extends PaymentModule
{
    protected $config_form = false;
    private $ifthenpayConfig;

    public function __construct()
    {
        $this->name = 'ifthenpay';
        $this->tab = 'payments_gateways';
        $this->version = '1.2.5';
        $this->author = 'Ifthenpay';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->controllers = [
            'adminIfthenpayPaymentMethodSetup',
            'adminIfthenpayActivateNewAccount',
            'validation',
            'payment',
            'callback',
            'update',
            'remember',
            'resend',
            'resendMbwayNotification',
            'updateIfthenpayUserAccount',
            'adminIfthenpayChooseNewPaymentMethod',
            'cancelMbwayOrder',
            'adminIfthenpayResetAccount',
        ];

        parent::__construct();

        $this->displayName = $this->l('Ifthenpay');
        $this->description = $this->l('Allows payments by Multibanco reference, MB WAY, Payshop and Credit Card.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall ifthenpay module?');
        $this->currencies = true;
        $this->currencies_mode = 'checkbox';
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->ifthenpayConfig = Configuration::getMultiple(
            [
            'IFTHENPAY_USER_PAYMENT_METHODS',
            'IFTHENPAY_BACKOFFICE_KEY'
            ]
        );
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        if (!extension_loaded('curl')) {
            $this->_errors[] = 'You have to enable the cURL extension on your server to install this module';
            return false;
        }
        //multistore
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
        if (!parent::install() || !$this->registerHook('payment') || !$this->registerHook('paymentOptions') ||
        !$this->registerHook('paymentReturn') || !$this->registerHook('displayAdminOrder') ||
        !$this->registerHook('displayOrderDetail') || !$this->registerHook('header') ||
        !$this->registerHook('actionAdminControllerSetMedia') || !$this->registerHook('actionFrontControllerSetMedia') || !$this->registerHook('displayBackOfficeHeader')
        ) {
            return false;
        }
        try {
            ConfigFactory::buildIfthenpaySql()->createIfthenpayLogSql();
            return true;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function uninstall()
    {
        try {
            if (Shop::isFeatureActive() && Shop::getContext() !== Shop::CONTEXT_SHOP) {
                $this->_errors[] = $this->l(
                    'Module configuration is only available for Shop Context Store.
                Please select the shop in the drop-down selector at the top of your screen'
                );
                return false;
            }
            IfthenpayInstallerFactory::build(
                'ifthenpayInstaller',
                $this->ifthenpayConfig['IFTHENPAY_USER_PAYMENT_METHODS'] ?
                $this->ifthenpayConfig['IFTHENPAY_USER_PAYMENT_METHODS'] : '',
                $this
            )->execute('uninstall');
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        if (Shop::isFeatureActive() && Shop::getContext() !== Shop::CONTEXT_SHOP) {
            return $this->displayError(
                $this->l(
                    'Module configuration is only available for Shop Context Store.
            Please select the shop in the drop-down selector at the top of your screen'
                )
            );
        } else {
            $formMessages = '';
            if ($this->context->cookie->__isset('success')) {
                $formMessages = $this->displayConfirmation($this->context->cookie->__get('success'));
                $this->context->cookie->__unset('success');
            }

            if ($this->context->cookie->__isset('error')) {
                $formMessages = $this->displayError($this->context->cookie->__get('error'));
                $this->context->cookie->__unset('error');
            }

            if ((bool)Tools::isSubmit('submitIfthenpayModule')) {
                $formMessages = $this->postProcess();
            }

            $needUpgrade = ConfigFactory::buildIfthenpayUpgrade($this)->checkModuleUpgrade();

            $this->context->smarty->assign('module_dir', $this->_path);
            $this->context->smarty->assign('isoCode', $this->context->language->iso_code);
            $this->context->smarty->assign('configForm', $this->renderForm());
            $this->context->smarty->assign('logTable', $this->renderTableList());
            $this->context->smarty->assign('isBackofficeKey', $this->ifthenpayConfig['IFTHENPAY_BACKOFFICE_KEY'] ? true : false);
            $this->context->smarty->assign('isIfthenpayPaymentMethodsSaved', Configuration::get('IFTHENPAY_PAYMENT_METHODS_SAVED') ? true : false);
            $this->context->smarty->assign('updateIfthenpayModuleAvailable', $needUpgrade['upgrade'] ? true : false);
            $this->context->smarty->assign('upgradeModuleBulletPoints', $needUpgrade['upgrade'] ? $needUpgrade['body'] : '');
            $this->context->smarty->assign('moduleUpgradeUrlDownload', $needUpgrade['upgrade'] ? $needUpgrade['download'] : '');
            $this->context->smarty->assign('spinnerUrl', Media::getMediaPath(
                    _PS_MODULE_DIR_ . 'ifthenpay/views/svg/oval.svg'
                )
            );
            $this->context->smarty->assign('updateSystemIcon', Media::getMediaPath(
                    _PS_MODULE_DIR_ . 'ifthenpay/views/svg/system-update.svg'
                )
            );
            $this->context->smarty->assign('updatedModuleIcon', Media::getMediaPath(
                    _PS_MODULE_DIR_ . 'ifthenpay/views/svg/updated.svg'
                )
            );

            return $formMessages . $this->context->smarty->fetch($this->local_path.'views/templates/admin/config.tpl');
        }
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = PrestashopFactory::buildHelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitIfthenpayModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }
    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        if (!$this->ifthenpayConfig['IFTHENPAY_BACKOFFICE_KEY']) {
            return [
                'form' => [
                    'input' => [
                        [
                            'type' => 'text',
                            'label' => $this->l('Backoffice key'),
                            'name' => 'IFTHENPAY_BACKOFFICE_KEY',
                            'size' => 19,
                            'required' => true
                        ]
                    ],
                    'submit' => [
                        'title' => $this->l('Save'),
                    ]
                ],
            ];
        } else {
            $form = [
                'form' => [
                    'input' => [
                        [
                            'type' => 'switch',
                            'label' => $this->l('Sandbox Mode'),
                            'name' => 'IFTHENPAY_ACTIVATE_SANDBOX_MODE',
                            'desc' => $this->l('Activate sandbox mode, to test the module without activating the callback.'),
                            'is_bool' => true,
                            'values' => [
                                [
                                    'id' => 'active_on',
                                    'value' => true,
                                    'label' => $this->l('Enabled'),
                                    'name' => ''
                                ],
                                [
                                    'id' => 'active_off',
                                    'value' => false,
                                    'label' => $this->l('Disabled'),
                                    'name' => ''
                                ]
                            ]   
                        ],
                    ],
                    'submit' => [
                        'title' => $this->l('Save'),
                    ],
                ],
            ];
            $ifthenpayUserPaymentMethods = (array) unserialize(
                $this->ifthenpayConfig['IFTHENPAY_USER_PAYMENT_METHODS']
            );
            foreach ($ifthenpayUserPaymentMethods as $paymentMethod) {
                $this->context->smarty->assign(
                    'isActive',
                    (bool) Configuration::get('IFTHENPAY_' . Tools::strtoupper($paymentMethod)) ? true : false
                );
                $this->context->smarty->assign(
                    'paymentMethodSetupLink',
                    $this->context->link->getAdminLink('AdminIfthenpayPaymentMethodSetup')
                    . "&paymentMethod=$paymentMethod"
                );
                $form['form']['input'][] = [
                    'type' => 'switch',
                    'label' => $this->l(Tools::ucfirst($paymentMethod)),
                    'name' => 'IFTHENPAY_' . Tools::strtoupper($paymentMethod),
                    'is_bool' => true,
                    'values' => [
                        [
                            'id' => 'active_on',
                            'value' => true,
                            'label' => $this->l('Enabled'),
                            'name' => ''
                        ],
                        [
                            'id' => 'active_off',
                            'value' => false,
                            'label' => $this->l('Disabled'),
                            'name' => ''
                        ]
                    ],
                ];
                $form['form']['input'][] = [
                    'type' => 'html',
                    'name' => '',
                    'html_content' => $this->context->smarty->fetch(
                        $this->local_path . 'views/templates/admin/_partials/buttonPaymentManage.tpl'
                    ),
                ];
            }
            foreach (GatewayFactory::build('gateway')->getPaymentMethodsType() as $paymentMethodType) {
                if ($paymentMethodType !== 'ifthenpay' && !in_array($paymentMethodType, $ifthenpayUserPaymentMethods)
                ) {
                        $this->context->smarty->assign('paymentMethod', $paymentMethodType);
                        $this->context->smarty->assign(
                            'ativateNewAccountLink',
                            $this->context->link->getAdminLink('AdminIfthenpayActivateNewAccount')
                            . "&paymentMethod=$paymentMethodType"
                        );
                    $form['form']['input'][] = [
                        'type' => 'html',
                        'name' => '',
                        'html_content' => $this->context->smarty->fetch(
                            $this->local_path . 'views/templates/admin/_partials/buttonAtivateNewAccount.tpl'
                        ),
                    ];
                }
            }
            return $form;
        }
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        $formValues = array(
            'IFTHENPAY_BACKOFFICE_KEY' => Configuration::get('IFTHENPAY_BACKOFFICE_KEY', false),
            'IFTHENPAY_ACTIVATE_SANDBOX_MODE' => Configuration::get('IFTHENPAY_ACTIVATE_SANDBOX_MODE', false)
        );

        if ($this->ifthenpayConfig['IFTHENPAY_USER_PAYMENT_METHODS']) {
            foreach ((array) unserialize($this->ifthenpayConfig['IFTHENPAY_USER_PAYMENT_METHODS']) as $paymentMethod) {
                $formValues['IFTHENPAY_' . Tools::strtoupper($paymentMethod)] = Configuration::get(
                    'IFTHENPAY_' .
                    Tools::strtoupper($paymentMethod)
                );
            }
        }
        return $formValues;
    }

    public function renderTableList()
    {
        $query = DatabaseFactory::buildDbQuery();
        $query->from('ifthenpay_log');
        $query->orderBy('created DESC LIMIT 300');
        $content = \Db::getInstance()->executeS($query);

        $fields_list = array(
            'id_ifthenpay_log' => array(
                'title' => 'ID',
                'align' => 'center',
            ),
            'type' => array(
                'title' => 'Type',
                'type' => 'text',
            ),
            'message' => array(
                'title' => 'Message',
                'type' => 'text',
            ),
            'order_id' => array(
                'title' => 'Order',
                'type' => 'text',
                'align' => 'center'
            ),
            'created' => array(
                'title' => 'Date',
                'type' => 'text',
                'align' => 'center'
            ),
        );

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = true;
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->listTotal = count($content);
        $helper->identifier = 'id_ifthenpay_log';
        $helper->table = 'ifthenpay_log';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        return $helper->generateList($content, $fields_list);
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        Configuration::updateValue(
            'IFTHENPAY_ACTIVATE_SANDBOX_MODE', Tools::getValue('IFTHENPAY_ACTIVATE_SANDBOX_MODE')
        );
        if (!$this->ifthenpayConfig['IFTHENPAY_BACKOFFICE_KEY']) {
            return $this->postProcessBackofficeKey();
        } else {
            return $this->postProcessActivatePaymentMethods();
        }        
    }

    private function postProcessBackofficeKey()
    {
        $backofficeKey = Tools::getValue('IFTHENPAY_BACKOFFICE_KEY');

        if (!$backofficeKey) {
            Utility::setPrestashopCookie('error', $this->l('Backoffice key is required!'));
        }

        try {
            $ifthenpayGateway = GatewayFactory::build('gateway');

            $ifthenpayGateway->authenticate($backofficeKey);

            Configuration::updateValue('IFTHENPAY_BACKOFFICE_KEY', $backofficeKey);
            Configuration::updateValue(
                'IFTHENPAY_USER_PAYMENT_METHODS',
                serialize(
                    $ifthenpayGateway->getPaymentMethods()
                )
            );
            Configuration::updateValue(
                'IFTHENPAY_USER_ACCOUNT',
                serialize(
                    $ifthenpayGateway->getAccount()
                )
            );
            ConfigFactory::buildIfthenpayControllersTabs($this)->dynamicInstall('AdminIfthenpayActivateNewAccount');
            Utility::setPrestashopCookie('success', $this->l('Backoffice key was saved with success!'));
            IfthenpayLogProcess::addLog('backoffice key saved with success.', IfthenpayLogProcess::INFO, 0);
            Utility::redirectIfthenpayConfigPage();
        } catch (\Throwable $th) {
            IfthenpayLogProcess::addLog(
                'Error saving backoffice key - ' . $th->getMessage(),
                IfthenpayLogProcess::ERROR,
                0
            );
            Utility::setPrestashopCookie('error', $this->l('Error saving Backoffice key!'));
            Utility::redirectIfthenpayConfigPage();
        }
    }

    private function postProcessActivatePaymentMethods()
    {
        $ifthenpayUserPaymentMethods = (array) unserialize($this->ifthenpayConfig['IFTHENPAY_USER_PAYMENT_METHODS']);

        try {
            IfthenpayInstallerFactory::build(
                'ifthenpayInstaller',
                $this->ifthenpayConfig['IFTHENPAY_USER_PAYMENT_METHODS'],
                $this
            )->execute('install');

            foreach ($ifthenpayUserPaymentMethods as $paymentMethod) {
                Configuration::updateValue(
                    'IFTHENPAY_' . Tools::strtoupper($paymentMethod),
                    Tools::getValue('IFTHENPAY_' . Tools::strtoupper($paymentMethod))
                );
            }
            Configuration::updateValue('IFTHENPAY_PAYMENT_METHODS_SAVED', true);
            IfthenpayLogProcess::addLog('Payment methods saved with success.', IfthenpayLogProcess::INFO, 0);
            Utility::setPrestashopCookie('success', $this->l('Payment methods saved with success!'));
            Utility::redirectIfthenpayConfigPage();
        } catch (\Throwable $th) {
            IfthenpayLogProcess::addLog(
                'Error saving payment methods - ' .
                $th->getMessage(),
                IfthenpayLogProcess::ERROR,
                0
            );
            Utility::setPrestashopCookie('error', $this->l('Error saving Payment methods!'));
            Utility::redirectIfthenpayConfigPage();
        }
    }

    private function checkCurrency($cart)
    {
        $currency_order = PrestashopModelFactory::buildCurrency($cart->id_currency);
        $currencies_module = $this->getCurrency($cart->id_currency);
        if (is_array($currencies_module)) {
            foreach ($currencies_module as $currency_module) {
                if ($currency_order->id == $currency_module['id_currency']) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Return payment options available for PS 1.7+
     *
     * @param array Hook parameters
     *
     * @return array|null
     */
    public function hookPaymentOptions($params)
    {
        if (!$this->active) {
            return;
        }
        if (!$this->checkCurrency($params['cart'])) {
            return;
        }
        $payments_options = [];
        $ifthenpayGateway = GatewayFactory::build('gateway');
        foreach ((array) unserialize($this->ifthenpayConfig['IFTHENPAY_USER_PAYMENT_METHODS']) as $paymentMethod) {
            if (PrestashopModelFactory::buildCurrency($params['cart']->id_currency)->iso_code === 'EUR' || $paymentMethod === 'ccard') {
                if (Configuration::get('IFTHENPAY_' . Tools::strtoupper($paymentMethod))) {
                    $option = PrestashopFactory::buildPaymentOption();
                    if ($paymentMethod === 'mbway') {
                        $this->context->smarty->assign('mbwaySvg', Media::getMediaPath(
                                _PS_MODULE_DIR_ . $this->name . '/views/svg/mbway.svg' 
                            )
                        );
                        $this->context->smarty->assign(
                            [
                            'action' => $this->context->link->getModuleLink(
                                $this->name,
                                'validation',
                                [
                                'paymentOption' => $paymentMethod,
                                ],
                                true
                            ),
                            ]
                        );
                        $option->setForm(
                            $this->context->smarty->fetch(
                                $this->local_path .
                                'views/templates/front/mbwayPhone.tpl'
                            )
                        );
                    }
                    $option->setCallToActionText($this->l('Pay by ') . $ifthenpayGateway->getAliasPaymentMethods(
                        $paymentMethod, $this->context->language->iso_code)
                    )
                        ->setLogo(Media::getMediaPath(
                            _PS_MODULE_DIR_ . $this->name . '/views/img/' . $paymentMethod . '_option.png'
                        ))
                        ->setAction(
                            $this->context->link->getModuleLink(
                                $this->name,
                                'validation',
                                [
                                'paymentOption' => $paymentMethod,
                                ],
                                true
                            )
                        )
                        ->setModuleName($this->name);
                    $payments_options[] = $option;
                }
            }
            
        }
        return $payments_options;
    }

    public function hookPaymentReturn($params)
    {
        if (!$this->active) {
            return;
        }

        $states = [
            Configuration::get('IFTHENPAY_' . Tools::strtoupper($params['order']->payment) . '_OS_WAITING'),
            Configuration::get('IFTHENPAY_' . Tools::strtoupper($params['order']->payment) . '_OS_CONFIRMED'),
            Configuration::get('PS_OS_OUTOFSTOCK'),
            Configuration::get('PS_OS_OUTOFSTOCK_UNPAID'),
            Configuration::get('PS_OS_OUTOFSTOCK_PAID'),
            Configuration::get('PS_OS_ERROR')
        ];

        if (GatewayFactory::build('gateway')->checkIfthenpayPaymentMethod($params['order']->payment)
            && in_array($params['order']->getCurrentState(), $states)
        ) {
            try {
                if ($params['order']->getCurrentState() === Configuration::get('PS_OS_ERROR')) {
                    throw new Exception('Error processing payment');
                }
                $paymentData = IfthenpayModelFactory::build($params['order']->payment)
                    ->getByOrderId((string) $params['order']->id);
                if (empty($paymentData)) {
                    $ifthenpayPaymentReturn = IfthenpayStrategyFactory::build(
                        'ifthenpayPaymentReturn',
                        $params['order'],
                        $this
                    )->execute();
                    IfthenpayLogProcess::addLog(
                        'Payment processed with success (paymentReturn).',
                        IfthenpayLogProcess::INFO,
                        $params['order']->id
                    );
                    $this->smarty->assign($ifthenpayPaymentReturn->getSmartyVariables()->setStatus('ok')->toArray());
                } else {
                    $ifthenpayOrderDetail = IfthenpayStrategyFactory::build(
                        'ifthenpayOrderDetail',
                        $params['order'],
                        $this
                    )->execute();
                    IfthenpayLogProcess::addLog(
                        'Order detail successfully withdrawn (displayOrderDetail).',
                        IfthenpayLogProcess::INFO,
                        $params['order']->id
                    );
                    $this->smarty->assign(
                        $ifthenpayOrderDetail->getSmartyVariables()
                            ->setStatus('ok')
                            ->setShopName($this->context->shop->name)
                            ->setOrderId((string) $params['order']->id)
                            //->setResendMbwayNotificationControllerUrl('')
                            ->toArray()
                    );
                }
            } catch (\Throwable $th) {
                IfthenpayLogProcess::addLog(
                    'Error processing payment (paymentReturn) - ' . $th->getMessage(),
                    IfthenpayLogProcess::ERROR,
                    $params['order']->id
                );
                $new_history = PrestashopModelFactory::buildOrderHistory();
                $new_history->id_order = (int) $params['order']->id;
                $new_history->changeIdOrderState((int) Configuration::get('PS_OS_ERROR'), (int) $params['order']->id);
                $new_history->addWithemail(true);
                $this->smarty->assign('status', 'failed');
                $this->smarty->assign('orderErrorImg',
                    \Media::getMediaPath(
                        _PS_MODULE_DIR_ . 'ifthenpay/views/svg/error.svg'
                    )
                );
                return $this->display(__FILE__, 'payment_return.tpl');
            }
            //return $this->fetch('module:ifthenpay/views/templates/hook/payment_return.tpl');
            return $this->display(__FILE__, 'payment_return.tpl');
        }
    }

    public function hookdisplayAdminOrder($params)
    {
        if (!$this->active) {
            return;
        }

        $order = PrestashopModelFactory::buildOrder((string) $params['id_order']);
        $message = '';
        $ifthenpayGateway = GatewayFactory::build('gateway');

        $previousModulePaymentMethod = $ifthenpayGateway->checkIfPaymentMethodIsPreviousModule($order->payment);

        if ($previousModulePaymentMethod) {
            $order->payment = $previousModulePaymentMethod;
            $order->save();
        }

        if ($ifthenpayGateway->checkIfthenpayPaymentMethod($order->payment)
            || $order->payment === Tools::ucfirst($this->name)
        ) {
            if (Shop::isFeatureActive() && Shop::getContext() !== Shop::CONTEXT_SHOP) {
                return $this->displayError(
                    $this->l(
                        'Payment Order Detail is only available for Shop Context Store.
                    Please select the shop in the drop-down selector at the top of your screen'
                    )
                );
            }

            if ($this->context->cookie->__isset('success')) {
                $message = $this->displayConfirmation($this->context->cookie->__get('success'));
                $this->context->cookie->__unset('success');
            }

            if ($this->context->cookie->__isset('error')) {
                $message = $this->displayError($this->context->cookie->__get('error'));
                $this->context->cookie->__unset('error');
            }

            try {
                $ifthenpayAdminOrder = IfthenpayStrategyFactory::build(
                    'ifthenpayAdminOrder',
                    $order,
                    $this,
                    $message
                )->execute();
                IfthenpayLogProcess::addLog(
                    'Payment order successfully withdrawn (displayAdminOrder).',
                    IfthenpayLogProcess::INFO,
                    $params['id_order']
                );
            } catch (\Throwable $th) {
                    IfthenpayLogProcess::addLog(
                        'Error withdrawing payment order (displayAdminOrder) - ' . $th->getMessage(),
                        IfthenpayLogProcess::ERROR,
                        $params['id_order']
                    );
                    throw $th;
            }
                $this->smarty->assign($ifthenpayAdminOrder->getSmartyVariables()->toArray());
                //return $this->fetch('module:ifthenpay/views/templates/hook/admin.tpl');
                return $this->display(__FILE__, 'admin.tpl');
        }
    }


    /**
     * Add the CSS & JavaScript files you want to be loaded in the BO.
     */
    public function hookActionAdminControllerSetMedia()
    {
        if (Tools::getValue('controller') === 'AdminModules' && Tools::getValue('configure') === $this->name) {
            $this->context->controller->addJS($this->_path . 'views/js/adminAccountSettingsPage.js');
            $this->context->controller->addCSS($this->_path . 'views/css/ifthenpayConfig.css');
            Media::addJsDef(
                [
                    'controllerUrl' => $this->context->link->getAdminLink('AdminIfthenpayResetAccount')
                ]
            );
        } elseif (Tools::getValue('controller') === 'AdminOrders' &&
        $this->ifthenpayConfig['IFTHENPAY_USER_PAYMENT_METHODS']) {
            $this->context->controller->addJS($this->_path . 'views/js/adminOrderCreatePage.js');
            $this->context->controller->addJS($this->_path . 'views/js/adminOrderDetailPage.js');
            $this->context->controller->addCSS($this->_path . 'views/css/ifthenpayAdminOrder.css');
            Media::addJsDef(
                [
                    'ifthenpayUserPaymentMethods' => (array) unserialize($this->ifthenpayConfig['IFTHENPAY_USER_PAYMENT_METHODS']),
                    'mbwaySvg' => $this->_path . 'views/svg/mbway.svg'
                ]
            );
        }
    }

    public function hookDisplayOrderDetail($params)
    {
        if (!$this->active) {
            return;
        }
        try {
            $order = PrestashopModelFactory::buildOrder((string) $params['order']->id);

            if (GatewayFactory::build('gateway')->checkIfthenpayPaymentMethod($order->payment)) {
                $ifthenpayOrderDetail = IfthenpayStrategyFactory::build(
                    'ifthenpayOrderDetail',
                    $order,
                    $this
                )->execute();
                IfthenpayLogProcess::addLog(
                    'Order detail successfully withdrawn (displayOrderDetail).',
                    IfthenpayLogProcess::INFO,
                    $params['order']->id
                );
                $this->smarty->assign($ifthenpayOrderDetail->getSmartyVariables()->toArray());
            }
        } catch (\Throwable $th) {
            IfthenpayLogProcess::addLog(
                'Error withdrawing order detail (displayOrderDetail) - ' . $th->getMessage(),
                IfthenpayLogProcess::ERROR,
                $params['order']->id
            );
            throw $th;
        }
        //return $this->fetch('module:ifthenpay/views/templates/hook/history.tpl');
        return $this->display(__FILE__, 'history.tpl');
    }

    private function executeCssScripts($type)
    {
        if ($type === 'orderConfirmation') {
            Media::addJsDef(
                [
                    'cancelMbwayOrderControllerUrl' => $this->context->link->getModuleLink('ifthenpay', 'cancelMbwayOrder', []),
                    
                ]
            );
            $this->context->controller->registerJavascript(
                'module-ifthenpay-mbwayCountdown',
                'modules/'. $this->name . '/views/js/mbwayCountdownConfirmPage.js'
            );
            $this->context->controller->registerStylesheet(
                'module-ifthenpay-confirmPage',
                'modules/'. $this->name . '/views/css/ifthenpayConfirmPage.css'
            );
        }
        if ($type === 'orderdetail') {
            $this->context->controller->registerStylesheet(
                'module-ifthenpay-orderDetail',
                'modules/'. $this->name . '/views/css/ifthenpayOrderDetail.css'
            );
        }
        if ($type === 'order') {
            $this->context->controller->registerStylesheet(
                'module-ifthenpay-orderPaymentOption',
                'modules/'. $this->name . '/views/css/paymentOptions.css'
            );
        }
    }

    public function hookActionFrontControllerSetMedia($params)
    {
        if ($this->context->controller->php_self) {
            if ($this->context->controller->php_self === 'order-confirmation') {
                $this->executeCssScripts('orderConfirmation');
            }
    
            if ($this->context->controller->php_self === 'orderdetail' || $this->context->controller->php_self === 'order-detail') {
                $this->executeCssScripts('orderDetail');
            }
    
            if ($this->context->controller->php_self === 'order') {
                $this->executeCssScripts('order');
            }
        } else {
            $this->executeCssScripts('orderConfirmation');
            $this->executeCssScripts('orderDetail');
            $this->executeCssScripts('order');
        }
    }

    public function hookDisplayBackOfficeHeader($params)
    {
        if(($this->context->controller->php_self === 'AdminOrders' || Tools::getValue('controller') === 'AdminOrders') && strpos($_SERVER['REQUEST_URI'], 'view') === false) {
            ConfigFactory::buildCancelMbwayOrder()->cancelOrder();
        }
    }
}
