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

class MultibancoBase extends PaymentBase
{
    protected function setGatewayBuilderData()
    {
        $this->gatewayBuilder->setEntidade(\Configuration::get('IFTHENPAY_MULTIBANCO_ENTIDADE'));
        $this->gatewayBuilder->setSubEntidade(\Configuration::get('IFTHENPAY_MULTIBANCO_SUBENTIDADE'));
        if (\Configuration::get('IFTHENPAY_MULTIBANCO_ENTIDADE') == 'MB' || \Configuration::get('IFTHENPAY_MULTIBANCO_ENTIDADE') == 'mb') {
            $this->gatewayBuilder->setValidade(\Configuration::get('IFTHENPAY_MULTIBANCO_VALIDADE'));
        }
    }

    protected function saveToDatabase()
    {
        $this->paymentModel->entidade = $this->paymentGatewayResultData->entidade;
        $this->paymentModel->referencia = $this->paymentGatewayResultData->referencia;
        $this->paymentModel->order_id = $this->paymentDefaultData->order->id;
        $this->paymentModel->request_id = isset($this->paymentGatewayResultData->idPedido) ? $this->paymentGatewayResultData->idPedido : null;
        $this->paymentModel->validade = isset($this->paymentGatewayResultData->validade) ? $this->paymentGatewayResultData->validade : null;
        $this->paymentModel->status = 'pending';
        $this->paymentModel->save();
    }

    protected function updateDatabase()
    {
        $this->setPaymentModel('multibanco', $this->paymentDataFromDb['id_ifthenpay_multibanco']);
        $this->paymentModel->referencia = $this->paymentGatewayResultData->referencia;
        $this->paymentModel->update();
    }

    protected function setEmailVariables()
    {
        $this->emailDefaultData['{mb_logo}'] = _PS_BASE_URL_ . _MODULE_DIR_ . 'ifthenpay/views/img/multibanco.png';
        $this->emailDefaultData['{entidade}'] = $this->paymentGatewayResultData ? $this->paymentGatewayResultData->entidade : $this->paymentDataFromDb['entidade'];
        $this->emailDefaultData['{referencia}'] = $this->paymentGatewayResultData ? $this->paymentGatewayResultData->referencia : $this->paymentDataFromDb['referencia'];
    }
}
