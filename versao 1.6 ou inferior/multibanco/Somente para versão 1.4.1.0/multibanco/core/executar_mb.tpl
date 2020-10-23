{capture name=path}Pagamento por Refer&ecirc;ncia Multibanco{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Order summary' mod='multibanco'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

<h3>Pagamento por Refer&ecirc;ncia Multibanco</h3>

<p>
	<img src="{$this_path}img/mb.png" alt="{l s='Multibanco' mod='multibanco'}" style="float:left; margin: 0px 10px 5px 0px;" />
	<br /> <br />
	<br /> <br />
	<br /> <br />
	<br /> <br />
	Escolheu pagar por Multibanco.
	<br /> <br />
	A seguir, um pequeno sum&aacute;rio sobre a sua encomenda:
</p> 
<p style="margin-top:10px;">
	<br /> - O valor total da sua encomenda &eacute;:
	<span id="amount" class="price">{displayPrice price=$total}</span>
	{if $use_taxes == 1}
    	(C/ IVA)
	{else}
		(S/ IVA)
    {/if}
</p>
<p>


<h3>Intru&ccedil;&otilde;es de pagamento</h3>
<b>- Se optar por Pagamento Multibanco, o pagamento pode ser feito em qualquer caixa multibanco.</b><br />
<br /><br />
<b>Por favor confirme a sua encomenda clicando "Confirmar Encomenda".</b>
<form action="{$this_path}core/valida_mb.php"     method="post" id="form1">
<p class="cart_navigation">
    <a href="{$base_dir_ssl}order.php?step=3" class="button_large">Outros m&eacute;todos de Pagamento</a>
   	<input type="submit" name="submit" value="Confirmar Encomenda" class="exclusive_large" />
</p>
</form>