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


if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Utility\Utility;
use PrestaShop\Module\Ifthenpay\Log\IfthenpayLogProcess;
use PrestaShop\Module\Ifthenpay\Factory\Payment\GatewayFactory;
use PrestaShop\Module\Ifthenpay\Factory\Config\IfthenpayConfigFormsFactory;
use PrestaShop\Module\Ifthenpay\Factory\Request\RequestFactory;

class AdminIfthenpayPaymentMethodSetupController extends ModuleAdminController
{
    private $paymentMethod;
    private $ifthenpayGateway;


    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->ifthenpayGateway = GatewayFactory::build('gateway');
    }


    public function initPageHeaderToolbar()
    {
        $this->page_header_toolbar_btn['return'] = array(
            'href' => $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->module->name,
            'desc' => $this->module->l('Back'),
            'icon' => 'process-icon-back'
        );
        parent::initPageHeaderToolbar();
    }


    public function initContent()
    {
        Utility::checkPaymentMethodDefined();

        parent::initContent();

        if ($this->context->cookie->__isset('success')) {
            $this->displayInformation($this->context->cookie->__get('success'));
            $this->context->cookie->__unset('success');
        }

        if ($this->context->cookie->__isset('error')) {
            $this->displayWarning($this->context->cookie->__get('error'));
            $this->context->cookie->__unset('error');
        }
        $this->paymentMethod = $_GET['paymentMethod'];

        $this->context->smarty->assign('paymentMethod', $this->paymentMethod);
        $this->context->smarty->assign('module_dir', _MODULE_DIR_ . $this->module->name);

        // prevents configuration without backoffice key
        if (!Configuration::get('IFTHENPAY_BACKOFFICE_KEY')) {
            Utility::redirectIfthenpayConfigPage();
        }

        IfthenpayConfigFormsFactory::build('ifthenpayConfigForms', $this->paymentMethod, $this->module, $this)->buildForm();

        $this->context->smarty->assign('content', $this->context->smarty->fetch($this->getTemplatePath() . '/paymentMethodSetup.tpl'));
    }

    public function postProcess()
    {
        parent::postProcess();
        $this->paymentMethod = Tools::getValue('IFTHENPAY_PAYMENT_METHOD');

        if ($this->paymentMethod && Tools::isSubmit('submitIfthenpay' . Tools::ucfirst($this->paymentMethod) . 'Config')) {
            try {
                IfthenpayConfigFormsFactory::build('ifthenpayConfigForms', $this->paymentMethod, $this->module)->processForm();
                IfthenpayLogProcess::addLog(Tools::ucfirst($this->paymentMethod) . ' configuration saved with success.', IfthenpayLogProcess::INFO, 0);
            } catch (\Throwable $th) {
                IfthenpayLogProcess::addLog('Error saving ' . Tools::ucfirst($this->paymentMethod) . ' configuration - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, 0);
                Utility::setPrestashopCookie('error', sprintf($this->module->l('Error saving %s data.'), Tools::ucfirst($this->paymentMethod)));
            }
            Tools::redirectAdmin(
                $this->context->link->getAdminLink(
                    'AdminIfthenpayPaymentMethodSetup',
                    true,
                    [],
                    [
                        'paymentMethod' => $this->paymentMethod
                    ]
                )
            );
        }
    }

    public function setMedia($isNewTheme = false)
    {
        $versioning = '_' . str_replace('.', '_', $this->module->version);

        $ifthenpayUserPaymentMethods = Configuration::get('IFTHENPAY_USER_PAYMENT_METHODS');
        if ($ifthenpayUserPaymentMethods) {
            parent::setMedia($isNewTheme);
            $this->addJS($this->module->getLocalPath() . '/views/js/adminConfigPage' . $versioning . '.js');
            $this->addCSS($this->module->getLocalPath() . 'views/css/ifthenpayPaymentMethodSetup' . $versioning . '.css');
            Media::addJsDef(array(
                'ifthenpayUserPaymentMethods' => (array) unserialize($ifthenpayUserPaymentMethods),
                'controllerUrl' => $this->context->link->getAdminLink('AdminIfthenpayPaymentMethodSetup'),
                'testCallbackUrl' => $this->context->link->getAdminLink('AdminIfthenpayTestCallback'),
                'msgFillAllFields' => $this->module->l('Please fill all fields', pathinfo(__FILE__)['filename'])
            ));
        }
    }

    public function ajaxProcessGetSubEntidade()
    {
        try {
            $this->ifthenpayGateway->setAccount((array) unserialize(Configuration::get('IFTHENPAY_USER_ACCOUNT')));
            $subEntidades = json_encode($this->ifthenpayGateway->getSubEntidadeInEntidade(Tools::getValue('entidade')));
            // this log is unnecessary
            // IfthenpayLogProcess::addLog('SubEntidades withdrawn with success', IfthenpayLogProcess::INFO, 0);
            die($subEntidades);
        } catch (\Throwable $th) {
            IfthenpayLogProcess::addLog('Error getting subEntidades by ajax request - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, 0);
            die($th->getMessage());
        }
    }


    public function ajaxProcessTestCallback()
    {
        try {

            $method = Tools::getValue('method');

            $isCallbackActive = Configuration::get('IFTHENPAY_CALLBACK_ACTIVATED_FOR_' . strtoupper($method));
            $callbackUrl = Configuration::get('IFTHENPAY_'. strtoupper($method) .'_URL_CALLBACK');
            $callbackUrl .= '&test=true';
            
            $reference = Tools::getValue('reference');
            $amount = Tools::getValue('amount');
            $mbwayTransactionId = Tools::getValue('mbway_transaction_id');
            $payshopTransactionId = Tools::getValue('payshop_transaction_id');
            

            if (!$callbackUrl) {
                die(json_encode([
                    'status' => 'warning',
                    'message' => $this->module->l('Callback url not defined', pathinfo(__FILE__)['filename'])
                ]));
            }
            if (!$isCallbackActive) {
                die(json_encode([
                    'status' => 'warning',
                    'message' => $this->module->l('Callback not activated', pathinfo(__FILE__)['filename'])
                ]));
            }


            $antiPhishingKey = Configuration::get('IFTHENPAY_' . strtoupper($method) . '_CHAVE_ANTI_PHISHING');
            $callbackUrl = str_replace('[CHAVE_ANTI_PHISHING]', $antiPhishingKey, $callbackUrl);


            // set callback url for multibanco
            if ($method === 'multibanco') {

                $entity = Configuration::get('IFTHENPAY_' . strtoupper($method) . '_ENTIDADE');
                $callbackUrl = str_replace('[ENTIDADE]', $entity, $callbackUrl);

                $callbackUrl = str_replace('[REFERENCIA]', $reference, $callbackUrl);
                $callbackUrl = str_replace('[VALOR]', $amount, $callbackUrl);
            }

            // set callback url for mbway

            if ($method === 'mbway') {
                $callbackUrl = str_replace('[ID_TRANSACAO]', $mbwayTransactionId, $callbackUrl);
                $callbackUrl = str_replace('[VALOR]', $amount, $callbackUrl);
                $callbackUrl = str_replace('[ESTADO]', 'PAGO', $callbackUrl);
            }

            // set callback url for payshop

            if ($method === 'payshop') {
                $callbackUrl = str_replace('[ID_TRANSACAO]', $payshopTransactionId, $callbackUrl);
                $callbackUrl = str_replace('[VALOR]', $amount, $callbackUrl);
                $callbackUrl = str_replace('[ESTADO]', 'PAGO', $callbackUrl);
            }


            $webservice = RequestFactory::buildWebservice();

            $request = $webservice->getRequest($callbackUrl);

            $responseBody = $request->getResponseJson();

            die(json_encode($responseBody));
        } catch (\Throwable $th) {
            IfthenpayLogProcess::addLog('Error testing the callback in backoffice - ' . $th->getMessage(), IfthenpayLogProcess::ERROR, 0);

            $response = [
                'status' => 'error',
                'message' => $this->module->l('Invalid data, order not found', pathinfo(__FILE__)['filename']),
            ];

            die(json_encode($response));
        }
    }
}
