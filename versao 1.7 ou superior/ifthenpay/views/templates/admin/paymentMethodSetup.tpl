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




<!-- Panes -->
{* info panel start *}
<div class="panel">
    <div class="panel-heading">
        <i class="icon-info"></i>
        {l s='%s payment method' mod='ifthenpay' sprintf=[$paymentMethod|ucfirst]}
    </div>

    <div class="panel-header header-paymentMethod">
        <img src="{$module_dir|escape:'html':'UTF-8'}/views/img/{$paymentMethod}.png" />
    </div>
    <div class="panel-body body-paymentMethod">
        {if $paymentMethod === 'mbway'}
            <p>{l s='This module allows secure payment by %s' mod='ifthenpay' sprintf=[$paymentMethod|capitalize]}.</p>
            <p>{l s='If the customer chooses to pay by %s, the order status will be placed in "Wait for payment by %s"' mod='ifthenpay' sprintf=[$paymentMethod|capitalize, $paymentMethod|capitalize]}.
            </p>
        <p>{l s='When payment is made, the order status will change to "Payment confirmed by %s' mod='ifthenpay' sprintf=[$paymentMethod|capitalize]}."
            </p>







        {elseif $paymentMethod === 'ccard'}
            <p>





            {l s='This module allows secure payment by credit card' mod='ifthenpay'}.</p>
            <p>





            {l s='If the customer chooses to pay by credit card, the order status will be placed in "Wait for payment by credit card"' mod='ifthenpay'}.
            </p>
            <p>





            {l s='When payment is made, the order status will change to "Payment confirmed by credit card' mod='ifthenpay'}."
            </p>
            <p>





            {l s='This method does not make use of the callback function to change order state, this is handled internally. To test credit card payed orders you must use a test card which you can request from Ifthenpay' mod='ifthenpay'}.
            </p>







        {else}
            <p>





            {l s='This module allows secure payment by Reference %s' mod='ifthenpay' sprintf=[$paymentMethod|capitalize]}.
            </p>
            <p>





            {l s='If the customer chooses to pay by %s reference, the order status will be placed in "Wait for payment by %s"' mod='ifthenpay' sprintf=[$paymentMethod|capitalize, $paymentMethod|capitalize]}.
            </p>
            <p>





            {l s='When payment is made, the order status will change to "Payment confirmed by %s' mod='ifthenpay' sprintf=[$paymentMethod|capitalize]}."
            </p>
        {/if}
    </div>
</div>
{* info panel end *}

{* specific payment method settings panel start *}
{$form}
{* specific payment method settings panel end *}

{* callback panel start *}
{if $displayCallbackTableInfo}
    <div class="panel">
        <div class="panel-heading">
            <i class="icon-rotate-left"></i>
            {l s='Callback' mod='ifthenpay'}
        </div>
        <div class="panel-body">
            {if $isCallbackActivated}
                <span class="label label-success">{l s='Callback is activated' mod='ifthenpay'}</span>
            {else}
                <span class="label label-danger">{l s='Callback not activated' mod='ifthenpay'}</span>
            {/if}
            {if $isCallbackActivated && $isSandboxMode}
                <span class="label label-warning">{l s='Sandbox Mode is enabled' mod='ifthenpay'}</span>
            {/if}
            <div class="list-group callback-list-group">
                <div class="col-sm-12 list-group-item">
                    <div class="col-md-3 col-sm-12">
                        {l s='Anti-Phishing key' mod='ifthenpay'}
                    </div>
                    <div class="col-md-9 col-sm-12 text-right">
                        <span class="badge">{$chaveAntiPhishing}</span>
                    </div>
                </div>
                <div class="col-sm-12 list-group-item">
                    <div class="col-md-3 col-sm-12">
                        {l s='Callback Url' mod='ifthenpay'}
                    </div>
                    <div class="col-md-9 col-sm-12">
                        <span id="callbackUrl" class="badge">{$urlCallback}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="panel">
        <div class="panel-heading">
            <i class="icon-rotate-left"></i>
            {l s='Test Callback' mod='ifthenpay'}
        </div>
        <div id="callback_result" class="bootstrap"></div>

        <div class="panel-body form-horizontal">
            <div class="form-wrapper" style="max-width: 83.33333%; margin: auto; padding: 14px 0;">


                {if $paymentMethod === 'multibanco'}

                    <div class="form-group" style="display: block;">
                        <label class="control-label col-lg-4">{l s='Reference' mod='ifthenpay'}</label>
                        <div class="col-lg-8">
                            <input type="text" id="reference" name="reference" class="form-control" />
                        </div>
                    </div>

                {elseif $paymentMethod === 'mbway'}

                    <div class="form-group" style="display: block;">
                        <label class="control-label col-lg-4">{l s='MB WAY Transaction ID' mod='ifthenpay'}</label>
                        <div class="col-lg-8">
                            <input type="text" id="mbway_transaction_id" name="mbway_transaction_id" class="form-control" />
                            <p class="help-block">{l s='Can be found as "MB WAY Request ID" in the SELL/Orders/Orders by selecting the order you wish to test and scrolling down to order payment details' mod='ifthenpay'}</p>

                        </div>
                    </div>

                {elseif $paymentMethod === 'payshop'}

                    <div class="form-group" style="display: block;">
                        <label class="control-label col-lg-4">{l s='Payshop Transaction ID' mod='ifthenpay'}</label>
                        <div class="col-lg-8">
                            <input type="text" id="payshop_transaction_id" name="payshop_transaction_id" class="form-control" />
                            <p class="help-block">{l s='Can be found as "IdRequest" in the SELL/Orders/Orders by selecting the order you wish to test and scrolling down to order payment details' mod='ifthenpay'}</p>
                        </div>
                    </div>

                {/if}


                <div class="form-group" style="display: block;">
                    <label class="control-label col-lg-4">{l s='Amount' mod='ifthenpay'}</label>
                    <div class="col-lg-8">
                        <input type="text" id="amount" name="amount" class="form-control" />
                    </div>
                </div>

            </div>


        </div>
        <div class="panel-footer">
            <button type="button" id="testCallback" class="btn btn-default pull-right">
                <i class="process-icon-refresh"></i>
                {l s='Test Callback' mod='ifthenpay'}
            </button>
        </div>


    </div>


{/if}
{* callback panel end *}