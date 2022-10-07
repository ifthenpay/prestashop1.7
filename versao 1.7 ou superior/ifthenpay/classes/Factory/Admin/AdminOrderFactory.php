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

use PrestaShop\Module\Ifthenpay\Admin\Payments\MbwayAdminOrder;
use PrestaShop\Module\Ifthenpay\Admin\Payments\PayshopAdminOrder;
use PrestaShop\Module\Ifthenpay\Admin\Payments\MultibancoAdminOrder;
use PrestaShop\Module\Ifthenpay\Admin\Payments\CCardAdminOrder;

class AdminOrderFactory
{
    public static function build(
        $type,
        $paymentDefaultData,
        $smartyDefaultData,
        $ifthenpayModule
    ) {
        switch ($type) {
            case 'multibanco':
                return new MultibancoAdminOrder($ifthenpayModule, $paymentDefaultData, $smartyDefaultData);
            case 'mbway':
                return new MbwayAdminOrder($ifthenpayModule, $paymentDefaultData, $smartyDefaultData);
            case 'payshop':
                return new PayshopAdminOrder($ifthenpayModule, $paymentDefaultData, $smartyDefaultData);
            case 'ccard':
                return new CCardAdminOrder($ifthenpayModule, $paymentDefaultData, $smartyDefaultData);
            default:
                throw new \Exception('Unknown Admin Order class');
        }
    }
}
