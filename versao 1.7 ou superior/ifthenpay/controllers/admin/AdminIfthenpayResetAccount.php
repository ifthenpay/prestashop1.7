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

use PrestaShop\Module\Ifthenpay\Utility\Utility;
use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;
use PrestaShop\Module\Ifthenpay\Factory\Payment\GatewayFactory;

class AdminIfthenpayResetAccountController extends ModuleAdminController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
    }

    public function ajaxProcessResetIfthenpayAccount()
    {
        try {
            $backofficeKey = Configuration::get('IFTHENPAY_BACKOFFICE_KEY');

            if (!$backofficeKey) {
                IfthenpayLogProcess::addLog('Backoffice key not exist on database', IfthenpayLogProcess::ERROR, 0);
                die('Backoffice key is required!');
            }
            $ifthenpayGateway = GatewayFactory::build('gateway');
            $ifthenpayGateway->authenticate($backofficeKey);
            IfthenpayLogProcess::addLog('Backoffice key authenticated with success', IfthenpayLogProcess::INFO, 0);
            Configuration::updateValue('IFTHENPAY_USER_PAYMENT_METHODS', serialize($ifthenpayGateway->getPaymentMethods()));
            Configuration::updateValue('IFTHENPAY_USER_ACCOUNT', serialize($ifthenpayGateway->getAccount()));
            Utility::setPrestashopCookie('success', 'Ifthenpay account reseted with success');
            IfthenpayLogProcess::addLog('Ifthenpay account reseted with success', IfthenpayLogProcess::INFO, 0);
            die(json_encode(
                    [
                        'message' => 'Ifthenpay account reseted with success',
                    ]
                )
            );
        } catch (\Throwable $th) {
            Utility::setPrestashopCookie('error', 'Error reseting ifthenpay account');
            IfthenpayLogProcess::addLog('Error reseting ifthenpay account - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, 0);
            die(json_encode(
                    [
                        'error' => $th->getMessage()
                    ]
                )
            );
        }
    }
}
