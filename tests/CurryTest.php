<?php

/**
 * This file is part of the sci/curryable package.
 *
 * (c) Sascha Schimke <sascha@schimke.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sci\Tests\Curryable;

use Sci\Curryable\Curryable;
use Sci\Curryable\CurryTrait;

class CurryTest extends \PHPUnit_Framework_TestCase
{
    public function testAutoCurryingDefault()
    {
        $test = new CurryableTestClass();

        $result = $test->autoCurry()->add(1, 2, 3, 4);

        $this->assertEquals(1 + 2 + 3 + 4, $result);
    }

    public function testAutoCurrying()
    {
        $test = new CurryableTestClass();

        $result1 = $test->autoCurry()->add(1);
        $this->assertTrue(is_callable($result1), "Failed assertion that result1 is callable");

        $result2 = $result1(2, 3);
        $this->assertTrue(is_callable($result2), "Failed assertion that result2 is callable");

        $result3 = $result2(4);
        $this->assertEquals(1 + 2 + 3 + 4, $result3);
    }

    public function testAutoCurryingParameterOrdering()
    {
        $test = new CurryableTestClass();

        $f = $test->autoCurry()->linear(10, 5); // f(x) = 10 * x + 5

        $this->assertEquals(-5, $f(-1));
        $this->assertEquals(5, $f(0));
        $this->assertEquals(15, $f(1));
    }

    public function testCurry()
    {
        $test = new CurryableTestClass();

        $this->assertFalse(is_callable($test->autoCurry()->square(1, 0, 0)));

        $f = $test->curry()->square(1, 0, 0);

        $this->assertTrue(is_callable($f));
        $this->assertEquals(0, $f(0));
        $this->assertEquals(1, $f(1));
        $this->assertEquals(4, $f(2));
        $this->assertEquals(9, $f(3));
    }
}

class CurryableTestClass implements Curryable
{
    use CurryTrait;

    public function add($a, $b, $c, $d)
    {
        return $a + $b + $c + $d;
    }

    public function linear($a, $b, $x)
    {
        return $a * $x + $b;
    }

    public function square($a, $b, $c, $x = 0)
    {
        return $a * $x * $x + $b * $x + $c;
    }
}
