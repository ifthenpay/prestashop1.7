<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-heading">
				<img src="{$logo_mb_gif}" alt="Endereço de entrega" />
				Dados Multibanco
			</div>
			<div id="info">
				<table style="font-family: Verdana,sans-serif; font-size: 11px; color: black; width: 278px;">
					<tbody>
						<tr>
						  <td rowspan="3">
						  <div align="center"><img src="{$logo_mb}" alt="" width="49"></div>
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
						  <td style="text-align: left;">{$valor}</td>
						</tr>
					</tbody>
				</table>
					<br /><br />

				{if $linked_order}
					<div style="margin: auto; text-align: center;">Esta referência é relativa ao total das encomendas com as seguintes referências:<br/>
						{foreach $linked_order_number as $lon}
							<span style="font-weight: bold;">{$lon}</span><br/>
						{/foreach}
					</div>
					<br />
					<br />
				{/if}
					<div>
						<a href="{$base_url}?fc=module&module=multibanco&controller=update&order_id={$order_id}&folder={$url_folder}&token={$token}" class="btn btn-primary">Atualizar Dados Multibanco</a>
						<a href="{$base_url}?fc=module&module=multibanco&controller=resend&order_id={$order_id}&folder={$url_folder}&token={$token}" class="btn btn-primary">Reenviar Refer&ecirc;ncia ao Cliente</a>
						&nbsp;&nbsp;
						<a href="{$base_url}?fc=module&module=multibanco&controller=remember&order_id={$order_id}&folder={$url_folder}&token={$token}" class="btn btn-primary">Lembrar Cliente sobre pagamento</a>
					</div>
					<br />
					{if $estadoenvio == 'sucesso'}
						<div style="color: black;border: 2px dotted green;background: lightgreen;font-weight: bold;text-align: center;padding: 10px;">Refer&ecirc;ncia enviada para o Cliente.</div>
					{else if $estadoenvio == 'erro'}
						<div style="color: black;border: 2px dotted red; background: lightsalmon;font-weight: bold;text-align: center;padding: 10px;">Refer&ecirc;ncia n&atilde;o foi enviada para o Cliente.</div>
					{else if $estadolembrete == 'sucesso'}
						<div style="color: black;border: 2px dotted green;background: lightgreen;font-weight: bold;text-align: center;padding: 10px;">Foi enviado um lembrete ao Cliente sobre o pagamento em falta.</div>
					{else if $estadolembrete == 'erro'}
						<div style="color: black;border: 2px dotted red; background: lightsalmon;font-weight: bold;text-align: center;padding: 10px;">N&atilde;o foi enviado um lembrete ao Cliente sobre o pagamento em falta.</div>
					{else if $estadoatualizacao == 'sucesso'}
						<div style="color: black;border: 2px dotted green;background: lightgreen;font-weight: bold;text-align: center;padding: 10px;">Os dados para pagamento por referência Multibanco foram atualizados.</div>
					{else if $estadoatualizacao == 'erro'}
						<div style="color: black;border: 2px dotted red; background: lightsalmon;font-weight: bold;text-align: center;padding: 10px;">Os dados para pagamento por referência Multibanco n&atilde;o foram atualizados.</div>
					{/if}
			</div>
		</div>
	</div>
</div>
