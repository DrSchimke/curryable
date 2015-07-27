<?php

/**
 * This file is part of the sci/curryable package.
 *
 * (c) Sascha Schimke <sascha@schimke.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sci\Curryable;

/**
 * Interface Curryable.
 *
 * @see http://en.wikipedia.org/wiki/Currying
 */
interface Curryable
{
    /**
     * $obj->curry()->something() returns a curried version of method $obj->something(), i.e. an anonymous function
     * representing a partially applied $obj->something().
     *
     * Arguments $args given to $f = $obj->curry()->something($args) are combined with arguments $args2 given to
     * $f($args2), which realizes the uncurrying.
     *
     * @param bool $asArray
     *
     * @return mixed
     */
    public function curry($asArray = false);

    /**
     * $obj->autoCurry()->something($args) returns:
     * - the result of $obj->something(), if all required arguments are given
     * - a curried version of method $obj->something(), if the number of arguments $args is smaller than number of
     *   required arguments of $obj->something().
     *
     * Given $f = $obj->autoCurry()->something() and the number of arguments $args for $f($args) is smaller then
     * required, $f() recursively returns further curried functions.
     *
     * @param bool $asArray
     *
     * @return mixed
     */
    public function autoCurry($asArray = false);
}
