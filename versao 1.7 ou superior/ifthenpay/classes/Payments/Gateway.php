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

namespace PrestaShop\Module\Ifthenpay\Payments;

if (!defined('_PS_VERSION_')) {
	exit;
}

use PrestaShop\Module\Ifthenpay\Builders\DataBuilder;
use PrestaShop\Module\Ifthenpay\Factory\Payment\PaymentFactory;
use PrestaShop\Module\Ifthenpay\Factory\Request\RequestFactory;
use PrestaShop\Module\Ifthenpay\Builders\GatewayDataBuilder;

class Gateway
{
	private $webservice;
	private $account;
	private $paymentMethods = ['multibanco', 'mbway', 'payshop', 'ccard', 'cofidispay', 'ifthenpay', 'ifthenpaygateway', 'pix'];
	private $previousModulePaymentMethods = ['pagamento por multibanco', 'pagamento por mbway', 'pagamento por payshop'];
	private $aliasPaymentMethods = [
		'multibanco' => [
			'gb' => 'Multibanco',
			'en' => 'Multibanco',
			'pt' => 'Multibanco',
			'es' => 'Cajero automático',
			'de' => 'Geldautomat'
		],
		'mbway' => [
			'gb' => 'MB WAY',
			'en' => 'MB WAY',
			'pt' => 'MB WAY',
			'es' => 'MB WAY',
			'de' => 'MB WAY'
		],
		'payshop' => [
			'gb' => 'Payshop',
			'en' => 'Payshop',
			'pt' => 'Payshop',
			'es' => 'Payshop',
			'de' => 'Payshop'
		],
		'ccard' => [
			'gb' => 'Credit Card',
			'en' => 'Credit Card',
			'pt' => 'Cartão de Crédito',
			'es' => 'Tarjeta de crédito',
			'de' => 'Kreditkarte'
		],
		'cofidispay' => [
			'gb' => 'Cofidis Pay',
			'en' => 'Cofidis Pay',
			'pt' => 'Cofidis Pay',
			'es' => 'Cofidis Pay',
			'de' => 'Cofidis Pay'
		],
		'ifthenpaygateway' => [
			'gb' => 'Ifthenpay Gateway',
			'en' => 'Ifthenpay Gateway',
			'pt' => 'Ifthenpay Gateway',
			'es' => 'Ifthenpay Gateway',
			'de' => 'Ifthenpay Gateway'
		],
		'pix' => [
			'gb' => 'Pix',
			'en' => 'Pix',
			'pt' => 'Pix',
			'es' => 'Pix',
			'de' => 'Pix'
		],
	];

	public function __construct()
	{
		$this->webservice = RequestFactory::buildWebservice();
	}

	public function getAliasPaymentMethods($paymentMethod, $isoCodeLanguage)
	{
		return $this->aliasPaymentMethods[$paymentMethod][$isoCodeLanguage] ?? $this->aliasPaymentMethods[$paymentMethod]['pt'];
	}

	public function getPaymentMethodsType()
	{
		return $this->paymentMethods;
	}

	public function checkIfthenpayPaymentMethod($paymentMethod)
	{
		if (in_array(strtolower($paymentMethod), $this->paymentMethods)) {
			return true;
		}
		return false;
	}

	public function checkIfPaymentMethodIsPreviousModule($paymentMethod)
	{
		$paymentMethodLowerCase = strtolower($paymentMethod);
		if (in_array($paymentMethodLowerCase, $this->previousModulePaymentMethods)) {
			return $this->paymentMethods[array_search($paymentMethodLowerCase, $this->previousModulePaymentMethods)];
		}
		return false;
	}

	public function authenticate($backofficeKey)
	{

		$gatewayKeys = $this->webservice->getRequest(
			'https://ifthenpay.com/IfmbWS/ifthenpaymobile.asmx/GetGatewayKeys',
			[
				'backofficekey' => $backofficeKey,
			]
		)->getResponseJson();


		$accountKeys = $this->webservice->postRequest(
			'https://www.ifthenpay.com/IfmbWS/ifmbws.asmx/' .
				'getEntidadeSubentidadeJsonV2',
			[
				'chavebackoffice' => $backofficeKey,
			]
		)->getResponseJson();

		if (!$accountKeys[0]['Entidade'] && empty($accountKeys[0]['SubEntidade'])) {
			throw new \Exception('Backoffice key is invalid');
		}

		if (!empty($accountKeys)) {
			$this->account = $accountKeys;
		}

		if (!empty($gatewayKeys)) {
			$this->account[] = [
				'Entidade' => 'IFTHENPAYGATEWAY',
				'SubEntidade' => $gatewayKeys
			];
		}
	}

