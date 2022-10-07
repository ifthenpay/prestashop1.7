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

use PrestaShop\Module\Ifthenpay\Factory\Models\IfthenpayModelFactory;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;

if (!defined('_PS_VERSION_')) {
    exit;
}

class MbwayCancelOrder
{
    /**
     * cancels mbway order if no payment has been received 30 minutes after order confirmation "date_add"
     *
     * @return void
     */
    public function cancelOrder()
    {
        if (\Configuration::get('IFTHENPAY_MBWAY_CANCEL_ORDER_AFTER_TIMEOUT')) {
            $mbwayOrders = IfthenpayModelFactory::build('mbway')->getAllPendingOrders();
            date_default_timezone_set('Europe/Lisbon');
            foreach ($mbwayOrders as $mbwayOrder) {
                $minutes_to_add = 30;
                $time = new \DateTime($mbwayOrder['date_add']);
                //TODO: this formating might be wrong, can give more than 30 minutes if in different timezone
                $time->add(new \DateInterval('PT' . $minutes_to_add . 'M'));
                $today = new \DateTime(date("Y-m-d G:i"));

                if ($time < $today) {
                    $new_history = PrestashopModelFactory::buildOrderHistory();
                    $new_history->id_order = (int) $mbwayOrder['id_order'];
                    $new_history->changeIdOrderState((int) \Configuration::get('PS_OS_CANCELED'), (int) $mbwayOrder['id_order']);
                    $new_history->addWithemail(true);
                }
            }
        }
        
    }
}
