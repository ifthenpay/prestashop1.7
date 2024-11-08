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

namespace PrestaShop\Module\Ifthenpay\Callback;

if (!defined('_PS_VERSION_')) {
	exit;
}

use PrestaShop\Module\Ifthenpay\Factory\Request\RequestFactory;
use PrestaShop\Module\Ifthenpay\Callback\CallbackVars as Cb;

class Callback
{

	private $activateEndpoint = 'https://ifthenpay.com/api/endpoint/callback/activation';
	private $webservice;
	private $urlCallback;
	private $chaveAntiPhishing;
	private $backofficeKey;
	private $entidade;
	private $subEntidade;
	private $urlCallbackParameters = [];



	public function __construct($data)
	{
		$this->webservice = RequestFactory::buildWebservice();
		$this->backofficeKey = $data->getData()->backofficeKey;
		$this->entidade = $data->getData()->entidade;
		$this->subEntidade = $data->getData()->subEntidade;

		$this->urlCallbackParameters = [
			'multibanco' => $this->toHttpQuery(
				[
					Cb::TYPE => 'offline',
					Cb::ECOMMERCE_VERSION => '{ec}',
					Cb::MODULE_VERSION => '{mv}',
					Cb::PAYMENT => '{paymentMethod}',
					Cb::ANTIPHISH_KEY => '[ANTI_PHISHING_KEY]',
					Cb::ORDER_ID => '[ID]',
					Cb::ENTITY => '[ENTITY]',
					Cb::REFERENCE => '[REFERENCE]',
					Cb::AMOUNT => '[AMOUNT]',
					Cb::PM => '[PAYMENT_METHOD]',
				]
			),
			'mbway' => $this->toHttpQuery(
				[
					Cb::TYPE => 'offline',
					Cb::ECOMMERCE_VERSION => '{ec}',
					Cb::MODULE_VERSION => '{mv}',
					Cb::PAYMENT => '{paymentMethod}',
					Cb::ANTIPHISH_KEY => '[ANTI_PHISHING_KEY]',
					Cb::ORDER_ID => '[ID]',
					Cb::TRANSACTION_ID => '[REQUEST_ID]',
					Cb::AMOUNT => '[AMOUNT]',
					Cb::PM => '[PAYMENT_METHOD]',
				]
			),
			'payshop' => $this->toHttpQuery(
				[
					Cb::TYPE => 'offline',
					Cb::ECOMMERCE_VERSION => '{ec}',
					Cb::MODULE_VERSION => '{mv}',
					Cb::PAYMENT => '{paymentMethod}',
					Cb::ANTIPHISH_KEY => '[ANTI_PHISHING_KEY]',
					Cb::REFERENCE => '[REFERENCE]',
					Cb::ORDER_ID => '[ID]',
					Cb::TRANSACTION_ID => '[REQUEST_ID]',
					Cb::AMOUNT => '[AMOUNT]',
					Cb::PM => '[PAYMENT_METHOD]',
				]
			),
			'ccard' => $this->toHttpQuery(
				[
					Cb::TYPE => 'offline',
					Cb::ECOMMERCE_VERSION => '{ec}',
					Cb::MODULE_VERSION => '{mv}',
					Cb::PAYMENT => '{paymentMethod}',
					Cb::ANTIPHISH_KEY => '[ANTI_PHISHING_KEY]',
					Cb::ORDER_ID => '[ID]',
					Cb::TRANSACTION_ID => '[REQUEST_ID]',
					Cb::AMOUNT => '[AMOUNT]',
					Cb::PM => '[PAYMENT_METHOD]',
				]
			),
			'cofidispay' => $this->toHttpQuery(
				[
					Cb::TYPE => 'offline',
					Cb::ECOMMERCE_VERSION => '{ec}',
					Cb::MODULE_VERSION => '{mv}',
					Cb::PAYMENT => '{paymentMethod}',
					Cb::ANTIPHISH_KEY => '[ANTI_PHISHING_KEY]',
					Cb::ORDER_ID => '[ID]',
					Cb::TRANSACTION_ID => '[REQUEST_ID]',
					Cb::AMOUNT => '[AMOUNT]',
					Cb::PM => '[PAYMENT_METHOD]',
				]
			),
			'ifthenpaygateway' => $this->toHttpQuery(
				[
					Cb::TYPE => 'offline',
					Cb::ECOMMERCE_VERSION => '{ec}',
					Cb::MODULE_VERSION => '{mv}',
					Cb::PAYMENT => '{paymentMethod}',
					Cb::ANTIPHISH_KEY => '[ANTI_PHISHING_KEY]',
					Cb::ORDER_ID => '[ID]',
					Cb::ENTITY => '[ENTITY]',
					Cb::REFERENCE => '[REFERENCE]',
					Cb::TRANSACTION_ID => '[REQUEST_ID]',
					Cb::AMOUNT => '[AMOUNT]',
					Cb::PM => '[PAYMENT_METHOD]',
				]
			),
			'pix' => $this->toHttpQuery(
				[
					Cb::TYPE => 'offline',
					Cb::ECOMMERCE_VERSION => '{ec}',
					Cb::MODULE_VERSION => '{mv}',
					Cb::PAYMENT => '{paymentMethod}',
					Cb::ANTIPHISH_KEY => '[ANTI_PHISHING_KEY]',
					Cb::ORDER_ID => '[ID]',
					Cb::TRANSACTION_ID => '[REQUEST_ID]',
					Cb::AMOUNT => '[AMOUNT]',
					Cb::PM => '[PAYMENT_METHOD]',
				]
			),
		];
	}

