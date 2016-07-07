<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Test;

class Test
{
    public function testContainer(Test2 $test2)
    {
        return $test2->getName();
    }
}