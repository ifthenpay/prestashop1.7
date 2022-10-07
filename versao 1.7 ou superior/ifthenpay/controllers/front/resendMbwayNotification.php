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
use PrestaShop\Module\Ifthenpay\Factory\Builder\BuilderFactory;
use PrestaShop\Module\Ifthenpay\Factory\Payment\GatewayFactory;
use PrestaShop\Module\Ifthenpay\Factory\Models\IfthenpayModelFactory;

class IfthenpayResendMbwayNotificationModuleFrontController extends ModuleFrontController
{

    public $ssl = true;

    public function initContent()
    {
        parent::initContent();

        $orderId = Tools::getValue('orderId');
        $mbwayTelemovel = Tools::getValue('mbwayTelemovel');
        $totalToPay = Tools::getValue('orderTotalPay');
        $cartId = Tools::getValue('cartId');
        $customerSecureKey = Tools::getValue('customerSecureKey');
        $redirectLink =  $this->context->link->getPageLink('order-confirmation', true) .
        '?id_cart='.(int)$cartId . '&id_module='. (int)$this->module->id . '&id_order=' . $orderId . '&key='.
            $customerSecureKey . '&paymentOption=mbway';

        $paymentData = BuilderFactory::build('gateway')
            ->setMbwayKey(Configuration::get('IFTHENPAY_MBWAY_KEY'))
            ->setTelemovel($mbwayTelemovel);

        try {
            $gatewayResult = GatewayFactory::build('gateway')->execute(
                'mbway',
                $paymentData,
                strval($orderId),
                strval($totalToPay)
            )->getData();
            $ifthenpayMbway = IfthenpayModelFactory::build('mbway');
            $mbwayDB = $ifthenpayMbway->getByOrderId($orderId);
            $ifthenpayMbway = IfthenpayModelFactory::build('mbway', $mbwayDB['id_ifthenpay_mbway']);
            $ifthenpayMbway->id_transacao = $gatewayResult->idPedido;
            $ifthenpayMbway->update();
            Utility::setPrestashopCookie('mbwayResendNotificationSent', true);
            IfthenpayLogProcess::addLog('Resend MB WAY notification (front-end) with success', IfthenpayLogProcess::INFO, (int) $orderId);
            $this->success[] = $this->module->l('MB WAY notification successfully resent, confirm payment on your MB WAY app.', pathinfo(__FILE__)['filename']);
            $this->redirectWithNotifications($redirectLink);
        } catch (\Throwable $th) {
            IfthenpayLogProcess::addLog('Error resending mbway notification (front-end) - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, (int) $orderId);
            $this->errors[] = $this->module->l('Error sending MB WAY notification, please contact the store administrator.', pathinfo(__FILE__)['filename']);
            $this->redirectWithNotifications($redirectLink);
        }
    }
}
