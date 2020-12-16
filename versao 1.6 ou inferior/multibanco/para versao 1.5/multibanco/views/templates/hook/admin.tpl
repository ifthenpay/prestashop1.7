<br />
<fieldset>
	<legend>
		<img src="{$this_path}logo.gif" alt="Endereço de entrega" />
		Dados Multibanco
	</legend>
	<div id="info">
	<table style="font-family: Verdana,sans-serif; font-size: 11px; color: black; width: 278px;">
		<tbody>
			<tr>
			  <td rowspan="3">
			  <div align="center"><img src="{$this_path}logo_mb.png" alt="" width="49"></div>
			  </td>
			  <td style="font-weight: bold; text-align: left;">Entidade:</td>
			  <td style="text-align: left;">{$entidade}</td>
			</tr>
			<tr>
			  <td style="font-weight: bold; text-align: left;">Refer&ecirc;ncia:</td>
			  <td style="text-align: left;">{$referencia}</td>
			</tr>
			<tr>
			  <td style="font-weight: bold; text-align: left;">Valor:</td>
			  <td style="text-align: left;">{$valor}&nbsp;&euro;</td>
			</tr>
		</tbody>
	</table>

	<br />

	<div>	<a href="../?fc=module&module=multibanco&controller=resend&order_id={$order_id}&folder={$url_folder}&token={$token}" style="border: 1px solid black; padding: 6px; background: gold; font-weight: bold;">Reenviar Refer&ecirc;ncia ao Cliente</a>

	&nbsp;&nbsp;

	<a href="../?fc=module&module=multibanco&controller=remember&order_id={$order_id}&folder={$url_folder}&token={$token}" style="border: 1px solid black; padding: 6px; background: gold; font-weight: bold;">Lembrar Cliente sobre pagamento</a></div>

	<br />

{if $estadoenvio == 'sucesso'}
	<div style="color: black;border: 2px dotted green;background: lightgreen;font-weight: bold;text-align: center;padding: 10px;">Refer&ecirc;ncia enviada para o Cliente.</div>
{else if $estadoenvio == 'erro'}
	<div style="color: black;border: 2px dotted red; background: lightsalmon;font-weight: bold;text-align: center;padding: 10px;">Refer&ecirc;ncia n&atilde;o foi enviada para o Cliente.</div>
{else if $estadolembrete == 'sucesso'}
	<div style="color: black;border: 2px dotted green;background: lightgreen;font-weight: bold;text-align: center;padding: 10px;">Foi enviado um lembrete ao Cliente sobre o pagamento em falta.</div>
{else if $estadolembrete == 'erro'}
	<div style="color: black;border: 2px dotted red; background: lightsalmon;font-weight: bold;text-align: center;padding: 10px;">N&atilde;o foi enviado um lembrete ao Cliente sobre o pagamento em falta.</div>
{/if}

	</div>
</fieldset>