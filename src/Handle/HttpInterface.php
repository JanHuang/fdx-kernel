<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/5/31
 * Time: 上午10:57
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Fdx\Handle;

/**
 * Interface Http
 *
 * @package Fdx\Handle
 */
interface Http
{
    /**
     * @param \swoole_http_request $request
     * @param \swoole_http_response $response
     * @return mixed
     */
    public function onRequest(\swoole_http_request $request, \swoole_http_response $response);
}