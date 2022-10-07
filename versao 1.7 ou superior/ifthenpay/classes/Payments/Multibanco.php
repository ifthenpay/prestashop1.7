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

use PrestaShop\Module\Ifthenpay\Payments\Payment as MasterPayment;
use PrestaShop\Module\Ifthenpay\Contracts\Payments\PaymentMethodInterface;

class Multibanco extends MasterPayment implements PaymentMethodInterface
{
    const DYNAMIC_MB_ENTIDADE = 'MB';
    private $entidade;
    private $subEntidade;
    private $validade;
    private $multibancoPedido;
    

    public function __construct($data, $orderId, $valor)
    {
        parent::__construct($orderId, $valor);
        $this->entidade = $data->getData()->entidade;
        $this->subEntidade = $data->getData()->subEntidade;
        if (isset($data->getData()->validade)) {
            $this->validade = $data->getData()->validade;
        }
    }

    public function checkValue()
    {
        if ($this->valor >= 1000000) {
            throw new \Exception('Invalid Multibanco value, above 999999€');
        }
    }


    private function checkEstado(): void
    {
        if ($this->multibancoPedido['Status'] !== '0') {
            throw new \Exception($this->multibancoPedido['Message']);
        }
    }

    private function setDynamicReferencia(): void
    {
        $this->multibancoPedido = $this->webservice->postRequest(
            'https://ifthenpay.com/api/multibanco/reference/init',
            [
                    'mbKey' => $this->subEntidade,
                    "orderId" => $this->orderId,
                    "amount" => $this->valor,
                    "description" => '',
                    "url" => '',
                    "clientCode" => '',
                    "clientName" => '',
                    "clientEmail" => '',
                    "clientUsername" => '',
                    "clientPhone" => '',
                    "expiryDays" => $this->validade
            ],
            true
        )->getResponseJson();
    }

    private function setReferencia()
    {
        
        $this->orderId = "0000" . $this->orderId;
        
        if(strlen($this->subEntidade) === 2){
			//Apenas sao considerados os 5 caracteres mais a direita do order_id
			$seed = substr($this->orderId, (strlen($this->orderId) - 5), strlen($this->orderId));
			$chk_str = sprintf('%05u%02u%05u%08u', $this->entidade, $this->subEntidade, $seed, round($this->valor*100));
		}else {
			//Apenas sao considerados os 4 caracteres mais a direita do order_id
			$seed = substr($this->orderId, (strlen($this->orderId) - 4), strlen($this->orderId));
			$chk_str = sprintf('%05u%03u%04u%08u', $this->entidade, $this->subEntidade, $seed, round($this->valor*100));
		}
        $chk_array=array(3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62, 38, 89, 17, 73, 51);
        $chk_val=0;
        for ($i = 0; $i < 20; $i++) {
            $chk_int = substr($chk_str, 19-$i, 1);
            $chk_val += ($chk_int%10)*$chk_array[$i];
        }
        $chk_val %= 97;
        $chk_digits = sprintf('%02u', 98-$chk_val);
        //referencia
        return $this->subEntidade.$seed.$chk_digits;
    }

    private function getReferencia()
    {
        $this->dataBuilder->setEntidade($this->entidade);
        if ($this->entidade === self::DYNAMIC_MB_ENTIDADE) {
            $this->setDynamicReferencia();
            $this->checkEstado();
            $this->dataBuilder->setEntidade($this->multibancoPedido['Entity']);
            $this->dataBuilder->setReferencia($this->multibancoPedido['Reference']);
            $this->dataBuilder->setIdPedido($this->multibancoPedido['RequestId']);
            $this->dataBuilder->setValidade($this->multibancoPedido['ExpiryDate']);
        } else {
            $this->dataBuilder->setReferencia($this->setReferencia());
        }
        $this->dataBuilder->setTotalToPay((string)$this->valor);
        return $this->dataBuilder;
    }

    public function buy()
    {
        $this->checkValue($this->valor);
        return $this->getReferencia();
    }
}
