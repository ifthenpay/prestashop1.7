{if $status == 'ok'}
<p>
	{l s='Your order on %s is complete' mod='ifthenpay' sprintf=[$shopName]}
		<br /><br />
		{l s='Please use the data below to pay for your order.' mod='ifthenpay'}
</p>
{if $paymentMethod == 'mbway' && $mbwayCountdownShow}
	<div class="panel mbwayCountdownPanel">
		<div class="panel-body">
			<h3>{l s='Confirm payment in your MB WAY App' mod='ifthenpay'}</h3>
			{include file="../admin/_partials/spinner.tpl"}
			<div id="countdownMbway">
				<h3 id="countdownMinutes"></h3>
				<h3>:</h3>
				<h3 id="countdownSeconds"></h3>
			</div>
			<p>{l s='If you do not confirm payment in 5 minutes, the payment notification will expire.' mod='ifthenpay'}</p>
		</div>
	</div>
	<div id="confirmMbwayOrder" class="panel" style="display:none;">
		<div class="panel-heading">
		<img src="{$confirmOrderImg}" alt="confirm order icon">
		</div>
		<div class="panel-body">
			<h3>{l s='Order Paid!' mod='ifthenpay'}</h3>
			<p>{l s='Payment order confirmed, Your order will be shipped.' mod='ifthenpay'}</p>
		</div>
	</div>
{/if}	
<div id="paymentReturnPanel" class="panel">
	{include file="./_partials/paymentPanel.tpl"}
</div>
<br /><br />{l s='An email was sent with this information' mod='ifthenpay'}.
<br /><br /><strong>{l s='Your order will be shipped as soon as payment is confirmed.' mod='ifthenpay'}</strong>
<br /><br />{l s='If you have questions, comments or concerns, please contact our' mod='ifthenpay'} 
<a href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}">{l s='expert customer support team.' mod='ifthenpay'}</a>
{else}
	<div id="orderErrorPanel" class="panel">
		<div class="panel-heading">
			<img src="{$orderErrorImg}" alt="error icon">
		</div>
		<div class="panel-body">
			<h3>{l s='Something went wrong!' mod='ifthenpay'}</h3>
			<p>{l s='There was an error processing your payment, please contact our' mod='ifthenpay'} 
			<a href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}">{l s='expert customer support team.' mod='ifthenpay'}</a></p>
		</div>
	</div>
{/if}