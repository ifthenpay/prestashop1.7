{*
* 2007-2020 PrestaShop
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
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="panel">
    <div class="panel-header header-paymentMethod">
        <img src="{$module_dir|escape:'html':'UTF-8'}/views/img/{$paymentMethod}.png"/>
    </div>
  	<div class="panel-body body-paymentMethod">
        {if $paymentMethod === 'mbway'} 
            <p>{l s='This module allows secure payment by %s' mod='ifthenpay' sprintf=[$paymentMethod|capitalize]}.</p>
        {else}
            <p>{l s='This module allows secure payment by Reference %s' mod='ifthenpay' sprintf=[$paymentMethod|capitalize]}.</p>
        {/if}
        <p>{l s='If the customer chooses to pay by %s reference, the order status will be placed in "Wait for payment by %s"' mod='ifthenpay' sprintf=[$paymentMethod|capitalize, $paymentMethod|capitalize]}.<p>
        <p>{l s='When payment is made, the order status will change to "Payment confirmed by %s' mod='ifthenpay' sprintf=[$paymentMethod|capitalize]}."</p>
	</div>
</div>
{if $form}
    {$form}   
{else}
    <div class="container-full">
        <div class="row">
            <div class="col-md-4">
                 <div class="panel">
                    <div class="panel-heading">
					    <i class="icon-cogs"></i>
                        {l s='%s Account Settings' mod='ifthenpay' sprintf=[$paymentMethod]}
					</div>
                    <div class="panel-body">
                        <ul class="list-group">
                        {if $paymentMethod eq 'multibanco'}
                            <li class="list-group-item">
                                {l s='Entity' mod='ifthenpay'}
                                <span class="badge">{$entidade}</span>
                            </li>
                            <li class="list-group-item">
                                {l s='SubEntity' mod='ifthenpay'}
                                <span class="badge">{$subEntidade}</span>
                            </li>
                        {elseif $paymentMethod eq 'mbway'}
                            <li class="list-group-item">
                                {l s='Mbway key' mod='ifthenpay'}
                                <span class="badge">{$mbwayKey}</span>
                            </li>
                        {else}
                            <li class="list-group-item">
                                {l s='Payshop key' mod='ifthenpay'}
                                <span class="badge">{$payshopKey}</span>
                            </li>
                            <li class="list-group-item">
                                {l s='Deadline' mod='ifthenpay'}
                                <span class="badge">{$payshopValidade}</span>
                            </li>
                        {/if}
                        </ul>
                    </div>
                    <button class="btn btn-primary" id="chooseNewEntidade">{l s='Choose New Entity/SubEntity' mod='ifthenpay'}</button>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel">
                    <div class="panel-heading">
                        <i class="icon-cogs"></i>
                        {l s='Callback Settings' mod='ifthenpay'}
                    </div>
                    <div class="panel-body">
                        {if $isCallbackActivated}
                            <span class="label label-success">{l s='Callback is activated' mod='ifthenpay'}</span>
                        {else}
                            <span class="label label-danger">{l s='Callback not activated' mod='ifthenpay'}</span>
                        {/if}
                        <ul class="list-group callback-list-group">
                            <li class="list-group-item">
                                {l s='Anti-Phishing key' mod='ifthenpay'}
                                <span class="badge">{$chaveAntiPhishing}</span>
                            </li>
                            <li class="list-group-item callback-list">
                                {l s='Callback Url' mod='ifthenpay'}
                                <span id="callbackUrl" class="badge" style="display:none;">{$urlCallback}</span> 
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}


