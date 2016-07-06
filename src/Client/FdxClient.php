<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Fdx\Client;

use FastD\Packet\Binary;
use FastD\Swoole\Client\Client;

class FdxClient extends Client
{
    public function call($name, array $arguments = [])
    {
        $result = $this->send(Binary::encode([
            'name' => $name,
            'params' => $arguments
        ]));

        return Binary::decode($result);
    }
}