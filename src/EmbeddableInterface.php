<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
interface EmbeddableInterface
{
    /**
     * Compare two embeddables.
     *
     * The comparison should be done by value.
     *
     * @access public
     * @param  EmbeddableInterface $embeddable
     * @return bool
     */
    public function equals(EmbeddableInterface $embeddable);

    /**
     * @access public
     * @return string
     */
    public function __toString();
}
