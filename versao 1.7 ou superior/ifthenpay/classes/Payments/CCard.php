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

use PrestaShop\Module\Ifthenpay\Builders\DataBuilder;
use PrestaShop\Module\Ifthenpay\Builders\GatewayDataBuilder;
use PrestaShop\Module\Ifthenpay\Contracts\Payments\PaymentMethodInterface;
use PrestaShop\PrestaShop\Adapter\Entity\Language;

if (!defined('_PS_VERSION_')) {
    exit;
}


class CCard extends Payment implements PaymentMethodInterface
{
    private $ccardKey;
    private $ccardPedido;
    private $successUrl;
    private $errorUrl;
    private $cancelUrl;

    public function __construct($data, $orderId, $valor)
    {
        parent::__construct($orderId, $valor);
        $this->ccardKey = $data->getData()->ccardKey;
        $this->successUrl = $data->getData()->successUrl;
        $this->errorUrl = $data->getData()->errorUrl;
        $this->cancelUrl = $data->getData()->cancelUrl;
    }

    public function checkValue()
    {
        //void
    }

    private function checkEstado()
    {
        if ($this->ccardPedido['Status'] !== '0') {
            throw new \Exception($this->ccardPedido['Message']);
        }
    }

    private function setReferencia()
    {
        $context = \Context::getContext();
        $langId = $context->cookie->id_lang;
        $langObj = \Language::getLanguage((int) $langId);
        $langIsoCode = isset($langObj['iso_code']) ? $langObj['iso_code'] : 'en';


        $this->ccardPedido = $this->webservice->postRequest(
            'https://ifthenpay.com/api/creditcard/init/' . $this->ccardKey,
            [
                "orderId" => $this->orderId,
                "amount" => $this->valor,
                "successUrl" => $this->successUrl,
                "errorUrl" => $this->errorUrl,
                "cancelUrl" => $this->cancelUrl,
                "language" => $langIsoCode
            ],
            true
        )->getResponseJson();
    }

    private function getReferencia()
    {

        $this->setReferencia();
        $this->checkEstado();

        $this->dataBuilder->setPaymentMessage($this->ccardPedido['Message']);
        $this->dataBuilder->setPaymentUrl($this->ccardPedido['PaymentUrl']);
        $this->dataBuilder->setIdPedido($this->ccardPedido['RequestId']);
        $this->dataBuilder->setPaymentStatus($this->ccardPedido['Status']);

        return $this->dataBuilder;
    }

    public function buy()
    {
        return $this->getReferencia();
    }
}
