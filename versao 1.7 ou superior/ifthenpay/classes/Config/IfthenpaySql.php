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

use PrestaShop\Module\Ifthenpay\Utility\Utility;
use PrestaShop\Module\Ifthenpay\Contracts\Config\InstallerInterface;

class IfthenpaySql implements InstallerInterface
{
    private $ifthenpayModule;
    private $userPaymentMethods;

    private $ifthenpaySqlTables = [
        'multibanco' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_multibanco` (
            `id_ifthenpay_multibanco` int(10) unsigned NOT NULL auto_increment,
            `entidade` varchar(5) NOT NULL,
            `referencia` varchar(9) NOT NULL,
            `validade` varchar(16),
            `request_id` varchar(50),
            `order_id` int(11) NOT NULL,
            `status` varchar(50) NOT NULL,
            PRIMARY KEY  (`id_ifthenpay_multibanco`),
            INDEX `referencia` (`referencia`)
          ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
        'mbway' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_mbway` (
            `id_ifthenpay_mbway` int(10) unsigned NOT NULL auto_increment,
            `id_transacao` varchar(20) NOT NULL,
            `telemovel` varchar(20) NOT NULL,
            `order_id` int(11) NOT NULL,
            `status` varchar(50) NOT NULL,
            PRIMARY KEY  (`id_ifthenpay_mbway`),
            INDEX `idTransacao` (`id_transacao`)
          ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
        'payshop' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_payshop` (
            `id_ifthenpay_payshop` int(10) unsigned NOT NULL auto_increment,
            `id_transacao` varchar(20) NOT NULL,
            `referencia` varchar(13) NOT NULL,
            `validade` varchar(8) NOT NULL,
            `order_id` int(11) NOT NULL,
            `status` varchar(50) NOT NULL,
            PRIMARY KEY  (`id_ifthenpay_payshop`),
            INDEX `idTransacao` (`id_transacao`)
          ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
          'ccard' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_ccard` (
            `id_ifthenpay_ccard` int(10) unsigned NOT NULL auto_increment,
            `requestId` varchar(50) NOT NULL,
            `order_id` int(11) NOT NULL,
            `status` varchar(50) NOT NULL,
            PRIMARY KEY  (`id_ifthenpay_ccard`),
            INDEX `requestId` (`requestId`)
          ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
    ];

    private $storeSql = [
        'multibanco' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_multibanco_shop` (
            `id_ifthenpay_multibanco` int(10) unsigned NOT NULL auto_increment,
            `id_shop` int(10) unsigned NOT NULL,
            PRIMARY KEY (`id_ifthenpay_multibanco`, `id_shop`)
          ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
          'mbway' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_mbway_shop` (
            `id_ifthenpay_mbway` int(10) unsigned NOT NULL auto_increment,
            `id_shop` int(10) unsigned NOT NULL,
            PRIMARY KEY (`id_ifthenpay_mbway`, `id_shop`)
          ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
          'payshop' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_payshop_shop` (
            `id_ifthenpay_payshop` int(10) unsigned NOT NULL auto_increment,
            `id_shop` int(10) unsigned NOT NULL,
            PRIMARY KEY (`id_ifthenpay_payshop`, `id_shop`)
          ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
          'ccard' => 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_ccard_shop` (
            `id_ifthenpay_ccard` int(10) unsigned NOT NULL auto_increment,
            `id_shop` int(10) unsigned NOT NULL,
            PRIMARY KEY (`id_ifthenpay_ccard`, `id_shop`)
          ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
    ];

    private $ifthenpaySqlLogTable = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ifthenpay_log` (
        `id_ifthenpay_log` int(10) unsigned NOT NULL auto_increment,
        `type` varchar(50) NOT NULL,
        `message` varchar(250) NOT NULL,
        `order_id` int(11) NOT NULL,
        `created` DATETIME NOT NULL,
        PRIMARY KEY  (`id_ifthenpay_log`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

    public function __construct($userPaymentMethods = null)
    {
        $this->userPaymentMethods = $userPaymentMethods;
        $this->ifthenpayStatusKeys = ['IFTHENPAY_{paymentMethod}_OS_WAITING', 'IFTHENPAY_{paymentMethod}_OS_CONFIRMED'];
    }

    private function createShopSql()
    {
        foreach ($this->userPaymentMethods as $paymentMethod) {
            $sql = \Db::getInstance()->execute($this->storeSql[$paymentMethod]);
            if (!$sql) {
                throw new \Exception($this->ifthenpayModule->l('Error creating ifthenpay payment shop table!', pathinfo(__FILE__)['filename']));
            }
        }
    }

    private function createIfthenpaySql()
    {
        foreach ($this->userPaymentMethods as $paymentMethod) {
                $sql = \Db::getInstance()->execute($this->ifthenpaySqlTables[$paymentMethod]);
            if (!$sql) {
                throw new \Exception($this->ifthenpayModule->l('Error creating ifthenpay payment table!', pathinfo(__FILE__)['filename']));
            }
        }
    }

    public function createIfthenpayLogSql()
    {
        $sql = \Db::getInstance()->execute($this->ifthenpaySqlLogTable);
        if (!$sql) {
            throw new \Exception($this->ifthenpayModule->l('Error creating ifthenpay log table!', pathinfo(__FILE__)['filename']));
        }
    }

    private function deleteIfthenpaySql()
    {
        foreach ($this->userPaymentMethods as $paymentMethod) {
                $sql = \Db::getInstance()->execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'ifthenpay_' . $paymentMethod);
            if (!$sql) {
                throw new \Exception($this->ifthenpayModule->l('Error deleting ifthenpay payment table!', pathinfo(__FILE__)['filename']));
            }
        }
    }

    private function deleteShopSql()
    {
        foreach ($this->userPaymentMethods as $paymentMethod) {
                $sql = \Db::getInstance()->execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'ifthenpay_' . $paymentMethod . '_shop');
            if (!$sql) {
                throw new \Exception($this->ifthenpayModule->l('Error deleting ifthenpay payment shop table!', pathinfo(__FILE__)['filename']));
            }
        }
    }

    private function deleteIfthenpayLogSql()
    {
        $sql = \Db::getInstance()->execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'ifthenpay_log');
        if (!$sql) {
            throw new \Exception($this->ifthenpayModule->l('Error deleting ifthenpay log table!', pathinfo(__FILE__)['filename']));
        }
    }

    public function install()
    {
        $this->createIfthenpaySql();
        $this->createShopSql();
    }

    public function uninstall()
    {
        if ($this->userPaymentMethods) {
            $this->deleteIfthenpaySql();
            $this->deleteShopSql();
        }
        $this->deleteIfthenpayLogSql();
    }

    /**
     * Set the value of ifthenpayModule
     *
     * @return  self
     */ 
    public function setIfthenpayModule($ifthenpayModule)
    {
        $this->ifthenpayModule = $ifthenpayModule;

        return $this;
    }
}
