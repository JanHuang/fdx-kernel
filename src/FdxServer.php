<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/5/30
 * Time: 下午10:53
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Fdx;

use FastD\Packet\Binary;
use FastD\Swoole\Server\Server;

/**
 * Class Fdx
 *
 * @package FdxServer
 */
class FdxServer extends Server
{
    /**
     * Api list.
     *
     * @var array
     */
    protected $apiList = [];

    /**
     * @param $name
     * @param callable $callback
     * @return $this
     */
    public function addFunction($name, callable $callback)
    {
        $this->apiList[$name] = $callback;

        return $this;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getFunction($name)
    {
        if (!isset($this->apiList[$name])) {
            throw new \InvalidArgumentException(sprintf('"%s" is cannot found.', $name));
        }

        return $this->apiList[$name];
    }

    /**
     * @param $name
     * @param array $parameters
     * @return mixed
     */
    public function dispatch($name, array $parameters = [])
    {
        $function = $this->getFunction($name);

        return call_user_func_array($function, $parameters);
    }

    /**
     * @param \swoole_server $server
     * @param int $fd
     * @param int $from_id
     * @param string $data
     * @return mixed
     */
    public function doWork(\swoole_server $server, int $fd, int $from_id, string $data)
    {
        $data = Binary::decode($data);

        $data = $this->dispatch($data['name'], $data['params']);

        $server->send($fd, Binary::encode($data));

        $server->close($fd);
    }

    /**
     * @param \swoole_server $server
     * @param string $data
     * @param array $client_info
     */
    public function doPacket(\swoole_server $server, string $data, array $client_info)
    {
        // TODO: Implement doPacket() method.
    }
}