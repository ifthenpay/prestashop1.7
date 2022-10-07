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

{if $status == 'ok'}
	<p>
		{l s='Your order on %s is complete' mod='ifthenpay' sprintf=[$shopName]}
		<br /><br />
		{l s='Please use the data below to pay for your order.' mod='ifthenpay'}
	</p>
	{if $paymentMethod == 'mbway' && isset($mbwayCountdownShow) && $mbwayCountdownShow}
		<div class="panel mbwayCountdownPanel">
			<div class="panel-body">
				<h3>{l s='Confirm payment in your MB WAY app' mod='ifthenpay'}</h3>
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
			<div class="panel-heading mbway_status">
				<img src="{$confirmOrderImg}" alt="confirm order icon">
				<h3>{l s='Order Paid!' mod='ifthenpay'}</h3>
			</div>
			<div class="panel-body">
				<p>{l s='Payment confirmed, your order will be shipped.' mod='ifthenpay'}</p>
			</div>
		</div>
		<div id="refusedMbwayOrder" class="panel" style="display:none;">
			<div class="panel-heading mbway_status">
				<img src="{$refusedOrderImg}" alt="refused order icon">
				<h3>{l s='MB WAY payment refused!' mod='ifthenpay'}</h3>
			</div>
			<div class="panel-body">
				<p>{l s='Order payment refused from MB WAY app.' mod='ifthenpay'}</p>
			</div>
		</div>
		<div id="errorMbwayOrder" class="panel" style="display:none;">
			<div class="panel-heading mbway_status">
					<img src="{$errorOrderImg}" alt="error order icon">
					<h3>{l s='MB WAY payment failed!' mod='ifthenpay'}</h3>
			</div>
			<div class="panel-body">
				<p>{l s='Order payment by MB WAY failed either from incorrect phone number or SIBS downtime.' mod='ifthenpay'}</p>
			</div>
		</div>
		<div id="timeoutMbwayOrder" class="panel" style="display:none;">
			<div class="panel-heading mbway_status">
				<img src="{$errorOrderImg}" alt="timeout order icon">
				<h3>{l s='Out of Time!' mod='ifthenpay'}</h3>
			</div>
			<div class="panel-body">
				<p>
					{l s='Request another payment notification to your mobile phone by clicking the "Resend MB WAY notification" below.' mod='ifthenpay'}
				</p>
			</div>
		</div>
	{/if}
	<div id="paymentReturnPanel" class="panel">
		{include file="./_partials/paymentPanel.tpl"}
	</div>
	<br /><br />{l s='An email was sent with this information.' mod='ifthenpay'}.
	<br /><br /><strong>{l s='Your order will be shipped as soon as payment is confirmed.' mod='ifthenpay'}</strong>
	<br /><br />{l s='If you have questions, comments or concerns, please contact our' mod='ifthenpay'}
	<a
		href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}">{l s='expert customer support team.' mod='ifthenpay'}</a>
{else}
	<div id="orderErrorPanel" class="panel">
		<div class="panel-heading">
			<img src="{$errorOrderImg}" alt="error icon">
		</div>
		<div class="panel-body">
			<h3>{l s='Something went wrong!' mod='ifthenpay'}</h3>
			<p>{l s='There was an error processing your payment, please contact our' mod='ifthenpay'}
				<a
					href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}">{l s='expert customer support team.' mod='ifthenpay'}</a>
			</p>
		</div>
	</div>
{/if}