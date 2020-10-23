{if $status == 'ok'}
<p>
	{l s='Your order on %s is complete' mod='ifthenpay' sprintf=[$shopName]}
		<br /><br />
		{l s='Please use the data below to pay for your order.' mod='ifthenpay'}
		<div class="panel">
			<div class="panel-heading">
				<h5>{l s='Pay by %s' mod='ifthenpay' sprintf=[$paymentMethod]}</h5>
			</div>
			<div class="panel-body">
				<div class="paymentLogo">
					<img src="{$paymentLogo}">
				</div>
				<div class="paymentData">
					{if $paymentMethod === 'multibanco'}
					<ul class="list-group">
						<li class="list-group-item">
							{l s='Entity:' mod='ifthenpay'}
							<span class="badge">{$entidade}</span>
						</li>
						<li class="list-group-item">
							{l s='Reference:' mod='ifthenpay'}
							<span class="badge">{$referencia}</span>
						</li>
						<li class="list-group-item">
							{l s='Total to pay:' mod='ifthenpay'}
							<span class="badge">{$totalToPay}</span>
						</li>
					</ul>
					{elseif $paymentMethod === 'mbway'}
						<ul class="list-group">
							<li class="list-group-item">
								{l s='Phone:' mod='ifthenpay'}
								<span class="badge">{$telemovel}</span>
							</li>
							<li class="list-group-item">
								{l s='Order:' mod='ifthenpay'}
								<span class="badge">{$orderId}</span>
							</li>
							<li class="list-group-item">
								{l s='Total to Pay:' mod='ifthenpay'}
								<span class="badge">{$totalToPay}</span>
							</li>
						</ul>
						{if $resendMbwayNotificationControllerUrl !== ''}
							<div>
								<h5>{l s='Not receive MBway notification?' mod='ifthenpay'}</h5>
								<a class="btn btn-primary" href="{$resendMbwayNotificationControllerUrl}">{l s='Resend MBway notification' mod='ifthenpay'}</a>
							</div>
						{/if}
					{elseif $paymentMethod === 'payshop'}
						<ul class="list-group">
							<li class="list-group-item">
								{l s='Reference:' mod='ifthenpay'}
								<span class="badge">{$referencia}</span>
							</li>
							<li class="list-group-item">
								{l s='Deadline:' mod='ifthenpay'}
								<span class="badge">{$validade}</span>
							</li>
							<li class="list-group-item">
								{l s='Total to Pay:' mod='ifthenpay'}
								<span class="badge">{$totalToPay}</span>
							</li>
						</ul>
					{/if}
				</div>
			</div>
		</div>
		<br /><br />{l s='An email was sent with this information' mod='ifthenpay'}.
		<br /><br /><strong>{l s='Your order will be shipped as soon as payment is confirmed.' mod='ifthenpay'}</strong>
		<br /><br />{l s='If you have questions, comments or concerns, please contact our' mod='ifthenpay'} 
		<a href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}">{l s='expert customer support team.' mod='ifthenpay'}</a>
</p>
{else}
	<p class="warning">
		{l s='We have noticed that there is a problem with your order. If you think this is an error, you can contact our' mod='ifthenpay'} 
		<a href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}">{l s='expert customer support team.' mod='ifthenpay'}</a>
	</p>
{/if}