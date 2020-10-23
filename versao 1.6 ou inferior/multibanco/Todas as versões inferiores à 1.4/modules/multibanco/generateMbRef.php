<?php

$order_id    = $_POST['order_id'];
$order_value = $_POST['order_value'];

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
	
function GenerateMbRef($order_id, $order_value)
{
    $ent_id      = $_POST['ent_id'];
    $subent_id   = $_POST['subent_id'];
	
	$order_id ="0000".$order_id;

		$order_value= sprintf("%01.2f", $order_value);

		$order_value =  format_number($order_value);
   //     Apenas são considerados os 4 caracteres mais à direita do order_id
	$order_id = substr($order_id, (strlen($order_id) - 4), strlen($order_id));

//     Podemos definir ou não um valor mínimo para pagamentos no multibanco apesar
//     não existir um limite mínimo
	if ($order_value < 1)
	{
		echo "Lamentamos mas é impossível gerar uma referência MB para valores inferiores a 1 Euro";
		return;
	}

//     O valor máximo que se pode pagar no multibanco é 999999.99 Euros pelo que
//     teremos que repartir o valor por mais do que uma referencia se o valor for superior
	if ($order_value >= 1000000)
	{
		echo "<b>AVISO:</b> Pagamento fraccionado por exceder o valor limite para pagamentos no sistema Multibanco<br>";
	}
	
	while ($order_value >= 1000000)
	{
		GenerateMbRef($order_id, 999999.99);
		$order_value -= 999999.99;
	}
					  
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
       $a = "<style media='print'>.oculta{visibility: hidden}</style>";
       echo "<input type='button' value='Imprimir' onclick='javascript:window.print()' class='oculta'>";
       echo "<pre>";
       echo "<b>Pagamento por Multibanco</b>";
       echo "\n\n<b>Entidade:    </b>".$ent_id ." ".$order_id." ".$order_value." ".$chk_val;
       echo "\n\n<b>Refer&ecirc;ncia:  </b>".$subent_id." ".substr($chk_str, 8, 3)." ".substr($chk_str, 11, 1).$chk_digits;
       echo "\n\n<b>Valor:       </b>".round($order_value, 2,',', ' ');
       echo "<br><br>O tal&atilde;o emitido pelo caixa autom&aacute;tico<br>";
       echo "faz prova de pagamento. Conserve-o.";
       echo "</pre>";
}
echo GenerateMbRef($order_id, $order_value);
?>
