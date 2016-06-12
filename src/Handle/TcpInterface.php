<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/5/30
 * Time: 下午6:58
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Fdx\Handle;

/**
 * Interface TcpInterface
 *
 * @package Fdx\Handle
 */
interface TcpInterface
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