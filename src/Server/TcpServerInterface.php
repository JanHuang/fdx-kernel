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
 * Interface TcpServerInterface
 *
 * @package Fdx\Server
 */
interface TcpServerInterface
{
    /**
     * @param \swoole_server $server
     * @param int $fd
     * @param int $from_id
     * @param string $data
     * @return mixed
     */
    public function onReceive(\swoole_server $server, int $fd, int $from_id, string $data);

    /**
     * @param \swoole_server $server
     * @param int $fd
     * @param int $from_id
     * @return mixed
     */
    public function onClose(\swoole_server $server, int $fd, int $from_id);

    /**
     * @param \swoole_server $server
     * @param int $fd
     * @param int $from_id
     * @return mixed
     */
    public function onConnect(\swoole_server $server, int $fd, int $from_id);
}