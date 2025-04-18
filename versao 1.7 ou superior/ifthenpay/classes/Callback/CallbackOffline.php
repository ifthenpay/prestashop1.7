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

namespace PrestaShop\Module\Ifthenpay\Callback;

use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;
use PrestaShop\Module\Ifthenpay\Factory\Callback\CallbackFactory;
use PrestaShop\Module\Ifthenpay\Contracts\Callback\CallbackProcessInterface;
use PrestaShop\Module\Ifthenpay\Callback\CallbackVars as Cb;


if (!defined('_PS_VERSION_')) {
	exit;
}

class CallbackOffline extends CallbackProcess implements CallbackProcessInterface
{
	public function process()
	{
		$this->request[Cb::PAYMENT] = $this->paymentMethod;

		// get the callback payment method to use the correct phish key
		$originalPaymentMethod = $this->paymentMethod;

		$this->setPaymentData();

		// if no payment data is set, search other payment methods
		if (empty($this->paymentData)) {
			if ($this->paymentMethod === 'ifthenpaygateway') {

				$methodsWithCallback = ['multibanco', 'mbway', 'payshop', 'ccard', 'cofidispay', 'ifthenpaygateway', 'pix'];

				// search every active payment method tables
				foreach ($methodsWithCallback as $paymentMethod) {
					$isActive = \Configuration::get('IFTHENPAY_' . strtoupper($this->paymentMethod));

					if ($isActive == '1') {
						$this->request[Cb::PAYMENT] = $paymentMethod;
						$this->setPaymentData();
						if (!empty($this->paymentData)) {
							// set the correct payment method
							$this->paymentMethod = $paymentMethod;
							break;
						}
					}
				}
			} else {

				$isActive = \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY');

				if ($isActive == '1') {
					// search the ifthenpaygateway table
					$this->request[Cb::PAYMENT] = 'ifthenpaygateway';
					$this->setPaymentData();
					if (!empty($this->paymentData)) {
						// set the correct payment method
						$this->paymentMethod = 'ifthenpaygateway';
					}
				}
			}
		}

		if (empty($this->paymentData)) {
			$this->executePaymentNotFound();
		} else {

			try {
				$this->setOrder();
				CallbackFactory::buildCalllbackValidate($_GET, $this->order, \Configuration::get('IFTHENPAY_' . \Tools::strtoupper($originalPaymentMethod) . '_CHAVE_ANTI_PHISHING'), $this->paymentData)
					->validate();
				IfthenpayLogProcess::addLog('Callback received and validated with success for payment method ' . $this->paymentMethod, IfthenpayLogProcess::INFO, $this->order->id);

				$this->changeIfthenpayPaymentStatus('paid');

				$splitOrders = $this->getSplitOrders($this->order->reference, $this->order->id_cart);
				if (count($splitOrders) > 1) {
					// update status for split orders
					foreach ($splitOrders as $order) {

						if (!isset($order['id_order'])) {
							IfthenpayLogProcess::addLog('Error processing callback for split orders - prestashop db order property id_order is not set.', IfthenpayLogProcess::ERROR, $this->order->id);
							http_response_code(400);
						}

						$this->changePrestashopOrderStatusByOrderId(\Configuration::get('IFTHENPAY_' . \Tools::strtoupper($this->paymentMethod) . '_OS_CONFIRMED'), $order['id_order']);
						IfthenpayLogProcess::addLog('Split Order status change with success to paid (after receiving callback)', IfthenpayLogProcess::INFO, $order['id_order']);
					}
				} else {
					// update status of single order
					$this->changePrestashopOrderStatus(\Configuration::get('IFTHENPAY_' . \Tools::strtoupper($this->paymentMethod) . '_OS_CONFIRMED'));
					IfthenpayLogProcess::addLog('Order status change with success to paid (after receiving callback)', IfthenpayLogProcess::INFO, $this->order->id);
				}

				if (isset($_GET['test']) && $_GET['test'] === 'true') {
					http_response_code(200);

					$ifthenpayModule = \Module::getInstanceByName('ifthenpay');

					$response = [
						'status' => 'success',
						'message' => $ifthenpayModule->l('Callback received and validated with success for payment method ', pathinfo(__FILE__)['filename']) . $this->paymentMethod
					];
					die(json_encode($response));
				}

				http_response_code(200);
				die('ok');
			} catch (\Throwable $th) {

				if (isset($_GET['test']) && $_GET['test'] === 'true') {
					http_response_code(200);

					$response = [
						'status' => 'warning',
						'message' => $th->getMessage(),
					];


					die(json_encode($response));
				}

				IfthenpayLogProcess::addLog('Error processing callback - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, $this->order->id);
				http_response_code(400);
				die($th->getMessage());
			}
		}
	}
}
