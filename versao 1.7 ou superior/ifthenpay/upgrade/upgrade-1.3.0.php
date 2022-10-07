<?php
/**
 * File: /upgrade/upgrade-1.3.0.php
 * @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
 *  @copyright 2007-2022 Ifthenpay Lda
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * add the required column for validade in ifthenpay_multibanco table
 *
 * @param [type] $module
 * @return void
 */
function upgrade_module_1_3_0($module)
{
    // Process Module upgrade to 1.3.0

    IfthenpayLogProcess::addLog('Running module upgrade to version 1.3.0', IfthenpayLogProcess::INFO, 0);


    $resultOfValidade = addColumnValidade();
    $resultOfRequestId = addColumnRequestId();

    if ($resultOfRequestId == $resultOfValidade && $resultOfValidade == true) {
        return true;
    }
    return false;
}

function addColumnValidade()
{
    // verify if column already exists
    $count = DB::getInstance()->getValue('SELECT count(*) FROM INFORMATION_SCHEMA.COLUMNS
  WHERE `TABLE_NAME` = "' . _DB_PREFIX_ . 'ifthenpay_multibanco"
  AND `TABLE_SCHEMA` = "' . _DB_NAME_ . '"
  AND `COLUMN_NAME` = "validade"');
    if ($count == 0) {
        $result = Db::getInstance()->execute('ALTER TABLE `' . _DB_PREFIX_ . 'ifthenpay_multibanco` ADD `validade` VARCHAR(16) NULL');
        IfthenpayLogProcess::addLog('Ran upgrade script 1.3.0 (addColumnValidade()) with result code = ' . $result, IfthenpayLogProcess::INFO, 0);

        return $result == 1 ? true : false;
    }
    return true;
}

function addColumnRequestId()
{
    // verify if column already exists
    $count = DB::getInstance()->getValue('SELECT count(*) FROM INFORMATION_SCHEMA.COLUMNS
  WHERE `TABLE_NAME` = "' . _DB_PREFIX_ . 'ifthenpay_multibanco"
  AND `TABLE_SCHEMA` = "' . _DB_NAME_ . '"
  AND `COLUMN_NAME` = "request_id"');
    if ($count == 0) {
        $result = Db::getInstance()->execute('ALTER TABLE `' . _DB_PREFIX_ . 'ifthenpay_multibanco` ADD `request_id` VARCHAR(50) NULL');
        IfthenpayLogProcess::addLog('Ran upgrade script 1.3.0 (addColumnRequestId()) with result code = ' . $result, IfthenpayLogProcess::INFO, 0);

        return $result == 1 ? true : false;
    }
    return true;
}
