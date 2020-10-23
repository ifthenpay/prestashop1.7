<?php
/**
* - By Ehinarr Elkader(ehinarr@msn.com)
* - THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

class multibanco extends PaymentModule
{
	private $_html = '';
	private $_postErrors = array();

	public  $ent_id;
    public  $subent_id;
    public  $result;
	public $valorOrder;

  public function __construct()
	{
		$this->name    = 'multibanco';
		$this->tab     = 'Payment';
		$this->version = 2.1;
        $this->path    = $this->_path;

        $this->idOrderState = Configuration::get('_PS_OS_MULTIBANCO_0');
        

		$config = Configuration::getMultiple(array('MULTIBANCO_ENT_ID','MULTIBANCO_SUBENT_ID'));
		if (isset($config['MULTIBANCO_ENT_ID']))
			$this->ent_id = $config['MULTIBANCO_ENT_ID'];
        if (isset($config['MULTIBANCO_SUBENT_ID']))
			$this->subent_id = $config['MULTIBANCO_SUBENT_ID'];


      parent::__construct(); /* The parent construct is required for translations */

		$this->page             = basename(__FILE__, '.php');
		$this->displayName      = $this->l('Multibanco');
		$this->description      = $this->l('Accept payments by Multibanco');
		$this->confirmUninstall = $this->l('Are you sure you want to delete your details?');
		if (!isset($this->ent_id))
            $this->warning = $this->l('Please Entidade number is required');
        if (!isset($this->subent_id))
            $this->warning = $this->l('Please Sub-entidade number is required');
}
    public function install()
    {
        if(!(Configuration::get('_PS_OS_MULTIBANCO_0') > 0))
            $this->create_states();
            
        if (!parent::install()
            OR !$this->registerHook('payment')
            OR !$this->registerHook('paymentReturn')
            OR !Configuration::updateValue('MULTIBANCO_ENT_ID', '10559')
			OR !$this->registerHook('AdminOrder')
            )
			return false;
        return true;
	}
 
    public function uninstall()
	{

		if (!Configuration::deleteByName('MULTIBANCO_ENT_ID')
           OR !Configuration::deleteByName('MULTIBANCO_SUBENT_ID')
           OR !parent::uninstall())

        return false;
        return true;
	}
	
	function hookAdminOrder($params)
	{
		$order_id    = $params['id_order'];
$ent_id      = $this->ent_id;
        $subent_id   = $this->subent_id;
        
		$sel = intval($order_id);
        $order_v = $this->readOrderDetails($sel);
		$order_value=$order_v['total_paid'];
		$order_id ="0000".$order_id;
		
		
		$order_id = substr($order_id, (strlen($order_id) - 4), strlen($order_id));

		$order_value= sprintf("%01.2f", $order_value);

		$order_value =  $this->format_number($order_value);
		
        if ($order_value < 1)
        $msg = $this->l('Lamentamos mas &eacute; imposs&iacute;vel gerar uma refer&ecirc;ncia MB para valores inferiores a 1 Euro.');
        if ($order_value >= 1000000)
        $msg = $this->l('AVISO: Pagamento fraccionado por exceder o valor limite para pagamentos no sistema Multibanco.');
        if ($order_value <= 1000000)
        {
           /* $chk_str = sprintf('%03u%04u%08u', $subent_id, $order_id, round($order_value*100));
            $chk_val = 923;
            $chk_array = array(3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62);
            for ($i = 0; $i < 15; $i++)
            {
                $chk_int = substr($chk_str, 14-$i, 1);
                $chk_val += ($chk_int%10)*$chk_array[$i];
            }
            $chk_val %= 97;
            $chk_digits = sprintf('%02u', 98-$chk_val);

            $a = "<pre>";
            $b = "\n\n<b>Entidade:    </b>".$ent_id;
            $c = "\n\n<b>Referência:  </b>".$subent_id." ".substr($chk_str, 3, 3)." ".substr($chk_str, 6, 1).$chk_digits;
            $d = "\n\n<b>Valor:       </b>".round($order_value,2);
            $e = "</pre>";
            $f = "<br><strong>".$this->l('Tome nota dos dados ou clique na imagem para imprimir.')."<br></strong></div>";
            $result = $a.$b.$c.$d.$e.$f;
            $y = setcookie('referencia',$a.$b.$c.$d.$e, time()+3600);*/
            
            //     Cálculo dos check-digits
	
	$chk_str = sprintf('%05u%03u%04u%08u', $ent_id, $subent_id, $order_id, round($order_value*100));
		   
           $chk_array = array(3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62, 38, 89, 17, 73, 51);
           
           for ($i = 0; $i < 20; $i++)
           {
                 $chk_int = substr($chk_str, 19-$i, 1);
                 $chk_val += ($chk_int%10)*$chk_array[$i];
           }
   
	$chk_val %= 97;
   
	$chk_digits = sprintf('%02u', 98-$chk_val);
	}
	
		global $smarty;
		
		$smarty->assign(array(
			'entidade'          => $ent_id,
		'referencia'         => $subent_id." ".substr($chk_str, 8, 3)." ".substr($chk_str, 11, 1).$chk_digits,
		'valor'         => round($order_value,2),
		'id_order'	 => $id_order,
		'this_page'	 => $_SERVER['REQUEST_URI'],
		'this_path' => $this->_path,
					'this_path_ssl' => Configuration::get('PS_FO_PROTOCOL').$_SERVER['HTTP_HOST'].__PS_BASE_URI__."modules/{$this->name}/"));
		return $this->display(__FILE__, 'invoice_block.tpl');

	}
	
	function readOrderDetails($sel)
	{
		$db = Db::getInstance();
		
		$querySelect='SELECT * FROM ' . _DB_PREFIX_ . 'orders WHERE id_order ="'.intval($sel).'";';
		
		$result = $db->ExecuteS($querySelect);
		return $result[0];
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
    private function _postProcess()
	{
        if (isset($_POST['btnSubmit']))
		{
           Configuration::updateValue('MULTIBANCO_ENT_ID', $_POST['ent_id']);
           Configuration::updateValue('MULTIBANCO_SUBENT_ID', $_POST['subent_id']);

		}

		$this->_html .= '<div class="conf confirm"><img src="../img/admin/ok.gif" alt="'.$this->l('ok').'" /> '.$this->l('Settings updated').'</div>';

        if (isset($_POST['submitPayment']))
		{
           $this->GenerateMbRef($order_id, $order_value);
		}

    }

    private function _displayForm()
	{
            $output = '<img src="../modules/multibanco/img/mb.jpg"  style="float:left; margin-right:15px;"></a><br /> <br />
            '.$this->l('- This module allows you to accept payments by Multibanco.').'</b><br />
            '.$this->l('- If the client chooses this payment mode, the order will change its status into a \'Waiting for payment\' status.').'<br />
            '.$this->l('- Therefore, you will need to manually confirm the order as soon as you receive the payment.').'<br />
            <br /> <br /><br /><br />
            <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
           	<fieldset>
			<legend><img src="../img/admin/contact.gif" />'.$this->l('Configuration').'</legend>
			<table class="table" border="0" width="900" cellpadding="0" cellspacing="2" id="form">
            <tr><td width="150" style="vertical-align: top;"><b>'.$this->l('Entidade:').'&nbsp;&nbsp;</b></td>
            <td width="250" style="vertical-align: top;"><input type="text" name="ent_id" value="'.htmlentities(Tools::getValue('ent_id', $this->ent_id), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" MAXLENGTH=5/></td><td>&nbsp;&nbsp;'.$this->l('(Sempre com 5 dígitos (10559 no caso da IFTHEN).').'</p></td></tr>
            <tr><td width="150" style="vertical-align: top;"><b>'.$this->l('Sub-entidade:').'&nbsp;&nbsp;</b></td>
            <td width="250" style="vertical-align: top;"><input type="text" name="subent_id" value="'.htmlentities(Tools::getValue('subent_id', $this->subent_id), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" MAXLENGTH=3/></td><td>&nbsp;&nbsp;'.$this->l('(Fornecido pela IFTHEN e sempre com 3 dígitos (Ex: 999).)').'</p></td></tr>
            <tr><td><a href="../modules/multibanco/extras/Multibanco_Empresas.pdf"><img src="../modules/multibanco/img/help.gif"         >'.$this->l('Help').'             </a></td>
                <td><a href="../modules/multibanco/extras/IFMultiBanco.exe"       ><img src="../modules/multibanco/img/IFMultiBanco.png" >'.$this->l('Check references.').'</a></td>
            </tr><tr>
            <td align="left"><a href="../modules/multibanco/extras/CONTRATOMB.pdf"         ><img src="../modules/multibanco/img/pdf.gif"          >'.$this->l('Contract.').'         </a></td>
            <td align="left"><a href="../modules/multibanco/extras/Multibanco_English.pdf" ><img src="../modules/multibanco/img/pdf.gif"          >'.$this->l('English.').'         </a></td>
             <td align="right"><input class="button" name="btnSubmit" value= "'.$this->l('Update settings').'" type="submit" </td>
            </tr>
            </table>
	        </fieldset>
            </form> <br />';
            return $output;
        }

    public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2><br>';
  
        if (!empty($_POST))
		{
			$this->_postValidation();
			if (!sizeof($this->_postErrors))
				$this->_postProcess();
			else
				foreach ($this->_postErrors AS $err)
					$this->_html .= '<div class="alert error">'. $err .'</div>';
		}
		else
			$this->_html .= '<br />';
        if (Tools::isSubmit('btnSubmit') AND ($ent_id = Tools::getValue('ent_id'))AND ($subent_id = Tools::getValue('subent_id')))
		{
           Configuration::updateValue('MULTIBANCO_ENT_ID', $ent_id);
           Configuration::updateValue('MULTIBANCO_SUBENT_ID', $subent_id);

	   $output .= '
       <div class="conf confirm">
       <img src="../img/admin/ok.gif" alt="'.$this->l('ok').'" />
        '.$this->l('Settings updated').'</div>';
        }
 		return $output.$this->_displayForm();
	}
 
    public function hookPayment($params)
	{
        if (!$this->active)
			return ;

      	global $smarty;

		$smarty->assign(array(
            'this_path'     => $this->_path,
			'this_path_ssl' => (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://').htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/'.$this->name.'/'
        ));
		return $this->display(__FILE__, 'payment.tpl');
	}
 
    public function execPayment($cart)
	{
        if (!$this->active)
        return ;

		global $cookie, $smarty;

        $products =  $cart->getProducts();

        $this->_products = $products;
		$currencies = Currency::getCurrencies();

 	    $smarty->assign(array(
			'currency_default' => new Currency(Configuration::get('PS_CURRENCY_DEFAULT')),
			'currencies'       => $this->getCurrency(),
			'total'            => number_format($cart->getOrderTotal(true, 3), 2, '.', ''),
			'isoCode'          => Language::getIsoById(intval($cookie->id_lang)),
			'ent_id'           => $this->ent_id,
            'subent_id'        => $this->subent_id,
            'products'         => $this->_products,
            'this_path'        => $this->_path,
			'this_path_ssl'    => (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://').htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/'.$this->name.'/'
		));

		return $this->display(__FILE__, 'payment_execution.tpl');
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

    public function hookPaymentReturn($params)
	{
        if (!$this->active)
        return ;

		global $cookie, $smarty;
        $order_id    = $params['objOrder']->id;
        $order_value = $params['total_to_pay'];
        $invoice     = $params['objOrder']->invoice_number;
        $products    = $params['objOrder']->getProducts();
        $ent_id      = $this->ent_id;
        $subent_id   = $this->subent_id;
		
        
		$order_id ="0000".$order_id;

		$order_id = substr($order_id, (strlen($order_id) - 4), strlen($order_id));
		$order_value= sprintf("%01.2f", $order_value);

		$order_value =  $this->format_number($order_value);
		
        if ($order_value < 1)
        $msg = $this->l('Lamentamos mas &eacute; imposs&iacute;vel gerar uma refer&ecirc;ncia MB para valores inferiores a 1 Euro.');
        if ($order_value >= 1000000)
        $msg = $this->l('AVISO: Pagamento fraccionado por exceder o valor limite para pagamentos no sistema Multibanco.');
        if ($order_value <= 1000000)
        {
           /* $chk_str = sprintf('%03u%04u%08u', $subent_id, $order_id, round($order_value*100));
            $chk_val = 923;
            $chk_array = array(3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62);
            for ($i = 0; $i < 15; $i++)
            {
                $chk_int = substr($chk_str, 14-$i, 1);
                $chk_val += ($chk_int%10)*$chk_array[$i];
            }
            $chk_val %= 97;
            $chk_digits = sprintf('%02u', 98-$chk_val);

            $a = "<pre>";
            $b = "\n\n<b>Entidade:    </b>".$ent_id;
            $c = "\n\n<b>Referência:  </b>".$subent_id." ".substr($chk_str, 3, 3)." ".substr($chk_str, 6, 1).$chk_digits;
            $d = "\n\n<b>Valor:       </b>".round($order_value,2);
            $e = "</pre>";
            $f = "<br><strong>".$this->l('Tome nota dos dados ou clique na imagem para imprimir.')."<br></strong></div>";
            $result = $a.$b.$c.$d.$e.$f;
            $y = setcookie('referencia',$a.$b.$c.$d.$e, time()+3600);*/
            
            //     Cálculo dos check-digits
	
	$chk_str = sprintf('%05u%03u%04u%08u', $ent_id, $subent_id, $order_id, round($order_value*100));
		   
           $chk_array = array(3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62, 38, 89, 17, 73, 51);
           
           for ($i = 0; $i < 20; $i++)
           {
                 $chk_int = substr($chk_str, 19-$i, 1);
                 $chk_val += ($chk_int%10)*$chk_array[$i];
           }
   
	$chk_val %= 97;
   
	$chk_digits = sprintf('%02u', 98-$chk_val);

       $a = "<pre>";
       $b = "\n\n<b>Entidade:    </b>".$ent_id;
       $c = "\n\n<b>Referência:  </b>".$subent_id." ".substr($chk_str, 8, 3)." ".substr($chk_str, 11, 1).$chk_digits;
       $d = "\n\n<b>Valor:       </b>".round($order_value,2);
       $e = "</pre>";
       $f = "<br>Tome nota dos dados ou clique no botão para imprimir.<br></strong></div>";

      // $msg = $a.$b.$c.$d.$e.$f;

            $result = $a.$b.$c.$d.$e.$f;
            $y = setcookie('referencia',$a.$b.$c.$d.$e, time()+3600);
            
            
        }
        $total_to_pay = Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false, false);
        $customer = new Customer(intval($cookie->id_customer));
        Mail::Send(intval($cookie->id_lang), 'multibanco', $this->l('Detalhes para Pagamento'), array('{firstname}' =>  $customer->firstname, '{lastname}' =>  $customer->lastname, '{result}' => $a.$b.$c.$d.$e, '{total_paid}' =>  $total_to_pay,  '{id_order}' => $params['objOrder']->id),  $customer->email, NULL, strval(Configuration::get('PS_SHOP_EMAIL')), strval(Configuration::get('PS_SHOP_NAME')), NULL, NULL, dirname(__FILE__).'/mails/');

        $this->_products = $products;
		$currencies = Currency::getCurrencies();
		$state = $params['objOrder']->getCurrentState();
        if ($state == $this->idOrderState OR $state == _PS_OS_OUTOFSTOCK_)
        $smarty->assign(array(
                'total' 	   => $params['total_to_pay'],
                'total_to_pay' =>  $total_to_pay,
                'ent_id'       => $this->ent_id,
                'subent_id'    => $this->subent_id,
                'order_id'     => $params['objOrder']->id,
				'invoice'      => $invoice,
                'result'       => $result,
                'products'     => $this->_products,
               	'status'       => 'ok',
                'currencies'   => $this->getCurrency(),
				'id_order'     => $params['objOrder']->id
			));
		else
			$smarty->assign('status', 'failed');

		return $this->display(__FILE__, 'payment_return.tpl');
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
    
    public function create_states()
	{

		$this->order_state = array(
		array( 'c9fecd', '10110', 'Awaiting payment by Multibanco',  '' ),
		array( 'ccfbff', '01110', 'Payment accepted by Multibanco',	 'payment'	)

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
			('.$value[1][0].', '.$value[1][1].', \'#'.$value[0].'\', '.$value[1][2].', '.$value[1][3].', '.$value[1][4].');
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

    		/** GRAVA AS CONFIGURAÇÕES  **/
    		Configuration::updateValue("_PS_OS_MULTIBANCO_$key", 	$this->figura);

		}

		return true;

	}
    
    public function GenerateMbRef($order_id, $order_value)
    {
        $ent_id      = $this->ent_id;
        $subent_id   = $this->subent_id;
        $order_id ="0000".$order_id;

		$order_value= sprintf("%01.2f", $order_value);

		$order_value =  $this->format_number($order_value);

		//Apenas sao considerados os 4 caracteres mais a direita do order_id
		$order_id = substr($order_id, (strlen($order_id) - 4), strlen($order_id));
        
		if ($order_value < 1)
       {
             echo "Lamentamos mas &eacute; imposs&iacute;vel gerar uma refer&ecirc;ncia MB para valores inferiores a 1 Euro";
             return;
       }
       if ($order_value >= 1000000)

             $return = "<b>AVISO:</b> Pagamento fraccionado por exceder o valor limite para pagamentos no sistema Multibanco<br>";
       else
       //while ($order_value >= 1000000)
      // {
      //       $this->GenerateMbRef($order_id++, 999999.99);
      //       $order_value -= 999999.99;
      // }

//       $ent_id = 10559;
//     Coloque aqui o seu codigo de sub-entidade
//       $subent_id = 999;

       $chk_str = sprintf('%05u%03u%04u%08u', $ent_id, $subent_id, $order_id, round($order_value*100));
		   
           $chk_array = array(3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62, 38, 89, 17, 73, 51);
           
           for ($i = 0; $i < 20; $i++)
           {
                 $chk_int = substr($chk_str, 19-$i, 1);
                 $chk_val += ($chk_int%10)*$chk_array[$i];
           }
   
	$chk_val %= 97;

       $chk_digits = sprintf('%02u', 98-$chk_val);

       $a = "<pre>";
       $b = "\n\n<b>Entidade:    </b>".$ent_id;
       $c = "\n\n<b>Referência:  </b>".$subent_id." ".substr($chk_str, 8, 3)." ".substr($chk_str, 11, 1).$chk_digits;
       $d = "\n\n<b>Valor:       </b>".round($order_value,2);
       $e = "</pre>";
       $f = "<br>Tome nota dos dados ou clique no botão para imprimir.<br></strong></div>";

       $result = $a.$b.$c.$d.$e.$f;
}

}

?>
