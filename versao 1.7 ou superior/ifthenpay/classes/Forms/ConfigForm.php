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

namespace PrestaShop\Module\Ifthenpay\Forms;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Utility\Utility;
use PrestaShop\Module\Ifthenpay\Factory\Builder\BuilderFactory;
use PrestaShop\Module\Ifthenpay\Factory\Payment\GatewayFactory;
use PrestaShop\Module\Ifthenpay\Factory\Callback\CallbackFactory;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopFactory;

abstract class ConfigForm
{
    protected $paymentMethod;
    protected $form;
    protected $ifthenpayModule;
    protected $ifthenpayController;
    protected $gatewayDataBuilder;
    private $ifthenpayGateway;
    protected $options;
    protected $formFactory;

    public function __construct($ifthenpayModule, $ifthenpayController = null)
    {
        $this->ifthenpayModule = $ifthenpayModule;
        $this->ifthenpayController = $ifthenpayController;
        $this->gatewayDataBuilder = BuilderFactory::build('gateway');
        $this->ifthenpayGateway = GatewayFactory::build('gateway');
        $this->ifthenpayGateway->setAccount((array) unserialize(\Configuration::get('IFTHENPAY_USER_ACCOUNT')));
        $this->options = [];
    }

    protected function checkIfCallbackIsSet()
    {
        if (!\Configuration::get('IFTHENPAY_' . \Tools::strtoupper($this->paymentMethod) . '_URL_CALLBACK')
            && !\Configuration::get('IFTHENPAY_' . \Tools::strtoupper($this->paymentMethod) . '_CHAVE_ANTI_PHISHING')
        ) {
            return false;
        }
        return true;
    }

