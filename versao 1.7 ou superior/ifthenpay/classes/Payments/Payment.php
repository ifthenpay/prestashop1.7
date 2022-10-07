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

use PrestaShop\Module\Ifthenpay\Contracts\Models\PaymentModelInterface;
use PrestaShop\Module\Ifthenpay\Factory\Builder\BuilderFactory;
use PrestaShop\Module\Ifthenpay\Factory\Request\RequestFactory;

class Payment
{
    protected $orderId;
    protected $valor;
    protected $dataBuilder;
    protected $webservice;

    public function __construct($orderId, $valor)
    {
        $this->orderId = $orderId;
        $this->valor = round(floatval($this->formatNumber($valor)), 2);
        $this->dataBuilder = BuilderFactory::build('default');
        $this->webservice = RequestFactory::buildWebservice();
    }

    protected function formatNumber($number)
    {
        $verifySepDecimal = number_format(99, 2);

        $valorTmp = $number;

        $sepDecimal = substr($verifySepDecimal, 2, 1);

        $hasSepDecimal = true;

        $i = (strlen($valorTmp) -1);

        for ($i; $i!=0; $i-=1) {
            if (substr($valorTmp, $i, 1)=="." || substr($valorTmp, $i, 1)==",") {
                $hasSepDecimal = true;
                $valorTmp = trim(substr($valorTmp, 0, $i))."@".trim(substr($valorTmp, 1+$i));
                break;
            }
        }

        if ($hasSepDecimal!=true) {
            $valorTmp=number_format($valorTmp, 2);

            $i=(strlen($valorTmp)-1);

            for ($i; $i!=1; $i--) {
                if (substr($valorTmp, $i, 1)=="." || substr($valorTmp, $i, 1)==",") {
                    $hasSepDecimal = true;
                    $valorTmp = trim(substr($valorTmp, 0, $i))."@".trim(substr($valorTmp, 1+$i));
                    break;
                }
            }
        }

        for ($i=1; $i!=(strlen($valorTmp)-1); $i++) {
            if (substr($valorTmp, $i, 1)=="." || substr($valorTmp, $i, 1)=="," || substr($valorTmp, $i, 1)==" ") {
                $valorTmp = trim(substr($valorTmp, 0, $i)).trim(substr($valorTmp, 1+$i));
                break;
            }
        }

        if (strlen(strstr($valorTmp, '@'))>0) {
            $valorTmp = trim(substr($valorTmp, 0, strpos($valorTmp, '@'))).trim($sepDecimal).trim(substr($valorTmp, strpos($valorTmp, '@')+1));
        }

        return $valorTmp;
    }

    protected function checkIfPaymentExist($orderId, $paymentModel)
    {
        $paymentData = $paymentModel->getByOrderId($orderId);
        return !empty($paymentData) ? $paymentData : false;
    }
}
