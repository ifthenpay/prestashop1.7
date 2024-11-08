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
function upgrade_module_1_6_0($module)
{
	// Process Module upgrade to 1.6.0

	IfthenpayLogProcess::addLog('Running module upgrade to version 1.6.0', IfthenpayLogProcess::INFO, 0);

	$statusArray = [
		[
			'methodName' => 'cofidispay',
			'configName' => 'IFTHENPAY_COFIDISPAY_OS_WAITING',
			'statusNameArray' => [
				'pt' => 'Aguarda pagamento por Cofidis Pay',
				'en' => 'Awaiting for Cofidis Pay payment',
			],
			'sendEmail' => false,
			'template' => '',
			'color' => '#FF8100',
			'logable' => false,
			'paid' => false,
			'imageName' => 'os_cofidispay.png',
		],
		[
			'methodName' => 'cofidispay',
			'configName' => 'IFTHENPAY_COFIDISPAY_OS_CONFIRMED',
			'statusNameArray' => [
				'pt' => 'Confirmado pagamento por Cofidis Pay',
				'en' => 'Payment by Cofidis Pay confirmed',
			],
			'sendEmail' => true,
			'template' => 'payment',
			'color' => '#33B200',
			'logable' => true,
			'paid' => true,
			'imageName' => 'os_cofidispay.png',
		],
		[
			'methodName' => 'cofidispay',
			'configName' => 'IFTHENPAY_COFIDISPAY_OS_NOT_APPROVED',
			'statusNameArray' => [
				'pt' => 'Pagamento por Cofidispay não aprovado',
				'en' => 'Cofidispay payment not approved',
			],
			'sendEmail' => false,
			'template' => '',
			'color' => '#E74C3C',
			'logable' => false,
			'paid' => false,
			'imageName' => 'os_cofidispay.png',
		],
		[
			'methodName' => 'pix',
			'configName' => 'IFTHENPAY_PIX_OS_WAITING',
			'statusNameArray' => [
				'pt' => 'Aguarda pagamento por Pix',
				'en' => 'Awaiting for Pix payment',
			],
			'sendEmail' => false,
			'template' => '',
			'color' => '#FF8100',
			'logable' => false,
			'paid' => false,
			'imageName' => 'os_pix.png',
		],
		[
			'methodName' => 'pix',
			'configName' => 'IFTHENPAY_PIX_OS_CONFIRMED',
			'statusNameArray' => [
				'pt' => 'Confirmado pagamento por Pix',
				'en' => 'Payment by Pix confirmed',
			],
			'sendEmail' => true,
			'template' => 'payment',
			'color' => '#33B200',
			'logable' => true,
			'paid' => true,
			'imageName' => 'os_pix.png',
		],
		[
			'methodName' => 'ifthenpaygateway',
			'configName' => 'IFTHENPAY_IFTHENPAYGATEWAY_OS_WAITING',
			'statusNameArray' => [
				'pt' => 'Aguarda pagamento por Ifthenpay Gateway',
				'en' => 'Awaiting for Ifthenpay Gateway payment',
			],
			'sendEmail' => false,
			'template' => '',
			'color' => '#FF8100',
			'logable' => false,
			'paid' => false,
			'imageName' => 'os_ifthenpaygateway.png',
		],
		[
			'methodName' => 'ifthenpaygateway',
			'configName' => 'IFTHENPAY_IFTHENPAYGATEWAY_OS_CONFIRMED',
			'statusNameArray' => [
				'pt' => 'Confirmado pagamento por Ifthenpay Gateway',
				'en' => 'Payment by Ifthenpay Gateway confirmed',
			],
			'sendEmail' => true,
			'template' => 'payment',
			'color' => '#33B200',
			'logable' => true,
			'paid' => true,
			'imageName' => 'os_ifthenpaygateway.png',
		]
	];



	$resultOfAddOrderStatuses = addOrderStatuses($statusArray);
	$resultOfReactivateCallbacks = reactivateCallbacks();
	$resultOfUpdateUserAccounts = updateUserAccounts();
	$resultOfCreateDdatabaseTables = createDatabaseTables();


	if (
		$resultOfAddOrderStatuses == true &&
		$resultOfReactivateCallbacks == true &&
		$resultOfUpdateUserAccounts == true &&
		$resultOfCreateDdatabaseTables == true
	) {
		IfthenpayLogProcess::addLog('Ran upgrade script 1.6.0 (addOrderStatuses() & reactivateCallbacks() & updateUserAccounts) with result success', IfthenpayLogProcess::INFO, 0);
		return true;
	}
	return false;
}


/**
 * Order status installer. it's a utility function to iterate an assoc array and save some order statuses that would other wise not be created when updating the module
 */
