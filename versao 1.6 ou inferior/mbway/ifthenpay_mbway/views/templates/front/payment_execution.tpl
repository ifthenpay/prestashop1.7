{capture name=path}{l s='Pay by MBWay' mod='ifthenpay_mbway'}{/capture}


<h2>{l s='Order summary' mod='ifthenpay_mbway'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <= 0}
	<p class="warning">{l s='Your shopping cart is empty.' mod='ifthenpay_mbway'}</p>
{else}

<h3>{l s='Pay by MBWay' mod='ifthenpay_mbway'}</h3>
<form action="{$link->getModuleLink('ifthenpay_mbway', 'validation', [], true)|escape:'html'}" method="post">
<p>
	<img src="{$this_path}logo.jpg" alt="{l s='MBWay' mod='ifthenpay_mbway'}" width="49" style="float:left; margin: 0px 10px 5px 0px;" />
	{l s='You have chosen to pay by MBWay.' mod='ifthenpay_mbway'}
	<br/><br />
	{l s='Here is a short summary of your order:' mod='ifthenpay_mbway'}
</p>
<p style="margin-top:20px;">
	- {l s='The total amount of your order is' mod='ifthenpay_mbway'}
	<span id="amount" class="price">{displayPrice price=$total}</span>
	{if $use_taxes == 1}
    	{l s='(tax incl.)' mod='ifthenpay_mbway'}
    {/if}
</p>
<br /><br />
<p>
	<b>{l s='Please fill with your MBWay registered mobile phone number and click confirm your order button in order to proceed' mod='ifthenpay_mbway'}</b>
	<br /><br />
	{l s='Mobile Phone' mod='ifthenpay_mbway'}: <input type="text" name="ifthenpay_mbway_mobilephone" id="ifthenpay_mbway_mobilephone" />
</p>
<p class="cart_navigation" id="cart_navigation">
	<a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html'}" class="button_large">{l s='Other payment methods' mod='ifthenpay_mbway'}</a>
	<input id="payment-confirmation" type="submit" value="{l s='I confirm my order' mod='ifthenpay_mbway'}" class="exclusive_large" style=" float: right; "/>
</p>
</form>
{/if}