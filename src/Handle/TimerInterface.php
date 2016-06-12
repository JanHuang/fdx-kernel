<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/5/31
 * Time: 上午10:58
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Fdx\Handle;

/**
 * Interface TimerInterface
 *
 * @package Fdx\Handle
 */
interface TimerInterface
{
    /**
     * @param \swoole_server $server
     * @param int $interval
     * @return mixed
     */
    public function onTimer(\swoole_server $server, int $interval);
}