	public function getAccount()
	{
		return $this->account;
	}

	public function setAccount($account)
	{
		$this->account = $account;
	}

	public function getPaymentMethods()
	{
		$userPaymentMethods = [];
		$paymentMethodMapping = [
			'mb' => $this->paymentMethods[0],
			'cofidis' => $this->paymentMethods[4],
			'ifthenpaygateway' => $this->paymentMethods[6],
		];

		foreach ($this->account as $account) {
			$entidade = strtolower($account['Entidade']);

			if (in_array($entidade, $this->paymentMethods)) {
				$userPaymentMethods[] = $entidade;
			} elseif (is_numeric($entidade) || $entidade == 'mb') {
				$userPaymentMethods[] = $paymentMethodMapping['mb'];
			} elseif ($entidade == 'cofidis') {
				$userPaymentMethods[] = $paymentMethodMapping['cofidis'];
			}elseif ($entidade == 'ifthenpaygateway') {
				$userPaymentMethods[] = $paymentMethodMapping['ifthenpaygateway'];
			}
		}
		return array_unique($userPaymentMethods);
	}

	public function getSubEntidadeInEntidade($entidade)
	{
		return array_filter(
			$this->account,
			function ($value) use ($entidade) {
				return $value['Entidade'] === $entidade;
			}
		);
	}

	public function getEntidadeSubEntidade($paymentMethod)
	{
		$list = [];
		if ($paymentMethod === 'multibanco') {
			$list = array_filter(
				array_column($this->account, 'Entidade'),
				function ($value) {
					return is_numeric($value) || $value === 'MB' || $value === 'mb';
				}
			);
		} elseif ($paymentMethod === 'cofidispay') {
			foreach (array_column($this->account, 'SubEntidade', 'Entidade') as $key => $value) {
				if ($key === \Tools::strtoupper('cofidis')) {
					$list[] = $value;
				}
			}
		} else {
			$list = [];
			foreach (array_column($this->account, 'SubEntidade', 'Entidade') as $key => $value) {
				if ($key === \Tools::strtoupper($paymentMethod)) {
					$list[] = $value;
				}
			}
		}
		return $list;
	}


	public function getIthenpaygatewayKeys(){
		foreach (array_column($this->account, 'SubEntidade', 'Entidade') as $key => $value) {
			if ($key === \Tools::strtoupper('ifthenpaygateway')) {
				return $value;
			}
		}
	}


	public function getIfthenpayGatewayPaymentMethodsDataByBackofficeKeyAndGatewayKey($backofficeKey, $gatewayKey): array
	{

		$methods = $this->webservice->getRequest(
			'https://api.ifthenpay.com/gateway/methods/available',
			[]
		)->getResponseJson();

		if (empty($methods)) {
			return [];
		}

		$accounts = $this->webservice->getRequest(
			'https://ifthenpay.com/IfmbWS/ifthenpaymobile.asmx/GetAccountsByGatewayKey',
			[
				'backofficekey' => $backofficeKey,
				'gatewayKey' => $gatewayKey
			]
		)->getResponseJson();

		if (empty($accounts)) {
			return [];
		}


		foreach ($methods as &$method) {

			$methodCode = $method['Entity'];
			$filteredAccounts = array_filter($accounts, function ($item) use ($methodCode) {
				return $item['Entidade'] === $methodCode || ($methodCode === 'MB' && is_numeric($item['Entidade']));
			});

			$method['accounts'] = $filteredAccounts;
		}
		unset($method);

		return $methods;
	}



	public function getCofidisLimits($cofidisKey)
	{
		$response = $this->webservice->getRequest("https://ifthenpay.com/api/cofidis/limits/$cofidisKey")->getResponseJson();
		$limits = [];

		if (is_array($response) && $response['message'] == 'success') {
			$limits['maxAmount'] = $response['limits']['maxAmount'];
			$limits['minAmount'] = $response['limits']['minAmount'];
		}

		return $limits;
	}


	public function execute($paymentMethod, $data, $orderId, $valor)
	{
		$paymentMethod = PaymentFactory::build($paymentMethod, $data, $orderId, $valor, $this->webservice);
		return $paymentMethod->buy();
	}
}
