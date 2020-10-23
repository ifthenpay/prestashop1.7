<?php

/**********************************************************
*                                                         *  
*  @author Ifthen Software <ifthen@ifthensoftware.com>    *
*  @copyright  2007-2011 Ifthen Software, Lda             *
*  @version  Release: $Revision: 3.1 $                    *
*                                                         *
***********************************************************/

if (!defined('_CAN_LOAD_FILES_'))
	exit;

class Multibanco extends PaymentModule
{
	private $_html = '';
	private $_postErrors = array();
	
	public  $ent_id;
    public  $subent_id;
    public  $chaveAntiPhishing;
	public  $id_country;
	
	public function __construct()
	{
		$this->name = 'multibanco';
		$this->tab = 'payments_gateways';
		$this->version = '3.2';
		$this->author = 'Ifthen Software';
		
        $this->idOrderState = Configuration::get('_PS_OS_MULTIBANCO_0');

		$config = Configuration::getMultiple(array('MULTIBANCO_ENT_ID','MULTIBANCO_SUBENT_ID','MULTIBANCO_CHAVE_ANTI_PHISHING'));
		
		if (isset($config['MULTIBANCO_ENT_ID']))
			$this->ent_id = $config['MULTIBANCO_ENT_ID'];
        if (isset($config['MULTIBANCO_SUBENT_ID']))
			$this->subent_id = $config['MULTIBANCO_SUBENT_ID'];
        if (isset($config['MULTIBANCO_CHAVE_ANTI_PHISHING']))
			$this->chaveAntiPhishing = $config['MULTIBANCO_CHAVE_ANTI_PHISHING'];

		parent::__construct();

		$this->page             = basename(__FILE__, '.php');
		$this->displayName      = 'Multibanco';
		$this->description      = 'Pagamentos por Multibanco - <b>Vers&atilde;o com <u><i>Real-Time</i></u></b>';
		$this->confirmUninstall = 'Tem a certeza de que quer desinstalar o Multibanco?';
		if (!isset($this->ent_id)){
            if (!isset($this->subent_id)){
				$this->warning = '&Eacute; necess&aacute;rio indicar a <b>Entidade</b> e Sub-entidade.';
			}else{
				$this->warning = '&Eacute; necess&aacute;rio indicar a Entidade.';
			}
		}else if (!isset($this->subent_id)){
            $this->warning = '&Eacute; necess&aacute;rio indicar Sub-entidade.';
		}
	}
	
	
	
