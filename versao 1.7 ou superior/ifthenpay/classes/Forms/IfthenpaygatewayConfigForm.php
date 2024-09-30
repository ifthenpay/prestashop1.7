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

namespace PrestaShop\Module\Ifthenpay\Forms;

if (!defined('_PS_VERSION_')) {
	exit;
}

use Configuration;
use PrestaShop\Module\Ifthenpay\Forms\ConfigForm;
use PrestaShop\Module\Ifthenpay\Utility\Utility;

class IfthenpaygatewayConfigForm extends ConfigForm
{
	protected $paymentMethod = 'ifthenpaygateway';

	protected $subEntityOptions = []; // array of subentity options for GUI select
	protected $options = []; // array of entity options for GUI select


	/**
	 * "gets" the form into object... it sets the form that will display in the payment method configuration
	 *
	 * @return void
	 */
	public function getForm()
	{
		// assign template variables
		$this->setSmartyVariables();

		$this->setFormParent('Ifthenpay Gateway');
		$this->setGatewayKeyOptions();


		$this->addActivateCallbackToForm();


		// GATEWAY KEY
		$this->form['form']['input'][] = [

			'type' => 'html',
			'name' => 'IFTHENPAY_IFTHENPAYGATEWAY_KEY',
			'required' => true,
			'html_content' => $this->generateSelectGatewayKey($this->ifthenpayGateway->getIthenpaygatewayKeys(), \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_KEY')),
			'label' => $this->ifthenpayModule->l('Gateway Key', pathinfo(__FILE__)['filename']),
			'desc' => $this->ifthenpayModule->l('Choose Key', pathinfo(__FILE__)['filename']),
		];


		// PAYMENT METHODS
		$storedMethods = \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_METHODS');
		$storedMethods = $storedMethods ? json_decode($storedMethods, true) : [];
		$paymentMethodsSelectionHtml = $this->generateIfthenpaygatewayPaymentMethodsHtml(Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_KEY'), $storedMethods);

		$this->form['form']['input'][] = [
			'type' => 'html',
			'name' => 'IFTHENPAY_IFTHENPAYGATEWAY_PAYMENT_METHODS',
			'html_content' => '<div id="methods_container">' . $paymentMethodsSelectionHtml . '</div>',
			'label' => $this->ifthenpayModule->l('Payment Methods', pathinfo(__FILE__)['filename'])
		];


		// DEFAULT METHOD
		$defaultPaymentMethodSelectionHtml = $this->generateIfthenpaygatewayDefaultPaymentMethodSelectionHtml(Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_KEY'));

		$this->form['form']['input'][] = [
			'type' => 'html',
			'name' => 'IFTHENPAY_IFTHENPAYGATEWAY_DEFAULT_METHOD',
			'html_content' => '<div id="default_method_container">' . $defaultPaymentMethodSelectionHtml . '</div>',
			'label' => $this->ifthenpayModule->l('Default Payment Method', pathinfo(__FILE__)['filename'])
		];


		// PAYMENT DEADLINE
		$this->form['form']['input'][] = [
			'type' => 'text',
			'label' => $this->ifthenpayModule->l('Deadline', pathinfo(__FILE__)['filename']),
			'name' => 'IFTHENPAY_IFTHENPAYGATEWAY_DEADLINE',
			'desc' => $this->ifthenpayModule->l('Choose the number of days (from 1 to 99), leave empty if you do not want expiration.', pathinfo(__FILE__)['filename'])
		];


		// Gateway Close Button Text
		$this->form['form']['input'][] = [
			'type' => 'text',
			'label' => $this->ifthenpayModule->l('Gateway Close Button Text', pathinfo(__FILE__)['filename']),
			'name' => 'IFTHENPAY_IFTHENPAYGATEWAY_CLOSE_BTN',
			'desc' => $this->ifthenpayModule->l('Replaces the return button text in the gateway page. Leave empty to use default.', pathinfo(__FILE__)['filename'])
		];


		// CANCEL AFTER DEADLINE
		$this->form['form']['input'][] = [
			'type' => 'switch',
			'label' => $this->ifthenpayModule->l('Cancel Ifthenpay Gateway Order', pathinfo(__FILE__)['filename']),
			'name' => 'IFTHENPAY_IFTHENPAYGATEWAY_CANCEL_ORDER_AFTER_TIMEOUT',
			'desc' => $this->ifthenpayModule->l('Cancel order if not payed before end of Deadline. Requires Deadline to be set. This is triggered when admin visits the order list page.', pathinfo(__FILE__)['filename']),
			'is_bool' => true,
			'values' => [
				[
					'id' => 'active_on',
					'value' => true,
					'label' => $this->ifthenpayModule->l('Activated', pathinfo(__FILE__)['filename'])
				],
				[
					'id' => 'active_off',
					'value' => false,
					'label' => $this->ifthenpayModule->l('Disabled', pathinfo(__FILE__)['filename'])
				]
			]
		];


		// add min max and country form elements
		$this->addMinMaxFieldsToForm();
		$this->addCountriesFieldToForm();


		$this->form['form']['input'][] = [
			'type' => 'select',
			'label' => $this->ifthenpayModule->l('Show Payment Method Logo on Checkout', pathinfo(__FILE__)['filename']),
			'name' => 'IFTHENPAY_IFTHENPAYGATEWAY_SHOW_LOGO',
			'options' => [
				'query' => [
					['id' => '1', 'name' => $this->ifthenpayModule->l('Enabled - Use Default Image', pathinfo(__FILE__)['filename'])],
					['id' => '0', 'name' => $this->ifthenpayModule->l('Disabled - Use Payment Method Title', pathinfo(__FILE__)['filename'])],
					['id' => 'composite', 'name' => $this->ifthenpayModule->l('Enabled - Use Generated Composite Image', pathinfo(__FILE__)['filename'])],
				],
				'id' => 'id',
				'name' => 'name'
			]
		];

		$this->form['form']['input'][] = [
			'type' => 'text',
			'label' => $this->ifthenpayModule->l('Payment Method Title', pathinfo(__FILE__)['filename']),
			'name' => 'IFTHENPAY_IFTHENPAYGATEWAY_TITLE',
		];


		$this->addOrderByNumberFieldsToForm();

		// generate form
		$this->generateHelperForm();
	}

	protected function getConfigFormValues()
	{
		return array_merge(parent::getCommonConfigFormValues(), [
			'IFTHENPAY_IFTHENPAYGATEWAY_CLOSE_BTN' => \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_CLOSE_BTN'),
			'IFTHENPAY_IFTHENPAYGATEWAY_DEADLINE' => \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_DEADLINE'),
			'IFTHENPAY_IFTHENPAYGATEWAY_KEY' => \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_KEY'),
			'IFTHENPAY_IFTHENPAYGATEWAY_CANCEL_ORDER_AFTER_TIMEOUT' => \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_CANCEL_ORDER_AFTER_TIMEOUT'),
			'IFTHENPAY_IFTHENPAYGATEWAY_TITLE' => \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_TITLE') == '' ? 'Ifthenpay Gateway' : \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_TITLE'),
			'IFTHENPAY_IFTHENPAYGATEWAY_SHOW_LOGO' => \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_SHOW_LOGO'),
		]);
	}

	public function setSmartyVariables()
	{
		// common to all payment methods
		parent::assignSmartyPayMethodsCommonVars();
	}

	public function setGatewayBuilderData()
	{
		$getKeyFromRequest = \Tools::getValue('IFTHENPAY_IFTHENPAYGATEWAY_KEY');
		$getPaymentMethodsFromRequest = \Tools::getValue('IFTHENPAY_IFTHENPAYGATEWAY_METHODS');
		$getDefaultMethodFromRequest = \Tools::getValue('IFTHENPAY_IFTHENPAYGATEWAY_DEFAULT_METHOD');
		$getDeadlineFromRequest = \Tools::getValue('IFTHENPAY_IFTHENPAYGATEWAY_DEADLINE');
		$getTitleFromRequest = \Tools::getValue('IFTHENPAY_IFTHENPAYGATEWAY_TITLE');
		$getShowLogoFromRequest = \Tools::getValue('IFTHENPAY_IFTHENPAYGATEWAY_SHOW_LOGO');
		$getCloseBtn = \Tools::getValue('IFTHENPAY_IFTHENPAYGATEWAY_CLOSE_BTN');

		parent::setGatewayBuilderData();
		$this->gatewayDataBuilder->setKey($getKeyFromRequest ? $getKeyFromRequest : \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_KEY'));
		$this->gatewayDataBuilder->setSelectableMethods($getPaymentMethodsFromRequest ? json_encode($getPaymentMethodsFromRequest) : \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_METHODS'));
		$this->gatewayDataBuilder->setDefaultMethod($getDefaultMethodFromRequest ? $getDefaultMethodFromRequest : \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_DEFAULT_METHOD'));
		$this->gatewayDataBuilder->setDeadline($getDeadlineFromRequest);
		$this->gatewayDataBuilder->setCloseBtn($getCloseBtn);
		$this->gatewayDataBuilder->setTitle($getTitleFromRequest ? $getTitleFromRequest : \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_TITLE'));
		$this->gatewayDataBuilder->setShowLogo($getShowLogoFromRequest != '' ? $getShowLogoFromRequest : \Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_SHOW_LOGO'));
	}

	public function processForm()
	{
		if ($this->isValid()) {

			$this->setGatewayBuilderData();

			if (
				!$this->generateAndSavePaymentLogo(json_decode($this->gatewayDataBuilder->getData()->selectableMethods, true), $this->gatewayDataBuilder->getData()->showLogo)
			) {
				return;
			}

			// save specific values
			\Configuration::updateValue('IFTHENPAY_IFTHENPAYGATEWAY_KEY', $this->gatewayDataBuilder->getData()->key);
			\Configuration::updateValue('IFTHENPAY_IFTHENPAYGATEWAY_DEFAULT_METHOD', $this->gatewayDataBuilder->getData()->defaultMethod);
			\Configuration::updateValue('IFTHENPAY_IFTHENPAYGATEWAY_DEADLINE', $this->gatewayDataBuilder->getData()->deadline);
			\Configuration::updateValue('IFTHENPAY_IFTHENPAYGATEWAY_CLOSE_BTN', $this->gatewayDataBuilder->getData()->closeBtn);
			\Configuration::updateValue('IFTHENPAY_IFTHENPAYGATEWAY_TITLE', $this->gatewayDataBuilder->getData()->title);
			\Configuration::updateValue('IFTHENPAY_IFTHENPAYGATEWAY_SHOW_LOGO', $this->gatewayDataBuilder->getData()->showLogo);
			\Configuration::updateValue('IFTHENPAY_IFTHENPAYGATEWAY_CANCEL_ORDER_AFTER_TIMEOUT', \Tools::getValue('IFTHENPAY_IFTHENPAYGATEWAY_CANCEL_ORDER_AFTER_TIMEOUT'));


			// can activate callback?
			$canActivateCallback = !\Configuration::get('IFTHENPAY_ACTIVATE_SANDBOX_MODE', false) &&
				\Tools::getValue('IFTHENPAY_CALLBACK_ACTIVATE_FOR_' . strtoupper($this->paymentMethod));

			if ($canActivateCallback) {
				$this->bulkActivateCallbacks();
			}

			// update methods after checking if necessary to activate callback
			\Configuration::updateValue('IFTHENPAY_IFTHENPAYGATEWAY_METHODS', $this->gatewayDataBuilder->getData()->selectableMethods);




			$this->updatePayMethodCommonValues();

			// response msg after submiting form
			Utility::setPrestashopCookie('success', $this->ifthenpayModule->l(ucfirst($this->paymentMethod) . ' payment method successfully updated.', pathinfo(__FILE__)['filename']));
		}
	}



	private function generateAndSavePaymentLogo($paymentMethodGroups, $paymentLogoType): bool
	{
		// exit early if is only showing text instead of logo
		if ($paymentLogoType == '0') {
			return true;
		}

		if (
			!function_exists('imagecreatefrompng') ||
			!function_exists('imagesx') ||
			!function_exists('imagesy') ||
			!function_exists('imagedestroy') ||
			!function_exists('imagecreatetruecolor') ||
			!function_exists('imagecolorallocatealpha') ||
			!function_exists('imagefill') ||
			!function_exists('imagesavealpha') ||
			!function_exists('imagecopyresampled') ||
			!function_exists('imagecopy') ||
			!function_exists('imagepng')
		) {
			Utility::setPrestashopCookie('error', 'Missing image edit dependencies required to create composite image', pathinfo(__FILE__)['filename']);
			return false;
		}


		if (
			!file_exists(_PS_MODULE_DIR_ . 'ifthenpay/views/img/ifthenpaygateway_option_default.png') ||
			!file_exists(_PS_MODULE_DIR_ . 'ifthenpay/views/img/ifthenpaygateway_option.png') ||
			!is_writable(_PS_MODULE_DIR_ . 'ifthenpay/views/img/ifthenpaygateway_option_default.png') ||
			!is_writable(_PS_MODULE_DIR_ . 'ifthenpay/views/img/ifthenpaygateway_option.png')
		) {
			Utility::setPrestashopCookie('error', 'Missing file permissions required to create composite image', pathinfo(__FILE__)['filename']);
			return false;
		}

		$paymentLogos = array_map(function ($item) {

			if ($item['is_active'] == '1') {
				return $item['image_url'] ?? null;
			}
		}, $paymentMethodGroups);
		$paymentLogos = array_filter($paymentLogos);

		if ($paymentLogoType != 'composite' || count($paymentLogos) <= 0) {

			copy(_PS_MODULE_DIR_ . 'ifthenpay/views/img/ifthenpaygateway_option_default.png', _PS_MODULE_DIR_ . 'ifthenpay/views/img/ifthenpaygateway_option.png');
			return true;
		}

		$canvasHeight = 38;
		$innerLayerHeight = 26;
		$verticalSpacing = 6;
		$horizontalSpacing = 10;


		$combinedWidth = 0;
		$combinedHeight = $canvasHeight;


		foreach ($paymentLogos as $url) {
			$image = imagecreatefrompng($url);
			$width = imagesx($image);
			$height = imagesy($image);

			if ($height != $innerLayerHeight) {

				$width = intval(($innerLayerHeight * $width) / $height);
				$height = $innerLayerHeight;
			}

			$combinedWidth += $width;
			imagedestroy($image); // Destroy immediately after size calculation
		}

		$combinedWidth += ($horizontalSpacing * (count($paymentLogos) - 1));

		$combinedImage = imagecreatetruecolor($combinedWidth, $combinedHeight);
		$transparentColor = imagecolorallocatealpha($combinedImage, 0, 0, 0, 127);
		imagefill($combinedImage, 0, 0, $transparentColor);
		imagesavealpha($combinedImage, true);

		$currentX = 0;
		foreach ($paymentLogos as $url) {
			$image = imagecreatefrompng($url);
			$width = imagesx($image);
			$height = imagesy($image);

			if ($height != $innerLayerHeight) {
				$resizedWidth = intval(($innerLayerHeight * $width) / $height);
				$resizedImage = imagecreatetruecolor($resizedWidth, $canvasHeight);

				$transparentColor = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
				imagefill($resizedImage, 0, 0, $transparentColor);
				imagesavealpha($resizedImage, true);

				imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $resizedWidth, $innerLayerHeight, $width, $height);
				imagecopy($combinedImage, $resizedImage, $currentX, $verticalSpacing, 0, 0, $resizedWidth, $innerLayerHeight);
				$currentX += $resizedWidth + $horizontalSpacing;

				imagedestroy($resizedImage);
			} else {
				imagecopy($combinedImage, $image, $currentX, 0, 0, 0, $width, $height);
				$currentX += $width + $horizontalSpacing;
			}

			imagedestroy($image);
		}

		imagepng($combinedImage, _PS_MODULE_DIR_ . 'ifthenpay/views/img/ifthenpaygateway_option.png');

		imagedestroy($combinedImage);

		return true;
	}



	private function bulkActivateCallbacks()
	{

		$paymentMethods = $this->gatewayDataBuilder->getData()->selectableMethods ? json_decode($this->gatewayDataBuilder->getData()->selectableMethods, true) : [];
		$storedPaymentMethods = Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_METHODS');
		$storedPaymentMethods = $storedPaymentMethods ? json_decode($storedPaymentMethods, true) : [];

		$paymentMethodsToActivate = [];

		if (
			empty($storedPaymentMethods) ||
			(!\Configuration::get('IFTHENPAY_CALLBACK_ACTIVATE_FOR_IFTHENPAYGATEWAY', false) &&
			\Tools::getValue('IFTHENPAY_CALLBACK_ACTIVATE_FOR_IFTHENPAYGATEWAY'))
		) {
			$paymentMethodsToActivate = array_filter($paymentMethods, fn($item) => $item['is_active'] === '1');
		} else {
			foreach ($paymentMethods as $key => $paymentMethod) {

				if (
					(isset($storedPaymentMethods[$key]) && $storedPaymentMethods[$key]['is_active'] === '0' && $paymentMethod['is_active'] === '1') ||
					(!isset($storedPaymentMethods[$key]) && $paymentMethod['is_active'] === '1')
				) {
					$paymentMethodsToActivate[$key] = $paymentMethod;
				}
			}
		}

		if (!empty($paymentMethodsToActivate)) {

			$antiPhishingKey = Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_CHAVE_ANTI_PHISHING');

			foreach ($paymentMethodsToActivate as $key => $values) {

				$paymentMethodEntitySubentity = explode('|', $values['account']);
				$paymentMethodEntity = trim($paymentMethodEntitySubentity[0]);
				$paymentMethodSubEntity = trim($paymentMethodEntitySubentity[1]);

				$this->gatewayDataBuilder->setEntidade($paymentMethodEntity);
				$this->gatewayDataBuilder->setSubEntidade($paymentMethodSubEntity);
				$ifthenpayCallback = $this->getIfthenpayCallback();

				$ifthenpayCallback->activateIfthenpayGatewayCallback($this->getCallbackControllerUrl(), true, $antiPhishingKey);
			}

			\Configuration::updateValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_URL_CALLBACK', $ifthenpayCallback->getUrlCallback());
			\Configuration::updateValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_CHAVE_ANTI_PHISHING', $ifthenpayCallback->getChaveAntiPhishing());
		}
	}


	/**
	 * verifies if form inputs are valid
	 * makes use of parent function that verifies common inputs such as min and max
	 *
	 * @return boolean
	 */
	public function isValid()
	{
		if (!parent::isValid()) {
			return false;
		}

		$key = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_KEY');
		if ($key == '') {
			Utility::setPrestashopCookie('error', 'Selected Key is not valid', pathinfo(__FILE__)['filename']);
			return false;
		}

		$deadline = \Tools::getValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_DEADLINE');
		if (
			isset($deadline) &&
			$deadline !== '' &&
			((is_numeric($deadline) ? intval($deadline) != $deadline : true) || intval($deadline) <= 0)
		) {
			Utility::setPrestashopCookie('error', 'Selected Deadline is not valid', pathinfo(__FILE__)['filename']);
			return false;
		}

		return true;
	}

	public function deleteConfigValues()
	{
		$this->deleteCommonConfigValues();
		\Configuration::deleteByName('IFTHENPAY_IFTHENPAYGATEWAY_KEY');
		\Configuration::deleteByName('IFTHENPAY_IFTHENPAYGATEWAY_DEFAULT_METHOD');
		\Configuration::deleteByName('IFTHENPAY_IFTHENPAYGATEWAY_METHODS');
		\Configuration::deleteByName('IFTHENPAY_IFTHENPAYGATEWAY_SHOW_LOGO');
		\Configuration::deleteByName('IFTHENPAY_IFTHENPAYGATEWAY_TITLE');
		\Configuration::deleteByName('IFTHENPAY_IFTHENPAYGATEWAY_DEADLINE');
		\Configuration::deleteByName('IFTHENPAY_IFTHENPAYGATEWAY_CLOSE_BTN');
		\Configuration::deleteByName('IFTHENPAY_IFTHENPAYGATEWAY_URL_CALLBACK');
		\Configuration::deleteByName('IFTHENPAY_IFTHENPAYGATEWAY_CHAVE_ANTI_PHISHING');
		\Configuration::deleteByName('IFTHENPAY_IFTHENPAYGATEWAY_CANCEL_ORDER_AFTER_TIMEOUT');
	}


	/**
	 * generates an assoc array specifically for populating the select box of deadline of dynamic ifthenpaygateway reference
	 *
	 * @return void
	 */
	public function getDeadlineOptions()
	{
		$options = array();

		$options[] = array(
			"id" => '999999',
			"name" => $this->ifthenpayModule->l('No Deadline', pathinfo(__FILE__)['filename'])
		);

		for ($i = 0; $i < 32; $i++) {
			$options[] = array(
				"id" => $i,
				"name" => $i
			);
		}
		foreach ([45, 60, 90, 120] as $val) {
			$options[] = array(
				"id" => $val,
				"name" => $val
			);
		}

		return $options;
	}


	private function setGatewayKeyOptions()
	{

		$gatewayKeys = $this->ifthenpayGateway->getIthenpaygatewayKeys();

		foreach ($gatewayKeys as $gatewayKey) {
			$this->options[] = [
				'value' => $gatewayKey['GatewayKey'],
				'name' => $gatewayKey['Alias'],
				'type' => $gatewayKey['Tipo']
			];
		}
	}

	public function getGatewayKeySettingsFromConfig(string $gatewayKey): array
	{
		$ifthenpaygatewayAccounts = (array) unserialize($this->ifthenpayController->config->get('payment_ifthenpaygateway_userAccount')) ?? [];

		$gatewayKeySettings = array_filter($ifthenpaygatewayAccounts, function ($item) use ($gatewayKey) {
			if ($item['GatewayKey'] === $gatewayKey) {
				return true;
			}
		});

		$gatewayKeySettings = reset($gatewayKeySettings);
		return $gatewayKeySettings;
	}



	private function generateSelectGatewayKey(array $gatewayKeys, string $selectedKey = '')
	{
		$optionsHtml = '<option value=""></option>';

		foreach ($gatewayKeys as $gatewayKey) {
			$selectedStr = $gatewayKey['GatewayKey'] === $selectedKey ? 'selected=""' : '';

			$optionsHtml .= '<option value="' . $gatewayKey['GatewayKey'] . '" data-type="' . $gatewayKey['Tipo'] . '" ' . $selectedStr . '>' . $gatewayKey['Alias'] . '</option>';
		}

		$html = '<select name="IFTHENPAY_IFTHENPAYGATEWAY_KEY" class="fixed-width-xl" id="ifthenpayIfthenpaygatewayKey">' . $optionsHtml . '</select>';

		return $html;
	}


	private function isGatewayKeyStatic(array $gatewayKeySettings): bool
	{
		return $gatewayKeySettings['Tipo'] === 'Estáticas';
	}



	public function generateIfthenpaygatewayDefaultPaymentMethodSelectionHtml(string $ifthenpaygatewayKey): string
	{

		$storedDefaultPaymentMethod = Configuration::get('IFTHENPAY_IFTHENPAYGATEWAY_DEFAULT_PAYMENT_METHOD');



		if ($ifthenpaygatewayKey == '') {
			return '<p>' . $this->ifthenpayModule->l('Please select a Ifthenpay Gateway key to view this field.', pathinfo(__FILE__)['filename']) . '</p>';
		}


		$backofficeKey = Configuration::get('IFTHENPAY_BACKOFFICE_KEY');

		$paymentMethodGroupArray = $this->ifthenpayGateway->getIfthenpayGatewayPaymentMethodsDataByBackofficeKeyAndGatewayKey($backofficeKey, $ifthenpaygatewayKey);


		$html = '';

		$index = 0;
		$accountOptions = '<option value="' . $index . '">' . $this->ifthenpayModule->l('None', pathinfo(__FILE__)['filename']) . '</option>';

		foreach ($paymentMethodGroupArray as $paymentMethodGroup) {
			$index++;

			$isDisabled = '';
			if (isset($storedMethods[$paymentMethodGroup['Entity']]['is_active'])) {
				$isDisabled = $storedMethods[$paymentMethodGroup['Entity']]['is_active'] ? '' : 'disabled';
			}
			// disable option if no accounts exist
			if (empty($paymentMethodGroup['accounts'])) {
				$isDisabled = 'disabled';
			}

			$selectedStr = $index == $storedDefaultPaymentMethod ? 'selected' : '';

			$accountOptions .= <<<HTML
			'<option value="{$index}" data-method="{$paymentMethodGroup['Entity']}" {$selectedStr} {$isDisabled}>{$paymentMethodGroup['Method']}</option>'
			HTML;
		}


		$html = <<<HTML
		<select name="IFTHENPAY_IFTHENPAYGATEWAY_DEFAULT_METHOD" id="payment_ifthenpaygateway_default" class="form-control">
			{$accountOptions}
		</select>
		HTML;


		return $html;
	}


	public function generateIfthenpaygatewayPaymentMethodsHtml(string $ifthenpaygatewayKey, array $storedMethods): string
	{
		if ($ifthenpaygatewayKey == '') {
			return '<p>' . $this->ifthenpayModule->l('Please select a Ifthenpay Gateway key to view this field.', pathinfo(__FILE__)['filename']) . '</p>';
		}


		$backofficeKey = \Configuration::get('IFTHENPAY_BACKOFFICE_KEY');

		$paymentMethodGroupArray = $this->ifthenpayGateway->getIfthenpayGatewayPaymentMethodsDataByBackofficeKeyAndGatewayKey($backofficeKey, $ifthenpaygatewayKey);

		$gatewayKeySettings = $this->ifthenpayGateway->getIthenpaygatewayKeys();


		$isStaticGatewayKey = $this->isGatewayKeyStatic($gatewayKeySettings);
		$html = '';

		$hiddenInputs = '';
		foreach ($paymentMethodGroupArray as $paymentMethodGroup) {
			$accountOptions = '';
			$hiddenInput = '';

			$entity = $paymentMethodGroup['Entity']; // unique identifier code like 'MB' or 'MULTIBANCO'

			$index = 0;
			foreach ($paymentMethodGroup['accounts'] as $account) {

				if ($index === 0) {
					$hiddenInput = <<<HTML
					<input type="hidden" name="IFTHENPAY_IFTHENPAYGATEWAY_METHODS[{$paymentMethodGroup['Entity']}][account]" value="{$account['Conta']}">
					HTML;
				}
				$index++;

				// set selected payment method key
				$selectedStr = '';
				if (isset($storedMethods[$entity]['account'])) {
					$selectedStr = $account['Conta'] == $storedMethods[$entity]['account'] ? 'selected' : '';
					$hiddenInput = <<<HTML
					<input type="hidden" name="IFTHENPAY_IFTHENPAYGATEWAY_METHODS[{$paymentMethodGroup['Entity']}][account]" value="{$account['Conta']}">
					HTML;
				}


				$accountOptions .= <<<HTML
				<option value="{$account['Conta']}" {$selectedStr}>{$account['Alias']}</option>
				HTML;
			}

			if ($hiddenInput !== '') {
				$hiddenInputs .= $hiddenInput;
			}



			$checkDisabledStr = $accountOptions === '' ? 'disabled' : '';
			$selectDisabledStr = ($accountOptions === '' || $isStaticGatewayKey) ? 'disabled' : '';
			$checkedStr = '';


			if ($accountOptions !== '') {
				// show method account select


				$selectOrActivate = <<<HTML
				<select {$selectDisabledStr} name="IFTHENPAY_IFTHENPAYGATEWAY_METHODS[{$paymentMethodGroup['Entity']}][account]" id="{$paymentMethodGroup['Entity']}" class="form-control">
					{$accountOptions}
				</select>
				HTML;

				// add hidden select inputs
				if ($selectDisabledStr === 'disabled') {
					$selectOrActivate .= $hiddenInputs;
				}

				// if the isActive is saved use it
				$checkedStr = (isset($storedMethods[$entity]['is_active']) && $storedMethods[$entity]['is_active'] == '1') || !$storedMethods ? 'checked' : '';
			} else {
				// show request button
				$selectOrActivate = <<<HTML
				<button type="button" title="request payment method" class="btn btn-primary min_w_300 request_ifthenpaygateway_method" data-method="{$paymentMethodGroup['Entity']}">
				button label findme {$paymentMethodGroup['Method']}
					<span class="glyphicon glyphicon glyphicon-send"></span>
				</button>
				HTML;

				$requestPaymentMethodUrl = \Context::getContext()->link->getAdminLink('AdminIfthenpayActivateNewGatewayMethod') . "&paymentMethod=" . $entity . "&gatewayKey=" . $ifthenpaygatewayKey;

				$selectOrActivate = '<a class="btn btn-primary width_100" href="' . $requestPaymentMethodUrl . '" role="button">' . $this->ifthenpayModule->l('Request Ifthenpay Gateway Method ', pathinfo(__FILE__)['filename']) . $paymentMethodGroup['Method'] . '</a>';
			}




			$html .= <<<HTML
			<div class="method_line">


				<input type="hidden" name="IFTHENPAY_IFTHENPAYGATEWAY_METHODS[{$paymentMethodGroup['Entity']}][method_name]" value="{$paymentMethodGroup['Method']}"/>
				<input type="hidden" name="IFTHENPAY_IFTHENPAYGATEWAY_METHODS[{$paymentMethodGroup['Entity']}][image_url]" value="{$paymentMethodGroup['SmallImageUrl']}"/>
				<div class="method_checkbox">
					<label>
						<input type="hidden" name="IFTHENPAY_IFTHENPAYGATEWAY_METHODS[{$paymentMethodGroup['Entity']}][is_active]" value="0"/>
						<input type="checkbox" name="IFTHENPAY_IFTHENPAYGATEWAY_METHODS[{$paymentMethodGroup['Entity']}][is_active]" value="1" {$checkedStr} {$checkDisabledStr} data-method="{$paymentMethodGroup['Entity']}" class="method_checkbox_input"/>
						<img src="{$paymentMethodGroup['ImageUrl']}" alt="{$paymentMethodGroup['Method']}"/>
					</label>
				</div>
				<div class="method_select">
					{$selectOrActivate}
				</div>
			</div>
			HTML;
		}

		return $html;
	}
}
