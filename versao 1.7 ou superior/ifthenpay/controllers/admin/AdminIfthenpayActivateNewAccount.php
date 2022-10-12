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

class AdminIfthenpayActivateNewAccountController extends ModuleAdminController
{
    private $paymentMethod;

    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->paymentMethod = $_GET['paymentMethod'];
    }

    public function initContent()
    {
        Utility::checkPaymentMethodDefined();

        parent::initContent();

        $updateUserToken = md5((string) rand());

        Configuration::updateValue('IFTHENPAY_UPDATE_USER_ACCOUNT_TOKEN', $updateUserToken);

        $psVersion = _PS_VERSION_ ?? '';

        $mailVars = [
            '{paymentMethod}' => $this->paymentMethod,
            '{backofficeKey}' => Configuration::get('IFTHENPAY_BACKOFFICE_KEY'),
            '{customerEmail}' => Configuration::get('PS_SHOP_EMAIL'),
            '{storeName}' => Configuration::get('PS_SHOP_NAME'),
            '{ecommercePlatform}' => "Prestashop " . $psVersion,

            '{updateUserAccountUrl}' => $this->context->link->getModuleLink(
                'ifthenpay',
                'updateIfthenpayUserAccount',
                ['updateUserToken' => $updateUserToken]
            ),
        ];

        try {
            \Mail::Send(
                (int)Configuration::get('PS_LANG_DEFAULT'),
                'activateAccount',
                'Associar conta ' . $this->paymentMethod . ' ao contrato',
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

            $config = str_replace(" ", "_", $this->paymentMethod);

            Configuration::updateValue('IFTHENPAY_ACTIVATE_NEW_' . \Tools::strtoupper($config) .  '_ACCOUNT', true);
            Utility::setPrestashopCookie('success', sprintf($this->module->l('%s account request sent with email %s'), $this->paymentMethod, Configuration::get('PS_SHOP_EMAIL')));
            IfthenpayLogProcess::addLog('Email associate account sent with success', IfthenpayLogProcess::INFO, 0);
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->module->name);
        } catch (\Throwable $th) {
            Utility::setPrestashopCookie('error', sprintf($this->module->l('Error sending %s account request with email %s'), $this->paymentMethod, Configuration::get('PS_SHOP_EMAIL')));
            IfthenpayLogProcess::addLog('Error sent email associate account - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, 0);
        }
    }
}
