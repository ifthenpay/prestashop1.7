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

    /**
    * Set payment total to pay
    *@param string $value 
    * @return DataBuilderInterface
    */
    public function setTotalToPay($value)
    {
        $this->data->totalToPay = $value;
        return $this;
    }

    /**
    * Set payment method
    *@param string $value 
    * @return DataBuilderInterface
    */
    public function setPaymentMethod($value)
    {
        $this->data->paymentMethod = $value;
        return $this;
    }

    /**
    * Set multibanco entidade
    *@param string $value 
    * @return DataBuilderInterface
    */
    public function setEntidade($value)
    {
        $this->data->entidade = $value;
        return $this;
    }

    /**
    * Set multibanco/payshop referencia
    *@param string $value 
    * @return DataBuilderInterface
    */
    public function setReferencia($value)
    {
        $this->data->referencia = $value;
        return $this;
    }

    /**
    * Set mbway telemovel
    *@param string $value 
    * @return DataBuilderInterface
    */
    public function setTelemovel($value = null)
    {
        $this->data->telemovel = $value;
        return $this;
    }

    /**
    * Set payshop validade
    *@param string $value 
    * @return DataBuilderInterface
    */
    public function setValidade($value)
    {
        $this->data->validade = $value;
        return $this;
    }

    /**
    * Set mbway/payshop payment idPedido
    *@param string $value 
    * @return DataBuilderInterface
    */
    public function setIdPedido($value = null)
    {
        $this->data->idPedido = $value;
        return $this;
    }

    /**
    * Set backoffice key for callback activation
    *@param string $value 
    * @return DataBuilderInterface
    */
    public function setBackofficeKey($value)
    {
        $this->data->backofficeKey = $value;
        return $this;
    }

    /**
    * Convert to array
    *@param string $value 
    * @return array
    */
    public function toArray()
    {
        return json_decode(json_encode($this->data), true);
    }

    /**
    * Get data
    *@param string $value 
    * @return stdClass
    */
    public function getData()
    {
        return $this->data;
    }
}
