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

namespace PrestaShop\Module\Ifthenpay\Callback;

use PrestaShop\Module\Ifthenpay\Utility\Token;
use PrestaShop\Module\Ifthenpay\Utility\Status;
use PrestaShop\Module\Ifthenpay\Utility\Utility;
use PrestaShop\Module\Ifthenpay\Utility\TokenExtra;
use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;
use PrestaShop\Module\Ifthenpay\Factory\Request\RequestFactory;
use PrestaShop\Module\Ifthenpay\Contracts\Callback\CallbackProcessInterface;

if (!defined('_PS_VERSION_')) {
	exit;
}

class CallbackOnline extends CallbackProcess implements CallbackProcessInterface
{
	const CCARD = 'ccard';
	const COFIDISPAY = 'cofidispay';
	const CCARD_KEY = 'IFTHENPAY_CCARD_KEY';
	const COFIDIS_KEY = 'IFTHENPAY_COFIDIS_KEY';
	const COFIDIS_STATUS_INITIATED = 'INITIATED';
	const COFIDIS_STATUS_PENDING_INVOICE = 'PENDING_INVOICE';
	const COFIDIS_STATUS_CANCELED = 'CANCELED';
	const COFIDIS_ENDPOINT_STATUS = 'https://ifthenpay.com/api/cofidis/status/sandbox';
	private $ifthenpayModule;
	private $cart;
	private $customer;
	private $redirectUrl;

	private function setPaymentKey($paymentMethod)
	{
		switch ($paymentMethod) {
			case self::CCARD:
				return self::CCARD_KEY;
			case self::COFIDISPAY:
				return self::COFIDIS_KEY;
			default:
				throw new \Exception('Invalid payment method');
		}
	}
	private function setupContext()
	{
		$this->request['payment'] = $this->paymentMethod;
		$this->setPaymentData();
		$this->setOrder();

		if (empty($this->paymentData)) {
			$this->executePaymentNotFound();
		}

		$this->ifthenpayModule = \Module::getInstanceByName('ifthenpay');
		$this->cart = \Context::getContext()->cart;
		$this->customer = PrestashopModelFactory::buildCustomer((string) $this->cart->id_customer);
		$this->redirectUrl = \Context::getContext()->link->getPageLink('order-confirmation', true) .
			'?id_cart=' . $this->request['cartId'] . '&id_module=' . (int) $this->ifthenpayModule->id . '&id_order=' . $this->order->id . '&key=' .
			$this->customer->secure_key . '&paymentOption=' . $this->paymentMethod;
	}

	private function redirectUser($type, $message)
	{
		$controller = \Context::getContext()->controller;
		$notificationType = $type === 'success' ? 'success' : 'errors';

		$controller->$notificationType[] = $this->ifthenpayModule->l($message, pathinfo(__FILE__)['filename']);
		$controller->redirectWithNotifications($this->redirectUrl);
	}

	public function process()
	{
		try {
			$this->setupContext();
			$paymentStatus = Status::getTokenStatus(Token::decrypt($this->request['qn']));

			if ($this->paymentData['status'] === 'pending') {

				switch ($this->paymentMethod) {
					case self::CCARD:
						$this->processCcardPayment($paymentStatus);
						break;
					case self::COFIDISPAY:
						$this->processCofidisPayment($paymentStatus);
						break;
					default:
						throw new \Exception('Invalid payment method');
				}
			}
			if ($this->paymentData['status'] === 'cancel') {
				$this->redirectUser('cancel', $this->ifthenpayModule->l('Order has already been canceled by the customer', Utility::getClassName($this)));
				return;
			}
			if ($this->paymentData['status'] === 'error') {
				$this->redirectUser('error', sprintf($this->ifthenpayModule->l('Error processing %s payment', Utility::getClassName($this)), $this->ifthenpayModule->l($this->paymentMethod, 'ifthenpay')));
				return;
			}
			if ($this->paymentData['status'] === 'paid') {
				$this->redirectUser('error', $this->ifthenpayModule->l('Order has already been paid', Utility::getClassName($this)));
				return;
			}

		} catch (\Throwable $th) {
			$this->handleError($th);
		}
	}

