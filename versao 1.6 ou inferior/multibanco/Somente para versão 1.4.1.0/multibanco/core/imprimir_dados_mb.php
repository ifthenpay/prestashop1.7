<?php
	$entidade="";
	$referencia="";
	$valor="";
	$modulePath="";
	$orderId="";
	
	if(isset($_POST['entidade'])) {
		$entidade=$_POST['entidade'];
	}else{
		$entidade="";
	}
	
	if(isset($_POST['referencia'])) {
		$referencia=$_POST['referencia'];
	}else{
		$referencia="";
	}
	
	if(isset($_POST['valor'])) {
		$valor=$_POST['valor'];
	}else{
		$valor="";
	}
	
	if(isset($_POST['modulePath'])) {
		$modulePath=$_POST['modulePath'];
	}else{
		$modulePath="";
	}
	
	if(isset($_POST['modulePath'])) {
		$modulePath=$_POST['modulePath'];
	}else{
		$modulePath="";
	}
	
	if(isset($_POST['orderId'])) {
		$orderId=$_POST['orderId'];
	}else{
		$orderId="";
	}
	
?>
<style media='print'>.oculta{visibility: hidden}</style>

<span style="font-weight: bold; color: #45829F;">Encomenda Nº </span><b><?php echo $orderId; ?></b>
<br />
<br />
<table style="font-family: Verdana,sans-serif; font-size: 11px; color: rgb(55, 73, 83); width: 278px;">
  <tbody>
    <tr style="color: rgb(5, 5, 5);">
      <td style="border-style: none none solid; border-top: 0px none; border-bottom: 1px solid rgb(69, 130, 159); font-size: x-small; border-right-width: 0px;" colspan="3">
      <div align="center">Pagamento por Multibanco ou Homebanking</div>
      </td>
    </tr>
    <tr>
      <td rowspan="3">
      <div align="center"><img src="<?php echo $modulePath; ?>img/mb.jpg" alt="" height="60" width="52"></div>
      </td>
      <td style="font-size: x-small; font-weight: bold; text-align: left;">Entidade:</td>
      <td style="font-size: x-small; text-align: left;"><?php echo $entidade; ?></td>
    </tr>
    <tr>
      <td style="font-size: x-small; font-weight: bold; text-align: left;">Referência:</td>
      <td style="font-size: x-small; text-align: left;"><?php echo $referencia; ?></td>
    </tr>
    <tr>
      <td style="font-size: x-small; font-weight: bold; text-align: left;">Valor:</td>
      <td style="font-size: x-small; text-align: left;"><?php echo $valor; ?></td>
    </tr>
    <tr style="color: rgb(2, 2, 2);">
      <td style="border-top: 1px solid rgb(69, 130, 159); font-size: xx-small;" colspan="3">O talão emitido pela caixa automática faz prova de pagamento. Conserve-o.</td>
    </tr>
  </tbody>
</table>
<br />
<span style="font-weight: bold; color: #45829F;">Instruções de Pagamento Multibanco</span>
<br />
<ol>
	<li>Na Caixa Automática de Multibanco, seleccione a opção <span style="font-weight: bold;">Pagamentos</span>.</li>
	<li>Seleccione a opção <span style="font-weight: bold;">Pagamentos de Serviços/Compras</span>.</li>
	<li>Preencha com os dados que encontra em cima.</li>
</ol>
<input type='button' value='Imprimir' onclick='javascript:window.print()' class='oculta'>