	private function createAntiPhishing()
	{
		$this->chaveAntiPhishing = md5((string) rand());
	}

	private function createUrlCallback($paymentType, $moduleLink)
	{
		$ecommerceVersion = 'ps_' . substr(_PS_VERSION_, 0, 9); // prevent version number of taking too many characters
		$module = \Module::getInstanceByName('ifthenpay');
		$moduleVersion = $module->version;

		$paramStr = $this->urlCallbackParameters[$paymentType];
		$paramStr = str_replace('{paymentMethod}', $paymentType, $paramStr);
		$paramStr = str_replace('{ec}', $ecommerceVersion, $paramStr);
		$paramStr = str_replace('{mv}', $moduleVersion, $paramStr);


		// condition to take into account uglyfied URLs, a prestashop setting at Shop Parameters > Traffic & SEO > Friendly URL
		if (strpos($moduleLink, '?') === true) {
			$this->urlCallback = $moduleLink . '&' . $paramStr;
		} else {
			$this->urlCallback = $moduleLink . '?' . $paramStr;
		}
	}

	private function activateCallback()
	{
		$request = $this->webservice->postRequest(
			$this->activateEndpoint,
			[
				'chave' => $this->backofficeKey,
				'entidade' => $this->entidade,
				'subentidade' => $this->subEntidade,
				'apKey' => $this->chaveAntiPhishing,
				'urlCb' => $this->urlCallback,
			],
			true
		);

		$response = $request->getResponse();
		if (!$response->getStatusCode() === 200 && !$response->getReasonPhrase()) {
			throw new \Exception("Error Activating Callback");
		}
	}

	public function make($paymentType, $moduleLink, $activateCallback = false)
	{
		$this->paymentType = $paymentType;
		$this->createAntiPhishing();
		$this->createUrlCallback($paymentType, $moduleLink);
		if ($activateCallback) {
			$this->activateCallback();
		}
	}

	/**
	 * activates callback for ifthenpay gateway
	 * it does the same as the make() function above but exclusively for ifthenpaygateway method
	 */
	public function activateIfthenpayGatewayCallback($moduleLink, $activateCallback = false, string $antiPhishingKey = '')
	{
		if ($antiPhishingKey == '') {
			$this->createAntiPhishing();
		} else{
			$this->chaveAntiPhishing = $antiPhishingKey;
		}

		$this->createUrlCallback('ifthenpaygateway', $moduleLink);
		if ($activateCallback) {
			$this->activateCallback();
		}
	}


	/**
	 * Get the value of urlCallback
	 */
	public function getUrlCallback()
	{
		return $this->urlCallback;
	}

	/**
	 * Get the value of chaveAntiPhishing
	 */
	public function getChaveAntiPhishing()
	{
		return $this->chaveAntiPhishing;
	}


	private function toHttpQuery(array $array){
		return urldecode(http_build_query($array));
	}
}
