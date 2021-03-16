<?php
/**
 * 2007-2020 Ifthenpay Lda
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
 * @copyright 2007-2020 Ifthenpay Lda
 * @author    Ifthenpay Lda <ifthenpay@ifthenpay.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\Ifthenpay\Config;

use PrestaShop\Module\Ifthenpay\Factory\Request\RequestFactory;

if (!defined('_PS_VERSION_')) {
    exit;
}

class IfthenpayUpgrade
{
    private $webservice;
    private $ifthenpayModule;

	public function __construct($ifthenpayModule)
	{
        $this->webservice = RequestFactory::buildWebservice(
            [
                'headers' => ['Accept' => 'application/vnd.github.v3+json']
            ]
        );
        $this->ifthenpayModule = $ifthenpayModule;
	}

    private function convertTextToBulletPoints($txt)
    {
        $txt = str_replace("*","<br><br> &#8226", str_replace("\r\n\r\n","",$txt));
        $txt = str_replace("###","<br><br>###", $txt);
        $txt = str_replace("### Features","<br><br><h3>Features</h3>", $txt);
        return str_replace("### Bug fixes","<br><br><h3>Bug fixes</h3>", $txt);
    }

    public function checkModuleUpgrade()
    {
        $response = $this->webservice->getRequest('https://api.github.com/repos/ifthenpay/prestashop/releases/latest')->getResponseJson();
        if (\Tools::version_compare(str_replace('v', '', $response['tag_name']), $this->ifthenpayModule->version, '>') && !$response["draft"] && !$response["prerelease"]) {
            return [
                'upgrade' => true,
                'body' => $this->convertTextToBulletPoints($response['body']),
                'download' => $response['assets'][0]['browser_download_url']
            ];
        }
        return [
            'upgrade' => false,
        ];      
    }
    
    
}
