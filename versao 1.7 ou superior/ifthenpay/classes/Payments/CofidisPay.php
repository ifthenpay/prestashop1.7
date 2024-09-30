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

namespace PrestaShop\Module\Ifthenpay\Payments;

use PrestaShop\Module\Ifthenpay\Builders\DataBuilder;
use PrestaShop\Module\Ifthenpay\Builders\GatewayDataBuilder;
use PrestaShop\Module\Ifthenpay\Contracts\Payments\PaymentMethodInterface;
use PrestaShop\Module\Ifthenpay\Utility\Status;
use PrestaShop\Module\Ifthenpay\Utility\Token;
use PrestaShop\PrestaShop\Adapter\Entity\Language;
use PrestaShop\PrestaShop\Core\Address\Address;

if (!defined('_PS_VERSION_')) {
	exit;
}


class CofidisPay extends Payment implements PaymentMethodInterface
{
	private $cofidisKey;
	private $cofidisRequest;
	private $successUrl;
	private $errorUrl;
	private $cancelUrl;

	public function __construct($data, $orderId, $valor)
	{
		parent::__construct($orderId, $valor);
		$this->cofidisKey = $data->getData()->cofidisKey;
		$this->successUrl = $data->getData()->successUrl;
	}

	public function checkValue()
	{
		if ($this->valor >= 1000000) {
			throw new \Exception('Invalid Cofidis Pay value, above 999999€');
		}
	}

	private function checkEstado()
	{
		if ($this->cofidisRequest['status'] !== '0') {
			throw new \Exception($this->cofidisRequest['message']);
		}
	}

/**
 * Generates an array with the customer data required to pass as payload for cofidis pay.
 * This is an overzealous take on the matter since it checks with isset() although verifying object properties.
 * @return array
 */
	private function getCustomerData(): array{
		$customerData = [];
		$context = \Context::getContext();
		$customer = $context->customer;
		$addressDelivery = new \Address($context->cart->id_address_delivery);
		$addressInvoice = new \Address($context->cart->id_address_invoice);


		$shippingFirstName = isset($addressDelivery->firstname) ? $addressDelivery->firstname : '';
		$shippingLastName = isset($addressDelivery->lastname) ? $addressDelivery->lastname : '';
		if ($shippingFirstName . $shippingLastName != '') {
			$customerData['customerName'] = trim($shippingFirstName . " " . $shippingLastName);
		}

		// use billing address customer name instead if it exists
		$billingFirstName = isset($addressInvoice->firstname) ? $addressInvoice->firstname : '';
		$billingLastName = isset($addressInvoice->lastname) ? $addressInvoice->lastname : '';
		if ($billingFirstName . $billingLastName != '') {
			$customerData['customerName'] = trim($billingFirstName . " " . $billingLastName);
		}

		if ($addressInvoice->vat_number){
			$customerData['customerVat'] = $addressInvoice->vat_number;
		}

		if (isset($customer->email) && $customer->email) {
			$customerData['customerEmail'] = $customer->email;
		}

		$phone = isset($addressInvoice->phone) && $addressInvoice->phone != '' ? $addressInvoice->phone : '';
		$mobilePhone = isset($addressInvoice->phone_mobile) && $addressInvoice->phone_mobile != '' ? $addressInvoice->phone_mobile : '';
		if ($phone != '' || $mobilePhone != '') {
			$customerData['customerPhone'] = $mobilePhone != '' ? $mobilePhone : $phone;
		}

		$billingAddress1 = isset($addressDelivery->address1) ? $addressDelivery->address1 : '';
		$billingAddress2 = isset($addressDelivery->address2) ? $addressDelivery->address2 : '';
		if ($billingAddress1 . $billingAddress2 != '') {
			$customerData['billingAddress'] = trim($billingAddress1 . " " . $billingAddress2);
		}

		if (isset($addressInvoice->postcode) && $addressInvoice->postcode) {
			$customerData['billingZipCode'] = $addressInvoice->postcode;
		}

		if (isset($addressInvoice->city) && $addressInvoice->city) {
			$customerData['billingCity'] = $addressInvoice->city;
		}

		$shippingAddress1 = isset($addressDelivery->address1) ? $addressDelivery->address1 : '';
		$shippingAddress2 = isset($addressDelivery->address2) ? $addressDelivery->address2 : '';
		if ($shippingAddress1 . $shippingAddress2 != '') {
			trim($customerData['deliveryAddress'] = trim($shippingAddress1 . " " . $shippingAddress2));
		}

		if (isset($addressDelivery->postcode) && $addressDelivery->postcode) {
			$customerData['deliveryZipCode'] = $addressDelivery->postcode;
		}

		if (isset($addressDelivery->city) && $addressDelivery->city) {
			$customerData['deliveryCity'] = $addressDelivery->city;
		}

		return $customerData;
	}


	private function setReferencia()
	{
		$payload = $this->getCustomerData();
		$payload["orderId"] = $this->orderId;
		$payload["amount"] = (string)$this->valor;
		$payload["returnUrl"] = $this->successUrl . '&orderId=' . $this->orderId;
		$payload["description"] = "Order {$this->orderId}";


		$this->cofidisRequest = $this->webservice->postRequest(
			'https://ifthenpay.com/api/cofidis/init/' . $this->cofidisKey,
			$payload,
			true
		)->getResponseJson();
	}

	private function getReferencia()
	{

		$this->setReferencia();
		$this->checkEstado();

		$this->dataBuilder->setPaymentMessage($this->cofidisRequest['message']);
		$this->dataBuilder->setPaymentUrl($this->cofidisRequest['paymentUrl']);
		$this->dataBuilder->setIdPedido($this->cofidisRequest['requestId']);
		$this->dataBuilder->setPaymentStatus($this->cofidisRequest['status']);

		return $this->dataBuilder;
	}

	public function buy()
	{
		$this->checkValue();
		return $this->getReferencia();
	}

}
