<?php

class Ifthenpay_MbwayCallbackModuleFrontController extends ModuleFrontController
{
	public $ssl = true;

	/**
	 * @see FrontController::initContent()
	 */
	public function initContent()
	{
    parent::initContent();

		$chave = '';
    $referencia = '';
    $idpedido = '';
		$estado = '';
		$valor = '';

		if (isset($_GET['chave'])) {
			$chave = $_GET['chave'];
		} else {
			$chave = '';
		}

		if (isset($_GET['referencia'])) {
			$referencia = $_GET['referencia'];
		} else {
			$referencia = '';
		}

		if (isset($_GET['idpedido'])) {
			$idpedido = $_GET['idpedido'];
		} else {
			$idpedido = '';
		}

		if (isset($_GET['estado'])) {
			$estado = $_GET['estado'];
		} else {
			$estado = '';
		}

		if (isset($_GET['valor'])) {
			$valor = $_GET['valor'];
		} else {
			$valor = '';
		}

		die($this->module->processCallback($chave, $referencia, $idpedido, $valor, $estado));
  }
}
