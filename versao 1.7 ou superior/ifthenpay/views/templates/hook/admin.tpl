{*
* 2007-2022 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-order-ifthenpay">
			<div class="panel-heading">
				<h3>{l s='Pay by %s' mod='ifthenpay' sprintf=[$paymentMethod|ucfirst]}</h3>
			</div>
			<div>{$message}</div>
			<div class="panel-body">
				<div class="row m_bottom_20">
					<div class="paymentLogo  col-auto">
						<img id="pm_logo" src="{$paymentLogo}">
					</div>
					<div class="paymentData  col">
						{if $paymentMethod == 'multibanco'}
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
						{elseif $paymentMethod == 'mbway'}
							<ul class="list-group">
								<li class="list-group-item">
									{l s='Phone:' mod='ifthenpay'}
									<span class="badge">{$telemovel}</span>
								</li>
								<li class="list-group-item">
									{l s='MB WAY Request ID:' mod='ifthenpay'}
									<span class="badge">{$idPedido}</span>
								</li>
								<li class="list-group-item">
									{l s='Total to Pay:' mod='ifthenpay'}
									<span class="badge">{$totalToPay}</span>
								</li>
							</ul>
						{elseif $paymentMethod == 'payshop'}
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
						{else}
							<ul class="list-group">
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
					</div>
					</div>

					<div class="row">
						{if $paymentMethod == 'multibanco' || $paymentMethod == 'payshop' || $paymentMethod == 'mbway'}
							<div class="adm_hist_actions">
								<a href="{$updateControllerUrl}" class=" btn btn-primary">{l s='Update %s Data' mod='ifthenpay' sprintf=[$paymentMethod|ucfirst]}</a>
							</div>
						{/if}
						{if $paymentMethod == 'mbway' && $idPedido && $telemovel}
							<div class="adm_hist_actions">
							<a href="{$resendControllerUrl}" class=" btn btn-primary">{l s='Resend Payment Data' mod='ifthenpay' }</a>
							</div>
							{elseif $paymentMethod == 'mbway'}
								<div class="adm_hist_actions">
									<a id="resendPaymentBtn" href="{$resendControllerUrl}" class="btn btn-primary">{l s='Resend Payment Data' mod='ifthenpay' }</a>
								</div>
						{/if}
						{if $paymentMethod == 'multibanco' || $paymentMethod == 'payshop'}
							<div class="adm_hist_actions">
								<a href="{$resendControllerUrl}" class=" btn btn-primary">{l s='Resend Payment Data' mod='ifthenpay' }</a>
							</div>
							<div class="adm_hist_actions">
								<a href="{$rememberControllerUrl}" class=" btn btn-primary">{l s='Remember Payment Details' mod='ifthenpay' }</a>
							</div>
						{/if}
						<div class="adm_hist_actions new_payment">
						<a id="chooseNewPaymentMethod" href="{$chooseNewPaymentMethodControllerUrl}" class=" btn btn-primary">{l s='Choose new Payment Method' mod='ifthenpay'}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>