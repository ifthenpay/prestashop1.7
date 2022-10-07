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

namespace PrestaShop\Module\Ifthenpay\Callback;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CallbackValidate
{

    private $httpRequest;
    private $order;
    private $configurationChaveAntiPhishing;
    private $paymentDataFromDb;

    public function __construct($httpRequest, $order, $configurationChaveAntiPhishing, $paymentDataFromDb)
    {
        $this->httpRequest = $httpRequest;
        $this->order = $order;
        $this->configurationChaveAntiPhishing = $configurationChaveAntiPhishing;
        $this->paymentDataFromDb = $paymentDataFromDb;
    }

    private function validateOrder()
    {
        if (!$this->order) {
            throw new \Exception('Ordem não encontrada.');
        }
    }

    private function validateOrderValue()
    {
        $orderTotal = floatval($this->order->getOrdersTotalPaid());
        $requestValor = floatval($this->httpRequest['valor']);
        if (round($orderTotal, 2) !== round($requestValor, 2)) {
            throw new \Exception('Valor não corresponde ao valor da encomenda.');
        }
    }

    private function validateOrderStatus()
    {
        if ($this->paymentDataFromDb['status'] === 'paid') {
                throw new \Exception('Encomenda já foi paga.');
        }
    }

    private function validateChaveAntiPhishing()
    {
        if (!$this->httpRequest['chave']) {
            throw new \Exception('Chave Anti-Phishing não foi enviada.');
        }

        if ($this->httpRequest['chave'] !== $this->configurationChaveAntiPhishing) {
            throw new \Exception('Chave Anti-Phishing não é válida.');
        }
    }

    public function validate()
    {
        $this->validateChaveAntiPhishing();
        $this->validateOrder();
        $this->validateOrderValue();
        $this->validateOrderStatus();
        return true;
    }
}
