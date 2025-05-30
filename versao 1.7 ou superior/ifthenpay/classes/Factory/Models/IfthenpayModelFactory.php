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

namespace PrestaShop\Module\Ifthenpay\Factory\Models;

if (!defined('_PS_VERSION_')) {
	exit;
}

use PrestaShop\Module\Ifthenpay\Models\IfthenpayLog;
use PrestaShop\Module\Ifthenpay\Models\IfthenpayCCard;
use PrestaShop\Module\Ifthenpay\Models\IfthenpayCofidispay;
use PrestaShop\Module\Ifthenpay\Models\IfthenpayMbway;
use PrestaShop\Module\Ifthenpay\Models\IfthenpayPayshop;
use PrestaShop\Module\Ifthenpay\Models\IfthenpayMultibanco;
use PrestaShop\Module\Ifthenpay\Models\IfthenpayIfthenpaygateway;
use PrestaShop\Module\Ifthenpay\Models\IfthenpayPix;

class IfthenpayModelFactory
{
	public static function build($type, $modelId = null)
	{
		switch ($type) {
			case 'multibanco':
				return new IfthenpayMultibanco($modelId);
			case 'mbway':
				return new IfthenpayMbway($modelId);
			case 'payshop':
				return new IfthenpayPayshop($modelId);
			case 'ccard':
				return new IfthenpayCCard($modelId);
			case 'cofidispay':
				return new IfthenpayCofidispay($modelId);
			case 'ifthenpaygateway':
				return new IfthenpayIfthenpaygateway($modelId);
			case 'pix':
				return new IfthenpayPix($modelId);
			case 'log':
				return new IfthenpayLog($modelId);
			default:
				throw new \Exception("Unknown Payment Model Class");
		}
	}
}
