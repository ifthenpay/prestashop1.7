# Ifthenpay Prestashop 1.7 payment module

Read this in ![Português](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/pt.png) [Portuguese](readme.pt.md), and ![Inglês](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/en.png) [English](readme.md)

[1. Introduction](#Introduction)

[2. Compatibility](#Compatibility)

[3. Installation](#Installation)

[4. Configuration](#Configuration)
  * [Backoffice Key](#Backoffice-Key)
  * [Enable Payment Method](#Enable-Payment-Method)
  * [Multibanco](#Multibanco)
  * [Multibanco with Dynamic References](#Multibanco-with-Dynamic-References)
  * [MB WAY](#MB-WAY)
  * [Credit Card](#Credit-Card)
  * [Payshop](#Payshop)

[5. Edit payment details](#Edit-payment-details)
  * [Update Payment Data](#Update-Payment-Data)
  * [Resend Payment Data](#Resend-Payment-Data)
  * [Remember Payment Data](#Remember-Payment-Data)
  * [Choose Payment Method](#Choose-Payment-Method)
  

[6. Other](#Other)
  * [Support](#Support)
  * [Request account](#Request-account)
  * [Request additional account](#Request-additional-account)
  * [Logs](#Logs)
  * [Reset Configuration](#Reset-Configuration)
  * [Updates](#Updates)
  * [Sandbox Mode](#Sandbox-Mode)
  * [Callback](#Callback)


[7. Customer usage experience](#Customer-usage-experience)
  * [Paying order with Multibanco](#Paying-order-with-Multibanco)
  * [Paying order with Payshop](P#aying-order-with-Payshop)
  * [Paying order with MB WAY](#Paying-order-with-MB-WAY)
  * [Paying order with Credit Card](#Paying-order-with-Credit-Card)


# Introduction
![Ifthenpay](https://ifthenpay.com/images/all_payments_logo_final.png)

**This is the Ifthenpay plugin for Prestashop e-commerce platform**

**Multibanco** is one Portuguese payment method that allows the customer to pay by bank reference.
This module will allow you to generate a payment Reference that the customer can then use to pay for his order on the ATM or Home Banking service. This plugin uses one of the several gateways/services available in Portugal, IfthenPay.

**MB WAY** is the first inter-bank solution that enables purchases and immediate transfers via smartphones and tablets.

This module will allow you to generate a request payment to the customer mobile phone, and he can authorize the payment for his order on the MB WAY App service. This module uses one of the several gateways/services available in Portugal, IfthenPay.

**Payshop** is one Portuguese payment method that allows the customer to pay by payshop reference.
This module will allow you to generate a payment Reference that the customer can then use to pay for his order on the Payshop agent or CTT. This module uses one of the several gateways/services available in Portugal, IfthenPay.

**Credit Card** 
This module will allow you to generate a payment by Visa or Master card, that the customer can then use to pay for his order. This module uses one of the several gateways/services available in Portugal, IfthenPay.

**Contract with Ifthenpay is required.**

See more at [Ifthenpay](https://ifthenpay.com). 


# Compatibility

Follow the table below to verify Ifthenpay's module compatibility with your online store.
|                  | Prestashop 1.6 | Prestashop 1.7 [1.7.0 - 1.7.8] |
|------------------|----------------|--------------------------------|
| Ifthenpay v1.3.0 | Not compatible | Compatible                     |
| Ifthenpay v1.3.1 | Not compatible | Compatible                     |

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
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/config_multibanco_dynamic.png)
</br>



## MB WAY

* Click the "Manage" button for MB WAY;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/manage_mbway.png)
</br>

* Configure MB WAY payment method:
1. Activate Callback, by selecting this option the order state will update when a payment is received;
2. Activate Cancel MB WAY Order, by selecting this option, you will cancel any MB WAY orders that are still unpaid 30 min after confirmation;
3. MB WAY Countdown, set to "Activate" by default, this option determines whether the MB WAY 5 minutes countdown is displayed or not after confirming order;
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
2. (optional) Input minimum order value to only display this payment method for orders above it;
3. (optional) Input maximum order value to only display this payment method for orders below it;
4. (optional) Select one or more countries to only display this payment method for orders with that shipping country, leave empty to allow all;
5. (optional) Input an Integer number to order this payment method in the checkout page. Smallest takes first place.
6. Click "Save" button;
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
4. (optional) Input minimum order value to only display this payment method for order above it;
5. (optional) Input maximum order value to only display this payment method for order below it;
6. (optional) Select one or more countries to only display this payment method for orders with that shipping country, leave empty to allow all;
7. (optional) Input an Integer number to order this payment method in the checkout page. Smallest takes first place.
8. Click "Save" button;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/config_payshop.png)
</br>

* If you set the "Callback" to activate, it's state will be updated below with the generated Anti-Phishing key and Callback Url;
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/payshop_callback_activated.png)
</br>




# Edit payment details
**Important Notice:** It is not possible to change to or update the Credit Card payment method.
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

  * If you are changing from Multibanco or Payshop to MB WAY, you are required to input the customer's phone number and click the "Change Payment Method" button. This action sends the MB WAY notification automatically, but you can use the "Resend Payment Data" button if the customer does not pay in the 5 minutes time window and requires another payment notification to their MB WAY app;
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
![img](https://github.com/ifthenpay/prestashop/raw/assets/version17/img/en/checkout_payshop.png)
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

