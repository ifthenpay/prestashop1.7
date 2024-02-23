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
use PrestaShop\Module\Ifthenpay\Factory\Request\RequestFactory;


if (!defined('_PS_VERSION_')) {
	exit;
}

class CofidisCancelOrder
{

	const COFIDIS_STATUS_EXPIRED = 'EXPIRED';
	const COFIDIS_ENDPOINT_STATUS = 'https://ifthenpay.com/api/cofidis/status';
	const CONFIG_IFTHENPAY_COFIDIS_KEY = 'IFTHENPAY_COFIDIS_KEY';


	/**
	 * cancels cofidis order if status is expired after 60 minutes after order confirmation "date_add"
	 *
	 * @return void
	 */
	public function cancelOrder()
	{
		if (\Configuration::get('IFTHENPAY_COFIDIS_CANCEL_ORDER_AFTER_TIMEOUT')) {

			$cofidisModel = IfthenpayModelFactory::build('cofidispay');

			$cofidisOrders = $cofidisModel->getAllPendingOrders();

			$timezone = \Configuration::get('PS_TIMEZONE');
			if (!$timezone) {
				$timezone = 'Europe/Lisbon';
			}
			date_default_timezone_set($timezone);

			foreach ($cofidisOrders as $cofidisOrder) {
				$minutes_to_add = 60;
				$time = new \DateTime($cofidisOrder['date_add']);
				$time->add(new \DateInterval('PT' . $minutes_to_add . 'M'));
				$deadlineStr = strtotime($time->format('Y-m-d H:i:s'));

				$currentDateStr = strtotime(date('Y-m-d H:i:s'));


				if ($deadlineStr < $currentDateStr) {

					// get ifthenpay db record
					$ifthenpayDbRecord = $cofidisModel->getByOrderId($cofidisOrder['id_order']);


					// get transaction id
					if (!$ifthenpayDbRecord) {
						continue;
					}

					$transactionId = $ifthenpayDbRecord['transaction_id'];

					//check the status
					$response = $this->getCofidisTransactionStatus($transactionId);


					if ($response[0]['statusCode'] === self::COFIDIS_STATUS_EXPIRED) {

						$new_history = PrestashopModelFactory::buildOrderHistory();
						$new_history->id_order = (int) $cofidisOrder['id_order'];
						$new_history->changeIdOrderState((int) \Configuration::get('PS_OS_CANCELED'), (int) $cofidisOrder['id_order']);
						$new_history->addWithemail(true);
					}

				}
			}
		}
	}


	private function getCofidisTransactionStatus(string $transactionId)
	{
		$webservice = RequestFactory::buildWebservice();
		return $webservice->postRequest(
			self::COFIDIS_ENDPOINT_STATUS,
			[
				"cofidisKey" => \Configuration::get(self::CONFIG_IFTHENPAY_COFIDIS_KEY),
				"requestId" => $transactionId
			],
			true
		)->getResponseJson();
	}
}
