<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable;

use Gentle\Embeddable\Date\Day;
use Gentle\Embeddable\Date\Month;
use Gentle\Embeddable\Date\Year;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
final class Date extends Embeddable
{
    /** @var Year */
    private $year;

    /** @var Month */
    private $month;

    /** @var Day */
    private $day;

    /** @var \DateTime */
    private $dateTime;

    /**
     * @static
     * @access public
     * @param  \DateTime $birthday
     * @return Date
     *
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     * @throws \DomainException
     * @throws \LengthException
     */
    public static function fromDateTime(\DateTime $birthday)
    {
        $date = clone $birthday;

        return new self(
            new Year($date->format('Y')),
            new Month($date->format('m')),
            new Day($date->format('d'))
        );
    }

    /**
     * @static
     * @access public
     * @param string $date
     * @param string $format
     * @return Date
     *
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     * @throws \DomainException
     * @throws \LengthException
     */
    public static function fromString($date, $format = \DateTime::ATOM)
    {
        $dateTime = \DateTime::createFromFormat($format, $date);

        $err = \DateTime::getLastErrors();
        if ($err['error_count'] > 0) {
            throw new \InvalidArgumentException(sprintf('%s', implode(', ', $err['errors'])));
        }

        return self::fromDateTime($dateTime);
    }

    /**
     * @param Year $year
     * @param Month $month
     * @param Day $day
     *
     * @throws \OutOfRangeException
     * @throws \DomainException
     */
    public function __construct(Year $year, Month $month, Day $day)
    {
        if ((int)sprintf('%s', $day) > ($daysNo = $this->getDaysInMonth($month, $year))) {
            throw new \OutOfRangeException(
                sprintf('Month %s of %s has only %d days.', $month, $year, $daysNo)
            );
        }

        $this->dateTime = \DateTime::createFromFormat('Y-m-d', sprintf('%s-%s-%s', $year, $month, $day));

        // @codeCoverageIgnoreStart
        $err = \DateTime::getLastErrors();
        if ($err !== false && $err['error_count'] > 0) {
            throw new \DomainException(sprintf('%s', implode(', ', $err['errors'])));
        }
        // @codeCoverageIgnoreStop

        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    /**
     * {@inheritdoc}
     */
    public function equals(Embeddable $object)
    {
        /* @var Date $object */
        return get_class($object) === 'Gentle\Embeddable\Date' &&
            (string)$this->year === (string)$object->getYear() &&
            (string)$this->month === (string)$object->getMonth() &&
            (string)$this->day === (string)$object->getDay()
        ;
    }

    /**
     * Returned format is `Y-m-d`.
     *
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf('%s-%s-%s', $this->getYear(), $this->getMonth(), $this->getDay());
    }

    /**
     * @access public
     * @return Year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @access public
     * @return Month
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @access public
     * @return Day
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @access public
     * @return \DateTime
     */
    public function asDateTime()
    {
        return $this->dateTime;
    }

    /**
     * Get number of days in specified month.
     *
     * @access private
     * @param  Month $month
     * @param  Year  $year
     * @return int
     */
    private function getDaysInMonth(Month $month, Year $year)
    {
        return (int)date('t', mktime(0, 0, 0, (string)$month, 1, (string)$year));
    }
}
