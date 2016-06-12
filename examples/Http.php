<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */


namespace Examples;

use FastD\Swoole\Handler\Base\HttpHandleAbstract;
use Fdx\Server\HttpServerInterface;

class Http extends HttpHandleAbstract implements HttpServerInterface
{
    /**
     * @param \swoole_http_request $request
     * @param \swoole_http_response $response
     * @return mixed
     */
    public function onRequest(\swoole_http_request $request, \swoole_http_response $response)
    {
        $response->end('hello fdx');
    }
}