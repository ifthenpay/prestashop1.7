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

use PrestaShop\Module\Ifthenpay\Utility\Token;
use PrestaShop\Module\Ifthenpay\Utility\Status;
use PrestaShop\Module\Ifthenpay\Utility\Utility;
use PrestaShop\Module\Ifthenpay\Utility\TokenExtra;
use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;
use PrestaShop\Module\Ifthenpay\Contracts\Callback\CallbackProcessInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CallbackOnline extends CallbackProcess implements CallbackProcessInterface
{
    private function redirectUser($type, $ifthenpayModule, $redirectUrl, $message)
    {
        if ($type === 'success') {
            \Context::getContext()->controller->success[] = $ifthenpayModule->l($message, pathinfo(__FILE__)['filename']);
        } else {
            \Context::getContext()->controller->errors[] = $ifthenpayModule->l($message,  Utility::getClassName($this));
        }
        \Context::getContext()->controller->redirectWithNotifications($redirectUrl);
    }
    
    public function process()
    {
        $this->setPaymentData();

        if (empty($this->paymentData)) {
            $this->executePaymentNotFound();
        } else {
            try {
                $ifthenpayModule = \Module::getInstanceByName('ifthenpay');
                $cart = \Context::getContext()->cart;
                $customer = PrestashopModelFactory::buildCustomer((string) $cart->id_customer);
                $this->setOrder();
                $redirectUrl = \Context::getContext()->link->getPageLink('order-confirmation', true) .
                '?id_cart=' . $this->request['cartId'] . '&id_module=' . (int)$ifthenpayModule->id . '&id_order=' . $this->order->id . '&key='.
                $customer->secure_key . '&paymentOption=ccard';
                if ($this->paymentData['status'] === 'pending') {
                    $paymentStatus = Status::getTokenStatus(
                        Token::decrypt($this->request['qn'])
                    );
                    if ($paymentStatus === 'success') {
                        if ($this->request['sk'] !== TokenExtra::encript(
                            $this->request['id'] . $this->request['amount'] . $this->request['requestId'], \Configuration::get('IFTHENPAY_CCARD_KEY'))) {
                                throw new \Exception($ifthenpayModule->l('Invalid security token',  Utility::getClassName($this)));
                        }
                        $orderTotal = floatval(Utility::convertPriceToEuros($this->order));
                        $requestValor = floatval($this->request['amount']);
                        if (round($orderTotal, 2) !== round($requestValor, 2)) {
                            IfthenpayLogProcess::addLog('Payment value by credit card not valid - ' . print_r($_GET), IfthenpayLogProcess::ERROR, $this->order->id);
                            \Context::getContext()->controller[] = $ifthenpayModule->l('Payment by credit card not valid',  Utility::getClassName($this));
                            \Context::getContext()->controller->redirectWithNotifications($redirectUrl);
                        }
                        $this->changeIfthenpayPaymentStatus('paid');
                        $this->changePrestashopOrderStatus(\Configuration::get('IFTHENPAY_' . \Tools::strtoupper($this->paymentMethod) . '_OS_CONFIRMED'));
                        IfthenpayLogProcess::addLog('Payment by credit card made with success', IfthenpayLogProcess::INFO, $this->order->id);
                        $this->redirectUser('success', $ifthenpayModule, $redirectUrl, $ifthenpayModule->l('Payment by credit card made with success',  Utility::getClassName($this)));     
                    } else if($paymentStatus === 'cancel') {
                        $this->changeIfthenpayPaymentStatus('cancel');
                        $this->changePrestashopOrderStatus(\Configuration::get('PS_OS_CANCELED'));
                        IfthenpayLogProcess::addLog('Payment by credit card canceled by the client', IfthenpayLogProcess::INFO, $this->order->id);
                        $this->redirectUser('cancel', $ifthenpayModule, $redirectUrl, $ifthenpayModule->l('Payment by credit card canceled',  Utility::getClassName($this)));
                    } else {
                        $this->changeIfthenpayPaymentStatus('error');
                        $this->changePrestashopOrderStatus(\Configuration::get('PS_OS_ERROR'));
                        IfthenpayLogProcess::addLog('Error processing credit card payment', IfthenpayLogProcess::INFO, $this->order->id);
                        $this->redirectUser('error', $ifthenpayModule, $redirectUrl, $ifthenpayModule->l('Error processing credit card payment',  Utility::getClassName($this)));
                    }
                } else if ($this->paymentData['status'] === 'cancel') {
                    $this->redirectUser('cancel', $ifthenpayModule, $redirectUrl, $ifthenpayModule->l('Order has already been canceled by the customer',  Utility::getClassName($this)));
                } else if ($this->paymentData['status'] === 'error') {
                    $this->redirectUser('error', $ifthenpayModule, $redirectUrl, $ifthenpayModule->l('Error processing credit card payment',  Utility::getClassName($this)));
                } else {
                    $this->redirectUser('error', $ifthenpayModule, $redirectUrl, $ifthenpayModule->l('Order has already been paid',  Utility::getClassName($this)));
                }
            } catch (\Throwable $th) {
                $this->changeIfthenpayPaymentStatus('error');
                $this->changePrestashopOrderStatus(\Configuration::get('PS_OS_ERROR'));
                IfthenpayLogProcess::addLog('Error processing credit card callback - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, $this->order->id);
                $this->redirectUser('error', $ifthenpayModule, $redirectUrl, $ifthenpayModule->l('Error processing credit card payment',  Utility::getClassName($this)));
            }
        }
    }
}
