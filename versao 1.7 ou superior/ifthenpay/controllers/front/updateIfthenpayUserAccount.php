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
use PrestaShop\Module\Ifthenpay\Factory\Payment\GatewayFactory;

class IfthenpayUpdateIfthenpayUserAccountModuleFrontController extends ModuleFrontController
{

    public $ssl = true;

    public function initContent()
    {
        parent::initContent();

        $requestUserToken = $_GET['updateUserToken'];

        if (!$requestUserToken || $requestUserToken !== Configuration::get('IFTHENPAY_UPDATE_USER_ACCOUNT_TOKEN')) {
            IfthenpayLogProcess::addLog('Authorization token is invalid', IfthenpayLogProcess::ERROR, 0);
            http_response_code(403);
            die('Not Authorized');
        }

        try {
            $backofficeKey = Configuration::get('IFTHENPAY_BACKOFFICE_KEY');

            if (!$backofficeKey) {
                IfthenpayLogProcess::addLog('Backoffice key does not exist on database', IfthenpayLogProcess::ERROR, 0);
                die('Backoffice key is required!');
            }

            $ifthenpayGateway = GatewayFactory::build('gateway');

            $ifthenpayGateway->authenticate($backofficeKey);
            IfthenpayLogProcess::addLog('Backoffice key authenticated with success', IfthenpayLogProcess::INFO, 0);
            Configuration::updateValue('IFTHENPAY_USER_PAYMENT_METHODS', serialize($ifthenpayGateway->getPaymentMethods()));
            Configuration::updateValue('IFTHENPAY_USER_ACCOUNT', serialize($ifthenpayGateway->getAccount()));
            Configuration::deleteByName('IFTHENPAY_UPDATE_USER_ACCOUNT_TOKEN');
            IfthenpayLogProcess::addLog('Ifthenpay user account updated with success', IfthenpayLogProcess::INFO, 0);
            http_response_code(200);
            die('User Account updated with success!');
        } catch (\Throwable $th) {
            IfthenpayLogProcess::addLog('Error updating ifthenpay user account - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, 0);
            http_response_code(400);
            die($th->getMessage());
        }
    }
}
