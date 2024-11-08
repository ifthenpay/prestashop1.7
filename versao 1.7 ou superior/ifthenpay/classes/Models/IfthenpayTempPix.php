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

class IfthenpayTempPix extends \ObjectModel
{
	public $id;
	public $cartId;
	public $id_ifthenpay_temp_pix;
	public $customerName;
	public $customerCpf;
	public $customerEmail;
	public $customerPhone;
	public $customerAddress;
	public $customerStreetNumber;
	public $customerCity;
	public $customerZipCode;
	public $customerState;
	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => "ifthenpay_temp_pix",
		'primary' => 'id_ifthenpay_temp_pix',
		'fields' => [
			'cartId' => [
				'type' => self::TYPE_STRING,
				'required' => true,
				'validate' => 'isString'
			],
			'customerName' => [
				'type' => self::TYPE_STRING,
				'required' => false,
				'validate' => 'isString'
			],
			'customerCpf' => [
				'type' => self::TYPE_STRING,
				'required' => false,
				'validate' => 'isString'
			],
			'customerEmail' => [
				'type' => self::TYPE_STRING,
				'required' => false,
				'validate' => 'isString'
			],
			'customerPhone' => [
				'type' => self::TYPE_STRING,
				'required' => false,
				'validate' => 'isString'
			],
			'customerAddress' => [
				'type' => self::TYPE_STRING,
				'required' => false,
				'validate' => 'isString'
			],
			'customerStreetNumber' => [
				'type' => self::TYPE_STRING,
				'required' => false,
				'validate' => 'isString'
			],
			'customerCity' => [
				'type' => self::TYPE_STRING,
				'required' => false,
				'validate' => 'isString'
			],
			'customerZipCode' => [
				'type' => self::TYPE_STRING,
				'required' => false,
				'validate' => 'isString'
			],
			'customerState' => [
				'type' => self::TYPE_STRING,
				'required' => false,
				'validate' => 'isString'
			],

		]

	);


	public static function modelFromData(array $data)
	{

		$model = new IfthenpayTempPix();
		$model->cartId = isset($data['cartId']) ? $data['cartId'] : '';
		$model->customerName = isset($data['customerName']) ? $data['customerName'] : '';
		$model->customerCpf = isset($data['customerCpf']) ? $data['customerCpf'] : '';
		$model->customerEmail = isset($data['customerEmail']) ? $data['customerEmail'] : '';
		$model->customerPhone = isset($data['customerPhone']) ? $data['customerPhone'] : '';
		$model->customerAddress = isset($data['customerAddress']) ? $data['customerAddress'] : '';
		$model->customerStreetNumber = isset($data['customerStreetNumber']) ? $data['customerStreetNumber'] : '';
		$model->customerCity = isset($data['customerCity']) ? $data['customerCity'] : '';
		$model->customerZipCode = isset($data['customerZipCode']) ? $data['customerZipCode'] : '';
		$model->customerState = isset($data['customerState']) ? $data['customerState'] : '';

		return $model;
	}


	public static function dataArrayFromDbByCartId(string $cartId): array
	{
		$query = "SELECT * FROM " . _DB_PREFIX_ . "ifthenpay_temp_pix WHERE cartId = '" . pSQL($cartId) . "'";

		$data = \Db::getInstance()->getRow($query);

		if (!$data) {
			return [];
		}
		$array = [];
		$array['customerName'] = isset($data['customerName']) ? $data['customerName'] : '';
		$array['customerCpf'] = isset($data['customerCpf']) ? $data['customerCpf'] : '';
		$array['customerEmail'] = isset($data['customerEmail']) ? $data['customerEmail'] : '';
		$array['customerPhone'] = isset($data['customerPhone']) ? $data['customerPhone'] : '';
		$array['customerAddress'] = isset($data['customerAddress']) ? $data['customerAddress'] : '';
		$array['customerStreetNumber'] = isset($data['customerStreetNumber']) ? $data['customerStreetNumber'] : '';
		$array['customerCity'] = isset($data['customerCity']) ? $data['customerCity'] : '';
		$array['customerZipCode'] = isset($data['customerZipCode']) ? $data['customerZipCode'] : '';
		$array['customerState'] = isset($data['customerState']) ? $data['customerState'] : '';

		return $array;
	}


	public function saveOrUpdate()
	{
		$query = "SELECT id_ifthenpay_temp_pix FROM " . _DB_PREFIX_ . "ifthenpay_temp_pix WHERE customerCpf = '" . pSQL($this->customerCpf) . "'";

		$existingId = \Db::getInstance()->getValue($query);

		if ($existingId) {
			$this->id = (int)$existingId;
		}

			$this->save();
	}
}
