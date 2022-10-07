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

namespace PrestaShop\Module\Ifthenpay\Models;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Contracts\Models\PaymentModelInterface;
use PrestaShop\Module\Ifthenpay\Factory\Database\DatabaseFactory;

class IfthenpayCCard extends \ObjectModel implements PaymentModelInterface
{
    public $id;
    public $id_ifthenpay_ccard;
    public $id_transacao;
    public $referencia;
    public $validade;
    public $order_id;

    public static $definition = [
        'table' => "ifthenpay_ccard",
        'primary' => 'id_ifthenpay_ccard',
        'multilang' => false,
        'multishop' => true,
        'fields' => [
            'requestId' => [
                'type' => self::TYPE_STRING,
                'required' => true,
                'validate' => 'isString',
                'size' => 50,
            ],
            'order_id' => [
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt',
            ],
            'status' => [
                'type' => self::TYPE_STRING,
                'required' => true,
                'validate' => 'isString',
                'size' => 50,
            ],
        ]
    ];

    public function __construct($id_name_table = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id_name_table, $id_lang, $id_shop);
        \Shop::addTableAssociation(self::$definition['table'], array('type' => 'shop'));
    }

    public static function getByOrderId($orderId)
    {
        $query = DatabaseFactory::buildDbQuery();
        $query->from(self::$definition['table']);
        $query->where('order_id = ' . (int) $orderId);
        $rowOrder = \Db::getInstance()->getRow($query);

        if (is_array($rowOrder)) {
            return $rowOrder;
        } else {
            return array();
        }
    }

    public static function getCCardByRequestId($requestId)
    {
        $rowOrder = \Db::getInstance()
            ->executeS('SELECT * FROM ' . _DB_PREFIX_  . self::$definition['table'] . ' WHERE (requestId = ' . '\'' . \pSQL((string) $requestId) .  '\') ');
            if (is_array($rowOrder)) {
            return $rowOrder[0];
        } else {
            return array();
        }
    }
}