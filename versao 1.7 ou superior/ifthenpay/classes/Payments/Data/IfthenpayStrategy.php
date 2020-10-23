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


namespace PrestaShop\Module\Ifthenpay\Payments\Data;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Factory\Builder\BuilderFactory;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;

class IfthenpayStrategy
{
    protected $paymentDefaultData;
    protected $smartyDefaultData;
    protected $emailDefaultData;
    protected $order;
    protected $paymentValueFormated;
    protected $ifthenpayModule;

    /**
    * @param Order $order, @param Ifthenpay $ifthenpayModule
    */
    public function __construct($order, $ifthenpayModule)
    {
        $this->ifthenpayModule = $ifthenpayModule;
        $this->paymentDefaultData = BuilderFactory::build('paymentData');
        $this->smartyDefaultData = BuilderFactory::build('smarty');
        $this->emailDefaultData = [];
        $this->order = $order;
        $this->paymentValueFormated = \Context::getContext()->currentLocale
            ->formatPrice($this->order->getOrdersTotalPaid(), \Context::getContext()->currency->iso_code);
    }
    /**
    * Set default payment default data
    *@return void
    */
    protected function setDefaultData()
    {
        $this->paymentDefaultData->setOrder($this->order);
        $this->paymentDefaultData->setPaymentMethod($this->order->payment);
        $this->paymentDefaultData->setCustomer(PrestashopModelFactory::buildCustomer((string) $this->order->id_customer));
    }
    /**
    * Set default email data
    *@return void
    */
    protected function setDefaultEmailData()
    {
        $data = $this->paymentDefaultData->getData();
        $this->emailDefaultData['{order_name}'] = $data->order->reference;
        $this->emailDefaultData['{firstname}'] = $data->customer->firstname;
        $this->emailDefaultData['{lastname}'] = $data->customer->lastname;
        $this->emailDefaultData['{total_paid}'] = $this->paymentValueFormated;
    }
}
