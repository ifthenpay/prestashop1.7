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


namespace PrestaShop\Module\Ifthenpay\Forms;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Callback\Callback;
use PrestaShop\Module\Ifthenpay\Factory\Builder\BuilderFactory;
use PrestaShop\Module\Ifthenpay\Factory\Payment\GatewayFactory;
use PrestaShop\Module\Ifthenpay\Factory\Callback\CallbackFactory;

abstract class ConfigForm
{
    protected $paymentMethod;
    protected $form;
    protected $ifthenpayModule;
    protected $gatewayDataBuilder;
    private $ifthenpayGateway;
    protected $options;
    /**
    *@param array $defaultForm, @param Ifthenpay $ifthenpayModule
    */
    public function __construct($defaultForm, $ifthenpayModule)
    {
        $this->form = $defaultForm;
        $this->ifthenpayModule = $ifthenpayModule;
        $this->gatewayDataBuilder = BuilderFactory::build('gateway');
        $this->ifthenpayGateway = GatewayFactory::build('gateway');
        $this->ifthenpayGateway->setAccount((array) unserialize(\Configuration::get('IFTHENPAY_USER_ACCOUNT')));
        $this->options = [];
    }
    /**
    * Add entidade/subentidade to config form when client request to add new entidade/subentidade
    * @return void
    */
    protected function addToOptions()
    {
        foreach ($this->ifthenpayGateway->getEntidadeSubEntidade($this->paymentMethod) as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    if (strlen($value2) > 3) {
                        $this->options[] = [
                            'id' => $value2,
                            'name' => $value2
                        ];
                    }
                }
            } else {
                $this->options[] = [
                    'id' => $value,
                    'name' => $value
                ];
            }
        }
    }
    /**
    * Set gateway builder backofficekey
    * @return void
    */
    protected function setGatewayBuilderData()
    {
        $this->gatewayDataBuilder->setBackofficeKey(\Configuration::get('IFTHENPAY_BACKOFFICE_KEY'));
    }
    /**
    * Get callback controller url
    * @return string
    */
    protected function getCallbackControllerUrl()
    {
        return \Context::getContext()->link->getModuleLink('ifthenpay', 'callback', array(), true);
    }
    /**
    * Set callback data
    * @return Callback
    */
    protected function getIfthenpayCallback()
    {
        return CallbackFactory::buildCallback($this->gatewayDataBuilder);
    }

    /**
    * Delete default config values
    * @return void
    */
    protected function deleteDefaultConfigValues()
    {
        \Configuration::deleteByName('IFTHENPAY_CALLBACK_ACTIVATE_FOR_' . strtoupper($this->paymentMethod));
        \Configuration::deleteByName('IFTHENPAY_CALLBACK_ACTIVATED_FOR_' . strtoupper($this->paymentMethod)); 
    }

    protected function setIfthenpayCallback()
    {
        
        $activateCallback = !\Configuration::get('IFTHENPAY_ACTIVATE_SANDBOX_MODE', false)  && 
        \Configuration::get('IFTHENPAY_CALLBACK_ACTIVATE_FOR_' . strtoupper($this->paymentMethod)) && 
        !\Configuration::get('IFTHENPAY_CALLBACK_ACTIVATED_FOR_' . strtoupper($this->paymentMethod)) ? true : false;
        $ifthenpayCallback = $this->getIfthenpayCallback();
        $ifthenpayCallback->make($this->paymentMethod, $this->getCallbackControllerUrl(), $activateCallback);

        if (!\Configuration::get('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_URL_CALLBACK', false) &&
        !\Configuration::get('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_CHAVE_ANTI_PHISHING', false)) {

            \Configuration::updateValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_URL_CALLBACK', $ifthenpayCallback->getUrlCallback());
            \Configuration::updateValue('IFTHENPAY_' . strtoupper($this->paymentMethod) . '_CHAVE_ANTI_PHISHING', $ifthenpayCallback->getChaveAntiPhishing());
        }
    }


    abstract protected function setOptions();
    abstract public function getForm();
    abstract public function processForm();
    abstract public function deleteConfigValues();
    abstract public function setSmartyVariables();
}
