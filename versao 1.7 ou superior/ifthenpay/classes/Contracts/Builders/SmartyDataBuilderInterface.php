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


namespace PrestaShop\Module\Ifthenpay\Contracts\Builders;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Contracts\Builders\DataBuilderInterface;

interface SmartyDataBuilderInterface extends DataBuilderInterface
{
    /**
    * Set shop name
    *@param string $value 
    * @return SmartyDataBuilderInterface
    */
    public function setShopName($value);
    /**
    * Set payment logo
    *@param string $value 
    * @return SmartyDataBuilderInterface
    */
    public function setPaymentLogo($value);
    /**
    * Set order id
    *@param string $value 
    * @return SmartyDataBuilderInterface
    */
    public function setOrderId($value);
    /**
    * Set order status
    *@param string $value 
    * @return SmartyDataBuilderInterface
    */
    public function setStatus($value);
    /**
    * Set update controller url
    *@param string $value 
    * @return SmartyDataBuilderInterface
    */
    public function setUpdateControllerUrl($value);
    /**
    * Set resend controller url
    *@param string $value 
    * @return SmartyDataBuilderInterface
    */
    public function setResendControllerUrl($value);
    /**
    * Set remember controller url
    *@param string $value 
    * @return SmartyDataBuilderInterface
    */
    public function setRememberControllerUrl($value);
    /**
    * Set message
    *@param string $value 
    * @return SmartyDataBuilderInterface
    */
    public function setMessage($value);
    /**
    * Set order success page resend mbway notification controller url
    *@param string $value 
    * @return SmartyDataBuilderInterface
    */
    public function setResendMbwayNotificationControllerUrl($value);
}
