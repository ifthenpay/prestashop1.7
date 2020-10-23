<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class Ifthenpay_Mbway extends PaymentModule
{
  const FLAG_DISPLAY_PAYMENT_INVITE = 'IFTHENPAY_MBWAY_PAYMENT_INVITE';

  public $ifthenpayMbwayKey;
  public $ifthenpayMbwayAntiPhishingKey;
  public $ifthenpayMbwayOrderStatusPending;
  public $ifthenpayMbwayOrderStatusConfirmed;

  private $_html = '';
  private $_postErrors = array();
  
  private $ifthenpay_mbway_url_api = 'https://www.ifthenpay.com/mbwayWS/IfthenPayMBW.asmx/SetPedidoJSON';

  public function __construct()
  {
    $this->name = 'ifthenpay_mbway';
    $this->tab = 'payments_gateways';
    $this->version = '1.0.3';
    $this->author = 'IfthenPay, Lda';
    $this->controllers = array('payment', 'validation');

    $this->currencies = true;
    $this->currencies_mode = 'checkbox';
		$this->is_eu_compatible = 1;
    $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    $this->bootstrap = true;
    parent::__construct();
    $this->displayName = $this->l('Mbway Payment');
    $this->description = $this->l('This module allow payments using MBWAY Gateway.');
    $this->confirmUninstall = $this->l('Are you sure you want to delete these details?');

    $config = Configuration::getMultiple(array('IFTHENPAY_MBWAY_KEY', 'IFTHENPAY_MBWAY_ANTI_PHISHING_KEY'));
    if (isset($config['IFTHENPAY_MBWAY_KEY'])) {
      Configuration::updateValue(self::FLAG_DISPLAY_PAYMENT_INVITE, true);
      $this->ifthenpayMbwayKey = $config['IFTHENPAY_MBWAY_KEY'];
    }
    if (isset($config['IFTHENPAY_MBWAY_ANTI_PHISHING_KEY'])) {
      $this->ifthenpayMbwayAntiPhishingKey = $config['IFTHENPAY_MBWAY_ANTI_PHISHING_KEY'];
    }
    if (isset($config['IFTHENPAY_MBWAY_ORDER_STATUS_PENDING'])) {
      $this->ifthenpayMbwayOrderStatusPending = $config['IFTHENPAY_MBWAY_ORDER_STATUS_PENDING'];
    }

		if (isset($config['IFTHENPAY_MBWAY_ORDER_STATUS_CONFIRMED'])) {
      $this->ifthenpayMbwayOrderStatusConfirmed = $config['IFTHENPAY_MBWAY_ORDER_STATUS_CONFIRMED'];
    }
			
    if (!count(Currency::checkPaymentCurrencies($this->id))) {
      $this->warning = $this->l('No currency has been set for this module.');
    }

    if (!isset($this->ifthenpayMbwayKey)) {
      $this->warning = $this->l('You should configure Ifthenpay MBWAY Key first in order to be able to use') . ' ' . $this->displayName;
    }

    if (extension_loaded('curl') == false)
    {
      $this->warning =  $this->l('Ifthenpay Mbway: You have to enable the cURL extension on your server use this module');
    }
			
  }

  private function smartCopy($source, $dest, $options=array('folderPermission'=>0755,'filePermission'=>0755))
	{
      $result=false;

      if (is_file($source)) {
        if ($dest[strlen($dest)-1]=='/') {
          if (!file_exists($dest)) {
            cmfcDirectory::makeAll($dest,$options['folderPermission'],true);
          }
          $__dest=$dest."/".basename($source);
        } else {
          $__dest=$dest;
        }
        $result=copy($source, $__dest);
        chmod($__dest,$options['filePermission']);

      } elseif(is_dir($source)) {
        if ($dest[strlen($dest)-1]=='/') {
          if ($source[strlen($source)-1]=='/') {
            //Copy only contents
          } else {
            //Change parent itself and its contents
            $dest=$dest.basename($source);
            @mkdir($dest);
            chmod($dest,$options['filePermission']);
          }
        } else {
          if ($source[strlen($source)-1]=='/') {
            //Copy parent directory with new name and all its content
            @mkdir($dest,$options['folderPermission']);
            chmod($dest,$options['filePermission']);
          } else {
            //Copy parent directory with new name and all its content
            @mkdir($dest,$options['folderPermission']);
            chmod($dest,$options['filePermission']);
          }
        }

        $dirHandle=opendir($source);
        while($file=readdir($dirHandle))
        {
          if($file!="." && $file!="..")
          {
            if(!is_dir($source."/".$file)) {
              $__dest=$dest."/".$file;
            } else {
              $__dest=$dest."/".$file;
            }
            $result=smartCopy($source."/".$file, $__dest, $options);
          }
        }
        closedir($dirHandle);
      } else {
        $result=false;
      }
      return $result;
    }

  private function create_states($configuration, $message, $color, $send_email = false, $template = '')
  {
    if (!Configuration::get($configuration)) {
      $order_state = new OrderState();
      $order_state->name = array();

      foreach (Language::getLanguages() as $language) {
        $order_state->name[$language['id_lang']] = $message;
      }

      $order_state->module_name = $this->name;
      $order_state->send_email = $send_email;
      $order_state->template = $template;
      $order_state->color = '#' . $color;
      $order_state->hidden = false;
      $order_state->delivery = false;
      $order_state->logable = false;
      $order_state->invoice = false;
      $order_state->unremovable = true;

      if ($order_state->add()) {
        $source = dirname(__FILE__).'/views/img/status.gif';
        $destination = dirname(__FILE__).'/../../img/os/'.(int) $order_state->id.'.gif';
        copy($source, $destination);
      }
  
      Configuration::updateValue($configuration, (int) $order_state->id);
    }
  }

  public function install()
  {
    if (extension_loaded('curl') == false)
    {
        $this->_errors[] = $this->l('You have to enable the cURL extension on your server to install this module');
        return false;
    }

    Configuration::updateValue(self::FLAG_DISPLAY_PAYMENT_INVITE, true);

    $this->create_states('IFTHENPAY_MBWAY_ORDER_STATUS_PENDING', 'Aguarda pagamento por MBWay', 'ffff00');
    $this->create_states('IFTHENPAY_MBWAY_ORDER_STATUS_CONFIRMED', 'Confirmado pagamento por MBWay', '00ffff', true, 'payment');

    if (version_compare(_PS_VERSION_, '1.7', '>=')) {
      if (
        !parent::install() ||
        !$this->registerHook('paymentOptions') ||
        !$this->registerHook('paymentReturn') ||
        !$this->registerHook('header')
      ) {
          return false;
      }
    } else {
      if (
        !parent::install() ||
        !$this->registerHook('payment') ||
        !$this->registerHook('displayPaymentEU') ||
        !$this->registerHook('header') ||
        !$this->registerHook('paymentReturn')
      ) {
          return false;
      }
    }
    return true;
  }

  public function uninstall() {
    Configuration::updateValue('IFTHENPAY_MBWAY_ANTI_PHISHING_KEY', "");
    Configuration::deleteByName(self::FLAG_DISPLAY_PAYMENT_INVITE);
    return parent::uninstall();
  }

  private function _infoTable()
  {
    $this->_html .= '<div style="background: white;">
		<table style="margin-bottom: 20px;">
			<tr>
				<td>
					<img src="../modules/' . $this->name . '/views/img/mbway.jpg" style="margin-right:15px;">
				</td>
				<td>
					<b>Este m&oacute;dulo permite o pagamento seguro por MBWay.</b>
					<br />
					<br />
					Se o cliente optar por pagar por MBWay o estado da encomenda ser&aacute; colocado em "Aguardar pagamento por MBWay"
					<br />
					Aquando do pagamento, se o callback se encontrar activo, o estado da encomenda ser&aacute; alterado para "Confirmado pagamento por MBWay"
					<br />
					<br />
					<b>NOTA: Este m&oacute;dulo s&oacute; funciona com o Sistema de Pagamentos por MBWay da <u><a href="https://www.ifthenpay.com" target="_blank">IfthenPay</a></u>.</b>
				</td>
			</tr>
    </table></div>';
  }

	private function _displayForm()
	{
		$this->_html .=
		'<div style="background: white;"><form action="'.Tools::htmlentitiesUTF8($_SERVER['REQUEST_URI']).'" method="post">
			<fieldset>
			<legend><img src="../modules/' . $this->name . '/logo.gif" />Dados do Contracto</legend>
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="form">
					<tr><td width="130" style="height: 35px;">'.$this->l('MBWay Key').'</td><td><input type="text" name="ifthenpay_mbway_key" value="'.htmlentities(Tools::getValue('ifthenpay_mbway_key', $this->ifthenpayMbwayKey), ENT_COMPAT, 'UTF-8').'" style="width: 100%;" /></td></tr>
					<tr><td colspan="2" style="padding-top: 20px; padding-bottom: 20px;" align="center"><input class="button" name="btnSubmit" value="Guardar Dados" type="submit" /></td></tr>
				</table>
			</fieldset>
		</form></div>';
	}

	private function _postProcess()
	{
		if (Tools::isSubmit('btnSubmit'))
		{
      Configuration::updateValue('IFTHENPAY_MBWAY_KEY', Tools::getValue('ifthenpay_mbway_key'));
      
      if(Configuration::get('IFTHENPAY_MBWAY_ANTI_PHISHING_KEY') == "") {
        Configuration::updateValue('IFTHENPAY_MBWAY_ANTI_PHISHING_KEY', md5(time()));
      }
		}
		$this->_html .= '<div class="conf confirm"> Dados guardados com sucesso</div>';
	}

	private function _displayCallbackForm()
	{
		$this->_html .='<br /><br />
			<fieldset>
			<legend><img src="../modules/' . $this->name . '/logo.gif" />Dados Callback</legend>
				<table border="0" cellpadding="0" cellspacing="0" id="form">
					<tr>
						<td width="130" style="height: 35px;">
							URL Callback
						</td>
						<td>
							<b>'.$this->context->link->getModuleLink($this->name, 'callback').'?chave=[CHAVE_ANTI_PHISHING]&referencia=[REFERENCIA]&idpedido=[ID_TRANSACAO]&valor=[VALOR]&estado=[ESTADO]</b>
						</td>
					</tr>
					<tr>
						<td width="130" style="height: 35px;">
							Chave Anti-Phishing
						</td>
						<td>
							<b>'.Configuration::get('IFTHENPAY_MBWAY_ANTI_PHISHING_KEY').'</b>
						</td>
					</tr>

					<tr>
						<td colspan="2">
							<br /><br />Caso deseje activar o callback ter&aacute; de comunicar os seguintes dados &agrave; IfthenPay:<br /><br />
							> MBWay Key<small><small><small><small><small><small><br /><br /></small></small></small></small></small></small>
							> 4 &uacute;ltimos digitos da chave de backoffice <i>(chave fornecida no acto da ades&atilde;o constituida por 16 d&iacute;gitos agrupados 4 a 4 -> Ex.: 0000-0000-0000-0000)</i><small><small><small><small><small><small><br /><br /></small></small></small></small></small></small>
							> Url de callback e chave anti-phishing acima indicados.<br /><br />
							Estes dados devem ser comunicados para o email <a href="mailto:ifthenpay@ifthenpay.com?subject=Activar Callback">ifthenpay@ifthenpay.com</a> com o assunto "Activar Callback".
						</td>
					</tr>
				</table>
			</fieldset>';
	}

	private function _postValidation()
	{
    $erro = "";
		if (Tools::isSubmit('btnSubmit'))
		{

			if (!Tools::getValue('ifthenpay_mbway_key')) {
				$erro = 'Tem de indicar uma <b><u>MBWay Key</u></b>';
			}

			if($erro!="")
				$this->_postErrors[] = $erro . '.';
		}
	}

  public function getContent()
	{
    if (Tools::isSubmit('btnSubmit'))
		{
			$this->_postValidation();
			if (!count($this->_postErrors))
				$this->_postProcess();
			else
				foreach ($this->_postErrors as $err)
					$this->_html .= '<div class="alert error">'.$err.'</div>';
    }
    
    $this->_infoTable();
    $this->_displayForm();

    if(Configuration::get('IFTHENPAY_MBWAY_ANTI_PHISHING_KEY') != "") {
      $this->_displayCallbackForm();
    }

    return $this->_html;
  }

  public function checkCurrency($cart)
	{
		$currency_order = new Currency($cart->id_currency);
		$currencies_module = $this->getCurrency($cart->id_currency);

		if (is_array($currencies_module))
			foreach ($currencies_module as $currency_module)
				if ($currency_order->id == $currency_module['id_currency'])
					return true;
		return false;
  }
  
  protected function generateForm($version = '')
  {
    $this->context->smarty->assign([
        'action' => $this->context->link->getModuleLink($this->name, 'validation', array(), true),
    ]);
    return $this->display(__FILE__, 'mbway_mobilephone' . ($version !== '' ? '_' . $version : '') . '.tpl');
  }

  public function hookPaymentOptions($params)
  {
    if (!$this->active) {
			return;
		}

		if (!$this->checkCurrency($params['cart'])) {
			return;
    }        

    $paymentOption = new PrestaShop\PrestaShop\Core\Payment\PaymentOption();
    $paymentOption->setModuleName($this->name)
            ->setCallToActionText($this->l('Pagamento por MBWay'))
            ->setForm($this->generateForm());

    $payment_options = [
      $paymentOption,
    ];

    return $payment_options;
  }

  public function hookPayment($params)
	{
		if (!$this->active)
			return;
		if (!$this->checkCurrency($params['cart']))
			return;

		$this->smarty->assign(array(
      'module_name' => $this->name,
			'this_path' => $this->_path,
			'this_path_bw' => $this->_path,
			'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/'
		));
		return $this->display(__FILE__, 'payment.tpl');
	}

	public function hookDisplayPaymentEU($params)
	{
		if (!$this->active)
			return;

		if (!$this->checkCurrency($params['cart']))
			return;

		$payment_options = array(
			'cta_text' => $this->l('Pagamento por MBWay'),
			'logo' => Media::getMediaPath(_PS_MODULE_DIR_.$this->name.'/logo.jpg'),
			'action' => $this->context->link->getModuleLink($this->name, 'validation', array(), true)
		);

		return $payment_options;
	}

  public function hookHeader()
  {
    if (version_compare(_PS_VERSION_, '1.7', '>=')) {
      $this->context->controller->registerJavascript('modules-ifthenpay-mbway', 'modules/'.$this->name.'/views/js/ifthenpay_mbway.js', ['position' => 'bottom', 'priority' => 150]); 
    } else {
      $this->context->controller->addJS($this->_path . '/views/js/ifthenpay_mbway.js');
    }
  }

  private function callIfthenpayMbWayAPI($referencia, $nr_encomenda, $nome, $nr_tlm, $valor) 
  {

    // Get cURL resource
    $curl = curl_init();

    // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $this->ifthenpay_mbway_url_api . '?MbWayKey=' . Configuration::get('IFTHENPAY_MBWAY_KEY') . '&canal=03&referencia=' . $nr_encomenda . '&valor=' . $valor . '&nrtlm=' . $nr_tlm . '&email=&descricao=' . urlencode ('Enc.: #' . $nr_encomenda . ' (' . $referencia . ') ' . $nome),
      CURLOPT_USERAGENT => 'Ifthenpay Prestashop Client'
    ));

    // Send the request & save response to $resp
    $resp = curl_exec($curl);
    // Close request to clear up some resources
    curl_close($curl);

    return json_decode($resp);
  }

  public function hookPaymentReturn($params)
  {
    if (!$this->active) {
        return;
    }

    $order = (version_compare(_PS_VERSION_, '1.7', '>=')) ? $params['order'] : $params['objOrder'];

    $nr_tlm = Configuration::get('IFTHENPAY_MBWAY_CART_' . $order->id_cart);
    
    if (Configuration::get('IFTHENPAY_MBWAY_CALLBACK_' . $order->id) === false) {
      
      $result = $this->callIfthenpayMbWayAPI($order->reference, $order->id, Configuration::get('PS_SHOP_NAME'), $nr_tlm, Tools::ps_round($order->total_paid, Configuration::get('PS_PRICE_ROUND_MODE')));

      if($result->Estado !== '000') 
      {
        $history = new OrderHistory();
        $history->id_order = (int)$order->id;
        //$erro = "Erro: [" . $result->Estado . "]".$result->MsgDescricao;
        $history->changeIdOrderState((int)Configuration::get('PS_OS_ERROR'), (int)($order->id));
      }
      Configuration::updateValue('IFTHENPAY_MBWAY_CALLBACK_' . $order->id, $result->IdPedido);
    }   

    $this->context->smarty->assign(array(
			'this_path' 	=> $this->_path
		));
    
    return $this->display(__FILE__, 'payment_return.tpl');
  }

  public function processCallback($chave, $referencia, $idpedido, $valor, $estado)
  {
    global $link;
		$context = Context::getContext();
    $context->link = new Link();
    
    $config_key = Configuration::get('IFTHENPAY_MBWAY_ANTI_PHISHING_KEY');
    $get_order_mbway_id = Configuration::get('IFTHENPAY_MBWAY_CALLBACK_' . $referencia);

    if ( $config_key === $chave && $get_order_mbway_id === $idpedido )
    {
      $order = new Order($referencia);

      if ($estado === 'PAGO')
      {
        $new_history = new OrderHistory();
        $new_history->id_order = (int)$order->id;
        $new_history->changeIdOrderState((int)Configuration::get('IFTHENPAY_MBWAY_ORDER_STATUS_CONFIRMED'), (int)$order->id);
        $new_history->addWithemail(true, null, $context);

        return "OK";
      } else {
        return "001 - CBE";
      }
    } else {
      return "000 - CBE";
    }
  }
}
