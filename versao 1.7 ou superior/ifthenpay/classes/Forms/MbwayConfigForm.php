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

use PrestaShop\Module\Ifthenpay\Utility\Utility;
use PrestaShop\Module\Ifthenpay\Forms\ConfigForm;

class MbwayConfigForm extends ConfigForm
{
    protected $paymentMethod = 'mbway';

    public function setOptions()
    {
        $this->options[] = [
            'id' => $this->ifthenpayModule->l('Choose Mbway key', Utility::getClassName($this)),
            'name' => $this->ifthenpayModule->l('Choose Mbway key', Utility::getClassName($this))
        ];
        $this->addToOptions();
    }

    public function getForm()
    {
        if (!$this->checkIfCallbackIsSet()
        ) {
            $this->setFormParent();
            $this->addActivateCallbackToForm();
            $this->setOptions();
            $this->form['form']['input'][] = [
                'type' => 'switch',
                'label' => $this->ifthenpayModule->l('Cancel MB WAY Order', Utility::getClassName($this)),
                'name' => 'IFTHENPAY_MBWAY_CANCEL_ORDER_AFTER_TIMEOUT',
                'desc' => $this->ifthenpayModule->l('Cancel MB WAY order after notification expire. This will only work, if the callback is activated.'),
                'is_bool' => true,
                'values' => [
                    [
                        'id' => 'active_on',
                        'value' => true,
                        'label' => $this->ifthenpayModule->l('Activate', Utility::getClassName($this))
                    ],
                    [
                        'id' => 'active_off',
                        'value' => false,
                        'label' => $this->ifthenpayModule->l('Disabled', Utility::getClassName($this))
                    ]
                ]   
            ];
            $this->form['form']['input'][] = [
                'type' => 'select',
                'label' => $this->ifthenpayModule->l('Mbway key', Utility::getClassName($this)),
                'desc' => $this->ifthenpayModule->l('Choose Mbway key', Utility::getClassName($this)),
                'name' => 'IFTHENPAY_MBWAY_KEY',
                'required' => true,
                'options' => [
                    'query' => $this->options,
                    'id' => 'id',
                    'name' => 'name'
                ]
            ];
            $this->generateHelperForm();
        } else {
            $this->setSmartyVariables();
        }
    }

    protected function getConfigFormValues()
    {
        return array_merge(parent::getConfigFormValues(), [
            'IFTHENPAY_MBWAY_CANCEL_ORDER_AFTER_TIMEOUT' => \Configuration::get('IFTHENPAY_MBWAY_CANCEL_ORDER_AFTER_TIMEOUT'),
            'IFTHENPAY_MBWAY_KEY' => \Configuration::get('IFTHENPAY_MBWAY_KEY')
        ]);
    }

    public function setSmartyVariables()
    {
        $this->setGatewayBuilderData();
        $this->setIfthenpayCallback();
        parent::setSmartyVariables();
        \Context::getContext()->smarty->assign('mbwayKey', \Configuration::get('IFTHENPAY_MBWAY_KEY'));
        \Context::getContext()->smarty->assign('chaveAntiPhishing', \Configuration::get('IFTHENPAY_MBWAY_CHAVE_ANTI_PHISHING'));
        \Context::getContext()->smarty->assign('urlCallback', \Configuration::get('IFTHENPAY_MBWAY_URL_CALLBACK'));
    }

    public function setGatewayBuilderData()
    {
        $getMbwayKeyFromRequest = \Tools::getValue('IFTHENPAY_MBWAY_KEY');
        parent::setGatewayBuilderData();
        $this->gatewayDataBuilder->setEntidade(\Tools::strtoupper($this->paymentMethod));
        $this->gatewayDataBuilder->setSubEntidade($getMbwayKeyFromRequest ? $getMbwayKeyFromRequest : \Configuration::get('IFTHENPAY_MBWAY_KEY'));
    }

    public function processForm()
    {
        $this->setGatewayBuilderData();
        \Configuration::updateValue('IFTHENPAY_MBWAY_KEY', $this->gatewayDataBuilder->getData()->subEntidade);
        \Configuration::updateValue('IFTHENPAY_MBWAY_CANCEL_ORDER_AFTER_TIMEOUT', \Tools::getValue('IFTHENPAY_MBWAY_CANCEL_ORDER_AFTER_TIMEOUT'));

        $this->setIfthenpayCallback();

        Utility::setPrestashopCookie('success', $this->ifthenpayModule->l('Mbway key successfully updated.', Utility::getClassName($this)));
    }

    public function deleteConfigValues()
    {
        $this->deleteDefaultConfigValues();
        \Configuration::deleteByName('IFTHENPAY_MBWAY_KEY');
        \Configuration::deleteByName('IFTHENPAY_MBWAY_URL_CALLBACK');
        \Configuration::deleteByName('IFTHENPAY_MBWAY_CHAVE_ANTI_PHISHING');
        \Configuration::deleteByName('IFTHENPAY_MBWAY_CANCEL_ORDER_AFTER_TIMEOUT');
    }
}
