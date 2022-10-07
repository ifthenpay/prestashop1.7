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

if (!defined('_PS_VERSION_')) {
    exit;
}

class CallbackOffline extends CallbackProcess implements CallbackProcessInterface
{
    public function process()
    {
        $this->request['payment'] = $this->paymentMethod;
        
        $this->setPaymentData();
        
        if (empty($this->paymentData)) {
            $this->executePaymentNotFound();
        } else {
            try {
                $this->setOrder();
                CallbackFactory::buildCalllbackValidate($_GET, $this->order, \Configuration::get('IFTHENPAY_' . \Tools::strtoupper($this->paymentMethod) . '_CHAVE_ANTI_PHISHING'), $this->paymentData)
                ->validate();
                IfthenpayLogProcess::addLog('Callback received and validated with success for payment method ' . $this->paymentMethod, IfthenpayLogProcess::INFO, $this->order->id);
                $this->changeIfthenpayPaymentStatus('paid');
                $this->changePrestashopOrderStatus(\Configuration::get('IFTHENPAY_' . \Tools::strtoupper($this->paymentMethod) . '_OS_CONFIRMED'));
                IfthenpayLogProcess::addLog('Order status change with success to paid (after receiving callback)', IfthenpayLogProcess::INFO, $this->order->id);
                http_response_code(200);
                die('ok');           
            } catch (\Throwable $th) {
                IfthenpayLogProcess::addLog('Error processing callback - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, $this->order->id);
                http_response_code(400);
                die($th->getMessage());
            }
        }
    }
}
