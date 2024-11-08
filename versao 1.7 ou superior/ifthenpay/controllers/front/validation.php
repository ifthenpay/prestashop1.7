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

if (!defined('_PS_VERSION_')) {
	exit;
}

use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;
use PrestaShop\Module\Ifthenpay\Models\IfthenpayTempPix;

class IfthenpayValidationModuleFrontController extends ModuleFrontController
{
	public function postProcess()
	{
		$cart = $this->context->cart;
		$paymentOption = Tools::getValue('paymentOption');

		if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active) {
			Tools::redirect('index.php?controller=order&step=1');
		}

		// Check that this payment option is still available in case the customer changed his address just before the end of the checkout process
		$authorized = false;
		foreach (Module::getPaymentModules() as $module) {
			if ($module['name'] === $this->module->name) {
				$authorized = true;
				break;
			}
		}

		if (!$authorized) {
			die($this->module->l('This payment method is not available.', pathinfo(__FILE__)['filename']));
		}

		$isAuthorized = $this->isAuthorized($paymentOption);

		if ($isAuthorized !== true) {
			IfthenpayLogProcess::addLog('Validate order, payment not authorized - ' . $isAuthorized, IfthenpayLogProcess::ERROR, 0);
			$this->errors[] = Tools::displayError($isAuthorized);
			$this->redirectWithNotifications('index.php?controller=order&step=3');
		} else {
			$customer = PrestashopModelFactory::buildCustomer((string) $cart->id_customer);

			if (!Validate::isLoadedObject($customer)) {
				Tools::redirect('index.php?controller=order&step=1');
			}

			$currency = $this->context->currency;
			$total = (float)$cart->getOrderTotal(true, Cart::BOTH);

			$mailVars = [];

			try {
				$this->module->validateOrder(
					(int)$cart->id,
					Configuration::get('IFTHENPAY_' . Tools::strtoupper($paymentOption) . '_OS_WAITING'),
					$total,
					$paymentOption,
					null,
					$mailVars,
					(int)$currency->id,
					false,
					$customer->secure_key
				);
				// unnecessary log, uncomment for testing
				// IfthenpayLogProcess::addLog('Order validated with success', IfthenpayLogProcess::INFO, 0);
				Tools::redirect(
					'index.php?controller=order-confirmation&id_cart=' . (int)$cart->id . '&id_module=' . (int)$this->module->id . '&id_order=' .
						$this->module->currentOrder . '&key=' . $customer->secure_key . '&paymentOption=' . $paymentOption
				);
			} catch (\Throwable $th) {
				IfthenpayLogProcess::addLog('Error validating order - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, 0);
				throw $th;
			}
		}
	}

