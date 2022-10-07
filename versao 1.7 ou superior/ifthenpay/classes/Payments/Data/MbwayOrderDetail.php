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

namespace PrestaShop\Module\Ifthenpay\Payments\Data;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Utility\Utility;
use PrestaShop\Module\Ifthenpay\Base\Payments\MbwayBase;
use PrestaShop\Module\Ifthenpay\Contracts\Order\OrderDetailInterface;

class MbwayOrderDetail extends MbwayBase implements OrderDetailInterface
{
    public function setSmartyVariables()
    {
        $this->smartyDefaultData->setTelemovel(!empty($this->paymentDataFromDb) ? $this->paymentDataFromDb['telemovel'] : '');
        $this->smartyDefaultData->setOrderId((string) $this->paymentDefaultData->order->id);
        $this->smartyDefaultData->setIdPedido(!empty($this->paymentDataFromDb) ? $this->paymentDataFromDb['id_transacao'] : '');
        
        if (!empty($this->paymentDataFromDb) && $this->paymentDataFromDb['status'] !== 'paid' && $this->paymentDefaultData->order->getCurrentOrderState()->name[1] !== 'Canceled') {
            $this->smartyDefaultData->setResendMbwayNotificationControllerUrl(
                \Context::getContext()->link->getModuleLink(
                    'ifthenpay',
                    'resendMbwayNotification',
                    [
                    'orderId' => $this->paymentDataFromDb['order_id'],
                    'mbwayTelemovel' => $this->paymentDataFromDb['telemovel'],
                    'orderTotalPay' => $this->paymentDefaultData->order->getOrdersTotalPaid(),
                    'cartId' => \Tools::getValue('id_cart'),
                    'customerSecureKey' => $this->paymentDefaultData->customer->secure_key
                    ]
                )
            );
            $this->setOrderIcons();
            if (\Context::getContext()->cookie->__isset('mbwayResendNotificationSent')) {
                Utility::setPrestashopCookie('mbwayCountdownShow', true);
                $this->smartyDefaultData->setMbwayCountdownShow(true);
                \Context::getContext()->cookie->__unset('mbwayResendNotificationSent');
            }
        } else {
            $this->smartyDefaultData->setMbwayCountdownShow(false);
            $this->smartyDefaultData->setResendMbwayNotificationControllerUrl('');
        }
    }

    public function getOrderDetail()
    {
        $this->setPaymentModel('mbway');
        $this->getFromDatabaseById();
        $this->setSmartyVariables();
        return $this;
    }
}
