<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/6/1
 * Time: 上午1:18
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 */

namespace Fdx\Commands;

use FastD\Console\Command\Command;
use FastD\Console\IO\Input;
use FastD\Console\IO\Output;

/**
 * Class Init
 * @package Fdx\Commands
 */
class Init extends Command
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'init';
    }

    /**
     * @return void
     */
    public function configure()
    {
        // TODO: Implement configure() method.
    }

    /**
     * @param Input $input
     * @param Output $output
     * @return int
     */
    public function execute(Input $input, Output $output)
    {
        echo 'init';
    }
}