{if $status == 'ok'}
<p>A sua encomenda em {$shop_name} est&aacute; conclu&iacute;da
		<br /><br />
		Por favor utilize os dados abaixo para proceder ao pagamento da sua encomenda.

		<table cellpadding="0" cellspacing="0" style="margin-top:20px;border-left: 1px solid black;border-right: 1px solid black;border-top: 1px solid black; width: 211px;" >
			<tbody>
				<tr>
					<td valign="top" style="border-bottom: solid 1px #222; padding-top: 5px; padding-bottom: 5px;">
						<img src="{$mb_logo}" border="0" style="width: 50px;">
					</td>
					<td valign="middle" width="100%" style="padding-left: 10px; border-bottom: solid 1px #222; padding-top: 5px; padding-bottom: 5px; ">
						Pagamento por Multibanco&nbsp;&nbsp;
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" style="border-bottom: solid 1px #222; padding-top: 2px; padding-bottom: 2px;">

						<strong>&nbsp;Entidade:</strong>
					</td>
					<td valign="top" align="right" style="border-bottom: solid 1px #222; padding-top: 2px; padding-bottom: 2px; padding-right: 2px;">
						{$entidade}
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" style="border-bottom: solid 1px #222; padding-top: 2px; padding-bottom: 2px;">
						<strong>&nbsp;Refer&ecirc;ncia:</strong>
					</td>
					<td valign="top" align="right" style="border-bottom: solid 1px #222; padding-top: 2px; padding-bottom: 2px; padding-right: 2px;">
						{$referencia}
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" style="border-bottom: solid 1px #222; padding-top: 2px; padding-bottom: 2px; ">
						<strong>&nbsp;Valor:</strong>
					</td>
					<td valign="top" align="right" style="border-bottom: solid 1px #222; padding-top: 2px; padding-bottom: 2px;  padding-right: 2px;">
						{$total_paid}
					</td>
				</tr>
			</tbody>
		</table>

		<br /><br />
		Um email foi enviado com esta informa&ccedil;&atilde;o.

		<br /><br /> <strong>
		A sua encomenda ser&aacute; enviada assim que o pagamento for confirmado.
		</strong>

		<br /><br />
		Se tiver d&uacute;vidas, coment&aacute;rios ou sugest&otilde;es, entre em contato com a nossa <a href="{$link->getPageLink('contact', true)}">Equipa de Apoio ao Cliente</a>.
	</p>
{else}
	<p class="warning">
		Encontramos um problema com seu pedido. Se acha que isso &eacute; um erro, n&atilde;o hesite em contactar a nossa <a href="{$link->getPageLink('contact', true)}">Equipa de Apoio ao Cliente</a>.
	</p>
{/if}
