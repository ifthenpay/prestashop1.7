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

use Ifthenpay as GlobalIfthenpay;
use PrestaShop\Module\Ifthenpay\Utility\Utility;
use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;
use PrestaShop\Module\Ifthenpay\Factory\Payment\GatewayFactory;
use PrestaShop\Module\Ifthenpay\Factory\Config\IfthenpayConfigFormsFactory;
use PrestaShop\Module\Ifthenpay\Factory\Database\DatabaseFactory;


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

            $this->deleteIfthenpayAccountData();

            Utility::setPrestashopCookie('success', 'Ifthenpay account reseted with success');
            IfthenpayLogProcess::addLog('Ifthenpay account backoffice key and configuration reseted with success', IfthenpayLogProcess::INFO, 0);

        } catch (\Throwable $th) {
            Utility::setPrestashopCookie('error', 'Error reseting ifthenpay account');
            IfthenpayLogProcess::addLog('Error reseting ifthenpay account - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, 0);
            die(json_encode(
                [
                    'error' => $th->getMessage()
                ]
            ));
        }
    }

    public function ajaxProcessGetLogsTable(){

        $page = Tools::getValue('page');
        $range = '50';
        $queryRow = (((int)$page - 1) * (int)$range);

        $query = DatabaseFactory::buildDbQuery();
        $query->from('ifthenpay_log');
        $query->orderBy('created DESC LIMIT '. $queryRow . ', ' . $range);
        $content = \Db::getInstance()->executeS($query);

        $fields_list = array(
            'id_ifthenpay_log' => array(
                'title' => 'ID',
                'align' => 'center',
            ),
            'type' => array(
                'title' => 'Type',
                'type' => 'text',
            ),
            'message' => array(
                'title' => 'Message',
                'type' => 'text',
            ),
            'order_id' => array(
                'title' => 'Order',
                'type' => 'text',
                'align' => 'center'
            ),
            'created' => array(
                'title' => 'Date',
                'type' => 'text',
                'align' => 'center'
            ),
        );

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = true;
        $helper->show_toolbar = false;
        $helper->listTotal = count($content);
        $helper->identifier = 'id_ifthenpay_log';
        $helper->table = 'ifthenpay_log';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . 'ifthenpay';
        $helper->no_link = true;


        $logTable = $helper->generateList($content, $fields_list);

        $query = DatabaseFactory::buildDbQuery();
        $query->select('count(*)');
        $query->from('ifthenpay_log');
        // $query->orderBy('created DESC LIMIT 2, 5');
        $result = \Db::getInstance()->getValue($query);

        $pagination = Utility::numberToPagination($result, $page);


        die(json_encode(
            [
                'table' => $logTable,
                'pagination' => $pagination
            ]
        ));

    }

    private function deleteIfthenpayAccountData()
    {
        $ifthenpayGateway = GatewayFactory::build('gateway');

        // global config to delete only once
        \Configuration::deleteByName('IFTHENPAY_BACKOFFICE_KEY');
        \Configuration::deleteByName('IFTHENPAY_USER_PAYMENT_METHODS');
        \Configuration::deleteByName('IFTHENPAY_USER_ACCOUNT');
        \Configuration::deleteByName('IFTHENPAY_ACTIVATE_SANDBOX_MODE');
        \Configuration::deleteByName('IFTHENPAY_PAYMENT_METHODS_SAVED');


        foreach ($ifthenpayGateway->getPaymentMethodsType() as $pm) {
            if ($pm != 'ifthenpay') {

                IfthenpayConfigFormsFactory::build('ifthenpayConfigForms', $pm, $this->module)->deleteConfigFormValues();
            }
        }
    }
}
