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

use PrestaShop\Module\Ifthenpay\Base\PaymentBase;


class IfthenpaygatewayBase extends PaymentBase
{
	protected function setGatewayBuilderData()
	{
		$this->gatewayBuilder->setKey(\Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_KEY'));
		$this->gatewayBuilder->setSelectableMethods(\Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_METHODS'));
		$this->gatewayBuilder->setDefaultMethod(\Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_DEFAULT_METHOD'));
		$this->gatewayBuilder->setDeadline(\Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_DEADLINE'));
	}



	protected function saveToDatabase()
	{
		$this->paymentModel->payment_url = $this->paymentGatewayResultData->paymentUrl;
		$this->paymentModel->deadline = isset($this->paymentGatewayResultData->deadline) ? $this->paymentGatewayResultData->deadline : null;
		$this->paymentModel->order_id = $this->paymentDefaultData->order->id;
		$this->paymentModel->status = 'pending';
		$this->paymentModel->save();
	}



	protected function updateDatabase()
	{
		$this->setPaymentModel('ifthenpaygateway', $this->paymentDataFromDb['id_ifthenpay_ifthenpaygateway']);
		$this->paymentModel->payment_url = $this->paymentGatewayResultData->payment_url;
		$this->paymentModel->deadline = isset($this->paymentGatewayResultData->deadline) ? $this->paymentGatewayResultData->deadline : null;
		$this->paymentModel->update();
	}



	protected function setEmailVariables()
	{
		$this->emailDefaultData['{mb_logo}'] = _PS_BASE_URL_ . _MODULE_DIR_ . 'ifthenpay/views/img/ifthenpaygateway.png';
		$this->emailDefaultData['{payment_url}'] = $this->paymentGatewayResultData ? $this->paymentGatewayResultData->paymentUrl : $this->paymentDataFromDb['payment_url'];

		$deadline = isset($this->paymentGatewayResultData->deadline) ? $this->paymentGatewayResultData->deadline : '';
		$this->emailDefaultData['{deadline}'] = $deadline != '' ? (new \DateTime($deadline))->format('d-m-Y') : '';
	}
}
