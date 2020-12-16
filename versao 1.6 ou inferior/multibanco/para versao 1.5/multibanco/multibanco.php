<?php

if (!defined('_PS_VERSION_'))
	exit;

class MultiBanco extends PaymentModule
{
	private $_html = '';
	private $_postErrors = array();

	public $ifmb_entidade;
	public $ifmb_subentidade;
	public $ifmb_cap;
	public $ifmb_os_0;
	public $ifmb_os_1;
	
	public function __construct()
	{
		$this->name = 'multibanco';
		$this->tab = 'payments_gateways';
		$this->version = '4.0.4';
		$this->author = 'Ifthen, Lda';
		
		$this->currencies = true;
		$this->currencies_mode = 'checkbox';

		$config = Configuration::getMultiple(array('MULTIBANCO_ENTIDADE', 'MULTIBANCO_SUBENTIDADE', 'MULTIBANCO_CHAVE_ANTI_PHISHING', 'MULTIBANCO_OS_0', 'MULTIBANCO_OS_1'));
		if (isset($config['MULTIBANCO_ENTIDADE']))
			$this->ifmb_entidade = $config['MULTIBANCO_ENTIDADE'];
			
		if (isset($config['MULTIBANCO_SUBENTIDADE']))
			$this->ifmb_subentidade = $config['MULTIBANCO_SUBENTIDADE'];
			
		if (isset($config['MULTIBANCO_CHAVE_ANTI_PHISHING']))
			$this->ifmb_cap = $config['MULTIBANCO_CHAVE_ANTI_PHISHING'];
			
		if (isset($config['MULTIBANCO_OS_0']))
			$this->ifmb_os_0 = $config['MULTIBANCO_OS_0'];
			
		if (isset($config['MULTIBANCO_OS_1']))
			$this->ifmb_os_1 = $config['MULTIBANCO_OS_1'];

		parent::__construct();

		$this->displayName = 'Pagamento por Multibanco';
		$this->description = 'Permitir &agrave;s empresas, lojas on-line, escolas, clubes, associa&ccedil;&otilde;es e munic&iacute;pios a emiss&atilde;o de Refer&ecirc;ncias Multibanco nos seus documentos ou site, que podem ser pagas na rede Multibanco ou Home Banking.';
		$this->confirmUninstall = 'Confirma o procedimento para desinstalar o Pagamento por Multibanco?';
		if (!isset($this->ifmb_entidade) || !isset($this->ifmb_subentidade))
			$this->warning = 'Deve configurar a Entidade e Subentidade antes de utilizar o m&oacute;dulo IFmb - Pagamentos por Refer&ecirc;ncias Multibanco...';
		if (!count(Currency::checkPaymentCurrencies($this->id)))
			$this->warning = 'N&atilde;o foi definido qualquer moeda para este modulo.';
	}

