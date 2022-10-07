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

use PrestaShop\Module\Ifthenpay\Payments\Payment;
use PrestaShop\Module\Ifthenpay\Builders\DataBuilder;
use PrestaShop\Module\Ifthenpay\Contracts\Payments\PaymentMethodInterface;

class Payshop extends Payment implements PaymentMethodInterface
{
    private $payshopKey;
    protected $validade;
    private $payshopPedido;

    public function __construct($data, $orderId, $valor)
    {
        parent::__construct($orderId, $valor);
        $this->payshopKey = $data->getData()->payshopKey;
        $this->validade = $this->makeValidade($data->getData()->validade);
    }

    private function makeValidade($validade)
    {

        if ($validade === '0' || $validade === '') {
            return '';
        }
        return (new \DateTime(date("Ymd")))->modify('+' . $validade . 'day')
            ->format('Ymd');
    }

    public function checkValue()
    {
        if ($this->valor < 0) {
            throw new \Exception('Payshop does not allow payments of 0€');
        }
    }

    private function checkEstado()
    {
        if ($this->payshopPedido['Code'] !== '0') {
            throw new \Exception($this->payshopPedido['Message']);
        }
    }

    private function setReferencia()
    {
        $this->payshopPedido = $this->webservice->postRequest(
            'https://ifthenpay.com/api/payshop/reference/',
            [
                    'payshopkey' => $this->payshopKey,
                    'id' => $this->orderId,
                    'valor' => $this->valor,
                    'validade' => $this->validade,
                ],
            true
        )->getResponseJson();
    }

    private function getReferencia()
    {
        $this->setReferencia();
        $this->checkEstado();

        $this->dataBuilder->setIdPedido($this->payshopPedido['RequestId']);
        $this->dataBuilder->setReferencia($this->payshopPedido['Reference']);
        $this->dataBuilder->setTotalToPay((string)$this->valor);
        $this->dataBuilder->setValidade($this->validade);
        return $this->dataBuilder;
    }

    public function buy()
    {
        $this->checkValue();
        return $this->getReferencia();
    }
}
