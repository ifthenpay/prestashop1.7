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
use PrestaShop\Module\Ifthenpay\Factory\Models\IfthenpayModelFactory;
use PrestaShop\Module\Ifthenpay\Factory\Request\RequestFactory;



class IfthenpayCancelMbwayOrderModuleFrontController extends ModuleFrontController
{

    public $ssl = true;
    private $urlCheckMbwayPaymentStatus = 'https://www.ifthenpay.com/mbwayws/ifthenpaymbw.asmx/EstadoPedidosJSON';
    private $webservice;




    public function displayAjax()
    {
        try {
            if (Tools::getValue('action') === 'cancelMbwayOrder') {
                \Context::getContext()->cookie->__unset('mbwayCountdownShow');


                $this->webservice = RequestFactory::buildWebservice();

                $orderId  = Tools::getValue('orderId');
                $mbwayKey = Configuration::get('IFTHENPAY_MBWAY_KEY');
                $paymentData = IfthenpayModelFactory::build('mbway')->getByOrderId((string) $orderId);
                $requestId = $paymentData['id_transacao'];


                $request = $this->webservice->getRequest(
                    $this->urlCheckMbwayPaymentStatus,
                    [
                        'MbWayKey' => $mbwayKey,
                        'canal' => 3,
                        'idspagamento' => $requestId
                    ]
                );

                $response = $request->getResponseJson();

                $status = $response['EstadoPedidos'][0]['Estado'];

                $statusCode = array(
                    'refusedByUser' => '020',
                    'paid' => '000',
                    'pending' => '123'
                );



                if ($status === $statusCode['pending']) {
                    die(json_encode(
                        ['orderStatus' => 'pending']
                    ));
                }
                if ($status === $statusCode['refusedByUser']) {
                    die(json_encode(
                        ['orderStatus' => 'refused']
                    ));
                }
                if ($status === $statusCode['paid']) {
                    die(json_encode(
                        ['orderStatus' => 'paid']
                    ));
                }

                // if none of the above send an error
                die(json_encode(
                    ['orderStatus' => 'error']
                ));
            }
        } catch (\Throwable $th) {
            \Context::getContext()->cookie->__unset('mbwayCountdownShow');
            IfthenpayLogProcess::addLog('Error retrieving mbway order status by ajax request - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, 0);
            die(json_encode(
                [
                    'error' => $th->getMessage()
                ]
            ));
        }
    }
}
