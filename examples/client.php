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

use Fdx\Client\FdxClient;

$client = new FdxClient();

$client->connect('127.0.0.1', '9527');

$result = $client->call('hello');

var_dump($result);
