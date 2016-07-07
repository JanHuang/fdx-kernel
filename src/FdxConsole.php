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

use FastD\Console\Command\Command;
use FastD\Console\Input\Input;
use FastD\Console\Input\InputArgument;
use FastD\Console\Input\InputOption;
use FastD\Console\Output\Output;
use FastD\Swoole\Console\Service;

/**
 * Class FdxConsole
 *
 * @package Fdx
 */
class FdxConsole extends Command
{
    /**
     * @return string
     */
    public function getDescription()
    {
        return 'fdx console.';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fdx';
    }

    /**
     * @return void
     */
    public function configure()
    {
        $this
            ->setArgument('action', InputArgument::REQUIRED)
            ->setOption('host', '-h')
            ->setOption('port', '-p')
            ->setOption('conf', '-c')
            ->setOption('daemon', '-d')
            ->setOption('dir', null, InputOption::VALUE_OPTIONAL, '', './src')
        ;
    }

    /**
     * @param Input $input
     * @param Output $output
     * @return int
     */
    public function execute(Input $input, Output $output)
    {
        $config = [];

        if (null !== $input->getOption('conf')) {
            $conf = $input->getOption('conf');
            switch (pathinfo($conf, PATHINFO_EXTENSION)) {
                case 'ini':
                    $config = parse_ini_file($conf, true);
                    break;
                default:
                    $config = include $conf;
            }
        }

        $server = new FdxServer($config);

        $dir = $input->getOption('dir');

        $server->scanDir($dir);

        $service = Service::server($server);

        switch ($input->getArgument('action')) {
            case 'status':
                $service->status();
                break;
            case 'start':
                $service->start();
                break;
            case 'stop':
                $service->shutdown();
                break;
            case 'reload':
                $service->reload();
                break;
            case 'watch':
                $service->watch(['.']);
                break;
            case 'dump':
                print_r(array_keys($server->getFunctions()));
                break;
            default:
                echo "php server {start|stop|status|reload|watch}";
        }
    }
}