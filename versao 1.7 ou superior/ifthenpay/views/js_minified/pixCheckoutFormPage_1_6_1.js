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

  return __webpack_require__(__webpack_require__.s = 5);
  /******/
}
/************************************************************************/

/******/
)({
  /***/
  "./_dev/js/pixCheckoutFormPage.ts":
  /*!****************************************!*\
    !*** ./_dev/js/pixCheckoutFormPage.ts ***!
    \****************************************/

  /*! no static exports found */

  /***/
  function _devJsPixCheckoutFormPageTs(module, exports) {
    var PixFormValidator =
    /** @class */
    function () {
      function PixFormValidator(formSelector) {
        if (formSelector === void 0) {
          formSelector = "#ifthenpay-pix-payment-form";
        }

        this.fieldsArray = ["#field-name", "#field-cpf", "#field-email"];
        this.formElement = $(formSelector);
      }

      PixFormValidator.prototype.init = function () {
        var self = this; // Wait for DOM to load

        document.addEventListener("DOMContentLoaded", function () {
          if (!self.formElement || !self.arePixFieldsPresent()) {
            console.log("PixFormValidator: pix form not detected");
            return;
          } //   name


          var nameField = self.formElement.find("#field-name");
          nameField.on("focusout", function () {
            nameField.parent().find(".error-message").hide();

            if (nameField.val() == "") {
              nameField.siblings(".message_required").show();
            }
          }); //   CPF

          var cpfField = self.formElement.find("#field-cpf");
          cpfField.on("focusout", function () {
            var _a;

            cpfField.parent().find(".error-message").hide();
            var cpfValue = ((_a = cpfField.val()) !== null && _a !== void 0 ? _a : "").toString();
            var cpfRegex = new RegExp(/^(\d{3}\.\d{3}\.\d{3}-\d{2}|\d{11})$/);

            if (cpfValue == "") {
              cpfField.siblings(".message_required").show();
            } else if (!cpfRegex.test(cpfValue)) {
              cpfField.siblings(".message_regex").show();
            }
          });
          cpfField.on("keyup", function () {
            var _a;

            var cpfValue = ((_a = cpfField.val()) !== null && _a !== void 0 ? _a : "").toString();
            var cpfRegex = new RegExp(/^(\d{3}\.\d{3}\.\d{3}-\d{2}|\d{11})$/);

            if (cpfRegex.test(cpfValue)) {
              cpfField.parent().find(".error-message").hide();
            }
          }); //   email

          var emailField = self.formElement.find("#field-email");
          emailField.on("focusout", function () {
            var _a;

            emailField.parent().find(".error-message").hide();
            var emailValue = ((_a = emailField.val()) !== null && _a !== void 0 ? _a : "").toString();
            var emailRegex = new RegExp(/^[^\s@]+@[^\s@]+\.[^\s@]+$/);

            if (emailValue == "") {
              emailField.siblings(".message_required").show();
            } else if (!emailRegex.test(emailValue)) {
              emailField.siblings(".message_regex").show();
            }
          });
          emailField.on("keyup", function () {
            var _a;

            var emailValue = ((_a = emailField.val()) !== null && _a !== void 0 ? _a : "").toString();
            var emailRegex = new RegExp(/^[^\s@]+@[^\s@]+\.[^\s@]+$/);

            if (emailRegex.test(emailValue)) {
              emailField.parent().find(".error-message").hide();
            }
          });
        });
      }; // Checks if required fields are present in the form


      PixFormValidator.prototype.arePixFieldsPresent = function () {
        var _this = this;

        return this.fieldsArray.every(function (field) {
          return _this.formElement.find("".concat(field)).length > 0;
        });
      };

      return PixFormValidator;
    }(); // Self-executing class instance


    new PixFormValidator().init();
    /***/
  },

  /***/
  5:
  /*!**********************************************!*\
    !*** multi ./_dev/js/pixCheckoutFormPage.ts ***!
    \**********************************************/

  /*! no static exports found */

  /***/
  function _(module, exports, __webpack_require__) {
    module.exports = __webpack_require__(
    /*! /home/devilbox/data/www/prestashop17/htdocs/modules/ifthenpay/_dev/js/pixCheckoutFormPage.ts */
    "./_dev/js/pixCheckoutFormPage.ts");
    /***/
  }
  /******/

});
