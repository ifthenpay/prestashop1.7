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


namespace PrestaShop\Module\Ifthenpay\Admin;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Factory\Admin\AdminOrderFactory;
use PrestaShop\Module\Ifthenpay\Contracts\Admin\AdminOrderInterface;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;
use PrestaShop\Module\Ifthenpay\Payments\Data\IfthenpayStrategy;

class IfthenpayAdminOrder extends IfthenpayStrategy
{
    private $message;
    /**
    *@param Order $order, @param Ifthenpay $ifthenpayModule, @param string $message
    */
    public function __construct($order, $ifthenpayModule, $message = '')
    {
        parent::__construct($order, $ifthenpayModule);
        $this->message = $message;
    }

    /**
    * get url parameters for admin controllers 
    * @return string
    */
    private function getControllersUrlParameters()
    {
        return '&paymentMethod=' . $this->order->payment . '&orderId=' . $this->order->id;
    }

    /**
    * Check if order was created in backoffice 
    * @return void
    */
    public function checkIfOrderBackofficeCreated()
    {
        if ($this->order->payment === 'Ifthenpay') {
            $orderState = PrestashopModelFactory::buildOrderState($this->order->current_state);

            if (strpos($orderState->name[1], \Tools::ucfirst('multibanco')) !== false) {
                $this->paymentDefaultData->setPaymentMethod('multibanco');
                $this->order->payment = 'multibanco';
                $this->order->save();
            } elseif (strpos($orderState->name[1], \Tools::ucfirst('mbway')) !== false) {
                $this->paymentDefaultData->setPaymentMethod('mbway');
                $this->order->payment = 'mbway';
                $this->order->save();
            } elseif (strpos($orderState->name[1], \Tools::ucfirst('payshop')) !== false) {
                $this->paymentDefaultData->setPaymentMethod('payshop');
                $this->order->payment = 'payshop';
                $this->order->save();
            }

            $this->paymentDefaultData->setOrder($this->order);
        }
    }

    /**
    * Set default smarty variables 
    * @return void
    */
    private function setDefaultSmartyData()
    {
        $this->smartyDefaultData->setTotalToPay(
            \Context::getContext()->currentLocale->formatPrice(
                $this->order->total_paid,
                \Context::getContext()->currency->iso_code
            )
        );
        $this->smartyDefaultData->setPaymentMethod($this->order->payment);
        $this->smartyDefaultData->setPaymentLogo(
            \Media::getMediaPath(
                _PS_MODULE_DIR_ . 'ifthenpay/views/img/' . $this->order->payment . '.png'
            )
        );
        $this->smartyDefaultData->setUpdateControllerUrl(\Context::getContext()->link->getAdminLink('Update') . $this->getControllersUrlParameters());
        $this->smartyDefaultData->setResendControllerUrl(\Context::getContext()->link->getAdminLink('Resend') . $this->getControllersUrlParameters());
        $this->smartyDefaultData->setRememberControllerUrl(\Context::getContext()->link->getAdminLink('Remember') . $this->getControllersUrlParameters());
        $this->smartyDefaultData->setMessage($this->message);
    }

    /**
    * Main method to get admin order 
    * @return AdminOrderInterface
    */
    public function execute()
    {
        $this->checkIfOrderBackofficeCreated();
        $this->setDefaultData();
        $this->setDefaultSmartyData();

        return AdminOrderFactory::build(
            $this->order->payment,
            $this->paymentDefaultData,
            $this->smartyDefaultData,
            $this->ifthenpayModule
        )->getAdminOrder();
    }
}
