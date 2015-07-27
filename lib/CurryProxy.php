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

class CurryProxy
{
    /** @var object */
    private $object;

    /**
     * @var bool
     */
    private $autoCurrying;

    /**
     * @param object $object
     * @param bool   $autoCurrying
     */
    public function __construct($object, $autoCurrying = true)
    {
        $this->object = $object;
        $this->autoCurrying = (boolean) $autoCurrying;
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return callable|mixed
     */
    public function __call($name, array $arguments)
    {
        return $this->autoCurrying ? $this->doAutoCurry($name, $arguments) : $this->doCurry($name, $arguments);
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return callable|mixed
     */
    private function doAutoCurry($name, array $arguments)
    {
        $method = new \ReflectionMethod($this->object, $name);

        if (count($arguments) < $method->getNumberOfRequiredParameters()) {
            $result = function () use ($name, $arguments) {
                $arguments = array_merge($arguments, func_get_args());

                return $this->doAutoCurry($name, $arguments);
            };
        } else {
            $result = call_user_func_array([$this->object, $name], $arguments);
        }

        return $result;
    }

    private function doCurry($name, array $arguments)
    {
        return function () use ($name, $arguments) {
            $arguments = array_merge($arguments, func_get_args());

            return call_user_func_array([$this->object, $name], $arguments);
        };
    }
}
