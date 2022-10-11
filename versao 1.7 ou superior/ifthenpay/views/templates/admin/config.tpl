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

<div class="panel">
    <div class="row m-20">

        <div class="col-sm-8 col-md-7">
            <img src="{$module_dir|escape:'html':'UTF-8'}views/img/ifthenpay.png" id="payment-logo" />
            <h5>{l s='Smart Payments' mod='ifthenpay'}</h5>
        </div>

        <div class="col-sm-4 col-md-5 text-center">
        
            <div class="col-sm-6">
                <h2>{l s='Need help?' mod='ifthenpay'}</h2>
                <a href="https://helpdesk.ifthenpay.com/pt-PT/support/home" target="_blank"
                    class="btn btn-default" id="">{l s='Go to Support!' mod='ifthenpay'}</a><br />
            </div>
            <div class="col-sm-6">
                <h2>{l s='Already have an account?' mod='ifthenpay'}</h2>
                <a href="https://www.ifthenpay.com/downloads/ifmb/contratomb.pdf" target="_blank"
                    class="btn btn-default" id="">{l s='Request an account now!' mod='ifthenpay'}</a><br />
            </div>
        </div>

    </div>
    <div class="panel-body">
        <h3>{l s='Multibanco, MB WAY and PAYSHOP payments has numerous advantages for your business' mod='ifthenpay'}
        </h3>
        <ul>
            <li>
                <h6>{l s='Free for users' mod='ifthenpay'}</h6>
            </li>
            <li>
                <h6>{l s='Payments 24 hours a day with real-time notifications' mod='ifthenpay'}</h6>
            </li>
            <li>
                <h6>{l s='Secure payments in Multibanco Multibanco, MB WAY and PAYSHOP' mod='ifthenpay'}</h6>
            </li>
            <li>
                <h6>{l s='Protected user data, no need to enter bank or card information' mod='ifthenpay'}</h6>
            </li>
            <li>
                <h6>{l s='Multichannel payments: Multibanco ATMs, Homebanking,<br> mobile phones, POS, MB SPOT network, MB WAY, PAYSHOP network, Post Offices' mod='ifthenpay'}
                </h6>
            </li>
            <li>
                <h6>{l s='Directly from user\'\s bank accounts no need for pre-load wallets' mod='ifthenpay'}</h6>
            </li>
            <li>
                <h6>{l s='Fully checkout inside seller\'\s website' mod='ifthenpay'}</h6>
            </li>
            <li>
                <h6>{l s='Free app for payments tracking' mod='ifthenpay'}</h6>
            </li>
            <li>
                <h6>{l s='More automation, less administrative work, greater effectivness sales' mod='ifthenpay'}</h6>
            </li>
        </ul>
        <div>
            <img src="{$module_dir|escape:'html':'UTF-8'}views/img/multibanco_50.png" />
            <img src="{$module_dir|escape:'html':'UTF-8'}views/img/mbway_50.png" />
            <img src="{$module_dir|escape:'html':'UTF-8'}views/img/payshop.png" />
            <img src="{$module_dir|escape:'html':'UTF-8'}views/img/ccard_50.png" />
        </div>
    </div>
</div>
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#template_1" role="tab" data-toggle="tab">{l s='Payment Settings' mod='ifthenpay'}</a>
    </li>
    <li><a href="#template_2" role="tab" data-toggle="tab">LOGS</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="template_1">
        <div class="container-full">
            {if $isBackofficeKey}
                <div>
                    {$configForm}
                    <div class="panel resetIfthenpayAccountsPanel">
                        <div class="panel-body text-center">
                            <h2>{l s='Use a different account.' mod='ifthenpay'}</h2>
                            <p>{l s='If you wish to use a different account click the reset button below.' mod='ifthenpay'}
                            </p>
                            <p>{l s='Warning: this will clear the current configuration.' mod='ifthenpay'}</p>
                            <div class="spinnerDivWithBtn">
                                <button type="button" id="resetIfthenpayAccount"
                                    class="btn btn-danger btn-lg btn-block">{l s='Reset' mod='ifthenpay'}</button>
                                {include file="./_partials/spinner.tpl"}
                            </div>

                        </div>
                    </div>
                </div>
                <div>
                    <div class="panel updateModulePanel">
                        <div class="panel-body text-center">
                            {if $updateIfthenpayModuleAvailable}
                                <img src="{$updateSystemIcon}" alt="update system icon">
                                <h2>{l s='New update is available!' mod='ifthenpay'}</h2>
                                <div class="text-left bulletPoints">
                                    {$upgradeModuleBulletPoints}
                                </div>
                                <a href="{$moduleUpgradeUrlDownload}" download id="downloadUpdateModuleIfthenpay"
                                    class="btn btn-danger btn-lg btn-block"
                                    target="_blank">{l s='Download Module Update' mod='ifthenpay'}</a>
                            {else}

                                <h2>{l s='Version ' mod='ifthenpay'}{$ifthenpayVersion}</h2>
                                <img src="{$updatedModuleIcon}" alt="update system icon">
                                <h2>{l s='Your module is up to date!' mod='ifthenpay'}</h2>
                            {/if}
                        </div>
                    </div>
                </div>
            {else}
                <div id="config_form">
                    {$configForm}
                </div>
            {/if}
        </div>
    </div>
    <div class="tab-pane" id="template_2">
        <div id="log_table">
            {$logTable}
        </div>
        <div id="log_pagination">
            {$logPagination}
        </div>
    </div>
</div>