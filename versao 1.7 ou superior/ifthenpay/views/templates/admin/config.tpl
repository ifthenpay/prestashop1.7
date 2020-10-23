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
	<div class="panel-heading">
		<img src="{$module_dir|escape:'html':'UTF-8'}views/img/ifthenpay.png" id="payment-logo" />
		<h5>{l s='Smart Payments' mod='ifthenpay'}</h5>
        <h3 class="help-documentation-title">{l s='Need Help?' mod='ifthenpay'}</h3>
        {$isoCode}
        {if {$isoCode} eq "pt"}
            <a href="https://www.ifthenpay.com/downloads/prestashop/prestashop_user_guide_pt.pdf" target="_blank" class="btn btn-default" id="help-documentation-btn">{l s='Access the user documentation.' mod='ifthenpay'}</a><br />
        {else}
            <a href="https://www.ifthenpay.com/downloads/prestashop/prestashop_user_guide_en.pdf" target="_blank" class="btn btn-default" id="help-documentation-btn">{l s='Access the user documentation.' mod='ifthenpay'}</a><br />
        {/if}
		<h3 class="create-account-title">{l s='Already have an account?' mod='ifthenpay'}</h3>
        <a href="https://www.ifthenpay.com/downloads/ifmb/contratomb.pdf" target="_blank" class="btn btn-default" id="create-account-btn">{l s='Create an account now!' mod='ifthenpay'}</a><br />
	</div>
  	<div class="panel-body">
	  <h3>{l s='Multibanco, MBWAY and PAYSHOP payments has numerous advantages for your business' mod='ifthenpay'}</h3>
		<ul>
            <li>
                <h6>{l s='Free for users' mod='ifthenpay'}</h6>
            </li>
            <li>
                <h6>{l s='Payments 24 hours a day with real-time notifications' mod='ifthenpay'}</h6>
            </li>
            <li>
                <h6>{l s='Secure payments in Multibanco ATM, MBWAY and PAYSHOP' mod='ifthenpay'}</h6>
            </li>
            <li>
                <h6>{l s='Protected user data, no need to enter bank or card information' mod='ifthenpay'}</h6>
            </li>
            <li>
            	<h6>{l s='Multichannel payments: multibanco ATMs, Homebanking,<br> mobile phones, mPOS, MB SPOT network, MBWAY, PAYSHOP network, Post Offices' mod='ifthenpay'}</h6>
            </li>
            <li>
                <h6>{l s='Directly from user\'\s bank accounts no need for pre-load wallets' mod='ifthenpay'}</h6>
            </li>
            <li>
                <h6>{l s='Fully checkout inside seller\'\s website' mod='ifthenpay'}</h6>
            </li>
            <li>
                <h6>{l s='Free APP for payments tracking' mod='ifthenpay'}</h6>
            </li>
            <li>
                <h6>{l s='More automation, less administrative work, greater effectivness sales' mod='ifthenpay'}</h6>
            </li>
        </ul>
		<div>
            <img src="{$module_dir|escape:'html':'UTF-8'}views/img/multibanco_50.png" id="payment-logo" />
            <img src="{$module_dir|escape:'html':'UTF-8'}views/img/mbway_50.png" id="payment-logo" />
            <img src="{$module_dir|escape:'html':'UTF-8'}views/img/payshop.png" id="payment-logo" />
        </div>
	</div>
</div>
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li class="active"><a href="#template_1" role="tab" data-toggle="tab">{l s='Payment Settings' mod='ifthenpay'}</a></li>
	<li><a href="#template_2" role="tab" data-toggle="tab">LOGS</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane active" id="template_1">{$configForm}</div>
	<div class="tab-pane" id="template_2">{$logTable}</div>
</div>

