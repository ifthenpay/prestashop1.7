<?php

include(dirname(__FILE__).'/../../../config/config.inc.php');
include(dirname(__FILE__).'/../../../header.php');
include(dirname(__FILE__).'/../multibanco.php');

$currency = new Currency(intval(isset($_POST['currency_payement']) ? $_POST['currency_payement'] : $cookie->id_currency));
$total = floatval(number_format($cart->getOrderTotal(true, 3), 2, '.', ''));
$mailVars = array(
    '{id_order}'           => $cart->id
);

$multibanco = new multibanco();
$multibanco->validateOrder($cart->id, Configuration::get('_PS_OS_MULTIBANCO_0'), $total, $multibanco->displayName, NULL, $mailVars, $currency->id);
$order = new Order($multibanco->currentOrder);
Tools::redirectLink(__PS_BASE_URI__.'order-confirmation.php?id_cart='.$cart->id.'&id_module='.$multibanco->id.'&id_order='.$multibanco->currentOrder.'&key='.$order->secure_key);

?>
