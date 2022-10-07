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

namespace PrestaShop\Module\Ifthenpay\Payments;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Builders\DataBuilder;
use PrestaShop\Module\Ifthenpay\Factory\Payment\PaymentFactory;
use PrestaShop\Module\Ifthenpay\Factory\Request\RequestFactory;
use PrestaShop\Module\Ifthenpay\Builders\GatewayDataBuilder;

class Gateway
{
    private $webservice;
    private $account;
    private $paymentMethods = ['multibanco', 'mbway', 'payshop', 'ccard', 'ifthenpay'];
    private $previousModulePaymentMethods = ['pagamento por multibanco', 'pagamento por mbway', 'pagamento por payshop'];
    private $aliasPaymentMethods = [
        'multibanco' => [
            'gb' => 'Multibanco',
            'en' => 'Multibanco',
            'pt' => 'Multibanco',
            'es' => 'Cajero automático',
            'de' => 'Geldautomat'
        ],
        'mbway' => [
            'gb' => 'MB WAY',
            'en' => 'MB WAY',
            'pt' => 'MB WAY',
            'es' => 'MB WAY',
            'de' => 'MB WAY'
        ],
        'payshop' => [
            'gb' => 'Payshop',
            'en' => 'Payshop',
            'pt' => 'Payshop',
            'es' => 'Payshop',
            'de' => 'Payshop'
        ],
        'ccard' => [
            'gb' => 'Credit Card',
            'en' => 'Credit Card',
            'pt' => 'Cartão de Crédito',
            'es' => 'Tarjeta de crédito',
            'de' => 'Kreditkarte'
            
        ],
        
    ];

    public function __construct()
    {
        $this->webservice = RequestFactory::buildWebservice();
    }

    public function getAliasPaymentMethods($paymentMethod, $isoCodeLanguage)
    {
        return $this->aliasPaymentMethods[$paymentMethod][$isoCodeLanguage] ?? $this->aliasPaymentMethods[$paymentMethod]['pt'];
    }

    public function getPaymentMethodsType()
    {
        return $this->paymentMethods;
    }

    public function checkIfthenpayPaymentMethod($paymentMethod)
    {
        if (in_array(strtolower($paymentMethod), $this->paymentMethods)) {
            return true;
        }
        return false;
    }

    public function checkIfPaymentMethodIsPreviousModule($paymentMethod)
    {
        $paymentMethodLowerCase = strtolower($paymentMethod);
        if (in_array($paymentMethodLowerCase, $this->previousModulePaymentMethods)) {
            return $this->paymentMethods[array_search($paymentMethodLowerCase, $this->previousModulePaymentMethods)];
        }
        return false;
    }

    public function authenticate($backofficeKey)
    {
            $authenticate = $this->webservice->postRequest(
                'https://www.ifthenpay.com/IfmbWS/ifmbws.asmx/' .
                'getEntidadeSubentidadeJsonV2',
                [
                   'chavebackoffice' => $backofficeKey,
                ]
            )->getResponseJson();

        if (!$authenticate[0]['Entidade'] && empty($authenticate[0]['SubEntidade'])) {
            throw new \Exception('Backoffice key is invalid');
        } else {
            $this->account = $authenticate;
        }
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function setAccount($account)
    {
        $this->account = $account;
    }

    public function getPaymentMethods()
    {
        $userPaymentMethods = [];

        foreach ($this->account as $account) {
            if (in_array(strtolower($account['Entidade']), $this->paymentMethods)) {
                $userPaymentMethods[] = strtolower($account['Entidade']);
            } elseif (is_numeric($account['Entidade']) || $account['Entidade'] == 'MB') {
                $userPaymentMethods[] = $this->paymentMethods[0];
            }
        }
        return array_unique($userPaymentMethods);
    }

    public function getSubEntidadeInEntidade($entidade)
    {
        return array_filter(
            $this->account,
            function ($value) use ($entidade) {
                return $value['Entidade'] === $entidade;
            }
        );
    }

    public function getEntidadeSubEntidade($paymentMethod)
    {
        $list = null;
        if ($paymentMethod === 'multibanco') {
            $list = array_filter(
                array_column($this->account, 'Entidade'),
                function ($value) {
                    return is_numeric($value) || $value === 'MB' || $value === 'mb';
                }
            );
        } else {
            $list = [];
            foreach (array_column($this->account, 'SubEntidade', 'Entidade') as $key => $value) {
                if ($key === \Tools::strtoupper($paymentMethod)) {
                    $list[] = $value;
                }
            }
        }
        return $list;
    }


    public function execute($paymentMethod, $data, $orderId, $valor)
    {
        $paymentMethod = PaymentFactory::build($paymentMethod, $data, $orderId, $valor, $this->webservice);
        return $paymentMethod->buy();
    }
}
