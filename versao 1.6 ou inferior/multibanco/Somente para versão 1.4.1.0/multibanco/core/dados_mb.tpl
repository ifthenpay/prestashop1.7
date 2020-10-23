{if $status == 'ok'}
    <p>
		A sua encomenda em <span class="bold">{$shop_name}</span> est&aacute; completa.
		<br />
		<br />
		<span class="bold">
			Tenha em aten&ccedil;&atilde;o que optou pelo pagamento por Multibanco:
		</span>
		<br />
		<br />
			- O valor de <span class="price">{$total_to_pay}</span>
		<br />
		<br />
		<span class="bold">
			Um e-mail foi enviado para si com esta informa&ccedil;&atilde;o.
		</span>
		<br />
		<br />
		<span class="bold">
			A sua encomenda ser&aacute; enviada assim que o pagamento for confirmado.
		</span>
		<br />
		<br />
		<span class="bold">
			Estes s&atilde;o os dados para proceder ao pagamento por multibanco. Clique no bot&atilde;o para imprimir.
		</span>
    </p>
	<div align="center">
		<table style="width: 278px; font-family: Verdana,sans-serif; font-size: 11px; color: #374953;">
			<tbody>
				<tr>
					<td style="font-size: x-small; border-top: 0px; border-left: 0px; border-right: 0px; border-bottom: 1px solid #45829F; background-color: #45829F; color: White" colspan="3"><div align="center">Pagamento por Multibanco ou Homebanking</div></td>
				</tr>
				<tr>
					<td rowspan="3"><div align="center"><img src="{$this_path}img/mb.jpg" alt="" width="52" height="60"/></div></td>
					<td style="font-size: x-small; font-weight:bold; text-align:left">Entidade:</td>
					<td style="font-size: x-small; text-align:left">{$entidade}</td>
				</tr>
				<tr>
					<td style="font-size: x-small; font-weight:bold; text-align:left">Refer&ecirc;ncia:</td>
					<td style="font-size: x-small; text-align:left">{$referencia}</td>
				</tr>
				<tr>
					<td style="font-size: x-small; font-weight:bold; text-align:left">Valor:</td>
					<td style="font-size: x-small; text-align:left">{$valor}</td>
				</tr>
				<tr>
					<td style="font-size: xx-small;border-top: 1px solid #45829F; border-left: 0px; border-right: 0px; border-bottom: 0px; background-color: #45829F; color: White" colspan="3">O tal&atilde;o emitido pela caixa autom&aacute;tica faz prova de pagamento. Conserve-o.</td>
				</tr>
			</tbody>
		</table>
		<br />
		<form action="{$this_path}core/imprimir_dados_mb.php" onsubmit="window.open('','pop','scrollbars=yes,width=750,height=446')" target="pop" method="post"  id="multibanco_form">
			<input type="hidden" name="entidade"   value="{$entidade}" />
			<input type="hidden" name="referencia"    value="{$referencia}" />
			<input type="hidden" name="valor" value="{$valor}" />
			<input type="hidden" name="modulePath"      value="{$this_path}" />
			<input type="hidden" name="orderId"      value="{$id_order}" />
			<input type="submit" value="Imprimir Refer&ecirc;ncia Multibanco"/>
		</form>
	</div>
	<br />
	Para qualquer quest&atilde;o ou para mais informa&ccedil;&otilde;es, por favor contate o nosso 
	<a href="{$base_dir_ssl}contact-form.php">Apoio ao Cliente</a>.
	<br />
	<br />
{else}
	<p class="warning">
		Verificamos um problema com a sua encomenda. Se pensa que isto &eacute; um erro pode contatar o nosso
		<a href="{$base_dir_ssl}contact-form.php">Apoio ao Cliente</a>.
	</p >
{/if}



