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

use Composer\Autoload\ClassLoader;
use FastD\Console\Console;
use FastD\Debug\Debug;
use Fdx\Commands\FdxCommand;
use FastD\Console\Input\ArgvInput;

/**
 * Class Fdx
 *
 * @package Fdx
 */
class Fdx
{
    /**
     * @var static
     */
    protected static $instance;

    /**
     * @return static
     */
    protected static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
            Debug::enable();
        }

        return static::$instance;
    }

    /**
     * @param ClassLoader $classLoader
     * @return int
     */
    public static function run(ClassLoader $classLoader)
    {
        $serverScript = static::getInstance();

        $config = $classLoader->getPrefixesPsr4()['Fdx\\'][0] . '/../config.php';

        if (!file_exists($config)) {
            throw new \RuntimeException(sprintf('Config file is not exists.'));
        }

        // include config to array.
        $config = include $config;

        return $serverScript->runCommand($config);
    }

    /**
     * @param array $config
     * @return int
     */
    public function runCommand(array $config)
    {
        $input = new ArgvInput();

        $consoleApp = new Console();

        $consoleApp->addCommand(new FdxCommand($config));

        return $consoleApp->run($input);
    }
}