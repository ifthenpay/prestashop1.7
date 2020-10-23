<?php
/**
 * 2007-2020 Ifthenpay Lda
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
 * @copyright 2007-2020 Ifthenpay Lda
 * @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */


if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;
use PrestaShop\Module\Ifthenpay\Factory\Callback\CallbackFactory;
use PrestaShop\Module\Ifthenpay\Factory\Models\IfthenpayModelFactory;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;

class IfthenpayCallbackModuleFrontController extends ModuleFrontController
{

    public function initContent()
    {
        parent::initContent();
        $paymentMethod = $_GET['payment'];

        $paymentData = CallbackFactory::buildCalllbackData($_GET)->execute();
        $order = PrestashopModelFactory::buildOrder($paymentData['order_id']);

        if (empty($paymentData)) {
            IfthenpayLogProcess::addLog('Callback Payment not found - ' . print_r($_GET, 1), IfthenpayLogProcess::ERROR, $order->id);
            http_response_code(404);
            die('Pagamento não encontrado');
        } else {
            try {
                CallbackFactory::buildCalllbackValidate($_GET, $order, Configuration::get('IFTHENPAY_' . Tools::strtoupper($paymentMethod) . '_CHAVE_ANTI_PHISHING'), $paymentData)
                    ->validate();
                IfthenpayLogProcess::addLog('Callback validated with success', IfthenpayLogProcess::INFO, $order->id);
                $ifthenpayModel = IfthenpayModelFactory::build($paymentMethod, $paymentData['id_ifthenpay_' . $paymentMethod]);
                $ifthenpayModel->status = 'paid';
                $ifthenpayModel->update();
                IfthenpayLogProcess::addLog('Callback payment status updated with success', IfthenpayLogProcess::INFO, $order->id);
                $new_history = PrestashopModelFactory::buildOrderHistory();
                $new_history->id_order = (int) $order->id;
                $new_history->changeIdOrderState((int) Configuration::get('IFTHENPAY_' . Tools::strtoupper($paymentMethod) . '_OS_CONFIRMED'), (int) $order->id);
                $new_history->addWithemail(true);
                IfthenpayLogProcess::addLog('Callback order status change with success', IfthenpayLogProcess::INFO, $order->id);
                http_response_code(200);
                die('ok');
            } catch (\Throwable $th) {
                IfthenpayLogProcess::addLog('Error processing callback - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, $order->id);
                http_response_code(404);
                die($th->getMessage());
            }
        }
    }
}
