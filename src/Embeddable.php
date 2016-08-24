<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
abstract class Embeddable
{
    /** @var string */
    protected $value;

    /**
     * Compare two embeddables.
     *
     * The comparison should be done by value.
     *
     * @access public
     * @param  Embeddable $object
     * @return bool
     */
    abstract public function equals(Embeddable $object);

    /**
     * @access public
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

    protected function __clone()
    {
    }
}
