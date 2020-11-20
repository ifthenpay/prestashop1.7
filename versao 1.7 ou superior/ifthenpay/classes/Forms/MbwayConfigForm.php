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
    /**
    * Set config options for mbway
    * @return void
    */
    public function setOptions()
    {
        $this->options[] = [
            'id' => $this->ifthenpayModule->l('Choose Mbway key'),
            'name' => $this->ifthenpayModule->l('Choose Mbway key')
        ];
        $this->addToOptions();
    }
    /**
    * Get mbway config form
    * @return array
    */
    public function getForm()
    {
        $this->setOptions();
        $this->form['form']['input'][] = [
            'type' => 'select',
            'label' => $this->ifthenpayModule->l('Mbway key'),
            'desc' => $this->ifthenpayModule->l('Choose Mbway key'),
            'name' => 'IFTHENPAY_MBWAY_KEY',
            'required' => true,
            'options' => [
                'query' => $this->options,
                'id' => 'id',
                'name' => 'name'
            ]
        ];
        return $this->form;
    }
    /**
    * Set mbway smarty variables for view
    * @return void
    */
    public function setSmartyVariables()
    {
        $this->setGatewayBuilderData();
        $this->setIfthenpayCallback();

        \Context::getContext()->smarty->assign('mbwayKey', \Configuration::get('IFTHENPAY_MBWAY_KEY'));
        \Context::getContext()->smarty->assign('chaveAntiPhishing', \Configuration::get('IFTHENPAY_MBWAY_CHAVE_ANTI_PHISHING'));
        \Context::getContext()->smarty->assign('urlCallback', \Configuration::get('IFTHENPAY_MBWAY_URL_CALLBACK'));
    }
    /**
    * Set mbway gateway data
    * @return void
    */
    public function setGatewayBuilderData()
    {
        $getMbwayKeyFromRequest = \Tools::getValue('IFTHENPAY_MBWAY_KEY');
        parent::setGatewayBuilderData();
        $this->gatewayDataBuilder->setEntidade(\Tools::strtoupper($this->paymentMethod));
        $this->gatewayDataBuilder->setSubEntidade($getMbwayKeyFromRequest ? $getMbwayKeyFromRequest : \Configuration::get('IFTHENPAY_MBWAY_KEY'));
    }
    /**
    * Process mbway config form
    * @return void
    */
    public function processForm()
    {
        $this->setGatewayBuilderData();
        \Configuration::updateValue('IFTHENPAY_MBWAY_KEY', $this->gatewayDataBuilder->getData()->subEntidade);

        $this->setIfthenpayCallback();

        Utility::setPrestashopCookie('success', $this->ifthenpayModule->l('Mbway key successfully updated.'));
    }
    /**
    * Delete mbway config values
    * @return void
    */
    public function deleteConfigValues()
    {
        $this->deleteDefaultConfigValues();
        \Configuration::deleteByName('IFTHENPAY_MBWAY_KEY');
        \Configuration::deleteByName('IFTHENPAY_MBWAY_URL_CALLBACK');
        \Configuration::deleteByName('IFTHENPAY_MBWAY_CHAVE_ANTI_PHISHING');
    }
}
