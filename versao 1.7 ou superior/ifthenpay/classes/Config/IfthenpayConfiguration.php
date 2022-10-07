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

namespace PrestaShop\Module\Ifthenpay\Config;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Contracts\Config\InstallerInterface;


class IfthenpayConfiguration implements InstallerInterface
{
    private $configurationNames;
    private $userPaymentMethods;

    public function __construct($userPaymentMethods)
    {
        $this->userPaymentMethods = $userPaymentMethods;
        $this->configurationNames = [
            'IFTHENPAY_USER_PAYMENT_METHODS',
            'IFTHENPAY_BACKOFFICE_KEY',
            'IFTHENPAY_USER_PAYMENT_METHODS',
            'IFTHENPAY_USER_ACCOUNT',
            'IFTHENPAY_UPDATE_USER_ACCOUNT_TOKEN',
            'IFTHENPAY_ACTIVATE_SANDBOX_MODE',
        ];
    }

    private function uninstallByPaymentMethod()
    {


        \Configuration::deleteByName('IFTHENPAY_BACKOFFICE_KEY');
        \Configuration::deleteByName('IFTHENPAY_USER_PAYMENT_METHODS');
        \Configuration::deleteByName('IFTHENPAY_USER_ACCOUNT');
        \Configuration::deleteByName('IFTHENPAY_ACTIVATE_SANDBOX_MODE');
        \Configuration::deleteByName('IFTHENPAY_PAYMENT_METHODS_SAVED');



        foreach ($this->userPaymentMethods as $paymentMethod) {
            if ($paymentMethod) {

                \Configuration::deleteByName('IFTHENPAY_' . \Tools::strtoupper($paymentMethod) . '_OS_WAITING');
                \Configuration::deleteByName('IFTHENPAY_' . \Tools::strtoupper($paymentMethod) . '_OS_CONFIRMED');
                \Configuration::deleteByName('IFTHENPAY_' . \Tools::strtoupper($paymentMethod));

                \Configuration::deleteByName('IFTHENPAY_CALLBACK_ACTIVATED_FOR_' . strtoupper($paymentMethod));
                \Configuration::deleteByName('IFTHENPAY_' . strtoupper($paymentMethod . '_MINIMUM'));
                \Configuration::deleteByName('IFTHENPAY_' . strtoupper($paymentMethod . '_MAXIMUM'));
                \Configuration::deleteByName('IFTHENPAY_' . strtoupper($paymentMethod . '_COUNTRIES'));
                \Configuration::deleteByName('IFTHENPAY_' . strtoupper($paymentMethod . '_ORDER'));
                \Configuration::deleteByName('IFTHENPAY_' . strtoupper($paymentMethod));

                switch ($paymentMethod) {
                    case 'multibanco':
                        \Configuration::deleteByName('IFTHENPAY_MULTIBANCO_ENTIDADE');
                        \Configuration::deleteByName('IFTHENPAY_MULTIBANCO_SUBENTIDADE');
                        \Configuration::deleteByName('IFTHENPAY_MULTIBANCO_VALIDADE');
                        \Configuration::deleteByName('IFTHENPAY_MULTIBANCO_URL_CALLBACK');
                        \Configuration::deleteByName('IFTHENPAY_MULTIBANCO_CHAVE_ANTI_PHISHING');
                        break;
                    case 'mbway':
                        \Configuration::deleteByName('IFTHENPAY_MBWAY_KEY');
                        \Configuration::deleteByName('IFTHENPAY_MBWAY_URL_CALLBACK');
                        \Configuration::deleteByName('IFTHENPAY_MBWAY_CHAVE_ANTI_PHISHING');
                        \Configuration::deleteByName('IFTHENPAY_MBWAY_CANCEL_ORDER_AFTER_TIMEOUT');
                        \Configuration::deleteByName('IFTHENPAY_MBWAY_SHOW_COUNTDOWN');
                        break;
                    case 'payshop':
                        \Configuration::deleteByName('IFTHENPAY_PAYSHOP_KEY');
                        \Configuration::deleteByName('IFTHENPAY_PAYSHOP_VALIDADE');
                        \Configuration::deleteByName('IFTHENPAY_PAYSHOP_URL_CALLBACK');
                        \Configuration::deleteByName('IFTHENPAY_PAYSHOP_CHAVE_ANTI_PHISHING');
                        break;
                    case 'ccard':
                        \Configuration::deleteByName('IFTHENPAY_CCARD_KEY');
                        break;
                    default:
                }
            }
        }
    }

    public function install()
    {
        //not need install
    }

    public function uninstall()
    {
        foreach ($this->configurationNames as $configurationName) {
            \Configuration::deleteByName($configurationName);
        }
        if ($this->userPaymentMethods) {
            $this->uninstallByPaymentMethod();
        }
    }
}
