<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable;

use Gentle\Embeddable\Time\Hour;
use Gentle\Embeddable\Time\Minute;
use Gentle\Embeddable\Time\Second;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
final class Time extends Embeddable
{
    /** @var Hour */
    private $hour;

    /** @var Minute */
    private $minutes;

    /** @var Second */
    private $seconds;

    /** @var \DateTime */
    private $dateTime;

    /**
     * @static
     * @access public
     * @param  \DateTime $dateTime
     * @return Time
     *
     * @throws \OutOfRangeException
     * @throws \InvalidArgumentException
     * @throws \LengthException
     */
    public static function from(\DateTime $dateTime)
    {
        return new self(
            new Hour($dateTime->format('H')),
            new Minute($dateTime->format('i')),
            new Second($dateTime->format('s'))
        );
    }

    /**
     * @param Hour    $hour
     * @param Minute $minutes
     * @param Second $seconds
     *
     * @throws \OutOfRangeException
     */
    public function __construct(Hour $hour, Minute $minutes, Second $seconds)
    {
        $this->dateTime = \DateTime::createFromFormat(
            'H:i:s',
            sprintf('%s:%s:%s', $hour, $minutes, $seconds),
            new \DateTimeZone(date_default_timezone_get())
        );
        $this->hour = $hour;
        $this->minutes = $minutes;
        $this->seconds = $seconds;
    }

    /**
     * @access public
     * @param  \DateTimeZone $timezone
     * @return Time
     *
     * @see \DateTimeZone::listIdentifiers()
     *
     * @throws \OutOfRangeException
     * @throws \InvalidArgumentException
     */
    public function withTimeZone(\DateTimeZone $timezone)
    {
        date_default_timezone_set($timezone->getName());

        return new self(
            new Hour((string)$this->getHour()),
            new Minute((string)$this->getMinutes()),
            new Second((string)$this->getSeconds())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function equals(Embeddable $object)
    {
        /* @var Time $object */
        return get_class($object) === 'Gentle\Embeddable\Time' &&
            (string)$this->hour === (string)$object->getHour() &&
            (string)$this->minutes === (string)$object->getMinutes() &&
            (string)$this->seconds === (string)$object->getSeconds()
        ;
    }

    /**
     * Returned format is `H-i-s`.
     *
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf('%s:%s:%s', $this->getHour(), $this->getMinutes(), $this->getSeconds());
    }

    /**
     * @access public
     * @return Hour
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @access public
     * @return Minute
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * @access public
     * @return Second
     */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * @access public
     * @return \DateTime
     */
    public function asDateTime()
    {
        return $this->dateTime;
    }
}
