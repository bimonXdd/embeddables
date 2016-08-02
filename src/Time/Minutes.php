<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Time;

use Gentle\Embeddable\EmbeddableInterface;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
final class Minutes implements EmbeddableInterface
{
    /** @var string */
    private $value;

    /**
     * @param string|int $value
     *
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    public function __construct($value)
    {
        if (is_int($value)) {
            $value = (string)$value;
        }

        if (!is_string($value) || !ctype_digit($value)) {
            throw new \InvalidArgumentException(sprintf('Expected string or integer and got %s', gettype($value)));
        }

        $value = str_pad($value, 2, 0, STR_PAD_LEFT);

        if ((mb_strlen($value) !== 2) || !in_array((int)$value, range(0, 59), true)) {
            throw new \OutOfRangeException('Expected a numeric representation of minutes.');
        }

        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function equals(EmbeddableInterface $object)
    {
        return get_class($object) === 'Gentle\Embeddable\Time\Minutes' && $this->value === (string)$object;
    }

    /**
     * {@inheritdoc}
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
