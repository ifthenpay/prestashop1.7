{if $status == 'ok'}
        <p>{l s='Your order on' mod='multibanco'} <span class="bold">{$shop_name}</span> {l s='is complete.' mod='multibanco'}<br /><br />
        <span class="bold">{l s='Please note that you have selected to pay by Multibanco:' mod='multibanco'}</span>
        <br /><br />- {l s='an amout of' mod='multibanco'} <span class="price">{$total_to_pay}</span>
        <br /><br />- {l s='for a purchase of' mod='multibanco'} <span class="price"></span>
        <table class="std">
        <tbody>
		{foreach from=$products item=product name=products}{assign var='quantityDisplayed' value=0}{if $product.product_quantity > $quantityDisplayed}
		<tr class="{if $smarty.foreach.products.first}first_item{/if} {if $smarty.foreach.products.index % 2}alternate_item{else}item{/if}">
            <td><span class="order_qte_span editable">{$product.product_quantity|intval}</span></td>
            <td>{if $product.product_reference}{$product.product_reference|escape:'htmlall':'UTF-8'}{else}--{/if}</td>
			<td class="bold">{$product.product_name|escape:'htmlall':'UTF-8'}</td>
		</tr>
		{/if}
		{/foreach}
		</tbody>
	    </table>
        <br /><br /><span class="bold">{l s='An e-mail has been sent to you with this information.' mod='multibanco'}</span>
		<br /><br /><span class="bold">{l s='Your order will be sent as soon as payment is received.' mod='multibanco'}</span>
        <br /><br /><span class="bold">{l s='This is your slip with the details for Multibanco payment. Click the button to open it in a new window.' mod='multibanco'}</span>
        </p>
        <table  width="500"   cellpadding="0" cellspacing="10" ><tr><td align="left"><b>{$result}</b></td><td align="left" ><form action="{$module_dir}geraRef.php" onsubmit="window.open('','pop','scrollbars=yes,width=500,height=250')" target="pop" method="post"  id="multibanco_form">
         <input type="hidden" name="subent_id"   value="{$subent_id}" />
         <input type="hidden" name="order_id"    value="{$order_id}" />
         <input type="hidden" name="order_value" value="{$total}" />
	     <input type="hidden" name="ent_id"      value="{$ent_id}" />

         <input type="image" src="{$module_dir}img/pagmultibanco.png" name="submitPayment" />
        </form></td></tr></table>

          <br />{l s='For any questions or for further information, please contact our' mod='multibanco'} <a href="{$base_dir_ssl}contact-form.php">{l s='customer support' mod='multibanco'}</a>. <br /><br />
{else}
	<p class="warning">
		{l s='We noticed a problem with your order. If you think this is an error, you can contact our' mod='multibanco'}
		<a href="{$base_dir_ssl}contact-form.php">{l s='customer support' mod='multibanco'}</a>.
	</p >
{/if}



