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

<form method="POST" action="{$action}" id="ifthenpay-mbway-payment-form">

	<small>
		{l s='Please enter the mobile phone number associated with your MB WAY account' mod='ifthenpay'}
	</small>
	<div id="ifthenpayPhoneWrapper" class="input-container">
		{if not empty($countryCodeOptions)}
			<select id="ifthenpayMbwayPhoneCode" class="form-control form-control-select" name="ifthenpayMbwayPhoneCode"
				required="">
				{foreach $countryCodeOptions as $countryCode}
					<option value="{$countryCode['value']}" {if $countryCode['value'] == '351'} selected {/if}>
						{$countryCode['name']}</option>
				{/foreach}
			</select>
			<input id="ifthenpayMbwayPhone" name="ifthenpayMbwayPhone" class="form-control ifthenpay_mbway_phone"
				type="text" placeholder="{l s='MB WAY Mobile Phone Number' mod='ifthenpay'}">
		{else}
			<div class="input-container">
				<i class="material-icons mbway_icon">smartphone</i>
				<input id="ifthenpayMbwayPhone" name="ifthenpayMbwayPhone" class="form-control input-field" type="text"
					placeholder="{l s='MB WAY Mobile Phone Number' mod='ifthenpay'}">
			</div>
		{/if}
	</div>
</form>
