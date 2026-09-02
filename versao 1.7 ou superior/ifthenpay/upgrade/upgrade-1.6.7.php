<?php

/**
 * File: /upgrade/upgrade-1.6.0.php
 * @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
 *  @copyright 2007-2022 Ifthenpay Lda
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

use PrestaShop\Module\Ifthenpay\Factory\Builder\BuilderFactory;
use PrestaShop\Module\Ifthenpay\Factory\Callback\CallbackFactory;
use PrestaShop\Module\Ifthenpay\Factory\Payment\GatewayFactory;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;
use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;

if (!defined('_PS_VERSION_')) {
	exit;
}

/**
 * adds new methods order statuses and
 * forces callback reactivation
 *
 * @param [type] $module
 * @return void
 */
function upgrade_module_1_6_7($module)
{
	// Process Module upgrade to 1.6.7

	IfthenpayLogProcess::addLog('Running module upgrade to version 1.6.7', IfthenpayLogProcess::INFO, 0);

	$resultOfReactivateCallbacks = reactivateCallbacks();
	$resultOfUpdateUserAccounts = updateUserAccounts();
	$resultOfDisableCofidis = disableCofidis();


	if (
		$resultOfReactivateCallbacks == true &&
		$resultOfUpdateUserAccounts == true &&
		$resultOfDisableCofidis == true
	) {
		IfthenpayLogProcess::addLog('Ran upgrade script 1.6.7 (disableCofidis() & reactivateCallbacks() & updateUserAccounts) with result success', IfthenpayLogProcess::INFO, 0);
		return true;
	}
	return false;
}



/**
 * Runs callback activation logic for methods that are active and have their callbacks active
 * This is necessary because update 1.5.0 introduced a change to all callback query strings, this will prevent a situation where the prestashop installation expects different callback parameters then the ones saved in ifthenpay's server
 */
function reactivateCallbacks(): bool
{
	try {

		$methodNameArray = ['MULTIBANCO', 'MBWAY', 'PAYSHOP'];

		foreach ($methodNameArray as $methodName) {

			$isCallbackActivated = \Configuration::get('IFTHENPAY_CALLBACK_ACTIVATED_FOR_' . $methodName);
			$isMethodActive = \Configuration::get('IFTHENPAY_' . $methodName);

			if ($isCallbackActivated != '1' || $isMethodActive != '1') {
				continue;
			}

			$gatewayDataBuilder = BuilderFactory::build('gateway');
			$gatewayDataBuilder->setBackofficeKey(\Configuration::get('IFTHENPAY_BACKOFFICE_KEY'));

			if ($methodName == 'MULTIBANCO') {

				$gatewayDataBuilder->setEntidade(\Configuration::get('IFTHENPAY_' . $methodName . '_ENTIDADE'));
				$gatewayDataBuilder->setSubEntidade(\Configuration::get('IFTHENPAY_' . $methodName . '_SUBENTIDADE'));
			} else {
				$gatewayDataBuilder->setEntidade($methodName);
				$gatewayDataBuilder->setSubEntidade(\Configuration::get('IFTHENPAY_' . $methodName . '_KEY'));
			}

			$callback = CallbackFactory::buildCallback($gatewayDataBuilder);
			$moduleLink = \Context::getContext()->link->getModuleLink('ifthenpay', 'callback', array(), true);


			$callback->make(strtolower($methodName), $moduleLink, true);

			// save url and apk to DB
			\Configuration::updateValue('IFTHENPAY_' . $methodName . '_URL_CALLBACK', $callback->getUrlCallback());
			\Configuration::updateValue('IFTHENPAY_' . $methodName . '_CHAVE_ANTI_PHISHING', $callback->getChaveAntiPhishing());
		}
	} catch (\Throwable $th) {
		IfthenpayLogProcess::addLog('Partial Fail to run upgrade script 1.6.0 with info message: Failed to reactivate callbacks' . $th->getMessage(), IfthenpayLogProcess::INFO, 0);

		return true; // intentional return true, it is expected to succeed update even if not able to force reactivate callbacks
	}
	return true;
}

/**
 * runs the authenticate logic, essentially refreshing the list of available accounts for the user
 */
function updateUserAccounts()
{
	try {

		$ifthenpayGateway = GatewayFactory::build('gateway');

		$backofficeKey = \Configuration::get('IFTHENPAY_BACKOFFICE_KEY');

		$ifthenpayGateway->authenticate($backofficeKey);

		\Configuration::updateValue('IFTHENPAY_USER_PAYMENT_METHODS', serialize($ifthenpayGateway->getPaymentMethods()));
		\Configuration::updateValue('IFTHENPAY_USER_ACCOUNT', serialize($ifthenpayGateway->getAccount()));
	} catch (\Throwable $th) {
		IfthenpayLogProcess::addLog('Partial Fail to run upgrade script 1.6.7 with info message: Failed to update user accounts' . $th->getMessage(), IfthenpayLogProcess::INFO, 0);
		return true; // intentional return true, it is expected to succeed update even if not able to force update user accounts
	}
	return true;
}


function disableCofidis()
{

	try {

		$sql = 'UPDATE `' . _DB_PREFIX_ . 'configuration` SET `value` = null WHERE `name` = "IFTHENPAY_COFIDISPAY"';

		$result = \Db::getInstance()->execute($sql);

		if ($result != true) {
			throw new Exception("failed to execute update of Cofidis configuration");
		}

		return true;
	} catch (\Throwable $th) {
		IfthenpayLogProcess::addLog('Fail to run upgrade script 1.6.7 with info message: Failed to disable Cofidis payment method' . $th->getMessage(), IfthenpayLogProcess::INFO, 0);
		return false;
	}
}
