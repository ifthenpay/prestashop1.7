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
use PrestaShop\Module\Ifthenpay\Factory\Models\IfthenpayModelFactory;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CallbackProcess
{
    protected $paymentMethod;
    protected $paymentData;
    protected $order;
    protected $request;

	    
    /**
     * Set the value of paymentMethod
     *
     * @return  self
     */ 
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Set the value of paymentData
     *
     * @return  self
     */ 
    protected function setPaymentData()
    {
        $this->paymentData = CallbackFactory::buildCalllbackData($_GET)->execute();

    }

    /**
     * Set the value of order
     *
     * @return  self
     */ 
    protected function setOrder()
    {
        $this->order = PrestashopModelFactory::buildOrder($this->paymentData['order_id']);
    }

    protected function executePaymentNotFound()
    {
        IfthenpayLogProcess::addLog('Callback Payment not found - ' . print_r($_GET, 1), IfthenpayLogProcess::ERROR, $this->order->id);
        http_response_code(404);
        die('Pagamento não encontrado');
    }

    protected function changeIfthenpayPaymentStatus($status)
    {
        $ifthenpayModel = IfthenpayModelFactory::build($this->paymentMethod, $this->paymentData['id_ifthenpay_' . $this->paymentMethod]);

        //WORKAROUND: odd behaviour from prestashop model object, it loses the requestId of the order for Ccard, so there is a need to set it in the next two lines
        if($this->paymentMethod == 'ccard' && isset($this->paymentData['requestId'])){
            $ifthenpayModel->requestId = $this->paymentData['requestId'];		
        }
        $ifthenpayModel->status = $status;
        $ifthenpayModel->update();
    }

    protected function changePrestashopOrderStatus($statusId)
    {
        $new_history = PrestashopModelFactory::buildOrderHistory();
        $new_history->id_order = (int) $this->order->id;
        $new_history->changeIdOrderState((int) $statusId, (int) $this->order->id);
        $new_history->addWithemail(true);
    }

    /**
     * Set the value of request
     *
     * @return  self
     */ 
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }   
}