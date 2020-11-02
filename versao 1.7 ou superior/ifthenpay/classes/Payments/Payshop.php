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


namespace PrestaShop\Module\Ifthenpay\Payments;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DateTime;
use PrestaShop\Module\Ifthenpay\Payments\Payment;
use PrestaShop\Module\Ifthenpay\Builders\DataBuilder;
use PrestaShop\Module\Ifthenpay\Builders\GatewayDataBuilder;
use PrestaShop\Module\Ifthenpay\Contracts\Payments\PaymentMethodInterface;

class Payshop extends Payment implements PaymentMethodInterface
{
    private $payshopKey;
    protected $validade;
    private $payshopPedido;
    /**
    *@param GatewayDataBuilder $data, @param string $orderId, @param string $valor
    */
    public function __construct($data, $orderId, $valor)
    {
        parent::__construct($orderId, $valor);
        $this->payshopKey = $data->getData()->payshopKey;
        $this->validade = $this->makeValidade($data->getData()->validade);
    }
    /**
    * Set payshop referencia validade
    *@param string $validade
    *@return string
    */
    private function makeValidade($validade)
    {

        if ($validade === '0' || $validade === '') {
            return '';
        }
        return (new DateTime(date("Ymd")))->modify('+' . $this->validade['value'] . 'day')
            ->format('Ymd');
    }
    /**
    * Check if payshop payment value is valid
    *@return void
    */
    public function checkValue()
    {
        if ($this->valor < 0) {
            throw new \Exception('Payshop does not allow payments of 0€');
        }
    }
    /**
    * Check if payshop estado is valid
    *@return void
    */
    private function checkEstado()
    {
        if ($this->payshopPedido['Code'] !== '0') {
            throw new \Exception($this->payshopPedido['Message']);
        }
    }
    /**
    * Send request to ifthenpay webservice to process payshop payment
    *@return void
    */
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
    /**
    * Get payshop referencia data
    *@return DataBuilder
    */
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
    /**
    * Main method to execute payshop payment
    *@return DataBuilder
    */
    public function buy()
    {
        $this->checkValue();
        return $this->getReferencia();
    }
}
