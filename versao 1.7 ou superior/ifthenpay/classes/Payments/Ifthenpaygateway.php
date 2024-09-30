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

namespace PrestaShop\Module\Ifthenpay\Payments;

if (!defined('_PS_VERSION_')) {
	exit;
}

use PrestaShop\Module\Ifthenpay\Payments\Payment as MasterPayment;
use PrestaShop\Module\Ifthenpay\Contracts\Payments\PaymentMethodInterface;
use PrestaShop\Module\Ifthenpay\Utility\Status;
use PrestaShop\Module\Ifthenpay\Utility\Time;
use PrestaShop\Module\Ifthenpay\Utility\Token;

class Ifthenpaygateway extends MasterPayment implements PaymentMethodInterface
{
	private $key;
	private $selectableMethods;
	private $defaultMethod;
	private $deadline;
	private $ifthenpaygatewayPedido;


	public function __construct($data, $orderId, $valor)
	{
		parent::__construct($orderId, $valor);

		$this->key = $data->getData()->key;
		$this->selectableMethods = json_decode($data->getData()->selectableMethods, true) ?? [];
		$this->defaultMethod = $data->getData()->defaultMethod;
		if (isset($data->getData()->deadline)) {
			$this->deadline = Time::dateAfterDays($data->getData()->deadline);
		}
	}

	public function checkValue()
	{
		if ($this->valor >= 1000000) {
			throw new \Exception('Invalid Ifthenpaygateway value, above 999999€');
		}
	}




	private function requestIfthenpaygatewayLink(): void
	{
		$context = \Context::getContext();
		$langId = $context->cookie->id_lang;
		$langObj = \Language::getLanguage((int) $langId);
		$langIsoCode = isset($langObj['iso_code']) ? $langObj['iso_code'] : 'en';
		$langIsoCode = $langIsoCode == 'gb' ? 'en' : $langIsoCode;

		$methodsStr = '';
		foreach ($this->selectableMethods as $key => $value) {
			if ($value != null && $value['is_active'] === '1') {

				$methodsStr .= str_replace(' ', '', $value['account']) . ';';
			}
		}

		$baseCallbackUrl = \Context::getContext()->link->getModuleLink('ifthenpay', 'callback', array(), true);

		// TODO: PAYMENT URLS
		$btnCloseUrl = $baseCallbackUrl . '?type=online&p=ifthenpaygateway&cartId=' . \Tools::getValue('id_cart') . '&oid=' . \Tools::getValue('id_order') . '&qn=' . Token::encrypt(Status::getStatusPending()); // return to store with pending status
		$successUrl = $baseCallbackUrl . '?type=online&p=ifthenpaygateway&cartId=' . \Tools::getValue('id_cart') . '&oid=' . \Tools::getValue('id_order') . '&qn=' . Token::encrypt(Status::getStatusSucess());
		$cancelUrl = $baseCallbackUrl . '?type=online&p=ifthenpaygateway&cartId=' . \Tools::getValue('id_cart') . '&oid=' . \Tools::getValue('id_order') . '&qn=' . Token::encrypt(Status::getStatusCancel());
		$errorUrl = $baseCallbackUrl . '?type=online&p=ifthenpaygateway&cartId=' . \Tools::getValue('id_cart') . '&oid=' . \Tools::getValue('id_order') . '&qn=' . Token::encrypt(Status::getStatusError());



		$payload = [
			'id' => $this->orderId,
			"amount" => (string)$this->valor,
			"description" => 'Prestashop order #' . $this->orderId,
			"lang" => $langIsoCode,
			"expiredate" => $this->deadline,
			"accounts" => $methodsStr,
			"selected_method" => $this->defaultMethod,
			"btnCloseUrl" => $btnCloseUrl,
			"success_url" => $successUrl,
			"cancel_url" => $cancelUrl,
			"error_url" => $errorUrl,
		];

		$btnCloseLabel = \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_CLOSE_BTN');
		if ($baseCallbackUrl != '') {
			$payload['btnCloseLabel'] = $btnCloseLabel;
		}


		$this->ifthenpaygatewayPedido = $this->webservice->PostRequest(
			'https://api.ifthenpay.com/gateway/pinpay/' . $this->key,
			$payload,
			true
		)->getResponseJson();
	}

	private function checkStatus(): void
	{
		if ($this->ifthenpaygatewayPedido['PinCode'] === null) {
			throw new \Exception('Invalid gateway request');
		}
	}


	private function getGatewayLink()
	{
		$this->requestIfthenpaygatewayLink();

		$this->checkStatus();

		$this->dataBuilder->setKey($this->key);

		if ($this->deadline) {
			$this->dataBuilder->setDeadline($this->deadline);
		}
		$this->dataBuilder->setPaymentUrl($this->ifthenpaygatewayPedido['RedirectUrl']);
		$this->dataBuilder->setTotalToPay((string)$this->valor);
		return $this->dataBuilder;
	}

	public function buy()
	{
		$this->checkValue($this->valor);
		return $this->getGatewayLink();
	}
}
