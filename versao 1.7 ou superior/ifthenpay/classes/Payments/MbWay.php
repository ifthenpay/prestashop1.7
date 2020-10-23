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

use PrestaShop\Module\Ifthenpay\Payments\Payment;
use PrestaShop\Module\Ifthenpay\Builders\DataBuilder;
use PrestaShop\Module\Ifthenpay\Builders\GatewayDataBuilder;
use PrestaShop\Module\Ifthenpay\Contracts\Payments\PaymentMethodInterface;

class MbWay extends Payment implements PaymentMethodInterface
{
    private $mbwayKey;
    private $telemovel;
    private $mbwayPedido;
    /**
    * @param GatewayDataBuilder $data, @param string $orderId, @param $valor
    */
    public function __construct($data, $orderId, $valor)
    {
        parent::__construct($orderId, $valor);
        $this->mbwayKey = $data->getData()->mbwayKey;
        $this->telemovel = $data->getData()->telemovel;
    }
    /**
    * Check if mbway payment value is valid
    *@return void
    */
    public function checkValue()
    {
        if ($this->valor < 0.10) {
            throw new Exception('Mbway does not allow payments under 0.10€');
        }
    }
    /**
    * Check if mbway estado is valid
    *@return void
    */
    private function checkEstado()
    {
        if ($this->mbwayPedido['Estado'] !== '000') {
            throw new Exception($this->mbwayPedido['MsgDescricao']);
        }
    }
    /**
    * Send request to ifthenpay webservice to process mbway payment
    *@return void
    */
    private function setReferencia()
    {
        $this->mbwayPedido = $this->webservice->postRequest(
            'https://ifthenpay.com/mbwayws/IfthenPayMBW.asmx/SetPedidoJSON',
            [
                    'MbWayKey' => $this->mbwayKey,
                    'canal' => '03',
                    'referencia' => $this->orderId,
                    'valor' => $this->valor,
                    'nrtlm' => $this->telemovel,
                    'email' => '',
                    'descricao' => '',
                ]
        )->getResponseJson();
    }
    /**
    * Get mbway payment data
    *@return DataBuilder
    */
    private function getReferencia()
    {
        $this->setReferencia();
        $this->checkEstado();
        $this->dataBuilder->setIdPedido($this->mbwayPedido['IdPedido']);
        $this->dataBuilder->setTelemovel($this->telemovel);
        $this->dataBuilder->setTotalToPay((string)$this->valor);
        return $this->dataBuilder;
    }
    /**
    * Main method to execute mbway payment
    *@return DataBuilder
    */
    public function buy()
    {
        $this->checkValue();
        return $this->getReferencia();
    }
}
