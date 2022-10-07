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


namespace PrestaShop\Module\Ifthenpay\Builders;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Builders\DataBuilder;
use PrestaShop\Module\Ifthenpay\Contracts\Builders\SmartyDataBuilderInterface;

class SmartyDataBuilder extends DataBuilder implements SmartyDataBuilderInterface
{
    public function setShopName($value)
    {
        $this->data->shopName = $value;
        return $this;
    }

    public function setPaymentLogo($value)
    {
        $this->data->paymentLogo = $value;
        return $this;
    }

    public function setOrderId($value)
    {
        $this->data->orderId = $value;
        return $this;
    }

    public function setStatus($value)
    {
        $this->data->status = $value;
        return $this;
    }

    public function setUpdateControllerUrl($value)
    {
        $this->data->updateControllerUrl = $value;
        return $this;
    }

    public function setResendControllerUrl($value)
    {
        $this->data->resendControllerUrl = $value;
        return $this;
    }

    public function setRememberControllerUrl($value)
    {
        $this->data->rememberControllerUrl = $value;
        return $this;
    }

    public function setResendMbwayNotificationControllerUrl($value)
    {
        $this->data->resendMbwayNotificationControllerUrl = $value;
        return $this;
    }

    public function setChooseNewPaymentMethodControllerUrl($value)
    {
        $this->data->chooseNewPaymentMethodControllerUrl = $value;
        return $this;
    }

    public function setMbwayCountdownShow($value)
    {
        $this->data->mbwayCountdownShow = $value;
        return $this;
    }

    public function setCancelOrderImg($value)
    {
        $this->data->cancelOrderImg = $value;
        return $this;
    }

    public function setConfirmOrderImg($value)
    {
        $this->data->confirmOrderImg = $value;
        return $this;
    }

    public function setRefusedOrderImg($value)
    {
        $this->data->refusedOrderImg = $value;
        return $this;
    }

    public function setErrorOrderImg($value)
    {
        $this->data->errorOrderImg = $value;
        return $this;
    }

    public function setTimeoutImg($value)
    {
        $this->data->timeoutImg = $value;
        return $this;
    }

    public function setSpinnerImg($value)
    {
        $this->data->spinnerUrl = $value;
        return $this;
    }


    public function setMessage($value)
    {
        $this->data->message = $value;
        return $this;
    }
}
