# Notice: 
## This module is only compatible with Prestashop 1.6 to 1.7. For Prestashop 8.0 and above, please use the [Ifthenpay Prestashop 8.0 payment module](https://github.com/ifthenpay/prestashop8)

</br>
</br>

# Ifthenpay Prestashop 1.7 payment module

Read this in ![Português](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/pt.png) [Portuguese](readme.pt.md), and ![Inglês](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/en.png) [English](readme.md)

[1. Introduction](#introduction)

[2. Compatibility](#compatibility)

[3. Installation](#installation)

[4. Configuration](#configuration)
  * [Backoffice Key](#backoffice-key)
  * [Enable Payment Method](#enable-payment-method)
  * [Multibanco](#multibanco)
  * [Multibanco with Dynamic References](#multibanco-with-dynamic-references)
  * [MB WAY](#mb-way)
  * [Credit Card](#credit-card)
  * [Payshop](#payshop)
  * [Cofidis Pay](#cofidis-pay)
  * [Pix](#pix)
  * [Ifthenpay Gateway](#ifthenpay-gateway)

[5. Edit payment details](#edit-payment-details)
  * [Update Payment Data](#update-payment-data)
  * [Resend Payment Data](#resend-payment-data)
  * [Remember Payment Data](#remember-payment-data)
  * [Choose Payment Method](#choose-payment-method)
  

[6. Other](#other)
  * [Support](#support)
  * [Request account](#request-account)
  * [Request additional account](#request-additional-account)
  * [Logs](#logs)
  * [Reset Configuration](#reset-configuration)
  * [Updates](#updates)
  * [Sandbox Mode](#sandbox-mode)
  * [Callback](#callback)
  * [Test Callback](#test-callback)
  * [Known bug and fixes](#known-bug-and-fixes)


[7. Customer usage experience](#customer-usage-experience)
  * [Paying order with Multibanco](#paying-order-with-multibanco)
  * [Paying order with Payshop](#paying-order-with-payshop)
  * [Paying order with MB WAY](#paying-order-with-mb-way)
  * [Paying order with Credit Card](#paying-order-with-credit-card)
  * [Paying order with Cofidis Pay](#paying-order-with-cofidis-pay)
  * [Paying order with Pix](#paying-order-with-pix)
  * [Paying order with Ifthenpay Gateway](#paying-order-with-ifthenpay-gateway)


# Introduction
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/payment_methods_banner.png)

**This is the Ifthenpay plugin for Prestashop e-commerce platform**

**Multibanco** is one Portuguese payment method that allows the customer to pay by bank reference.
This module will allow you to generate a payment Reference that the customer can then use to pay for his order on the ATM or Home Banking service. This plugin uses one of the several gateways/services available in Portugal, IfthenPay.

**MB WAY** is the first inter-bank solution that enables purchases and immediate transfers via smartphones and tablets.

This module will allow you to generate a request payment to the customer mobile phone, and he can authorize the payment for his order on the MB WAY App service. This module uses one of the several gateways/services available in Portugal, IfthenPay.

**Payshop** is one Portuguese payment method that allows the customer to pay by payshop reference.
This module will allow you to generate a payment Reference that the customer can then use to pay for his order on the Payshop agent or CTT. This module uses one of the several gateways/services available in Portugal, IfthenPay.

**Credit Card** This module will allow you to generate a payment by Visa or Master card, that the customer can then use to pay for his order. This module uses one of the several gateways/services available in Portugal, IfthenPay.

**Cofidis Pay** is a payment solution of up to 12 interest-free installments that makes it easier to pay for purchases by splitting them. This module uses one of the several gateways/services available in Portugal, IfthenPay.

**Contract with Ifthenpay is required.**

See more at [Ifthenpay](https://ifthenpay.com). 


# Compatibility

Follow the table below to verify Ifthenpay's module compatibility with your online store.
|                            | Prestashop 1.6 | Prestashop 1.7 [1.7.0 - 1.7.8] |
|----------------------------|----------------|--------------------------------|
| Ifthenpay v1.3.0 to v1.6.3 | Not compatible | Compatible                     |


# Installation

You may install the module for the first time on you Prestashop platform or just update it.

* To install it for the first time, go the module's [Github](https://github.com/ifthenpay/prestashop) page and click the the latest release;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/release.png)
</br>

* And download the installer zip named "ifthenpay.zip";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/release_download.png)
</br>

* Or if you are upgrading, you can download it from Prestashop in Modules/Ifthenpay/Configure;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/upgrade_download.png)
</br>

* Go to Module Manager;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/module_manager.png)
</br>

* Click "Upload a module";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/click_upload_module.png)
</br>

* Drag the installer zip on to "Upload a module" box;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/drag_upload_module.png)
</br>




# Configuration
## Backoffice key
* After a successful installation click the "Configure" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/click_configure.png)
</br>

* Insert your Ifthenpay Backoffice key and save:
1. The backoffice key is given upon contract and is made of four sets of four digits separated by a dash (-), insert it in the Backoffice key field;
2. Click "Save" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/insert_backoffice_key.png)
</br>

## Enable Payment Method
The following takes Multibanco as example, but the process is the same for the remaining payment methods

* To enable a payment method, follow the steps:
1. (optional) Switch on this option if you are testing the payment methods, this will prevent the callback activation;
2. Enable the payment method by switching the "Status" to Enabled;
3. Click "Save" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/enable_multibanco.png)
</br>

## Multibanco

* To configure Multibanco payment method click the "MANAGE" button for Multibanco;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/manage_multibanco.png)
</br>

* Configure Multibanco payment method:
1. Activate Callback, by selecting this option the order state will update when a payment is received;
2. Select an Entity. Can only select from the Entities associated with your Backoffice Key;
3. Select a Sub Entity. Can only select from the Sub Entities associated with Entity previously selected;
4. (optional) Input minimum order value to only display this payment method for orders above it;
5. (optional) Input maximum order value to only display this payment method for orders below it;
6. (optional) Select one or more countries to only display this payment method for orders with that shipping country, leave empty to allow all;
7. (optional) Input an Integer number to order this payment method in the checkout page. Smallest takes first place;
8. Click "Save" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/config_multibanco.png)
</br>

* If you previously set the "Callback" to activate, after saving, it's state will be updated below with the generated Anti-Phishing key and Callback Url;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/multibanco_callback_activated.png)
</br>

## Multibanco with Dynamic References

Multibanco with Dynamic References payment method generates references by request, and is used if you wish to add a deadline with limited number of days to your order payment.

* Configure Multibanco with Dynamic References:
1. Select "MB" from the Entity field, this entity will only be available for selection if you contracted an account for Multibanco with Dynamic References;
2. Select a Sub Entity.
3. (optional) Select number of days for deadline.
4. (optional) Activate Cancel Multibanco Order, by selecting this option, Multibanco orders that are still unpaid after the deadline will have status changed to "Cancelled";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/config_multibanco_dynamic.png)
</br>



## MB WAY

* Click the "Manage" button for MB WAY;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/manage_mbway.png)
</br>

* Configure MB WAY payment method:
1. Activate Callback, by selecting this option the order state will update when a payment is received;
2. (optional) Activate Cancel MB WAY Order, by selecting this option, MB WAY orders that are still unpaid 30 min after confirmation, will have status changed to "Cancelled";
3. MB WAY Countdown, set to "Activate" by default, this option determines whether the MB WAY 4 minutes countdown is displayed or not after confirming order;
4. Select a MB WAY key. Can only select from the MB WAY keys associated with your Backoffice key; 
5. (optional) Input minimum order value to only display this payment method for orders above it;
6. (optional) Input maximum order value to only display this payment method for orders below it;
7. (optional) Select one or more countries to only display this payment method for orders with that shipping country, leave empty to allow all;
8. (optional) Input an Integer number to order this payment method in the checkout page. Smallest takes first place.
9. Click "Save" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/config_mbway.png)
</br>

* If you set the "Callback" to activate, it's state will be updated below with the generated Anti-Phishing key and Callback Url;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/mbway_callback_activated.png)
</br>




## Credit Card

* In Modules/Ifthenpay/Configure, click the "MANAGE" button for Credit Card;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/manage_ccard.png)
</br>

* Configure Credit Card (also referred to as Ccard) payment method:
1. Select a CCard key. Can only select from the CCard keys associated with your Backoffice key; 
2. (optional) Activate Cancel Credit Card Order, by selecting this option, Credit Card orders that are still unpaid 30 min after confirmation, will have status changed to "Cancelled";
3. (optional) Input minimum order value to only display this payment method for orders above it;
4. (optional) Input maximum order value to only display this payment method for orders below it;
5. (optional) Select one or more countries to only display this payment method for orders with that shipping country, leave empty to allow all;
6. (optional) Input an Integer number to order this payment method in the checkout page. Smallest takes first place.
7. Click "Save" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/config_ccard.png)
</br>


## Payshop

* In Modules/Ifthenpay/Configure, click the "MANAGE" button for Payshop;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/manage_payshop.png)
</br>

* Configure Payshop payment method:
1. Activate Callback, by selecting this option the order state will update when a payment is received;
2. Select a Payshop key. Can only select from the Payshop keys associated with your Backoffice key;
3. (optional) Input a Deadline for payment, from 1 to 99 days or leave empty if you do not want it to expire;
4. (optional) Activate Cancel Payshop Order, by selecting this option, Payshop orders that are still unpaid after the deadline will have status changed to "Cancelled";
5. (optional) Input minimum order value to only display this payment method for order above it;
6. (optional) Input maximum order value to only display this payment method for order below it;
7. (optional) Select one or more countries to only display this payment method for orders with that shipping country, leave empty to allow all;
8. (optional) Input an Integer number to order this payment method in the checkout page. Smallest takes first place.
9. Click "Save" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/config_payshop.png)
</br>

* If you set the "Callback" to activate, it's state will be updated below with the generated Anti-Phishing key and Callback Url;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/payshop_callback_activated.png)
</br>


## Cofidis Pay

* In Modules/Ifthenpay/Configure, click the "MANAGE" button for Cofidis Pay;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/manage_cofidis.png)
</br>

* Configure Cofidis Pay payment method:
1. Activate Callback, by selecting this option the order state will update when a payment is received;
2. Select a Cofidis Pay key. Can only select from the Cofidis Pay keys associated with your Backoffice key;
3. (optional) Activate Cancel Cofidis Pay Order, by selecting this option, Cofidis Pay orders that are expired 60 minutes after confirmation will have status changed to "Cancelled";
4. (optional) Input minimum order value to only display this payment method for order above it. **Important Notice:** On Cofidis Key selection, this input is updated with value configured in ifthenpay's backoffice, and when editing, it can not be less then the value specified in ifthenpay's backoffice.;
5. (optional) Input maximum order value to only display this payment method for order below it. **Important Notice:** On Cofidis Key selection, this input is updated with value configured in ifthenpay's backoffice, and when editing, it can not be greater then the value specified in ifthenpay's backoffice.;
6. (optional) Select one or more countries to only display this payment method for orders with that shipping country, leave empty to allow all;
7. (optional) Input an Integer number to order this payment method in the checkout page. Smallest takes first place.
8. Click "Save" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/config_cofidis.png)
</br>

* If you set the "Callback" to activate, it's state will be updated below with the generated Anti-Phishing key and Callback Url;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/cofidis_callback_activated.png)
</br>


## Pix

* In Modules/Ifthenpay/Configure, click the "MANAGE" button for Pix;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/manage_pix.png)
</br>

* Configure Pix payment method:
1. Activate Callback, by selecting this option the order state will update when a payment is received;
2. Select a Pix key. Can only select from the Pix keys associated with your Backoffice key;
3. (optional) Activate Cancel Pix Order, by selecting this option, Pix orders that are expired 30 minutes after confirmation will have status changed to "Cancelled";
4. (optional) Input minimum order value to only display this payment method for order above it;
5. (optional) Input maximum order value to only display this payment method for order below it;
6. (optional) Select one or more countries to only display this payment method for orders with that shipping country, leave empty to allow all;
7. (optional) Input an Integer number to order this payment method in the checkout page. Smallest takes first place.
8. Click "Save" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/config_pix.png)
</br>

* If you set the "Callback" to activate, it's state will be updated below with the generated Anti-Phishing key and Callback Url;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/pix_callback_activated.png)
</br>


## Ifthenpay Gateway

* In Modules/Ifthenpay/Configure, click the "MANAGE" button for Ifthenpay Gateway;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/manage_ifthenpaygateway.png)
</br>

* Configure Ifthenpay Gateway payment method:
1. Activate Callback, by selecting this option the order state will update when a payment is received;
2. Select a Ifthenpay Gateway key. Can only select from the Ifthenpay Gateway keys associated with your Backoffice key;
3. Select a Payment Method Key per each Method and check the checkbox if you want to display it in the gateway page.
4. Select a Payment Method that will be selected in the gateway page by default.
5. (optional) Input a Deadline for gateway page link, from 1 to 99 days or leave empty if you do not want it to expire;
6. Text displayed in the "Return to Shop" button in the gateway page;
7. (optional) Activate Cancel Ifthenpay Gateway Order, by selecting this option, Ifthenpay Gateway orders that are expired 60 minutes after confirmation will have status changed to "Cancelled";
8. (optional) Input minimum order value to only display this payment method for order above it. 
9. (optional) Input maximum order value to only display this payment method for order below it. 
10. (optional) Select one or more countries to only display this payment method for orders with that shipping country, leave empty to allow all;
11. Display this payment method logo image on checkout, choose from 3 options:
    -  enabled - default image: displays ifthenpay gateway logo;
    -  disabled: displays Payment Method Title;
    -  enabled - composite image: displays a composite image of all the payment method logos you have selected;
12. Text that appears to the consumer during checkout if logo option above is set to disabled.
13. (optional) Input an Integer number to order this payment method in the checkout page. Smallest takes first place.
14. Click "Save" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/config_ifthenpaygateway.png)
</br>

* If you set the "Callback" to activate, it's state will be updated below with the generated Anti-Phishing key and Callback Url;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/ifthenpaygateway_callback_activated.png)
</br>


# Edit payment details
**Important Notice:** It is not possible to change to or update the Credit Card and Cofidis Pay payment methods.
</br>
At Prestashop order details, you can edit the order payment method and payment data.
An use case for this would be a customer ordered 2 units of a product, but decided to only get one, so the customer contacts the store admin and requests that change.
The store admin edits the product quantity and at the bottom of the page clicks the "Update Multibanco/MB WAY/Payshop Data" button and next clicks the "Resend Payment Data".
Multibanco payment method is used to explain the following procedures. The procedures are the same for all methods apart from MB WAY that does require a phone number.

## Update Payment Data

  * After changing the order, click the "Update Multibanco Data" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/update_payment_data.png)
</br>


## Resend Payment Data

  * After updating the payment data, you must resend the payment details to this order's customer by clicking the "Resend Payment Data" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/resend_payment_data.png)
</br>
  

## Remember Payment Data
  
  * If you have long deadlines on your payment methods and want to remind your customer of an order's pending payment, click the "Remember Payment Details" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/remember_payment_details.png)
</br>

## Choose Payment Method

Choose a different payment method:

  * Start the process by clicking the "Choose new Payment Method" button;
  ![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/choose_payment_method.png)
</br>

  * From the newly shown select box, select your new payment method (1), and click the "Change Payment Method" button (2);
  ![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/select_payment_method.png)
</br>

  * The payment details will be updated with the new methods payment data, now you must click the "Resend Payment Data" to let your customer know;
  ![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/new_payment_method.png)
</br>

  * If you are changing from Multibanco or Payshop to MB WAY, you are required to input the customer's phone number and click the "Change Payment Method" button. This action sends the MB WAY notification automatically, but you can use the "Resend Payment Data" button if the customer does not pay in the 4 minutes time window and requires another payment notification to their MB WAY app;
    ![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/change_to_mbway_payment.png)
</br>



# Other

## Support

* In Modules/Ifthenpay/Configure click the "Go to Support!" button to be redirected to the Ifthenpay helpdesk page;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/support.png)
</br>

## Request account

* If you still do not have an Ifthenpay account, you may request one by filling the membership contract pdf file that you can download by clicking the "Request an account!" button, and send it along with requested documentation to the email ifthenpay@ifthenpay.com
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/request_account.png)
</br>


## Request additional account

If you already have an Ifthenpay account, but don't have a payment method unlocked, you can make an automatic request to Ifthenpay;

* At Modules/Ifthenpay/Configure, there will be a "REQUEST ... ACCOUNT CREATION" button for every payment method that you have yet to unlock. Click the button for the payment method you require. After Ifthenpay's team have added your payment method, the list of payment methods available on your module will be updated with the new one. 
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/request_account_creation.png)
</br>


## Request additional Gateway Method
After selecting your Ifthenpay Gateway Key some methods may not be available, to unlock these follow the same procedure above by clicking one of the buttons (1) of the method you want to unlock.
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/request_gateway_method_creation.png)
</br>


## Logs

* You can consult logs related to this module at Module/Ifthenpay/Configure by clicking the tab "LOGS";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/click_logs.png)
</br>

* The logs will record errors and other events that can be helpful in detecting issues;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/logs.png)
</br>

## Reset Configuration

* If for example you acquired a new Backoffice key, and want to assign it to your site, but already have one assigned, you can reset the module's configuration.
At Module/Ifthenpay/Configure click the "Reset" button. **Warning, this action will reset all current configurations for this module**;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/reset.png)
</br>

* After reset, you will once again be asked for your Backoffice key;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/backoffice_key.png)
</br>

## Updates

* At Module/Ifthenpay/Configure, bottom of the page you can check if there are any updates available for the module;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/update.png)
</br>

## Sandbox Mode

* You may want to run tests before going into production. To do so, you must turn "Sandbox Mode" to Enabled and click the "Save" button, before activating any payment method Callback.
The Sandbox Mode is used in order to prevent the Callback activation and the communication between our server and your store.
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/sandbox_mode.png)
</br>

## Callback

* Callback is a functionality that when active, will allow your store to receive the notification of a successful payment. When active, a successful payment for an order will trigger a change in that specific order's status to "paid" or "processing" (status name will depend on your Prestashop configuration). You can use the Ifthenpay Payment methods without activating the Callback, but your orders will not update their status automatically;

* Callback statuses:
1. Callback Disabled (order will not change state upon receiving payment);
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/callback_status_disabled.png)
</br>

2. Callback Activated (order will change state upon receiving payment);
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/callback_status_activated.png)
</br>

3. Callback Activated & Sandbox Mode enabled (order will not change state upon receiving payment);
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/callback_status_sandbox.png)
</br>

## Test Callback

In each payment method config page (except Ccard), you can test the Callback functionality by clicking the "Test Callback" button. This will simulate a successful payment for a order in your store, and will change its status. Requires Callback to be activated;

**Multibanco:** Use the following data (1) and (2) from order payment details:
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/multibanco_callback_data.png)
</br>