	public function create_states()
	{

		$this->order_state = 	array(
									array( 'ffff00', '10110', 'Aguardar pagamento por Multibanco',  '' ,0),
									array( '00ffff', '01110', 'Confirmado pagamento por Multibanco',	 'conf_pag_mb'	,1)
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
			( `invoice`, `send_email`, `color`, `unremovable`, `logable`, `delivery`)
				VALUES
			(0, '.$value[4].',  \'#'.$value[0].'\', 1, 1, 0);
			');
			/** /CRIANDO OS STATUS NA TABELA order_state **/

			$this->figura 	= mysql_insert_id();

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
			$this->smartCopy((dirname(__file__) . "/img/$key.gif"),(dirname( dirname (dirname(__file__) ) ) .  "/img/os/$this->figura.gif"));
			/** /COPIANDO O ICONE ATUAL **/
			
			/** RENOMEAR O MAIL ORIGINAL **/
			//rename((dirname( dirname (dirname(__file__) ) ) .  "/mails/pt/order_conf.html"),(dirname( dirname (dirname(__file__) ) ) .  "/mails/pt/order_conf_original.html"));
			/** /RENOMEAR O MAIL ORIGINAL **/
			
			
			

    		/** GRAVA AS CONFIGURAÇÕES  **/
    		Configuration::updateValue("_PS_OS_MULTIBANCO_$key", 	$this->figura);
			
			
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
			$this->smartCopy((dirname(__file__) . "/mails/order_conf_mb.html"),(dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/order_conf_mb.html"));
			$this->smartCopy((dirname(__file__) . "/mails/order_conf_mb.txt"),(dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/order_conf_mb.txt"));
			$this->smartCopy((dirname(__file__) . "/mails/conf_pag_mb.html"),(dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/conf_pag_mb.html"));
			$this->smartCopy((dirname(__file__) . "/mails/conf_pag_mb.txt"),(dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/conf_pag_mb.txt"));
			/** /COPIANDO O MAIL ATUAL **/
		}

		return true;

	}
	
	public function delete_create_states()
	{
		Db::getInstance()->Execute
		('
			DELETE FROM `' . _DB_PREFIX_ . 'order_state_lang` WHERE `id_order_state`  = '.Configuration::get('_PS_OS_MULTIBANCO_0').' OR `id_order_state`  = '.Configuration::get('_PS_OS_MULTIBANCO_1').');
		');
			
		Db::getInstance()->Execute
		('
			DELETE  FROM `' . _DB_PREFIX_ . 'order_state` WHERE `id_order_state`  = '.Configuration::get('_PS_OS_MULTIBANCO_0').' OR `id_order_state`  = '.Configuration::get('_PS_OS_MULTIBANCO_1').');
		');
		
		unlink((dirname( dirname (dirname(__file__) ) ) .  "/img/os/".Configuration::get('_PS_OS_MULTIBANCO_0').".gif"));
		unlink((dirname( dirname (dirname(__file__) ) ) .  "/img/os/".Configuration::get('_PS_OS_MULTIBANCO_1').".gif"));
		
		
		/** OBTENDO UMA LISTA DOS IDIOMAS  **/
		$languages = Db::getInstance()->ExecuteS('
		SELECT `id_lang`, `iso_code`
		FROM `'._DB_PREFIX_.'lang`
		');
		/** /OBTENDO UMA LISTA DOS IDIOMAS  **/
		
		foreach ( $languages as $language_atual )
		{
			unlink((dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/order_conf_mb.html"));
			unlink((dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/order_conf_mb.txt"));
			unlink((dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/conf_pag_mb.html"));
			unlink((dirname( dirname (dirname(__file__) ) ) .  "/mails/".$language_atual['iso_code']."/conf_pag_mb.txt"));
		}
		
		
		//rename((dirname( dirname (dirname(__file__) ) ) .  "/mails/pt/order_conf_original.html"),(dirname( dirname (dirname(__file__) ) ) .  "/mails/pt/order_conf.html"));
		
		Configuration::deleteByName("_PS_OS_MULTIBANCO_0");
		Configuration::deleteByName("_PS_OS_MULTIBANCO_1");


		return true;

	}
	
	public function install()
    {
        if(!(Configuration::get('_PS_OS_MULTIBANCO_0') > 0))
            $this->create_states();
            
        if (!parent::install() OR !$this->registerHook('payment') OR !$this->registerHook('paymentReturn') OR !$this->registerHook('AdminOrder'))
			return false;
	
		Configuration::updateValue('MULTIBANCO_CHAVE_ANTI_PHISHING', md5(time()));
		
		
        return true;
	}
 
    public function uninstall()
	{
		if(Configuration::get('_PS_OS_MULTIBANCO_0') > 0)
            $this->delete_create_states();
			
		if (!Configuration::deleteByName('MULTIBANCO_ENT_ID') OR !Configuration::deleteByName('MULTIBANCO_SUBENT_ID') OR !Configuration::deleteByName('MULTIBANCO_CHAVE_ANTI_PHISHING') OR !parent::uninstall())
			return false;
			
        return true;
	}
	
	function hookAdminOrder($params)
	{
		$order_id    = $params['id_order'];
		
		$order = new Order($order_id);
		
		$ref = $this->GenerateMbRef(Configuration::get('MULTIBANCO_ENT_ID'),Configuration::get('MULTIBANCO_SUBENT_ID'),$order_id,$order->total_paid);
		
		global $cookie,$smarty;

		$smarty->assign(array(
			'entidade' 	=> Configuration::get('MULTIBANCO_ENT_ID'),
			'referencia' => $ref,
			'valor' 	=> $order->total_paid,
			'this_path' 	=> $this->curPageURL().'modules/'.$this->name.'/'
		));

		return $this->display(__FILE__, 'core/admin_dados_mb.tpl');
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

    private function _displayForm()
	{
        $output = '<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<fieldset>
				<legend>
					<img src="../modules/multibanco/img/config.png" />Configura&ccedil;&atilde;o
				</legend>
				
				<table class="table" border="0" width="900" cellpadding="0" cellspacing="2" id="form">
					<tr>
						<td width="150" style="vertical-align: top;">
							<b>Entidade:&nbsp;&nbsp;</b>
						</td>
						<td width="250" style="vertical-align: top;">
							<input type="text" name="ent_id" value="'.htmlentities(Tools::getValue('ent_id', $this->ent_id), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" MAXLENGTH=5/>
						</td>
						<td>
							&nbsp;&nbsp; - Sempre com 5 d&iacute;gitos (10559, 11202, 11473, 11604)
						</td>
					</tr>
					<tr>
						<td width="150" style="vertical-align: top;">
							<b>Sub-entidade:&nbsp;&nbsp;</b>
						</td>
						<td width="250" style="vertical-align: top;">
							<input type="text" name="subent_id" value="'.htmlentities(Tools::getValue('subent_id', $this->subent_id), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" MAXLENGTH=3/>
						</td>
						<td>
							&nbsp;&nbsp; - Fornecido pela IFTHEN e sempre com 3 d&iacute;gitos (Ex: 999).
						</td>
					</tr>
					<tr>
						<td>
							<a href="https://www.ifthensoftware.com/ProdutoX.aspx?ProdID=5"  target="_blank">
								<img src="../modules/multibanco/img/info.png">Informa&ccedil;&atilde;o sobre o servi&ccedil;o
							</a>
						</td>
						<td>
							<a href="https://www.ifthensoftware.com/downloads/ifmb/IFMultiBanco.zip"  target="_blank">
								<img src="../modules/multibanco/img/check.png" >Verificar Refer&ecirc;ncias
							</a>
						</td>
						<td align="left">
							<a href="https://www.ifthensoftware.com/downloads/ifmb/contratomb.pdf"  target="_blank">
								<img src="../modules/multibanco/img/pdf.png">Contrato         
							</a>
						</td>
					</tr>
					<tr>
						<td align="center" colspan="3">
							<input class="button" name="btnSubmit" value= "Guardar Configura&ccedil;&otilde;es" type="submit" />
						</td>
					</tr>
        </table>
	    </fieldset>
        </form> <br />';
		
        return $output;
    }
	
	public function _displayFormCallBack(){
		$output = '
			<fieldset>
				<legend>
					<img src="../modules/multibanco/img/info.png" />Informa&ccedil;&otilde;es Callback
				</legend>
				
				O CallBack permite que, sempre que haja um pagamento por multibanco, os servidores da Ifthen comuniquem &agrave; sua loja online, de forma autom&aacute;tica, dando baixa da respetiva encomenda.
				<br />
				<br />
				Caso deseje ativar esta funcionalidade, d&ecirc; a conhecer &agrave; Ifthen os seguintes dados:
				<br />
				<br />
				<table class="table" border="0" width="900" cellpadding="0" cellspacing="2" id="form">
					<tr>
						<td>
							<b>URL:</b>
							<br />
							<br />
							'.$this->curPageURL().'modules/'.$this->name.'/callback/callback.php?chave=[CHAVE_ANTI_PHISHING]&entidade=[ENTIDADE]&referencia=[REFERENCIA]&valor=[VALOR]
							<br />
							<br />
						</td>
					</tr>
					<tr>
						<td>
							<b>Chave Anti-Phishing:</b>
							<br />
							<br />
							'.Configuration::get('MULTIBANCO_CHAVE_ANTI_PHISHING').'
							<br />
							<br />
						</td>
					</tr>
				</table>
				<br />
				<br />
				Estes dados devem ser enviados com o assunto <b>"Ativar CallBack"</b> para o seguinte endere&ccedil;o de e-mail:
				<br />
				<b><u><a href="mailto:ifthen@ifthensoftware.com?subject=Ativar CallBack" target="_blank">ifthen@ifthensoftware.com</a></u></b>
			</fieldset>';
		
		return $output;
	}
	
	private function _postValidation()
	{
       	if (isset($_POST['btnSubmit']))
       	{
            if (empty($_POST['ent_id']))
				$this->_postErrors[] = $this->l('Entidade is required.');
            if (empty($_POST['subent_id']))
				$this->_postErrors[] = $this->l('Sub-entidade is required.');
   		}
    }

    public function getContent()
	{
		$callback ='';
		
		$output = '<img src="../modules/multibanco/img/mb.png"  style="float:left; margin-right:15px;">
		<br /><br /><br /><br /><br /> <br />
        - Este m&oacute;dulo permite aceitar pagamentos por Multibanco</b><br />
        - Se o cliente escolher este m&eacute;todo de pagamento o estado da encomenda ir&aacute; altera para <b>\'Aguardar pagamento por Multibanco\'</b><br />
        - Ap&oacute;s pagamento o estado da encomenda ser&aacute; alterado automaticamente para <b>\'Pagamento Realizado por Multibanco\'</b>. Ter&aacute; depois de dar seguimento &agrave; mesma.<br /><br />
		<b>NOTA: Este m&oacute;dulo de pagamento s&oacute; funciona com o sistema da <a href="https://www.ifthensoftware.com/ProdutoX.aspx?ProdID=5" target="_blank"><u>Ifthen Software (servi&ccedil;o IFMB - Pagamentos por refer&ecirc;nia Multibanco)</u></a>.</b><br /> <br />';
  
        if (!empty($_POST))
		{
			$this->_postValidation();
			
			if (sizeof($this->_postErrors)){
				foreach ($this->_postErrors AS $err)
					$this->_html .= '<div class="alert error"><img src="../modules/multibanco/img/error.png" alt="error" />'. $err .'</div>';
					
				$this->_html .= '<br /><br />';
			}
			
			$output .= $this->_html;
		}
		else{
			$this->_html .= '<br />';
			$output .= $this->_html;
		}
			
        if (Tools::isSubmit('btnSubmit') AND ($ent_id = Tools::getValue('ent_id'))AND ($subent_id = Tools::getValue('subent_id')))
		{
           Configuration::updateValue('MULTIBANCO_ENT_ID', $ent_id);
           Configuration::updateValue('MULTIBANCO_SUBENT_ID', $subent_id);

		   $output .= '
		   <div class="conf confirm">
		   <img src="../modules/multibanco/img/check.png" alt="ok" />
			Configura&ccedil;&otilde;es Guardadas</div><br /> <br />';
			
			
        }
		
		if (Configuration::get('MULTIBANCO_ENT_ID')!="" and Configuration::get('MULTIBANCO_SUBENT_ID')!="")
				$callback = $this->_displayFormCallBack();
				
 		return $output.$this->_displayForm().$callback;
	}
	
	function curPageURL() {
		 $pageUrl = Tools::getProtocol().Tools::getServerName();
		 
		 return $pageUrl.__PS_BASE_URI__;
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

		$chk_val=0;
				
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
           
           for ($i = 0; $i < 20; $i++)
           {
                 $chk_int = substr($chk_str, 19-$i, 1);
                 $chk_val += ($chk_int%10)*$chk_array[$i];
           }
           
           $chk_val %= 97;
           
           $chk_digits = sprintf('%02u', 98-$chk_val);

       return $subent_id." ".substr($chk_str, 8, 3)." ".substr($chk_str, 11, 1).$chk_digits;         

    }
	
	public function hookPayment($params)
	{
		if (!$this->active)
			return ;

		global $smarty;

		$smarty->assign(array(
			'this_path' => $this->curPageURL().'modules/'.$this->name.'/'
		));
		return $this->display(__FILE__, 'core/mb.tpl');
	}
	
	public function execPayment($cart)
	{
		 if (!$this->active)
			return ;
		//if (!$this->_checkCurrency($cart))
			//Tools::redirectLink(__PS_BASE_URI__.'order.php');

		global $cookie,$smarty;

		$smarty->assign(array(
			'nbProducts' 	=> $cart->nbProducts(),
			'cust_currency' => $cart->id_currency,
			'currencies' 	=> $this->getCurrency((int)$cart->id_currency),
			'total' 		=> $cart->getOrderTotal(true, Cart::BOTH),
			'isoCode' 		=> Language::getIsoById((int)($cookie->id_lang)),
			'ent_id'       	=> $this->ent_id,
            'subent_id'     => $this->subent_id,
			'this_path' 	=> $this->curPageURL().'modules/'.$this->name.'/'
		));

		return $this->display(__FILE__, 'core/executar_mb.tpl');
	}
	
	public function hookPaymentReturn($params)
	{
		if (!$this->active)
			return ;

		global $smarty;
		$state = $params['objOrder']->getCurrentState();
		
		$total_to_pay = Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false, false);

		
		$ref = $this->GenerateMbRef(Configuration::get('MULTIBANCO_ENT_ID'),Configuration::get('MULTIBANCO_SUBENT_ID'),$params['objOrder']->id,$params['total_to_pay']);
		
		//if ($state == _PS_OS_BANKWIRE_ OR $state == _PS_OS_OUTOFSTOCK_)
			$smarty->assign(array(
				'total_to_pay' 	=> Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false, false),
				'entidade' 		=> Configuration::get('MULTIBANCO_ENT_ID'),
				'referencia'	=> $ref,
				'valor' 		=> $params['total_to_pay'],
				'status' 		=> 'ok',
				'this_path'		=> $this->curPageURL().'modules/'.$this->name.'/',
				'id_order' 		=> $params['objOrder']->id
			));
		//else
			//$smarty->assign('status', 'failed');
		return $this->display(__FILE__, 'core/dados_mb.tpl');
	}
	
	/**
	* Override Function ValidateOrder
	* Validate an order in database
	*
	* @param integer $id_cart Value
	* @param integer $id_order_state Value
	* @param float $amountPaid Amount really paid by customer (in the default currency)
	* @param string $paymentMethod Payment method (eg. 'Credit card')
	* @param string $message Message to attach to order
	*/
	public function validateOrder($id_cart, $id_order_state, $amountPaid, $paymentMethod = 'Unknown', $message = NULL, $extraVars = array(), $currency_special = NULL, $dont_touch_amount = false, $secure_key = false)
	{
			global $cart;
			
	

		$cart = new Cart((int)($id_cart));
		
		// Does order already exists ?
		if (!$this->active)
			die(Tools::displayError());

		if (Validate::isLoadedObject($cart) AND $cart->OrderExists() == false)
		{
	
			if ($secure_key !== false AND $secure_key != $cart->secure_key)
				die(Tools::displayError());

			// Copying data from cart
			$order = new Order();
			$order->id_carrier = (int)($cart->id_carrier);
			$order->id_customer = (int)($cart->id_customer);
			$order->id_address_invoice = (int)($cart->id_address_invoice);
			$order->id_address_delivery = (int)($cart->id_address_delivery);
			$vat_address = new Address((int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
			$order->id_currency = ($currency_special ? (int)($currency_special) : (int)($cart->id_currency));
			$order->id_lang = (int)($cart->id_lang);
			$order->id_cart = (int)($cart->id);
			$customer = new Customer((int)($order->id_customer));
			$order->secure_key = ($secure_key ? pSQL($secure_key) : pSQL($customer->secure_key));
			$order->payment = $paymentMethod;
			if (isset($this->name))
				$order->module = $this->name;
			$order->recyclable = $cart->recyclable;
			$order->gift = (int)($cart->gift);
			$order->gift_message = $cart->gift_message;
			$currency = new Currency($order->id_currency);
			$order->conversion_rate = $currency->conversion_rate;
			$amountPaid = !$dont_touch_amount ? Tools::ps_round((float)($amountPaid), 2) : $amountPaid;
			$order->total_paid_real = $amountPaid;
			$order->total_products = (float)($cart->getOrderTotal(false, Cart::ONLY_PRODUCTS));
			$order->total_products_wt = (float)($cart->getOrderTotal(true, Cart::ONLY_PRODUCTS));
			$order->total_discounts = (float)(abs($cart->getOrderTotal(true, Cart::ONLY_DISCOUNTS)));
			$order->total_shipping = (float)($cart->getOrderShippingCost());
			$order->carrier_tax_rate = (float)Tax::getCarrierTaxRate($cart->id_carrier, (int)$cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
			$order->total_wrapping = (float)(abs($cart->getOrderTotal(true, Cart::ONLY_WRAPPING)));
			$order->total_paid = (float)(Tools::ps_round((float)($cart->getOrderTotal(true, Cart::BOTH)), 2));
			$order->invoice_date = '0000-00-00 00:00:00';
			$order->delivery_date = '0000-00-00 00:00:00';
			// Amount paid by customer is not the right one -> Status = payment error
			// We don't use the following condition to avoid the float precision issues : http://www.php.net/manual/en/language.types.float.php
			// if ($order->total_paid != $order->total_paid_real)
			// We use number_format in order to compare two string
			if (number_format($order->total_paid, 2) != number_format($order->total_paid_real, 2))
				$id_order_state = Configuration::get('PS_OS_ERROR');
			// Creating order
			if ($cart->OrderExists() == false)
				$result = $order->add();
			else
			{
				$errorMessage = Tools::displayError('An order has already been placed using this cart.');
				Logger::addLog($errorMessage, 4, '0000001', 'Cart', intval($order->id_cart));
				die($errorMessage);
			}

			// Next !
			if ($result AND isset($order->id))
			{
				if (!$secure_key)
					$message .= $this->l('Warning : the secure key is empty, check your payment account before validation');
				// Optional message to attach to this order
				if (isset($message) AND !empty($message))
				{
					
					$msg = new Message();
					$message = strip_tags($message, '<br>');
					if (Validate::isCleanHtml($message))
					{
						$msg->message = $message;
						$msg->id_order = intval($order->id);
						$msg->private = 1;
						$msg->add();
					}
				}

				// Insert products from cart into order_detail table
				$products = $cart->getProducts();
				$productsList = '';
				$db = Db::getInstance();
				$query = 'INSERT INTO `'._DB_PREFIX_.'order_detail`
					(`id_order`, `product_id`, `product_attribute_id`, `product_name`, `product_quantity`, `product_quantity_in_stock`, `product_price`, `reduction_percent`, `reduction_amount`, `group_reduction`, `product_quantity_discount`, `product_ean13`, `product_upc`, `product_reference`, `product_supplier_reference`, `product_weight`, `tax_name`, `tax_rate`, `ecotax`, `ecotax_tax_rate`, `discount_quantity_applied`, `download_deadline`, `download_hash`)
				VALUES ';

				$customizedDatas = Product::getAllCustomizedDatas((int)($order->id_cart));
				Product::addCustomizationPrice($products, $customizedDatas);
				$outOfStock = false;

				$storeAllTaxes = array();

				foreach ($products AS $key => $product)
				{
					$productQuantity = (int)(Product::getQuantity((int)($product['id_product']), ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL)));
					$quantityInStock = ($productQuantity - (int)($product['cart_quantity']) < 0) ? $productQuantity : (int)($product['cart_quantity']);
					if ($id_order_state != Configuration::get('PS_OS_CANCELED') AND $id_order_state != Configuration::get('PS_OS_ERROR'))
					{
						if (Product::updateQuantity($product, (int)$order->id))
							$product['stock_quantity'] -= $product['cart_quantity'];
						if ($product['stock_quantity'] < 0 && Configuration::get('PS_STOCK_MANAGEMENT'))
							$outOfStock = true;

						Product::updateDefaultAttribute($product['id_product']);
					}
					$price = Product::getPriceStatic((int)($product['id_product']), false, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), 6, NULL, false, true, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
					$price_wt = Product::getPriceStatic((int)($product['id_product']), true, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), 2, NULL, false, true, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));

					/* Store tax info */
					$id_country = (int)Country::getDefaultCountryId();
					$id_state = 0;
					$id_county = 0;
					$rate = 0;
					$id_address = $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
					$address_infos = Address::getCountryAndState($id_address);
					if ($address_infos['id_country'])
					{
						$id_country = (int)($address_infos['id_country']);
						$id_state = (int)$address_infos['id_state'];
						$id_county = (int)County::getIdCountyByZipCode($address_infos['id_state'], $address_infos['postcode']);
					}
					$allTaxes = TaxRulesGroup::getTaxes((int)Product::getIdTaxRulesGroupByIdProduct((int)$product['id_product']), $id_country, $id_state, $id_county);
					$nTax = 0;
					foreach ($allTaxes AS $res)
					{
						if (!isset($storeAllTaxes[$res->id]))
						{
							$storeAllTaxes[$res->id] = array();
							$storeAllTaxes[$res->id]['amount'] = 0;
						}
						$storeAllTaxes[$res->id]['name'] = $res->name[(int)$order->id_lang];
						$storeAllTaxes[$res->id]['rate'] = $res->rate;

						if (!$nTax++)
							$storeAllTaxes[$res->id]['amount'] += ($price * ($res->rate * 0.01)) * $product['cart_quantity'];
						else
						{
							$priceTmp = $price_wt / (1 + ($res->rate * 0.01));
							$storeAllTaxes[$res->id]['amount'] += ($price_wt - $priceTmp) * $product['cart_quantity'];
						}
					}
					/* End */

					// Add some informations for virtual products
					$deadline = '0000-00-00 00:00:00';
					$download_hash = NULL;
					if ($id_product_download = ProductDownload::getIdFromIdProduct((int)($product['id_product'])))
					{
						$productDownload = new ProductDownload((int)($id_product_download));
						$deadline = $productDownload->getDeadLine();
						$download_hash = $productDownload->getHash();
					}

					// Exclude VAT
					if (Tax::excludeTaxeOption())
					{
						$product['tax'] = 0;
						$product['rate'] = 0;
						$tax_rate = 0;
					}
					else
						$tax_rate = Tax::getProductTaxRate((int)($product['id_product']), $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});

                    $ecotaxTaxRate = 0;
                    if (!empty($product['ecotax']))
                        $ecotaxTaxRate = Tax::getProductEcotaxRate($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});

                    $product_price = (float)Product::getPriceStatic((int)($product['id_product']), false, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), (Product::getTaxCalculationMethod((int)($order->id_customer)) == PS_TAX_EXC ? 2 : 6), NULL, false, false, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}), $specificPrice, false, false);

					$group_reduction = (float)GroupReduction::getValueForProduct((int)$product['id_product'], $customer->id_default_group) * 100;
					if (!$group_reduction)
						$group_reduction = Group::getReduction((int)$order->id_customer);

					$quantityDiscount = SpecificPrice::getQuantityDiscount((int)$product['id_product'], Shop::getCurrentShop(), (int)$cart->id_currency, (int)$vat_address->id_country, (int)$customer->id_default_group, (int)$product['cart_quantity']);
					$unitPrice = Product::getPriceStatic((int)$product['id_product'], true, ($product['id_product_attribute'] ? intval($product['id_product_attribute']) : NULL), 2, NULL, false, true, 1, false, (int)$order->id_customer, NULL, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
					$quantityDiscountValue = $quantityDiscount ? ((Product::getTaxCalculationMethod((int)$order->id_customer) == PS_TAX_EXC ? Tools::ps_round($unitPrice, 2) : $unitPrice) - $quantityDiscount['price'] * (1 + $tax_rate / 100)) : 0.00;
					$query .= '('.(int)($order->id).',
						'.(int)($product['id_product']).',
						'.(isset($product['id_product_attribute']) ? (int)($product['id_product_attribute']) : 'NULL').',
						\''.pSQL($product['name'].((isset($product['attributes']) AND $product['attributes'] != NULL) ? ' - '.$product['attributes'] : '')).'\',
						'.(int)($product['cart_quantity']).',
						'.$quantityInStock.',
						'.$product_price.',
						'.(float)(($specificPrice AND $specificPrice['reduction_type'] == 'percentage') ? $specificPrice['reduction'] * 100 : 0.00).',
						'.(float)(($specificPrice AND $specificPrice['reduction_type'] == 'amount') ? (!$specificPrice['id_currency'] ? Tools::convertPrice($specificPrice['reduction'], $order->id_currency) : $specificPrice['reduction']) : 0.00).',
						'.$group_reduction.',
						'.$quantityDiscountValue.',
						'.(empty($product['ean13']) ? 'NULL' : '\''.pSQL($product['ean13']).'\'').',
						'.(empty($product['upc']) ? 'NULL' : '\''.pSQL($product['upc']).'\'').',
						'.(empty($product['reference']) ? 'NULL' : '\''.pSQL($product['reference']).'\'').',
						'.(empty($product['supplier_reference']) ? 'NULL' : '\''.pSQL($product['supplier_reference']).'\'').',
						'.(float)($product['id_product_attribute'] ? $product['weight_attribute'] : $product['weight']).',
						\''.(empty($tax_rate) ? '' : pSQL($product['tax'])).'\',
						'.(float)($tax_rate).',
						'.(float)Tools::convertPrice(floatval($product['ecotax']), intval($order->id_currency)).',
						'.(float)$ecotaxTaxRate.',
						'.(($specificPrice AND $specificPrice['from_quantity'] > 1) ? 1 : 0).',
						\''.pSQL($deadline).'\',
						\''.pSQL($download_hash).'\'),';

					$customizationQuantity = 0;
					if (isset($customizedDatas[$product['id_product']][$product['id_product_attribute']]))
					{
						$customizationText = '';
						foreach ($customizedDatas[$product['id_product']][$product['id_product_attribute']] AS $customization)
						{
							if (isset($customization['datas'][_CUSTOMIZE_TEXTFIELD_]))
								foreach ($customization['datas'][_CUSTOMIZE_TEXTFIELD_] AS $text)
									$customizationText .= $text['name'].':'.' '.$text['value'].'<br />';

							if (isset($customization['datas'][_CUSTOMIZE_FILE_]))
								$customizationText .= sizeof($customization['datas'][_CUSTOMIZE_FILE_]) .' '. Tools::displayError('image(s)').'<br />';

							$customizationText .= '---<br />';
						}

						$customizationText = rtrim($customizationText, '---<br />');

						$customizationQuantity = (int)($product['customizationQuantityTotal']);
						$productsList .=
						'<tr style="background-color: '.($key % 2 ? '#DDE2E6' : '#EBECEE').';">
							<td style="padding: 0.6em 0.4em;">'.$product['reference'].'</td>
							<td style="padding: 0.6em 0.4em;"><strong>'.$product['name'].(isset($product['attributes']) ? ' - '.$product['attributes'] : '').' - '.$this->l('Customized').(!empty($customizationText) ? ' - '.$customizationText : '').'</strong></td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice(Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt, $currency, false).'</td>
							<td style="padding: 0.6em 0.4em; text-align: center;">'.$customizationQuantity.'</td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice($customizationQuantity * (Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt), $currency, false).'</td>
						</tr>';
					}

					if (!$customizationQuantity OR (int)$product['cart_quantity'] > $customizationQuantity)
						$productsList .=
						'<tr style="background-color: '.($key % 2 ? '#DDE2E6' : '#EBECEE').';">
							<td style="padding: 0.6em 0.4em;">'.$product['reference'].'</td>
							<td style="padding: 0.6em 0.4em;"><strong>'.$product['name'].(isset($product['attributes']) ? ' - '.$product['attributes'] : '').'</strong></td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice(Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt, $currency, false).'</td>
							<td style="padding: 0.6em 0.4em; text-align: center;">'.((int)($product['cart_quantity']) - $customizationQuantity).'</td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice(((int)($product['cart_quantity']) - $customizationQuantity) * (Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt), $currency, false).'</td>
						</tr>';
				} // end foreach ($products)
				
				$query = rtrim($query, ',');
				$result = $db->Execute($query);

				/* Add carrier tax */
				$shippingCostTaxExcl = $cart->getOrderShippingCost((int)$order->id_carrier, false);
				$allTaxes = TaxRulesGroup::getTaxes((int)Carrier::getIdTaxRulesGroupByIdCarrier((int)$order->id_carrier), $id_country, $id_state, $id_county);
				$this->id_country = $id_country;
				$nTax = 0;

				foreach ($allTaxes AS $res)
				{
					if (!isset($res->id))
						continue;

					if (!isset($storeAllTaxes[$res->id]))
						$storeAllTaxes[$res->id] = array();
					if (!isset($storeAllTaxes[$res->id]['amount']))
						$storeAllTaxes[$res->id]['amount'] = 0;
					$storeAllTaxes[$res->id]['name'] = $res->name[(int)$order->id_lang];
					$storeAllTaxes[$res->id]['rate'] = $res->rate;

					if (!$nTax++)
						$storeAllTaxes[$res->id]['amount'] += ($shippingCostTaxExcl * (1 + ($res->rate * 0.01))) - $shippingCostTaxExcl;
					else
					{
						$priceTmp = $order->total_shipping / (1 + ($res->rate * 0.01));
						$storeAllTaxes[$res->id]['amount'] += $order->total_shipping - $priceTmp;
					}
				}
				
				/* Store taxes */
				foreach ($storeAllTaxes AS $t)
					Db::getInstance()->Execute('
					INSERT INTO '._DB_PREFIX_.'order_tax (id_order, tax_name, tax_rate, amount)
					VALUES ('.(int)$order->id.', \''.pSQL($t['name']).'\', '.(float)($t['rate']).', '.(float)$t['amount'].')');

				// Insert discounts from cart into order_discount table
				$discounts = $cart->getDiscounts();
				$discountsList = '';
				$total_discount_value = 0;
				$shrunk = false;
					
				foreach ($discounts AS $discount)
				{
					$objDiscount = new Discount((int)$discount['id_discount']);
					$value = $objDiscount->getValue(sizeof($discounts), $cart->getOrderTotal(true, Cart::ONLY_PRODUCTS), $order->total_shipping, $cart->id);
					if ($objDiscount->id_discount_type == 2 AND in_array($objDiscount->behavior_not_exhausted, array(1,2)))
						$shrunk = true;

					if ($shrunk AND ($total_discount_value + $value) > ($order->total_products_wt + $order->total_shipping + $order->total_wrapping))
					{
						$amount_to_add = ($order->total_products_wt + $order->total_shipping + $order->total_wrapping) - $total_discount_value;
						if ($objDiscount->id_discount_type == 2 AND $objDiscount->behavior_not_exhausted == 2)
						{
							$voucher = new Discount();
							foreach ($objDiscount AS $key => $discountValue)
								$voucher->$key = $discountValue;
							$voucher->name = 'VSRK'.(int)$order->id_customer.'O'.(int)$order->id;
							$voucher->value = (float)$value - $amount_to_add;
							$voucher->add();
							$params['{voucher_amount}'] = Tools::displayPrice($voucher->value, $currency, false);
							$params['{voucher_num}'] = $voucher->name;
							$params['{firstname}'] = $customer->firstname;
							$params['{lastname}'] = $customer->lastname;
							$params['{id_order}'] = $order->id;
							@Mail::Send((int)$order->id_lang, 'voucher', Mail::l('New voucher regarding your order #', (int)$order->id_lang).$order->id, $params, $customer->email, $customer->firstname.' '.$customer->lastname);
						}
					}
					else
						$amount_to_add = $value;
					$order->addDiscount($objDiscount->id, $objDiscount->name, $amount_to_add);
					$total_discount_value += $amount_to_add;
					if ($id_order_state != Configuration::get('PS_OS_ERROR') AND $id_order_state != Configuration::get('PS_OS_CANCELED'))
						$objDiscount->quantity = $objDiscount->quantity - 1;
					$objDiscount->update();

					$discountsList .=
					'<tr style="background-color:#EBECEE;">
							<td colspan="4" style="padding: 0.6em 0.4em; text-align: right;">'.$this->l('Voucher code:').' '.$objDiscount->name.'</td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.($value != 0.00 ? '-' : '').Tools::displayPrice($value, $currency, false).'</td>
					</tr>';
				}

				// Specify order id for message
				$oldMessage = Message::getMessageByCartId((int)($cart->id));
				if ($oldMessage)
				{
					$message = new Message((int)$oldMessage['id_message']);
					$message->id_order = (int)$order->id;
					$message->update();
				}

					
				// Hook new order
				$orderStatus = new OrderState((int)$id_order_state, (int)$order->id_lang);
				if (Validate::isLoadedObject($orderStatus))
				{
					Hook::newOrder($cart, $order, $customer, $currency, $orderStatus);
					foreach ($cart->getProducts() AS $product)
						if ($orderStatus->logable)
							ProductSale::addProductSale((int)$product['id_product'], (int)$product['cart_quantity']);
				}

				if (isset($outOfStock) && $outOfStock && Configuration::get('PS_STOCK_MANAGEMENT'))
				{
					$history = new OrderHistory();
					$history->id_order = (int)$order->id;
					$history->changeIdOrderState(Configuration::get('PS_OS_OUTOFSTOCK'), (int)$order->id);
					$history->addWithemail();
				}

		
				// Set order state in order history ONLY even if the "out of stock" status has not been yet reached
				// So you migth have two order states
				$new_history = new OrderHistory();
				$new_history->id_order = (int)$order->id;
				$new_history->changeIdOrderState((int)$id_order_state, (int)$order->id);
				$new_history->addWithemail(true, $extraVars);

				// Order is reloaded because the status just changed
				$order = new Order($order->id);


				// Send an e-mail to customer
				if ($id_order_state != Configuration::get('PS_OS_ERROR') AND $id_order_state != Configuration::get('PS_OS_CANCELED') AND $customer->id)
				{
					$invoice = new Address((int)($order->id_address_invoice));
					$delivery = new Address((int)($order->id_address_delivery));
					$carrier = new Carrier((int)($order->id_carrier), $order->id_lang);
					$delivery_state = $delivery->id_state ? new State((int)($delivery->id_state)) : false;
					$invoice_state = $invoice->id_state ? new State((int)($invoice->id_state)) : false;

			
				$ref = $this->GenerateMbRef(Configuration::get('MULTIBANCO_ENT_ID'),Configuration::get('MULTIBANCO_SUBENT_ID'),(int)($order->id),$order->total_paid);

				
					$data = array(
					'{firstname}' => $customer->firstname,
					'{lastname}' => $customer->lastname,
					'{email}' => $customer->email,
					'{delivery_block_txt}' => $this->_getFormatedAddress($delivery, "\n"),
					'{invoice_block_txt}' => $this->_getFormatedAddress($invoice, "\n"),
					'{delivery_block_html}' => $this->_getFormatedAddress($delivery, "<br />",
						array(
							'firstname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>',
							'lastname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>')),
					'{invoice_block_html}' => $this->_getFormatedAddress($invoice, "<br />",
						array(
							'firstname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>',
							'lastname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>')),
					'{delivery_company}' => $delivery->company,
					'{delivery_firstname}' => $delivery->firstname,
					'{delivery_lastname}' => $delivery->lastname,
					'{delivery_address1}' => $delivery->address1,
					'{delivery_address2}' => $delivery->address2,
					'{delivery_city}' => $delivery->city,
					'{delivery_postal_code}' => $delivery->postcode,
					'{delivery_country}' => $delivery->country,
					'{delivery_state}' => $delivery->id_state ? $delivery_state->name : '',
					'{delivery_phone}' => ($delivery->phone) ? $delivery->phone : $delivery->phone_mobile,
					'{delivery_other}' => $delivery->other,
					'{invoice_company}' => $invoice->company,
					'{invoice_vat_number}' => $invoice->vat_number,
					'{invoice_firstname}' => $invoice->firstname,
					'{invoice_lastname}' => $invoice->lastname,
					'{invoice_address2}' => $invoice->address2,
					'{invoice_address1}' => $invoice->address1,
					'{invoice_city}' => $invoice->city,
					'{invoice_postal_code}' => $invoice->postcode,
					'{invoice_country}' => $invoice->country,
					'{invoice_state}' => $invoice->id_state ? $invoice_state->name : '',
					'{invoice_phone}' => ($invoice->phone) ? $invoice->phone : $invoice->phone_mobile,
					'{invoice_other}' => $invoice->other,
					'{order_name}' => sprintf("#%06d", (int)($order->id)),
					'{date}' => Tools::displayDate(date('Y-m-d H:i:s'), (int)($order->id_lang), 1),
					'{carrier}' => $carrier->name,
					'{payment}' => Tools::substr($order->payment, 0, 32),
					'{products}' => $productsList,
					'{discounts}' => $discountsList,
					'{total_paid}' => Tools::displayPrice($order->total_paid, $currency, false),
					'{total_products}' => Tools::displayPrice($order->total_paid - $order->total_shipping - $order->total_wrapping + $order->total_discounts, $currency, false),
					'{total_discounts}' => Tools::displayPrice($order->total_discounts, $currency, false),
					'{total_shipping}' => Tools::displayPrice($order->total_shipping, $currency, false),
					'{total_wrapping}' => Tools::displayPrice($order->total_wrapping, $currency, false),
					'{entidade}' => Configuration::get('MULTIBANCO_ENT_ID'),
					'{referencia}' => $ref,
					'{this_path}' 		=> $this->curPageURL().'modules/'.$this->name.'/');
					
					
		
					$this->setMultibancoOrderDb((int)($order->id),Configuration::get('MULTIBANCO_ENT_ID'),trim($ref),$order->total_paid);
					
					if (is_array($extraVars))
						$data = array_merge($data, $extraVars);

					// Join PDF invoice
					if ((int)(Configuration::get('PS_INVOICE')) AND Validate::isLoadedObject($orderStatus) AND $orderStatus->invoice AND $order->invoice_number)
					{
						$fileAttachment['content'] = PDF::invoice($order, 'S');
						$fileAttachment['name'] = Configuration::get('PS_INVOICE_PREFIX', (int)($order->id_lang)).sprintf('%06d', $order->invoice_number).'.pdf';
						$fileAttachment['mime'] = 'application/pdf';
					}
					else
						$fileAttachment = NULL;
	
//echo "Assunto: ".Mail::l('Order confirmation', (int)$order->id_lang);
					if (Validate::isEmail($customer->email))
						Mail::Send((int)$order->id_lang, 'order_conf_mb', 'Resumo da Encomenda', $data, $customer->email, $customer->firstname.' '.$customer->lastname, NULL, NULL, $fileAttachment);
				}
				
				$this->currentOrder = (int)$order->id;
				return true;
			}
			else
			{
				$errorMessage = Tools::displayError('Order creation failed');
				Logger::addLog($errorMessage, 4, '0000002', 'Cart', intval($order->id_cart));
				die($errorMessage);
			}
		}
		else
		{
			$errorMessage = Tools::displayError('Cart cannot be loaded or an order has already been placed using this cart');
			Logger::addLog($errorMessage, 4, '0000001', 'Cart', intval($cart->id));
			die($errorMessage);
		}
	}
	
	/**
	 * @param Object Address $the_address that needs to be txt formated
	 * @return String the txt formated address block
	 */

	private function _getFormatedAddress(Address $the_address, $line_sep, $fields_style = array())
	{
		$out = '';
		$adr_fields = AddressFormat::getOrderedAddressFields($this->id_country);

		$r_values = array();

		foreach($adr_fields as $fields_line)
		{
			$tmp_values = array();
			foreach (explode(' ', $fields_line) as $field_item)
			{
				$field_item = trim($field_item);
				$tmp_values[] = (isset($fields_style[$field_item]))? sprintf($fields_style[$field_item], $the_address->{$field_item}) : $the_address->{$field_item};
			}
			$r_values[] = implode(' ', $tmp_values);
		}


		$out = implode($line_sep, $r_values);
		return $out;
	}
	
	
	public function setMultibancoOrderDb($order,$entidade,$referencia,$valor)
	{
		Db::getInstance()->Execute
			('
				INSERT INTO `' . _DB_PREFIX_ . 'multibanco`
			( `order_id`, `entidade`, `referencia`, `valor`)
				VALUES
			('.$order.', '.$entidade.', \''.$this->centerTrim($referencia).'\', '.$valor.');
			');
	}
	
	public function getMultibancoOrderDb($entidade,$referencia,$valor)
	{

		$pagamentos = Db::getInstance()->getRow('
		SELECT `order_id`
		FROM `'._DB_PREFIX_.'multibanco`
		WHERE `entidade`=\''.$entidade.'\' and `referencia` =\''.$referencia.'\' and `valor`=\''.$valor.'\' and `chave` is null
		ORDER BY id desc
		');
		
		return $pagamentos['order_id'];
	}
	
	public function updateMultibancoOrderDb($orderId)
	{
		Db::getInstance()->Execute
			('
				UPDATE `' . _DB_PREFIX_ . 'multibanco`
				SET `chave` = \'PAGO\'
				WHERE `order_id`='.$orderId);
	}
	
	function centerTrim($str){
		return preg_replace("/\s+/", "", $str);
	}
	
	/* 
	 * Função para tratamento do callback
     */	 
	public function callback($chave, $entidade, $referencia, $valor)
	{
		$chaveReg = Configuration::get('MULTIBANCO_CHAVE_ANTI_PHISHING');
		if($chave == $chaveReg){
			$orderId = $this->getMultibancoOrderDb($entidade, $referencia, $valor);
			
			if(!empty($orderId)){
				$new_history = new OrderHistory();
				$new_history->id_order = (int)$orderId;
				$new_history->changeIdOrderState((int)Configuration::get('_PS_OS_MULTIBANCO_1'), (int)$orderId);
				$new_history->addWithemail(true, null);
				
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

?>