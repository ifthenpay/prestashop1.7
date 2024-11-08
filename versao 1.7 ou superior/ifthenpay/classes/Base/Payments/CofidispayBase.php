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


namespace PrestaShop\Module\Ifthenpay\Base\Payments;

if (!defined('_PS_VERSION_')) {
	exit;
}

use PrestaShop\Module\Ifthenpay\Utility\Token;
use PrestaShop\Module\Ifthenpay\Utility\Status;
use PrestaShop\Module\Ifthenpay\Base\PaymentBase;

class CofidispayBase extends PaymentBase
{

	private function getUrlCallback()
	{
		return \Context::getContext()->link->getModuleLink('ifthenpay', 'callback', array(), true);
	}

	protected function setGatewayBuilderData()
	{
		$this->gatewayBuilder->setCofidisKey(\Configuration::get('IFTHENPAY_COFIDISPAY_KEY'));

		$this->gatewayBuilder->setSuccessUrl(
			$this->getUrlCallback() . '?type=online&p=cofidispay&cartId=' . \Tools::getValue('id_cart') . '&qn=' .
			Token::encrypt(Status::getStatusSucess())
		);
	}

	protected function saveToDatabase()
	{
		$this->paymentModel->transaction_id = $this->paymentGatewayResultData->idPedido;
		$this->paymentModel->order_id = $this->paymentDefaultData->order->id;
		$this->paymentModel->status = 'pending';
		$this->paymentModel->save();
	}

	protected function updateDatabase()
	{
		/*$this->setPaymentModel('cofidispay', $this->paymentDataFromDb['id_ifthenpay_cofidispay']);
			  $this->paymentModel->referencia = $this->paymentGatewayResultData->referencia;
			  $this->paymentModel->transaction_id = $this->paymentGatewayResultData->idPedido;
			  $this->paymentModel->update();*/
	}

	protected function setEmailVariables()
	{
		$this->emailDefaultData['{securityCode}'] = $this->securityCode;
	}
}