    protected function generateHelperForm()
    {
        $helper = PrestashopFactory::buildHelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->ifthenpayController->table;
        $helper->module = $this->ifthenpayModule;
        $helper->identifier = 'id_module';
        $helper->submit_action = 'submitIfthenpay' . \Tools::ucfirst($this->paymentMethod) . 'Config';
        $helper->currentIndex = \AdminController::$currentIndex;
        $helper->token = \Tools::getAdminTokenLite($this->ifthenpayController->controller_name);

        $helper->default_form_language = \Context::getContext()->language->id;
        $helper->allow_employee_form_lang = \Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => \Context::getContext()->controller->getLanguages(),
            'id_language' => \Context::getContext()->language->id,
        );
        \Context::getContext()->smarty->assign('form', $helper->generateForm(array($this->form)));
    }
   

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return [
            'IFTHENPAY_PAYMENT_METHOD' => $this->paymentMethod,
            'IFTHENPAY_CALLBACK_ACTIVATE_FOR_' . strtoupper($this->paymentMethod) => \Configuration::get('IFTHENPAY_CALLBACK_ACTIVATE_FOR_' . strtoupper($this->paymentMethod), false),
        ];
    }

    protected function setFormParent()
    {
       \Context::getContext()->smarty->assign('spinnerUrl', _MODULE_DIR_ . $this->ifthenpayModule->name . '/views/svg/oval.svg');
        $this->form = [
            'form' => [
                'legend' => [
                    'title' => \Tools::ucfirst($this->paymentMethod) . ' ' . $this->ifthenpayModule->l('Settings', Utility::getClassName($this)),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                        [
                            'type' => 'hidden',
                            'name' => 'IFTHENPAY_PAYMENT_METHOD',
                        ],
                        [
                            'type' => 'html',
                            'name' => 'name',
                            'html_content' => \Context::getContext()->smarty->fetch($this->ifthenpayModule->getLocalPath() . 'views/templates/admin/_partials/spinner.tpl'),
                        ]
                ],
                'submit' => [
                    'title' => $this->ifthenpayModule->l('Save', Utility::getClassName($this)),
                ],
            ],
        ];
    }

    protected function addActivateCallbackToForm()
    {               
        $this->form['form']['input'][] = [
            'type' => 'switch',
            'label' => $this->ifthenpayModule->l('Callback', Utility::getClassName($this)),
            'name' => 'IFTHENPAY_CALLBACK_ACTIVATE_FOR_' . strtoupper($this->paymentMethod),
            'desc' => $this->ifthenpayModule->l('Activate callback automatically. If sandbox mode is enabled, callback will not activate.', Utility::getClassName($this)),
            'is_bool' => true,
            'values' => [
                [
                    'id' => 'active_on',
                    'value' => true,
                    'label' => $this->ifthenpayModule->l('Activate', Utility::getClassName($this))
                ],
                [
                    'id' => 'active_off',
                    'value' => false,
                    'label' => $this->ifthenpayModule->l('Disabled', Utility::getClassName($this))
                ]
            ]   
        ];
        return $this->form;
    }

    protected function addToOptions()
    {
        foreach ($this->ifthenpayGateway->getEntidadeSubEntidade($this->paymentMethod) as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    if (strlen($value2) > 3) {
                        $this->options[] = [
                            'id' => $value2,
                            'name' => $value2
                        ];
                    }
                }
            } else {
                $this->options[] = [
                    'id' => $value,
                    'name' => $value
                ];
            }
        }
    }

    protected function setGatewayBuilderData()
    {
        $this->gatewayDataBuilder->setBackofficeKey(\Configuration::get('IFTHENPAY_BACKOFFICE_KEY'));
    }

    protected function getCallbackControllerUrl()
    {
        return \Context::getContext()->link->getModuleLink('ifthenpay', 'callback', array(), true);
    }

    protected function getIfthenpayCallback()
    {
        return CallbackFactory::buildCallback($this->gatewayDataBuilder);
    }

    /**
    * Delete default config values
    * @return void
    */
    protected function deleteDefaultConfigValues()
    {
        \Configuration::deleteByName('IFTHENPAY_CALLBACK_ACTIVATE_FOR_' . strtoupper($this->paymentMethod));
        \Configuration::deleteByName('IFTHENPAY_CALLBACK_ACTIVATED_FOR_' . strtoupper($this->paymentMethod));
    }

    protected function setIfthenpayCallback()
    {
        \Context::getContext()->smarty->assign('displayCallbackTableInfo', true);
        \Context::getContext()->smarty->assign('isCallbackActivated', 
            \Configuration::get('IFTHENPAY_CALLBACK_ACTIVATED_FOR_' . strtoupper($this->paymentMethod)) ? true : false
        );
        $activateCallback = !\Configuration::get('IFTHENPAY_ACTIVATE_SANDBOX_MODE', false) && 
        \Configuration::get('IFTHENPAY_CALLBACK_ACTIVATE_FOR_' . strtoupper($this->paymentMethod)) && 
        !\Configuration::get('IFTHENPAY_CALLBACK_ACTIVATED_FOR_' . strtoupper($this->paymentMethod)) ? true : false;
        $ifthenpayCallback = $this->getIfthenpayCallback();
        $ifthenpayCallback->make($this->paymentMethod, $this->getCallbackControllerUrl(), $activateCallback);

        if (!\Configuration::get('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_URL_CALLBACK', false) &&
        !\Configuration::get('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_CHAVE_ANTI_PHISHING', false)) {

            \Configuration::updateValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_URL_CALLBACK', $ifthenpayCallback->getUrlCallback());
            \Configuration::updateValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_CHAVE_ANTI_PHISHING', $ifthenpayCallback->getChaveAntiPhishing());
        }
    }

    public function setSmartyVariables()
    {
        \Context::getContext()->smarty->assign('form', '');
        \Context::getContext()->smarty->assign('spinnerUrl', _MODULE_DIR_ . $this->ifthenpayModule->name . '/views/svg/oval.svg');
    }

    abstract protected function setOptions();
    abstract public function getForm();
    abstract public function processForm();
    abstract public function deleteConfigValues();
}
