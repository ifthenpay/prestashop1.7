function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

/******/
(function (modules) {
  // webpackBootstrap

  /******/
  // The module cache

  /******/
  var installedModules = {};
  /******/

  /******/
  // The require function

  /******/

  function __webpack_require__(moduleId) {
    /******/

    /******/
    // Check if module is in cache

    /******/
    if (installedModules[moduleId]) {
      /******/
      return installedModules[moduleId].exports;
      /******/
    }
    /******/
    // Create a new module (and put it into the cache)

    /******/


    var module = installedModules[moduleId] = {
      /******/
      i: moduleId,

      /******/
      l: false,

      /******/
      exports: {}
      /******/

    };
    /******/

    /******/
    // Execute the module function

    /******/

    modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
    /******/

    /******/
    // Flag the module as loaded

    /******/

    module.l = true;
    /******/

    /******/
    // Return the exports of the module

    /******/

    return module.exports;
    /******/
  }
  /******/

  /******/

  /******/
  // expose the modules object (__webpack_modules__)

  /******/


  __webpack_require__.m = modules;
  /******/

  /******/
  // expose the module cache

  /******/

  __webpack_require__.c = installedModules;
  /******/

  /******/
  // define getter function for harmony exports

  /******/

  __webpack_require__.d = function (exports, name, getter) {
    /******/
    if (!__webpack_require__.o(exports, name)) {
      /******/
      Object.defineProperty(exports, name, {
        enumerable: true,
        get: getter
      });
      /******/
    }
    /******/

  };
  /******/

  /******/
  // define __esModule on exports

  /******/


  __webpack_require__.r = function (exports) {
    /******/
    if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
      /******/
      Object.defineProperty(exports, Symbol.toStringTag, {
        value: 'Module'
      });
      /******/
    }
    /******/


    Object.defineProperty(exports, '__esModule', {
      value: true
    });
    /******/
  };
  /******/

  /******/
  // create a fake namespace object

  /******/
  // mode & 1: value is a module id, require it

  /******/
  // mode & 2: merge all properties of value into the ns

  /******/
  // mode & 4: return value when already ns object

  /******/
  // mode & 8|1: behave like require

  /******/


  __webpack_require__.t = function (value, mode) {
    /******/
    if (mode & 1) value = __webpack_require__(value);
    /******/

    if (mode & 8) return value;
    /******/

    if (mode & 4 && _typeof(value) === 'object' && value && value.__esModule) return value;
    /******/

    var ns = Object.create(null);
    /******/

    __webpack_require__.r(ns);
    /******/


    Object.defineProperty(ns, 'default', {
      enumerable: true,
      value: value
    });
    /******/

    if (mode & 2 && typeof value != 'string') for (var key in value) {
      __webpack_require__.d(ns, key, function (key) {
        return value[key];
      }.bind(null, key));
    }
    /******/

    return ns;
    /******/
  };
  /******/

  /******/
  // getDefaultExport function for compatibility with non-harmony modules

  /******/


  __webpack_require__.n = function (module) {
    /******/
    var getter = module && module.__esModule ?
    /******/
    function getDefault() {
      return module['default'];
    } :
    /******/
    function getModuleExports() {
      return module;
    };
    /******/

    __webpack_require__.d(getter, 'a', getter);
    /******/


    return getter;
    /******/
  };
  /******/

  /******/
  // Object.prototype.hasOwnProperty.call

  /******/


  __webpack_require__.o = function (object, property) {
    return Object.prototype.hasOwnProperty.call(object, property);
  };
  /******/

  /******/
  // __webpack_public_path__

  /******/


  __webpack_require__.p = "/";
  /******/

  /******/

  /******/
  // Load entry module and return exports

  /******/

  return __webpack_require__(__webpack_require__.s = 0);
  /******/
}
/************************************************************************/

