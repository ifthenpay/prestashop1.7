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
 * @copyright 2007-2020 Ifthenpay Lda
 * @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */


if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Utility\Utility;
use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;
use PrestaShop\Module\Ifthenpay\Factory\Payment\GatewayFactory;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopFactory;
use PrestaShop\Module\Ifthenpay\Factory\Config\IfthenpayConfigFormsFactory;

class AdminIfthenpayPaymentMethodSetupController extends ModuleAdminController
{
    private $paymentMethod;
    private $ifthenpayGateway;


    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->ifthenpayGateway = GatewayFactory::build('gateway');
    }


    public function initPageHeaderToolbar()
    {
        $this->page_header_toolbar_btn['return'] = array(
            'href' => $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->module->name,
            'desc' => $this->l('Back'),
            'icon' => 'process-icon-back'
        );
        parent::initPageHeaderToolbar();
    }


    public function initContent()
    {
        Utility::checkPaymentMethodDefined();

        parent::initContent();

        if ($this->context->cookie->__isset('success')) {
            $this->displayInformation($this->context->cookie->__get('success'));
            $this->context->cookie->__unset('success');
        }

        if ($this->context->cookie->__isset('error')) {
            $this->displayWarning($this->context->cookie->__get('error'));
            $this->context->cookie->__unset('error');
        }
        $this->paymentMethod = $_GET['paymentMethod'];

        $this->context->smarty->assign('paymentMethod', $this->paymentMethod);
        $this->context->smarty->assign('module_dir', _MODULE_DIR_ . $this->module->name);

        if (!Configuration::get('IFTHENPAY_BACKOFFICE_KEY')) {
            Utility::redirectIfthenpayConfigPage();
        }
        if (!Configuration::get('IFTHENPAY_' . \Tools::strtoupper($this->paymentMethod) . '_URL_CALLBACK')
            && !Configuration::get('IFTHENPAY_' . \Tools::strtoupper($this->paymentMethod) . '_CHAVE_ANTI_PHISHING')
        ) {
                $this->context->smarty->assign('form', $this->displayForm());
        } else {
            IfthenpayConfigFormsFactory::build('ifthenpayConfigForms', $this->paymentMethod, [], $this->module)->setSmartyVariables();
        }

        $this->context->smarty->assign('content', $this->context->smarty->fetch($this->getTemplatePath() . '/paymentMethodSetup.tpl'));
    }

    public function displayForm()
    {
        $helper = PrestashopFactory::buildHelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this->module;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitIfthenpay' . Tools::ucfirst($this->paymentMethod) . 'Config';
        $helper->currentIndex = AdminController::$currentIndex;
        $helper->token = Tools::getAdminTokenLite($this->controller_name);

        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }
    private function getConfigForm()
    {
        $this->context->smarty->assign('spinnerUrl', _MODULE_DIR_ . $this->module->name . '/views/svg/oval.svg');
        $form = [
            'form' => [
                'legend' => [
                    'title' => Tools::ucfirst($this->paymentMethod) . ' ' . $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                        [
                            'type' => 'hidden',
                            'name' => 'IFTHENPAY_PAYMENT_METHOD',
                        ],
                        [
                            'type' => 'html',
                            'html_content' => $this->context->smarty->fetch($this->module->getLocalPath() . 'views/templates/admin/_partials/spinner.tpl'),
                        ]
                    ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
            ],
        ];

        return IfthenpayConfigFormsFactory::build('ifthenpayConfigForms', $this->paymentMethod, $form, $this->module)->buildForm();
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return [
            'IFTHENPAY_PAYMENT_METHOD' => $this->paymentMethod,
        ];
    }

    public function postProcess()
    {
        parent::postProcess();
        $this->paymentMethod = Tools::getValue('IFTHENPAY_PAYMENT_METHOD');

        if ($this->paymentMethod && Tools::isSubmit('submitIfthenpay' . Tools::ucfirst($this->paymentMethod) . 'Config')) {
            try {
                IfthenpayConfigFormsFactory::build('ifthenpayConfigForms', $this->paymentMethod, [], $this->module)->processForm();
                IfthenpayLogProcess::addLog(Tools::ucfirst($this->paymentMethod) . ' Form Data saved with success.', IfthenpayLogProcess::INFO, 0);
            } catch (\Throwable $th) {
                IfthenpayLogProcess::addLog('Error saving ' . Tools::ucfirst($this->paymentMethod) . ' Form Data - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, 0);
                Utility::setPrestashopCookie('error', $this->module->l('Error saving ') . Tools::ucfirst($this->paymentMethod) .  $this->module->l(' data.'));
            }
            Tools::redirectAdmin(
                $this->context->link->getAdminLink(
                    'AdminIfthenpayPaymentMethodSetup',
                    true,
                    [],
                    [
                    'paymentMethod' => $this->paymentMethod
                        ]
                )
            );
        }
    }

    public function setMedia($isNewTheme = false)
    {
        $ifthenpayUserPaymentMethods = Configuration::get('IFTHENPAY_USER_PAYMENT_METHODS');
        if ($ifthenpayUserPaymentMethods) {
            parent::setMedia($isNewTheme);
            $this->addJS($this->module->getLocalPath() . '/views/js/ifthenpayPaymentMethodSetup.js');
            $this->addCSS($this->module->getLocalPath() . 'views/css/ifthenpayPaymentMethodSetup.css');
            Media::addJsDef(array('ifthenpayUserPaymentMethods' => (array) unserialize($ifthenpayUserPaymentMethods)));
        }
    }

    public function ajaxProcessGetSubEntidade()
    {
        try {
            $this->ifthenpayGateway->setAccount((array) unserialize(Configuration::get('IFTHENPAY_USER_ACCOUNT')));
            $subEntidades = json_encode($this->ifthenpayGateway->getSubEntidadeInEntidade(Tools::getValue('entidade')));
            IfthenpayLogProcess::addLog('SubEntidades withdrawn with success', IfthenpayLogProcess::INFO, 0);
            die($subEntidades);
        } catch (\Throwable $th) {
            IfthenpayLogProcess::addLog('Error withdrawn subEntidades - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, 0);
            die($th->getMessage());
        }
    }

    public function ajaxProcessChooseNewEntidade()
    {
        $this->paymentMethod = Tools::getValue('paymentMethod');
        try {
            IfthenpayConfigFormsFactory::build('ifthenpayConfigForms', $this->paymentMethod, [], $this->module)->deleteConfigFormValues();
            IfthenpayLogProcess::addLog('Choose new Entidade executed with success', IfthenpayLogProcess::INFO, 0);
            die(
                json_encode(
                    $this->context->link->getAdminLink(
                        'AdminIfthenpayPaymentMethodSetup',
                        true,
                        [],
                        [
                        'paymentMethod' => $this->paymentMethod
                        ]
                    )
                )
            );
        } catch (\Throwable $th) {
            IfthenpayLogProcess::addLog('Error choosing new entidade - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, 0);
            die(
                json_encode($th->getMessage())
            );
        }
    }
}
