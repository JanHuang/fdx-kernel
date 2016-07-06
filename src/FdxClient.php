<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Fdx;

use FastD\Packet\Binary;
use FastD\Swoole\Client\Client;

/**
 * Class FdxClient
 *
 * @package Fdx
 */
class FdxClient extends Client
{
    /**
     * FdxClient constructor.
     *
     * @param $protocol
     * @param null $async
     */
    public function __construct($protocol, $async = null)
    {
        $protocol = parse_url($protocol);

        if ('tcp' === $protocol['scheme']) {
            $mode = SWOOLE_SOCK_TCP;
        } else {
            $mode = SWOOLE_SOCK_UDP;
        }

        parent::__construct($mode, $async);

        $this->connect($protocol['host'], $protocol['port']);
    }

    /**
     * @param $name
     * @param array $arguments
     * @return mixed
     * @throws \FastD\Packet\PacketException
     */
    public function call($name, array $arguments = [], callable $callable = null)
    {
        $result = $this->send(Binary::encode([
            'name' => $name,
            'params' => $arguments
        ]));

        return Binary::decode($result);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->call($name, $arguments);
    }
}