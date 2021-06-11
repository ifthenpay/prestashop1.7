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

class CCardConfigForm extends ConfigForm
{
    protected $paymentMethod = 'ccard';

    public function setOptions()
    {
        $this->options[] = [
            'id' => $this->ifthenpayModule->l('Choose CCard key'),
            'name' => $this->ifthenpayModule->l('Choose CCard key')
        ];
        $this->addToOptions();
    }

    public function getForm()
    {
        if (!\Configuration::get('IFTHENPAY_CCARD_KEY')) {
            $this->setFormParent();
            $this->setOptions();
            $this->form['form']['input'][] = [
                'type' => 'select',
                'label' => $this->ifthenpayModule->l('CCard key'),
                'desc' => $this->ifthenpayModule->l('Choose CCard key'),
                'name' => 'IFTHENPAY_CCARD_KEY',
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

    public function setSmartyVariables()
    {
        $this->setGatewayBuilderData();
        parent::setSmartyVariables();
        \Context::getContext()->smarty->assign('displayCallbackTableInfo', false);
        \Context::getContext()->smarty->assign('ccardKey', \Configuration::get('IFTHENPAY_CCARD_KEY'));
    }

    public function setGatewayBuilderData()
    {
        $getCCardKeyFromRequest = \Tools::getValue('IFTHENPAY_CCARD_KEY');
        parent::setGatewayBuilderData();
        $this->gatewayDataBuilder->setEntidade(\Tools::strtoupper($this->paymentMethod));
        $this->gatewayDataBuilder->setSubEntidade($getCCardKeyFromRequest ? $getCCardKeyFromRequest : \Configuration::get('IFTHENPAY_CCARD_KEY'));
    }

    public function processForm()
    {
        $this->setGatewayBuilderData();
        \Configuration::updateValue('IFTHENPAY_CCARD_KEY', $this->gatewayDataBuilder->getData()->subEntidade);

        Utility::setPrestashopCookie('success', $this->ifthenpayModule->l('CCard key successfully updated.'));
    }

    public function deleteConfigValues()
    {
        $this->deleteDefaultConfigValues();
        \Configuration::deleteByName('IFTHENPAY_CCARD_KEY');
    }
}
