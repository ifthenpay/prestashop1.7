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


namespace PrestaShop\Module\Ifthenpay\Config;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Factory\Database\DatabaseFactory;
use PrestaShop\Module\Ifthenpay\Contracts\Config\InstallerInterface;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;

class IfthenpayControllersTabs implements InstallerInterface
{
    private $adminControllers;
    private $ifthenpayModule;

    /**
    *@param Ifthenpay $ifthenpayModule 
    */
    public function __construct($ifthenpayModule)
    {
        $this->adminControllers = ['AdminIfthenpayPaymentMethodSetup', 'Update', 'Resend', 'Remember'];
        $this->ifthenpayModule = $ifthenpayModule;
    }

    /**
    * Create tabs for admin controllers
    * @return void
    */
    public function install()
    {
        foreach ($this->adminControllers as $controller) {
            $tab = PrestashopModelFactory::buildTab();
            foreach (\Language::getLanguages() as $lang) {
                $tab->name[$lang['id_lang']] = $this->ifthenpayModule->l('Payment Setup');
            }
            $tab->class_name = $controller;
            $tab->id_parent = -1;
            $tab->module = $this->ifthenpayModule->name;
            $tab->add();
            if (!$tab->save()) {
                throw new Exception('Error creating admin controllers tab.');
            }
        }
    }

    /**
    * Method for install tab dynamic
    *@param string $controllerType 
    * @return void
    */
    public function dynamicInstall($controllerType)
    {
        $this->adminControllers = [$controllerType];
        $this->install();
    }

    /**
    * Main method for uninstall controllers tabs
    * @return void
    */
    public function uninstall()
    {
        $query = DatabaseFactory::build('dbQuery');
        $query->select('*');
        $query->from('tab');
        $query->where('module = \''.pSQL($this->ifthenpayModule->name).'\'');

        $tabs = \Db::getInstance()->executeS($query);
        foreach ($tabs as $tabData) {
            $tab = PrestashopModelFactory::buildTab($tabData['id_tab']);
            $tab->delete();
        }
    }
}
