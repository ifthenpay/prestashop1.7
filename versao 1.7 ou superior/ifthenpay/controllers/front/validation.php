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
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;

class IfthenpayValidationModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        $cart = $this->context->cart;
        $paymentOption = Tools::getValue('paymentOption');

        if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        // Check that this payment option is still available in case the customer changed his address just before the end of the checkout process
        $authorized = false;
        foreach (Module::getPaymentModules() as $module) {
            if ($module['name'] === $this->module->name) {
                $authorized = true;
                break;
            }
        }

        if (!$authorized) {
            die($this->module->l('This payment method is not available.', pathinfo(__FILE__)['filename']));
        }

        $isAuthorized = $this->isAuthorized($paymentOption);

        if ($isAuthorized !== true) {
            IfthenpayLogProcess::addLog('Validate order, payment not authorized - ' . $isAuthorized, IfthenpayLogProcess::ERROR, 0);
            $this->errors[] = Tools::displayError($isAuthorized);
            $this->redirectWithNotifications('index.php?controller=order&step=3');
        } else {
            $customer = PrestashopModelFactory::buildCustomer((string) $cart->id_customer);

            if (!Validate::isLoadedObject($customer)) {
                Tools::redirect('index.php?controller=order&step=1');
            }

            $currency = $this->context->currency;
            $total = (float)$cart->getOrderTotal(true, Cart::BOTH);

            $mailVars = [];

            try {
                $this->module->validateOrder(
                    (int)$cart->id,
                    Configuration::get('IFTHENPAY_' . Tools::strtoupper($paymentOption) . '_OS_WAITING'),
                    $total,
                    $paymentOption,
                    null,
                    $mailVars,
                    (int)$currency->id,
                    false,
                    $customer->secure_key
                );
                // unnecessary log, uncomment for testing
                // IfthenpayLogProcess::addLog('Order validated with success', IfthenpayLogProcess::INFO, 0);
                Tools::redirect(
                    'index.php?controller=order-confirmation&id_cart='.(int)$cart->id.'&id_module=' . (int)$this->module->id . '&id_order=' .
                    $this->module->currentOrder . '&key=' .$customer->secure_key . '&paymentOption=' . $paymentOption
                );
            } catch (\Throwable $th) {
                IfthenpayLogProcess::addLog('Error validating order - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, 0);
                throw $th;
            }
        }
    }

    /**
     * Only validates mbway
     *
     * @param [type] $paymentOption
     * @return boolean
     */
    private function isAuthorized($paymentOption)
    {
        if (!Configuration::get('IFTHENPAY_' . strtoupper($paymentOption))) {
            return false;
        }

        if ($paymentOption === 'mbway') {
            $mbwayPhone = Tools::getValue("ifthenpayMbwayPhone");
            if (!$mbwayPhone) {
                return $this->module->l('MB WAY phone is required.', pathinfo(__FILE__)['filename']);
            }
            if (strlen($mbwayPhone) < 9) {
                return $this->module->l('MB WAY phone is not valid.', pathinfo(__FILE__)['filename']);
            }
            Configuration::updateValue('IFTHENPAY_MBWAY_PHONE_' . $this->context->cart->id, $mbwayPhone);
        }
        return true;
    }
}
