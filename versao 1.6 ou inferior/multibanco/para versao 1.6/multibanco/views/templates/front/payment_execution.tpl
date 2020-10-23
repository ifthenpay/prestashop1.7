{capture name=path}{l s='Pay by Multibanco Reference' mod='multibanco'}{/capture}


<h2>{l s='Order summary' mod='multibanco'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <= 0}
	<p class="warning">{l s='Your shopping cart is empty.' mod='multibanco'}</p>
{else}

<h3>{l s='Pay by Multibanco Reference' mod='multibanco'}</h3>
<form action="{$link->getModuleLink('multibanco', 'validation', [], true)|escape:'html'}" method="post">
<div class="panel panel-default panel-paymentExecution">
	<div class="panel-header">
		<div>
			<img src="{$this_path}multibanco.jpg" alt="{l s='ATM' mod='multibanco'}" width="49"/>
		</div>
	</div>
	<div class="panel-body">
		<p>
			{l s='You have chosen to pay by multibanco reference.' mod='multibanco'}
		</p>
		<p>
			{l s='Here is a short summary of your order:' mod='multibanco'}
		</p>
		<p>
			{l s='The total amount of your order is' mod='multibanco'}
			<span id="amount" class="price">{displayPrice price=$total}</span>
			{if $use_taxes == 1}
				{l s='(tax incl.)' mod='multibanco'}
			{/if}
		</p>
		<p>
			{l s='The Multibanco Reference Information will be displayed on the next page.' mod='multibanco'}
		</p>
		<p>
			<b>{l s='Please confirm your order by clicking "I confirm my order."' mod='multibanco'}.</b>
		</p>
	</div>
</div>
<p class="cart_navigation" id="cart_navigation">
	<a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html'}" class="button_large">{l s='Other payment methods' mod='multibanco'}</a>
	<input type="submit" value="{l s='I confirm my order' mod='multibanco'}" class="exclusive_large" style=" float: right; "/>
</p>
</form>
{/if}