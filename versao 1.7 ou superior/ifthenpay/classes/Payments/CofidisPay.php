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
use PrestaShop\PrestaShop\Adapter\Entity\Language;
use PrestaShop\Module\Ifthenpay\Utility\Token;
use PrestaShop\Module\Ifthenpay\Utility\Status;
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

	private function setReferencia()
	{
		$context = \Context::getContext();
		$customer = $context->customer;
		$langId = $context->cookie->id_lang;
		$langObj = \Language::getLanguage((int) $langId);
		$langIsoCode = isset($langObj['iso_code']) ? $langObj['iso_code'] : 'en';

		$addressDelivery = new \Address($context->cart->id_address_delivery);
		$addressInvoice = new \Address($context->cart->id_address_invoice);

		$this->cofidisRequest = $this->webservice->postRequest(
			'https://ifthenpay.com/api/cofidis/init/' . $this->cofidisKey,
			[
				"orderId" => $this->orderId,
				"amount" => $this->valor,
				"returnUrl" => $this->successUrl . '&orderId=' . $this->orderId,
				"description" => "Order $this->orderId",
				"customerName" => $customer->firstname . ' ' . $customer->lastname,
				"customerVat" => $addressInvoice->vat_number,
				"customerEmail" => $customer->email,
				"customerPhone" => $addressInvoice->phone_mobile,
				"billingAddress" => $addressInvoice->address1 . " " . $addressInvoice->address2,
				"billingZipCode" => $addressInvoice->postcode,
				"billingCity" => $addressInvoice->city,
				"deliveryAddress" => $addressDelivery->address1 . " " . $addressDelivery->address2,
				"deliveryZipCode" => $addressDelivery->postcode,
				"deliveryCity" => $addressDelivery->city,
			],
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
