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

<div class="panel-heading">
	<h5>{l s='Pay by %s' mod='ifthenpay' sprintf=[$paymentMethod]}</h5>
</div>
<div class="panel-body">
    <div class="paymentLogo">
        <img src="{$paymentLogo}" alt="{$paymentMethod} logotipo">
    </div>
    <div class="paymentData">
        {if $paymentMethod == 'multibanco'}
            <ul class="list-group">
                <li class="list-group-item">
                    {l s='Entity:' mod='ifthenpay'}
                    <span>{$entidade}</span>
                </li>
                <li class="list-group-item">
                    {l s='Reference:' mod='ifthenpay'}
                    <span>{$referencia}</span>
                </li>
                <li class="list-group-item">
                    {l s='Total to Pay:' mod='ifthenpay'}
                    <span>{$totalToPay}</span>
                </li>
                {if $validade != ''}
                    <li class="list-group-item">
                    {l s='Deadline:' mod='ifthenpay'}
                    <span>{$validade}</span>
                </li>
                {/if}



            </ul>
        {elseif $paymentMethod == 'mbway'}
            <ul class="list-group">
                <li class="list-group-item">
                    {l s='Phone:' mod='ifthenpay'}
                    <span>{$telemovel}</span>
                </li>
                <li class="list-group-item">
                    {l s='Order:' mod='ifthenpay'}
                    <span>{$orderId}</span>
                </li>
                <li class="list-group-item">
                    {l s='Total to Pay:' mod='ifthenpay'}
                    <span>{$totalToPay}</span>
                </li>
            </ul>
            {if $resendMbwayNotificationControllerUrl != ''}
                <div>
                    <h5>{l s='Did not receive MB WAY notification?' mod='ifthenpay'}</h5>
                    <a class="btn btn-primary mbwayResendNotificationLink" href="{$resendMbwayNotificationControllerUrl}">{l s='Resend MB WAY notification' mod='ifthenpay'}</a>
                </div>
            {/if}
        {elseif $paymentMethod == 'payshop'}
            <ul class="list-group">
                <li class="list-group-item">
                    {l s='Reference:' mod='ifthenpay'}
                    <span>{$referencia}</span>
                </li>
                <li class="list-group-item">
                    {l s='Deadline:' mod='ifthenpay'}
                    <span>{$validade}</span>
                </li>
                <li class="list-group-item">
                    {l s='Total to Pay:' mod='ifthenpay'}
                    <span>{$totalToPay}</span>
                </li>
            </ul>
        {else}
            <ul class="list-group">
                <li class="list-group-item">
                    {l s='Total to Pay:' mod='ifthenpay'}
                    <span>{$totalToPay}</span>
                </li>
            </ul>
        {/if}
    </div>
</div>