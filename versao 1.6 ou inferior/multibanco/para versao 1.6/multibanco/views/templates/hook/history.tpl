<table cellpadding="0" cellspacing="0" style="margin:auto;border-left: 1px solid black;border-right: 1px solid black;border-top: 1px solid black; width: 211px;" >
	<tbody>
		<tr>
			<td valign="top" style="border-bottom: solid 1px #222; padding-top: 5px; padding-bottom: 5px;">
				<img src="{$logo_mb}" border="0" style="width: 36px;">
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
<br />
<br />

{if $linked_order}
<div style="margin: auto; text-align: center;">Esta referência é relativa ao total das encomendas com as seguintes referências:<br/>
	{foreach $linked_order_number as $lon}
		<span style="font-weight: bold;">{$lon}</span><br/>
	{/foreach}
</div>
<br />
<br />
{/if}
