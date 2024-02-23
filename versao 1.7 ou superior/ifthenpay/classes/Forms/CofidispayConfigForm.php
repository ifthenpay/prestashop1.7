<?php

/**
 * 2007-2023 Ifthenpay Lda
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

class CofidispayConfigForm extends ConfigForm
{
	protected $paymentMethod = 'cofidispay';
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

		// sets the $this->options
		$this->setEntityOptions();

		// activate auto callback
		$this->addActivateCallbackToForm();

		$this->form['form']['input'][] = [
			'type' => 'select',
			'label' => $this->ifthenpayModule->l('Cofidis Pay key', pathinfo(__FILE__)['filename']),
			'desc' => $this->ifthenpayModule->l('Choose Cofidis Pay key', pathinfo(__FILE__)['filename']),
			'name' => 'IFTHENPAY_COFIDIS_KEY',
			'id' => 'ifthenpayCofidisKey',
			'required' => true,
			'options' => [
				'query' => $this->options,
				'id' => 'id',
				'name' => 'name'
			]
		];

		// cancel after deadline
		$this->form['form']['input'][] = [
			'type' => 'switch',
			'label' => $this->ifthenpayModule->l('Cancel Cofidis Pay Order', pathinfo(__FILE__)['filename']),
			'name' => 'IFTHENPAY_COFIDIS_CANCEL_ORDER_AFTER_TIMEOUT',
			'desc' => $this->ifthenpayModule->l('Cancel order if not payed within 60 minutes after confirmation. This is triggered when admin visits the order list page.', pathinfo(__FILE__)['filename']),
			'is_bool' => true,
			'values' => [
				[
					'id' => 'active_on',
					'value' => true,
					'label' => $this->ifthenpayModule->l('Activated', pathinfo(__FILE__)['filename'])
				],
				[
					'id' => 'active_off',
					'value' => false,
					'label' => $this->ifthenpayModule->l('Disabled', pathinfo(__FILE__)['filename'])
				]
			]
		];


		// add min max and country form elements
		$this->addMinMaxFieldsToForm();

		// modify min max info
		$this->form['form']['input'][count($this->form['form']['input']) - 2]['desc'] = $this->ifthenpayModule->l('Only display this payment method for orders with total value greater than inserted value. Inputted value can not be less than defined value in ifthenpay backoffice.', pathinfo(__FILE__)['filename']);

		$this->form['form']['input'][count($this->form['form']['input']) - 1]['desc'] = $this->ifthenpayModule->l('Only display this payment method for orders with total value less than inserted value. Inputted value can not be greater than defined value in ifthenpay backoffice.', pathinfo(__FILE__)['filename']);


		$this->addCountriesFieldToForm();
		$this->addOrderByNumberFieldsToForm();

		// generate form
		$this->generateHelperForm();
	}

	protected function getConfigFormValues()
	{
		return array_merge(parent::getCommonConfigFormValues(), [
			'IFTHENPAY_COFIDIS_KEY' => \Configuration::get('IFTHENPAY_COFIDIS_KEY'),
			'IFTHENPAY_COFIDIS_CANCEL_ORDER_AFTER_TIMEOUT' => \Configuration::get('IFTHENPAY_COFIDIS_CANCEL_ORDER_AFTER_TIMEOUT')
		]);
	}

	public function setSmartyVariables()
	{
		// common to all payment methods
		parent::assignSmartyPayMethodsCommonVars();

		// specific to this payment method
		\Context::getContext()->smarty->assign('cofidisKey', \Configuration::get('IFTHENPAY_COFIDIS_KEY'));
	}



	public function setGatewayBuilderData()
	{
		$getCofidisKeyFromRequest = \Tools::getValue('IFTHENPAY_COFIDIS_KEY');

		parent::setGatewayBuilderData();
		$this->gatewayDataBuilder->setEntidade(\Tools::strtoupper('COFIDIS'));
		$this->gatewayDataBuilder->setSubEntidade($getCofidisKeyFromRequest ? $getCofidisKeyFromRequest : \Configuration::get('IFTHENPAY_COFIDIS_KEY'));
	}

	public function processForm()
	{
		if ($this->isValid()) {

			$this->setGatewayBuilderData();

			// save specific values
			\Configuration::updateValue('IFTHENPAY_COFIDIS_KEY', $this->gatewayDataBuilder->getData()->subEntidade);
			\Configuration::updateValue('IFTHENPAY_COFIDIS_CANCEL_ORDER_AFTER_TIMEOUT', \Tools::getValue('IFTHENPAY_COFIDIS_CANCEL_ORDER_AFTER_TIMEOUT'));


			$this->setIfthenpayCallback();
			$this->updatePayMethodCommonValues();

			// response msg after submiting form
			Utility::setPrestashopCookie('success', $this->ifthenpayModule->l(ucfirst($this->paymentMethod) . ' payment method successfully updated.', pathinfo(__FILE__)['filename']));

			return true;

		} else {

			return false;
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

		$cofidisKey = \Tools::getValue('IFTHENPAY_COFIDIS_KEY');
		$minimum = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_MINIMUM');
		$maximum = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_MAXIMUM');

		$limits = $this->ifthenpayGateway->getCofidisLimits($cofidisKey);

		if ($minimum < $limits['minAmount']) {
			Utility::setPrestashopCookie('error', 'Inputted Minimum Order Value is not valid');
			return false;
		}

		if ($maximum > $limits['maxAmount']) {
			Utility::setPrestashopCookie('error', 'Inputted Maximum Order Value is not valid');
			return false;
		}

		if ($cofidisKey == '') {
			Utility::setPrestashopCookie('error', 'Selected Key is not valid');
			return false;
		}

		return true;
	}

	public function deleteConfigValues()
	{
		$this->deleteCommonConfigValues();
		\Configuration::deleteByName('IFTHENPAY_COFIDIS_KEY');
		\Configuration::deleteByName('IFTHENPAY_COFIDIS_CANCEL_ORDER_AFTER_TIMEOUT');

	}
}
