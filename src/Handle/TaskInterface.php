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
 * Interface TaskInterface
 *
 * @package Fdx\Handle
 */
interface TaskInterface
{
    /**
     * @param \swoole_server $server
     * @param int $task_id
     * @param int $from_id
     * @param string $data
     * @return mixed
     */
    public function onTask(\swoole_server $server, int $task_id, int $from_id, string $data);

    /**
     * @param \swoole_server $server
     * @param int $task_id
     * @param string $data
     * @return mixed
     */
    public function onFinish(\swoole_server $server, int $task_id, string $data);
}