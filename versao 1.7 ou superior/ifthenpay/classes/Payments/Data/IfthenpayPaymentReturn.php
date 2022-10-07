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

use PrestaShop\Module\Ifthenpay\Factory\Payment\PaymentReturnFactory;
use PrestaShop\Module\Ifthenpay\Payments\Data\IfthenpayStrategy;

class IfthenpayPaymentReturn extends IfthenpayStrategy
{


    private function setDefaultSmartyData()
    {
        $this->smartyDefaultData->setShopName(\Context::getContext()->shop->name);
        $this->smartyDefaultData->setTotalToPay($this->paymentValueFormated);
        $this->smartyDefaultData->setPaymentMethod($this->order->payment);
        $this->smartyDefaultData->setPaymentLogo(
            \Media::getMediaPath(
                _PS_MODULE_DIR_ . 'ifthenpay/views/img/' . $this->order->payment . '.png'
            )
        );
    }

    public function execute()
    {
        $this->setDefaultData();
        $this->setDefaultSmartyData();
        $this->setDefaultEmailData();

        return PaymentReturnFactory::build(
            $this->order->payment,
            $this->paymentDefaultData,
            $this->smartyDefaultData,
            $this->emailDefaultData,
            $this->ifthenpayModule
        )->getPaymentReturn();
    }
}
