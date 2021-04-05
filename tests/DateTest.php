<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Test;

use Gentle\Embeddable\Date;
use Gentle\Embeddable\Date\Year;
use Gentle\Embeddable\Date\Month;
use Gentle\Embeddable\Date\Day;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class DateTest extends TestCase
{
    /**
     * @param $year
     * @param $month
     * @param $day
     *
     * @dataProvider validDatesProvider
     */
    public function testInstantiateSuccess($year, $month, $day): void
    {
        $date = new Date(
            new Year($year),
            new Month($month),
            new Day($day)
        );

        $this->assertInstanceOf(Date::class, $date);
    }

    public function testInstantiateFromString(): void
    {
        $date = Date::fromString('2009-11-04T19:55:41Z');
        $this->assertInstanceOf(Date::class, $date);

        $this->expectException(\InvalidArgumentException::class);
        Date::fromString('2009-11-04T19:55');
    }

    /**
     * @param $year
     * @param $month
     * @param $day
     *
     * @dataProvider invalidDateRangeError
     */
    public function testDayRangeError($year, $month, $day): void
    {
        $this->expectException(\OutOfRangeException::class);
        new Date(
            new Year($year),
            new Month($month),
            new Day($day)
        );
    }

    /**
     * @param $year
     * @param $month
     * @param $day
     *
     * @dataProvider validDatesProvider
     */
    public function testEqualityByValue($year, $month, $day): void
    {
        $expected = new Date(
            new Year($year),
            new Month($month),
            new Day($day)
        );
        $actual = new Date(
            new Year($year),
            new Month($month),
            new Day($day)
        );

        $this->assertTrue($expected->equals($actual));
        $this->assertNotSame($expected, $actual);
    }

    /**
     * @param $year
     * @param $month
     * @param $day
     *
     * @dataProvider validDatesProvider
     */
    public function testNativeDateTime($year, $month, $day): void
    {
        $date = new Date(
            new Year($year),
            new Month($month),
            new Day($day)
        );

        $this->assertEquals((string)$date, $date->asDateTime()->format('Y-m-d'));
    }

    /**
     * @param $year
     * @param $month
     * @param $day
     *
     * @dataProvider validDatesProvider
     */
    public function testFromNativeDateTimeSuccess($year, $month, $day): void
    {
        $native = \DateTime::createFromFormat('Y-m-d', sprintf('%s-%s-%s', $year, $month, $day));

        $this->assertInstanceOf(Date::class, Date::fromDateTime($native));
    }

    /**
     * @return array
     */
    public function validDatesProvider(): array
    {
        return [
            [2015, 3, 21],
            ['1990', 11, 14],
            [2020, '05', 23],
            [1998, 10, '04'],
            ['0900', '08', '01']
        ];
    }

    /**
     * @return array
     */
    public function invalidDateRangeError(): array
    {
        return [
            [2015, 2, 31],
            ['1990', 11, 32],
            [2020, '05', 123],
            [1998, 10, '44'],
            ['0900', '02', '30']
        ];
    }
}