	private function processCcardPayment($paymentStatus)
	{
		if ($paymentStatus === 'success') {
			if (
				$this->request['sk'] !== TokenExtra::encript(
					$this->request['id'] . $this->request['amount'] . $this->request['requestId'],
					\Configuration::get(
						$this->setPaymentKey($this->paymentMethod)
					)
				)
			) {
				throw new \Exception($this->ifthenpayModule->l('Invalid security token', Utility::getClassName($this)));
			}
			$orderTotal = floatval(Utility::convertPriceToEuros($this->order));
			$requestValor = floatval($this->request['amount']);

			if (round($orderTotal, 2) !== round($requestValor, 2)) {
				IfthenpayLogProcess::addLog('Payment value by ' . $this->paymentMethod . ' not valid - ' . print_r($_GET), IfthenpayLogProcess::ERROR, $this->order->id);
				\Context::getContext()->controller[] = sprintf($this->ifthenpayModule->l('Payment by %s not valid', Utility::getClassName($this)), $this->ifthenpayModule->l($this->paymentMethod, 'ifthenpay'));
				\Context::getContext()->controller->redirectWithNotifications($this->redirectUrl);
			}

			$this->changeIfthenpayPaymentStatus('paid');
			$this->changePrestashopOrderStatus(\Configuration::get('IFTHENPAY_' . \Tools::strtoupper($this->paymentMethod) . '_OS_CONFIRMED'));
			IfthenpayLogProcess::addLog('Payment by ' . $this->paymentMethod . ' made with success', IfthenpayLogProcess::INFO, $this->order->id);

			$this->redirectUser('success', sprintf($this->ifthenpayModule->l('Payment by %s made with success', Utility::getClassName($this)), $this->ifthenpayModule->l($this->paymentMethod, 'ifthenpay')));

		} else if ($paymentStatus === 'cancel') {
			$this->changeIfthenpayPaymentStatus('cancel');
			$this->changePrestashopOrderStatus(\Configuration::get('PS_OS_CANCELED'));
			IfthenpayLogProcess::addLog('Payment by ' . $this->paymentMethod . ' canceled by the customer', IfthenpayLogProcess::INFO, $this->order->id);
			$this->redirectUser('cancel', sprintf($this->ifthenpayModule->l('Payment by %s canceled', Utility::getClassName($this)), $this->ifthenpayModule->l($this->paymentMethod, 'ifthenpay')));
		} else {
			$this->changeIfthenpayPaymentStatus('error');
			$this->changePrestashopOrderStatus(\Configuration::get('PS_OS_ERROR'));

			// prepare error message
			$errorMsg = '{}';
			if (isset($this->request['error'])) {
				$errorData = Utility::extractArrayWithKeys($this->request, ['error', 'id', 'amount', 'requestId']);
				$errorMsg = Utility::dataToString($errorData);
			}
			$errorMsg = $errorMsg === '{}' ? 'error data not found' : $errorMsg;

			IfthenpayLogProcess::addLog("Error processing " . $this->paymentMethod . " payment - $errorMsg", IfthenpayLogProcess::INFO, $this->order->id);
			$this->redirectUser('error', sprintf($this->ifthenpayModule->l('Error processing %s payment', Utility::getClassName($this)), $this->ifthenpayModule->l($this->paymentMethod, 'ifthenpay')));
		}
	}

	private function processCofidisPayment($paymentStatus)
	{
		if ($paymentStatus !== 'success') {
			throw new \Exception($this->ifthenpayModule->l('Invalid security token', Utility::getClassName($this)));
		}
		if ($this->request['Success'] !== 'True') {
			sleep(1);
		}


		foreach ($this->getCofidisTransactionStatus() as $transactionStatus) {
			switch ($transactionStatus['statusCode']) {
				case self::COFIDIS_STATUS_INITIATED:
				case self::COFIDIS_STATUS_PENDING_INVOICE:
					IfthenpayLogProcess::addLog('Awaiting by ' . $this->paymentMethod . ' invoice', IfthenpayLogProcess::INFO, $this->order->id);
					$this->redirectUser('success', sprintf($this->ifthenpayModule->l('Payment by %s made with success', Utility::getClassName($this)), $this->ifthenpayModule->l($this->paymentMethod, 'ifthenpay')));

					break;
				case self::COFIDIS_STATUS_CANCELED:
					$this->changeIfthenpayPaymentStatus('cancel');
					$this->changePrestashopOrderStatus(\Configuration::get('PS_OS_CANCELED'));
					IfthenpayLogProcess::addLog('Payment by ' . $this->paymentMethod . ' canceled by the customer', IfthenpayLogProcess::INFO, $this->order->id);
					$this->redirectUser('cancel', sprintf($this->ifthenpayModule->l('Payment by %s canceled', Utility::getClassName($this)), $this->ifthenpayModule->l($this->paymentMethod, 'ifthenpay')));

					break;
				default:
					throw new \Exception($transactionStatus['statusCode'] . " status");
			}
		}
	}

	private function getCofidisTransactionStatus()
	{
		$webservice = RequestFactory::buildWebservice();
		return $webservice->postRequest(
			self::COFIDIS_ENDPOINT_STATUS,
			[
				"cofidisKey" => \Configuration::get($this->setPaymentKey($this->paymentMethod)),
				"requestId" => $this->paymentData['transaction_id']
			],
			true
		)->getResponseJson();
	}

	private function handleError(\Throwable $th)
	{
		$this->changeIfthenpayPaymentStatus('error');
		$this->changePrestashopOrderStatus(\Configuration::get('PS_OS_ERROR'));

		IfthenpayLogProcess::addLog('Error processing ' . $this->paymentMethod . ' callback - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, $this->order->id);
		$this->redirectUser('error', sprintf($this->ifthenpayModule->l('Error processing %s payment', Utility::getClassName($this)), $this->ifthenpayModule->l($this->paymentMethod, 'ifthenpay')));
	}
}
