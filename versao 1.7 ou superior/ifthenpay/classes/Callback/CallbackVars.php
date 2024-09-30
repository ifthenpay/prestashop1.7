<?php

declare(strict_types=1);

namespace PrestaShop\Module\Ifthenpay\Callback;


class CallbackVars
{
	const PAYMENT = 'p';			//payment method - internal
	const ANTIPHISH_KEY = 'apk';	// Anti-phishing key
	const ORDER_ID = 'oid'; 		// Opencart Order ID
	const ENTITY = 'ent'; 			// Multibanco Entity
	const REFERENCE = 'ref'; 		// Multibanco or Payshop reference
	const TRANSACTION_ID = 'tid'; 	// Transaction ID, normally is the request ID
	const AMOUNT = 'val';			// Amount payed
	const PM = 'pm'; 				// Payment method used to pay the order
	const TYPE = 'type'; 			// type - payment method
	const ECOMMERCE_VERSION = 'ec'; // Ecommerce Platform version
	const MODULE_VERSION = 'mv'; 	// Ifthenpay module version
}
