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


<form method="POST" action="{$action}" id="ifthenpay-pix-payment-form" class="mt-2 mb-2 form_pix">

	{* name *}
	<div class="form-group row ">
		<label class="col-md-3 form-control-label" for="field-name">
			{l s='Name' mod='ifthenpay'}
		</label>
		<div class="col-md-6">
			<input id="field-name" class="form-control" name="ifthenpay_customerName" type="text"
				value="{$customerName}" required maxlength="150">
			<span class="error-message message_required" style="color: red; font-size:12px; display: none;">{l s='Name is required.' mod='ifthenpay'}</span>
		</div>
		<div class="col-md-3 form-control-comment"></div>
	</div>

	{* CPF *}
	<div class="form-group row ">
		<label class="col-md-3 form-control-label" for="field-cpf">
			{l s='CPF' mod='ifthenpay'}
		</label>
		<div class="col-md-6">
			<input id="field-cpf" class="form-control" name="ifthenpay_customerCpf" type="text" value="{$customerCPF}">
			<span class="error-message message_required" style="color: red; font-size:12px; display: none;">{l s='CPF is required.' mod='ifthenpay'}</span>
			<span class="error-message message_regex" style="color: red; font-size:12px; display: none;">{l s='CPF format is invalid.' mod='ifthenpay'}</span>
		</div>
		<div class="col-md-3 form-control-comment"></div>
	</div>

	{* Email *}
	<div class="form-group row ">
		<label class="col-md-3 form-control-label" for="field-email">
			{l s='Email' mod='ifthenpay'}
		</label>
		<div class="col-md-6">
			<input id="field-email" class="form-control" name="ifthenpay_customerEmail" type="email"
				value="{$customerEmail}" required maxlength="250">
				<span class="error-message message_required" style="color: red; font-size:12px; display: none;">{l s='Email is required.' mod='ifthenpay'}</span>
				<span class="error-message message_regex" style="color: red; font-size:12px; display: none;">{l s='Email format is invalid.' mod='ifthenpay'}</span>
		</div>
		<div class="col-md-3 form-control-comment"></div>
	</div>

	<div class="row bootstrap iftp_separator">
		<hr class="">
		</hr>
		<span class="text-muted">{l s='Address' mod='ifthenpay'}</span>
		<hr class="">
		</hr>
	</div>

	{* <div class="iftp_separator">Next section</div> *}
	{* Phone *}
	<div class="form-group row ">
		<label class="col-md-3 form-control-label" for="field-phone">
			{l s='Phone' mod='ifthenpay'}
		</label>
		<div class="col-md-6">
			<input id="field-phone" class="form-control" name="ifthenpay_customerPhone" type="text"
				value="{$customerPhone}" maxlength="20">
		</div>
		<div class="col-md-3 form-control-comment">
			{l s='Optional' mod='ifthenpay'}
		</div>
	</div>

	{* Address *}
	<div class="form-group row ">
		<label class="col-md-3 form-control-label" for="field-address">
			{l s='Address' mod='ifthenpay'}
		</label>
		<div class="col-md-6">
			<input id="field-address" class="form-control" name="ifthenpay_customerAddress" type="text"
				value="{$customerAddress}" maxlength="250">
		</div>
		<div class="col-md-3 form-control-comment">
			{l s='Optional' mod='ifthenpay'}
		</div>
	</div>

	{* StreetNumber *}
	<div class="form-group row ">
		<label class="col-md-3 form-control-label" for="field-streetNumber">
			{l s='Street Number' mod='ifthenpay'}
		</label>
		<div class="col-md-6">
			<input id="field-streetNumber" class="form-control" name="ifthenpay_customerStreetNumber" type="text" value="{$customerStreetNumber}" maxlength="20">
		</div>
		<div class="col-md-3 form-control-comment">
			{l s='Optional' mod='ifthenpay'}
		</div>
	</div>

	{* City *}
	<div class="form-group row ">
		<label class="col-md-3 form-control-label" for="field-city">
			{l s='City' mod='ifthenpay'}
		</label>
		<div class="col-md-6">
			<input id="field-city" class="form-control" name="ifthenpay_customerCity" type="text"
				value="{$customerCity}" maxlength="50">
		</div>
		<div class="col-md-3 form-control-comment">
			{l s='Optional' mod='ifthenpay'}
		</div>
	</div>

	{* ZipCode *}
	<div class="form-group row ">
		<label class="col-md-3 form-control-label" for="field-zipCode">
			{l s='Zip/Postal Code' mod='ifthenpay'}
		</label>
		<div class="col-md-6">
			<input id="field-zipCode" class="form-control" name="ifthenpay_customerZipCode" type="text"
				value="{$customerZipCode}" maxlength="20">
		</div>
		<div class="col-md-3 form-control-comment">
			{l s='Optional' mod='ifthenpay'}
		</div>
	</div>

	{* State *}
	<div class="form-group row ">
		<label class="col-md-3 form-control-label" for="field-state">
			{l s='State' mod='ifthenpay'}
		</label>
		<div class="col-md-6">
			<input id="field-state" class="form-control" name="ifthenpay_customerState" type="text"
				value="{$customerState}" maxlength="50">
		</div>
		<div class="col-md-3 form-control-comment">
			{l s='Optional' mod='ifthenpay'}
		</div>
	</div>






</form>


<script>

// document.addEventListener("DOMContentLoaded", function () {



// 	$('#ifthenpay-pix-payment-form').on('submit', function(event){

// 		const nameElement = $(this).find('#field-cpf');

// 	if (nameElement.val() === '') {
// 		alert('its empty')
// 	}


// 		console.log("🚀 ~ $ ~ nameElement:", nameElement)


// 	event.preventDefault();

// 		alert('hi there');


// 	});



//     const form = document.querySelector("form"); // Adjust selector to your form if needed
//     const fieldName = document.getElementById("field-name");

//     form.addEventListener("submit", function (event) {
//         if (fieldName && !fieldName.value.trim()) {
//             event.preventDefault(); // Prevents form submission if field is empty
//             alert("Please fill out the Name field.");
//             fieldName.focus();
//         }
//     });
// });


</script>
