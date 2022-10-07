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

namespace PrestaShop\Module\Ifthenpay\Request;

if (!defined('_PS_VERSION_')) {
    exit;
}

use GuzzleHttp\Message\Response;
use PrestaShop\Module\Ifthenpay\Factory\Request\RequestFactory;

class WebService
{
    private $client;
    private $response;

    public function __construct($headers = [])
    {
        $this->client = RequestFactory::buildClient($headers);
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getResponseJson()
    {
        return json_decode(json_encode(json_decode((string) $this->response->getBody())), true);
    }

    public function postRequest($url, $data, $jsonContentType = false)
    {
        try {
            $this->response = $this->client->post(
                $url,
                $jsonContentType ? ['json' => $data] :
                ['body' => $data]
            );
            return $this;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getRequest($url, $data = [])
    {
        try {
            $this->response = $this->client->get($url, ['query' => $data]);
            return $this;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
