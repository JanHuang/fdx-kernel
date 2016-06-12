<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/5/31
 * Time: 上午11:00
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Fdx\Handle;

interface UdpInterface
{
    public function onPacket(\swoole_server $server, string $data, array $client_info);
}