function addOrderStatuses(array $statusArray): bool
{
	try {
		foreach ($statusArray as $status) {

			if (!\Configuration::get($status['configName']) || !\Validate::isLoadedObject(PrestashopModelFactory::buildOrderState(\Configuration::get($status['configName'])))) {
				$order_state = PrestashopModelFactory::buildOrderState();

				foreach (\Language::getLanguages() as $language) {
					$isoCode = \Tools::strtolower($language['iso_code']);

					if ($isoCode == 'en') {
						$order_state->name[$language['id_lang']] = $status['statusNameArray']['en'];
					} else if ($isoCode == 'pt') {
						$order_state->name[$language['id_lang']] = $status['statusNameArray']['pt'];
					} else if ($isoCode == 'es') {
						$order_state->name[$language['id_lang']] = $status['statusNameArray']['es'];
					} else {
						$order_state->name[$language['id_lang']] = $status['statusNameArray']['en'];
						IfthenpayLogProcess::addLog('Unsupported language of ' . $isoCode . ', will set order status text to default english (upgrade script 1.6.0)', IfthenpayLogProcess::INFO, 0);
					}
				}

				$order_state->send_email = $status['sendEmail'];
				$order_state->template = $status['template'];
				$order_state->color = $status['color'];
				$order_state->hidden = false;
				$order_state->delivery = false;
				$order_state->logable = $status['logable'];
				$order_state->invoice = false;
				$order_state->module_name = 'ifthenpay';
				$order_state->unremovable = true;
				$order_state->paid = $status['paid'];


				if ($order_state->add()) {
					$source = _PS_MODULE_DIR_ . 'ifthenpay/views/img/' . $status['imageName'];
					$destination = _PS_ROOT_DIR_ . '/img/os/' . (int) $order_state->id . '.gif';
					copy($source, $destination);
				} else {
					throw new \Exception('Error saving order state.');
				}


				if (\Shop::isFeatureActive()) {
					$shops = \Shop::getShops();
					foreach ($shops as $shop) {
						\Configuration::updateValue($status['configName'], (int) $order_state->id, false, null, (int) $shop['id_shop']);
					}
				} else {
					\Configuration::updateValue($status['configName'], (int) $order_state->id);
				}
			}
		}
		return true;
	} catch (\Throwable $th) {
		IfthenpayLogProcess::addLog('Fail to run upgrade script 1.6.0 with error message: ' . $th->getMessage(), IfthenpayLogProcess::INFO, 0);

		return false;
	}
}

/**
 * Runs callback activation logic for methods that are active and have their callbacks active
 * This is necessary because update 1.5.0 introduced a change to all callback query strings, this will prevent a situation where the prestashop installation expects different callback parameters then the ones saved in ifthenpay's server
 */
function reactivateCallbacks(): bool
{
	try {

		$methodNameArray = ['MULTIBANCO', 'MBWAY', 'PAYSHOP', 'COFIDIS'];

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
		IfthenpayLogProcess::addLog('Partial Fail to run upgrade script 1.6.0 with info message: Failed to update user accounts' . $th->getMessage(), IfthenpayLogProcess::INFO, 0);
		return true; // intentional return true, it is expected to succeed update even if not able to force update user accounts
	}
	return true;
}


function createDatabaseTables()
{

	try {

		$tablesToCreate = [
			'cofidispay' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_cofidispay` (
				`id_ifthenpay_cofidispay` int(10) unsigned NOT NULL auto_increment,
				`transaction_id` varchar(50) NOT NULL,
				`order_id` int(11) NOT NULL,
				`status` varchar(50) NOT NULL,
				PRIMARY KEY  (`id_ifthenpay_cofidispay`),
				INDEX `transaction_id` (`transaction_id`)
			  ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
			'ifthenpaygateway' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_ifthenpaygateway` (
				`id_ifthenpay_ifthenpaygateway` int(10) unsigned NOT NULL auto_increment,
				`order_id` int(11) NOT NULL,
				`status` varchar(50) NOT NULL,
				`payment_url` varchar(255) NOT NULL,
				`deadline` varchar(10) NOT NULL,
				PRIMARY KEY  (`id_ifthenpay_ifthenpaygateway`),
				INDEX `order_id` (`order_id`)
			  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;',
			'pix' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_pix` (
				`id_ifthenpay_pix` int(10) unsigned NOT NULL auto_increment,
				`requestId` varchar(50) NOT NULL,
				`order_id` int(11) NOT NULL,
				`status` varchar(50) NOT NULL,
				PRIMARY KEY  (`id_ifthenpay_pix`),
				INDEX `requestId` (`requestId`)
			  ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
			'shop_cofidispay' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_cofidispay_shop` (
				`id_ifthenpay_cofidispay` int(10) unsigned NOT NULL auto_increment,
				`id_shop` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_ifthenpay_cofidispay`, `id_shop`)
			  ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
			'shop_ifthenpaygateway' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_ifthenpaygateway_shop` (
				`id_ifthenpay_ifthenpaygateway` int(10) unsigned NOT NULL auto_increment,
				`id_shop` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_ifthenpay_ifthenpaygateway`, `id_shop`)
			  ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
			'shop_pix' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_pix_shop` (
				`id_ifthenpay_pix` int(10) unsigned NOT NULL auto_increment,
				`id_shop` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_ifthenpay_pix`, `id_shop`)
			  ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
			'temp_pix' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_temp_pix` (
				`id_ifthenpay_temp_pix` int(10) unsigned NOT NULL auto_increment,
				`cartId` varchar(50) NOT NULL,
				`customerName` varchar(255),
				`customerCpf` varchar(14),
				`customerEmail` varchar(255),
				`customerPhone` varchar(20),
				`customerAddress` varchar(250),
				`customerStreetNumber` varchar(20),
				`customerCity` varchar(20),
				`customerZipCode` varchar(20),
				`customerState` varchar(50),
				PRIMARY KEY  (`id_ifthenpay_temp_pix`),
				INDEX `customerCpf` (`customerCpf`)
			  ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
		];

		foreach ($tablesToCreate as $key => $sql) {

			$result = \Db::getInstance()->execute($sql);

			if ($result != true) {
				throw new Exception("failed to execute table creation of item " . $key);
			}
		}

		return true;
	} catch (\Throwable $th) {
		IfthenpayLogProcess::addLog('Fail to run upgrade script 1.6.0 with info message: Failed to create database tables' . $th->getMessage(), IfthenpayLogProcess::INFO, 0);
		return false;
	}
}
