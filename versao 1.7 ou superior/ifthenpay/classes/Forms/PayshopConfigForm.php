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

class PayshopConfigForm extends ConfigForm
{
    protected $paymentMethod = 'payshop';

    protected $options = []; // array of entity options for GUI select



    public function getForm()
    {
        // assign template variables
        $this->setSmartyVariables();

        $this->setFormParent();
        $this->setEntityOptions(); // sets the $this->options
        $this->addActivateCallbackToForm();
        $this->form['form']['input'][] = [
            'type' => 'select',
            'label' => $this->ifthenpayModule->l('Payshop key', pathinfo(__FILE__)['filename']),
            'desc' => $this->ifthenpayModule->l('Choose Payshop key', pathinfo(__FILE__)['filename']),
            'name' => 'IFTHENPAY_PAYSHOP_KEY',
            'required' => true,
            'options' => [
                'query' => $this->options,
                'id' => 'id',
                'name' => 'name'
            ]
        ];
        $this->form['form']['input'][] = [
            'type' => 'text',
            'label' => $this->ifthenpayModule->l('Deadline', pathinfo(__FILE__)['filename']),
            'name' => 'IFTHENPAY_PAYSHOP_VALIDADE',
            'desc' => $this->ifthenpayModule->l('Choose the number of days (from 1 to 99), leave empty if you do not want expiration.', pathinfo(__FILE__)['filename'])
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
        return array_merge(parent::getCommonConfigFormValues(), [
            'IFTHENPAY_PAYSHOP_KEY' => \Configuration::get('IFTHENPAY_PAYSHOP_KEY'),
            'IFTHENPAY_PAYSHOP_VALIDADE' => \Configuration::get('IFTHENPAY_PAYSHOP_VALIDADE')
        ]);
    }



    public function setSmartyVariables()
    {
        // common to all payment methods
        parent::assignSmartyPayMethodsCommonVars();

        // specific to this payment method
        \Context::getContext()->smarty->assign('payshopKey', \Configuration::get('IFTHENPAY_PAYSHOP_KEY'));
        \Context::getContext()->smarty->assign('payshopValidade', \Configuration::get('IFTHENPAY_PAYSHOP_VALIDADE'));
    }



    public function setGatewayBuilderData()
    {
        $getPayshopKeyFromRequest = \Tools::getValue('IFTHENPAY_PAYSHOP_KEY');

        parent::setGatewayBuilderData();
        $this->gatewayDataBuilder->setEntidade(\Tools::strtoupper($this->paymentMethod));
        $this->gatewayDataBuilder->setSubEntidade($getPayshopKeyFromRequest ? $getPayshopKeyFromRequest : \Configuration::get('IFTHENPAY_PAYSHOP_KEY'));
    }



    public function processForm()
    {
        if ($this->isValid()) {

            $this->setGatewayBuilderData();

            // save specific values
            \Configuration::updateValue('IFTHENPAY_PAYSHOP_KEY', $this->gatewayDataBuilder->getData()->subEntidade);
            \Configuration::updateValue('IFTHENPAY_PAYSHOP_VALIDADE', \Tools::getValue('IFTHENPAY_PAYSHOP_VALIDADE'));

            $this->setIfthenpayCallback();

            $this->updatePayMethodCommonValues();

            // response msg after submiting form
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

        $payShopKey = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_KEY');
        $deadline = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_VALIDADE');

        if ($payShopKey == '') {
            Utility::setPrestashopCookie('error', 'Selected Key is not valid', pathinfo(__FILE__)['filename']);
            return false;
        }

        if (!preg_match("/^[0-9]{1,2}$/", $deadline) && $deadline != '') {
            Utility::setPrestashopCookie('error', 'Inputted Expiration is not valid', pathinfo(__FILE__)['filename']);
            return false;
        }

        return true;
    }

    public function deleteConfigValues()
    {
        $this->deleteCommonConfigValues();
        \Configuration::deleteByName('IFTHENPAY_PAYSHOP_KEY');
        \Configuration::deleteByName('IFTHENPAY_PAYSHOP_VALIDADE');
        \Configuration::deleteByName('IFTHENPAY_PAYSHOP_URL_CALLBACK');
        \Configuration::deleteByName('IFTHENPAY_PAYSHOP_CHAVE_ANTI_PHISHING');
    }
}
