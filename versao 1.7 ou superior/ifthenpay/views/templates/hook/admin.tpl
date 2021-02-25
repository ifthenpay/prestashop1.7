<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-order-ifthenpay">
			<div class="panel-heading">
				<h3>{l s='Pay by %s' mod='ifthenpay' sprintf=[$paymentMethod|ucfirst]}</h3>
			</div>
			<div>{$message}</div>
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
							{l s='Total to Pay:' mod='ifthenpay'}
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
								{l s='IdRequest:' mod='ifthenpay'}
								<span class="badge">{$idPedido}</span>
							</li>
							<li class="list-group-item">
								{l s='Total to Pay:' mod='ifthenpay'}
								<span class="badge">{$totalToPay}</span>
							</li>
						</ul>
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
								{l s='IdRequest:' mod='ifthenpay'}
								<span class="badge">{$idPedido}</span>
							</li>
							<li class="list-group-item">
								{l s='Total to Pay:' mod='ifthenpay'}
								<span class="badge">{$totalToPay}</span>
							</li>
						</ul>
					{/if}
					<div>
						{if $paymentMethod == 'multibanco' || $paymentMethod == 'payshop'}
							<a href="{$updateControllerUrl}" class="btn btn-primary">{l s='Update %s data' mod='ifthenpay' sprintf=[$paymentMethod|ucfirst]}</a>
						{/if}
						{if $idPedido && $telemovel}
							<a href="{$resendControllerUrl}" class="btn btn-primary">{l s='Resend Payment Data' mod='ifthenpay' }</a>
						{else}
							<a id="resendPaymentBtn" href="{$resendControllerUrl}" class="btn btn-primary">{l s='Resend Payment Data' mod='ifthenpay' }</a>
						{/if}
						{if $paymentMethod == 'multibanco' || $paymentMethod == 'payshop'}
							<a href="{$rememberControllerUrl}" class="btn btn-primary">{l s='Remember Payment Details' mod='ifthenpay' }</a>
						{/if}
						<a id="chooseNewPaymentMethod" href="{$chooseNewPaymentMethodControllerUrl}" class="btn btn-primary">{l s='Choose new Payment Method' mod='ifthenpay'}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>