to fill the Test Callback form and click the "Test Callback" button (3):
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/multibanco_callback_test.png)
</br>
</br>

**MB WAY:** Use the following data (1) and (2) from order payment details:

![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/mbway_callback_data.png)
</br>

to fill the Test Callback form and click the "Test Callback" button (3):
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/mbway_callback_test.png)
</br>
</br>

**Payshop:** Use the following data (1) and (2) from order payment details:

![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/payshop_callback_data.png)
</br>

to fill the Test Callback form and click the "Test Callback" button (3):
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/payshop_callback_test.png)
</br>
</br>

**Cofidis:** Use the following data (1) and (2) from order payment details:

![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/cofidis_callback_data.png)
</br>

to fill the Test Callback form and click the "Test Callback" button (3):
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/cofidis_callback_test.png)
</br>

**Pix:** Use the following data (1) and (2) from order payment details:

![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/pix_callback_data.png)
</br>

to fill the Test Callback form and click the "Test Callback" button (3):
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/pix_callback_test.png)
</br>

**Ifthenpay Gateway**: In the backoffice, use the order ID and the order amount, and enter them in the respective fields (1) and (2) of the Callback test form, then click on Test (3).
Note: The value, if it has decimals, should be separated by a dot.
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/ifthenpaygateway_callback_test.png)