	/**
	 * Only validates mbway and pix
	 * in pix method it has a not very elegant side effect of saving the pix form data,
	 * this is to be used to fill the form upon redirect instead of cluttering the url query-string
	 * @param [type] $paymentOption
	 * @return boolean
	 */
	private function isAuthorized($paymentOption)
	{
		if (!Configuration::get('IFTHENPAY_' . strtoupper($paymentOption))) {
			return false;
		}

		if ($paymentOption === 'mbway') {
			$mbwayPhone = Tools::getValue("ifthenpayMbwayPhone");
			if (!$mbwayPhone) {
				return $this->module->l('MB WAY phone is required.', pathinfo(__FILE__)['filename']);
			}
			if (strlen($mbwayPhone) < 9 || !ctype_digit($mbwayPhone)) {
				return $this->module->l('MB WAY phone is not valid.', pathinfo(__FILE__)['filename']);
			}

			$mbwayPhoneCode = Tools::getValue("ifthenpayMbwayPhoneCode") ?? '';
			if ($mbwayPhoneCode != '') {
				$mbwayPhone = $mbwayPhoneCode . '#' . $mbwayPhone;
			}

			Configuration::updateValue('IFTHENPAY_MBWAY_PHONE_' . $this->context->cart->id, $mbwayPhone);
		}

		if ($paymentOption === 'pix') {

			$data = [];
			$data['cartId'] = (string)$this->context->cart->id;
			$data['customerName'] = Tools::getValue("ifthenpay_customerName");
			$data['customerCpf'] = Tools::getValue("ifthenpay_customerCpf");
			$data['customerEmail'] = Tools::getValue("ifthenpay_customerEmail");
			$data['customerPhone'] = Tools::getValue("ifthenpay_customerPhone");
			$data['customerAddress'] = Tools::getValue("ifthenpay_customerAddress");
			$data['customerStreetNumber'] = Tools::getValue("ifthenpay_customerStreetNumber");
			$data['customerCity'] = Tools::getValue("ifthenpay_customerCity");
			$data['customerZipCode'] = Tools::getValue("ifthenpay_customerZipCode");
			$data['customerState'] = Tools::getValue("ifthenpay_customerState");


			$validationErrorArray = [];
			// cartid
			if (!$data['cartId'] || $data['cartId'] == '') {
				return $this->module->l('An error ocurred while getting the Cart ID.', pathinfo(__FILE__)['filename']);
			}
			// name
			if (!$data['customerName'] || $data['customerName'] == '') {
				$validationErrorArray['customerName'] = $this->module->l('Pix Name field is required.', pathinfo(__FILE__)['filename']);
			} else if (strlen($data['customerName']) > 150) {
				$validationErrorArray['customerName'] = $this->module->l('Pix Name field is invalid. Must not exceed 150 characters.', pathinfo(__FILE__)['filename']);
			}

			// CPF
			if (!$data['customerCpf'] || $data['customerCpf'] == '') {
				$validationErrorArray['customerCpf'] = $this->module->l('Pix CPF field is required.', pathinfo(__FILE__)['filename']);
			} else if (!preg_match("/^(\d{3}\.\d{3}\.\d{3}-\d{2}|\d{11})$/", $data['customerCpf'])) {
				$validationErrorArray['customerCpf'] = $this->module->l('Pix CPF field is invalid. Must be comprised of 11 digits with either of the following patterns: 111.111.111-11 or 11111111111', pathinfo(__FILE__)['filename']);
			}
			// email
			if (!$data['customerEmail'] || $data['customerEmail'] == '') {
				$validationErrorArray['customerEmail'] = $this->module->l('Pix Email field is required.', pathinfo(__FILE__)['filename']);
			} else if (!filter_var($data['customerEmail'], FILTER_VALIDATE_EMAIL)) {
				$validationErrorArray['customerEmail'] = $this->module->l('Pix Email field is invalid. Must be a valid email address.', pathinfo(__FILE__)['filename']);
			} else if (strlen($data['customerEmail']) > 250) {
				$validationErrorArray['customerEmail'] = $this->module->l('Pix Email field is invalid. Must not exceed 250 characters.', pathinfo(__FILE__)['filename']);
			}
			// phone
			if ($data['customerPhone'] && $data['customerPhone'] != '' && strlen($data['customerPhone']) > 20) {
				$validationErrorArray['customerPhone'] = $this->module->l('Pix Phone field is invalid. Must not exceed 20 characters.', pathinfo(__FILE__)['filename']);
			}
			// address
			if ($data['customerAddress'] && $data['customerAddress'] != '' && strlen($data['customerAddress']) > 250) {
				$validationErrorArray['customerAddress'] = $this->module->l('Pix Address field is invalid. Must not exceed 250 characters.', pathinfo(__FILE__)['filename']);
			}
			// streetNumber
			if ($data['customerStreetNumber'] && $data['customerStreetNumber'] != '' && strlen($data['customerStreetNumber']) > 20) {
				$validationErrorArray['customerStreetNumber'] = $this->module->l('Pix Street Number field is invalid. Must not exceed 20 characters.', pathinfo(__FILE__)['filename']);
			}
			// City
			if ($data['customerCity'] && $data['customerCity'] != '' && strlen($data['customerCity']) > 50) {
				$validationErrorArray['customerCity'] = $this->module->l('Pix City field is invalid. Must not exceed 50 characters.', pathinfo(__FILE__)['filename']);
			}
			// Zip Code
			if ($data['customerZipCode'] && $data['customerZipCode'] != '' && strlen($data['customerZipCode']) > 20) {
				$validationErrorArray['customerZipCode'] = $this->module->l('Pix Zip Code field is invalid. Must not exceed 20 characters.', pathinfo(__FILE__)['filename']);
			}
			// State
			if ($data['customerState'] && $data['customerState'] != '' && strlen($data['customerState']) > 50) {
				$validationErrorArray['customerState'] = $this->module->l('Pix State field is invalid. Must not exceed 50 characters.', pathinfo(__FILE__)['filename']);
			}

			foreach ($validationErrorArray as $field => $message) {
				$data[$field] = ''; // Clear only fields with errors
			}

			$tempPixModel = IfthenpayTempPix::modelFromData($data);
			$tempPixModel->saveOrUpdate();

			// show only one error
			if (!empty($validationErrorArray)) {
				return reset($validationErrorArray);
			}
		}
		return true;
	}
}
