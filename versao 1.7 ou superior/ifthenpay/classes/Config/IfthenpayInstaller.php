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

use PrestaShop\Module\Ifthenpay\Factory\Config\ConfigFactory;

class IfthenpayInstaller
{
    private $userPaymentMethods;
    private $ifthenpayOrderStates;
    private $ifthenpayControllersTab;
    private $ifthenpaySql;
    private $ifthenpayModule;

    public function __construct($userPaymentMethods, $ifthenpayModule)
    {
        $this->ifthenpayModule = $ifthenpayModule;
        $this->userPaymentMethods = (array) unserialize($userPaymentMethods);
        $this->ifthenpayOrderStates = ConfigFactory::buildIfthenpayOrderStates($this->userPaymentMethods);
        $this->ifthenpayControllersTab = ConfigFactory::buildIfthenpayControllersTabs($ifthenpayModule);
        $this->ifthenpaySql = ConfigFactory::buildIfthenpaySql($this->userPaymentMethods);
        $this->ifthenpayConfiguration =  ConfigFactory::buildIfthenpayConfiguration($this->userPaymentMethods);
    }

    public function execute($type)
    {
        if (!$this->userPaymentMethods) {
            throw new \Exception('Error instaling, paymentMethods not defined!');
        } else {
            if ($type === 'install') {
                $this->ifthenpaySql->setIfthenpayModule($this->ifthenpayModule)->install();
                $this->ifthenpayOrderStates->install();
                $this->ifthenpayControllersTab->install();
            } else {
                $this->ifthenpaySql->uninstall();
                $this->ifthenpayOrderStates->uninstall();
                $this->ifthenpayControllersTab->uninstall();
                $this->ifthenpayConfiguration->uninstall();
            }
        }
    }
}
