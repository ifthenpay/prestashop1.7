<form method="POST" action="{$action}" id="ifthenpay-mbway-payment-form">
  <div class="field required" id="ifthenpayMbwayPhoneDiv">
    <div id="ifthenpay_mbway_mobilephone_error" class="alert alert-danger" role="alert"></div>
    <div class="control input-container">
        <img src="{$mbwaySvg}" class="icon" alt="mbway logo">
        <input name="ifthenpayMbwayPhone" class="text input-field" type="text" id="ifthenpayMbwayPhone" placeholder="{l s='MBWay Mobile Phone Number' mod='ifthenpay'}">
    </div>
  </div>
</form>