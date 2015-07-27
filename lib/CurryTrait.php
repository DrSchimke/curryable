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

trait CurryTrait
{
    /**
     * @param bool $asArray
     *
     * @return CurryProxy
     *
     * @see Curryable::curry()
     */
    public function curry($asArray = false)
    {
        return new CurryProxy($this, false);
    }

    /**
     * @param bool $asArray
     *
     * @return mixed
     *
     * @see Curryable::autoCurry()
     */
    public function autoCurry($asArray = false)
    {
        return new CurryProxy($this);
    }
}
