<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Fdx\Commands;

use FastD\Console\Command\Command;
use FastD\Console\Input\Input;
use FastD\Console\Input\InputOption;
use FastD\Console\Output\Output;
use FastD\Swoole\Server\Server;
use FastD\Swoole\Console\Service;

/**
 * Class FdxCommand
 *
 * @package Fdx\Commands
 */
class FdxCommand extends Command
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Fdx constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
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
            ->setArgument('action')
            ->setOption('daemonize', '-d', InputOption::VALUE_NONE, '守护进程')
        ;
    }

    public function getDescription()
    {
        return "\t<info>fdx 命令 --help 查询操作</info>";
    }

    /**
     * @param Input $input
     * @param Output $output
     * @return int
     */
    public function execute(Input $input, Output $output)
    {
        $server = $this->handle($this->config);

        $action = $input->getOption('action') ?? 'status';

        switch ($action) {
            case 'start':
                Service::server($server)->start();
                break;
            case 'stop':
                Service::server($server)->shutdown();
                break;
            case 'restart':
                Service::server($server)->shutdown();
                Service::server($server)->start();
                break;
            case 'reload':
                Service::server($server)->reload();
                break;
            case 'watch':
                Service::server($server)->watch();
                break;
            case 'status':
            default:
                Service::server($server)->status();
        }
    }

    /**
     * @param array $config
     * @return Server
     */
    protected function handle(array $config)
    {
        $handle = new $config['handle']();

        $server = $config['server']::create();

        $server->handle($handle);

        return $server;
    }
}