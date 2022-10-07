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

namespace PrestaShop\Module\Ifthenpay\Factory\Admin;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Admin\Payments\MbwayAdminResend;
use PrestaShop\Module\Ifthenpay\Admin\Payments\PayshopAdminResend;
use PrestaShop\Module\Ifthenpay\Admin\Payments\MultibancoAdminResend;

class AdminResendFactory
{
    public static function build(
        $type,
        $paymentDefaultData,
        $ifthenpayModule,
        $smartyDefaultData = null,
        $emailDefaultData = null
    ) {
        switch ($type) {
            case 'multibanco':
                return new MultibancoAdminResend($ifthenpayModule, $paymentDefaultData, $smartyDefaultData, $emailDefaultData);
            case 'mbway':
                return new MbwayAdminResend($ifthenpayModule, $paymentDefaultData, $smartyDefaultData, $emailDefaultData);
            case 'payshop':
                return new PayshopAdminResend($ifthenpayModule, $paymentDefaultData, $smartyDefaultData, $emailDefaultData);
            default:
                throw new \Exception('Unknown Admin Order Resend Class');
        }
    }
}
