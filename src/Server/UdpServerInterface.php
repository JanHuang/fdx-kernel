<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Fdx\Server;

/**
 * Interface UdpServerInterface
 *
 * @package Fdx\Server
 */
interface UdpServerInterface
{
    /**
     * @param \swoole_server $server
     * @param string $data
     * @param array $client_info
     * @return mixed
     */
    public function onPacket(\swoole_server $server, string $data, array $client_info);
}