</br>


## Known bug and fixes

* In some versions of Prestashop, enabling the ccc (Combine, Compress and Cache) for javascript, will result in minimization errors.
To fix this issue, replace the "js" folder with "js_uglyfied" folder.
1. Rename "js" folder to "js_minimized".
2. Rename "js_uglyfied" folder to "js".

![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/ccc_fix.png)
</br>


# Customer usage experience
The following action are described from the perspective of the consumer.

## Paying order with Multibanco

* Select Multibanco at checkout and place order:
1. Select "Pay by Multibanco";
2. Check the box of "terms of service" (this will depend on your Prestashop configuration);
3. Click "PLACE ORDER" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/checkout_multibanco.png)
</br>

* Upon confirmation, you will be greeted with the Multibanco payment information;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/multibanco_payment_return.png)
</br>

## Paying order with Payshop

* Select Payshop at checkout and place order:
1. Select "Pay by Payshop";
2. Check the box of "terms of service" (this will depend on your Prestashop configuration);
3. Click "PLACE ORDER" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/checkout_payshop.png)
</br>

* Upon confirmation, you will be greeted with the Payshop payment information;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/payshop_payment_return.png)
</br>

## Paying order with MB WAY

* Select MB WAY at checkout and place order:
1. Select "Pay by MB WAY";
2. Input the mobile phone number of a smartphone with MB WAY app installed;
3. Check the box of "terms of service" (this will depend on your Prestashop configuration);
4. Click "PLACE ORDER" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/checkout_mbway.png)
</br>

