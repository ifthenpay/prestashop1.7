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

namespace PrestaShop\Module\Ifthenpay\Base;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Factory\Builder\BuilderFactory;
use PrestaShop\Module\Ifthenpay\Factory\Payment\GatewayFactory;
use PrestaShop\Module\Ifthenpay\Factory\Models\IfthenpayModelFactory;

abstract class PaymentBase
{
    protected $gatewayBuilder;
    protected $paymentDefaultData;
    protected $smartyDefaultData;
    protected $emailDefaultData;
    protected $paymentGatewayResultData;
    protected $ifthenpayGateway;
    protected $paymentModel;
    protected $paymentDataFromDb;
    protected $ifthenpayModule;

    public function __construct(
        $ifthenpayModule,
        $paymentDefaultData,
        $smartyDefaultData = null,
        $emailDefaultData = []
    ) {
        $this->gatewayBuilder = BuilderFactory::build('gateway');
        $this->paymentDefaultData = $paymentDefaultData->getData();
        $this->smartyDefaultData = $smartyDefaultData;
        $this->emailDefaultData = $emailDefaultData;
        $this->ifthenpayGateway = GatewayFactory::build('gateway');
        $this->ifthenpayModule = $ifthenpayModule;
    }

    public function setPaymentModel($type, $id = null)
    {
        $this->paymentModel = IfthenpayModelFactory::build($type, $id);
        return $this;
    }

    public function getFromDatabaseById()
    {
        $this->paymentDataFromDb = $this->paymentModel->getByOrderId($this->paymentDefaultData->order->id);
    }

    protected function sendEmail($emailTemplate, $emailSubject)
    {
        \Mail::Send(
            (int)$this->paymentDefaultData->order->id_lang,
            $emailTemplate,
            $emailSubject,
            $this->emailDefaultData,
            $this->paymentDefaultData->customer->email,
            $this->paymentDefaultData->customer->firstname . ' ' . $this->paymentDefaultData->customer->lastname,
            null,
            null,
            null,
            null,
            _PS_MODULE_DIR_ . 'ifthenpay/mails/',
            false,
            (int)$this->paymentDefaultData->order->id_shop
        );
    }

    public function getSmartyVariables()
    {
        return $this->smartyDefaultData;
    }

    abstract protected function setGatewayBuilderData();
    abstract protected function saveToDatabase();
    abstract protected function updateDatabase();
    abstract protected function setEmailVariables();

    /**
     * Get the value of paymentDataFromDb
     */
    public function getPaymentDataFromDb()
    {
        return $this->paymentDataFromDb;
    }
}
