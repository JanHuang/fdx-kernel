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

use FastD\Container\Container;
use FastD\Packet\Binary;
use FastD\Swoole\Server\Server;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Class FdxServer
 *
 * @package Fdx
 */
class FdxServer extends Server
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * FdxServer constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->container = new Container();
    }

    /**
     * Api list.
     *
     * @var array
     */
    protected $apiList = [];

    /**
     * @param $directory
     */
    public function scanDir($directory)
    {
        $showFiles = function ($dir) use (&$showFiles) {
            $files = [];

            $dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

            for (; $dir->valid(); $dir->next()) {
                if ($dir->isDir() && !$dir->isDot()) {
                    if ($dir->hasChildren()) {
                        $files = array_merge($files, $showFiles($dir->getChildren()));
                    };
                } else if ($dir->isFile()) {
                    $files[] = $dir->getFileInfo();
                }
            }

            return $files;
        };

        $directory = realpath($directory);

        $files = $showFiles($directory);

        $isUpper = function ($str) {
            $str = ord($str);
            if ($str > 64 && $str < 91) {
                return true;
            }

            return false;
        };

        foreach ($files as $file) {

            include_once $file->getRealPath();

            if ($isUpper($file->getFilename(){0})) {
                $namespace = str_replace($directory, '', $file->getPath());
                $namespace = empty($namespace) ? '\\' : str_replace('/', '\\', $namespace);
                $className = str_replace('\\\\', '\\', $namespace . '\\' . pathinfo($file->getFilename(), PATHINFO_FILENAME));
                if (!class_exists($className)) {
                    continue;
                }

                $reflection = new \ReflectionClass($className);
                $name = strtolower($reflection->getShortName());
                $this->container->set($name, $className);
                $service = $this->container->get($name);
                foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                    $this->addFunction($name . '.' . $method->getName(), [$service, $method->getShortName()]);
                }
                
            } else {
                $name = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                $this->addFunction($name, $name);
            }
        }
    }

    /**
     * @param $name
     * @param callable $callback
     * @return $this
     */
    public function addFunction($name, $callback)
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
     * @return array
     */
    public function getFunctions()
    {
        return $this->apiList;
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