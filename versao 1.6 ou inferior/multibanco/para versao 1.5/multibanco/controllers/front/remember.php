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
class MultibancoRememberModuleFrontController extends ModuleFrontController
{
	/**
	 * @see FrontController::postProcess()
	 */
	public function postProcess()
	{
		$status="";
		$order_id = Tools::getValue("order_id");
		$folder = Tools::getValue("folder");
		$token = Tools::getValue("token");
		try{
		
			$order = new Order($order_id);
			
			$referencia = $this->module->GenerateMbRef($this->module->ifmb_entidade,$this->module->ifmb_subentidade,$order_id,$order->total_paid);
				
			$cliente = new Customer($order->id_customer);
				
			$data = array(
				'{order_name}' => $order->reference,
				'{firstname}' => $cliente->firstname,
				'{lastname}' => $cliente->lastname,
				'{entidade}' => $this->module->ifmb_entidade,
				'{referencia}' => $referencia,
				'{total_paid}' => $order->total_paid. ' €'
			);
				
			Mail::Send((int)$order->id_lang, 'multibanco_relembrar', 'Pagamento em falta...', $data, $cliente->email, $cliente->firstname.' '.$cliente->lastname,null, null, null, null, _PS_MAIL_DIR_, false, (int)$order->id_shop);
			
			$status = "sucesso";
		} catch (Exception $e) {
			$status = "erro";
		}
		

		$redirect =  _PS_BASE_URL_."/" . $folder . "/index.php?controller=AdminOrders&id_order=" . $order_id . "&vieworder&token=" . $token."&estadolembrete=".$status;
		
		Tools::redirect($redirect);
	}
}
