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

namespace PrestaShop\Module\Ifthenpay\Base\Payments;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Base\PaymentBase;

class MbwayBase extends PaymentBase
{
    protected function setOrderIcons()
    {
        $this->smartyDefaultData->setCancelOrderImg(
            \Media::getMediaPath(
                _PS_MODULE_DIR_ . 'ifthenpay/views/img/cancelOrder.svg'
            )
        );
        $this->smartyDefaultData->setConfirmOrderImg(
            \Media::getMediaPath(
                _PS_MODULE_DIR_ . 'ifthenpay/views/img/mbwayOrderConfirm.png'
            )
        );
        $this->smartyDefaultData->setRefusedOrderImg(
            \Media::getMediaPath(
                _PS_MODULE_DIR_ . 'ifthenpay/views/img/mbwayOrderRefused.png'
            )
        );
        $this->smartyDefaultData->setErrorOrderImg(
            \Media::getMediaPath(
                _PS_MODULE_DIR_ . 'ifthenpay/views/img/error.png'
            )
        );
        $this->smartyDefaultData->setTimeoutImg(
            \Media::getMediaPath(
                _PS_MODULE_DIR_ . 'ifthenpay/views/img/timeout.png'
            )
        );
        $this->smartyDefaultData->setSpinnerImg(
            \Media::getMediaPath(
                _PS_MODULE_DIR_ . 'ifthenpay/views/img/oval.svg'
            )
        );
    }
    protected function setGatewayBuilderData()
    {
        $this->gatewayBuilder->setMbwayKey(\Configuration::get('IFTHENPAY_MBWAY_KEY'));
        $telemovelFromCart = \Configuration::get('IFTHENPAY_MBWAY_PHONE_' . \Tools::getValue('id_cart'));
        $telemovelFromOrderCreateBo = \Configuration::get('IFTHENPAY_MBWAY_PHONE_BO_CREATED' . $this->paymentDefaultData->order->id );
        if ($telemovelFromOrderCreateBo) {
            $this->gatewayBuilder->setTelemovel($telemovelFromOrderCreateBo);
            \Configuration::deleteByName('IFTHENPAY_MBWAY_PHONE_BO_CREATED' . $this->paymentDefaultData->order->id);
        } else {
            $this->gatewayBuilder->setTelemovel($telemovelFromCart ? $telemovelFromCart : $this->paymentDataFromDb['telemovel']);
            \Configuration::deleteByName('IFTHENPAY_MBWAY_PHONE_' . \Tools::getValue('id_cart'));
        }
    }

    protected function saveToDatabase()
    {
        $this->paymentModel->id_transacao = $this->paymentGatewayResultData->idPedido;
        $this->paymentModel->telemovel = $this->paymentGatewayResultData->telemovel;
        $this->paymentModel->order_id = $this->paymentDefaultData->order->id;
        $this->paymentModel->status = 'pending';
        $this->paymentModel->save();
    }

    protected function updateDatabase()
    {
        $this->setPaymentModel('mbway', $this->paymentDataFromDb['id_ifthenpay_mbway']);
        $this->paymentModel->id_transacao = $this->paymentGatewayResultData->idPedido;
        $this->paymentModel->update();
    }

    protected function setEmailVariables()
    {
        //void
    }
}
