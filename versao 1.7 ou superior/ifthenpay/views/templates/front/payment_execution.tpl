{capture name=path}{l s='Pay by %s' mod='ifthenpay' sprintf=[$paymentOption|ucfirst]}{/capture}


<h2>{l s='Order summary' mod='ifthenpay'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <= 0}
	<p class="warning">{l s='Your shopping cart is empty.' mod='ifthenpay'}</p>
{else}

<h3>{l s='Pay by %s' mod='ifthenpay' sprintf=[$paymentOption|ucfirst]}</h3>
<form action="{$link->getModuleLink('ifthenpay', 'validation', ['paymentOption => {$paymentOption}], true)|escape:'html'}" method="post">
<p>
	<img src="{$this_path}multibanco.jpg" alt="{l s='Multibanco' mod='ifthenpay'}" width="49" style="float:left; margin: 0px 10px 5px 0px;" />
	{l s='You have chosen to pay by %s.' mod='ifthenpay' sprintf=[$paymentOption|ucfirst]}
	<br/><br />
	{l s='Here is a short summary of your order:' mod='ifthenpay'}
</p>
<p style="margin-top:20px;">
	- {l s='The total amount of your order is' mod='ifthenpay'}
	<span id="amount" class="price">{displayPrice price=$total}</span>
	{if $use_taxes == 1}
    	{l s='(tax incl.)' mod='ifthenpay'}
    {/if}
</p>
<p>
	{l s='The Payment Information will be displayed on the next page.' mod='ifthenpay'}
	<br /><br />
	<b>{l s='Please confirm your order by clicking "I confirm my order."' mod='ifthenpay'}.</b>
</p>
<p class="cart_navigation" id="cart_navigation">
	<a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html'}" class="button_large">{l s='Other payment methods' mod='ifthenpay'}</a>
	<input type="submit" value="{l s='I confirm my order' mod='ifthenpay'}" class="exclusive_large" style=" float: right; "/>
</p>
</form>
{/if}