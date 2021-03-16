<?php

namespace Test\Unit;

use Helper\Utility;
use Codeception\Stub\Expected;

class IfthenpayTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    public $ifthenpay;
    public $controllers;
    
    protected function _before()
    {
      $this->ifthenpay = new \Ifthenpay();
      $this->controllers = [
        'adminIfthenpayPaymentMethodSetup',
        'adminIfthenpayActivateNewAccount',
        'validation',
        'payment',
        'callback',
        'update',
        'remember',
        'resend',
        'resendMbwayNotification',
        'updateIfthenpayUserAccount'
      ];
    }

    protected function _after()
    {
    }

    // tests
    public function test_construct_set_values()
    {
      $this->assertInstanceOf(\PaymentModule::class, $this->ifthenpay);

      $this->assertObjectHasAttribute('name', $this->ifthenpay);
      $this->assertObjectHasAttribute('tab', $this->ifthenpay);
      $this->assertObjectHasAttribute('version', $this->ifthenpay);
      $this->assertObjectHasAttribute('author', $this->ifthenpay);
      $this->assertObjectHasAttribute('need_instance', $this->ifthenpay);
      $this->assertObjectHasAttribute('bootstrap', $this->ifthenpay);
      $this->assertObjectHasAttribute('controllers', $this->ifthenpay);
      $this->assertObjectHasAttribute('displayName', $this->ifthenpay);
      $this->assertObjectHasAttribute('description', $this->ifthenpay);
      $this->assertObjectHasAttribute('confirmUninstall', $this->ifthenpay);
      
      $this->assertEquals($this->ifthenpay->name, 'ifthenpay');
      $this->assertEquals($this->ifthenpay->tab, 'payments_gateways');
      $this->assertEquals($this->ifthenpay->version, '1.0.3');
      $this->assertEquals($this->ifthenpay->author, 'Ifthenpay');
      $this->assertEquals($this->ifthenpay->need_instance, 0);
      $this->assertEquals($this->ifthenpay->bootstrap, true);
      $this->assertEquals($this->ifthenpay->displayName, 'Ifthenpay');
      $this->assertEquals($this->ifthenpay->description, 'Permite pagamentos por referência Multibanco, MB WAY e Payshop.');
      $this->assertEquals($this->ifthenpay->confirmUninstall, 'Tem a certeza que quer desinstalar o módulo?');
      $this->assertContains('EUR', $this->ifthenpay->limited_currencies);
      
      $this->assertIsArray($this->ifthenpay->controllers);
      $this->assertContainsOnly('string', $this->ifthenpay->controllers);

      foreach ($this->controllers as $controller) {
        $this->assertContains($controller, $this->ifthenpay->controllers);
      }

      $this->assertIsArray($this->ifthenpay->limited_currencies);
      $this->assertIsArray($this->ifthenpay->ps_versions_compliancy);
      $ifthenpayConfig = Utility::getPrivateProtectedPropertie($this->ifthenpay, 'ifthenpayConfig');
      $this->assertIsArray($ifthenpayConfig);
      
      $this->assertArrayHasKey('IFTHENPAY_USER_PAYMENT_METHODS', $ifthenpayConfig);
      $this->assertArrayHasKey('IFTHENPAY_BACKOFFICE_KEY', $ifthenpayConfig);
      
    }

    public function test_install_method()
    {
      if (!extension_loaded('curl')) {
        $_errors = Utility::getPrivateProtectedPropertie($this->ifthenpay, '_errors');
        $this->assertContains('You have to enable the cURL extension on your server to install this module', $_errors);
      }

      $shop = $this->make(
        '\Shop',
        array(
            'isFeatureActive' => Expected::once(function() { return true; }),
            'setContext' => Expected::once(function() { return 4; })
        )
    );
    $this->assertEquals($shop::CONTEXT_ALL, 4);
    }
}