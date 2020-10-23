{capture name=path}{l s='Multibanco payment' mod='multibanco'}{/capture}
{include file=$tpl_dir./breadcrumb.tpl}

<h2>{l s='Order summary' mod='multibanco'}</h2>

{assign var='current_step' value='payment'}
{include file=$tpl_dir./order-steps.tpl}

<h3>{l s='Multibanco payment' mod='multibanco'}</h3>

<p>
	<img src="{$this_path}img/multibanco.png" alt="{l s='Multibanco' mod='multibanco'}" style="float:left; margin: 0px 10px 5px 0px;" />
	{l s='You have chosen to pay by Multibanco.' mod='multibanco'}
	<br /> <br />
	{l s='Here is a short summary of your order:' mod='multibanco'}
</p>  <br />
<p style="margin-top:20px;">
	<br /> - {l s='The total amount of your order is' mod='multibanco'}
	{if $currencies|@count > 1}
		{foreach from=$currencies item=currency}
			<span id="amount_{$currency.id_currency}" class="price" style="display:none;">{convertPriceWithCurrency price=$total currency=$currency}</span>
		{/foreach}
	{else}
		<span id="amount_{$currencies.0.id_currency}" class="price">{convertPriceWithCurrency price=$total currency=$currencies.0}</span>
	{/if}
	{l s='(tax incl.)' mod='multibanco'}
</p>
<p>
	-
	{if $currencies|@count > 1}
		{l s='We accept several currencies to be sent by Multibanco.' mod='multibanco'}
		<br /><br />
		{l s='Choose one of the following:' mod='multibanco'}
		<select id="currency_payement" name="currency_payement" onchange="showElemFromSelect('currency_payement', 'amount_')">
			{foreach from=$currencies item=currency}
				<option value="{$currency.id_currency}" {if $currency.id_currency == $cust_currency}selected="selected"{/if}>{$currency.name}</option>
			{/foreach}
		</select>
		<script language="javascript">showElemFromSelect('currency_payement', 'amount_');</script>
	{else}
		{l s='We accept the following currency to be sent by multibanco:' mod='multibanco'}&nbsp;<b>{$currencies.0.name}</b>
		<input type="hidden" name="currency_payement" value="{$currencies.0.id_currency}">
	{/if}

<h3>{l s='Payment instructions ' mod='multibanco'}</h3>
<b>- {l s='Se optar por Pagamento Multibanco, o pagamento pode ser feito em qualquer caixa multibanco.' mod='multibanco'}</b><br />
<b>- {l s='By confirming your purchase, a billing will be avaliable to you, in order to carry out the payment.' mod='multibanco'}</b>
<br />  <br /><br />
<b>{l s='Please confirm your order by clicking \'I confirm my order\'' mod='multibanco'}.</b>
<form action="{$this_path_ssl}validation.php"     method="post" id="form1">
<p class="cart_navigation">
    <a href="{$base_dir_ssl}order.php?step=3" class="button_large">{l s='Other payment methods' mod='multibanco'}</a>
   	<input type="submit" name="submit" value="{l s='I confirm my order' mod='multibanco'}" class="exclusive_large" />
</p>
</form>




