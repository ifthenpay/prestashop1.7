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
use PrestaShop\Module\Ifthenpay\Forms\ConfigForm;

class MbwayConfigForm extends ConfigForm
{
    protected $paymentMethod = 'mbway';

    protected $options = []; // array of entity options for GUI select



    /**
     * "gets" the form into object... it sets the form that will display in the payment method configuration
     *
     * @return void
     */
    public function getForm()
    {
        // assign template variables
        $this->setSmartyVariables();

        $this->setFormParent();
        $this->setEntityOptions();
        $this->addActivateCallbackToForm();

        // cancel after timer of 30 minutes
        $this->form['form']['input'][] = [
            'type' => 'switch',
            'label' => $this->ifthenpayModule->l('Cancel MB WAY Order', pathinfo(__FILE__)['filename']),
            'name' => 'IFTHENPAY_MBWAY_CANCEL_ORDER_AFTER_TIMEOUT',
            'desc' => $this->ifthenpayModule->l('Cancel MB WAY order thirty minutes after order confirmation. This is triggered when admin visits the order list page and will only work if the callback is activated.'),
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
        // show javascript countdown after order confirmation
        $this->form['form']['input'][] = [
            'type' => 'switch',
            'label' => $this->ifthenpayModule->l('MB WAY Countdown', pathinfo(__FILE__)['filename']),
            'name' => 'IFTHENPAY_MBWAY_SHOW_COUNTDOWN',
            'desc' => $this->ifthenpayModule->l('Display MB WAY Countdown after confirming order. Disable this option if having conflicts with "one page checkout" plugins.'),
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
        // select mbway key
        $this->form['form']['input'][] = [
            'type' => 'select',
            'label' => $this->ifthenpayModule->l('MB WAY key', pathinfo(__FILE__)['filename']),
            'desc' => $this->ifthenpayModule->l('Choose MB WAY key', pathinfo(__FILE__)['filename']),
            'name' => 'IFTHENPAY_MBWAY_KEY',
            'required' => true,
            'options' => [
                'query' => $this->options,
                'id' => 'id',
                'name' => 'name'
            ]
        ];

        // add min max and country form elements
        $this->addMinMaxFieldsToForm();
        $this->addCountriesFieldToForm();
        $this->addOrderByNumberFieldsToForm();

        // generate form
        $this->generateHelperForm();
    }

    protected function getConfigFormValues()
    {
        $mbWayCountdown = \Configuration::get('IFTHENPAY_MBWAY_SHOW_COUNTDOWN') !== false ? \Configuration::get('IFTHENPAY_MBWAY_SHOW_COUNTDOWN') : '1';

        return array_merge(parent::getCommonConfigFormValues(), [
            'IFTHENPAY_MBWAY_CANCEL_ORDER_AFTER_TIMEOUT' => \Configuration::get('IFTHENPAY_MBWAY_CANCEL_ORDER_AFTER_TIMEOUT'),
            'IFTHENPAY_MBWAY_KEY' => \Configuration::get('IFTHENPAY_MBWAY_KEY'),
            'IFTHENPAY_MBWAY_SHOW_COUNTDOWN' => $mbWayCountdown
        ]);
    }

    public function setSmartyVariables()
    {
        // common to all payment methods
        parent::assignSmartyPayMethodsCommonVars();

        // specific to this payment method

        \Context::getContext()->smarty->assign('mbwayKey', \Configuration::get('IFTHENPAY_MBWAY_KEY'));
    }

    public function setGatewayBuilderData()
    {
        $getMbwayKeyFromRequest = \Tools::getValue('IFTHENPAY_MBWAY_KEY');

        parent::setGatewayBuilderData();

        $this->gatewayDataBuilder->setEntidade(\Tools::strtoupper($this->paymentMethod));
        $this->gatewayDataBuilder->setSubEntidade($getMbwayKeyFromRequest ? $getMbwayKeyFromRequest : \Configuration::get('IFTHENPAY_MBWAY_KEY'));
    }

    public function processForm()
    {
        if ($this->isValid()) {

            $this->setGatewayBuilderData();
     
            // save specific values
            \Configuration::updateValue('IFTHENPAY_MBWAY_KEY', $this->gatewayDataBuilder->getData()->subEntidade);
            \Configuration::updateValue('IFTHENPAY_MBWAY_CANCEL_ORDER_AFTER_TIMEOUT', \Tools::getValue('IFTHENPAY_MBWAY_CANCEL_ORDER_AFTER_TIMEOUT'));
            \Configuration::updateValue('IFTHENPAY_MBWAY_SHOW_COUNTDOWN', \Tools::getValue('IFTHENPAY_MBWAY_SHOW_COUNTDOWN'));

            $this->setIfthenpayCallback();

            $this->updatePayMethodCommonValues();

            Utility::setPrestashopCookie('success', $this->ifthenpayModule->l(ucfirst($this->paymentMethod) . ' payment method successfully updated.', pathinfo(__FILE__)['filename']));
        }
    }

    

    /**
     * verifies if form inputs are valid
     * makes use of parent function that verifies common inputs such as min and max
     *
     * @return boolean
     */
    public function isValid()
    {
        if (!parent::isValid()) {
            return false;
        }

        $mbwayKey = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_KEY');

        if ($mbwayKey == '') {
            Utility::setPrestashopCookie('error', 'Selected Key is not valid', pathinfo(__FILE__)['filename']);
            return false;
        }

        return true;
    }

    public function deleteConfigValues()
    {
        $this->deleteCommonConfigValues();
        \Configuration::deleteByName('IFTHENPAY_MBWAY_KEY');
        \Configuration::deleteByName('IFTHENPAY_MBWAY_URL_CALLBACK');
        \Configuration::deleteByName('IFTHENPAY_MBWAY_CHAVE_ANTI_PHISHING');
        \Configuration::deleteByName('IFTHENPAY_MBWAY_CANCEL_ORDER_AFTER_TIMEOUT');
        \Configuration::deleteByName('IFTHENPAY_MBWAY_SHOW_COUNTDOWN');
    }
}
