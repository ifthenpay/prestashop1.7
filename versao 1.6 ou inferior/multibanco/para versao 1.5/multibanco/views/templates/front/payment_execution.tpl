{capture name=path}Pagamento por Refer&ecirc;ncia Multibanco{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>Resumo da encomenda</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <= 0}
	<p class="warning">O seu carrinho de compras encontra-se vazio</p>
{else}

<h3>Pagamento por Refer&ecirc;ncia Multibanco</h3>
<form action="{$link->getModuleLink('multibanco', 'validation', [], true)}" method="post">
<p>
	<img src="{$this_path}multibanco.jpg" alt="{l s='ATM' mod='multibanco'}" width="49" style="float:left; margin: 0px 10px 5px 0px;" />
	Escolheu pagar por Refer&ecirc;ncia Multibanco
	<br/><br />
	Aqui tem um pequeno sum&aacute;rio sobre a sua encomenda:
</p>
<p style="margin-top:20px;">
	- O total a pagar pela sua encomenda &eacute;
	<span id="amount" class="price">{displayPrice price=$total}</span>
	{if $use_taxes == 1}
    	(C/ IVA)
    {/if}
</p>
<p>
	A informa&ccedil;&atilde;o para proceder ao Pagamento por Refer&ecirc;ncia Multibanco ir&aacute; aparecer na pr&oacute;xima p&aacute;gina.
	<br /><br />
	<b>Por favor confirme clicando em "Confirmar Encomenda".</b>
</p>
<p class="cart_navigation">
	<input type="submit" name="submit" value="Confirmar Encomenda" class="exclusive_large" />
	<a href="{$link->getPageLink('order', true, NULL, "step=3")}" class="button_large">Outros m&eacute;todos de pagamento</a>
</p>
</form>
{/if}