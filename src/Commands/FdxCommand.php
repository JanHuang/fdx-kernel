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

    /**
     * @return string
     */
    public function getDescription()
    {
        return "<info>fdx 命令 --help 查询操作</info>";
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
        
        $service = Service::server($server);
        
        switch ($action) {
            case 'start':
                $service->start();
                break;
            case 'stop':
                $service->shutdown();
                break;
            case 'restart':
                $service->shutdown();
                $service->start();
                break;
            case 'reload':
                $service->reload();
                break;
            case 'watch':
                $service->watch();
                break;
            case 'status':
            default:
                $service->status();
        }
    }

    /**
     * @param array $config
     * @return Server
     */
    protected function handle(array $config)
    {
        $server = $config['server'];

        if (empty($server) || !class_exists($server)) {
            throw new \RuntimeException(sprintf('Cannot setting server. And you must be to extends "%s"', Server::class));
        }

        $server = $server::create();

        $handle = $config['handle'];

        if (empty($handle) || !class_exists($handle)) {
            throw new \RuntimeException(sprintf('Cannot setting server callback handle.'));
        }

        $server->handle(new $handle);

        return $server;
    }
}