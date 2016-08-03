<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Date;

use Gentle\Embeddable\Embeddable;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
final class Month extends Embeddable
{
    /**
     * @param string|int $month
     *
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    public function __construct($month)
    {
        if (is_int($month)) {
            $month = (string)$month;
        }

        if (!is_string($month) || !ctype_digit($month)) {
            throw new \InvalidArgumentException(sprintf('Expected string or integer and got %s', gettype($month)));
        }

        if (!in_array((int)$month, range(1, 12), true)) {
            throw new \OutOfRangeException('Expected a numeric representation of a month.');
        }

        $this->value = str_pad($month, 2, 0, STR_PAD_LEFT);
    }

    /**
     * {@inheritdoc}
     */
    public function equals(Embeddable $object)
    {
        return get_class($object) === 'Gentle\Embeddable\Date\Month' && $this->value === (string)$object;
    }
}
