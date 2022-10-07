<?php

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
 * @copyright 2007-2022 Ifthenpay Lda
 * @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\Ifthenpay\Callback;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Ifthenpay\Factory\Request\RequestFactory;

class Callback
{

    private $activateEndpoint = 'https://ifthenpay.com/api/endpoint/callback/activation';
    private $webservice;
    private $urlCallback;
    private $chaveAntiPhishing;
    private $backofficeKey;
    private $entidade;
    private $subEntidade;
    private $paymentType;

    private $urlCallbackParameters = [
        'multibanco' => '?type=offline&payment={paymentMethod}&chave=[CHAVE_ANTI_PHISHING]&entidade=[ENTIDADE]&referencia=[REFERENCIA]&valor=[VALOR]',
        'mbway' => '?type=offline&payment={paymentMethod}&chave=[CHAVE_ANTI_PHISHING]&referencia=[REFERENCIA]&id_pedido=[ID_TRANSACAO]&valor=[VALOR]&estado=[ESTADO]',
        'payshop' => '?type=offline&payment={paymentMethod}&chave=[CHAVE_ANTI_PHISHING]&id_cliente=[ID_CLIENTE]&id_transacao=[ID_TRANSACAO]&referencia=[REFERENCIA]&valor=[VALOR]&estado=[ESTADO]',
    ];

    public function __construct($data)
    {
        $this->webservice = RequestFactory::buildWebservice();
        $this->backofficeKey = $data->getData()->backofficeKey;
        $this->entidade = $data->getData()->entidade;
        $this->subEntidade = $data->getData()->subEntidade;
    }

    private function createAntiPhishing()
    {
        $this->chaveAntiPhishing = md5((string) rand());
    }

    private function createUrlCallback($paymentType, $moduleLink)
    {
        $this->urlCallback = $moduleLink . str_replace('{paymentMethod}', $paymentType, $this->urlCallbackParameters[$paymentType]);
    }

    private function activateCallback()
    {
        $request = $this->webservice->postRequest(
            $this->activateEndpoint,
            [
                'chave' => $this->backofficeKey,
                'entidade' => $this->entidade,
                'subentidade' => $this->subEntidade,
                'apKey' => $this->chaveAntiPhishing,
                'urlCb' => $this->urlCallback,
            ],
            true
        );

        $response = $request->getResponse();
        if (!$response->getStatusCode() === 200 && !$response->getReasonPhrase()) {
            throw new \Exception("Error Activating Callback");
        }
    }

    public function make($paymentType, $moduleLink, $activateCallback = false)
    {
        $this->paymentType = $paymentType;
        $this->createAntiPhishing();
        $this->createUrlCallback($paymentType, $moduleLink);
        if ($activateCallback) {
            $this->activateCallback();
        }
    }

    /**
     * Get the value of urlCallback
     */
    public function getUrlCallback()
    {
        return $this->urlCallback;
    }

    /**
     * Get the value of chaveAntiPhishing
     */
    public function getChaveAntiPhishing()
    {
        return $this->chaveAntiPhishing;
    }
}
