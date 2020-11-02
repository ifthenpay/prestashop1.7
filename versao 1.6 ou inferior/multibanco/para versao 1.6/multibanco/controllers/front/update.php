<?php
/*
* 2007-2013 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @since 1.5.0
 */
class MultibancoUpdateModuleFrontController extends ModuleFrontController
{
	/**
	 * @see FrontController::postProcess()
	 */
	public function postProcess()
	{
		$order_id = Tools::getValue("order_id");
		$folder = Tools::getValue("folder");
		$token = Tools::getValue("token");

		try {
			$order = new Order($order_id);
			$mbOrderDetails = Multibanco::getMultibancoOrderDetailsDb($order_id);

			$entidade = $mbOrderDetails["entidade"];
			$subEntidade = substr($mbOrderDetails["referencia"], 0, 3);

			$novaRef = $this->module->GenerateMbRef($entidade,$subEntidade,$order_id,$order->total_paid);

			Db::getInstance()->Execute('UPDATE `' . _DB_PREFIX_ . 'multibanco` SET referencia=\''.preg_replace("/\s+/", "", $novaRef).'\', valor=\''.number_format((float)$order->total_paid, 2, '.', '').'\' WHERE `order_id` = '.$order_id);

			$status = "sucesso";
		} catch (\Exception $e) {
			$status = "erro";
		}

		preg_match("/admin.+\//", $_SERVER['HTTP_REFERER'], $matches, PREG_OFFSET_CAPTURE);

		$admin = rtrim($matches[0][0], "/");
		
		$base = _PS_BASE_URL_ . "/" . $folder;

		$checkAdmin = strpos( $base, $admin ) !== false ? $base : $base . "/" . $admin;

		$redirect =  $checkAdmin . "/index.php?controller=AdminOrders&id_order=" . $order_id . "&vieworder&token=" . $token."&estadoatualizacao=".$status;

		Tools::redirect($redirect);
	}
}
