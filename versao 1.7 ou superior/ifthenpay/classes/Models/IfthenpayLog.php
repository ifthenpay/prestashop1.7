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

class IfthenpayLog extends \ObjectModel
{
    public $id_ifthenpay_log;
    public $type;
    public $message;
    public $order_id;
    public $date_add;
    public $date_upd;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => "ifthenpay_log",
        'primary' => 'id_ifthenpay_log',
        'fields' => array(
            'type' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'message' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'order_id' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'created' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
        ),
    );
}
