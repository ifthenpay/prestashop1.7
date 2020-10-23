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


namespace PrestaShop\Module\Ifthenpay\Factory\Payment;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Payments\MbWay;
use PrestaShop\Module\Ifthenpay\Payments\Payshop;
use PrestaShop\Module\Ifthenpay\Payments\Multibanco;
use PrestaShop\Module\Ifthenpay\Contracts\Payments\PaymentMethodInterface;

class PaymentFactory
{
    /**
    * Get payment class by payment method
    *@param string $paymentMethod, @param GatewayDataBuilder $data, @param String $orderId, @param string $valor
    * @return PaymentMethodInterface
    */
    public static function build($paymentMethod, $data, $orderId, $valor)
    {
        switch ($paymentMethod) {
            case 'multibanco':
                return new Multibanco($data, $orderId, $valor);
            case 'mbway':
                return new MbWay($data, $orderId, $valor);
            case 'payshop':
                return new Payshop($data, $orderId, $valor);
            default:
                throw new Exception("Unknown Payment Class");
        }
    }
}