* Upon confirmation, you will be greeted with the MB WAY countdown, and payment information:
1. MB WAY countdown;
2. MB WAY payment information;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/mbway_payment_return.png)
</br>

* During countdown, interactions from user with MB WAY app will update countdown accordingly:
1. if you accept the payment in the smartphone's MB WAY app, the countdown will update with "Order Paid!";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/mbway_payment_paid.png)
</br>

2. if you reject the payment in the smartphone's MB WAY app, the countdown will update with "payment refused!";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/mbway_payment_refused.png)
</br>

3. if at checkout you inputted a phone number to a smartphone that does not have MB WAY app installed, or there are communication issues with SIBS servers at that moment, the countdown will update with "payment failed!";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/mbway_payment_error.png)
</br>

* if you ran out of time, you can resend a MB WAY notification by clicking "RESEND MB WAY NOTIFICATION";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/mbway_payment_notification_resend.png)
</br>

## Paying order with Credit Card

* Select Credit Card at checkout and place order:
1. Select "Pay by Credit Card";
2. Check the box of "terms of service" (this will depend on your Prestashop configuration);
3. Click "PLACE ORDER" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/checkout_ccard.png)
</br>

* Fill Credit Card data:
1. Input Card Number;
2. Input Expiry Date;
3. Input CVV/CVC;
4. Input Name;
5. Click "PAY" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/ccard_payment.png)
</br>