	public function create_states()
	{

		$this->order_state = 	array(
									array( 'ffff00', '10110', 'Aguardar pagamento por Multibanco',  'multibanco' ,0),
									array( '00ffff', '01110', 'Confirmado pagamento por Multibanco',	 'payment'	,1)
								);

		/** OBTENDO UMA LISTA DOS IDIOMAS  **/
		$languages = Db::getInstance()->ExecuteS('
		SELECT `id_lang`, `iso_code`
		FROM `'._DB_PREFIX_.'lang`
		');
		/** /OBTENDO UMA LISTA DOS IDIOMAS  **/

		/** INSTALANDO STATUS MULTIBANCO **/
		foreach ($this->order_state as $key => $value)
		{
			/** CRIANDO OS STATUS NA TABELA order_state **/
			Db::getInstance()->Execute
			('
				INSERT INTO `' . _DB_PREFIX_ . 'order_state`
			( `invoice`, `send_email`, `color`, `unremovable`, `logable`, `delivery`, `module_name`)
				VALUES
			(0, '.$value[4].', \'#'.$value[0].'\', 1, 1, 0,\'multibanco\');
			');
			/** /CRIANDO OS STATUS NA TABELA order_state **/

			//$this->figura 	= mysql_insert_id();
			$this->figura 	= Db::getInstance()->Insert_ID();

			//echo $this->figura;
			
			foreach ( $languages as $language_atual )
			{
				/** CRIANDO AS DESCRIÇÕES DOS STATUS NA TABELA order_state_lang  **/
				Db::getInstance()->Execute
				('
					INSERT INTO `' . _DB_PREFIX_ . 'order_state_lang`
				(`id_order_state`, `id_lang`, `name`, `template`)
					VALUES
				('.$this->figura .', '.$language_atual['id_lang'].', \''.$value[2].'\', \''.$value[3].'\');
				');
				/** /CRIANDO AS DESCRIÇÕES DOS STATUS NA TABELA order_state_lang  **/
			}
			
			/** COPIANDO O ICONE ATUAL **/
			$this->smartCopy((dirname(__file__) . "/logo.gif"),(dirname( dirname (dirname(__file__) ) ) .  "/img/os/$this->figura.gif"));
			/** /COPIANDO O ICONE ATUAL **/
			
			/** RENOMEAR O MAIL ORIGINAL **/
			//rename((dirname( dirname (dirname(__file__) ) ) .  "/mails/pt/order_conf.html"),(dirname( dirname (dirname(__file__) ) ) .  "/mails/pt/order_conf_original.html"));
			/** /RENOMEAR O MAIL ORIGINAL **/
			
			
			

    		/** GRAVA AS CONFIGURAÇÕES  **/
    		Configuration::updateValue("MULTIBANCO_OS_$key", 	$this->figura);
			
			
			/** CRIANDO A Tabela de Registo de referências multibanco  **/
				Db::getInstance()->Execute
				('
					CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'multibanco`(
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `order_id` int(11) NOT NULL,
					  `entidade` int(11) NOT NULL,
					  `referencia` varchar(9) NOT NULL,
					  `valor` decimal(10,2) NOT NULL,
					  `chave` varchar(50) DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;'
				);
				/** /CRIANDO A Tabela de Registo de referências multibanco  **/

		}
		
		
		foreach ( $languages as $language_atual )
		{
			/** COPIANDO O MAIL ATUAL **/
			$this->smartCopy((dirname(__file__) . "/mails/multibanco.html"),(dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/multibanco.html"));
			$this->smartCopy((dirname(__file__) . "/mails/multibanco.txt"),(dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/multibanco.txt"));
			$this->smartCopy((dirname(__file__) . "/mails/multibanco_conf.html"),(dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/multibanco_conf.html"));
			$this->smartCopy((dirname(__file__) . "/mails/multibanco_conf.txt"),(dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/multibanco_conf.txt"));
			$this->smartCopy((dirname(__file__) . "/mails/multibanco_relembrar.html"),(dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/multibanco_relembrar.html"));
			$this->smartCopy((dirname(__file__) . "/mails/multibanco_relembrar.txt"),(dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/multibanco_relembrar.txt"));
			/** /COPIANDO O MAIL ATUAL **/
		}

		return true;

	}
	
	public function delete_create_states()
	{
		/*Db::getInstance()->Execute
		('
			DELETE FROM `' . _DB_PREFIX_ . 'order_state_lang` WHERE `id_order_state`  = '.Configuration::get('MULTIBANCO_OS_0').' OR `id_order_state`  = '.Configuration::get('MULTIBANCO_OS_1').';
		');
			
		Db::getInstance()->Execute
		('
			DELETE  FROM `' . _DB_PREFIX_ . 'order_state` WHERE `id_order_state`  = '.Configuration::get('MULTIBANCO_OS_0').' OR `id_order_state`  = '.Configuration::get('MULTIBANCO_OS_1').';
		');
		
		unlink((dirname( dirname (dirname(__file__) ) ) .  "/img/os/".Configuration::get('MULTIBANCO_OS_0').".gif"));
		unlink((dirname( dirname (dirname(__file__) ) ) .  "/img/os/".Configuration::get('MULTIBANCO_OS_1').".gif"));*/
		
		
		/** OBTENDO UMA LISTA DOS IDIOMAS  **/
		$languages = Db::getInstance()->ExecuteS('
		SELECT `id_lang`, `iso_code`
		FROM `'._DB_PREFIX_.'lang`
		');
		/** /OBTENDO UMA LISTA DOS IDIOMAS  **/
		
		foreach ( $languages as $language_atual )
		{
			unlink((dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/multibanco.html"));
			unlink((dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/multibanco.txt"));
			unlink((dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/multibanco_conf.html"));
			unlink((dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/multibanco_conf.txt"));
			unlink((dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/multibanco_relembrar.html"));
			unlink((dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/multibanco_relembrar.txt"));
		}
		
		Configuration::deleteByName("MULTIBANCO_OS_0");
		Configuration::deleteByName("MULTIBANCO_OS_1");


		return true;

	}
	
	function smartCopy($source, $dest, $options=array('folderPermission'=>0755,'filePermission'=>0755))
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
                    //echo "$source/$file ||| $__dest<br />";
                    $result=smartCopy($source."/".$file, $__dest, $options);
                }
            }
            closedir($dirHandle);

        } else {
            $result=false;
        }
        return $result;
    }
	
	public function install()
    {
        if(!(Configuration::get('MULTIBANCO_OS_0') > 0))
            $this->create_states();
            
        if (!parent::install() OR 
			!$this->registerHook('payment') OR 
			!$this->registerHook('paymentReturn') OR 
			!$this->registerHook('displayAdminOrder') OR
			!$this->registerHook('displayOrderDetail') OR
			!$this->registerHook('header'))
			return false;
	
		Configuration::updateValue('MULTIBANCO_CHAVE_ANTI_PHISHING', md5(time()));
		
		
        return true;
	}
 
    public function uninstall()
	{
		if(Configuration::get('MULTIBANCO_OS_0') > 0)
            $this->delete_create_states();
			
		if (!Configuration::deleteByName('MULTIBANCO_ENTIDADE') OR 
				!Configuration::deleteByName('MULTIBANCO_SUBENTIDADE') OR 
				!Configuration::deleteByName('MULTIBANCO_CHAVE_ANTI_PHISHING') OR 
				!Configuration::deleteByName('MULTIBANCO_OS_0') OR 
				!Configuration::deleteByName('MULTIBANCO_OS_1') OR 
				!parent::uninstall())
			return false;
			
        return true;
	}
	
	function hookdisplayAdminOrder($params)
	{
	
	
		if (!$this->active)
			return;
			
		$order_id    = $params['id_order'];
		
		$order = new Order($order_id);
		
		
		//verifica se o método da encomenda é mesmo este ou não...
		if($order->payment != $this->displayName)
			return;
		
		
		$ref = $this->GenerateMbRef($this->ifmb_entidade,$this->ifmb_subentidade,$order_id,$order->total_paid);
		
		global $cookie,$smarty;

		$estado = "";
		
		$url_folder_adm = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		$a_url_folder_adm = explode('/',$url_folder_adm);
		$url_folder_adm = $a_url_folder_adm[1];
		
		$smarty->assign(array(
			'entidade' 	=> $this->ifmb_entidade,
			'referencia' => $ref,
			'valor' 	=> $order->total_paid,
			'order_id' 	=> $order_id,
			'token' 	=> $this->context->controller->token,
			'estadoenvio'	=>	Tools::getValue("estadoenvio"),
			'estadolembrete'	=>	Tools::getValue("estadolembrete"),
			'this_path' 	=> $this->curPageURL().'modules/'.$this->name.'/',
			'url_folder'	=> $url_folder_adm
		));
		
		

		return $this->display(__FILE__, '/admin.tpl');
	}
	
	function hookdisplayOrderDetail($params)
	{
		if (!$this->active)
			return;
		
		$order_id = $params['order']->id;
		
		$order = new Order($order_id);
		
		$ref = $this->GenerateMbRef($this->ifmb_entidade,$this->ifmb_subentidade,$order_id,$order->total_paid);
		
		//verifica se o método da encomenda é mesmo este ou não...
		if($order->payment != $this->displayName)
			return;
	

		$estado = "";
		
	
		global $cookie,$smarty;
		
		$smarty->assign(array(
			'entidade' 	=> $this->ifmb_entidade,
			'referencia' => $ref,
			'total_paid' 	=> $order->total_paid,
			'order_id' 	=> $order_id,
			'token' 	=> $this->context->controller->token,
			'estadoenvio'	=>	Tools::getValue("estadoenvio"),
			'estadolembrete'	=>	Tools::getValue("estadolembrete"),
			'this_path' 	=> $this->curPageURL().'modules/'.$this->name.'/'
		));
		

		return $this->display(__FILE__, '/history.tpl');
	}

	private function _postValidation()
	{
		if (Tools::isSubmit('btnSubmit'))
		{
			$erro ="";
			
			if (!Tools::getValue('entidade'))
				$erro = 'Tem de indicar uma <b><u>Entidade</u></b>';
			
			if (!Tools::getValue('subentidade')){
				if($erro!="")
					$erro .= " e ";
				else
					$erro = "Tem de indicar uma ";
					
				$erro .= '<b><u>Subentidade</u></b>';
			}
				
			if($erro!="")
				$this->_postErrors[] = $erro . '.';
		}
	}

	private function _postProcess()
	{
		if (Tools::isSubmit('btnSubmit'))
		{
			Configuration::updateValue('MULTIBANCO_ENTIDADE', Tools::getValue('entidade'));
			Configuration::updateValue('MULTIBANCO_SUBENTIDADE', Tools::getValue('subentidade'));
		}
		$this->_html .= '<div class="conf confirm"> Dados guardados com sucesso</div>';
	}

	private function _displayMultibanco()
	{
		$this->_html .= '
		<table style="margin-bottom: 20px;">
			<tr>
				<td>
					<img src="../modules/multibanco/logo_mb.png" style="margin-right:15px;width: 77px;">
				</td>
				<td>
					<b>Este m&oacute;dulo permite o pagamento seguro por Refer&ecirc;ncia Multibanco.</b>
					<br />
					<br />
					Se o cliente optar por pagar por Refer&ecirc;ncia Multibanco o estado da encomenda ser&aacute; colocado em "Aguardar pagamento por Multibanco"
					<br />
					Se o pagamento da Refer&ecirc;ncia for efectuado, e o callback activo, o estado da encomenda ser&aacute; alterado para "Confirmado pagamento por Multibanco"
					<br />
					<br />
					<b>NOTA: Este m&oacute;dulo s&oacute; funciona com o Sistema de Pagamentos por Refer&ecirc;ncia Multibanco da <u><a href="https://www.ifthensoftware.com/ProdutoX.aspx?ProdID=5">Ifthen</a></u>.</b>
				</td>
			</tr>
		</table>';
	}

	private function _displayForm()
	{
		$this->_html .=
		'<form action="'.Tools::htmlentitiesUTF8($_SERVER['REQUEST_URI']).'" method="post">
			<fieldset>
			<legend><img src="../modules/multibanco/logo.gif" />Dados do Contracto</legend>
				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">
					<tr><td width="130" style="height: 35px;">'.$this->l('Entidade').'</td><td><input type="text" name="entidade" value="'.htmlentities(Tools::getValue('entidade', $this->ifmb_entidade), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
					<tr><td width="130" style="height: 35px;">'.$this->l('Subentidade').'</td><td><input type="text" name="subentidade" value="'.htmlentities(Tools::getValue('subentidade', $this->ifmb_subentidade), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
					<tr><td colspan="2" align="center"><input class="button" name="btnSubmit" value="Guardar Dados" type="submit" /></td></tr>
				</table>
			</fieldset>
		</form>';
	}
	   
	public function hookDisplayHeader()
	{
	  $this->context->controller->addCSS($this->_path.'views/css/multibanco.css', 'all');
	}

	private function _displayCallbackForm()
	{
		$t = "ola
		ola";
		$this->_html .='<br /><br />
			<fieldset>
			<legend><img src="../modules/multibanco/logo.gif" />Dados Callback</legend>
				<table border="0" cellpadding="0" cellspacing="0" id="form">
					<tr>
						<td width="130" style="height: 35px;">
							URL Callback
						</td>
						<td>
							<b>'.$this->curPageURL().'modules/'.$this->name.'/callback/callback.php?chave=[CHAVE_ANTI_PHISHING]&entidade=[ENTIDADE]&referencia=[REFERENCIA]&valor=[VALOR]</b>
						</td>
					</tr>
					<tr>
						<td width="130" style="height: 35px;">
							Chave Anti-Phishing
						</td>
						<td>
							<b>'.Configuration::get('MULTIBANCO_CHAVE_ANTI_PHISHING').'</b>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<br /><br />Caso deseje activar o callback ter&aacute; de comunicar os seguintes dados &agrave; Ifthen:<br /><br />
							> Entidade e Sub-entidade<small><small><small><small><small><small><br /><br /></small></small></small></small></small></small>
							> 4 &uacute;ltimos digitos da chave de backoffice <i>(chave fornecida no acto da ades&atilde;o constituida por 16 d&iacute;gitos agrupados 4 a 4 -> Ex.: 0000-0000-0000-0000)</i><small><small><small><small><small><small><br /><br /></small></small></small></small></small></small>
							> Url de callback e chave anti-phishing acima indicados.<br /><br />
							Estes dados devem ser comunicados para o email <a href="mailto:ifthen@ifthensoftware.com?subject=Activar Callback">ifthen@ifthensoftware.com</a> com o assunto "Activar Callback".
						</td>
					</tr>
				</table>
			</fieldset>';
	}

	public function getContent()
	{
		$this->_html = '<h2>'.$this->displayName.'</h2>';
		
		if (Tools::isSubmit('btnSubmit'))
		{
			$this->_postValidation();
			if (!count($this->_postErrors))
				$this->_postProcess();
			else
				foreach ($this->_postErrors as $err)
					$this->_html .= '<div class="alert error">'.$err.'</div>';
		}
		else
			$this->_html .= '<br />';
		
		$this->_displayMultibanco();
		$this->_displayForm();
		
		if(Configuration::get('MULTIBANCO_ENTIDADE')!="" && Configuration::get('MULTIBANCO_SUBENTIDADE')!="")
			$this->_displayCallbackForm();

		return $this->_html;
	}

	public function hookPayment($params)
	{
		if (!$this->active)
			return;
		if (!$this->checkCurrency($params['cart']))
			return;


		$this->smarty->assign(array(
			'this_path' => $this->_path,
			'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/'
		));
		return $this->display(__FILE__, 'payment.tpl');
	}

	public function hookPaymentReturn($params)
	{
		if (!$this->active)
			return;

		$state = $params['objOrder']->getCurrentState();
		if ($state == Configuration::get('MULTIBANCO_OS_0') || $state == Configuration::get('PS_OS_OUTOFSTOCK'))
		{
			$entidade = $this->ifmb_entidade;
			$referencia = $this->GenerateMbRef($this->ifmb_entidade,$this->ifmb_subentidade,$params['objOrder']->id,$params['total_to_pay']);
			$total = Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false);
			
			$this->smarty->assign(array(
				'entidade' => $entidade,
				'referencia' => $referencia,
				'total_paid' => $total,
				'status' => 'ok',
				'id_order' => $params['objOrder']->id
			));
			if (isset($params['objOrder']->reference) && !empty($params['objOrder']->reference))
				$this->smarty->assign('reference', $params['objOrder']->reference);
			
			
			//envia email cliente com os dados de pagamento
			$cliente = new Customer($params['objOrder']->id_customer);
			
			
			
			$data = array(
				'{order_name}' => $params['objOrder']->reference,
				'{firstname}' => $cliente->firstname,
				'{lastname}' => $cliente->lastname,
				'{entidade}' => $entidade,
				'{referencia}' => $referencia,
				'{total_paid}' => $total
			);
			
			Mail::Send((int)$params['objOrder']->id_lang, 'multibanco', 'Dados para pagamento por Multibanco', $data, $cliente->email, $cliente->firstname.' '.$cliente->lastname,
					null, null, null, null, _PS_MAIL_DIR_, false, (int)$params['objOrder']->id_shop);
					
			//guardar dados em base de dados para controlo callback
			$this->setMultibancoOrderDb($params['objOrder']->id,$entidade,$referencia,$params['total_to_pay']);
		}
		else
			$this->smarty->assign('status', 'failed');
		return $this->display(__FILE__, 'payment_return.tpl');
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
	
	function curPageURL() {
		 $pageUrl = $this->getShopDomainSsl(true,true);
		 
		 return $pageUrl.__PS_BASE_URI__;
	}
	
	function getShopDomainSsl($http = false, $entities = false)
	{
		if (method_exists('Tools', 'getShopDomainSsl'))
			return Tools::getShopDomainSsl($http, $entities);
		else
		{
			if (!($domain = Configuration::get('PS_SHOP_DOMAIN_SSL')))
				$domain = self::getHttpHost();
			if ($entities)
				$domain = htmlspecialchars($domain, ENT_COMPAT, 'UTF-8');
			if ($http)
				$domain = (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://').$domain;
			return $domain;
		}
	}
	
	public function setMultibancoOrderDb($order,$entidade,$referencia,$valor)
	{
		$referencia = $this->centerTrim($referencia);
		
		$orderidcheck = $this->getMultibancoOrderDb($entidade,$referencia,$valor,$order,true);
		
		if($orderidcheck<1){
			Db::getInstance()->Execute
				('
					INSERT INTO `' . _DB_PREFIX_ . 'multibanco`
				( `order_id`, `entidade`, `referencia`, `valor`)
					VALUES
				('.$order.', '.$entidade.', \''.$referencia.'\', '.$valor.');
				');
		}else{
			$set = '`referencia` =\''.$referencia.'\', `valor`=\''.$valor.'\'';
			
			$this->updateMultibancoOrderDb($order,$set);
		}
	}
	
	
	
	public function getMultibancoOrderDb($entidade,$referencia,$valor,$order = 0, $count=false)
	{
		$select="order_id";
		
		$where = " `chave` is null";
		
		if($count)
			$select = "count(order_id) as order_id";
			
		if($order!=0)
			$where  = ' `order_id` =\''.$order.'\'';
		
		$pagamentos = Db::getInstance()->getRow('
		SELECT '.$select.'
		FROM `'._DB_PREFIX_.'multibanco`
		WHERE `entidade`=\''.$entidade.'\' and `referencia` =\''.$referencia.'\' and `valor`=\''.$valor.'\' and' . $where . ' 
		ORDER BY id desc
		');
		
		return $pagamentos['order_id'];
	}
	
	public function updateMultibancoOrderDb($orderId, $set = '`chave` = \'PAGO\'')
	{
		Db::getInstance()->Execute
			('
				UPDATE `' . _DB_PREFIX_ . 'multibanco`
				SET '.$set.'
				WHERE `order_id`='.$orderId);
	}
		
	function centerTrim($str){
		return preg_replace("/\s+/", "", $str);
	}
	
	function format_number($number) 
	{ 
		$verifySepDecimal = number_format(99,2);
	
		$valorTmp = $number;
	
		$sepDecimal = substr($verifySepDecimal, 2, 1);
	
		$hasSepDecimal = True;
	
		$i=(strlen($valorTmp)-1);
	
		for($i;$i!=0;$i-=1)
		{
			if(substr($valorTmp,$i,1)=="." || substr($valorTmp,$i,1)==","){
				$hasSepDecimal = True;
				$valorTmp = trim(substr($valorTmp,0,$i))."@".trim(substr($valorTmp,1+$i));
				break;
			}
		}
	
		if($hasSepDecimal!=True){
			$valorTmp=number_format($valorTmp,2);
		
			$i=(strlen($valorTmp)-1);
		
			for($i;$i!=1;$i--)
			{
				if(substr($valorTmp,$i,1)=="." || substr($valorTmp,$i,1)==","){
					$hasSepDecimal = True;
					$valorTmp = trim(substr($valorTmp,0,$i))."@".trim(substr($valorTmp,1+$i));
					break;
				}
			}
		}
	
		for($i=1;$i!=(strlen($valorTmp)-1);$i++)
		{
			if(substr($valorTmp,$i,1)=="." || substr($valorTmp,$i,1)=="," || substr($valorTmp,$i,1)==" "){
				$valorTmp = trim(substr($valorTmp,0,$i)).trim(substr($valorTmp,1+$i));
				break;
			}
		}
	
		if (strlen(strstr($valorTmp,'@'))>0){
			$valorTmp = trim(substr($valorTmp,0,strpos($valorTmp,'@'))).trim($sepDecimal).trim(substr($valorTmp,strpos($valorTmp,'@')+1));
		}
		
		return $valorTmp; 
	} 
	//FIM TRATAMENTO DEFINIÇÕES REGIONAIS


	//INICIO REF MULTIBANCO

	function GenerateMbRef($ent_id, $subent_id, $order_id, $order_value)
	{


				
		$order_id ="0000".$order_id;

		$order_value =  $this->format_number($order_value);

		//Apenas sao considerados os 4 caracteres mais a direita do order_id
		$order_id = substr($order_id, (strlen($order_id) - 4), strlen($order_id));


		if ($order_value < 1){
                 echo "Lamentamos mas é impossível gerar uma referência MB para valores inferiores a 1 Euro";
                 return;
           }
           if ($order_value >= 1000000){
                 echo "<b>AVISO:</b> Pagamento fraccionado por exceder o valor limite para pagamentos no sistema Multibanco<br>";
           }
           while ($order_value >= 1000000){
                 $this->GenerateMbRef($order_id++, 999999.99);
                 $order_value -= 999999.99;
           }
                              
           
        //cálculo dos check digits
		
		   
           $chk_str = sprintf('%05u%03u%04u%08u', $ent_id, $subent_id, $order_id, round($order_value*100));
		   
           $chk_array = array(3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62, 38, 89, 17, 73, 51);
           
		   $chk_val=0;
		   
           for ($i = 0; $i < 20; $i++)
           {
                 $chk_int = substr($chk_str, 19-$i, 1);
                 $chk_val += ($chk_int%10)*$chk_array[$i];
           }
           
           $chk_val %= 97;
           
           $chk_digits = sprintf('%02u', 98-$chk_val);

       return $subent_id." ".substr($chk_str, 8, 3)." ".substr($chk_str, 11, 1).$chk_digits;         

    }
	
	public function callback($chave, $entidade, $referencia, $valor)
	{
	global $link;
		$chaveReg = Configuration::get('MULTIBANCO_CHAVE_ANTI_PHISHING');
		$context = Context::getContext();
		$context->link = new Link();
		if($chave == $chaveReg){
			$orderId = $this->getMultibancoOrderDb($entidade, $referencia, $valor);
			
			if(!empty($orderId)){
				$new_history = new OrderHistory();
				$new_history->id_order = (int)$orderId;
				$new_history->changeIdOrderState((int)Configuration::get('MULTIBANCO_OS_1'), $orderId);
				$new_history->addWithemail(true, null,$context);
				
				$this->updateMultibancoOrderDb($orderId);
				
				echo 'OK...';
			}else{
				echo 'Provavelmente j&aacute; paga...';
			}
		}else{
			echo 'Chave inv&aacute;lida...';
		}
		
	}
}