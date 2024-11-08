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

use PrestaShop\Module\Ifthenpay\Contracts\Payments\PaymentMethodInterface;
use PrestaShop\Module\Ifthenpay\Models\IfthenpayTempPix;

if (!defined('_PS_VERSION_')) {
	exit;
}


class Pix extends Payment implements PaymentMethodInterface
{
	private $pixKey;
	private $pixPedido;
	private $successUrl;

	public function __construct($data, $orderId, $valor)
	{
		parent::__construct($orderId, $valor);
		$this->pixKey = $data->getData()->pixKey;
		$this->successUrl = $data->getData()->successUrl;
	}

	public function checkValue()
	{
		//void
	}

	private function checkEstado()
	{
		if ($this->pixPedido['status'] !== '0') {
			throw new \Exception($this->pixPedido['message']);
		}
	}


	private function setReferencia()
	{
		$cartId = \Tools::getValue('id_cart');
		$payload = IfthenpayTempPix::dataArrayFromDbByCartId($cartId);

		$payload["orderId"] = $this->orderId;
		$payload["amount"] = (string)$this->valor;
		$payload["redirectUrl"] = $this->successUrl . '&orderId=' . $this->orderId;
		$payload["description"] = "Order {$this->orderId}";

		try {

			$this->pixPedido = $this->webservice->postRequest(
				'https://api.ifthenpay.com/pix/init/' . $this->pixKey,
				$payload,
				true
			)->getResponseJson();
		} catch (\Throwable $th) {
			throw $th;
		}
	}




	private function getReferencia()
	{

		$this->setReferencia();
		$this->checkEstado();

		$this->dataBuilder->setPaymentMessage($this->pixPedido['message']);
		$this->dataBuilder->setPaymentUrl($this->pixPedido['paymentUrl']);
		$this->dataBuilder->setIdPedido($this->pixPedido['requestId']);
		$this->dataBuilder->setPaymentStatus($this->pixPedido['status']);

		return $this->dataBuilder;
	}

	public function buy()
	{
		return $this->getReferencia();
	}
}
