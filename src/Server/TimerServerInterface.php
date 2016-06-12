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
 * Interface TimerServerInterface
 *
 * @package Fdx\Server
 */
interface TimerServerInterface
{
    /**
     * @param \swoole_server $server
     * @param int $interval
     * @return mixed
     */
    public function onTimer(\swoole_server $server, int $interval);
}