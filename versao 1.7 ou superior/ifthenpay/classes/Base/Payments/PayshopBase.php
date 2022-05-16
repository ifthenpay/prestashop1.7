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

namespace PrestaShop\Module\Ifthenpay\Base\Payments;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Base\PaymentBase;

class PayshopBase extends PaymentBase
{
    protected function setGatewayBuilderData()
    {
        $this->gatewayBuilder->setPayshopKey(\Configuration::get('IFTHENPAY_PAYSHOP_KEY'));
        $this->gatewayBuilder->setValidade(\Configuration::get('IFTHENPAY_PAYSHOP_VALIDADE'));
    }

    protected function saveToDatabase()
    {
        $this->paymentModel->id_transacao = $this->paymentGatewayResultData->idPedido;
        $this->paymentModel->referencia = $this->paymentGatewayResultData->referencia;
        $this->paymentModel->validade = $this->paymentGatewayResultData->validade;
        $this->paymentModel->order_id = $this->paymentDefaultData->order->id;
        $this->paymentModel->status = 'pending';
        $this->paymentModel->save();
    }

    protected function updateDatabase()
    {
        $this->setPaymentModel('payshop', $this->paymentDataFromDb['id_ifthenpay_payshop']);
        $this->paymentModel->referencia = $this->paymentGatewayResultData->referencia;
        $this->paymentModel->id_transacao = $this->paymentGatewayResultData->idPedido;
        $this->paymentModel->update();
    }

    protected function setEmailVariables()
    {
        $this->emailDefaultData['{referencia}'] = $this->paymentGatewayResultData ? $this->paymentGatewayResultData->referencia : $this->paymentDataFromDb['referencia'];

        // format validity date if not already formated
        $validade = $this->paymentGatewayResultData ? $this->paymentGatewayResultData->validade : $this->paymentDataFromDb['validade'];
        if (!strpos($validade, "-")) {
            $validade = (new \DateTime($validade))->format('d-m-Y');
        }

        $this->emailDefaultData['{validade}'] = $validade;

    }
}
