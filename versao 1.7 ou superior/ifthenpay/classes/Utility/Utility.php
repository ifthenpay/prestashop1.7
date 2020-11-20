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


namespace PrestaShop\Module\Ifthenpay\Utility;

use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Utility
{
    private static $name = 'ifthenpay';
    /**
    * Redirect to ifthenpay module config page
    *@return void
    */
    public static function redirectIfthenpayConfigPage()
    {
        $token = \Tools::getAdminTokenLite('AdminModules');
        \Tools::redirectAdmin('index.php?controller=AdminModules&configure=' . self::$name . '&tab_module=payments_gateways&module_name=' . self::$name . '&token=' . $token);
    }
    /**
    * Redirect to admin page
    *@param string $orderId
    *@return void
    */
    public static function redirectAdminOrder($orderId)
    {
        $token = \Tools::getAdminTokenLite('AdminOrders');
        \Tools::redirect(\Context::getContext()->link->getAdminLink('AdminOrders') . '&vieworder=&id_order=' . $orderId . '&token=' . $token);
    }
    /**
    * Check if payment method is present in url
    *@return void
    */
    public static function checkPaymentMethodDefined()
    {
        if (!isset($_GET['paymentMethod'])) {
            self::redirectIfthenpayConfigPage();
        }
    }
    /**
    * Set coockie
    *@param string $cookieName, @param string $cookieValue
    *@return void
    */
    public static function setPrestashopCookie($cookieName, $cookieValue)
    {
        \Context::getContext()->cookie->__set($cookieName, $cookieValue);
        \Context::getContext()->cookie->write();
    }

    /**
    * Get formated price
    *@param Order $order
    *@return string
    */
    public static function getFormatedPrice($order)
    {
        $price = $order->getOrdersTotalPaid();
        if (version_compare(_PS_VERSION_, '1.7.6', '<')) {
            return \Tools::displayPrice(
                $price, 
                PrestashopModelFactory::buildCurrency($order->id_currency), false);
        } else {
            return \Context::getContext()->currentLocale
            ->formatPrice($price, \Context::getContext()->currency->iso_code);
        }
    }
}
