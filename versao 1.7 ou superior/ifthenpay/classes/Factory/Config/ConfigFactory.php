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

namespace PrestaShop\Module\Ifthenpay\Factory\Config;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Config\IfthenpaySql;
use PrestaShop\Module\Ifthenpay\Config\IfthenpayUpgrade;
use PrestaShop\Module\Ifthenpay\Config\IfthenpayOrderStates;
use PrestaShop\Module\Ifthenpay\Config\IfthenpayConfiguration;
use PrestaShop\Module\Ifthenpay\Payments\Data\MbwayCancelOrder;
use PrestaShop\Module\Ifthenpay\Config\IfthenpayControllersTabs;

class ConfigFactory
{
    public static function buildIfthenpayConfiguration($userPaymentMethods = null)
    {
        return new IfthenpayConfiguration($userPaymentMethods);
    }

    public static function buildIfthenpayControllersTabs($ifthenpayModule = null)
    {
        return new IfthenpayControllersTabs($ifthenpayModule);
    }

    public static function buildIfthenpayOrderStates($userPaymentMethods = null)
    {
        return new IfthenpayOrderStates($userPaymentMethods);
    }

    public static function buildIfthenpaySql($userPaymentMethods = null)
    {
        return new IfthenpaySql($userPaymentMethods);
    }

    public static function buildIfthenpayUpgrade($ifthenpayModule)
    {
        return new IfthenpayUpgrade($ifthenpayModule);
    }

    public static function buildCancelMbwayOrder()
    {
        return new MbwayCancelOrder();
    }
}
