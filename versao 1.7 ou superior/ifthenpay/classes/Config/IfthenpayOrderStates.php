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

use PrestaShop\Module\Ifthenpay\Contracts\Config\InstallerInterface;
use PrestaShop\Module\Ifthenpay\Factory\Prestashop\PrestashopModelFactory;

class IfthenpayOrderStates implements InstallerInterface
{
    private $ifthenpayStatusKeys;
    private $userPaymentMethods;

    public function __construct($userPaymentMethods)
    {
        $this->userPaymentMethods = $userPaymentMethods;
        $this->ifthenpayStatusKeys = ['IFTHENPAY_{paymentMethod}_OS_WAITING', 'IFTHENPAY_{paymentMethod}_OS_CONFIRMED'];
    }

    public function install()
    {
        foreach ($this->userPaymentMethods as $paymentMethod) {
            foreach ($this->ifthenpayStatusKeys as $status) {
                $status = str_replace('{paymentMethod}', \Tools::strtoupper($paymentMethod), $status);
                if (!\Configuration::get($status) || !\Validate::isLoadedObject(PrestashopModelFactory::buildOrderState(\Configuration::get($status)))) {
                    $order_state = PrestashopModelFactory::buildOrderState();
                    $order_state->name = array();
                    foreach (\Language::getLanguages() as $language) {
                        if (\Tools::strtolower($language['iso_code']) == 'en') {
                            $order_state->name[$language['id_lang']] = strpos($status, 'WAITING') ?
                                'Awaiting for ' . \Tools::ucfirst($paymentMethod) . 'payment' : 'Payment by ' . \Tools::ucfirst($paymentMethod) . 'confirmed';
                        } else {
                            $order_state->name[$language['id_lang']] = strpos($status, 'WAITING') ?
                                'Aguarda pagamento por ' . \Tools::ucfirst($paymentMethod) : 'Confirmado pagamento por ' . \Tools::ucfirst($paymentMethod);
                        }
                    }
                    $order_state->send_email = strpos($status, 'WAITING')  ? false : true;
                    $order_state->template = strpos($status, 'WAITING') ? '' : 'payment';
                    $order_state->color = strpos($status, 'WAITING') ? '#FF8100' : '#33B200';
                    $order_state->hidden = false;
                    $order_state->delivery = false;
                    $order_state->logable = strpos($status, 'WAITING')  ? false : true;
                    $order_state->invoice = false;
                    $order_state->module_name = 'ifthenpay';
                    $order_state->unremovable = true;
                    $order_state->paid = strpos($status, 'WAITING')  ? false : true;

                    if ($order_state->add()) {
                        $source = _PS_MODULE_DIR_ . 'ifthenpay/views/img/os_' . $paymentMethod . '.png';
                        $destination = _PS_ROOT_DIR_ . '/img/os/' . (int)$order_state->id . '.gif';
                        copy($source, $destination);
                    } else {
                        throw new \Exception('Error saving order state.');
                    }

                    if (\Shop::isFeatureActive()) {
                        $shops = \Shop::getShops();
                        foreach ($shops as $shop) {
                            \Configuration::updateValue($status, (int) $order_state->id, false, null, (int)$shop['id_shop']);
                        }
                    } else {
                        \Configuration::updateValue($status, (int) $order_state->id);
                    }
                }
            }
        }
    }

    public function uninstall()
    {
        /* @var $orderState OrderState */
       /* $result = true;
        $collection = PrestashopFactory::buildPrestaShopCollection('OrderState');
        $collection->where('module_name', '=', 'ifthenpay');
        $orderStates = $collection->getResults();

        if ($orderStates !== false) {
            foreach ($orderStates as $orderState) {
                $result &= $orderState->delete();
            }
        }*/

        $query = new \DbQuery();
        $query->select('id_order_state');
        $query->from('order_state');
        $query->where('module_name = \''.pSQL('ifthenpay').'\'');

        $orderStateData = \Db::getInstance()->executeS($query);

        if (!empty($orderStateData)) {
            foreach ($orderStateData as $data) {
                $query = new \DbQuery();
                $query->select('1');
                $query->from('orders');
                $query->where('current_state = '.$data['id_order_state']);
                $isUsed = (bool)\Db::getInstance()->getValue($query);
                $orderState = new \OrderState($data['id_order_state']);
                if ($isUsed && version_compare(_PS_VERSION_, '1.7.6.8', '>')) {
                    $orderState->deleted = true;
                    $orderState->save();
                } else {
                    $orderState->delete();
                }
            }
        }
    }
}