/******/
)({
  /***/
  "./_dev/js/adminConfigPage.ts":
  /*!************************************!*\
    !*** ./_dev/js/adminConfigPage.ts ***!
    \************************************/

  /*! no static exports found */

  /***/
  function _devJsAdminConfigPageTs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    /**
    * 2007-2022 Ifthenpay Lda
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
    *  @copyright 2007-2022 Ifthenpay Lda
    *  @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
    *  @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
    */

    __webpack_require__(
    /*! reflect-metadata */
    "./node_modules/reflect-metadata/Reflect.js");

    var inversify_adminConfigPage_1 = __webpack_require__(
    /*! ./container/inversify.adminConfigPage */
    "./_dev/js/container/inversify.adminConfigPage.ts");

    var AdminConfigPageCreateApp_1 = __webpack_require__(
    /*! ./facades/AdminConfigPageCreateApp */
    "./_dev/js/facades/AdminConfigPageCreateApp.ts");

    $(document).ready(function () {
      if (isMultbanco()) {
        dom_toggleDeadline();
        dom_alignSpinnerWithInput();
      }

      var app = inversify_adminConfigPage_1["default"].get(AdminConfigPageCreateApp_1.AdminConfigPageCreateApp);
      app.start();
    });
    /**
     * show or hide deadline according to multibanco entity
     */

    function dom_toggleDeadline() {
      var domMbExpSelectParent = document.getElementById('ifthenpayMultibancoDeadline').closest('.form-group');
      domMbExpSelectParent.classList.add('hide_element');

      if (typeof domMbExpSelectParent != 'undefined' && domMbExpSelectParent != null) {
        var domEntidade = document.getElementById('ifthenpayMultibancoEntidade');

        if (typeof domEntidade != 'undefined' && domEntidade != null) {
          var value = domEntidade.value;

          if (value == 'MB' || value == 'mb') {
            domMbExpSelectParent.classList.remove('hide_element');
          } else {
            var domMbExpSelect = document.getElementById('ifthenpayMultibancoDeadline');
            domMbExpSelect.disabled = true;
          }
        }
      }
    }
    /**
     * since this bit of dom is being used across other PMs, there is a need to alter its placement using this function in order
     * to place it to the right of the SubEntity input
     */


    function dom_alignSpinnerWithInput() {
      var domSpinner = document.getElementById('appSpinner');

      if (domSpinner.closest('.col-lg-8')) {
        var domMbSubEnt = document.getElementById('ifthenpayMultibancoSubentidade');
        domMbSubEnt.style["float"] = 'left';
        domSpinner.style["float"] = 'left';
        domSpinner.style.margin = '0';
        domSpinner.style.paddingLeft = '10px';
        domSpinner.closest('.col-lg-8').classList.remove('col-lg-8', 'col-lg-offset-3');
        var domHelpBlockParent = domMbSubEnt.closest('.form-group');
        var domHelpBlock = domHelpBlockParent.querySelector('.col-lg-8 .help-block');

        if (domHelpBlock != null) {
          var clearbothDiv = document.createElement("div");
          clearbothDiv.classList.add('clearboth');
          domHelpBlock.before(clearbothDiv);
        }
      }
    }
    /**
     * checks if is in multibanco configuration
     * @returns bool
     */


    function isMultbanco() {
      return document.getElementById('ifthenpayMultibancoEntidade') ? true : false;
    }
    /***/

  },

  /***/
  "./_dev/js/classes/ShowFormGroup.ts":
  /*!******************************************!*\
    !*** ./_dev/js/classes/ShowFormGroup.ts ***!
    \******************************************/

  /*! no static exports found */

  /***/
  function _devJsClassesShowFormGroupTs(module, exports, __webpack_require__) {
    "use strict";
    /**
    * 2007-2022 Ifthenpay Lda
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
    *  @copyright 2007-2022 Ifthenpay Lda
    *  @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
    *  @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
    */

    var __decorate = this && this.__decorate || function (decorators, target, key, desc) {
      var c = arguments.length,
          r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc,
          d;
      if ((typeof Reflect === "undefined" ? "undefined" : _typeof(Reflect)) === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);else for (var i = decorators.length - 1; i >= 0; i--) {
        if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
      }
      return c > 3 && r && Object.defineProperty(target, key, r), r;
    };

    var __metadata = this && this.__metadata || function (k, v) {
      if ((typeof Reflect === "undefined" ? "undefined" : _typeof(Reflect)) === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.ShowFormGroup = void 0;

    var inversify_1 = __webpack_require__(
    /*! inversify */
    "./node_modules/inversify/lib/inversify.js");

    var ShowFormGroup =
    /** @class */
    function () {
      function ShowFormGroup() {
        this.formGroup = $('div.form-group');
      }

      ShowFormGroup.prototype.init = function () {
        this.formGroup.show();
      };

      ShowFormGroup = __decorate([(0, inversify_1.injectable)(), __metadata("design:paramtypes", [])], ShowFormGroup);
      return ShowFormGroup;
    }();

    exports.ShowFormGroup = ShowFormGroup;
    /***/
  },

  /***/
  "./_dev/js/container/inversify.adminConfigPage.ts":
  /*!********************************************************!*\
    !*** ./_dev/js/container/inversify.adminConfigPage.ts ***!
    \********************************************************/

  /*! no static exports found */

  /***/
  function _devJsContainerInversifyAdminConfigPageTs(module, exports, __webpack_require__) {
    "use strict";
    /**
    * 2007-2022 Ifthenpay Lda
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
    *  @copyright 2007-2022 Ifthenpay Lda
    *  @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
    *  @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
    */

    Object.defineProperty(exports, "__esModule", {
      value: true
    });

    var inversify_1 = __webpack_require__(
    /*! inversify */
    "./node_modules/inversify/lib/inversify.js");

    var ShowFormGroup_1 = __webpack_require__(
    /*! ../classes/ShowFormGroup */
    "./_dev/js/classes/ShowFormGroup.ts");

    var AdminConfigPage_1 = __webpack_require__(
    /*! ../events/AdminConfigPage */
    "./_dev/js/events/AdminConfigPage.ts");

    var AdminConfigPageCreateApp_1 = __webpack_require__(
    /*! ../facades/AdminConfigPageCreateApp */
    "./_dev/js/facades/AdminConfigPageCreateApp.ts");

    var HttpService_1 = __webpack_require__(
    /*! ../services/HttpService */
    "./_dev/js/services/HttpService.ts");

    var containerAdminConfigPage = new inversify_1.Container();
    containerAdminConfigPage.bind(HttpService_1.HttpService).toSelf();
    containerAdminConfigPage.bind(AdminConfigPage_1.AdminConfigPage).toSelf();
    containerAdminConfigPage.bind(ShowFormGroup_1.ShowFormGroup).toSelf();
    containerAdminConfigPage.bind(AdminConfigPageCreateApp_1.AdminConfigPageCreateApp).toSelf();
    exports["default"] = containerAdminConfigPage;
    /***/
  },

  /***/
  "./_dev/js/decorators/AppComponent.ts":
  /*!********************************************!*\
    !*** ./_dev/js/decorators/AppComponent.ts ***!
    \********************************************/

  /*! no static exports found */

  /***/
  function _devJsDecoratorsAppComponentTs(module, exports, __webpack_require__) {
    "use strict";

    var __extends = this && this.__extends || function () {
      var _extendStatics = function extendStatics(d, b) {
        _extendStatics = Object.setPrototypeOf || {
          __proto__: []
        } instanceof Array && function (d, b) {
          d.__proto__ = b;
        } || function (d, b) {
          for (var p in b) {
            if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p];
          }
        };

        return _extendStatics(d, b);
      };

      return function (d, b) {
        if (typeof b !== "function" && b !== null) throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");

        _extendStatics(d, b);

        function __() {
          this.constructor = d;
        }

        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
      };
    }();

    var __read = this && this.__read || function (o, n) {
      var m = typeof Symbol === "function" && o[Symbol.iterator];
      if (!m) return o;
      var i = m.call(o),
          r,
          ar = [],
          e;

      try {
        while ((n === void 0 || n-- > 0) && !(r = i.next()).done) {
          ar.push(r.value);
        }
      } catch (error) {
        e = {
          error: error
        };
      } finally {
        try {
          if (r && !r.done && (m = i["return"])) m.call(i);
        } finally {
          if (e) throw e.error;
        }
      }

      return ar;
    };

    var __spreadArray = this && this.__spreadArray || function (to, from, pack) {
      if (pack || arguments.length === 2) for (var i = 0, l = from.length, ar; i < l; i++) {
        if (ar || !(i in from)) {
          if (!ar) ar = Array.prototype.slice.call(from, 0, i);
          ar[i] = from[i];
        }
      }
      return to.concat(ar || Array.prototype.slice.call(from));
    };

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.AppComponent = void 0;
    /**
    * 2007-2022 Ifthenpay Lda
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
    *  @copyright 2007-2022 Ifthenpay Lda
    *  @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
    *  @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
    */

    function AppComponent(params) {
      return function (target) {
        var parentClass = Object.getPrototypeOf(target).prototype;
        parentClass.appEvents = params.pageEvents;
        parentClass.apps = params.apps;
        return (
          /** @class */
          function (_super) {
            __extends(class_1, _super);

            function class_1() {
              var args = [];

              for (var _i = 0; _i < arguments.length; _i++) {
                args[_i] = arguments[_i];
              }

              var _this = _super.apply(this, __spreadArray([], __read(args), false)) || this;

              parentClass.container = _this.container;
              parentClass.createAppEvents();
              parentClass.initApps();
              return _this;
            }

            return class_1;
          }(target)
        );
      };
    }

    exports.AppComponent = AppComponent;
    /***/
  },

  /***/
  "./_dev/js/decorators/Event.ts":
  /*!*************************************!*\
    !*** ./_dev/js/decorators/Event.ts ***!
    \*************************************/

  /*! no static exports found */

  /***/
  function _devJsDecoratorsEventTs(module, exports, __webpack_require__) {
    "use strict";
    /**
    * 2007-2022 Ifthenpay Lda
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
    *  @copyright 2007-2022 Ifthenpay Lda
    *  @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
    *  @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
    */

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.Event = void 0;

    var Event = function Event(type, selector, dynamic) {
      return function (target, propertyKey) {
        if (!Reflect.hasMetadata('events', target.constructor)) {
          Reflect.defineMetadata('events', [], target.constructor);
        }

        var events = Reflect.getMetadata('events', target.constructor);
        events.push({
          type: type,
          element: selector,
          methodName: propertyKey,
          dynamic: dynamic
        });
        Reflect.defineMetadata('events', events, target.constructor);
      };
    };

    exports.Event = Event;
    /***/
  },

  /***/
  "./_dev/js/events/AdminConfigPage.ts":
  /*!*******************************************!*\
    !*** ./_dev/js/events/AdminConfigPage.ts ***!
    \*******************************************/

  /*! no static exports found */

  /***/
  function _devJsEventsAdminConfigPageTs(module, exports, __webpack_require__) {
    "use strict";
    /**
    * 2007-2022 Ifthenpay Lda
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
    *  @copyright 2007-2022 Ifthenpay Lda
    *  @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
    *  @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
    */

    var __extends = this && this.__extends || function () {
      var _extendStatics2 = function extendStatics(d, b) {
        _extendStatics2 = Object.setPrototypeOf || {
          __proto__: []
        } instanceof Array && function (d, b) {
          d.__proto__ = b;
        } || function (d, b) {
          for (var p in b) {
            if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p];
          }
        };

        return _extendStatics2(d, b);
      };

      return function (d, b) {
        if (typeof b !== "function" && b !== null) throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");

        _extendStatics2(d, b);

        function __() {
          this.constructor = d;
        }

        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
      };
    }();

    var __decorate = this && this.__decorate || function (decorators, target, key, desc) {
      var c = arguments.length,
          r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc,
          d;
      if ((typeof Reflect === "undefined" ? "undefined" : _typeof(Reflect)) === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);else for (var i = decorators.length - 1; i >= 0; i--) {
        if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
      }
      return c > 3 && r && Object.defineProperty(target, key, r), r;
    };

    var __metadata = this && this.__metadata || function (k, v) {
      if ((typeof Reflect === "undefined" ? "undefined" : _typeof(Reflect)) === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.AdminConfigPage = void 0;

    var inversify_adminConfigPage_1 = __webpack_require__(
    /*! ../container/inversify.adminConfigPage */
    "./_dev/js/container/inversify.adminConfigPage.ts");

    var Event_1 = __webpack_require__(
    /*! ../decorators/Event */
    "./_dev/js/decorators/Event.ts");

    var HttpService_1 = __webpack_require__(
    /*! ../services/HttpService */
    "./_dev/js/services/HttpService.ts");

    var Page_1 = __webpack_require__(
    /*! ./Page */
    "./_dev/js/events/Page.ts");

    var AdminConfigPage =
    /** @class */
    function (_super) {
      __extends(AdminConfigPage, _super);

      function AdminConfigPage() {
        return _super !== null && _super.apply(this, arguments) || this;
      }

      AdminConfigPage.prototype.changeEntidade = function (event) {
        var _this = this;

        var spinner = $('#appSpinner');
        var containerSubEntidade = $('#ifthenpayMultibancoSubentidade');
        spinner.parent().insertAfter(containerSubEntidade);
        spinner.show();
        this.httpService = inversify_adminConfigPage_1["default"].get(HttpService_1.HttpService);
        this.httpService.setUrl(controllerUrl);
        this.httpService.post({
          ajax: 1,
          controller: 'AdminIfthenpayPaymentMethodSetup',
          action: 'getSubEntidade',
          entidade: $(event.target).val()
        }).then(function (response) {
          containerSubEntidade.find('option').remove();
          Object.keys(response).forEach(function (key) {
            response[key].SubEntidade.forEach(function (subEntidade) {
              _this.documentFragment.append($("<option value=\"".concat(subEntidade, "\">").concat(subEntidade, "</option>")));
            });
          }); // if is selected dynamic references, toggle/show deadline select

          var domMbExpSelectParent = document.getElementById('ifthenpayMultibancoDeadline').closest('.form-group');
          var domMbExpSelect = document.getElementById('ifthenpayMultibancoDeadline');

          if ($(event.target).val() === 'MB' || $(event.target).val() === 'mb') {
            domMbExpSelectParent.classList.remove('hide_element');
            domMbExpSelect.disabled = false;
          } else {
            domMbExpSelectParent.classList.add('hide_element');
            domMbExpSelect.disabled = true;
          }

          containerSubEntidade.append(_this.documentFragment);
          spinner.hide();
        });
      };

      __decorate([(0, Event_1.Event)('change', '#ifthenpayMultibancoEntidade'), __metadata("design:type", Function), __metadata("design:paramtypes", [Object]), __metadata("design:returntype", void 0)], AdminConfigPage.prototype, "changeEntidade", null);

      return AdminConfigPage;
    }(Page_1.Page);

    exports.AdminConfigPage = AdminConfigPage;
    /***/
  },

  /***/
  "./_dev/js/events/Page.ts":
  /*!********************************!*\
    !*** ./_dev/js/events/Page.ts ***!
    \********************************/

  /*! no static exports found */

  /***/
  function _devJsEventsPageTs(module, exports, __webpack_require__) {
    "use strict";
    /**
    * 2007-2022 Ifthenpay Lda
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
    *  @copyright 2007-2022 Ifthenpay Lda
    *  @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
    *  @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
    */

    var __decorate = this && this.__decorate || function (decorators, target, key, desc) {
      var c = arguments.length,
          r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc,
          d;
      if ((typeof Reflect === "undefined" ? "undefined" : _typeof(Reflect)) === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);else for (var i = decorators.length - 1; i >= 0; i--) {
        if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
      }
      return c > 3 && r && Object.defineProperty(target, key, r), r;
    };

    var __metadata = this && this.__metadata || function (k, v) {
      if ((typeof Reflect === "undefined" ? "undefined" : _typeof(Reflect)) === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.Page = void 0;

    var inversify_1 = __webpack_require__(
    /*! inversify */
    "./node_modules/inversify/lib/inversify.js");

    var Page =
    /** @class */
    function () {
      function Page() {
        this.documentFragment = $(document.createDocumentFragment());
        this.ifthenpayUserPaymentMethods = typeof ifthenpayUserPaymentMethods !== 'undefined' ? ifthenpayUserPaymentMethods : [];
      }

      Page.prototype.setEventDefault = function (event, preventDefault) {
        if (preventDefault) {
          event.preventDefault();
        }

        this.eventTarget = $(event.target);
      };

      Page = __decorate([(0, inversify_1.injectable)(), __metadata("design:paramtypes", [])], Page);
      return Page;
    }();

    exports.Page = Page;
    /***/
  },

  /***/
  "./_dev/js/facades/AdminConfigPageCreateApp.ts":
  /*!*****************************************************!*\
    !*** ./_dev/js/facades/AdminConfigPageCreateApp.ts ***!
    \*****************************************************/

  /*! no static exports found */

  /***/
  function _devJsFacadesAdminConfigPageCreateAppTs(module, exports, __webpack_require__) {
    "use strict";
    /**
    * 2007-2022 Ifthenpay Lda
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
    *  @copyright 2007-2022 Ifthenpay Lda
    *  @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
    *  @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
    */

    var __extends = this && this.__extends || function () {
      var _extendStatics3 = function extendStatics(d, b) {
        _extendStatics3 = Object.setPrototypeOf || {
          __proto__: []
        } instanceof Array && function (d, b) {
          d.__proto__ = b;
        } || function (d, b) {
          for (var p in b) {
            if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p];
          }
        };

        return _extendStatics3(d, b);
      };

      return function (d, b) {
        if (typeof b !== "function" && b !== null) throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");

        _extendStatics3(d, b);

        function __() {
          this.constructor = d;
        }

        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
      };
    }();

    var __decorate = this && this.__decorate || function (decorators, target, key, desc) {
      var c = arguments.length,
          r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc,
          d;
      if ((typeof Reflect === "undefined" ? "undefined" : _typeof(Reflect)) === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);else for (var i = decorators.length - 1; i >= 0; i--) {
        if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
      }
      return c > 3 && r && Object.defineProperty(target, key, r), r;
    };

    var __metadata = this && this.__metadata || function (k, v) {
      if ((typeof Reflect === "undefined" ? "undefined" : _typeof(Reflect)) === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.AdminConfigPageCreateApp = void 0;

    var inversify_1 = __webpack_require__(
    /*! inversify */
    "./node_modules/inversify/lib/inversify.js");

    var ShowFormGroup_1 = __webpack_require__(
    /*! ../classes/ShowFormGroup */
    "./_dev/js/classes/ShowFormGroup.ts");

    var inversify_adminConfigPage_1 = __webpack_require__(
    /*! ../container/inversify.adminConfigPage */
    "./_dev/js/container/inversify.adminConfigPage.ts");

    var AppComponent_1 = __webpack_require__(
    /*! ../decorators/AppComponent */
    "./_dev/js/decorators/AppComponent.ts");

    var AdminConfigPage_1 = __webpack_require__(
    /*! ../events/AdminConfigPage */
    "./_dev/js/events/AdminConfigPage.ts");

    var MainApp_1 = __webpack_require__(
    /*! ./MainApp */
    "./_dev/js/facades/MainApp.ts");

    var AdminConfigPageCreateApp =
    /** @class */
    function (_super) {
      __extends(AdminConfigPageCreateApp, _super);

      function AdminConfigPageCreateApp() {
        var _this = _super.call(this) || this;

        _this.container = inversify_adminConfigPage_1["default"];
        return _this;
      }

      AdminConfigPageCreateApp.prototype.start = function () {};

      AdminConfigPageCreateApp = __decorate([(0, inversify_1.injectable)(), (0, AppComponent_1.AppComponent)({
        pageEvents: [AdminConfigPage_1.AdminConfigPage],
        apps: [ShowFormGroup_1.ShowFormGroup]
      }), __metadata("design:paramtypes", [])], AdminConfigPageCreateApp);
      return AdminConfigPageCreateApp;
    }(MainApp_1.MainApp);

    exports.AdminConfigPageCreateApp = AdminConfigPageCreateApp;
    /***/
  },

  /***/
  "./_dev/js/facades/MainApp.ts":
  /*!************************************!*\
    !*** ./_dev/js/facades/MainApp.ts ***!
    \************************************/

  /*! no static exports found */

  /***/
  function _devJsFacadesMainAppTs(module, exports, __webpack_require__) {
    "use strict";
    /**
    * 2007-2022 Ifthenpay Lda
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
    *  @copyright 2007-2022 Ifthenpay Lda
    *  @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
    *  @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
    */

    var __decorate = this && this.__decorate || function (decorators, target, key, desc) {
      var c = arguments.length,
          r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc,
          d;
      if ((typeof Reflect === "undefined" ? "undefined" : _typeof(Reflect)) === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);else for (var i = decorators.length - 1; i >= 0; i--) {
        if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
      }
      return c > 3 && r && Object.defineProperty(target, key, r), r;
    };

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.MainApp = void 0;

    var inversify_1 = __webpack_require__(
    /*! inversify */
    "./node_modules/inversify/lib/inversify.js");

    var MainApp =
    /** @class */
    function () {
      function MainApp() {}

      MainApp.prototype.createAppEvents = function () {
        var _this = this;

        this.appEvents.forEach(function (page) {
          var events = Reflect.getMetadata('events', page);
          events.forEach(function (event) {
            if (event.dynamic) {
              $(event.element).on(event.type, event.dynamic, function (domEvent) {
                _this.container.get(page)[event.methodName](domEvent);
              });
            } else {
              $(event.element)[event.type](function (domEvent) {
                _this.container.get(page)[event.methodName](domEvent);
              });
            }
          });
        });
      };

      MainApp.prototype.initApps = function () {
        var _this = this;

        if (this.apps) {
          this.apps.forEach(function (app) {
            var aplication = _this.container.get(app);

            aplication.init();
          });
        }
      };

      MainApp = __decorate([(0, inversify_1.injectable)()], MainApp);
      return MainApp;
    }();

    exports.MainApp = MainApp;
    /***/
  },

  /***/
  "./_dev/js/services/HttpService.ts":
  /*!*****************************************!*\
    !*** ./_dev/js/services/HttpService.ts ***!
    \*****************************************/

  /*! no static exports found */

  /***/
  function _devJsServicesHttpServiceTs(module, exports, __webpack_require__) {
    "use strict";
    /**
    * 2007-2022 Ifthenpay Lda
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
    *  @copyright 2007-2022 Ifthenpay Lda
    *  @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
    *  @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
    */

    var __decorate = this && this.__decorate || function (decorators, target, key, desc) {
      var c = arguments.length,
          r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc,
          d;
      if ((typeof Reflect === "undefined" ? "undefined" : _typeof(Reflect)) === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);else for (var i = decorators.length - 1; i >= 0; i--) {
        if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
      }
      return c > 3 && r && Object.defineProperty(target, key, r), r;
    };

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.HttpService = void 0;

    var inversify_1 = __webpack_require__(
    /*! inversify */
    "./node_modules/inversify/lib/inversify.js");

    var HttpService =
    /** @class */
    function () {
      function HttpService() {}

      HttpService.prototype.get = function () {
        return $.ajax({
          url: this.url,
          type: 'GET',
          dataType: 'json'
        });
      };

      HttpService.prototype.post = function (data) {
        return $.ajax({
          url: this.url,
          type: 'POST',
          cache: false,
          data: data,
          dataType: 'json'
        });
      };

      HttpService.prototype.setUrl = function (url) {
        this.url = url;
      };

      HttpService = __decorate([(0, inversify_1.injectable)()], HttpService);
      return HttpService;
    }();

    exports.HttpService = HttpService;
    /***/
  },

  /***/
  "./_dev/scss/ifthenpayAdminOrder.scss":
  /*!********************************************!*\
    !*** ./_dev/scss/ifthenpayAdminOrder.scss ***!
    \********************************************/

  /*! no static exports found */

  /***/
  function _devScssIfthenpayAdminOrderScss(module, exports) {// removed by extract-text-webpack-plugin

    /***/
  },

  /***/
  "./_dev/scss/ifthenpayConfig.scss":
  /*!****************************************!*\
    !*** ./_dev/scss/ifthenpayConfig.scss ***!
    \****************************************/

  /*! no static exports found */

  /***/
  function _devScssIfthenpayConfigScss(module, exports) {// removed by extract-text-webpack-plugin

    /***/
  },

  /***/
  "./_dev/scss/ifthenpayConfirmPage.scss":
  /*!*********************************************!*\
    !*** ./_dev/scss/ifthenpayConfirmPage.scss ***!
    \*********************************************/

  /*! no static exports found */

  /***/
  function _devScssIfthenpayConfirmPageScss(module, exports) {// removed by extract-text-webpack-plugin

    /***/
  },

  /***/
  "./_dev/scss/ifthenpayOrderDetail.scss":
  /*!*********************************************!*\
    !*** ./_dev/scss/ifthenpayOrderDetail.scss ***!
    \*********************************************/

  /*! no static exports found */

  /***/
  function _devScssIfthenpayOrderDetailScss(module, exports) {// removed by extract-text-webpack-plugin

    /***/
  },

  /***/
  "./_dev/scss/ifthenpayPaymentMethodSetup.scss":
  /*!****************************************************!*\
    !*** ./_dev/scss/ifthenpayPaymentMethodSetup.scss ***!
    \****************************************************/

  /*! no static exports found */

  /***/
  function _devScssIfthenpayPaymentMethodSetupScss(module, exports) {// removed by extract-text-webpack-plugin

    /***/
  },

  /***/
  "./_dev/scss/paymentOptions.scss":
  /*!***************************************!*\
    !*** ./_dev/scss/paymentOptions.scss ***!
    \***************************************/

  /*! no static exports found */

  /***/
  function _devScssPaymentOptionsScss(module, exports) {// removed by extract-text-webpack-plugin

    /***/
  },

  /***/
  "./node_modules/inversify/lib/annotation/decorator_utils.js":
  /*!******************************************************************!*\
    !*** ./node_modules/inversify/lib/annotation/decorator_utils.js ***!
    \******************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibAnnotationDecorator_utilsJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.tagProperty = exports.tagParameter = exports.decorate = void 0;

    var ERROR_MSGS = __webpack_require__(
    /*! ../constants/error_msgs */
    "./node_modules/inversify/lib/constants/error_msgs.js");

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    function tagParameter(annotationTarget, propertyName, parameterIndex, metadata) {
      var metadataKey = METADATA_KEY.TAGGED;

      _tagParameterOrProperty(metadataKey, annotationTarget, propertyName, metadata, parameterIndex);
    }

    exports.tagParameter = tagParameter;

    function tagProperty(annotationTarget, propertyName, metadata) {
      var metadataKey = METADATA_KEY.TAGGED_PROP;

      _tagParameterOrProperty(metadataKey, annotationTarget.constructor, propertyName, metadata);
    }

    exports.tagProperty = tagProperty;

    function _tagParameterOrProperty(metadataKey, annotationTarget, propertyName, metadata, parameterIndex) {
      var paramsOrPropertiesMetadata = {};
      var isParameterDecorator = typeof parameterIndex === "number";
      var key = parameterIndex !== undefined && isParameterDecorator ? parameterIndex.toString() : propertyName;

      if (isParameterDecorator && propertyName !== undefined) {
        throw new Error(ERROR_MSGS.INVALID_DECORATOR_OPERATION);
      }

      if (Reflect.hasOwnMetadata(metadataKey, annotationTarget)) {
        paramsOrPropertiesMetadata = Reflect.getMetadata(metadataKey, annotationTarget);
      }

      var paramOrPropertyMetadata = paramsOrPropertiesMetadata[key];

      if (!Array.isArray(paramOrPropertyMetadata)) {
        paramOrPropertyMetadata = [];
      } else {
        for (var _i = 0, paramOrPropertyMetadata_1 = paramOrPropertyMetadata; _i < paramOrPropertyMetadata_1.length; _i++) {
          var m = paramOrPropertyMetadata_1[_i];

          if (m.key === metadata.key) {
            throw new Error(ERROR_MSGS.DUPLICATED_METADATA + " " + m.key.toString());
          }
        }
      }

      paramOrPropertyMetadata.push(metadata);
      paramsOrPropertiesMetadata[key] = paramOrPropertyMetadata;
      Reflect.defineMetadata(metadataKey, paramsOrPropertiesMetadata, annotationTarget);
    }

    function _decorate(decorators, target) {
      Reflect.decorate(decorators, target);
    }

    function _param(paramIndex, decorator) {
      return function (target, key) {
        decorator(target, key, paramIndex);
      };
    }

    function decorate(decorator, target, parameterIndex) {
      if (typeof parameterIndex === "number") {
        _decorate([_param(parameterIndex, decorator)], target);
      } else if (typeof parameterIndex === "string") {
        Reflect.decorate([decorator], target, parameterIndex);
      } else {
        _decorate([decorator], target);
      }
    }

    exports.decorate = decorate;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/annotation/inject.js":
  /*!*********************************************************!*\
    !*** ./node_modules/inversify/lib/annotation/inject.js ***!
    \*********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibAnnotationInjectJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.inject = exports.LazyServiceIdentifer = void 0;

    var error_msgs_1 = __webpack_require__(
    /*! ../constants/error_msgs */
    "./node_modules/inversify/lib/constants/error_msgs.js");

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    var metadata_1 = __webpack_require__(
    /*! ../planning/metadata */
    "./node_modules/inversify/lib/planning/metadata.js");

    var decorator_utils_1 = __webpack_require__(
    /*! ./decorator_utils */
    "./node_modules/inversify/lib/annotation/decorator_utils.js");

    var LazyServiceIdentifer = function () {
      function LazyServiceIdentifer(cb) {
        this._cb = cb;
      }

      LazyServiceIdentifer.prototype.unwrap = function () {
        return this._cb();
      };

      return LazyServiceIdentifer;
    }();

    exports.LazyServiceIdentifer = LazyServiceIdentifer;

    function inject(serviceIdentifier) {
      return function (target, targetKey, index) {
        if (serviceIdentifier === undefined) {
          throw new Error(error_msgs_1.UNDEFINED_INJECT_ANNOTATION(target.name));
        }

        var metadata = new metadata_1.Metadata(METADATA_KEY.INJECT_TAG, serviceIdentifier);

        if (typeof index === "number") {
          decorator_utils_1.tagParameter(target, targetKey, index, metadata);
        } else {
          decorator_utils_1.tagProperty(target, targetKey, metadata);
        }
      };
    }

    exports.inject = inject;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/annotation/injectable.js":
  /*!*************************************************************!*\
    !*** ./node_modules/inversify/lib/annotation/injectable.js ***!
    \*************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibAnnotationInjectableJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.injectable = void 0;

    var ERRORS_MSGS = __webpack_require__(
    /*! ../constants/error_msgs */
    "./node_modules/inversify/lib/constants/error_msgs.js");

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    function injectable() {
      return function (target) {
        if (Reflect.hasOwnMetadata(METADATA_KEY.PARAM_TYPES, target)) {
          throw new Error(ERRORS_MSGS.DUPLICATED_INJECTABLE_DECORATOR);
        }

        var types = Reflect.getMetadata(METADATA_KEY.DESIGN_PARAM_TYPES, target) || [];
        Reflect.defineMetadata(METADATA_KEY.PARAM_TYPES, types, target);
        return target;
      };
    }

    exports.injectable = injectable;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/annotation/multi_inject.js":
  /*!***************************************************************!*\
    !*** ./node_modules/inversify/lib/annotation/multi_inject.js ***!
    \***************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibAnnotationMulti_injectJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.multiInject = void 0;

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    var metadata_1 = __webpack_require__(
    /*! ../planning/metadata */
    "./node_modules/inversify/lib/planning/metadata.js");

    var decorator_utils_1 = __webpack_require__(
    /*! ./decorator_utils */
    "./node_modules/inversify/lib/annotation/decorator_utils.js");

    function multiInject(serviceIdentifier) {
      return function (target, targetKey, index) {
        var metadata = new metadata_1.Metadata(METADATA_KEY.MULTI_INJECT_TAG, serviceIdentifier);

        if (typeof index === "number") {
          decorator_utils_1.tagParameter(target, targetKey, index, metadata);
        } else {
          decorator_utils_1.tagProperty(target, targetKey, metadata);
        }
      };
    }

    exports.multiInject = multiInject;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/annotation/named.js":
  /*!********************************************************!*\
    !*** ./node_modules/inversify/lib/annotation/named.js ***!
    \********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibAnnotationNamedJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.named = void 0;

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    var metadata_1 = __webpack_require__(
    /*! ../planning/metadata */
    "./node_modules/inversify/lib/planning/metadata.js");

    var decorator_utils_1 = __webpack_require__(
    /*! ./decorator_utils */
    "./node_modules/inversify/lib/annotation/decorator_utils.js");

    function named(name) {
      return function (target, targetKey, index) {
        var metadata = new metadata_1.Metadata(METADATA_KEY.NAMED_TAG, name);

        if (typeof index === "number") {
          decorator_utils_1.tagParameter(target, targetKey, index, metadata);
        } else {
          decorator_utils_1.tagProperty(target, targetKey, metadata);
        }
      };
    }

    exports.named = named;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/annotation/optional.js":
  /*!***********************************************************!*\
    !*** ./node_modules/inversify/lib/annotation/optional.js ***!
    \***********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibAnnotationOptionalJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.optional = void 0;

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    var metadata_1 = __webpack_require__(
    /*! ../planning/metadata */
    "./node_modules/inversify/lib/planning/metadata.js");

    var decorator_utils_1 = __webpack_require__(
    /*! ./decorator_utils */
    "./node_modules/inversify/lib/annotation/decorator_utils.js");

    function optional() {
      return function (target, targetKey, index) {
        var metadata = new metadata_1.Metadata(METADATA_KEY.OPTIONAL_TAG, true);

        if (typeof index === "number") {
          decorator_utils_1.tagParameter(target, targetKey, index, metadata);
        } else {
          decorator_utils_1.tagProperty(target, targetKey, metadata);
        }
      };
    }

    exports.optional = optional;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/annotation/post_construct.js":
  /*!*****************************************************************!*\
    !*** ./node_modules/inversify/lib/annotation/post_construct.js ***!
    \*****************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibAnnotationPost_constructJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.postConstruct = void 0;

    var ERRORS_MSGS = __webpack_require__(
    /*! ../constants/error_msgs */
    "./node_modules/inversify/lib/constants/error_msgs.js");

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    var metadata_1 = __webpack_require__(
    /*! ../planning/metadata */
    "./node_modules/inversify/lib/planning/metadata.js");

    function postConstruct() {
      return function (target, propertyKey, descriptor) {
        var metadata = new metadata_1.Metadata(METADATA_KEY.POST_CONSTRUCT, propertyKey);

        if (Reflect.hasOwnMetadata(METADATA_KEY.POST_CONSTRUCT, target.constructor)) {
          throw new Error(ERRORS_MSGS.MULTIPLE_POST_CONSTRUCT_METHODS);
        }

        Reflect.defineMetadata(METADATA_KEY.POST_CONSTRUCT, metadata, target.constructor);
      };
    }

    exports.postConstruct = postConstruct;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/annotation/tagged.js":
  /*!*********************************************************!*\
    !*** ./node_modules/inversify/lib/annotation/tagged.js ***!
    \*********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibAnnotationTaggedJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.tagged = void 0;

    var metadata_1 = __webpack_require__(
    /*! ../planning/metadata */
    "./node_modules/inversify/lib/planning/metadata.js");

    var decorator_utils_1 = __webpack_require__(
    /*! ./decorator_utils */
    "./node_modules/inversify/lib/annotation/decorator_utils.js");

    function tagged(metadataKey, metadataValue) {
      return function (target, targetKey, index) {
        var metadata = new metadata_1.Metadata(metadataKey, metadataValue);

        if (typeof index === "number") {
          decorator_utils_1.tagParameter(target, targetKey, index, metadata);
        } else {
          decorator_utils_1.tagProperty(target, targetKey, metadata);
        }
      };
    }

    exports.tagged = tagged;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/annotation/target_name.js":
  /*!**************************************************************!*\
    !*** ./node_modules/inversify/lib/annotation/target_name.js ***!
    \**************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibAnnotationTarget_nameJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.targetName = void 0;

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    var metadata_1 = __webpack_require__(
    /*! ../planning/metadata */
    "./node_modules/inversify/lib/planning/metadata.js");

    var decorator_utils_1 = __webpack_require__(
    /*! ./decorator_utils */
    "./node_modules/inversify/lib/annotation/decorator_utils.js");

    function targetName(name) {
      return function (target, targetKey, index) {
        var metadata = new metadata_1.Metadata(METADATA_KEY.NAME_TAG, name);
        decorator_utils_1.tagParameter(target, targetKey, index, metadata);
      };
    }

    exports.targetName = targetName;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/annotation/unmanaged.js":
  /*!************************************************************!*\
    !*** ./node_modules/inversify/lib/annotation/unmanaged.js ***!
    \************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibAnnotationUnmanagedJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.unmanaged = void 0;

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    var metadata_1 = __webpack_require__(
    /*! ../planning/metadata */
    "./node_modules/inversify/lib/planning/metadata.js");

    var decorator_utils_1 = __webpack_require__(
    /*! ./decorator_utils */
    "./node_modules/inversify/lib/annotation/decorator_utils.js");

    function unmanaged() {
      return function (target, targetKey, index) {
        var metadata = new metadata_1.Metadata(METADATA_KEY.UNMANAGED_TAG, true);
        decorator_utils_1.tagParameter(target, targetKey, index, metadata);
      };
    }

    exports.unmanaged = unmanaged;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/bindings/binding.js":
  /*!********************************************************!*\
    !*** ./node_modules/inversify/lib/bindings/binding.js ***!
    \********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibBindingsBindingJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.Binding = void 0;

    var literal_types_1 = __webpack_require__(
    /*! ../constants/literal_types */
    "./node_modules/inversify/lib/constants/literal_types.js");

    var id_1 = __webpack_require__(
    /*! ../utils/id */
    "./node_modules/inversify/lib/utils/id.js");

    var Binding = function () {
      function Binding(serviceIdentifier, scope) {
        this.id = id_1.id();
        this.activated = false;
        this.serviceIdentifier = serviceIdentifier;
        this.scope = scope;
        this.type = literal_types_1.BindingTypeEnum.Invalid;

        this.constraint = function (request) {
          return true;
        };

        this.implementationType = null;
        this.cache = null;
        this.factory = null;
        this.provider = null;
        this.onActivation = null;
        this.dynamicValue = null;
      }

      Binding.prototype.clone = function () {
        var clone = new Binding(this.serviceIdentifier, this.scope);
        clone.activated = clone.scope === literal_types_1.BindingScopeEnum.Singleton ? this.activated : false;
        clone.implementationType = this.implementationType;
        clone.dynamicValue = this.dynamicValue;
        clone.scope = this.scope;
        clone.type = this.type;
        clone.factory = this.factory;
        clone.provider = this.provider;
        clone.constraint = this.constraint;
        clone.onActivation = this.onActivation;
        clone.cache = this.cache;
        return clone;
      };

      return Binding;
    }();

    exports.Binding = Binding;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/bindings/binding_count.js":
  /*!**************************************************************!*\
    !*** ./node_modules/inversify/lib/bindings/binding_count.js ***!
    \**************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibBindingsBinding_countJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.BindingCount = void 0;
    var BindingCount = {
      MultipleBindingsAvailable: 2,
      NoBindingsAvailable: 0,
      OnlyOneBindingAvailable: 1
    };
    exports.BindingCount = BindingCount;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/constants/error_msgs.js":
  /*!************************************************************!*\
    !*** ./node_modules/inversify/lib/constants/error_msgs.js ***!
    \************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibConstantsError_msgsJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.STACK_OVERFLOW = exports.CIRCULAR_DEPENDENCY_IN_FACTORY = exports.POST_CONSTRUCT_ERROR = exports.MULTIPLE_POST_CONSTRUCT_METHODS = exports.CONTAINER_OPTIONS_INVALID_SKIP_BASE_CHECK = exports.CONTAINER_OPTIONS_INVALID_AUTO_BIND_INJECTABLE = exports.CONTAINER_OPTIONS_INVALID_DEFAULT_SCOPE = exports.CONTAINER_OPTIONS_MUST_BE_AN_OBJECT = exports.ARGUMENTS_LENGTH_MISMATCH = exports.INVALID_DECORATOR_OPERATION = exports.INVALID_TO_SELF_VALUE = exports.INVALID_FUNCTION_BINDING = exports.INVALID_MIDDLEWARE_RETURN = exports.NO_MORE_SNAPSHOTS_AVAILABLE = exports.INVALID_BINDING_TYPE = exports.NOT_IMPLEMENTED = exports.CIRCULAR_DEPENDENCY = exports.UNDEFINED_INJECT_ANNOTATION = exports.MISSING_INJECT_ANNOTATION = exports.MISSING_INJECTABLE_ANNOTATION = exports.NOT_REGISTERED = exports.CANNOT_UNBIND = exports.AMBIGUOUS_MATCH = exports.KEY_NOT_FOUND = exports.NULL_ARGUMENT = exports.DUPLICATED_METADATA = exports.DUPLICATED_INJECTABLE_DECORATOR = void 0;
    exports.DUPLICATED_INJECTABLE_DECORATOR = "Cannot apply @injectable decorator multiple times.";
    exports.DUPLICATED_METADATA = "Metadata key was used more than once in a parameter:";
    exports.NULL_ARGUMENT = "NULL argument";
    exports.KEY_NOT_FOUND = "Key Not Found";
    exports.AMBIGUOUS_MATCH = "Ambiguous match found for serviceIdentifier:";
    exports.CANNOT_UNBIND = "Could not unbind serviceIdentifier:";
    exports.NOT_REGISTERED = "No matching bindings found for serviceIdentifier:";
    exports.MISSING_INJECTABLE_ANNOTATION = "Missing required @injectable annotation in:";
    exports.MISSING_INJECT_ANNOTATION = "Missing required @inject or @multiInject annotation in:";

    var UNDEFINED_INJECT_ANNOTATION = function UNDEFINED_INJECT_ANNOTATION(name) {
      return "@inject called with undefined this could mean that the class " + name + " has " + "a circular dependency problem. You can use a LazyServiceIdentifer to  " + "overcome this limitation.";
    };

    exports.UNDEFINED_INJECT_ANNOTATION = UNDEFINED_INJECT_ANNOTATION;
    exports.CIRCULAR_DEPENDENCY = "Circular dependency found:";
    exports.NOT_IMPLEMENTED = "Sorry, this feature is not fully implemented yet.";
    exports.INVALID_BINDING_TYPE = "Invalid binding type:";
    exports.NO_MORE_SNAPSHOTS_AVAILABLE = "No snapshot available to restore.";
    exports.INVALID_MIDDLEWARE_RETURN = "Invalid return type in middleware. Middleware must return!";
    exports.INVALID_FUNCTION_BINDING = "Value provided to function binding must be a function!";
    exports.INVALID_TO_SELF_VALUE = "The toSelf function can only be applied when a constructor is " + "used as service identifier";
    exports.INVALID_DECORATOR_OPERATION = "The @inject @multiInject @tagged and @named decorators " + "must be applied to the parameters of a class constructor or a class property.";

    var ARGUMENTS_LENGTH_MISMATCH = function ARGUMENTS_LENGTH_MISMATCH() {
      var values = [];

      for (var _i = 0; _i < arguments.length; _i++) {
        values[_i] = arguments[_i];
      }

      return "The number of constructor arguments in the derived class " + (values[0] + " must be >= than the number of constructor arguments of its base class.");
    };

    exports.ARGUMENTS_LENGTH_MISMATCH = ARGUMENTS_LENGTH_MISMATCH;
    exports.CONTAINER_OPTIONS_MUST_BE_AN_OBJECT = "Invalid Container constructor argument. Container options " + "must be an object.";
    exports.CONTAINER_OPTIONS_INVALID_DEFAULT_SCOPE = "Invalid Container option. Default scope must " + "be a string ('singleton' or 'transient').";
    exports.CONTAINER_OPTIONS_INVALID_AUTO_BIND_INJECTABLE = "Invalid Container option. Auto bind injectable must " + "be a boolean";
    exports.CONTAINER_OPTIONS_INVALID_SKIP_BASE_CHECK = "Invalid Container option. Skip base check must " + "be a boolean";
    exports.MULTIPLE_POST_CONSTRUCT_METHODS = "Cannot apply @postConstruct decorator multiple times in the same class";

    var POST_CONSTRUCT_ERROR = function POST_CONSTRUCT_ERROR() {
      var values = [];

      for (var _i = 0; _i < arguments.length; _i++) {
        values[_i] = arguments[_i];
      }

      return "@postConstruct error in class " + values[0] + ": " + values[1];
    };

    exports.POST_CONSTRUCT_ERROR = POST_CONSTRUCT_ERROR;

    var CIRCULAR_DEPENDENCY_IN_FACTORY = function CIRCULAR_DEPENDENCY_IN_FACTORY() {
      var values = [];

      for (var _i = 0; _i < arguments.length; _i++) {
        values[_i] = arguments[_i];
      }

      return "It looks like there is a circular dependency " + ("in one of the '" + values[0] + "' bindings. Please investigate bindings with") + ("service identifier '" + values[1] + "'.");
    };

    exports.CIRCULAR_DEPENDENCY_IN_FACTORY = CIRCULAR_DEPENDENCY_IN_FACTORY;
    exports.STACK_OVERFLOW = "Maximum call stack size exceeded";
    /***/
  },

  /***/
  "./node_modules/inversify/lib/constants/literal_types.js":
  /*!***************************************************************!*\
    !*** ./node_modules/inversify/lib/constants/literal_types.js ***!
    \***************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibConstantsLiteral_typesJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.TargetTypeEnum = exports.BindingTypeEnum = exports.BindingScopeEnum = void 0;
    var BindingScopeEnum = {
      Request: "Request",
      Singleton: "Singleton",
      Transient: "Transient"
    };
    exports.BindingScopeEnum = BindingScopeEnum;
    var BindingTypeEnum = {
      ConstantValue: "ConstantValue",
      Constructor: "Constructor",
      DynamicValue: "DynamicValue",
      Factory: "Factory",
      Function: "Function",
      Instance: "Instance",
      Invalid: "Invalid",
      Provider: "Provider"
    };
    exports.BindingTypeEnum = BindingTypeEnum;
    var TargetTypeEnum = {
      ClassProperty: "ClassProperty",
      ConstructorArgument: "ConstructorArgument",
      Variable: "Variable"
    };
    exports.TargetTypeEnum = TargetTypeEnum;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/constants/metadata_keys.js":
  /*!***************************************************************!*\
    !*** ./node_modules/inversify/lib/constants/metadata_keys.js ***!
    \***************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibConstantsMetadata_keysJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.NON_CUSTOM_TAG_KEYS = exports.POST_CONSTRUCT = exports.DESIGN_PARAM_TYPES = exports.PARAM_TYPES = exports.TAGGED_PROP = exports.TAGGED = exports.MULTI_INJECT_TAG = exports.INJECT_TAG = exports.OPTIONAL_TAG = exports.UNMANAGED_TAG = exports.NAME_TAG = exports.NAMED_TAG = void 0;
    exports.NAMED_TAG = "named";
    exports.NAME_TAG = "name";
    exports.UNMANAGED_TAG = "unmanaged";
    exports.OPTIONAL_TAG = "optional";
    exports.INJECT_TAG = "inject";
    exports.MULTI_INJECT_TAG = "multi_inject";
    exports.TAGGED = "inversify:tagged";
    exports.TAGGED_PROP = "inversify:tagged_props";
    exports.PARAM_TYPES = "inversify:paramtypes";
    exports.DESIGN_PARAM_TYPES = "design:paramtypes";
    exports.POST_CONSTRUCT = "post_construct";

    function getNonCustomTagKeys() {
      return [exports.INJECT_TAG, exports.MULTI_INJECT_TAG, exports.NAME_TAG, exports.UNMANAGED_TAG, exports.NAMED_TAG, exports.OPTIONAL_TAG];
    }

    exports.NON_CUSTOM_TAG_KEYS = getNonCustomTagKeys();
    /***/
  },

  /***/
  "./node_modules/inversify/lib/container/container.js":
  /*!***********************************************************!*\
    !*** ./node_modules/inversify/lib/container/container.js ***!
    \***********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibContainerContainerJs(module, exports, __webpack_require__) {
    "use strict";

    var __awaiter = this && this.__awaiter || function (thisArg, _arguments, P, generator) {
      function adopt(value) {
        return value instanceof P ? value : new P(function (resolve) {
          resolve(value);
        });
      }

      return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) {
          try {
            step(generator.next(value));
          } catch (e) {
            reject(e);
          }
        }

        function rejected(value) {
          try {
            step(generator["throw"](value));
          } catch (e) {
            reject(e);
          }
        }

        function step(result) {
          result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
        }

        step((generator = generator.apply(thisArg, _arguments || [])).next());
      });
    };

    var __generator = this && this.__generator || function (thisArg, body) {
      var _ = {
        label: 0,
        sent: function sent() {
          if (t[0] & 1) throw t[1];
          return t[1];
        },
        trys: [],
        ops: []
      },
          f,
          y,
          t,
          g;
      return g = {
        next: verb(0),
        "throw": verb(1),
        "return": verb(2)
      }, typeof Symbol === "function" && (g[Symbol.iterator] = function () {
        return this;
      }), g;

      function verb(n) {
        return function (v) {
          return step([n, v]);
        };
      }

      function step(op) {
        if (f) throw new TypeError("Generator is already executing.");

        while (_) {
          try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];

            switch (op[0]) {
              case 0:
              case 1:
                t = op;
                break;

              case 4:
                _.label++;
                return {
                  value: op[1],
                  done: false
                };

              case 5:
                _.label++;
                y = op[1];
                op = [0];
                continue;

              case 7:
                op = _.ops.pop();

                _.trys.pop();

                continue;

              default:
                if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) {
                  _ = 0;
                  continue;
                }

                if (op[0] === 3 && (!t || op[1] > t[0] && op[1] < t[3])) {
                  _.label = op[1];
                  break;
                }

                if (op[0] === 6 && _.label < t[1]) {
                  _.label = t[1];
                  t = op;
                  break;
                }

                if (t && _.label < t[2]) {
                  _.label = t[2];

                  _.ops.push(op);

                  break;
                }

                if (t[2]) _.ops.pop();

                _.trys.pop();

                continue;
            }

            op = body.call(thisArg, _);
          } catch (e) {
            op = [6, e];
            y = 0;
          } finally {
            f = t = 0;
          }
        }

        if (op[0] & 5) throw op[1];
        return {
          value: op[0] ? op[1] : void 0,
          done: true
        };
      }
    };

    var __spreadArray = this && this.__spreadArray || function (to, from) {
      for (var i = 0, il = from.length, j = to.length; i < il; i++, j++) {
        to[j] = from[i];
      }

      return to;
    };

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.Container = void 0;

    var binding_1 = __webpack_require__(
    /*! ../bindings/binding */
    "./node_modules/inversify/lib/bindings/binding.js");

    var ERROR_MSGS = __webpack_require__(
    /*! ../constants/error_msgs */
    "./node_modules/inversify/lib/constants/error_msgs.js");

    var literal_types_1 = __webpack_require__(
    /*! ../constants/literal_types */
    "./node_modules/inversify/lib/constants/literal_types.js");

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    var metadata_reader_1 = __webpack_require__(
    /*! ../planning/metadata_reader */
    "./node_modules/inversify/lib/planning/metadata_reader.js");

    var planner_1 = __webpack_require__(
    /*! ../planning/planner */
    "./node_modules/inversify/lib/planning/planner.js");

    var resolver_1 = __webpack_require__(
    /*! ../resolution/resolver */
    "./node_modules/inversify/lib/resolution/resolver.js");

    var binding_to_syntax_1 = __webpack_require__(
    /*! ../syntax/binding_to_syntax */
    "./node_modules/inversify/lib/syntax/binding_to_syntax.js");

    var id_1 = __webpack_require__(
    /*! ../utils/id */
    "./node_modules/inversify/lib/utils/id.js");

    var serialization_1 = __webpack_require__(
    /*! ../utils/serialization */
    "./node_modules/inversify/lib/utils/serialization.js");

    var container_snapshot_1 = __webpack_require__(
    /*! ./container_snapshot */
    "./node_modules/inversify/lib/container/container_snapshot.js");

    var lookup_1 = __webpack_require__(
    /*! ./lookup */
    "./node_modules/inversify/lib/container/lookup.js");

    var Container = function () {
      function Container(containerOptions) {
        this._appliedMiddleware = [];
        var options = containerOptions || {};

        if (_typeof(options) !== "object") {
          throw new Error("" + ERROR_MSGS.CONTAINER_OPTIONS_MUST_BE_AN_OBJECT);
        }

        if (options.defaultScope === undefined) {
          options.defaultScope = literal_types_1.BindingScopeEnum.Transient;
        } else if (options.defaultScope !== literal_types_1.BindingScopeEnum.Singleton && options.defaultScope !== literal_types_1.BindingScopeEnum.Transient && options.defaultScope !== literal_types_1.BindingScopeEnum.Request) {
          throw new Error("" + ERROR_MSGS.CONTAINER_OPTIONS_INVALID_DEFAULT_SCOPE);
        }

        if (options.autoBindInjectable === undefined) {
          options.autoBindInjectable = false;
        } else if (typeof options.autoBindInjectable !== "boolean") {
          throw new Error("" + ERROR_MSGS.CONTAINER_OPTIONS_INVALID_AUTO_BIND_INJECTABLE);
        }

        if (options.skipBaseClassChecks === undefined) {
          options.skipBaseClassChecks = false;
        } else if (typeof options.skipBaseClassChecks !== "boolean") {
          throw new Error("" + ERROR_MSGS.CONTAINER_OPTIONS_INVALID_SKIP_BASE_CHECK);
        }

        this.options = {
          autoBindInjectable: options.autoBindInjectable,
          defaultScope: options.defaultScope,
          skipBaseClassChecks: options.skipBaseClassChecks
        };
        this.id = id_1.id();
        this._bindingDictionary = new lookup_1.Lookup();
        this._snapshots = [];
        this._middleware = null;
        this.parent = null;
        this._metadataReader = new metadata_reader_1.MetadataReader();
      }

      Container.merge = function (container1, container2) {
        var container3 = [];

        for (var _i = 2; _i < arguments.length; _i++) {
          container3[_i - 2] = arguments[_i];
        }

        var container = new Container();

        var targetContainers = __spreadArray([container1, container2], container3).map(function (targetContainer) {
          return planner_1.getBindingDictionary(targetContainer);
        });

        var bindingDictionary = planner_1.getBindingDictionary(container);

        function copyDictionary(origin, destination) {
          origin.traverse(function (key, value) {
            value.forEach(function (binding) {
              destination.add(binding.serviceIdentifier, binding.clone());
            });
          });
        }

        targetContainers.forEach(function (targetBindingDictionary) {
          copyDictionary(targetBindingDictionary, bindingDictionary);
        });
        return container;
      };

      Container.prototype.load = function () {
        var modules = [];

        for (var _i = 0; _i < arguments.length; _i++) {
          modules[_i] = arguments[_i];
        }

        var getHelpers = this._getContainerModuleHelpersFactory();

        for (var _a = 0, modules_1 = modules; _a < modules_1.length; _a++) {
          var currentModule = modules_1[_a];
          var containerModuleHelpers = getHelpers(currentModule.id);
          currentModule.registry(containerModuleHelpers.bindFunction, containerModuleHelpers.unbindFunction, containerModuleHelpers.isboundFunction, containerModuleHelpers.rebindFunction);
        }
      };

      Container.prototype.loadAsync = function () {
        var modules = [];

        for (var _i = 0; _i < arguments.length; _i++) {
          modules[_i] = arguments[_i];
        }

        return __awaiter(this, void 0, void 0, function () {
          var getHelpers, _a, modules_2, currentModule, containerModuleHelpers;

          return __generator(this, function (_b) {
            switch (_b.label) {
              case 0:
                getHelpers = this._getContainerModuleHelpersFactory();
                _a = 0, modules_2 = modules;
                _b.label = 1;

              case 1:
                if (!(_a < modules_2.length)) return [3, 4];
                currentModule = modules_2[_a];
                containerModuleHelpers = getHelpers(currentModule.id);
                return [4, currentModule.registry(containerModuleHelpers.bindFunction, containerModuleHelpers.unbindFunction, containerModuleHelpers.isboundFunction, containerModuleHelpers.rebindFunction)];

              case 2:
                _b.sent();

                _b.label = 3;

              case 3:
                _a++;
                return [3, 1];

              case 4:
                return [2];
            }
          });
        });
      };

      Container.prototype.unload = function () {
        var _this = this;

        var modules = [];

        for (var _i = 0; _i < arguments.length; _i++) {
          modules[_i] = arguments[_i];
        }

        var conditionFactory = function conditionFactory(expected) {
          return function (item) {
            return item.moduleId === expected;
          };
        };

        modules.forEach(function (module) {
          var condition = conditionFactory(module.id);

          _this._bindingDictionary.removeByCondition(condition);
        });
      };

      Container.prototype.bind = function (serviceIdentifier) {
        var scope = this.options.defaultScope || literal_types_1.BindingScopeEnum.Transient;
        var binding = new binding_1.Binding(serviceIdentifier, scope);

        this._bindingDictionary.add(serviceIdentifier, binding);

        return new binding_to_syntax_1.BindingToSyntax(binding);
      };

      Container.prototype.rebind = function (serviceIdentifier) {
        this.unbind(serviceIdentifier);
        return this.bind(serviceIdentifier);
      };

      Container.prototype.unbind = function (serviceIdentifier) {
        try {
          this._bindingDictionary.remove(serviceIdentifier);
        } catch (e) {
          throw new Error(ERROR_MSGS.CANNOT_UNBIND + " " + serialization_1.getServiceIdentifierAsString(serviceIdentifier));
        }
      };

      Container.prototype.unbindAll = function () {
        this._bindingDictionary = new lookup_1.Lookup();
      };

      Container.prototype.isBound = function (serviceIdentifier) {
        var bound = this._bindingDictionary.hasKey(serviceIdentifier);

        if (!bound && this.parent) {
          bound = this.parent.isBound(serviceIdentifier);
        }

        return bound;
      };

      Container.prototype.isBoundNamed = function (serviceIdentifier, named) {
        return this.isBoundTagged(serviceIdentifier, METADATA_KEY.NAMED_TAG, named);
      };

      Container.prototype.isBoundTagged = function (serviceIdentifier, key, value) {
        var bound = false;

        if (this._bindingDictionary.hasKey(serviceIdentifier)) {
          var bindings = this._bindingDictionary.get(serviceIdentifier);

          var request_1 = planner_1.createMockRequest(this, serviceIdentifier, key, value);
          bound = bindings.some(function (b) {
            return b.constraint(request_1);
          });
        }

        if (!bound && this.parent) {
          bound = this.parent.isBoundTagged(serviceIdentifier, key, value);
        }

        return bound;
      };

      Container.prototype.snapshot = function () {
        this._snapshots.push(container_snapshot_1.ContainerSnapshot.of(this._bindingDictionary.clone(), this._middleware));
      };

      Container.prototype.restore = function () {
        var snapshot = this._snapshots.pop();

        if (snapshot === undefined) {
          throw new Error(ERROR_MSGS.NO_MORE_SNAPSHOTS_AVAILABLE);
        }

        this._bindingDictionary = snapshot.bindings;
        this._middleware = snapshot.middleware;
      };

      Container.prototype.createChild = function (containerOptions) {
        var child = new Container(containerOptions || this.options);
        child.parent = this;
        return child;
      };

      Container.prototype.applyMiddleware = function () {
        var middlewares = [];

        for (var _i = 0; _i < arguments.length; _i++) {
          middlewares[_i] = arguments[_i];
        }

        this._appliedMiddleware = this._appliedMiddleware.concat(middlewares);
        var initial = this._middleware ? this._middleware : this._planAndResolve();
        this._middleware = middlewares.reduce(function (prev, curr) {
          return curr(prev);
        }, initial);
      };

      Container.prototype.applyCustomMetadataReader = function (metadataReader) {
        this._metadataReader = metadataReader;
      };

      Container.prototype.get = function (serviceIdentifier) {
        return this._get(false, false, literal_types_1.TargetTypeEnum.Variable, serviceIdentifier);
      };

      Container.prototype.getTagged = function (serviceIdentifier, key, value) {
        return this._get(false, false, literal_types_1.TargetTypeEnum.Variable, serviceIdentifier, key, value);
      };

      Container.prototype.getNamed = function (serviceIdentifier, named) {
        return this.getTagged(serviceIdentifier, METADATA_KEY.NAMED_TAG, named);
      };

      Container.prototype.getAll = function (serviceIdentifier) {
        return this._get(true, true, literal_types_1.TargetTypeEnum.Variable, serviceIdentifier);
      };

      Container.prototype.getAllTagged = function (serviceIdentifier, key, value) {
        return this._get(false, true, literal_types_1.TargetTypeEnum.Variable, serviceIdentifier, key, value);
      };

      Container.prototype.getAllNamed = function (serviceIdentifier, named) {
        return this.getAllTagged(serviceIdentifier, METADATA_KEY.NAMED_TAG, named);
      };

      Container.prototype.resolve = function (constructorFunction) {
        var tempContainer = this.createChild();
        tempContainer.bind(constructorFunction).toSelf();

        this._appliedMiddleware.forEach(function (m) {
          tempContainer.applyMiddleware(m);
        });

        return tempContainer.get(constructorFunction);
      };

      Container.prototype._getContainerModuleHelpersFactory = function () {
        var _this = this;

        var setModuleId = function setModuleId(bindingToSyntax, moduleId) {
          bindingToSyntax._binding.moduleId = moduleId;
        };

        var getBindFunction = function getBindFunction(moduleId) {
          return function (serviceIdentifier) {
            var _bind = _this.bind.bind(_this);

            var bindingToSyntax = _bind(serviceIdentifier);

            setModuleId(bindingToSyntax, moduleId);
            return bindingToSyntax;
          };
        };

        var getUnbindFunction = function getUnbindFunction(moduleId) {
          return function (serviceIdentifier) {
            var _unbind = _this.unbind.bind(_this);

            _unbind(serviceIdentifier);
          };
        };

        var getIsboundFunction = function getIsboundFunction(moduleId) {
          return function (serviceIdentifier) {
            var _isBound = _this.isBound.bind(_this);

            return _isBound(serviceIdentifier);
          };
        };

        var getRebindFunction = function getRebindFunction(moduleId) {
          return function (serviceIdentifier) {
            var _rebind = _this.rebind.bind(_this);

            var bindingToSyntax = _rebind(serviceIdentifier);

            setModuleId(bindingToSyntax, moduleId);
            return bindingToSyntax;
          };
        };

        return function (mId) {
          return {
            bindFunction: getBindFunction(mId),
            isboundFunction: getIsboundFunction(mId),
            rebindFunction: getRebindFunction(mId),
            unbindFunction: getUnbindFunction(mId)
          };
        };
      };

      Container.prototype._get = function (avoidConstraints, isMultiInject, targetType, serviceIdentifier, key, value) {
        var result = null;
        var defaultArgs = {
          avoidConstraints: avoidConstraints,
          contextInterceptor: function contextInterceptor(context) {
            return context;
          },
          isMultiInject: isMultiInject,
          key: key,
          serviceIdentifier: serviceIdentifier,
          targetType: targetType,
          value: value
        };

        if (this._middleware) {
          result = this._middleware(defaultArgs);

          if (result === undefined || result === null) {
            throw new Error(ERROR_MSGS.INVALID_MIDDLEWARE_RETURN);
          }
        } else {
          result = this._planAndResolve()(defaultArgs);
        }

        return result;
      };

      Container.prototype._planAndResolve = function () {
        var _this = this;

        return function (args) {
          var context = planner_1.plan(_this._metadataReader, _this, args.isMultiInject, args.targetType, args.serviceIdentifier, args.key, args.value, args.avoidConstraints);
          context = args.contextInterceptor(context);
          var result = resolver_1.resolve(context);
          return result;
        };
      };

      return Container;
    }();

    exports.Container = Container;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/container/container_module.js":
  /*!******************************************************************!*\
    !*** ./node_modules/inversify/lib/container/container_module.js ***!
    \******************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibContainerContainer_moduleJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.AsyncContainerModule = exports.ContainerModule = void 0;

    var id_1 = __webpack_require__(
    /*! ../utils/id */
    "./node_modules/inversify/lib/utils/id.js");

    var ContainerModule = function () {
      function ContainerModule(registry) {
        this.id = id_1.id();
        this.registry = registry;
      }

      return ContainerModule;
    }();

    exports.ContainerModule = ContainerModule;

    var AsyncContainerModule = function () {
      function AsyncContainerModule(registry) {
        this.id = id_1.id();
        this.registry = registry;
      }

      return AsyncContainerModule;
    }();

    exports.AsyncContainerModule = AsyncContainerModule;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/container/container_snapshot.js":
  /*!********************************************************************!*\
    !*** ./node_modules/inversify/lib/container/container_snapshot.js ***!
    \********************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibContainerContainer_snapshotJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.ContainerSnapshot = void 0;

    var ContainerSnapshot = function () {
      function ContainerSnapshot() {}

      ContainerSnapshot.of = function (bindings, middleware) {
        var snapshot = new ContainerSnapshot();
        snapshot.bindings = bindings;
        snapshot.middleware = middleware;
        return snapshot;
      };

      return ContainerSnapshot;
    }();

    exports.ContainerSnapshot = ContainerSnapshot;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/container/lookup.js":
  /*!********************************************************!*\
    !*** ./node_modules/inversify/lib/container/lookup.js ***!
    \********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibContainerLookupJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.Lookup = void 0;

    var ERROR_MSGS = __webpack_require__(
    /*! ../constants/error_msgs */
    "./node_modules/inversify/lib/constants/error_msgs.js");

    var Lookup = function () {
      function Lookup() {
        this._map = new Map();
      }

      Lookup.prototype.getMap = function () {
        return this._map;
      };

      Lookup.prototype.add = function (serviceIdentifier, value) {
        if (serviceIdentifier === null || serviceIdentifier === undefined) {
          throw new Error(ERROR_MSGS.NULL_ARGUMENT);
        }

        if (value === null || value === undefined) {
          throw new Error(ERROR_MSGS.NULL_ARGUMENT);
        }

        var entry = this._map.get(serviceIdentifier);

        if (entry !== undefined) {
          entry.push(value);

          this._map.set(serviceIdentifier, entry);
        } else {
          this._map.set(serviceIdentifier, [value]);
        }
      };

      Lookup.prototype.get = function (serviceIdentifier) {
        if (serviceIdentifier === null || serviceIdentifier === undefined) {
          throw new Error(ERROR_MSGS.NULL_ARGUMENT);
        }

        var entry = this._map.get(serviceIdentifier);

        if (entry !== undefined) {
          return entry;
        } else {
          throw new Error(ERROR_MSGS.KEY_NOT_FOUND);
        }
      };

      Lookup.prototype.remove = function (serviceIdentifier) {
        if (serviceIdentifier === null || serviceIdentifier === undefined) {
          throw new Error(ERROR_MSGS.NULL_ARGUMENT);
        }

        if (!this._map["delete"](serviceIdentifier)) {
          throw new Error(ERROR_MSGS.KEY_NOT_FOUND);
        }
      };

      Lookup.prototype.removeByCondition = function (condition) {
        var _this = this;

        this._map.forEach(function (entries, key) {
          var updatedEntries = entries.filter(function (entry) {
            return !condition(entry);
          });

          if (updatedEntries.length > 0) {
            _this._map.set(key, updatedEntries);
          } else {
            _this._map["delete"](key);
          }
        });
      };

      Lookup.prototype.hasKey = function (serviceIdentifier) {
        if (serviceIdentifier === null || serviceIdentifier === undefined) {
          throw new Error(ERROR_MSGS.NULL_ARGUMENT);
        }

        return this._map.has(serviceIdentifier);
      };

      Lookup.prototype.clone = function () {
        var copy = new Lookup();

        this._map.forEach(function (value, key) {
          value.forEach(function (b) {
            return copy.add(key, b.clone());
          });
        });

        return copy;
      };

      Lookup.prototype.traverse = function (func) {
        this._map.forEach(function (value, key) {
          func(key, value);
        });
      };

      return Lookup;
    }();

    exports.Lookup = Lookup;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/inversify.js":
  /*!*************************************************!*\
    !*** ./node_modules/inversify/lib/inversify.js ***!
    \*************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibInversifyJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.multiBindToService = exports.getServiceIdentifierAsString = exports.typeConstraint = exports.namedConstraint = exports.taggedConstraint = exports.traverseAncerstors = exports.decorate = exports.id = exports.MetadataReader = exports.postConstruct = exports.targetName = exports.multiInject = exports.unmanaged = exports.optional = exports.LazyServiceIdentifer = exports.inject = exports.named = exports.tagged = exports.injectable = exports.ContainerModule = exports.AsyncContainerModule = exports.TargetTypeEnum = exports.BindingTypeEnum = exports.BindingScopeEnum = exports.Container = exports.METADATA_KEY = void 0;

    var keys = __webpack_require__(
    /*! ./constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    exports.METADATA_KEY = keys;

    var container_1 = __webpack_require__(
    /*! ./container/container */
    "./node_modules/inversify/lib/container/container.js");

    Object.defineProperty(exports, "Container", {
      enumerable: true,
      get: function get() {
        return container_1.Container;
      }
    });

    var literal_types_1 = __webpack_require__(
    /*! ./constants/literal_types */
    "./node_modules/inversify/lib/constants/literal_types.js");

    Object.defineProperty(exports, "BindingScopeEnum", {
      enumerable: true,
      get: function get() {
        return literal_types_1.BindingScopeEnum;
      }
    });
    Object.defineProperty(exports, "BindingTypeEnum", {
      enumerable: true,
      get: function get() {
        return literal_types_1.BindingTypeEnum;
      }
    });
    Object.defineProperty(exports, "TargetTypeEnum", {
      enumerable: true,
      get: function get() {
        return literal_types_1.TargetTypeEnum;
      }
    });

    var container_module_1 = __webpack_require__(
    /*! ./container/container_module */
    "./node_modules/inversify/lib/container/container_module.js");

    Object.defineProperty(exports, "AsyncContainerModule", {
      enumerable: true,
      get: function get() {
        return container_module_1.AsyncContainerModule;
      }
    });
    Object.defineProperty(exports, "ContainerModule", {
      enumerable: true,
      get: function get() {
        return container_module_1.ContainerModule;
      }
    });

    var injectable_1 = __webpack_require__(
    /*! ./annotation/injectable */
    "./node_modules/inversify/lib/annotation/injectable.js");

    Object.defineProperty(exports, "injectable", {
      enumerable: true,
      get: function get() {
        return injectable_1.injectable;
      }
    });

    var tagged_1 = __webpack_require__(
    /*! ./annotation/tagged */
    "./node_modules/inversify/lib/annotation/tagged.js");

    Object.defineProperty(exports, "tagged", {
      enumerable: true,
      get: function get() {
        return tagged_1.tagged;
      }
    });

    var named_1 = __webpack_require__(
    /*! ./annotation/named */
    "./node_modules/inversify/lib/annotation/named.js");

    Object.defineProperty(exports, "named", {
      enumerable: true,
      get: function get() {
        return named_1.named;
      }
    });

    var inject_1 = __webpack_require__(
    /*! ./annotation/inject */
    "./node_modules/inversify/lib/annotation/inject.js");

    Object.defineProperty(exports, "inject", {
      enumerable: true,
      get: function get() {
        return inject_1.inject;
      }
    });
    Object.defineProperty(exports, "LazyServiceIdentifer", {
      enumerable: true,
      get: function get() {
        return inject_1.LazyServiceIdentifer;
      }
    });

    var optional_1 = __webpack_require__(
    /*! ./annotation/optional */
    "./node_modules/inversify/lib/annotation/optional.js");

    Object.defineProperty(exports, "optional", {
      enumerable: true,
      get: function get() {
        return optional_1.optional;
      }
    });

    var unmanaged_1 = __webpack_require__(
    /*! ./annotation/unmanaged */
    "./node_modules/inversify/lib/annotation/unmanaged.js");

    Object.defineProperty(exports, "unmanaged", {
      enumerable: true,
      get: function get() {
        return unmanaged_1.unmanaged;
      }
    });

    var multi_inject_1 = __webpack_require__(
    /*! ./annotation/multi_inject */
    "./node_modules/inversify/lib/annotation/multi_inject.js");

    Object.defineProperty(exports, "multiInject", {
      enumerable: true,
      get: function get() {
        return multi_inject_1.multiInject;
      }
    });

    var target_name_1 = __webpack_require__(
    /*! ./annotation/target_name */
    "./node_modules/inversify/lib/annotation/target_name.js");

    Object.defineProperty(exports, "targetName", {
      enumerable: true,
      get: function get() {
        return target_name_1.targetName;
      }
    });

    var post_construct_1 = __webpack_require__(
    /*! ./annotation/post_construct */
    "./node_modules/inversify/lib/annotation/post_construct.js");

    Object.defineProperty(exports, "postConstruct", {
      enumerable: true,
      get: function get() {
        return post_construct_1.postConstruct;
      }
    });

    var metadata_reader_1 = __webpack_require__(
    /*! ./planning/metadata_reader */
    "./node_modules/inversify/lib/planning/metadata_reader.js");

    Object.defineProperty(exports, "MetadataReader", {
      enumerable: true,
      get: function get() {
        return metadata_reader_1.MetadataReader;
      }
    });

    var id_1 = __webpack_require__(
    /*! ./utils/id */
    "./node_modules/inversify/lib/utils/id.js");

    Object.defineProperty(exports, "id", {
      enumerable: true,
      get: function get() {
        return id_1.id;
      }
    });

    var decorator_utils_1 = __webpack_require__(
    /*! ./annotation/decorator_utils */
    "./node_modules/inversify/lib/annotation/decorator_utils.js");

    Object.defineProperty(exports, "decorate", {
      enumerable: true,
      get: function get() {
        return decorator_utils_1.decorate;
      }
    });

    var constraint_helpers_1 = __webpack_require__(
    /*! ./syntax/constraint_helpers */
    "./node_modules/inversify/lib/syntax/constraint_helpers.js");

    Object.defineProperty(exports, "traverseAncerstors", {
      enumerable: true,
      get: function get() {
        return constraint_helpers_1.traverseAncerstors;
      }
    });
    Object.defineProperty(exports, "taggedConstraint", {
      enumerable: true,
      get: function get() {
        return constraint_helpers_1.taggedConstraint;
      }
    });
    Object.defineProperty(exports, "namedConstraint", {
      enumerable: true,
      get: function get() {
        return constraint_helpers_1.namedConstraint;
      }
    });
    Object.defineProperty(exports, "typeConstraint", {
      enumerable: true,
      get: function get() {
        return constraint_helpers_1.typeConstraint;
      }
    });

    var serialization_1 = __webpack_require__(
    /*! ./utils/serialization */
    "./node_modules/inversify/lib/utils/serialization.js");

    Object.defineProperty(exports, "getServiceIdentifierAsString", {
      enumerable: true,
      get: function get() {
        return serialization_1.getServiceIdentifierAsString;
      }
    });

    var binding_utils_1 = __webpack_require__(
    /*! ./utils/binding_utils */
    "./node_modules/inversify/lib/utils/binding_utils.js");

    Object.defineProperty(exports, "multiBindToService", {
      enumerable: true,
      get: function get() {
        return binding_utils_1.multiBindToService;
      }
    });
    /***/
  },

  /***/
  "./node_modules/inversify/lib/planning/context.js":
  /*!********************************************************!*\
    !*** ./node_modules/inversify/lib/planning/context.js ***!
    \********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibPlanningContextJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.Context = void 0;

    var id_1 = __webpack_require__(
    /*! ../utils/id */
    "./node_modules/inversify/lib/utils/id.js");

    var Context = function () {
      function Context(container) {
        this.id = id_1.id();
        this.container = container;
      }

      Context.prototype.addPlan = function (plan) {
        this.plan = plan;
      };

      Context.prototype.setCurrentRequest = function (currentRequest) {
        this.currentRequest = currentRequest;
      };

      return Context;
    }();

    exports.Context = Context;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/planning/metadata.js":
  /*!*********************************************************!*\
    !*** ./node_modules/inversify/lib/planning/metadata.js ***!
    \*********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibPlanningMetadataJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.Metadata = void 0;

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    var Metadata = function () {
      function Metadata(key, value) {
        this.key = key;
        this.value = value;
      }

      Metadata.prototype.toString = function () {
        if (this.key === METADATA_KEY.NAMED_TAG) {
          return "named: " + this.value.toString() + " ";
        } else {
          return "tagged: { key:" + this.key.toString() + ", value: " + this.value + " }";
        }
      };

      return Metadata;
    }();

    exports.Metadata = Metadata;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/planning/metadata_reader.js":
  /*!****************************************************************!*\
    !*** ./node_modules/inversify/lib/planning/metadata_reader.js ***!
    \****************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibPlanningMetadata_readerJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.MetadataReader = void 0;

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    var MetadataReader = function () {
      function MetadataReader() {}

      MetadataReader.prototype.getConstructorMetadata = function (constructorFunc) {
        var compilerGeneratedMetadata = Reflect.getMetadata(METADATA_KEY.PARAM_TYPES, constructorFunc);
        var userGeneratedMetadata = Reflect.getMetadata(METADATA_KEY.TAGGED, constructorFunc);
        return {
          compilerGeneratedMetadata: compilerGeneratedMetadata,
          userGeneratedMetadata: userGeneratedMetadata || {}
        };
      };

      MetadataReader.prototype.getPropertiesMetadata = function (constructorFunc) {
        var userGeneratedMetadata = Reflect.getMetadata(METADATA_KEY.TAGGED_PROP, constructorFunc) || [];
        return userGeneratedMetadata;
      };

      return MetadataReader;
    }();

    exports.MetadataReader = MetadataReader;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/planning/plan.js":
  /*!*****************************************************!*\
    !*** ./node_modules/inversify/lib/planning/plan.js ***!
    \*****************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibPlanningPlanJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.Plan = void 0;

    var Plan = function () {
      function Plan(parentContext, rootRequest) {
        this.parentContext = parentContext;
        this.rootRequest = rootRequest;
      }

      return Plan;
    }();

    exports.Plan = Plan;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/planning/planner.js":
  /*!********************************************************!*\
    !*** ./node_modules/inversify/lib/planning/planner.js ***!
    \********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibPlanningPlannerJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.getBindingDictionary = exports.createMockRequest = exports.plan = void 0;

    var binding_count_1 = __webpack_require__(
    /*! ../bindings/binding_count */
    "./node_modules/inversify/lib/bindings/binding_count.js");

    var ERROR_MSGS = __webpack_require__(
    /*! ../constants/error_msgs */
    "./node_modules/inversify/lib/constants/error_msgs.js");

    var literal_types_1 = __webpack_require__(
    /*! ../constants/literal_types */
    "./node_modules/inversify/lib/constants/literal_types.js");

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    var exceptions_1 = __webpack_require__(
    /*! ../utils/exceptions */
    "./node_modules/inversify/lib/utils/exceptions.js");

    var serialization_1 = __webpack_require__(
    /*! ../utils/serialization */
    "./node_modules/inversify/lib/utils/serialization.js");

    var context_1 = __webpack_require__(
    /*! ./context */
    "./node_modules/inversify/lib/planning/context.js");

    var metadata_1 = __webpack_require__(
    /*! ./metadata */
    "./node_modules/inversify/lib/planning/metadata.js");

    var plan_1 = __webpack_require__(
    /*! ./plan */
    "./node_modules/inversify/lib/planning/plan.js");

    var reflection_utils_1 = __webpack_require__(
    /*! ./reflection_utils */
    "./node_modules/inversify/lib/planning/reflection_utils.js");

    var request_1 = __webpack_require__(
    /*! ./request */
    "./node_modules/inversify/lib/planning/request.js");

    var target_1 = __webpack_require__(
    /*! ./target */
    "./node_modules/inversify/lib/planning/target.js");

    function getBindingDictionary(cntnr) {
      return cntnr._bindingDictionary;
    }

    exports.getBindingDictionary = getBindingDictionary;

    function _createTarget(isMultiInject, targetType, serviceIdentifier, name, key, value) {
      var metadataKey = isMultiInject ? METADATA_KEY.MULTI_INJECT_TAG : METADATA_KEY.INJECT_TAG;
      var injectMetadata = new metadata_1.Metadata(metadataKey, serviceIdentifier);
      var target = new target_1.Target(targetType, name, serviceIdentifier, injectMetadata);

      if (key !== undefined) {
        var tagMetadata = new metadata_1.Metadata(key, value);
        target.metadata.push(tagMetadata);
      }

      return target;
    }

    function _getActiveBindings(metadataReader, avoidConstraints, context, parentRequest, target) {
      var bindings = getBindings(context.container, target.serviceIdentifier);
      var activeBindings = [];

      if (bindings.length === binding_count_1.BindingCount.NoBindingsAvailable && context.container.options.autoBindInjectable && typeof target.serviceIdentifier === "function" && metadataReader.getConstructorMetadata(target.serviceIdentifier).compilerGeneratedMetadata) {
        context.container.bind(target.serviceIdentifier).toSelf();
        bindings = getBindings(context.container, target.serviceIdentifier);
      }

      if (!avoidConstraints) {
        activeBindings = bindings.filter(function (binding) {
          var request = new request_1.Request(binding.serviceIdentifier, context, parentRequest, binding, target);
          return binding.constraint(request);
        });
      } else {
        activeBindings = bindings;
      }

      _validateActiveBindingCount(target.serviceIdentifier, activeBindings, target, context.container);

      return activeBindings;
    }

    function _validateActiveBindingCount(serviceIdentifier, bindings, target, container) {
      switch (bindings.length) {
        case binding_count_1.BindingCount.NoBindingsAvailable:
          if (target.isOptional()) {
            return bindings;
          } else {
            var serviceIdentifierString = serialization_1.getServiceIdentifierAsString(serviceIdentifier);
            var msg = ERROR_MSGS.NOT_REGISTERED;
            msg += serialization_1.listMetadataForTarget(serviceIdentifierString, target);
            msg += serialization_1.listRegisteredBindingsForServiceIdentifier(container, serviceIdentifierString, getBindings);
            throw new Error(msg);
          }

        case binding_count_1.BindingCount.OnlyOneBindingAvailable:
          if (!target.isArray()) {
            return bindings;
          }

        case binding_count_1.BindingCount.MultipleBindingsAvailable:
        default:
          if (!target.isArray()) {
            var serviceIdentifierString = serialization_1.getServiceIdentifierAsString(serviceIdentifier);
            var msg = ERROR_MSGS.AMBIGUOUS_MATCH + " " + serviceIdentifierString;
            msg += serialization_1.listRegisteredBindingsForServiceIdentifier(container, serviceIdentifierString, getBindings);
            throw new Error(msg);
          } else {
            return bindings;
          }

      }
    }

    function _createSubRequests(metadataReader, avoidConstraints, serviceIdentifier, context, parentRequest, target) {
      var activeBindings;
      var childRequest;

      if (parentRequest === null) {
        activeBindings = _getActiveBindings(metadataReader, avoidConstraints, context, null, target);
        childRequest = new request_1.Request(serviceIdentifier, context, null, activeBindings, target);
        var thePlan = new plan_1.Plan(context, childRequest);
        context.addPlan(thePlan);
      } else {
        activeBindings = _getActiveBindings(metadataReader, avoidConstraints, context, parentRequest, target);
        childRequest = parentRequest.addChildRequest(target.serviceIdentifier, activeBindings, target);
      }

      activeBindings.forEach(function (binding) {
        var subChildRequest = null;

        if (target.isArray()) {
          subChildRequest = childRequest.addChildRequest(binding.serviceIdentifier, binding, target);
        } else {
          if (binding.cache) {
            return;
          }

          subChildRequest = childRequest;
        }

        if (binding.type === literal_types_1.BindingTypeEnum.Instance && binding.implementationType !== null) {
          var dependencies = reflection_utils_1.getDependencies(metadataReader, binding.implementationType);

          if (!context.container.options.skipBaseClassChecks) {
            var baseClassDependencyCount = reflection_utils_1.getBaseClassDependencyCount(metadataReader, binding.implementationType);

            if (dependencies.length < baseClassDependencyCount) {
              var error = ERROR_MSGS.ARGUMENTS_LENGTH_MISMATCH(reflection_utils_1.getFunctionName(binding.implementationType));
              throw new Error(error);
            }
          }

          dependencies.forEach(function (dependency) {
            _createSubRequests(metadataReader, false, dependency.serviceIdentifier, context, subChildRequest, dependency);
          });
        }
      });
    }

    function getBindings(container, serviceIdentifier) {
      var bindings = [];
      var bindingDictionary = getBindingDictionary(container);

      if (bindingDictionary.hasKey(serviceIdentifier)) {
        bindings = bindingDictionary.get(serviceIdentifier);
      } else if (container.parent !== null) {
        bindings = getBindings(container.parent, serviceIdentifier);
      }

      return bindings;
    }

    function plan(metadataReader, container, isMultiInject, targetType, serviceIdentifier, key, value, avoidConstraints) {
      if (avoidConstraints === void 0) {
        avoidConstraints = false;
      }

      var context = new context_1.Context(container);

      var target = _createTarget(isMultiInject, targetType, serviceIdentifier, "", key, value);

      try {
        _createSubRequests(metadataReader, avoidConstraints, serviceIdentifier, context, null, target);

        return context;
      } catch (error) {
        if (exceptions_1.isStackOverflowExeption(error)) {
          if (context.plan) {
            serialization_1.circularDependencyToException(context.plan.rootRequest);
          }
        }

        throw error;
      }
    }

    exports.plan = plan;

    function createMockRequest(container, serviceIdentifier, key, value) {
      var target = new target_1.Target(literal_types_1.TargetTypeEnum.Variable, "", serviceIdentifier, new metadata_1.Metadata(key, value));
      var context = new context_1.Context(container);
      var request = new request_1.Request(serviceIdentifier, context, null, [], target);
      return request;
    }

    exports.createMockRequest = createMockRequest;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/planning/queryable_string.js":
  /*!*****************************************************************!*\
    !*** ./node_modules/inversify/lib/planning/queryable_string.js ***!
    \*****************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibPlanningQueryable_stringJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.QueryableString = void 0;

    var QueryableString = function () {
      function QueryableString(str) {
        this.str = str;
      }

      QueryableString.prototype.startsWith = function (searchString) {
        return this.str.indexOf(searchString) === 0;
      };

      QueryableString.prototype.endsWith = function (searchString) {
        var reverseString = "";
        var reverseSearchString = searchString.split("").reverse().join("");
        reverseString = this.str.split("").reverse().join("");
        return this.startsWith.call({
          str: reverseString
        }, reverseSearchString);
      };

      QueryableString.prototype.contains = function (searchString) {
        return this.str.indexOf(searchString) !== -1;
      };

      QueryableString.prototype.equals = function (compareString) {
        return this.str === compareString;
      };

      QueryableString.prototype.value = function () {
        return this.str;
      };

      return QueryableString;
    }();

    exports.QueryableString = QueryableString;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/planning/reflection_utils.js":
  /*!*****************************************************************!*\
    !*** ./node_modules/inversify/lib/planning/reflection_utils.js ***!
    \*****************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibPlanningReflection_utilsJs(module, exports, __webpack_require__) {
    "use strict";

    var __spreadArray = this && this.__spreadArray || function (to, from) {
      for (var i = 0, il = from.length, j = to.length; i < il; i++, j++) {
        to[j] = from[i];
      }

      return to;
    };

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.getFunctionName = exports.getBaseClassDependencyCount = exports.getDependencies = void 0;

    var inject_1 = __webpack_require__(
    /*! ../annotation/inject */
    "./node_modules/inversify/lib/annotation/inject.js");

    var ERROR_MSGS = __webpack_require__(
    /*! ../constants/error_msgs */
    "./node_modules/inversify/lib/constants/error_msgs.js");

    var literal_types_1 = __webpack_require__(
    /*! ../constants/literal_types */
    "./node_modules/inversify/lib/constants/literal_types.js");

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    var serialization_1 = __webpack_require__(
    /*! ../utils/serialization */
    "./node_modules/inversify/lib/utils/serialization.js");

    Object.defineProperty(exports, "getFunctionName", {
      enumerable: true,
      get: function get() {
        return serialization_1.getFunctionName;
      }
    });

    var target_1 = __webpack_require__(
    /*! ./target */
    "./node_modules/inversify/lib/planning/target.js");

    function getDependencies(metadataReader, func) {
      var constructorName = serialization_1.getFunctionName(func);
      var targets = getTargets(metadataReader, constructorName, func, false);
      return targets;
    }

    exports.getDependencies = getDependencies;

    function getTargets(metadataReader, constructorName, func, isBaseClass) {
      var metadata = metadataReader.getConstructorMetadata(func);
      var serviceIdentifiers = metadata.compilerGeneratedMetadata;

      if (serviceIdentifiers === undefined) {
        var msg = ERROR_MSGS.MISSING_INJECTABLE_ANNOTATION + " " + constructorName + ".";
        throw new Error(msg);
      }

      var constructorArgsMetadata = metadata.userGeneratedMetadata;
      var keys = Object.keys(constructorArgsMetadata);
      var hasUserDeclaredUnknownInjections = func.length === 0 && keys.length > 0;
      var hasOptionalParameters = keys.length > func.length;
      var iterations = hasUserDeclaredUnknownInjections || hasOptionalParameters ? keys.length : func.length;
      var constructorTargets = getConstructorArgsAsTargets(isBaseClass, constructorName, serviceIdentifiers, constructorArgsMetadata, iterations);
      var propertyTargets = getClassPropsAsTargets(metadataReader, func);

      var targets = __spreadArray(__spreadArray([], constructorTargets), propertyTargets);

      return targets;
    }

    function getConstructorArgsAsTarget(index, isBaseClass, constructorName, serviceIdentifiers, constructorArgsMetadata) {
      var targetMetadata = constructorArgsMetadata[index.toString()] || [];
      var metadata = formatTargetMetadata(targetMetadata);
      var isManaged = metadata.unmanaged !== true;
      var serviceIdentifier = serviceIdentifiers[index];
      var injectIdentifier = metadata.inject || metadata.multiInject;
      serviceIdentifier = injectIdentifier ? injectIdentifier : serviceIdentifier;

      if (serviceIdentifier instanceof inject_1.LazyServiceIdentifer) {
        serviceIdentifier = serviceIdentifier.unwrap();
      }

      if (isManaged) {
        var isObject = serviceIdentifier === Object;
        var isFunction = serviceIdentifier === Function;
        var isUndefined = serviceIdentifier === undefined;
        var isUnknownType = isObject || isFunction || isUndefined;

        if (!isBaseClass && isUnknownType) {
          var msg = ERROR_MSGS.MISSING_INJECT_ANNOTATION + " argument " + index + " in class " + constructorName + ".";
          throw new Error(msg);
        }

        var target = new target_1.Target(literal_types_1.TargetTypeEnum.ConstructorArgument, metadata.targetName, serviceIdentifier);
        target.metadata = targetMetadata;
        return target;
      }

      return null;
    }

    function getConstructorArgsAsTargets(isBaseClass, constructorName, serviceIdentifiers, constructorArgsMetadata, iterations) {
      var targets = [];

      for (var i = 0; i < iterations; i++) {
        var index = i;
        var target = getConstructorArgsAsTarget(index, isBaseClass, constructorName, serviceIdentifiers, constructorArgsMetadata);

        if (target !== null) {
          targets.push(target);
        }
      }

      return targets;
    }

    function getClassPropsAsTargets(metadataReader, constructorFunc) {
      var classPropsMetadata = metadataReader.getPropertiesMetadata(constructorFunc);
      var targets = [];
      var keys = Object.keys(classPropsMetadata);

      for (var _i = 0, keys_1 = keys; _i < keys_1.length; _i++) {
        var key = keys_1[_i];
        var targetMetadata = classPropsMetadata[key];
        var metadata = formatTargetMetadata(classPropsMetadata[key]);
        var targetName = metadata.targetName || key;
        var serviceIdentifier = metadata.inject || metadata.multiInject;
        var target = new target_1.Target(literal_types_1.TargetTypeEnum.ClassProperty, targetName, serviceIdentifier);
        target.metadata = targetMetadata;
        targets.push(target);
      }

      var baseConstructor = Object.getPrototypeOf(constructorFunc.prototype).constructor;

      if (baseConstructor !== Object) {
        var baseTargets = getClassPropsAsTargets(metadataReader, baseConstructor);
        targets = __spreadArray(__spreadArray([], targets), baseTargets);
      }

      return targets;
    }

    function getBaseClassDependencyCount(metadataReader, func) {
      var baseConstructor = Object.getPrototypeOf(func.prototype).constructor;

      if (baseConstructor !== Object) {
        var baseConstructorName = serialization_1.getFunctionName(baseConstructor);
        var targets = getTargets(metadataReader, baseConstructorName, baseConstructor, true);
        var metadata = targets.map(function (t) {
          return t.metadata.filter(function (m) {
            return m.key === METADATA_KEY.UNMANAGED_TAG;
          });
        });
        var unmanagedCount = [].concat.apply([], metadata).length;
        var dependencyCount = targets.length - unmanagedCount;

        if (dependencyCount > 0) {
          return dependencyCount;
        } else {
          return getBaseClassDependencyCount(metadataReader, baseConstructor);
        }
      } else {
        return 0;
      }
    }

    exports.getBaseClassDependencyCount = getBaseClassDependencyCount;

    function formatTargetMetadata(targetMetadata) {
      var targetMetadataMap = {};
      targetMetadata.forEach(function (m) {
        targetMetadataMap[m.key.toString()] = m.value;
      });
      return {
        inject: targetMetadataMap[METADATA_KEY.INJECT_TAG],
        multiInject: targetMetadataMap[METADATA_KEY.MULTI_INJECT_TAG],
        targetName: targetMetadataMap[METADATA_KEY.NAME_TAG],
        unmanaged: targetMetadataMap[METADATA_KEY.UNMANAGED_TAG]
      };
    }
    /***/

  },

  /***/
  "./node_modules/inversify/lib/planning/request.js":
  /*!********************************************************!*\
    !*** ./node_modules/inversify/lib/planning/request.js ***!
    \********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibPlanningRequestJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.Request = void 0;

    var id_1 = __webpack_require__(
    /*! ../utils/id */
    "./node_modules/inversify/lib/utils/id.js");

    var Request = function () {
      function Request(serviceIdentifier, parentContext, parentRequest, bindings, target) {
        this.id = id_1.id();
        this.serviceIdentifier = serviceIdentifier;
        this.parentContext = parentContext;
        this.parentRequest = parentRequest;
        this.target = target;
        this.childRequests = [];
        this.bindings = Array.isArray(bindings) ? bindings : [bindings];
        this.requestScope = parentRequest === null ? new Map() : null;
      }

      Request.prototype.addChildRequest = function (serviceIdentifier, bindings, target) {
        var child = new Request(serviceIdentifier, this.parentContext, this, bindings, target);
        this.childRequests.push(child);
        return child;
      };

      return Request;
    }();

    exports.Request = Request;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/planning/target.js":
  /*!*******************************************************!*\
    !*** ./node_modules/inversify/lib/planning/target.js ***!
    \*******************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibPlanningTargetJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.Target = void 0;

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    var id_1 = __webpack_require__(
    /*! ../utils/id */
    "./node_modules/inversify/lib/utils/id.js");

    var metadata_1 = __webpack_require__(
    /*! ./metadata */
    "./node_modules/inversify/lib/planning/metadata.js");

    var queryable_string_1 = __webpack_require__(
    /*! ./queryable_string */
    "./node_modules/inversify/lib/planning/queryable_string.js");

    var Target = function () {
      function Target(type, name, serviceIdentifier, namedOrTagged) {
        this.id = id_1.id();
        this.type = type;
        this.serviceIdentifier = serviceIdentifier;
        this.name = new queryable_string_1.QueryableString(name || "");
        this.metadata = new Array();
        var metadataItem = null;

        if (typeof namedOrTagged === "string") {
          metadataItem = new metadata_1.Metadata(METADATA_KEY.NAMED_TAG, namedOrTagged);
        } else if (namedOrTagged instanceof metadata_1.Metadata) {
          metadataItem = namedOrTagged;
        }

        if (metadataItem !== null) {
          this.metadata.push(metadataItem);
        }
      }

      Target.prototype.hasTag = function (key) {
        for (var _i = 0, _a = this.metadata; _i < _a.length; _i++) {
          var m = _a[_i];

          if (m.key === key) {
            return true;
          }
        }

        return false;
      };

      Target.prototype.isArray = function () {
        return this.hasTag(METADATA_KEY.MULTI_INJECT_TAG);
      };

      Target.prototype.matchesArray = function (name) {
        return this.matchesTag(METADATA_KEY.MULTI_INJECT_TAG)(name);
      };

      Target.prototype.isNamed = function () {
        return this.hasTag(METADATA_KEY.NAMED_TAG);
      };

      Target.prototype.isTagged = function () {
        return this.metadata.some(function (metadata) {
          return METADATA_KEY.NON_CUSTOM_TAG_KEYS.every(function (key) {
            return metadata.key !== key;
          });
        });
      };

      Target.prototype.isOptional = function () {
        return this.matchesTag(METADATA_KEY.OPTIONAL_TAG)(true);
      };

      Target.prototype.getNamedTag = function () {
        if (this.isNamed()) {
          return this.metadata.filter(function (m) {
            return m.key === METADATA_KEY.NAMED_TAG;
          })[0];
        }

        return null;
      };

      Target.prototype.getCustomTags = function () {
        if (this.isTagged()) {
          return this.metadata.filter(function (metadata) {
            return METADATA_KEY.NON_CUSTOM_TAG_KEYS.every(function (key) {
              return metadata.key !== key;
            });
          });
        } else {
          return null;
        }
      };

      Target.prototype.matchesNamedTag = function (name) {
        return this.matchesTag(METADATA_KEY.NAMED_TAG)(name);
      };

      Target.prototype.matchesTag = function (key) {
        var _this = this;

        return function (value) {
          for (var _i = 0, _a = _this.metadata; _i < _a.length; _i++) {
            var m = _a[_i];

            if (m.key === key && m.value === value) {
              return true;
            }
          }

          return false;
        };
      };

      return Target;
    }();

    exports.Target = Target;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/resolution/instantiation.js":
  /*!****************************************************************!*\
    !*** ./node_modules/inversify/lib/resolution/instantiation.js ***!
    \****************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibResolutionInstantiationJs(module, exports, __webpack_require__) {
    "use strict";

    var __spreadArray = this && this.__spreadArray || function (to, from) {
      for (var i = 0, il = from.length, j = to.length; i < il; i++, j++) {
        to[j] = from[i];
      }

      return to;
    };

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.resolveInstance = void 0;

    var error_msgs_1 = __webpack_require__(
    /*! ../constants/error_msgs */
    "./node_modules/inversify/lib/constants/error_msgs.js");

    var literal_types_1 = __webpack_require__(
    /*! ../constants/literal_types */
    "./node_modules/inversify/lib/constants/literal_types.js");

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    function _injectProperties(instance, childRequests, resolveRequest) {
      var propertyInjectionsRequests = childRequests.filter(function (childRequest) {
        return childRequest.target !== null && childRequest.target.type === literal_types_1.TargetTypeEnum.ClassProperty;
      });
      var propertyInjections = propertyInjectionsRequests.map(resolveRequest);
      propertyInjectionsRequests.forEach(function (r, index) {
        var propertyName = "";
        propertyName = r.target.name.value();
        var injection = propertyInjections[index];
        instance[propertyName] = injection;
      });
      return instance;
    }

    function _createInstance(Func, injections) {
      return new (Func.bind.apply(Func, __spreadArray([void 0], injections)))();
    }

    function _postConstruct(constr, result) {
      if (Reflect.hasMetadata(METADATA_KEY.POST_CONSTRUCT, constr)) {
        var data = Reflect.getMetadata(METADATA_KEY.POST_CONSTRUCT, constr);

        try {
          result[data.value]();
        } catch (e) {
          throw new Error(error_msgs_1.POST_CONSTRUCT_ERROR(constr.name, e.message));
        }
      }
    }

    function resolveInstance(constr, childRequests, resolveRequest) {
      var result = null;

      if (childRequests.length > 0) {
        var constructorInjectionsRequests = childRequests.filter(function (childRequest) {
          return childRequest.target !== null && childRequest.target.type === literal_types_1.TargetTypeEnum.ConstructorArgument;
        });
        var constructorInjections = constructorInjectionsRequests.map(resolveRequest);
        result = _createInstance(constr, constructorInjections);
        result = _injectProperties(result, childRequests, resolveRequest);
      } else {
        result = new constr();
      }

      _postConstruct(constr, result);

      return result;
    }

    exports.resolveInstance = resolveInstance;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/resolution/resolver.js":
  /*!***********************************************************!*\
    !*** ./node_modules/inversify/lib/resolution/resolver.js ***!
    \***********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibResolutionResolverJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.resolve = void 0;

    var ERROR_MSGS = __webpack_require__(
    /*! ../constants/error_msgs */
    "./node_modules/inversify/lib/constants/error_msgs.js");

    var literal_types_1 = __webpack_require__(
    /*! ../constants/literal_types */
    "./node_modules/inversify/lib/constants/literal_types.js");

    var exceptions_1 = __webpack_require__(
    /*! ../utils/exceptions */
    "./node_modules/inversify/lib/utils/exceptions.js");

    var serialization_1 = __webpack_require__(
    /*! ../utils/serialization */
    "./node_modules/inversify/lib/utils/serialization.js");

    var instantiation_1 = __webpack_require__(
    /*! ./instantiation */
    "./node_modules/inversify/lib/resolution/instantiation.js");

    var invokeFactory = function invokeFactory(factoryType, serviceIdentifier, fn) {
      try {
        return fn();
      } catch (error) {
        if (exceptions_1.isStackOverflowExeption(error)) {
          throw new Error(ERROR_MSGS.CIRCULAR_DEPENDENCY_IN_FACTORY(factoryType, serviceIdentifier.toString()));
        } else {
          throw error;
        }
      }
    };

    var _resolveRequest = function _resolveRequest(requestScope) {
      return function (request) {
        request.parentContext.setCurrentRequest(request);
        var bindings = request.bindings;
        var childRequests = request.childRequests;
        var targetIsAnArray = request.target && request.target.isArray();
        var targetParentIsNotAnArray = !request.parentRequest || !request.parentRequest.target || !request.target || !request.parentRequest.target.matchesArray(request.target.serviceIdentifier);

        if (targetIsAnArray && targetParentIsNotAnArray) {
          return childRequests.map(function (childRequest) {
            var _f = _resolveRequest(requestScope);

            return _f(childRequest);
          });
        } else {
          var result = null;

          if (request.target.isOptional() && bindings.length === 0) {
            return undefined;
          }

          var binding_1 = bindings[0];
          var isSingleton = binding_1.scope === literal_types_1.BindingScopeEnum.Singleton;
          var isRequestSingleton = binding_1.scope === literal_types_1.BindingScopeEnum.Request;

          if (isSingleton && binding_1.activated) {
            return binding_1.cache;
          }

          if (isRequestSingleton && requestScope !== null && requestScope.has(binding_1.id)) {
            return requestScope.get(binding_1.id);
          }

          if (binding_1.type === literal_types_1.BindingTypeEnum.ConstantValue) {
            result = binding_1.cache;
            binding_1.activated = true;
          } else if (binding_1.type === literal_types_1.BindingTypeEnum.Function) {
            result = binding_1.cache;
            binding_1.activated = true;
          } else if (binding_1.type === literal_types_1.BindingTypeEnum.Constructor) {
            result = binding_1.implementationType;
          } else if (binding_1.type === literal_types_1.BindingTypeEnum.DynamicValue && binding_1.dynamicValue !== null) {
            result = invokeFactory("toDynamicValue", binding_1.serviceIdentifier, function () {
              return binding_1.dynamicValue(request.parentContext);
            });
          } else if (binding_1.type === literal_types_1.BindingTypeEnum.Factory && binding_1.factory !== null) {
            result = invokeFactory("toFactory", binding_1.serviceIdentifier, function () {
              return binding_1.factory(request.parentContext);
            });
          } else if (binding_1.type === literal_types_1.BindingTypeEnum.Provider && binding_1.provider !== null) {
            result = invokeFactory("toProvider", binding_1.serviceIdentifier, function () {
              return binding_1.provider(request.parentContext);
            });
          } else if (binding_1.type === literal_types_1.BindingTypeEnum.Instance && binding_1.implementationType !== null) {
            result = instantiation_1.resolveInstance(binding_1.implementationType, childRequests, _resolveRequest(requestScope));
          } else {
            var serviceIdentifier = serialization_1.getServiceIdentifierAsString(request.serviceIdentifier);
            throw new Error(ERROR_MSGS.INVALID_BINDING_TYPE + " " + serviceIdentifier);
          }

          if (typeof binding_1.onActivation === "function") {
            result = binding_1.onActivation(request.parentContext, result);
          }

          if (isSingleton) {
            binding_1.cache = result;
            binding_1.activated = true;
          }

          if (isRequestSingleton && requestScope !== null && !requestScope.has(binding_1.id)) {
            requestScope.set(binding_1.id, result);
          }

          return result;
        }
      };
    };

    function resolve(context) {
      var _f = _resolveRequest(context.plan.rootRequest.requestScope);

      return _f(context.plan.rootRequest);
    }

    exports.resolve = resolve;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/syntax/binding_in_syntax.js":
  /*!****************************************************************!*\
    !*** ./node_modules/inversify/lib/syntax/binding_in_syntax.js ***!
    \****************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibSyntaxBinding_in_syntaxJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.BindingInSyntax = void 0;

    var literal_types_1 = __webpack_require__(
    /*! ../constants/literal_types */
    "./node_modules/inversify/lib/constants/literal_types.js");

    var binding_when_on_syntax_1 = __webpack_require__(
    /*! ./binding_when_on_syntax */
    "./node_modules/inversify/lib/syntax/binding_when_on_syntax.js");

    var BindingInSyntax = function () {
      function BindingInSyntax(binding) {
        this._binding = binding;
      }

      BindingInSyntax.prototype.inRequestScope = function () {
        this._binding.scope = literal_types_1.BindingScopeEnum.Request;
        return new binding_when_on_syntax_1.BindingWhenOnSyntax(this._binding);
      };

      BindingInSyntax.prototype.inSingletonScope = function () {
        this._binding.scope = literal_types_1.BindingScopeEnum.Singleton;
        return new binding_when_on_syntax_1.BindingWhenOnSyntax(this._binding);
      };

      BindingInSyntax.prototype.inTransientScope = function () {
        this._binding.scope = literal_types_1.BindingScopeEnum.Transient;
        return new binding_when_on_syntax_1.BindingWhenOnSyntax(this._binding);
      };

      return BindingInSyntax;
    }();

    exports.BindingInSyntax = BindingInSyntax;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/syntax/binding_in_when_on_syntax.js":
  /*!************************************************************************!*\
    !*** ./node_modules/inversify/lib/syntax/binding_in_when_on_syntax.js ***!
    \************************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibSyntaxBinding_in_when_on_syntaxJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.BindingInWhenOnSyntax = void 0;

    var binding_in_syntax_1 = __webpack_require__(
    /*! ./binding_in_syntax */
    "./node_modules/inversify/lib/syntax/binding_in_syntax.js");

    var binding_on_syntax_1 = __webpack_require__(
    /*! ./binding_on_syntax */
    "./node_modules/inversify/lib/syntax/binding_on_syntax.js");

    var binding_when_syntax_1 = __webpack_require__(
    /*! ./binding_when_syntax */
    "./node_modules/inversify/lib/syntax/binding_when_syntax.js");

    var BindingInWhenOnSyntax = function () {
      function BindingInWhenOnSyntax(binding) {
        this._binding = binding;
        this._bindingWhenSyntax = new binding_when_syntax_1.BindingWhenSyntax(this._binding);
        this._bindingOnSyntax = new binding_on_syntax_1.BindingOnSyntax(this._binding);
        this._bindingInSyntax = new binding_in_syntax_1.BindingInSyntax(binding);
      }

      BindingInWhenOnSyntax.prototype.inRequestScope = function () {
        return this._bindingInSyntax.inRequestScope();
      };

      BindingInWhenOnSyntax.prototype.inSingletonScope = function () {
        return this._bindingInSyntax.inSingletonScope();
      };

      BindingInWhenOnSyntax.prototype.inTransientScope = function () {
        return this._bindingInSyntax.inTransientScope();
      };

      BindingInWhenOnSyntax.prototype.when = function (constraint) {
        return this._bindingWhenSyntax.when(constraint);
      };

      BindingInWhenOnSyntax.prototype.whenTargetNamed = function (name) {
        return this._bindingWhenSyntax.whenTargetNamed(name);
      };

      BindingInWhenOnSyntax.prototype.whenTargetIsDefault = function () {
        return this._bindingWhenSyntax.whenTargetIsDefault();
      };

      BindingInWhenOnSyntax.prototype.whenTargetTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenTargetTagged(tag, value);
      };

      BindingInWhenOnSyntax.prototype.whenInjectedInto = function (parent) {
        return this._bindingWhenSyntax.whenInjectedInto(parent);
      };

      BindingInWhenOnSyntax.prototype.whenParentNamed = function (name) {
        return this._bindingWhenSyntax.whenParentNamed(name);
      };

      BindingInWhenOnSyntax.prototype.whenParentTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenParentTagged(tag, value);
      };

      BindingInWhenOnSyntax.prototype.whenAnyAncestorIs = function (ancestor) {
        return this._bindingWhenSyntax.whenAnyAncestorIs(ancestor);
      };

      BindingInWhenOnSyntax.prototype.whenNoAncestorIs = function (ancestor) {
        return this._bindingWhenSyntax.whenNoAncestorIs(ancestor);
      };

      BindingInWhenOnSyntax.prototype.whenAnyAncestorNamed = function (name) {
        return this._bindingWhenSyntax.whenAnyAncestorNamed(name);
      };

      BindingInWhenOnSyntax.prototype.whenAnyAncestorTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenAnyAncestorTagged(tag, value);
      };

      BindingInWhenOnSyntax.prototype.whenNoAncestorNamed = function (name) {
        return this._bindingWhenSyntax.whenNoAncestorNamed(name);
      };

      BindingInWhenOnSyntax.prototype.whenNoAncestorTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenNoAncestorTagged(tag, value);
      };

      BindingInWhenOnSyntax.prototype.whenAnyAncestorMatches = function (constraint) {
        return this._bindingWhenSyntax.whenAnyAncestorMatches(constraint);
      };

      BindingInWhenOnSyntax.prototype.whenNoAncestorMatches = function (constraint) {
        return this._bindingWhenSyntax.whenNoAncestorMatches(constraint);
      };

      BindingInWhenOnSyntax.prototype.onActivation = function (handler) {
        return this._bindingOnSyntax.onActivation(handler);
      };

      return BindingInWhenOnSyntax;
    }();

    exports.BindingInWhenOnSyntax = BindingInWhenOnSyntax;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/syntax/binding_on_syntax.js":
  /*!****************************************************************!*\
    !*** ./node_modules/inversify/lib/syntax/binding_on_syntax.js ***!
    \****************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibSyntaxBinding_on_syntaxJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.BindingOnSyntax = void 0;

    var binding_when_syntax_1 = __webpack_require__(
    /*! ./binding_when_syntax */
    "./node_modules/inversify/lib/syntax/binding_when_syntax.js");

    var BindingOnSyntax = function () {
      function BindingOnSyntax(binding) {
        this._binding = binding;
      }

      BindingOnSyntax.prototype.onActivation = function (handler) {
        this._binding.onActivation = handler;
        return new binding_when_syntax_1.BindingWhenSyntax(this._binding);
      };

      return BindingOnSyntax;
    }();

    exports.BindingOnSyntax = BindingOnSyntax;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/syntax/binding_to_syntax.js":
  /*!****************************************************************!*\
    !*** ./node_modules/inversify/lib/syntax/binding_to_syntax.js ***!
    \****************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibSyntaxBinding_to_syntaxJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.BindingToSyntax = void 0;

    var ERROR_MSGS = __webpack_require__(
    /*! ../constants/error_msgs */
    "./node_modules/inversify/lib/constants/error_msgs.js");

    var literal_types_1 = __webpack_require__(
    /*! ../constants/literal_types */
    "./node_modules/inversify/lib/constants/literal_types.js");

    var binding_in_when_on_syntax_1 = __webpack_require__(
    /*! ./binding_in_when_on_syntax */
    "./node_modules/inversify/lib/syntax/binding_in_when_on_syntax.js");

    var binding_when_on_syntax_1 = __webpack_require__(
    /*! ./binding_when_on_syntax */
    "./node_modules/inversify/lib/syntax/binding_when_on_syntax.js");

    var BindingToSyntax = function () {
      function BindingToSyntax(binding) {
        this._binding = binding;
      }

      BindingToSyntax.prototype.to = function (constructor) {
        this._binding.type = literal_types_1.BindingTypeEnum.Instance;
        this._binding.implementationType = constructor;
        return new binding_in_when_on_syntax_1.BindingInWhenOnSyntax(this._binding);
      };

      BindingToSyntax.prototype.toSelf = function () {
        if (typeof this._binding.serviceIdentifier !== "function") {
          throw new Error("" + ERROR_MSGS.INVALID_TO_SELF_VALUE);
        }

        var self = this._binding.serviceIdentifier;
        return this.to(self);
      };

      BindingToSyntax.prototype.toConstantValue = function (value) {
        this._binding.type = literal_types_1.BindingTypeEnum.ConstantValue;
        this._binding.cache = value;
        this._binding.dynamicValue = null;
        this._binding.implementationType = null;
        this._binding.scope = literal_types_1.BindingScopeEnum.Singleton;
        return new binding_when_on_syntax_1.BindingWhenOnSyntax(this._binding);
      };

      BindingToSyntax.prototype.toDynamicValue = function (func) {
        this._binding.type = literal_types_1.BindingTypeEnum.DynamicValue;
        this._binding.cache = null;
        this._binding.dynamicValue = func;
        this._binding.implementationType = null;
        return new binding_in_when_on_syntax_1.BindingInWhenOnSyntax(this._binding);
      };

      BindingToSyntax.prototype.toConstructor = function (constructor) {
        this._binding.type = literal_types_1.BindingTypeEnum.Constructor;
        this._binding.implementationType = constructor;
        this._binding.scope = literal_types_1.BindingScopeEnum.Singleton;
        return new binding_when_on_syntax_1.BindingWhenOnSyntax(this._binding);
      };

      BindingToSyntax.prototype.toFactory = function (factory) {
        this._binding.type = literal_types_1.BindingTypeEnum.Factory;
        this._binding.factory = factory;
        this._binding.scope = literal_types_1.BindingScopeEnum.Singleton;
        return new binding_when_on_syntax_1.BindingWhenOnSyntax(this._binding);
      };

      BindingToSyntax.prototype.toFunction = function (func) {
        if (typeof func !== "function") {
          throw new Error(ERROR_MSGS.INVALID_FUNCTION_BINDING);
        }

        var bindingWhenOnSyntax = this.toConstantValue(func);
        this._binding.type = literal_types_1.BindingTypeEnum.Function;
        this._binding.scope = literal_types_1.BindingScopeEnum.Singleton;
        return bindingWhenOnSyntax;
      };

      BindingToSyntax.prototype.toAutoFactory = function (serviceIdentifier) {
        this._binding.type = literal_types_1.BindingTypeEnum.Factory;

        this._binding.factory = function (context) {
          var autofactory = function autofactory() {
            return context.container.get(serviceIdentifier);
          };

          return autofactory;
        };

        this._binding.scope = literal_types_1.BindingScopeEnum.Singleton;
        return new binding_when_on_syntax_1.BindingWhenOnSyntax(this._binding);
      };

      BindingToSyntax.prototype.toProvider = function (provider) {
        this._binding.type = literal_types_1.BindingTypeEnum.Provider;
        this._binding.provider = provider;
        this._binding.scope = literal_types_1.BindingScopeEnum.Singleton;
        return new binding_when_on_syntax_1.BindingWhenOnSyntax(this._binding);
      };

      BindingToSyntax.prototype.toService = function (service) {
        this.toDynamicValue(function (context) {
          return context.container.get(service);
        });
      };

      return BindingToSyntax;
    }();

    exports.BindingToSyntax = BindingToSyntax;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/syntax/binding_when_on_syntax.js":
  /*!*********************************************************************!*\
    !*** ./node_modules/inversify/lib/syntax/binding_when_on_syntax.js ***!
    \*********************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibSyntaxBinding_when_on_syntaxJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.BindingWhenOnSyntax = void 0;

    var binding_on_syntax_1 = __webpack_require__(
    /*! ./binding_on_syntax */
    "./node_modules/inversify/lib/syntax/binding_on_syntax.js");

    var binding_when_syntax_1 = __webpack_require__(
    /*! ./binding_when_syntax */
    "./node_modules/inversify/lib/syntax/binding_when_syntax.js");

    var BindingWhenOnSyntax = function () {
      function BindingWhenOnSyntax(binding) {
        this._binding = binding;
        this._bindingWhenSyntax = new binding_when_syntax_1.BindingWhenSyntax(this._binding);
        this._bindingOnSyntax = new binding_on_syntax_1.BindingOnSyntax(this._binding);
      }

      BindingWhenOnSyntax.prototype.when = function (constraint) {
        return this._bindingWhenSyntax.when(constraint);
      };

      BindingWhenOnSyntax.prototype.whenTargetNamed = function (name) {
        return this._bindingWhenSyntax.whenTargetNamed(name);
      };

      BindingWhenOnSyntax.prototype.whenTargetIsDefault = function () {
        return this._bindingWhenSyntax.whenTargetIsDefault();
      };

      BindingWhenOnSyntax.prototype.whenTargetTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenTargetTagged(tag, value);
      };

      BindingWhenOnSyntax.prototype.whenInjectedInto = function (parent) {
        return this._bindingWhenSyntax.whenInjectedInto(parent);
      };

      BindingWhenOnSyntax.prototype.whenParentNamed = function (name) {
        return this._bindingWhenSyntax.whenParentNamed(name);
      };

      BindingWhenOnSyntax.prototype.whenParentTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenParentTagged(tag, value);
      };

      BindingWhenOnSyntax.prototype.whenAnyAncestorIs = function (ancestor) {
        return this._bindingWhenSyntax.whenAnyAncestorIs(ancestor);
      };

      BindingWhenOnSyntax.prototype.whenNoAncestorIs = function (ancestor) {
        return this._bindingWhenSyntax.whenNoAncestorIs(ancestor);
      };

      BindingWhenOnSyntax.prototype.whenAnyAncestorNamed = function (name) {
        return this._bindingWhenSyntax.whenAnyAncestorNamed(name);
      };

      BindingWhenOnSyntax.prototype.whenAnyAncestorTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenAnyAncestorTagged(tag, value);
      };

      BindingWhenOnSyntax.prototype.whenNoAncestorNamed = function (name) {
        return this._bindingWhenSyntax.whenNoAncestorNamed(name);
      };

      BindingWhenOnSyntax.prototype.whenNoAncestorTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenNoAncestorTagged(tag, value);
      };

      BindingWhenOnSyntax.prototype.whenAnyAncestorMatches = function (constraint) {
        return this._bindingWhenSyntax.whenAnyAncestorMatches(constraint);
      };

      BindingWhenOnSyntax.prototype.whenNoAncestorMatches = function (constraint) {
        return this._bindingWhenSyntax.whenNoAncestorMatches(constraint);
      };

      BindingWhenOnSyntax.prototype.onActivation = function (handler) {
        return this._bindingOnSyntax.onActivation(handler);
      };

      return BindingWhenOnSyntax;
    }();

    exports.BindingWhenOnSyntax = BindingWhenOnSyntax;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/syntax/binding_when_syntax.js":
  /*!******************************************************************!*\
    !*** ./node_modules/inversify/lib/syntax/binding_when_syntax.js ***!
    \******************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibSyntaxBinding_when_syntaxJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.BindingWhenSyntax = void 0;

    var binding_on_syntax_1 = __webpack_require__(
    /*! ./binding_on_syntax */
    "./node_modules/inversify/lib/syntax/binding_on_syntax.js");

    var constraint_helpers_1 = __webpack_require__(
    /*! ./constraint_helpers */
    "./node_modules/inversify/lib/syntax/constraint_helpers.js");

    var BindingWhenSyntax = function () {
      function BindingWhenSyntax(binding) {
        this._binding = binding;
      }

      BindingWhenSyntax.prototype.when = function (constraint) {
        this._binding.constraint = constraint;
        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      BindingWhenSyntax.prototype.whenTargetNamed = function (name) {
        this._binding.constraint = constraint_helpers_1.namedConstraint(name);
        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      BindingWhenSyntax.prototype.whenTargetIsDefault = function () {
        this._binding.constraint = function (request) {
          var targetIsDefault = request.target !== null && !request.target.isNamed() && !request.target.isTagged();
          return targetIsDefault;
        };

        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      BindingWhenSyntax.prototype.whenTargetTagged = function (tag, value) {
        this._binding.constraint = constraint_helpers_1.taggedConstraint(tag)(value);
        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      BindingWhenSyntax.prototype.whenInjectedInto = function (parent) {
        this._binding.constraint = function (request) {
          return constraint_helpers_1.typeConstraint(parent)(request.parentRequest);
        };

        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      BindingWhenSyntax.prototype.whenParentNamed = function (name) {
        this._binding.constraint = function (request) {
          return constraint_helpers_1.namedConstraint(name)(request.parentRequest);
        };

        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      BindingWhenSyntax.prototype.whenParentTagged = function (tag, value) {
        this._binding.constraint = function (request) {
          return constraint_helpers_1.taggedConstraint(tag)(value)(request.parentRequest);
        };

        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      BindingWhenSyntax.prototype.whenAnyAncestorIs = function (ancestor) {
        this._binding.constraint = function (request) {
          return constraint_helpers_1.traverseAncerstors(request, constraint_helpers_1.typeConstraint(ancestor));
        };

        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      BindingWhenSyntax.prototype.whenNoAncestorIs = function (ancestor) {
        this._binding.constraint = function (request) {
          return !constraint_helpers_1.traverseAncerstors(request, constraint_helpers_1.typeConstraint(ancestor));
        };

        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      BindingWhenSyntax.prototype.whenAnyAncestorNamed = function (name) {
        this._binding.constraint = function (request) {
          return constraint_helpers_1.traverseAncerstors(request, constraint_helpers_1.namedConstraint(name));
        };

        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      BindingWhenSyntax.prototype.whenNoAncestorNamed = function (name) {
        this._binding.constraint = function (request) {
          return !constraint_helpers_1.traverseAncerstors(request, constraint_helpers_1.namedConstraint(name));
        };

        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      BindingWhenSyntax.prototype.whenAnyAncestorTagged = function (tag, value) {
        this._binding.constraint = function (request) {
          return constraint_helpers_1.traverseAncerstors(request, constraint_helpers_1.taggedConstraint(tag)(value));
        };

        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      BindingWhenSyntax.prototype.whenNoAncestorTagged = function (tag, value) {
        this._binding.constraint = function (request) {
          return !constraint_helpers_1.traverseAncerstors(request, constraint_helpers_1.taggedConstraint(tag)(value));
        };

        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      BindingWhenSyntax.prototype.whenAnyAncestorMatches = function (constraint) {
        this._binding.constraint = function (request) {
          return constraint_helpers_1.traverseAncerstors(request, constraint);
        };

        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      BindingWhenSyntax.prototype.whenNoAncestorMatches = function (constraint) {
        this._binding.constraint = function (request) {
          return !constraint_helpers_1.traverseAncerstors(request, constraint);
        };

        return new binding_on_syntax_1.BindingOnSyntax(this._binding);
      };

      return BindingWhenSyntax;
    }();

    exports.BindingWhenSyntax = BindingWhenSyntax;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/syntax/constraint_helpers.js":
  /*!*****************************************************************!*\
    !*** ./node_modules/inversify/lib/syntax/constraint_helpers.js ***!
    \*****************************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibSyntaxConstraint_helpersJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.typeConstraint = exports.namedConstraint = exports.taggedConstraint = exports.traverseAncerstors = void 0;

    var METADATA_KEY = __webpack_require__(
    /*! ../constants/metadata_keys */
    "./node_modules/inversify/lib/constants/metadata_keys.js");

    var metadata_1 = __webpack_require__(
    /*! ../planning/metadata */
    "./node_modules/inversify/lib/planning/metadata.js");

    var traverseAncerstors = function traverseAncerstors(request, constraint) {
      var parent = request.parentRequest;

      if (parent !== null) {
        return constraint(parent) ? true : traverseAncerstors(parent, constraint);
      } else {
        return false;
      }
    };

    exports.traverseAncerstors = traverseAncerstors;

    var taggedConstraint = function taggedConstraint(key) {
      return function (value) {
        var constraint = function constraint(request) {
          return request !== null && request.target !== null && request.target.matchesTag(key)(value);
        };

        constraint.metaData = new metadata_1.Metadata(key, value);
        return constraint;
      };
    };

    exports.taggedConstraint = taggedConstraint;
    var namedConstraint = taggedConstraint(METADATA_KEY.NAMED_TAG);
    exports.namedConstraint = namedConstraint;

    var typeConstraint = function typeConstraint(type) {
      return function (request) {
        var binding = null;

        if (request !== null) {
          binding = request.bindings[0];

          if (typeof type === "string") {
            var serviceIdentifier = binding.serviceIdentifier;
            return serviceIdentifier === type;
          } else {
            var constructor = request.bindings[0].implementationType;
            return type === constructor;
          }
        }

        return false;
      };
    };

    exports.typeConstraint = typeConstraint;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/utils/binding_utils.js":
  /*!***********************************************************!*\
    !*** ./node_modules/inversify/lib/utils/binding_utils.js ***!
    \***********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibUtilsBinding_utilsJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.multiBindToService = void 0;

    var multiBindToService = function multiBindToService(container) {
      return function (service) {
        return function () {
          var types = [];

          for (var _i = 0; _i < arguments.length; _i++) {
            types[_i] = arguments[_i];
          }

          return types.forEach(function (t) {
            return container.bind(t).toService(service);
          });
        };
      };
    };

    exports.multiBindToService = multiBindToService;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/utils/exceptions.js":
  /*!********************************************************!*\
    !*** ./node_modules/inversify/lib/utils/exceptions.js ***!
    \********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibUtilsExceptionsJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.isStackOverflowExeption = void 0;

    var ERROR_MSGS = __webpack_require__(
    /*! ../constants/error_msgs */
    "./node_modules/inversify/lib/constants/error_msgs.js");

    function isStackOverflowExeption(error) {
      return error instanceof RangeError || error.message === ERROR_MSGS.STACK_OVERFLOW;
    }

    exports.isStackOverflowExeption = isStackOverflowExeption;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/utils/id.js":
  /*!************************************************!*\
    !*** ./node_modules/inversify/lib/utils/id.js ***!
    \************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibUtilsIdJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.id = void 0;
    var idCounter = 0;

    function id() {
      return idCounter++;
    }

    exports.id = id;
    /***/
  },

  /***/
  "./node_modules/inversify/lib/utils/serialization.js":
  /*!***********************************************************!*\
    !*** ./node_modules/inversify/lib/utils/serialization.js ***!
    \***********************************************************/

  /*! no static exports found */

  /***/
  function node_modulesInversifyLibUtilsSerializationJs(module, exports, __webpack_require__) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    exports.circularDependencyToException = exports.listMetadataForTarget = exports.listRegisteredBindingsForServiceIdentifier = exports.getServiceIdentifierAsString = exports.getFunctionName = void 0;

    var ERROR_MSGS = __webpack_require__(
    /*! ../constants/error_msgs */
    "./node_modules/inversify/lib/constants/error_msgs.js");

    function getServiceIdentifierAsString(serviceIdentifier) {
      if (typeof serviceIdentifier === "function") {
        var _serviceIdentifier = serviceIdentifier;
        return _serviceIdentifier.name;
      } else if (_typeof(serviceIdentifier) === "symbol") {
        return serviceIdentifier.toString();
      } else {
        var _serviceIdentifier = serviceIdentifier;
        return _serviceIdentifier;
      }
    }

    exports.getServiceIdentifierAsString = getServiceIdentifierAsString;

    function listRegisteredBindingsForServiceIdentifier(container, serviceIdentifier, getBindings) {
      var registeredBindingsList = "";
      var registeredBindings = getBindings(container, serviceIdentifier);

      if (registeredBindings.length !== 0) {
        registeredBindingsList = "\nRegistered bindings:";
        registeredBindings.forEach(function (binding) {
          var name = "Object";

          if (binding.implementationType !== null) {
            name = getFunctionName(binding.implementationType);
          }

          registeredBindingsList = registeredBindingsList + "\n " + name;

          if (binding.constraint.metaData) {
            registeredBindingsList = registeredBindingsList + " - " + binding.constraint.metaData;
          }
        });
      }

      return registeredBindingsList;
    }

    exports.listRegisteredBindingsForServiceIdentifier = listRegisteredBindingsForServiceIdentifier;

    function alreadyDependencyChain(request, serviceIdentifier) {
      if (request.parentRequest === null) {
        return false;
      } else if (request.parentRequest.serviceIdentifier === serviceIdentifier) {
        return true;
      } else {
        return alreadyDependencyChain(request.parentRequest, serviceIdentifier);
      }
    }

    function dependencyChainToString(request) {
      function _createStringArr(req, result) {
        if (result === void 0) {
          result = [];
        }

        var serviceIdentifier = getServiceIdentifierAsString(req.serviceIdentifier);
        result.push(serviceIdentifier);

        if (req.parentRequest !== null) {
          return _createStringArr(req.parentRequest, result);
        }

        return result;
      }

      var stringArr = _createStringArr(request);

      return stringArr.reverse().join(" --> ");
    }

    function circularDependencyToException(request) {
      request.childRequests.forEach(function (childRequest) {
        if (alreadyDependencyChain(childRequest, childRequest.serviceIdentifier)) {
          var services = dependencyChainToString(childRequest);
          throw new Error(ERROR_MSGS.CIRCULAR_DEPENDENCY + " " + services);
        } else {
          circularDependencyToException(childRequest);
        }
      });
    }

    exports.circularDependencyToException = circularDependencyToException;

    function listMetadataForTarget(serviceIdentifierString, target) {
      if (target.isTagged() || target.isNamed()) {
        var m_1 = "";
        var namedTag = target.getNamedTag();
        var otherTags = target.getCustomTags();

        if (namedTag !== null) {
          m_1 += namedTag.toString() + "\n";
        }

        if (otherTags !== null) {
          otherTags.forEach(function (tag) {
            m_1 += tag.toString() + "\n";
          });
        }

        return " " + serviceIdentifierString + "\n " + serviceIdentifierString + " - " + m_1;
      } else {
        return " " + serviceIdentifierString;
      }
    }

    exports.listMetadataForTarget = listMetadataForTarget;

    function getFunctionName(v) {
      if (v.name) {
        return v.name;
      } else {
        var name_1 = v.toString();
        var match = name_1.match(/^function\s*([^\s(]+)/);
        return match ? match[1] : "Anonymous function: " + name_1;
      }
    }

    exports.getFunctionName = getFunctionName;
    /***/
  },

  /***/
  "./node_modules/process/browser.js":
  /*!*****************************************!*\
    !*** ./node_modules/process/browser.js ***!
    \*****************************************/

  /*! no static exports found */

  /***/
  function node_modulesProcessBrowserJs(module, exports) {
    // shim for using process in browser
    var process = module.exports = {}; // cached from whatever global is present so that test runners that stub it
    // don't break things.  But we need to wrap it in a try catch in case it is
    // wrapped in strict mode code which doesn't define any globals.  It's inside a
    // function because try/catches deoptimize in certain engines.

    var cachedSetTimeout;
    var cachedClearTimeout;

    function defaultSetTimout() {
      throw new Error('setTimeout has not been defined');
    }

    function defaultClearTimeout() {
      throw new Error('clearTimeout has not been defined');
    }

    (function () {
      try {
        if (typeof setTimeout === 'function') {
          cachedSetTimeout = setTimeout;
        } else {
          cachedSetTimeout = defaultSetTimout;
        }
      } catch (e) {
        cachedSetTimeout = defaultSetTimout;
      }

      try {
        if (typeof clearTimeout === 'function') {
          cachedClearTimeout = clearTimeout;
        } else {
          cachedClearTimeout = defaultClearTimeout;
        }
      } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
      }
    })();

    function runTimeout(fun) {
      if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
      } // if setTimeout wasn't available but was latter defined


      if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
      }

      try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
      } catch (e) {
        try {
          // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
          return cachedSetTimeout.call(null, fun, 0);
        } catch (e) {
          // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
          return cachedSetTimeout.call(this, fun, 0);
        }
      }
    }

    function runClearTimeout(marker) {
      if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
      } // if clearTimeout wasn't available but was latter defined


      if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
      }

      try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
      } catch (e) {
        try {
          // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
          return cachedClearTimeout.call(null, marker);
        } catch (e) {
          // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
          // Some versions of I.E. have different rules for clearTimeout vs setTimeout
          return cachedClearTimeout.call(this, marker);
        }
      }
    }

    var queue = [];
    var draining = false;
    var currentQueue;
    var queueIndex = -1;

    function cleanUpNextTick() {
      if (!draining || !currentQueue) {
        return;
      }

      draining = false;

      if (currentQueue.length) {
        queue = currentQueue.concat(queue);
      } else {
        queueIndex = -1;
      }

      if (queue.length) {
        drainQueue();
      }
    }

    function drainQueue() {
      if (draining) {
        return;
      }

      var timeout = runTimeout(cleanUpNextTick);
      draining = true;
      var len = queue.length;

      while (len) {
        currentQueue = queue;
        queue = [];

        while (++queueIndex < len) {
          if (currentQueue) {
            currentQueue[queueIndex].run();
          }
        }

        queueIndex = -1;
        len = queue.length;
      }

      currentQueue = null;
      draining = false;
      runClearTimeout(timeout);
    }

    process.nextTick = function (fun) {
      var args = new Array(arguments.length - 1);

      if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
          args[i - 1] = arguments[i];
        }
      }

      queue.push(new Item(fun, args));

      if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
      }
    }; // v8 likes predictible objects


    function Item(fun, array) {
      this.fun = fun;
      this.array = array;
    }

    Item.prototype.run = function () {
      this.fun.apply(null, this.array);
    };

    process.title = 'browser';
    process.browser = true;
    process.env = {};
    process.argv = [];
    process.version = ''; // empty string to avoid regexp issues

    process.versions = {};

    function noop() {}

    process.on = noop;
    process.addListener = noop;
    process.once = noop;
    process.off = noop;
    process.removeListener = noop;
    process.removeAllListeners = noop;
    process.emit = noop;
    process.prependListener = noop;
    process.prependOnceListener = noop;

    process.listeners = function (name) {
      return [];
    };

    process.binding = function (name) {
      throw new Error('process.binding is not supported');
    };

    process.cwd = function () {
      return '/';
    };

    process.chdir = function (dir) {
      throw new Error('process.chdir is not supported');
    };

    process.umask = function () {
      return 0;
    };
    /***/

  },

  /***/
  "./node_modules/reflect-metadata/Reflect.js":
  /*!**************************************************!*\
    !*** ./node_modules/reflect-metadata/Reflect.js ***!
    \**************************************************/

  /*! no static exports found */

  /***/
  function node_modulesReflectMetadataReflectJs(module, exports, __webpack_require__) {
    /* WEBPACK VAR INJECTION */
    (function (process, global) {
      /*! *****************************************************************************
      Copyright (C) Microsoft. All rights reserved.
      Licensed under the Apache License, Version 2.0 (the "License"); you may not use
      this file except in compliance with the License. You may obtain a copy of the
      License at http://www.apache.org/licenses/LICENSE-2.0
      THIS CODE IS PROVIDED ON AN *AS IS* BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
      KIND, EITHER EXPRESS OR IMPLIED, INCLUDING WITHOUT LIMITATION ANY IMPLIED
      WARRANTIES OR CONDITIONS OF TITLE, FITNESS FOR A PARTICULAR PURPOSE,
      MERCHANTABLITY OR NON-INFRINGEMENT.
      See the Apache Version 2.0 License for specific language governing permissions
      and limitations under the License.
      ***************************************************************************** */
      var Reflect;

      (function (Reflect) {
        // Metadata Proposal
        // https://rbuckton.github.io/reflect-metadata/
        (function (factory) {
          var root = _typeof(global) === "object" ? global : (typeof self === "undefined" ? "undefined" : _typeof(self)) === "object" ? self : _typeof(this) === "object" ? this : Function("return this;")();
          var exporter = makeExporter(Reflect);

          if (typeof root.Reflect === "undefined") {
            root.Reflect = Reflect;
          } else {
            exporter = makeExporter(root.Reflect, exporter);
          }

          factory(exporter);

          function makeExporter(target, previous) {
            return function (key, value) {
              if (typeof target[key] !== "function") {
                Object.defineProperty(target, key, {
                  configurable: true,
                  writable: true,
                  value: value
                });
              }

              if (previous) previous(key, value);
            };
          }
        })(function (exporter) {
          var hasOwn = Object.prototype.hasOwnProperty; // feature test for Symbol support

          var supportsSymbol = typeof Symbol === "function";
          var toPrimitiveSymbol = supportsSymbol && typeof Symbol.toPrimitive !== "undefined" ? Symbol.toPrimitive : "@@toPrimitive";
          var iteratorSymbol = supportsSymbol && typeof Symbol.iterator !== "undefined" ? Symbol.iterator : "@@iterator";
          var supportsCreate = typeof Object.create === "function"; // feature test for Object.create support

          var supportsProto = {
            __proto__: []
          } instanceof Array; // feature test for __proto__ support

          var downLevel = !supportsCreate && !supportsProto;
          var HashMap = {
            // create an object in dictionary mode (a.k.a. "slow" mode in v8)
            create: supportsCreate ? function () {
              return MakeDictionary(Object.create(null));
            } : supportsProto ? function () {
              return MakeDictionary({
                __proto__: null
              });
            } : function () {
              return MakeDictionary({});
            },
            has: downLevel ? function (map, key) {
              return hasOwn.call(map, key);
            } : function (map, key) {
              return key in map;
            },
            get: downLevel ? function (map, key) {
              return hasOwn.call(map, key) ? map[key] : undefined;
            } : function (map, key) {
              return map[key];
            }
          }; // Load global or shim versions of Map, Set, and WeakMap

          var functionPrototype = Object.getPrototypeOf(Function);
          var usePolyfill = _typeof(process) === "object" && process.env && process.env["REFLECT_METADATA_USE_MAP_POLYFILL"] === "true";

          var _Map = !usePolyfill && typeof Map === "function" && typeof Map.prototype.entries === "function" ? Map : CreateMapPolyfill();

          var _Set = !usePolyfill && typeof Set === "function" && typeof Set.prototype.entries === "function" ? Set : CreateSetPolyfill();

          var _WeakMap = !usePolyfill && typeof WeakMap === "function" ? WeakMap : CreateWeakMapPolyfill(); // [[Metadata]] internal slot
          // https://rbuckton.github.io/reflect-metadata/#ordinary-object-internal-methods-and-internal-slots


          var Metadata = new _WeakMap();
          /**
           * Applies a set of decorators to a property of a target object.
           * @param decorators An array of decorators.
           * @param target The target object.
           * @param propertyKey (Optional) The property key to decorate.
           * @param attributes (Optional) The property descriptor for the target key.
           * @remarks Decorators are applied in reverse order.
           * @example
           *
           *     class Example {
           *         // property declarations are not part of ES6, though they are valid in TypeScript:
           *         // static staticProperty;
           *         // property;
           *
           *         constructor(p) { }
           *         static staticMethod(p) { }
           *         method(p) { }
           *     }
           *
           *     // constructor
           *     Example = Reflect.decorate(decoratorsArray, Example);
           *
           *     // property (on constructor)
           *     Reflect.decorate(decoratorsArray, Example, "staticProperty");
           *
           *     // property (on prototype)
           *     Reflect.decorate(decoratorsArray, Example.prototype, "property");
           *
           *     // method (on constructor)
           *     Object.defineProperty(Example, "staticMethod",
           *         Reflect.decorate(decoratorsArray, Example, "staticMethod",
           *             Object.getOwnPropertyDescriptor(Example, "staticMethod")));
           *
           *     // method (on prototype)
           *     Object.defineProperty(Example.prototype, "method",
           *         Reflect.decorate(decoratorsArray, Example.prototype, "method",
           *             Object.getOwnPropertyDescriptor(Example.prototype, "method")));
           *
           */

          function decorate(decorators, target, propertyKey, attributes) {
            if (!IsUndefined(propertyKey)) {
              if (!IsArray(decorators)) throw new TypeError();
              if (!IsObject(target)) throw new TypeError();
              if (!IsObject(attributes) && !IsUndefined(attributes) && !IsNull(attributes)) throw new TypeError();
              if (IsNull(attributes)) attributes = undefined;
              propertyKey = ToPropertyKey(propertyKey);
              return DecorateProperty(decorators, target, propertyKey, attributes);
            } else {
              if (!IsArray(decorators)) throw new TypeError();
              if (!IsConstructor(target)) throw new TypeError();
              return DecorateConstructor(decorators, target);
            }
          }

          exporter("decorate", decorate); // 4.1.2 Reflect.metadata(metadataKey, metadataValue)
          // https://rbuckton.github.io/reflect-metadata/#reflect.metadata

          /**
           * A default metadata decorator factory that can be used on a class, class member, or parameter.
           * @param metadataKey The key for the metadata entry.
           * @param metadataValue The value for the metadata entry.
           * @returns A decorator function.
           * @remarks
           * If `metadataKey` is already defined for the target and target key, the
           * metadataValue for that key will be overwritten.
           * @example
           *
           *     // constructor
           *     @Reflect.metadata(key, value)
           *     class Example {
           *     }
           *
           *     // property (on constructor, TypeScript only)
           *     class Example {
           *         @Reflect.metadata(key, value)
           *         static staticProperty;
           *     }
           *
           *     // property (on prototype, TypeScript only)
           *     class Example {
           *         @Reflect.metadata(key, value)
           *         property;
           *     }
           *
           *     // method (on constructor)
           *     class Example {
           *         @Reflect.metadata(key, value)
           *         static staticMethod() { }
           *     }
           *
           *     // method (on prototype)
           *     class Example {
           *         @Reflect.metadata(key, value)
           *         method() { }
           *     }
           *
           */

          function metadata(metadataKey, metadataValue) {
            function decorator(target, propertyKey) {
              if (!IsObject(target)) throw new TypeError();
              if (!IsUndefined(propertyKey) && !IsPropertyKey(propertyKey)) throw new TypeError();
              OrdinaryDefineOwnMetadata(metadataKey, metadataValue, target, propertyKey);
            }

            return decorator;
          }

          exporter("metadata", metadata);
          /**
           * Define a unique metadata entry on the target.
           * @param metadataKey A key used to store and retrieve metadata.
           * @param metadataValue A value that contains attached metadata.
           * @param target The target object on which to define metadata.
           * @param propertyKey (Optional) The property key for the target.
           * @example
           *
           *     class Example {
           *         // property declarations are not part of ES6, though they are valid in TypeScript:
           *         // static staticProperty;
           *         // property;
           *
           *         constructor(p) { }
           *         static staticMethod(p) { }
           *         method(p) { }
           *     }
           *
           *     // constructor
           *     Reflect.defineMetadata("custom:annotation", options, Example);
           *
           *     // property (on constructor)
           *     Reflect.defineMetadata("custom:annotation", options, Example, "staticProperty");
           *
           *     // property (on prototype)
           *     Reflect.defineMetadata("custom:annotation", options, Example.prototype, "property");
           *
           *     // method (on constructor)
           *     Reflect.defineMetadata("custom:annotation", options, Example, "staticMethod");
           *
           *     // method (on prototype)
           *     Reflect.defineMetadata("custom:annotation", options, Example.prototype, "method");
           *
           *     // decorator factory as metadata-producing annotation.
           *     function MyAnnotation(options): Decorator {
           *         return (target, key?) => Reflect.defineMetadata("custom:annotation", options, target, key);
           *     }
           *
           */

          function defineMetadata(metadataKey, metadataValue, target, propertyKey) {
            if (!IsObject(target)) throw new TypeError();
            if (!IsUndefined(propertyKey)) propertyKey = ToPropertyKey(propertyKey);
            return OrdinaryDefineOwnMetadata(metadataKey, metadataValue, target, propertyKey);
          }

          exporter("defineMetadata", defineMetadata);
          /**
           * Gets a value indicating whether the target object or its prototype chain has the provided metadata key defined.
           * @param metadataKey A key used to store and retrieve metadata.
           * @param target The target object on which the metadata is defined.
           * @param propertyKey (Optional) The property key for the target.
           * @returns `true` if the metadata key was defined on the target object or its prototype chain; otherwise, `false`.
           * @example
           *
           *     class Example {
           *         // property declarations are not part of ES6, though they are valid in TypeScript:
           *         // static staticProperty;
           *         // property;
           *
           *         constructor(p) { }
           *         static staticMethod(p) { }
           *         method(p) { }
           *     }
           *
           *     // constructor
           *     result = Reflect.hasMetadata("custom:annotation", Example);
           *
           *     // property (on constructor)
           *     result = Reflect.hasMetadata("custom:annotation", Example, "staticProperty");
           *
           *     // property (on prototype)
           *     result = Reflect.hasMetadata("custom:annotation", Example.prototype, "property");
           *
           *     // method (on constructor)
           *     result = Reflect.hasMetadata("custom:annotation", Example, "staticMethod");
           *
           *     // method (on prototype)
           *     result = Reflect.hasMetadata("custom:annotation", Example.prototype, "method");
           *
           */

          function hasMetadata(metadataKey, target, propertyKey) {
            if (!IsObject(target)) throw new TypeError();
            if (!IsUndefined(propertyKey)) propertyKey = ToPropertyKey(propertyKey);
            return OrdinaryHasMetadata(metadataKey, target, propertyKey);
          }

          exporter("hasMetadata", hasMetadata);
          /**
           * Gets a value indicating whether the target object has the provided metadata key defined.
           * @param metadataKey A key used to store and retrieve metadata.
           * @param target The target object on which the metadata is defined.
           * @param propertyKey (Optional) The property key for the target.
           * @returns `true` if the metadata key was defined on the target object; otherwise, `false`.
           * @example
           *
           *     class Example {
           *         // property declarations are not part of ES6, though they are valid in TypeScript:
           *         // static staticProperty;
           *         // property;
           *
           *         constructor(p) { }
           *         static staticMethod(p) { }
           *         method(p) { }
           *     }
           *
           *     // constructor
           *     result = Reflect.hasOwnMetadata("custom:annotation", Example);
           *
           *     // property (on constructor)
           *     result = Reflect.hasOwnMetadata("custom:annotation", Example, "staticProperty");
           *
           *     // property (on prototype)
           *     result = Reflect.hasOwnMetadata("custom:annotation", Example.prototype, "property");
           *
           *     // method (on constructor)
           *     result = Reflect.hasOwnMetadata("custom:annotation", Example, "staticMethod");
           *
           *     // method (on prototype)
           *     result = Reflect.hasOwnMetadata("custom:annotation", Example.prototype, "method");
           *
           */

          function hasOwnMetadata(metadataKey, target, propertyKey) {
            if (!IsObject(target)) throw new TypeError();
            if (!IsUndefined(propertyKey)) propertyKey = ToPropertyKey(propertyKey);
            return OrdinaryHasOwnMetadata(metadataKey, target, propertyKey);
          }

          exporter("hasOwnMetadata", hasOwnMetadata);
          /**
           * Gets the metadata value for the provided metadata key on the target object or its prototype chain.
           * @param metadataKey A key used to store and retrieve metadata.
           * @param target The target object on which the metadata is defined.
           * @param propertyKey (Optional) The property key for the target.
           * @returns The metadata value for the metadata key if found; otherwise, `undefined`.
           * @example
           *
           *     class Example {
           *         // property declarations are not part of ES6, though they are valid in TypeScript:
           *         // static staticProperty;
           *         // property;
           *
           *         constructor(p) { }
           *         static staticMethod(p) { }
           *         method(p) { }
           *     }
           *
           *     // constructor
           *     result = Reflect.getMetadata("custom:annotation", Example);
           *
           *     // property (on constructor)
           *     result = Reflect.getMetadata("custom:annotation", Example, "staticProperty");
           *
           *     // property (on prototype)
           *     result = Reflect.getMetadata("custom:annotation", Example.prototype, "property");
           *
           *     // method (on constructor)
           *     result = Reflect.getMetadata("custom:annotation", Example, "staticMethod");
           *
           *     // method (on prototype)
           *     result = Reflect.getMetadata("custom:annotation", Example.prototype, "method");
           *
           */

          function getMetadata(metadataKey, target, propertyKey) {
            if (!IsObject(target)) throw new TypeError();
            if (!IsUndefined(propertyKey)) propertyKey = ToPropertyKey(propertyKey);
            return OrdinaryGetMetadata(metadataKey, target, propertyKey);
          }

          exporter("getMetadata", getMetadata);
          /**
           * Gets the metadata value for the provided metadata key on the target object.
           * @param metadataKey A key used to store and retrieve metadata.
           * @param target The target object on which the metadata is defined.
           * @param propertyKey (Optional) The property key for the target.
           * @returns The metadata value for the metadata key if found; otherwise, `undefined`.
           * @example
           *
           *     class Example {
           *         // property declarations are not part of ES6, though they are valid in TypeScript:
           *         // static staticProperty;
           *         // property;
           *
           *         constructor(p) { }
           *         static staticMethod(p) { }
           *         method(p) { }
           *     }
           *
           *     // constructor
           *     result = Reflect.getOwnMetadata("custom:annotation", Example);
           *
           *     // property (on constructor)
           *     result = Reflect.getOwnMetadata("custom:annotation", Example, "staticProperty");
           *
           *     // property (on prototype)
           *     result = Reflect.getOwnMetadata("custom:annotation", Example.prototype, "property");
           *
           *     // method (on constructor)
           *     result = Reflect.getOwnMetadata("custom:annotation", Example, "staticMethod");
           *
           *     // method (on prototype)
           *     result = Reflect.getOwnMetadata("custom:annotation", Example.prototype, "method");
           *
           */

          function getOwnMetadata(metadataKey, target, propertyKey) {
            if (!IsObject(target)) throw new TypeError();
            if (!IsUndefined(propertyKey)) propertyKey = ToPropertyKey(propertyKey);
            return OrdinaryGetOwnMetadata(metadataKey, target, propertyKey);
          }

          exporter("getOwnMetadata", getOwnMetadata);
          /**
           * Gets the metadata keys defined on the target object or its prototype chain.
           * @param target The target object on which the metadata is defined.
           * @param propertyKey (Optional) The property key for the target.
           * @returns An array of unique metadata keys.
           * @example
           *
           *     class Example {
           *         // property declarations are not part of ES6, though they are valid in TypeScript:
           *         // static staticProperty;
           *         // property;
           *
           *         constructor(p) { }
           *         static staticMethod(p) { }
           *         method(p) { }
           *     }
           *
           *     // constructor
           *     result = Reflect.getMetadataKeys(Example);
           *
           *     // property (on constructor)
           *     result = Reflect.getMetadataKeys(Example, "staticProperty");
           *
           *     // property (on prototype)
           *     result = Reflect.getMetadataKeys(Example.prototype, "property");
           *
           *     // method (on constructor)
           *     result = Reflect.getMetadataKeys(Example, "staticMethod");
           *
           *     // method (on prototype)
           *     result = Reflect.getMetadataKeys(Example.prototype, "method");
           *
           */

          function getMetadataKeys(target, propertyKey) {
            if (!IsObject(target)) throw new TypeError();
            if (!IsUndefined(propertyKey)) propertyKey = ToPropertyKey(propertyKey);
            return OrdinaryMetadataKeys(target, propertyKey);
          }

          exporter("getMetadataKeys", getMetadataKeys);
          /**
           * Gets the unique metadata keys defined on the target object.
           * @param target The target object on which the metadata is defined.
           * @param propertyKey (Optional) The property key for the target.
           * @returns An array of unique metadata keys.
           * @example
           *
           *     class Example {
           *         // property declarations are not part of ES6, though they are valid in TypeScript:
           *         // static staticProperty;
           *         // property;
           *
           *         constructor(p) { }
           *         static staticMethod(p) { }
           *         method(p) { }
           *     }
           *
           *     // constructor
           *     result = Reflect.getOwnMetadataKeys(Example);
           *
           *     // property (on constructor)
           *     result = Reflect.getOwnMetadataKeys(Example, "staticProperty");
           *
           *     // property (on prototype)
           *     result = Reflect.getOwnMetadataKeys(Example.prototype, "property");
           *
           *     // method (on constructor)
           *     result = Reflect.getOwnMetadataKeys(Example, "staticMethod");
           *
           *     // method (on prototype)
           *     result = Reflect.getOwnMetadataKeys(Example.prototype, "method");
           *
           */

          function getOwnMetadataKeys(target, propertyKey) {
            if (!IsObject(target)) throw new TypeError();
            if (!IsUndefined(propertyKey)) propertyKey = ToPropertyKey(propertyKey);
            return OrdinaryOwnMetadataKeys(target, propertyKey);
          }

          exporter("getOwnMetadataKeys", getOwnMetadataKeys);
          /**
           * Deletes the metadata entry from the target object with the provided key.
           * @param metadataKey A key used to store and retrieve metadata.
           * @param target The target object on which the metadata is defined.
           * @param propertyKey (Optional) The property key for the target.
           * @returns `true` if the metadata entry was found and deleted; otherwise, false.
           * @example
           *
           *     class Example {
           *         // property declarations are not part of ES6, though they are valid in TypeScript:
           *         // static staticProperty;
           *         // property;
           *
           *         constructor(p) { }
           *         static staticMethod(p) { }
           *         method(p) { }
           *     }
           *
           *     // constructor
           *     result = Reflect.deleteMetadata("custom:annotation", Example);
           *
           *     // property (on constructor)
           *     result = Reflect.deleteMetadata("custom:annotation", Example, "staticProperty");
           *
           *     // property (on prototype)
           *     result = Reflect.deleteMetadata("custom:annotation", Example.prototype, "property");
           *
           *     // method (on constructor)
           *     result = Reflect.deleteMetadata("custom:annotation", Example, "staticMethod");
           *
           *     // method (on prototype)
           *     result = Reflect.deleteMetadata("custom:annotation", Example.prototype, "method");
           *
           */

          function deleteMetadata(metadataKey, target, propertyKey) {
            if (!IsObject(target)) throw new TypeError();
            if (!IsUndefined(propertyKey)) propertyKey = ToPropertyKey(propertyKey);
            var metadataMap = GetOrCreateMetadataMap(target, propertyKey,
            /*Create*/
            false);
            if (IsUndefined(metadataMap)) return false;
            if (!metadataMap["delete"](metadataKey)) return false;
            if (metadataMap.size > 0) return true;
            var targetMetadata = Metadata.get(target);
            targetMetadata["delete"](propertyKey);
            if (targetMetadata.size > 0) return true;
            Metadata["delete"](target);
            return true;
          }

          exporter("deleteMetadata", deleteMetadata);

          function DecorateConstructor(decorators, target) {
            for (var i = decorators.length - 1; i >= 0; --i) {
              var decorator = decorators[i];
              var decorated = decorator(target);

              if (!IsUndefined(decorated) && !IsNull(decorated)) {
                if (!IsConstructor(decorated)) throw new TypeError();
                target = decorated;
              }
            }

            return target;
          }

          function DecorateProperty(decorators, target, propertyKey, descriptor) {
            for (var i = decorators.length - 1; i >= 0; --i) {
              var decorator = decorators[i];
              var decorated = decorator(target, propertyKey, descriptor);

              if (!IsUndefined(decorated) && !IsNull(decorated)) {
                if (!IsObject(decorated)) throw new TypeError();
                descriptor = decorated;
              }
            }

            return descriptor;
          }

          function GetOrCreateMetadataMap(O, P, Create) {
            var targetMetadata = Metadata.get(O);

            if (IsUndefined(targetMetadata)) {
              if (!Create) return undefined;
              targetMetadata = new _Map();
              Metadata.set(O, targetMetadata);
            }

            var metadataMap = targetMetadata.get(P);

            if (IsUndefined(metadataMap)) {
              if (!Create) return undefined;
              metadataMap = new _Map();
              targetMetadata.set(P, metadataMap);
            }

            return metadataMap;
          } // 3.1.1.1 OrdinaryHasMetadata(MetadataKey, O, P)
          // https://rbuckton.github.io/reflect-metadata/#ordinaryhasmetadata


          function OrdinaryHasMetadata(MetadataKey, O, P) {
            var hasOwn = OrdinaryHasOwnMetadata(MetadataKey, O, P);
            if (hasOwn) return true;
            var parent = OrdinaryGetPrototypeOf(O);
            if (!IsNull(parent)) return OrdinaryHasMetadata(MetadataKey, parent, P);
            return false;
          } // 3.1.2.1 OrdinaryHasOwnMetadata(MetadataKey, O, P)
          // https://rbuckton.github.io/reflect-metadata/#ordinaryhasownmetadata


          function OrdinaryHasOwnMetadata(MetadataKey, O, P) {
            var metadataMap = GetOrCreateMetadataMap(O, P,
            /*Create*/
            false);
            if (IsUndefined(metadataMap)) return false;
            return ToBoolean(metadataMap.has(MetadataKey));
          } // 3.1.3.1 OrdinaryGetMetadata(MetadataKey, O, P)
          // https://rbuckton.github.io/reflect-metadata/#ordinarygetmetadata


          function OrdinaryGetMetadata(MetadataKey, O, P) {
            var hasOwn = OrdinaryHasOwnMetadata(MetadataKey, O, P);
            if (hasOwn) return OrdinaryGetOwnMetadata(MetadataKey, O, P);
            var parent = OrdinaryGetPrototypeOf(O);
            if (!IsNull(parent)) return OrdinaryGetMetadata(MetadataKey, parent, P);
            return undefined;
          } // 3.1.4.1 OrdinaryGetOwnMetadata(MetadataKey, O, P)
          // https://rbuckton.github.io/reflect-metadata/#ordinarygetownmetadata


          function OrdinaryGetOwnMetadata(MetadataKey, O, P) {
            var metadataMap = GetOrCreateMetadataMap(O, P,
            /*Create*/
            false);
            if (IsUndefined(metadataMap)) return undefined;
            return metadataMap.get(MetadataKey);
          } // 3.1.5.1 OrdinaryDefineOwnMetadata(MetadataKey, MetadataValue, O, P)
          // https://rbuckton.github.io/reflect-metadata/#ordinarydefineownmetadata


          function OrdinaryDefineOwnMetadata(MetadataKey, MetadataValue, O, P) {
            var metadataMap = GetOrCreateMetadataMap(O, P,
            /*Create*/
            true);
            metadataMap.set(MetadataKey, MetadataValue);
          } // 3.1.6.1 OrdinaryMetadataKeys(O, P)
          // https://rbuckton.github.io/reflect-metadata/#ordinarymetadatakeys


          function OrdinaryMetadataKeys(O, P) {
            var ownKeys = OrdinaryOwnMetadataKeys(O, P);
            var parent = OrdinaryGetPrototypeOf(O);
            if (parent === null) return ownKeys;
            var parentKeys = OrdinaryMetadataKeys(parent, P);
            if (parentKeys.length <= 0) return ownKeys;
            if (ownKeys.length <= 0) return parentKeys;
            var set = new _Set();
            var keys = [];

            for (var _i = 0, ownKeys_1 = ownKeys; _i < ownKeys_1.length; _i++) {
              var key = ownKeys_1[_i];
              var hasKey = set.has(key);

              if (!hasKey) {
                set.add(key);
                keys.push(key);
              }
            }

            for (var _a = 0, parentKeys_1 = parentKeys; _a < parentKeys_1.length; _a++) {
              var key = parentKeys_1[_a];
              var hasKey = set.has(key);

              if (!hasKey) {
                set.add(key);
                keys.push(key);
              }
            }

            return keys;
          } // 3.1.7.1 OrdinaryOwnMetadataKeys(O, P)
          // https://rbuckton.github.io/reflect-metadata/#ordinaryownmetadatakeys


          function OrdinaryOwnMetadataKeys(O, P) {
            var keys = [];
            var metadataMap = GetOrCreateMetadataMap(O, P,
            /*Create*/
            false);
            if (IsUndefined(metadataMap)) return keys;
            var keysObj = metadataMap.keys();
            var iterator = GetIterator(keysObj);
            var k = 0;

            while (true) {
              var next = IteratorStep(iterator);

              if (!next) {
                keys.length = k;
                return keys;
              }

              var nextValue = IteratorValue(next);

              try {
                keys[k] = nextValue;
              } catch (e) {
                try {
                  IteratorClose(iterator);
                } finally {
                  throw e;
                }
              }

              k++;
            }
          } // 6 ECMAScript Data Typ0es and Values
          // https://tc39.github.io/ecma262/#sec-ecmascript-data-types-and-values


          function Type(x) {
            if (x === null) return 1
            /* Null */
            ;

            switch (_typeof(x)) {
              case "undefined":
                return 0
                /* Undefined */
                ;

              case "boolean":
                return 2
                /* Boolean */
                ;

              case "string":
                return 3
                /* String */
                ;

              case "symbol":
                return 4
                /* Symbol */
                ;

              case "number":
                return 5
                /* Number */
                ;

              case "object":
                return x === null ? 1
                /* Null */
                : 6
                /* Object */
                ;

              default:
                return 6
                /* Object */
                ;
            }
          } // 6.1.1 The Undefined Type
          // https://tc39.github.io/ecma262/#sec-ecmascript-language-types-undefined-type


          function IsUndefined(x) {
            return x === undefined;
          } // 6.1.2 The Null Type
          // https://tc39.github.io/ecma262/#sec-ecmascript-language-types-null-type


          function IsNull(x) {
            return x === null;
          } // 6.1.5 The Symbol Type
          // https://tc39.github.io/ecma262/#sec-ecmascript-language-types-symbol-type


          function IsSymbol(x) {
            return _typeof(x) === "symbol";
          } // 6.1.7 The Object Type
          // https://tc39.github.io/ecma262/#sec-object-type


          function IsObject(x) {
            return _typeof(x) === "object" ? x !== null : typeof x === "function";
          } // 7.1 Type Conversion
          // https://tc39.github.io/ecma262/#sec-type-conversion
          // 7.1.1 ToPrimitive(input [, PreferredType])
          // https://tc39.github.io/ecma262/#sec-toprimitive


          function ToPrimitive(input, PreferredType) {
            switch (Type(input)) {
              case 0
              /* Undefined */
              :
                return input;

              case 1
              /* Null */
              :
                return input;

              case 2
              /* Boolean */
              :
                return input;

              case 3
              /* String */
              :
                return input;

              case 4
              /* Symbol */
              :
                return input;

              case 5
              /* Number */
              :
                return input;
            }

            var hint = PreferredType === 3
            /* String */
            ? "string" : PreferredType === 5
            /* Number */
            ? "number" : "default";
            var exoticToPrim = GetMethod(input, toPrimitiveSymbol);

            if (exoticToPrim !== undefined) {
              var result = exoticToPrim.call(input, hint);
              if (IsObject(result)) throw new TypeError();
              return result;
            }

            return OrdinaryToPrimitive(input, hint === "default" ? "number" : hint);
          } // 7.1.1.1 OrdinaryToPrimitive(O, hint)
          // https://tc39.github.io/ecma262/#sec-ordinarytoprimitive


          function OrdinaryToPrimitive(O, hint) {
            if (hint === "string") {
              var toString_1 = O.toString;

              if (IsCallable(toString_1)) {
                var result = toString_1.call(O);
                if (!IsObject(result)) return result;
              }

              var valueOf = O.valueOf;

              if (IsCallable(valueOf)) {
                var result = valueOf.call(O);
                if (!IsObject(result)) return result;
              }
            } else {
              var valueOf = O.valueOf;

              if (IsCallable(valueOf)) {
                var result = valueOf.call(O);
                if (!IsObject(result)) return result;
              }

              var toString_2 = O.toString;

              if (IsCallable(toString_2)) {
                var result = toString_2.call(O);
                if (!IsObject(result)) return result;
              }
            }

            throw new TypeError();
          } // 7.1.2 ToBoolean(argument)
          // https://tc39.github.io/ecma262/2016/#sec-toboolean


          function ToBoolean(argument) {
            return !!argument;
          } // 7.1.12 ToString(argument)
          // https://tc39.github.io/ecma262/#sec-tostring


          function ToString(argument) {
            return "" + argument;
          } // 7.1.14 ToPropertyKey(argument)
          // https://tc39.github.io/ecma262/#sec-topropertykey


          function ToPropertyKey(argument) {
            var key = ToPrimitive(argument, 3
            /* String */
            );
            if (IsSymbol(key)) return key;
            return ToString(key);
          } // 7.2 Testing and Comparison Operations
          // https://tc39.github.io/ecma262/#sec-testing-and-comparison-operations
          // 7.2.2 IsArray(argument)
          // https://tc39.github.io/ecma262/#sec-isarray


          function IsArray(argument) {
            return Array.isArray ? Array.isArray(argument) : argument instanceof Object ? argument instanceof Array : Object.prototype.toString.call(argument) === "[object Array]";
          } // 7.2.3 IsCallable(argument)
          // https://tc39.github.io/ecma262/#sec-iscallable


          function IsCallable(argument) {
            // NOTE: This is an approximation as we cannot check for [[Call]] internal method.
            return typeof argument === "function";
          } // 7.2.4 IsConstructor(argument)
          // https://tc39.github.io/ecma262/#sec-isconstructor


          function IsConstructor(argument) {
            // NOTE: This is an approximation as we cannot check for [[Construct]] internal method.
            return typeof argument === "function";
          } // 7.2.7 IsPropertyKey(argument)
          // https://tc39.github.io/ecma262/#sec-ispropertykey


          function IsPropertyKey(argument) {
            switch (Type(argument)) {
              case 3
              /* String */
              :
                return true;

              case 4
              /* Symbol */
              :
                return true;

              default:
                return false;
            }
          } // 7.3 Operations on Objects
          // https://tc39.github.io/ecma262/#sec-operations-on-objects
          // 7.3.9 GetMethod(V, P)
          // https://tc39.github.io/ecma262/#sec-getmethod


          function GetMethod(V, P) {
            var func = V[P];
            if (func === undefined || func === null) return undefined;
            if (!IsCallable(func)) throw new TypeError();
            return func;
          } // 7.4 Operations on Iterator Objects
          // https://tc39.github.io/ecma262/#sec-operations-on-iterator-objects


          function GetIterator(obj) {
            var method = GetMethod(obj, iteratorSymbol);
            if (!IsCallable(method)) throw new TypeError(); // from Call

            var iterator = method.call(obj);
            if (!IsObject(iterator)) throw new TypeError();
            return iterator;
          } // 7.4.4 IteratorValue(iterResult)
          // https://tc39.github.io/ecma262/2016/#sec-iteratorvalue


          function IteratorValue(iterResult) {
            return iterResult.value;
          } // 7.4.5 IteratorStep(iterator)
          // https://tc39.github.io/ecma262/#sec-iteratorstep


          function IteratorStep(iterator) {
            var result = iterator.next();
            return result.done ? false : result;
          } // 7.4.6 IteratorClose(iterator, completion)
          // https://tc39.github.io/ecma262/#sec-iteratorclose


          function IteratorClose(iterator) {
            var f = iterator["return"];
            if (f) f.call(iterator);
          } // 9.1 Ordinary Object Internal Methods and Internal Slots
          // https://tc39.github.io/ecma262/#sec-ordinary-object-internal-methods-and-internal-slots
          // 9.1.1.1 OrdinaryGetPrototypeOf(O)
          // https://tc39.github.io/ecma262/#sec-ordinarygetprototypeof


          function OrdinaryGetPrototypeOf(O) {
            var proto = Object.getPrototypeOf(O);
            if (typeof O !== "function" || O === functionPrototype) return proto; // TypeScript doesn't set __proto__ in ES5, as it's non-standard.
            // Try to determine the superclass constructor. Compatible implementations
            // must either set __proto__ on a subclass constructor to the superclass constructor,
            // or ensure each class has a valid `constructor` property on its prototype that
            // points back to the constructor.
            // If this is not the same as Function.[[Prototype]], then this is definately inherited.
            // This is the case when in ES6 or when using __proto__ in a compatible browser.

            if (proto !== functionPrototype) return proto; // If the super prototype is Object.prototype, null, or undefined, then we cannot determine the heritage.

            var prototype = O.prototype;
            var prototypeProto = prototype && Object.getPrototypeOf(prototype);
            if (prototypeProto == null || prototypeProto === Object.prototype) return proto; // If the constructor was not a function, then we cannot determine the heritage.

            var constructor = prototypeProto.constructor;
            if (typeof constructor !== "function") return proto; // If we have some kind of self-reference, then we cannot determine the heritage.

            if (constructor === O) return proto; // we have a pretty good guess at the heritage.

            return constructor;
          } // naive Map shim


          function CreateMapPolyfill() {
            var cacheSentinel = {};
            var arraySentinel = [];

            var MapIterator =
            /** @class */
            function () {
              function MapIterator(keys, values, selector) {
                this._index = 0;
                this._keys = keys;
                this._values = values;
                this._selector = selector;
              }

              MapIterator.prototype["@@iterator"] = function () {
                return this;
              };

              MapIterator.prototype[iteratorSymbol] = function () {
                return this;
              };

              MapIterator.prototype.next = function () {
                var index = this._index;

                if (index >= 0 && index < this._keys.length) {
                  var result = this._selector(this._keys[index], this._values[index]);

                  if (index + 1 >= this._keys.length) {
                    this._index = -1;
                    this._keys = arraySentinel;
                    this._values = arraySentinel;
                  } else {
                    this._index++;
                  }

                  return {
                    value: result,
                    done: false
                  };
                }

                return {
                  value: undefined,
                  done: true
                };
              };

              MapIterator.prototype["throw"] = function (error) {
                if (this._index >= 0) {
                  this._index = -1;
                  this._keys = arraySentinel;
                  this._values = arraySentinel;
                }

                throw error;
              };

              MapIterator.prototype["return"] = function (value) {
                if (this._index >= 0) {
                  this._index = -1;
                  this._keys = arraySentinel;
                  this._values = arraySentinel;
                }

                return {
                  value: value,
                  done: true
                };
              };

              return MapIterator;
            }();

            return (
              /** @class */
              function () {
                function Map() {
                  this._keys = [];
                  this._values = [];
                  this._cacheKey = cacheSentinel;
                  this._cacheIndex = -2;
                }

                Object.defineProperty(Map.prototype, "size", {
                  get: function get() {
                    return this._keys.length;
                  },
                  enumerable: true,
                  configurable: true
                });

                Map.prototype.has = function (key) {
                  return this._find(key,
                  /*insert*/
                  false) >= 0;
                };

                Map.prototype.get = function (key) {
                  var index = this._find(key,
                  /*insert*/
                  false);

                  return index >= 0 ? this._values[index] : undefined;
                };

                Map.prototype.set = function (key, value) {
                  var index = this._find(key,
                  /*insert*/
                  true);

                  this._values[index] = value;
                  return this;
                };

                Map.prototype["delete"] = function (key) {
                  var index = this._find(key,
                  /*insert*/
                  false);

                  if (index >= 0) {
                    var size = this._keys.length;

                    for (var i = index + 1; i < size; i++) {
                      this._keys[i - 1] = this._keys[i];
                      this._values[i - 1] = this._values[i];
                    }

                    this._keys.length--;
                    this._values.length--;

                    if (key === this._cacheKey) {
                      this._cacheKey = cacheSentinel;
                      this._cacheIndex = -2;
                    }

                    return true;
                  }

                  return false;
                };

                Map.prototype.clear = function () {
                  this._keys.length = 0;
                  this._values.length = 0;
                  this._cacheKey = cacheSentinel;
                  this._cacheIndex = -2;
                };

                Map.prototype.keys = function () {
                  return new MapIterator(this._keys, this._values, getKey);
                };

                Map.prototype.values = function () {
                  return new MapIterator(this._keys, this._values, getValue);
                };

                Map.prototype.entries = function () {
                  return new MapIterator(this._keys, this._values, getEntry);
                };

                Map.prototype["@@iterator"] = function () {
                  return this.entries();
                };

                Map.prototype[iteratorSymbol] = function () {
                  return this.entries();
                };

                Map.prototype._find = function (key, insert) {
                  if (this._cacheKey !== key) {
                    this._cacheIndex = this._keys.indexOf(this._cacheKey = key);
                  }

                  if (this._cacheIndex < 0 && insert) {
                    this._cacheIndex = this._keys.length;

                    this._keys.push(key);

                    this._values.push(undefined);
                  }

                  return this._cacheIndex;
                };

                return Map;
              }()
            );

            function getKey(key, _) {
              return key;
            }

            function getValue(_, value) {
              return value;
            }

            function getEntry(key, value) {
              return [key, value];
            }
          } // naive Set shim


          function CreateSetPolyfill() {
            return (
              /** @class */
              function () {
                function Set() {
                  this._map = new _Map();
                }

                Object.defineProperty(Set.prototype, "size", {
                  get: function get() {
                    return this._map.size;
                  },
                  enumerable: true,
                  configurable: true
                });

                Set.prototype.has = function (value) {
                  return this._map.has(value);
                };

                Set.prototype.add = function (value) {
                  return this._map.set(value, value), this;
                };

                Set.prototype["delete"] = function (value) {
                  return this._map["delete"](value);
                };

                Set.prototype.clear = function () {
                  this._map.clear();
                };

                Set.prototype.keys = function () {
                  return this._map.keys();
                };

                Set.prototype.values = function () {
                  return this._map.values();
                };

                Set.prototype.entries = function () {
                  return this._map.entries();
                };

                Set.prototype["@@iterator"] = function () {
                  return this.keys();
                };

                Set.prototype[iteratorSymbol] = function () {
                  return this.keys();
                };

                return Set;
              }()
            );
          } // naive WeakMap shim


          function CreateWeakMapPolyfill() {
            var UUID_SIZE = 16;
            var keys = HashMap.create();
            var rootKey = CreateUniqueKey();
            return (
              /** @class */
              function () {
                function WeakMap() {
                  this._key = CreateUniqueKey();
                }

                WeakMap.prototype.has = function (target) {
                  var table = GetOrCreateWeakMapTable(target,
                  /*create*/
                  false);
                  return table !== undefined ? HashMap.has(table, this._key) : false;
                };

                WeakMap.prototype.get = function (target) {
                  var table = GetOrCreateWeakMapTable(target,
                  /*create*/
                  false);
                  return table !== undefined ? HashMap.get(table, this._key) : undefined;
                };

                WeakMap.prototype.set = function (target, value) {
                  var table = GetOrCreateWeakMapTable(target,
                  /*create*/
                  true);
                  table[this._key] = value;
                  return this;
                };

                WeakMap.prototype["delete"] = function (target) {
                  var table = GetOrCreateWeakMapTable(target,
                  /*create*/
                  false);
                  return table !== undefined ? delete table[this._key] : false;
                };

                WeakMap.prototype.clear = function () {
                  // NOTE: not a real clear, just makes the previous data unreachable
                  this._key = CreateUniqueKey();
                };

                return WeakMap;
              }()
            );

            function CreateUniqueKey() {
              var key;

              do {
                key = "@@WeakMap@@" + CreateUUID();
              } while (HashMap.has(keys, key));

              keys[key] = true;
              return key;
            }

            function GetOrCreateWeakMapTable(target, create) {
              if (!hasOwn.call(target, rootKey)) {
                if (!create) return undefined;
                Object.defineProperty(target, rootKey, {
                  value: HashMap.create()
                });
              }

              return target[rootKey];
            }

            function FillRandomBytes(buffer, size) {
              for (var i = 0; i < size; ++i) {
                buffer[i] = Math.random() * 0xff | 0;
              }

              return buffer;
            }

            function GenRandomBytes(size) {
              if (typeof Uint8Array === "function") {
                if (typeof crypto !== "undefined") return crypto.getRandomValues(new Uint8Array(size));
                if (typeof msCrypto !== "undefined") return msCrypto.getRandomValues(new Uint8Array(size));
                return FillRandomBytes(new Uint8Array(size), size);
              }

              return FillRandomBytes(new Array(size), size);
            }

            function CreateUUID() {
              var data = GenRandomBytes(UUID_SIZE); // mark as random - RFC 4122 § 4.4

              data[6] = data[6] & 0x4f | 0x40;
              data[8] = data[8] & 0xbf | 0x80;
              var result = "";

              for (var offset = 0; offset < UUID_SIZE; ++offset) {
                var _byte = data[offset];
                if (offset === 4 || offset === 6 || offset === 8) result += "-";
                if (_byte < 16) result += "0";
                result += _byte.toString(16).toLowerCase();
              }

              return result;
            }
          } // uses a heuristic used by v8 and chakra to force an object into dictionary mode.


          function MakeDictionary(obj) {
            obj.__ = undefined;
            delete obj.__;
            return obj;
          }
        });
      })(Reflect || (Reflect = {}));
      /* WEBPACK VAR INJECTION */

    }).call(this, __webpack_require__(
    /*! ./../process/browser.js */
    "./node_modules/process/browser.js"), __webpack_require__(
    /*! ./../webpack/buildin/global.js */
    "./node_modules/webpack/buildin/global.js"));
    /***/
  },

  /***/
  "./node_modules/webpack/buildin/global.js":
  /*!***********************************!*\
    !*** (webpack)/buildin/global.js ***!
    \***********************************/

  /*! no static exports found */

  /***/
  function node_modulesWebpackBuildinGlobalJs(module, exports) {
    var g; // This works in non-strict mode

    g = function () {
      return this;
    }();

    try {
      // This works if eval is allowed (see CSP)
      g = g || new Function("return this")();
    } catch (e) {
      // This works if the window reference is available
      if ((typeof window === "undefined" ? "undefined" : _typeof(window)) === "object") g = window;
    } // g can still be undefined, but nothing to do about it...
    // We return undefined, instead of nothing here, so it's
    // easier to handle this case. if(!global) { ...}


    module.exports = g;
    /***/
  },

  /***/
  0:
  /*!*************************************************************************************************************************************************************************************************************************************************************************!*\
    !*** multi ./_dev/js/adminConfigPage.ts ./_dev/scss/ifthenpayConfig.scss ./_dev/scss/ifthenpayPaymentMethodSetup.scss ./_dev/scss/ifthenpayConfirmPage.scss ./_dev/scss/ifthenpayAdminOrder.scss ./_dev/scss/ifthenpayOrderDetail.scss ./_dev/scss/paymentOptions.scss ***!
    \*************************************************************************************************************************************************************************************************************************************************************************/

  /*! no static exports found */

  /***/
  function _(module, exports, __webpack_require__) {
    __webpack_require__(
    /*! /var/www/html/prestashop/1787/modules/ifthenpay/_dev/js/adminConfigPage.ts */
    "./_dev/js/adminConfigPage.ts");

    __webpack_require__(
    /*! /var/www/html/prestashop/1787/modules/ifthenpay/_dev/scss/ifthenpayConfig.scss */
    "./_dev/scss/ifthenpayConfig.scss");

    __webpack_require__(
    /*! /var/www/html/prestashop/1787/modules/ifthenpay/_dev/scss/ifthenpayPaymentMethodSetup.scss */
    "./_dev/scss/ifthenpayPaymentMethodSetup.scss");

    __webpack_require__(
    /*! /var/www/html/prestashop/1787/modules/ifthenpay/_dev/scss/ifthenpayConfirmPage.scss */
    "./_dev/scss/ifthenpayConfirmPage.scss");

    __webpack_require__(
    /*! /var/www/html/prestashop/1787/modules/ifthenpay/_dev/scss/ifthenpayAdminOrder.scss */
    "./_dev/scss/ifthenpayAdminOrder.scss");

    __webpack_require__(
    /*! /var/www/html/prestashop/1787/modules/ifthenpay/_dev/scss/ifthenpayOrderDetail.scss */
    "./_dev/scss/ifthenpayOrderDetail.scss");

    module.exports = __webpack_require__(
    /*! /var/www/html/prestashop/1787/modules/ifthenpay/_dev/scss/paymentOptions.scss */
    "./_dev/scss/paymentOptions.scss");
    /***/
  }
  /******/

});
