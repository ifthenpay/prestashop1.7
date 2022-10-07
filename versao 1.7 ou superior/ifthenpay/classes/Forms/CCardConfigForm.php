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

class CCardConfigForm extends ConfigForm
{
    protected $paymentMethod = 'ccard';

    protected $options = []; // array of entity options for GUI select



    /**
     * Translation workaround
     * this is used to generate translations while in this class, because even setting the second argument (file)
     * in the $this->translate('translatable', file), it still stores it to ... for example configform when used there.
     *
     * @return array
     */
    protected function tl()
    {
        $f = Utility::getClassName($this);
        $trans = [
            'Settings' => $this->ifthenpayModule->l('Settings', $f),
            'Save' => $this->ifthenpayModule->l('Save', $f),
            'Callback' => $this->ifthenpayModule->l('Callback', $f),
            'CallbackDesc' => $this->ifthenpayModule->l('Activate callback automatically. If sandbox mode is enabled, callback will not activate.', $f),
            'Activate' => $this->ifthenpayModule->l('Activate', $f),
            'Disabled' => $this->ifthenpayModule->l('Disabled', $f),
            'Minimum' => $this->ifthenpayModule->l('Minimum Order Value', $f),
            'MinimumDesc' => $this->ifthenpayModule->l('Only display this payment method for orders with total value greater than inserted value.', $f),
            'Maximum' => $this->ifthenpayModule->l('Maximum Order Value', $f),
            'MaximumDesc' => $this->ifthenpayModule->l('Only display this payment method for orders with total value less than inserted value.', $f),
            'Order' => $this->ifthenpayModule->l('Order', $f),
            'OrderDesc' => $this->ifthenpayModule->l('Order payment methods at checkout page. Order is ascending for example, (Multibanco: 1, MB WAY: 4, CCARD: 2) will result in  (Multibanco, CCARD, MB WAY). This option only affects this module\'s payment methods', $f),
            'CountryRestrictions' => $this->ifthenpayModule->l('Country restrictions', $f),
            'CountryRestrictionsDesc' => $this->ifthenpayModule->l('Display this payment method for selected countries, or leave empty to allow all countries. Use CTRL keyboard key and mouse click to toggle selection.', $f)
        ];

        return $trans;
    }



    /**
     * "gets" the form into object... it sets the form that will display in the payment method configuration
     *
     * @return void
     */
    public function getForm()
    {
        // assign template variables
        $this->setSmartyVariables();

        $this->setFormParent($this->tl());
        $this->setEntityOptions();

        $this->form['form']['input'][] = [
            'type' => 'select',
            'label' => $this->ifthenpayModule->l('CCard key', pathinfo(__FILE__)['filename']),
            'desc' => $this->ifthenpayModule->l('Choose CCard key', pathinfo(__FILE__)['filename']),
            'name' => 'IFTHENPAY_CCARD_KEY',
            'required' => true,
            'options' => [
                'query' => $this->options,
                'id' => 'id',
                'name' => 'name'
            ]
        ];

        // add min max and country form elements
        $this->addMinMaxFieldsToForm($this->tl());
        $this->addCountriesFieldToForm($this->tl());
        $this->addOrderByNumberFieldsToForm($this->tl());

        // generate form
        $this->generateHelperForm();
    }

    protected function getConfigFormValues()
    {
        return array_merge(parent::getCommonConfigFormValues(), [
            'IFTHENPAY_CCARD_KEY' => \Configuration::get('IFTHENPAY_CCARD_KEY')
        ]);
    }

    public function setSmartyVariables()
    {
        // common to all payment methods
        parent::assignSmartyPayMethodsCommonVars();

        // specific to this payment method
        \Context::getContext()->smarty->assign('ccardKey', \Configuration::get('IFTHENPAY_CCARD_KEY'));
    }



    public function setGatewayBuilderData()
    {
        $getCCardKeyFromRequest = \Tools::getValue('IFTHENPAY_CCARD_KEY');

        parent::setGatewayBuilderData();
        $this->gatewayDataBuilder->setEntidade(\Tools::strtoupper($this->paymentMethod));
        $this->gatewayDataBuilder->setSubEntidade($getCCardKeyFromRequest ? $getCCardKeyFromRequest : \Configuration::get('IFTHENPAY_CCARD_KEY'));
    }

    public function processForm()
    {
        if ($this->isValid()) {

            $this->setGatewayBuilderData();

            // save specific values
            \Configuration::updateValue('IFTHENPAY_CCARD_KEY', $this->gatewayDataBuilder->getData()->subEntidade);

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

        $ccardKey = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_KEY');

        if ($ccardKey == '') {
            Utility::setPrestashopCookie('error', 'Selected Key is not valid', pathinfo(__FILE__)['filename']);
            return false;
        }

        return true;
    }

    public function deleteConfigValues()
    {
        $this->deleteCommonConfigValues();
        \Configuration::deleteByName('IFTHENPAY_CCARD_KEY');
    }
}
