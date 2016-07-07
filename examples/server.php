<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

include __DIR__ . '/../vendor/autoload.php';

use Fdx\FdxServer;

$server = new FdxServer();

$server->addFunction('hello', function () {
    return 'hello';
});

$server->start();
