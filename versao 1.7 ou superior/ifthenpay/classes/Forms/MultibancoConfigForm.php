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

use PrestaShop\Module\Ifthenpay\Forms\ConfigForm;
use PrestaShop\Module\Ifthenpay\Utility\Utility;

class MultibancoConfigForm extends ConfigForm
{
    protected $paymentMethod = 'multibanco';

    protected $subEntityOptions = []; // array of subentity options for GUI select
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
        $this->setSubEntityOptions();
        $this->addActivateCallbackToForm();

        // ENTITY
        $this->form['form']['input'][] = [
            'type' => 'select',
            'label' => $this->ifthenpayModule->l('Entity', pathinfo(__FILE__)['filename']),
            'desc' => $this->ifthenpayModule->l('Choose Entity', pathinfo(__FILE__)['filename']),
            'name' => 'IFTHENPAY_MULTIBANCO_ENTIDADE',
            'id' => 'ifthenpayMultibancoEntidade',
            'required' => true,
            'options' => [
                'query' => $this->options,
                'id' => 'id',
                'name' => 'name'
            ]
        ];
        // SUB_ENTITY
        $this->form['form']['input'][] = [
            'type' => 'select',
            'label' => $this->ifthenpayModule->l('SubEntity', pathinfo(__FILE__)['filename']),
            'desc' => $this->ifthenpayModule->l('Choose SubEntity', pathinfo(__FILE__)['filename']),
            'name' => 'IFTHENPAY_MULTIBANCO_SUBENTIDADE',
            'id' => 'ifthenpayMultibancoSubentidade',
            'required' => true,
            'options' => [
                'query' => $this->subEntityOptions,
                'id' => 'id',
                'name' => 'name'
            ]
        ];
        // PAYMENT EXPIRATION
        $this->form['form']['input'][] = [
            'type' => 'select',
            'label' => $this->ifthenpayModule->l('Deadline', pathinfo(__FILE__)['filename']),
            'desc' => $this->ifthenpayModule->l('Choose days to Deadline. By selecting 0, the reference expires on the same day at 23:59. By selecting "No Deadline", the reference does not expiry. ', pathinfo(__FILE__)['filename']),
            'name' => 'IFTHENPAY_MULTIBANCO_VALIDADE',
            'id' => 'ifthenpayMultibancoDeadline',
            'options' => [
                'query' => $this->getDeadlineOptions(),
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
        $validade = \Configuration::get('IFTHENPAY_MULTIBANCO_VALIDADE');
        $validade = $validade !== false ? $validade : '999999';

        return array_merge(parent::getCommonConfigFormValues(), [
            'IFTHENPAY_MULTIBANCO_ENTIDADE' => \Configuration::get('IFTHENPAY_MULTIBANCO_ENTIDADE'),
            'IFTHENPAY_MULTIBANCO_SUBENTIDADE' => \Configuration::get('IFTHENPAY_MULTIBANCO_SUBENTIDADE'),
            'IFTHENPAY_MULTIBANCO_VALIDADE' => $validade,
        ]);
    }

    public function setSmartyVariables()
    {
        // common to all payment methods
        parent::assignSmartyPayMethodsCommonVars();

        // specific to this payment method
        \Context::getContext()->smarty->assign('entidade', \Configuration::get('IFTHENPAY_MULTIBANCO_ENTIDADE'));
        \Context::getContext()->smarty->assign('subEntidade', \Configuration::get('IFTHENPAY_MULTIBANCO_SUBENTIDADE'));
        $validade = \Configuration::get('IFTHENPAY_MULTIBANCO_VALIDADE');
        \Context::getContext()->smarty->assign('validade', $validade ? $validade : '999999');
    }

    public function setGatewayBuilderData()
    {
        $getEntidadeFromRequest = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_ENTIDADE');
        $getSubEntidadeFromRequest = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_SUBENTIDADE');
        $getValidadeFromRequest = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_VALIDADE');



        parent::setGatewayBuilderData();
        $this->gatewayDataBuilder->setEntidade($getEntidadeFromRequest ? $getEntidadeFromRequest : \Configuration::get('IFTHENPAY_MULTIBANCO_ENTIDADE'));
        $this->gatewayDataBuilder->setSubEntidade($getSubEntidadeFromRequest ? $getSubEntidadeFromRequest : \Configuration::get('IFTHENPAY_MULTIBANCO_SUBENTIDADE'));

        if ($this->gatewayDataBuilder->getData()->entidade == 'MB' || $this->gatewayDataBuilder->getData()->entidade == 'mb') {
            $this->gatewayDataBuilder->setValidade($getValidadeFromRequest !== false ? $getValidadeFromRequest : \Configuration::get('IFTHENPAY_MULTIBANCO_VALIDADE'));
        }
    }

    public function processForm()
    {
        if ($this->isValid()) {

            $this->setGatewayBuilderData();

            // save specific values
            \Configuration::updateValue('IFTHENPAY_MULTIBANCO_ENTIDADE', $this->gatewayDataBuilder->getData()->entidade);
            \Configuration::updateValue('IFTHENPAY_MULTIBANCO_SUBENTIDADE', $this->gatewayDataBuilder->getData()->subEntidade);

            if ($this->gatewayDataBuilder->getData()->entidade == 'MB' || $this->gatewayDataBuilder->getData()->entidade == 'mb') {
                \Configuration::updateValue('IFTHENPAY_MULTIBANCO_VALIDADE', $this->gatewayDataBuilder->getData()->validade);
            }

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

        $entity = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_ENTIDADE');
        $subEntity = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_SUBENTIDADE');

        if ($entity == '') {
            Utility::setPrestashopCookie('error', 'Selected Entity is not valid', pathinfo(__FILE__)['filename']);
            return false;
        }

        if ($subEntity == '') {
            Utility::setPrestashopCookie('error', 'Selected SubEntity is not valid', pathinfo(__FILE__)['filename']);
            return false;
        }

        return true;
    }

    public function deleteConfigValues()
    {
        $this->deleteCommonConfigValues();
        \Configuration::deleteByName('IFTHENPAY_MULTIBANCO_ENTIDADE');
        \Configuration::deleteByName('IFTHENPAY_MULTIBANCO_SUBENTIDADE');
        \Configuration::deleteByName('IFTHENPAY_MULTIBANCO_VALIDADE');
        \Configuration::deleteByName('IFTHENPAY_MULTIBANCO_URL_CALLBACK');
        \Configuration::deleteByName('IFTHENPAY_MULTIBANCO_CHAVE_ANTI_PHISHING');
    }


    /**
     * generates an assoc array specifically for populating the select box of deadline of dynamic multibanco reference
     *
     * @return void
     */
    public function getDeadlineOptions()
    {
        $options = array();

        $options[] = array(
            "id" => '999999',
            "name" => $this->ifthenpayModule->l('No Deadline')
        );

        for ($i = 0; $i < 32; $i++) {
            $options[] = array(
                "id" => $i,
                "name" => $i
            );
        }
        foreach ([45, 60, 90, 120] as $val) {
            $options[] = array(
                "id" => $val,
                "name" => $val
            );
        }

        return $options;
    }
}
