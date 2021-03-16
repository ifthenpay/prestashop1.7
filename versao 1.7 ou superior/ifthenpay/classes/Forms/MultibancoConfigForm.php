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

use PrestaShop\Module\Ifthenpay\Forms\ConfigForm;
use PrestaShop\Module\Ifthenpay\Utility\Utility;

class MultibancoConfigForm extends ConfigForm
{
    protected $paymentMethod = 'multibanco';

    public function setOptions()
    {
        $this->options[] = [
            'id' => $this->ifthenpayModule->l('Choose Entity'),
            'name' => $this->ifthenpayModule->l('Choose Entity')
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
                'type' => 'select',
                'label' => $this->ifthenpayModule->l('Entity'),
                'desc' => $this->ifthenpayModule->l('Choose Entity'),
                'name' => 'IFTHENPAY_MULTIBANCO_ENTIDADE',
                'id' => 'ifthenpayMultibancoEntidade',
                'required' => true,
                'options' => [
                    'query' => $this->options,
                    'id' => 'id',
                    'name' => 'name'
                ]
            ];
            $this->form['form']['input'][] = [
                'type' => 'select',
                'label' => $this->ifthenpayModule->l('SubEntity'),
                'desc' => $this->ifthenpayModule->l('Choose SubEntity'),
                'name' => 'IFTHENPAY_MULTIBANCO_SUBENTIDADE',
                'id' => 'ifthenpayMultibancoSubentidade',
                'required' => true,
                'options' => [
                    'query' => [
                        [
                        'id' => $this->ifthenpayModule->l('Choose Entity'),
                        'name' => $this->ifthenpayModule->l('Choose Entity')
                        ],
                    ],
                    'id' => 'id',
                    'name' => 'name'
                ]
            ];
            $this->generateHelperForm();
        } else {
            $this->setSmartyVariables();
        }
    }

    public function setSmartyVariables()
    {
        $this->setGatewayBuilderData();
        $this->setIfthenpayCallback();
        \Context::getContext()->smarty->assign('spinnerUrl', _MODULE_DIR_ . $this->ifthenpayModule->name . '/views/svg/oval.svg');
        \Context::getContext()->smarty->assign('entidade', \Configuration::get('IFTHENPAY_MULTIBANCO_ENTIDADE'));
        \Context::getContext()->smarty->assign('subEntidade', \Configuration::get('IFTHENPAY_MULTIBANCO_SUBENTIDADE'));
        \Context::getContext()->smarty->assign('chaveAntiPhishing', \Configuration::get('IFTHENPAY_MULTIBANCO_CHAVE_ANTI_PHISHING'));
        \Context::getContext()->smarty->assign('urlCallback', \Configuration::get('IFTHENPAY_MULTIBANCO_URL_CALLBACK'));
    }

    public function setGatewayBuilderData()
    {
        $getEntidadeFromRequest = \Tools::getValue('IFTHENPAY_MULTIBANCO_ENTIDADE');
        $getSubEntidadeFromRequest = \Tools::getValue('IFTHENPAY_MULTIBANCO_SUBENTIDADE');
        parent::setGatewayBuilderData();
        $this->gatewayDataBuilder->setEntidade($getEntidadeFromRequest ? $getEntidadeFromRequest : \Configuration::get('IFTHENPAY_MULTIBANCO_ENTIDADE'));
        $this->gatewayDataBuilder->setSubEntidade($getSubEntidadeFromRequest ? $getSubEntidadeFromRequest : \Configuration::get('IFTHENPAY_MULTIBANCO_SUBENTIDADE'));
    }

    public function processForm()
    {
        $this->setGatewayBuilderData();
        \Configuration::updateValue('IFTHENPAY_MULTIBANCO_ENTIDADE', $this->gatewayDataBuilder->getData()->entidade);
        \Configuration::updateValue('IFTHENPAY_MULTIBANCO_SUBENTIDADE', $this->gatewayDataBuilder->getData()->subEntidade);

        $this->setIfthenpayCallback();

        Utility::setPrestashopCookie('success', $this->ifthenpayModule->l('Entity/SubEntity successfully updated.'));
    }

    public function deleteConfigValues()
    {
        $this->deleteDefaultConfigValues();
        \Configuration::deleteByName('IFTHENPAY_MULTIBANCO_ENTIDADE');
        \Configuration::deleteByName('IFTHENPAY_MULTIBANCO_SUBENTIDADE');
        \Configuration::deleteByName('IFTHENPAY_MULTIBANCO_URL_CALLBACK');
        \Configuration::deleteByName('IFTHENPAY_MULTIBANCO_CHAVE_ANTI_PHISHING');
    }
}
