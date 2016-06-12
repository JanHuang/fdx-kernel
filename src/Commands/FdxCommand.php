<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/6/1
 * Time: 上午1:12
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 */

namespace Fdx\Commands;

use FastD\Console\Command\Command;
use FastD\Console\IO\Input;
use FastD\Console\IO\Output;
use FastD\Swoole\Server\Server;
use FastD\Swoole\Console\Service;

/**
 * Class Fdx
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
            ->setOption('daemonize', Input::ARG_NONE)
        ;
    }

    /**
     * @param Input $input
     * @param Output $output
     * @return int
     */
    public function execute(Input $input, Output $output)
    {
        $server = $this->handle($this->config);

        $action = $input->get('action') ?? 'status';

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