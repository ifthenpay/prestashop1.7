/*! For license information please see setMbwayPhoneBoOrderCreate12345.js.LICENSE.txt */
!function(e){var t={};function n(o){if(t[o])return t[o].exports;var i=t[o]={i:o,l:!1,exports:{}};return e[o].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var i in e)n.d(o,i,function(t){return e[t]}.bind(null,i));return o},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=18)}([function(e,t,n){"use strict";var o,i=this&&this.__extends||(o=function(e,t){return(o=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(e,t){e.__proto__=t}||function(e,t){for(var n in t)Object.prototype.hasOwnProperty.call(t,n)&&(e[n]=t[n])})(e,t)},function(e,t){function n(){this.constructor=e}o(e,t),e.prototype=null===t?Object.create(t):(n.prototype=t.prototype,new n)});Object.defineProperty(t,"__esModule",{value:!0}),t.HttpService=void 0;var r=function(e){function t(){return null!==e&&e.apply(this,arguments)||this}return i(t,e),t.prototype.get=function(){return $.ajax({url:this.url,type:"GET",dataType:"json"})},t.prototype.post=function(e){return $.ajax({url:this.url,type:"POST",cache:!1,data:e,dataType:"json"})},t}(n(4).RequestService);t.HttpService=r},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.AppEvents=void 0;var o=function(){function e(){}return e.prototype.init=function(){this.appEvents.forEach((function(e){e.setEvent()}))},e}();t.AppEvents=o},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.EventsFactory=void 0;var o=n(3),i=n(5),r=n(6),a=n(7),c=function(){function e(){}return e.build=function(e){switch(e){case"changeEntidade":return new o.ChangeEntidadeEvent;case"chooseNewEntidade":return new i.ChooseNewEntidadeEvent;case"clickPaymentMethodNames":return new r.ClickPaymentMethodNamesEvent;case"clickResendMbwayPhone":return new a.ClickResendMbwayPhoneEvent;default:return null}},e}();t.EventsFactory=c},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.ChangeEntidadeEvent=void 0;var o=n(0),i=function(){function e(){this.containerEntidade=$("#ifthenpayMultibancoEntidade"),this.containerSubEntidade=$("#ifthenpayMultibancoSubentidade"),this.httpService=new o.HttpService("AdminIfthenpayPaymentMethodSetup.php"),this.spinner=$("#appSpinner")}return e.prototype.setEvent=function(){var e=this;this.spinner.parent().insertAfter(this.containerSubEntidade),this.containerEntidade.change((function(t){e.dispatch(t)}))},e.prototype.dispatch=function(e){var t=this;this.spinner.show();var n=$(new DocumentFragment);this.httpService.post({ajax:1,controller:"AdminIfthenpayPaymentMethodSetup",action:"GetSubEntidade",entidade:$(e.target).val(),token:new window.URLSearchParams(window.location.search).get("token")}).then((function(e){t.containerSubEntidade.find("option").remove(),Object.keys(e).forEach((function(t){e[t].SubEntidade.forEach((function(e){n.append($('<option value="'+e+'">'+e+"</option>"))}))})),t.containerSubEntidade.append(n),t.spinner.hide()}))},e}();t.ChangeEntidadeEvent=i},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.RequestService=void 0;var o=function(){function e(e){this.url=e}return e.prototype.setUrl=function(e){return this.url=e,this},e}();t.RequestService=o},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.ChooseNewEntidadeEvent=void 0;var o=n(0),i=function(){function e(){this.chooseEntidadeBtn=$("#chooseNewEntidade"),this.httpService=new o.HttpService("AdminIfthenpayPaymentMethodSetup.php")}return e.prototype.setEvent=function(){var e=this;this.chooseEntidadeBtn.click((function(t){console.log("funciounou chooseNewEntidade"),e.dispatch(t)}))},e.prototype.dispatch=function(e){this.httpService.post({ajax:1,controller:"AdminIfthenpayPaymentMethodSetup",action:"ChooseNewEntidade",paymentMethod:new window.URLSearchParams(window.location.search).get("paymentMethod"),token:new window.URLSearchParams(window.location.search).get("token")}).then((function(e){window.location.replace(e)})).fail((function(e,t,n){console.log(n)}))},e}();t.ChooseNewEntidadeEvent=i},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.ClickPaymentMethodNamesEvent=void 0;var o=function(){function e(){this.content=$("#content"),this.userPaymentMethods=ifthenpayUserPaymentMethods,this.documentFragment=$(document.createDocumentFragment())}return e.prototype.removeIfthenpayOption=function(){var e=$("#payment_module_name").find('option[value="ifthenpay"]');e.length>0&&e.remove()},e.prototype.insertPaymentMethodsName=function(){var e=this;this.removeIfthenpayOption(),Object.keys(this.userPaymentMethods).forEach((function(t){e.documentFragment.append('<option value="ifthenpay">'+(e.userPaymentMethods[t].charAt(0).toUpperCase()+e.userPaymentMethods[t].slice(1))+"</option>")})),$("#payment_module_name").append(this.documentFragment)},e.prototype.setEvent=function(){var e=this;this.content.on("click","a.use_cart.btn.btn-default, #submitAddProduct",(function(t){e.dispatch(t)}))},e.prototype.dispatch=function(e){this.insertPaymentMethodsName()},e}();t.ClickPaymentMethodNamesEvent=o},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.ClickResendMbwayPhoneEvent=void 0;var o=function(){function e(){this.resendPaymentBtn=$("#resendPaymentBtn"),this.ifthenpayMbwayPhoneInput=null}return e.prototype.setEvent=function(){var e=this;this.resendPaymentBtn.click((function(t){e.dispatch(t)}))},e.prototype.dispatch=function(e){e.preventDefault();var t=$(e.target),n=t.attr("href"),o=new URLSearchParams(n);if(this.ifthenpayMbwayPhoneInput=$("#ifthenpayMbwayPhone"),"mbway"===o.get("paymentMethod")&&0===this.ifthenpayMbwayPhoneInput.length)t.parent().append('<div>\n                    <label>Mbway Phone Number<span style="color: red">*</span></label><br/>\n                    <input style="margin-bottom: 10px;" type="text" autocomplete="off" name="ifthenpayMbwayPhone" id="ifthenpayMbwayPhone" />\n                    <div style="color: red" id="ifthenpay_mbway_mobilephone_error"></div>\n                </div>');else if("mbway"===o.get("paymentMethod")&&this.ifthenpayMbwayPhoneInput.length>0)if(this.ifthenpayMbwayPhoneInput.val()){var i=new URL(n);i.searchParams.set("mbwayPhoneAdmin",this.ifthenpayMbwayPhoneInput.val()),console.log(this.ifthenpayMbwayPhoneInput.val()),console.log(i.href),console.log("teste"),window.location.href=i.href}else $("#ifthenpay_mbway_mobilephone_error").text("Mbway phone number is required");else window.location.href=n},e}();t.ClickResendMbwayPhoneEvent=o},,,,,,,,,,,function(e,t,n){e.exports=n(19)},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var o=n(20);$(document).ready((function(){(new o.SetMbwayPhoneBoOrderCreateApp).start()}))},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.SetMbwayPhoneBoOrderCreateApp=void 0;var o=n(21),i=function(){function e(){}return e.prototype.start=function(){(new o.MbwayPhoneBoOrderCreateEvents).init()},e}();t.SetMbwayPhoneBoOrderCreateApp=i},function(e,t,n){"use strict";var o,i=this&&this.__extends||(o=function(e,t){return(o=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(e,t){e.__proto__=t}||function(e,t){for(var n in t)Object.prototype.hasOwnProperty.call(t,n)&&(e[n]=t[n])})(e,t)},function(e,t){function n(){this.constructor=e}o(e,t),e.prototype=null===t?Object.create(t):(n.prototype=t.prototype,new n)});Object.defineProperty(t,"__esModule",{value:!0}),t.MbwayPhoneBoOrderCreateEvents=void 0;var r=n(1),a=n(2),c=function(e){function t(){var t=e.call(this)||this;return t.appEvents=[a.EventsFactory.build("clickResendMbwayPhone")],t}return i(t,e),t}(r.AppEvents);t.MbwayPhoneBoOrderCreateEvents=c}]);