* After paying you will be redirected back to the store;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/ccard_payment_return.png)
</br>

## Paying order with Cofidis Pay

* Select Cofidis Pay at checkout and place order:
1. Select "Pay by Cofidis Pay";
2. Check the box of "terms of service" (this will depend on your Prestashop configuration);
3. Click "PLACE ORDER" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/checkout_cofidis.png)
</br>

* Login or, if you don't have an account, sign up with Cofidis Pay:
1. Click "Avançar" to sign up with Cofidis Pay;
2. Or if you have a Cofidis Pay account, fill in your access credentials and click enter;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/cofidis_payment_1.png)
</br>

* Number of installments and billing and personal data:
1. Select the number of installments you wish;
2. Verify the summary of the the payment plan;
3. Fill in your personal and billing data;
4. Click "Avançar" to continue;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/cofidis_payment_2.png)
</br>

* Terms and Conditions:
1. Select "Li e autorizo" to agree with terms and conditions;
2. Click "Avançar"
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/cofidis_payment_3.png)
</br>

* Agreement formalization:
1. Click "Enviar código";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/cofidis_payment_4.png)
</br>

* Agreement formalization authentication code:
1. Fill in the code you received on your phone;
1. Click "Confirmar código";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/cofidis_payment_5.png)
</br>

