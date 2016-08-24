<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Network;

use Gentle\Embeddable\Embeddable;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
final class Mac extends Embeddable
{
    /**
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value)
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException(sprintf('Expected string and got %s', gettype($value)));
        }

        if (false === filter_var($value, FILTER_VALIDATE_MAC)) {
            throw new \InvalidArgumentException('Invalid MAC address.');
        }

        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function equals(Embeddable $object)
    {
        return get_class($object) === 'Gentle\Embeddable\Network\Mac' && $this->value === (string)$object;
    }
}
