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
        {elseif $paymentMethod == 'mbway'}
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
            {if $resendMbwayNotificationControllerUrl != ''}
                <div>
                    <h5>{l s='Not receive MBway notification?' mod='ifthenpay'}</h5>
                    <a class="btn btn-primary mbwayResendNotificationLink" href="{$resendMbwayNotificationControllerUrl}">{l s='Resend MBway notification' mod='ifthenpay'}</a>
                </div>
            {/if}
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
                    {l s='Total to Pay:' mod='ifthenpay'}
                    <span class="badge">{$totalToPay}</span>
                </li>
            </ul>
        {else}
            <ul class="list-group">
                <li class="list-group-item">
                    {l s='Total to Pay:' mod='ifthenpay'}
                    <span class="badge">{$totalToPay}</span>
                </li>
            </ul>
        {/if}
    </div>
</div>