* Summary and Payment:
1. Fill in your credit card details (number, expiration date and CW), and click "Validar";
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/cofidis_payment_6.png)
</br>

* Success and return to store:
1. Click the return icon to return to the store;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/cofidis_payment_7.png)
</br>

* After which you will be redirected back to the store;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/cofidis_payment_return.png)
</br>


## Paying order with Pix

* Select Pix at checkout and place order:
1. Select "Pay by Pix";
2. Fill the form. Only the name, CPF, and Email are required, the remaining are optional;
3. Check the box of "terms of service" (this will depend on your Prestashop configuration);
4. Click "PLACE ORDER" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/checkout_pix.png)
</br>

* Proceed with payment with one of two options:
1. Reading QR code with mobile phone;
2. Copy the Pix code and pay with online banking;
**Important Note:** In order to be redirected back to the store after paying, this page must be left open. If closed the consumer will still be able to pay, as long as he has already read the Pix code, he will only not be redirected back to the store.

![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/pix_payment.png)
</br>

* After paying you will be redirected back to the store;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/pix_payment_return.png)
</br>


## Paying order with Ifthenpay Gateway

* Select Ifthenpay Gateway at checkout and place order:
1. Select "Pay by Ifthenpay Gateway";
2. Check the box of "terms of service" (this will depend on your Prestashop configuration);
3. Click "PLACE ORDER" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/checkout_ifthenpaygateway.png)
</br>

Select one of the payment methods available in the gateway page (1). 
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/ifthenpaygateway_payment_1.png)
</br>

In case of Multibanco method, the entity, reference and amount will be displayed.
Here the user can do one of the two:
 - in case of an offline payment method, note down the payment details, click the close gateway button (2) and pay later;
 - pay at that moment and click the confirm payment button (3) to verify the payment.
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/ifthenpaygateway_payment_2.png)
</br>

If the user did not pay at the moment and did not take note of the payment details, it is also possible to access the Ithenpay Gateway link at a later date in the user account order history or order confirmation email.
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/ifthenpaygateway_payment_3.png)
</br>

You have reached the end of the ifthenpay extension manual for Prestashop 1.7.
