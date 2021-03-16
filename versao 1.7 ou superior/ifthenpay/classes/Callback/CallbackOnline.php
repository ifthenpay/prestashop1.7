<?php
/**
 * 2007-2020 Ifthenpay Lda
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
 * @copyright 2007-2020 Ifthenpay Lda
 * @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\Ifthenpay\Callback;

use PrestaShop\Module\Ifthenpay\Utility\Token;
use PrestaShop\Module\Ifthenpay\Utility\Status;
use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;
use PrestaShop\Module\Ifthenpay\Contracts\Callback\CallbackProcessInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CallbackOnline extends CallbackProcess implements CallbackProcessInterface
{
        
    public function process()
    {
        $this->setPaymentData();

        if (empty($this->paymentData)) {
            $this->executePaymentNotFound();
        } else {
            try {
                $paymentStatus = Status::getTokenStatus(
                    Token::decrypt($this->request['qn'])
                );
                $ifthenpayModule = \Module::getInstanceByName('ifthenpay');
                $cart = \Context::getContext()->cart;
                $customer = PrestashopModelFactory::buildCustomer((string) $cart->id_customer);
                $this->setOrder();
                $redirectUrl = \Context::getContext()->link->getPageLink('order-confirmation', true) .
                '?id_cart=' . $this->request['cartId'] . '&id_module=' . (int)$ifthenpayModule->id . '&id_order=' . $this->order->id . '&key='.
                $customer->secure_key . '&paymentOption=ccard';

                if ($paymentStatus === 'success') {
                    
                    $orderTotal = floatval($this->order->getOrdersTotalPaid());
                    $requestValor = floatval($this->request['amount']);
                    if (round($orderTotal, 2) !== round($requestValor, 2)) {
                        IfthenpayLogProcess::addLog('Payment value by credit card not valid - ' . print_r($_GET, 1), IfthenpayLogProcess::ERROR, $this->order->id);
                        \Context::getContext()->controller[] = $ifthenpayModule->l('Payment by credit card not valid');
                        \Context::getContext()->controller->redirectWithNotifications($redirectUrl);
                    }
                    $this->changeIfthenpayPaymentStatus('paid');
                    $new_history = PrestashopModelFactory::buildOrderHistory();
                    $new_history->id_order = (int) $this->order->id;
                    $new_history->changeIdOrderState((int) \Configuration::get('IFTHENPAY_' . \Tools::strtoupper($this->paymentMethod) . '_OS_CONFIRMED'), (int) $this->order->id);
                    $new_history->addWithemail(true);
                    IfthenpayLogProcess::addLog('Payment by credit card made with success', IfthenpayLogProcess::INFO, $this->order->id);
                    \Context::getContext()->controller->success[] = $ifthenpayModule->l('Payment by credit card made with success');
                    \Context::getContext()->controller->redirectWithNotifications($redirectUrl);           
                } else if($paymentStatus === 'cancel') {
                    $this->changeIfthenpayPaymentStatus('cancel');
                    $new_history = PrestashopModelFactory::buildOrderHistory();
                    $new_history->id_order = (int) $this->order->id;
                    $new_history->changeIdOrderState((int) \Configuration::get('PS_OS_CANCELED'), (int) $this->order->id);
                    $new_history->addWithemail(true);
                    IfthenpayLogProcess::addLog('Payment by credit card canceled by the client', IfthenpayLogProcess::INFO, $this->order->id);
                    \Context::getContext()->controller->errors[] = $ifthenpayModule->l('Payment by credit card canceled');
                    \Context::getContext()->controller->redirectWithNotifications($redirectUrl); 
                } else {
                    $this->changeIfthenpayPaymentStatus('error');
                    $new_history = PrestashopModelFactory::buildOrderHistory();
                    $new_history->id_order = (int) $this->order->id;
                    $new_history->changeIdOrderState((int) \Configuration::get('PS_OS_ERROR'), (int) $this->order->id);
                    $new_history->addWithemail(true);
                    IfthenpayLogProcess::addLog('Error processing credit card payment', IfthenpayLogProcess::INFO, $this->order->id);
                    \Context::getContext()->controller->errors[] = $ifthenpayModule->l('Error processing credit card payment');
                    \Context::getContext()->controller->redirectWithNotifications($redirectUrl);  
                }

            } catch (\Throwable $th) {
                IfthenpayLogProcess::addLog('Error processing credit card callback - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, $this->order->id);
                \Context::getContext()->controller->errors[] = $th->getMessage();
                \Context::getContext()->controller->redirectWithNotifications($redirectUrl); 
            }
        }
    }
}
