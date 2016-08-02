<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Date;

use Gentle\Embeddable\EmbeddableInterface;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
final class Day implements EmbeddableInterface
{
    /** @var string */
    private $value;

    /**
     * @param string|int $day
     *
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    public function __construct($day)
    {
        if (is_int($day)) {
            $day = (string)$day;
        }

        if (!is_string($day) || !ctype_digit($day)) {
            throw new \InvalidArgumentException(sprintf('Expected string or integer and got %s', gettype($day)));
        }

        if (!in_array((int)$day, range(1, 31), true)) {
            throw new \OutOfRangeException(
                sprintf('Expected a numeric representation of a day in a range of 1 - 31 (%d).', (int)$day)
            );
        }

        $this->value = str_pad($day, 2, 0, STR_PAD_LEFT);
    }

    /**
     * {@inheritDoc}
     */
    public function equals(EmbeddableInterface $object)
    {
        return get_class($object) === 'Gentle\Embeddable\Date\Day' && $this->value === (string)$object;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * @codeCoverageIgnore
     */
    private function __clone()
    {
    }
}
