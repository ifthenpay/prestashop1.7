<?php

class MultibancoCallbackModuleFrontController extends ModuleFrontController
{
	public $ssl = true;

	/**
	 * @see FrontController::initContent()
	 */
	public function initContent()
	{
    parent::initContent();

		$chave = '';
		$entidade = '';
		$referencia = '';
		$valor = '';

		if (isset($_GET['chave'])) {
			$chave = $_GET['chave'];
		} else {
			$chave = '';
		}

		if (isset($_GET['entidade'])) {
			$entidade = $_GET['entidade'];
		} else {
			$entidade = '';
		}

		if (isset($_GET['referencia'])) {
			$referencia = $_GET['referencia'];
		} else {
			$referencia = '';
		}

		if (isset($_GET['valor'])) {
			$valor = $_GET['valor'];
		} else {
			$valor = '';
		}

		echo $this->module->callBack($chave,$entidade,$referencia,$valor);
  }
}
