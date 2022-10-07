<?php

/**
 * 2007-2022 Ifthenpay Lda
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
 * @copyright 2007-2022 Ifthenpay Lda
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
    }




    protected function checkIfCallbackIsSet()
    {
        if (
            !\Configuration::get('IFTHENPAY_' . \Tools::strtoupper($this->paymentMethod) . '_URL_CALLBACK')
            && !\Configuration::get('IFTHENPAY_' . \Tools::strtoupper($this->paymentMethod) . '_CHAVE_ANTI_PHISHING')
        ) {
            return false;
        }
        return true;
    }



    /**
     * generates the form and assigns it as a smarty variable
     *
     * @return void
     */
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
     *
     * @return array
     */
    protected function getCommonConfigFormValues()
    {
        // this first line gets the current state of the callback (...activated_for_)
        return [
            'IFTHENPAY_CALLBACK_ACTIVATE_FOR_' . strtoupper($this->paymentMethod) => \Configuration::get('IFTHENPAY_CALLBACK_ACTIVATED_FOR_' . strtoupper($this->paymentMethod), false),
            'IFTHENPAY_PAYMENT_METHOD' => $this->paymentMethod,
            'IFTHENPAY_' . strtoupper($this->paymentMethod) . '_MAXIMUM' => \Configuration::get('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_MAXIMUM', false),
            'IFTHENPAY_' . strtoupper($this->paymentMethod) . '_MINIMUM' => \Configuration::get('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_MINIMUM', false),
            'IFTHENPAY_' . strtoupper($this->paymentMethod) . '_COUNTRIES[]' => json_decode(\Configuration::get('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_COUNTRIES', false)),
            'IFTHENPAY_' . strtoupper($this->paymentMethod) . '_ORDER' => \Configuration::get('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_ORDER', false)
        ];
    }



    /**
     * sets the main part of the form,
     * this will let the dev add more fields by using $this->form[] = <some form field>
     *
     * @return void
     */
    protected function setFormParent()
    {
        $this->form = [
            'form' => [
                'legend' => [
                    'title' => \Tools::ucfirst($this->paymentMethod) . ' ' . $this->ifthenpayModule->l('Settings', pathinfo(__FILE__)['filename']),
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
                    'title' => $this->ifthenpayModule->l('Save', pathinfo(__FILE__)['filename']),
                ],
            ],
        ];
    }



    /**
     * adds activate callback switch to form
     *
     * @return void
     */
    protected function addActivateCallbackToForm()
    {
        $this->form['form']['input'][] = [
            'type' => 'switch',
            'label' => $this->ifthenpayModule->l('Callback', pathinfo(__FILE__)['filename']),
            'name' => 'IFTHENPAY_CALLBACK_ACTIVATE_FOR_' . strtoupper($this->paymentMethod),
            'desc' => $this->ifthenpayModule->l('Activate callback automatically. If sandbox mode is enabled, callback will not activate.', pathinfo(__FILE__)['filename']),
            'is_bool' => true,
            'values' => [
                [
                    'id' => 'active_on',
                    'value' => true,
                    'label' => $this->ifthenpayModule->l('Activate', pathinfo(__FILE__)['filename'])
                ],
                [
                    'id' => 'active_off',
                    'value' => false,
                    'label' => $this->ifthenpayModule->l('Disabled', pathinfo(__FILE__)['filename'])
                ]
            ]
        ];
    }



    /**
     * adds max and min order value fields to form
     *
     * @return void
     */
    protected function addMinMaxFieldsToForm()
    {
        $this->form['form']['input'][] = [
            'type' => 'text',
            'label' => $this->ifthenpayModule->l('Minimum Order Value', pathinfo(__FILE__)['filename']),
            'name' => 'IFTHENPAY_' . strtoupper($this->paymentMethod) . '_MINIMUM',
            'desc' => $this->ifthenpayModule->l('Only display this payment method for orders with total value greater than inserted value.', pathinfo(__FILE__)['filename'])
        ];
        $this->form['form']['input'][] = [
            'type' => 'text',
            'label' => $this->ifthenpayModule->l('Maximum Order Value', pathinfo(__FILE__)['filename']),
            'name' => 'IFTHENPAY_' . strtoupper($this->paymentMethod) . '_MAXIMUM',
            'desc' => $this->ifthenpayModule->l('Only display this payment method for orders with total value less than inserted value.', pathinfo(__FILE__)['filename'])
        ];
    }


    protected function addOrderByNumberFieldsToForm()
    {
        $this->form['form']['input'][] = [
            'type' => 'text',
            'label' => $this->ifthenpayModule->l('Order', pathinfo(__FILE__)['filename']),
            'name' => 'IFTHENPAY_' . strtoupper($this->paymentMethod) . '_ORDER',
            'desc' => $this->ifthenpayModule->l('Order payment methods at checkout page. Order is ascending for example, (Multibanco: 1, MB WAY: 4, CCARD: 2) will result in  (Multibanco, CCARD, MB WAY). This option only affects this module\'s payment methods', pathinfo(__FILE__)['filename'])
        ];
    }



    /**
     * adds countries field to form
     *
     * @return void
     */
    protected function addCountriesFieldToForm()
    {
        $countriesArr = $this->getCountriesArray();

        $this->form['form']['input'][] = [
            'type' => 'select',
            'label' => $this->ifthenpayModule->l('Country restrictions', pathinfo(__FILE__)['filename']),
            'id' => 'ifthenpay' . ucfirst($this->paymentMethod) . 'Countries',
            'name' => 'IFTHENPAY_' . strtoupper($this->paymentMethod) . '_COUNTRIES[]',
            'desc' => $this->ifthenpayModule->l('Only display this payment method for orders with shipping country within the selected ones. Leave empty to allow all countries. Use CTRL keyboard key and mouse click to toggle selection.', pathinfo(__FILE__)['filename']),
            'multiple' => true,
            'options' => [
                'query' => $countriesArr,
                'id' => 'id',
                'name' => 'name'
            ]
        ];
    }

    /**
     * gets assoc array of countries in prestashop ...
     * in format ['name' => Portugal, 'id' => 7]
     *
     * @return array
     */
    protected function getCountriesArray()
    {
        $result = [];
        $langId = \Context::getContext()->cookie->id_lang;
        if (isset($langId) && $langId != '') {

            $query = 'SELECT `name`, `id_country` as id FROM ' . _DB_PREFIX_ . 'country_lang WHERE id_lang = ' . $langId . ' ORDER BY name ASC';
            $result = \Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);
        }
        return $result;
    }



    /**
     * adds the array of entities to the object in use
     * assigns to $this->options[]
     *
     * @return void
     */
    protected function setEntityOptions()
    {
        // prestashop does not support placeholder in selects so I have to make do with a blank option
        $this->options[] = [
            'id' => '',
            'name' => ''
        ];

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



    /**
     * adds the array of sub_entities to the object in use
     * assigns to $this->subEntityOptions[]
     *
     * @return void
     */
    protected function setSubEntityOptions()
    {
        $entity = \Configuration::get('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_ENTIDADE');
        $entityAndSubEntityArr = $this->ifthenpayGateway->getSubEntidadeInEntidade($entity);

        $firstElement = reset($entityAndSubEntityArr);

        if (isset($firstElement['SubEntidade'])) {

            foreach ($firstElement['SubEntidade'] as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $key2 => $value2) {
                        if (strlen($value2) > 3) {
                            $this->subEntityOptions[] = [
                                'id' => $value2,
                                'name' => $value2
                            ];
                        }
                    }
                } else {
                    $this->subEntityOptions[] = [
                        'id' => $value,
                        'name' => $value
                    ];
                }
            }
        }
    }



    /**
     * sets backoffice key and common values
     *
     * @return void
     */
    protected function setGatewayBuilderData()
    {
        $this->gatewayDataBuilder->setBackofficeKey(\Configuration::get('IFTHENPAY_BACKOFFICE_KEY'));

        $this->gatewayDataBuilder->setMin(\Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_MINIMUM'));
        $this->gatewayDataBuilder->setMax(\Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_MAXIMUM'));
        $this->gatewayDataBuilder->setCountries(\Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_COUNTRIES'));
        $this->gatewayDataBuilder->setOrder(\Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_ORDER'));
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
    protected function deleteCommonConfigValues()
    {
        \Configuration::deleteByName('IFTHENPAY_CALLBACK_ACTIVATED_FOR_' . strtoupper($this->paymentMethod));
        \Configuration::deleteByName('IFTHENPAY_' . strtoupper($this->paymentMethod . '_MINIMUM'));
        \Configuration::deleteByName('IFTHENPAY_' . strtoupper($this->paymentMethod . '_MAXIMUM'));
        \Configuration::deleteByName('IFTHENPAY_' . strtoupper($this->paymentMethod . '_COUNTRIES'));
        \Configuration::deleteByName('IFTHENPAY_' . strtoupper($this->paymentMethod . '_ORDER'));
        \Configuration::deleteByName('IFTHENPAY_' . strtoupper($this->paymentMethod));
    }



    /**
     * generates the antiphishing key and callback url, and activates the calback if conditions are met
     *
     * @return void
     */
    protected function setIfthenpayCallback()
    {
        $activateCallback = !\Configuration::get('IFTHENPAY_ACTIVATE_SANDBOX_MODE', false) &&
            \Tools::getValue('IFTHENPAY_CALLBACK_ACTIVATE_FOR_' . strtoupper($this->paymentMethod)) &&
            !\Configuration::get('IFTHENPAY_CALLBACK_ACTIVATED_FOR_' . strtoupper($this->paymentMethod)) ? true : false;
        $ifthenpayCallback = $this->getIfthenpayCallback();

        $ifthenpayCallback->make($this->paymentMethod, $this->getCallbackControllerUrl(), $activateCallback);

        if ($activateCallback || !$this->hasCallbackData()) {
            \Configuration::updateValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_URL_CALLBACK', $ifthenpayCallback->getUrlCallback());
            \Configuration::updateValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_CHAVE_ANTI_PHISHING', $ifthenpayCallback->getChaveAntiPhishing());
        }
    }



    /**
     * verifies if method has callback data stored in database
     *
     * @return boolean
     */
    protected function hasCallbackData(){
        return \Configuration::get('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_URL_CALLBACK') &&
        \Configuration::get('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_CHAVE_ANTI_PHISHING');
    }

    /**
     * saves payment method common values to database
     * ex: minimum, maximum, countries, callback url, antiphishing key
     *
     * @return void
     */
    protected function updatePayMethodCommonValues()
    {
        \Configuration::updateValue('IFTHENPAY_'. strtoupper($this->paymentMethod) .'_MINIMUM', $this->gatewayDataBuilder->getData()->min);
        \Configuration::updateValue('IFTHENPAY_'. strtoupper($this->paymentMethod) .'_MAXIMUM', $this->gatewayDataBuilder->getData()->max);
        \Configuration::updateValue('IFTHENPAY_'. strtoupper($this->paymentMethod) .'_COUNTRIES', json_encode($this->gatewayDataBuilder->getData()->countries));
        \Configuration::updateValue('IFTHENPAY_'. strtoupper($this->paymentMethod) .'_ORDER', $this->gatewayDataBuilder->getData()->order);

        $isActive = \Tools::getValue('IFTHENPAY_CALLBACK_ACTIVATE_FOR_' . strtoupper($this->paymentMethod)) ? true : false;
        \Configuration::updateValue('IFTHENPAY_CALLBACK_ACTIVATED_FOR_' . strtoupper($this->paymentMethod), $isActive);
    }



    /**
     * assigns all variables that are common to all payment methods but these do not belong to the form
     * ex: callback(if is active or not)...
     * @return void
     */
    protected function assignSmartyPayMethodsCommonVars()
    {
        $callbackUrl = \Configuration::get('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_URL_CALLBACK');

        $hasCallbackUrl = $callbackUrl ? true : false;
        \Context::getContext()->smarty->assign('displayCallbackTableInfo', $hasCallbackUrl);

        \Context::getContext()->smarty->assign('isSandboxMode', \Configuration::get('IFTHENPAY_ACTIVATE_SANDBOX_MODE', false));

        $isCallbackActivated = \Configuration::get('IFTHENPAY_CALLBACK_ACTIVATED_FOR_' . strtoupper($this->paymentMethod)) ? true : false;
        \Context::getContext()->smarty->assign('isCallbackActivated', $isCallbackActivated);

        \Context::getContext()->smarty->assign('chaveAntiPhishing', \Configuration::get('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_CHAVE_ANTI_PHISHING'));
        \Context::getContext()->smarty->assign('urlCallback', $callbackUrl);
        \Context::getContext()->smarty->assign('spinnerUrl', _MODULE_DIR_ . $this->ifthenpayModule->name . '/views/img/oval.svg');
    }


    /**
     * validates the minimum and maximum values from the config form
     *
     * @return boolean
     */
    protected function isValid()
    {
        $minimum = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_MINIMUM');
        $maximum = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_MAXIMUM');
        $order = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_ORDER');

        if (!preg_match( "/^[0-9]+([.][0-9]{3})*$/" , $minimum) && $minimum != '') {
            Utility::setPrestashopCookie('error', 'Inputted Minimum Order Value is not valid', pathinfo(__FILE__)['filename']);
            return false;
        } 
        
        if (!preg_match( "/^[0-9]+([.][0-9]{3})*$/" , $maximum) && $maximum != '') {
            Utility::setPrestashopCookie('error', 'Inputted Maximum Order Value is not valid', pathinfo(__FILE__)['filename']);
            return false;
        } 

        if ($minimum > $maximum  && $minimum != '' && $maximum != '') {
            Utility::setPrestashopCookie('error', 'Inputted Minimum Order Value is larger than Maximum Order Value', pathinfo(__FILE__)['filename']);
            return false;
        }

        if ($minimum == $maximum  && $minimum != '' && $maximum != '') {
            Utility::setPrestashopCookie('error', 'Inputted Minimum Order Value is equal to Maximum Order Value', pathinfo(__FILE__)['filename']);
            return false;
        }

        if (!preg_match( "/^[0-9]+([.][0-9])*$/" , $order) && $order != '') {
            Utility::setPrestashopCookie('error', 'Inputted Order Value is not valid', pathinfo(__FILE__)['filename']);
            return false;
        } 

        return true;
    }



    abstract public function getForm();
    abstract public function processForm();
    abstract public function deleteConfigValues();
}
