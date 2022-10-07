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

use PrestaShop\Module\Ifthenpay\Utility\Utility;
use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;
use PrestaShop\Module\Ifthenpay\Factory\Payment\GatewayFactory;
use PrestaShop\Module\Ifthenpay\Factory\Models\IfthenpayModelFactory;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;
use PrestaShop\Module\Ifthenpay\Factory\IfthenpayStrategyFactory;

class AdminIfthenpayChooseNewPaymentMethodController extends ModuleAdminController
{

    public function postProcess()
    {
        try {
            $orderId = Tools::getValue('orderId');
            $mbwayPhone = Tools::getValue('mbwayPhone');

            if (!$orderId) {
                die('orderId not defined');
            } else {
                $ifthenpayGateway = GatewayFactory::build('gateway');
                $order = PrestashopModelFactory::buildOrder($orderId);
                if ($ifthenpayGateway->checkIfthenpayPaymentMethod($order->payment)) {
                    $paymentMethod = Tools::getValue('newPaymentMethod');
                    $ifthenpayModel = IfthenpayModelFactory::build($order->payment);
                    $data = $ifthenpayModel->getByOrderId((string)$order->id);
                    IfthenpayModelFactory::build($order->payment, $data['id_ifthenpay_' . $order->payment])->delete();
                    $order->payment = $paymentMethod;
                    $order->save();

                    if ($mbwayPhone) {
                        \Configuration::updateValue('IFTHENPAY_MBWAY_PHONE_BO_CREATED' . $order->id, $mbwayPhone);
                        IfthenpayStrategyFactory::build('ifthenpayAdminResend', $order, $this->module)->execute();
                    }

                    $new_history = PrestashopModelFactory::buildOrderHistory();
                    $new_history->id_order = (int) $order->id;
                    $new_history->changeIdOrderState((int) \Configuration::get('IFTHENPAY_' . Tools::strtoupper($order->payment) . '_OS_WAITING'), (int) $order->id);
                    $new_history->addWithemail(true);
                    IfthenpayLogProcess::addLog('Payment method changed with success to ' . $paymentMethod, IfthenpayLogProcess::INFO, $order->id);

                    Utility::setPrestashopCookie('success', $this->module->l('Payment method changed with success!', pathinfo(__FILE__)['filename']));
                }
                Utility::redirectAdminOrder($order);
            }
        } catch (Exception $th) {
            IfthenpayLogProcess::addLog('Error changing payment method to ' . $paymentMethod . ' - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, $order->id);
            Utility::setPrestashopCookie('error', $this->module->l('Error changing payment method!', pathinfo(__FILE__)['filename']));
            Utility::redirectAdminOrder($order);
        }
    }
}
