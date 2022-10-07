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

use PrestaShop\Module\Ifthenpay\Contracts\Builders\DataBuilderInterface;

class DataBuilder implements DataBuilderInterface
{
    protected $data;

    public function __construct()
    {
        $this->data = new \stdClass;
    }

    public function setTotalToPay($value)
    {
        $this->data->totalToPay = $value;
        return $this;
    }

    public function setPaymentMethod($value)
    {
        $this->data->paymentMethod = $value;
        return $this;
    }

    public function setEntidade($value)
    {
        $this->data->entidade = $value;
        return $this;
    }

    public function setSubEntidade($value)
    {
        $this->data->entidade = $value;
        return $this;
    }

    public function setReferencia($value)
    {
        $this->data->referencia = $value;
        return $this;
    }

    public function setTelemovel($value = null)
    {
        $this->data->telemovel = $value;
        return $this;
    }

    public function setValidade($value)
    {
        $this->data->validade = $value;
        return $this;
    }

    public function setIdPedido($value = null)
    {
        $this->data->idPedido = $value;
        return $this;
    }

    public function setBackofficeKey($value)
    {
        $this->data->backofficeKey = $value;
        return $this;
    }

    public function setSuccessUrl($value)
    {
        $this->data->successUrl = $value;
        return $this;
    }

    public function setErrorUrl($value)
    {
        $this->data->errorUrl = $value;
        return $this;
    }

    public function setCancelUrl($value)
    {
        $this->data->cancelUrl = $value;
        return $this;
    }

    public function setPaymentMessage($value)
    {
        $this->data->message = $value;
        return $this;
    }

    public function setPaymentUrl($value)
    {
        $this->data->paymentUrl = $value;
        return $this;
    }

    public function setPaymentStatus($value)
    {
        $this->data->status = $value;
        return $this;
    }

    public function setMin($value)
    {
        $this->data->min = $value;
        return $this;
    }
    
    public function setMax($value)
    {
        $this->data->max = $value;
        return $this;
    }

    public function setCountries($value)
    {
        $this->data->countries = $value;
        return $this;
    }

    public function setOrder($value)
    {
        $this->data->order = $value;
        return $this;
    }

    public function toArray()
    {
        return json_decode(json_encode($this->data), true);
    }

    public function getData()
    {
        return $this->data;
    }
}
