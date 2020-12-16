<?php


$useSSL = true;

include(dirname(__FILE__).'/../../../config/config.inc.php');
include(dirname(__FILE__).'/../multibanco.php');


$chave = '';
$entidade = '';
$referencia = '';
$valor = '';



if(isset($_GET['chave'])){
	$chave = $_GET['chave'];
}else{
	$chave = '';
}

if(isset($_GET['entidade'])){
	$entidade = $_GET['entidade'];
}else{
	$entidade = '';
}

if(isset($_GET['referencia'])){
	$referencia = $_GET['referencia'];
}else{
	$referencia = '';
}

if(isset($_GET['valor'])){
	$valor = $_GET['valor'];
}else{
	$valor = '';
}


$multibanco = new multibanco();


echo $multibanco ->callBack($chave,$entidade,$referencia,$valor);



?>
