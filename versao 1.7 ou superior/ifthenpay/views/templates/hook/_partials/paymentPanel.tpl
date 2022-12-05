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


            {* a table with 2 columns and three rows *}

            <table class="table if_table">
                <tbody>
                    <tr>
                        <td class="if_td_desc">{l s='Entity:' mod='ifthenpay'}</td>
                        <td class="if_td_value">{$entidade}</td>
                    </tr>
                    <tr>
                        <td class="if_td_desc">{l s='Reference:' mod='ifthenpay'}</td>
                        <td class="if_td_value">{$referencia}</td>
                    </tr>
                    <tr>
                        <td class="if_td_desc">{l s='Total to Pay:' mod='ifthenpay'}</td>
                        <td class="if_td_value">{$totalToPay}</td>
                    </tr>
                    {if $validade != ''}
                        <tr>
                            <td class="if_td_desc">{l s='Deadline:' mod='ifthenpay'}</td>
                            <td class="if_td_value">{$validade}</td>
                        </tr>
                    {/if}
                </tbody>
            </table>
            <p class="ifthenpay_info">{l s='Processed by ifthenpay' mod='ifthenpay'}</p>


        {elseif $paymentMethod == 'mbway'}

            <table class="table if_table">
                <tbody>
                    <tr>
                        <td class="if_td_desc">{l s='Phone:' mod='ifthenpay'}</td>
                        <td class="if_td_value">{$telemovel}</td>
                    </tr>
                    <tr>
                        <td class="if_td_desc">{l s='Order:' mod='ifthenpay'}</td>
                        <td class="if_td_value">{$orderId}</td>
                    </tr>
                    <tr>
                        <td class="if_td_desc">{l s='Total to Pay:' mod='ifthenpay'}</td>
                        <td class="if_td_value">{$totalToPay}</td>
                    </tr>
                </tbody>
            </table>


            {if $resendMbwayNotificationControllerUrl != ''}
                <div>
                    <h5>{l s='Did not receive MB WAY notification?' mod='ifthenpay'}</h5>
                    <a class="btn btn-primary mbwayResendNotificationLink"
                        href="{$resendMbwayNotificationControllerUrl}">{l s='Resend MB WAY notification' mod='ifthenpay'}</a>
                </div>
            {/if}
        {elseif $paymentMethod == 'payshop'}

            <table class="table if_table">
                <tbody>
                    <tr>
                        <td class="if_td_desc">{l s='Reference:' mod='ifthenpay'}</td>
                        <td class="if_td_value">{$referencia}</td>
                    </tr>
                    {if $validade != ''}
                        <tr>
                            <td class="if_td_desc">{l s='Deadline:' mod='ifthenpay'}</td>
                            <td class="if_td_value">{$validade}</td>
                        </tr>
                    {/if}
                    <tr>
                        <td class="if_td_desc">{l s='Total to Pay:' mod='ifthenpay'}</td>
                        <td class="if_td_value">{$totalToPay}</td>
                    </tr>
                </tbody>
            </table>

        {else}

            <table class="table if_table">
                <tbody>
                    <tr>
                        <td class="if_td_desc">{l s='Total to Pay:' mod='ifthenpay'}</td>
                        <td class="if_td_value">{$totalToPay}</td>
                    </tr>
                </tbody>
            </table>
        {/if}
    </div>
</div>