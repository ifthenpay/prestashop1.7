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

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;
use PrestaShop\Module\Ifthenpay\Utility\Utility;

class AdminIfthenpayActivateNewGatewayMethodController extends ModuleAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;

    }

    public function initContent()
    {
        parent::initContent();

		$gatewayKey = $_GET['gatewayKey'] ?? '';
        $paymentMethod = $_GET['paymentMethod'] == 'MB' ? 'MULTIBANCO' : $_GET['paymentMethod'];


        $psVersion = _PS_VERSION_ ?? '';

		$module = Module::getInstanceByName('ifthenpay');
		$moduleVersion = $module->version;

        $mailVars = [
            '{backoffice_key}' => Configuration::get('IFTHENPAY_BACKOFFICE_KEY'),
			'{gateway_key}' => $gatewayKey,
            '{store_email}' => Configuration::get('PS_SHOP_EMAIL'),
            '{store_name}' => Configuration::get('PS_SHOP_NAME'),
			'{payment_method}' => $paymentMethod,
            '{ecommerce_platform}' => "Prestashop " . $psVersion,
			'{module_version}' => $moduleVersion,
        ];


        try {
            \Mail::Send(
                (int)Configuration::get('PS_LANG_DEFAULT'),
                'activateGatewayMethod',
                $paymentMethod . ': Ativação de Serviço',
                $mailVars,
                'suporte@ifthenpay.com',
                'Ifthenpay',
                null,
                null,
                null,
                null,
                _PS_MODULE_DIR_ . 'ifthenpay/mails/',
                false,
                null
            );

            Utility::setPrestashopCookie('success', sprintf($this->module->l('%s gateway method request sent with email %s'), $paymentMethod, Configuration::get('PS_SHOP_EMAIL')));
            IfthenpayLogProcess::addLog('Email associate method with gateway sent with success', IfthenpayLogProcess::INFO, 0);
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminIfthenpayPaymentMethodSetup') . '&paymentMethod=ifthenpaygateway');
        } catch (\Throwable $th) {
            Utility::setPrestashopCookie('error', sprintf($this->module->l('Error sending %s gateway method request with email %s'), $paymentMethod, Configuration::get('PS_SHOP_EMAIL')));
            IfthenpayLogProcess::addLog('Error sent email associate gateway method - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, 0);
        }
    }
}
