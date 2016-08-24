<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Test;

use Gentle\Embeddable\Time;
use Gentle\Embeddable\Time\Hour;
use Gentle\Embeddable\Time\Minute;
use Gentle\Embeddable\Time\Second;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class TimeTest extends TestCase
{
    /**
     * @param $hour
     * @param $minutes
     * @param $seconds
     *
     * @dataProvider validTimeProvider
     */
    public function testInstantiateSuccess($hour, $minutes, $seconds)
    {
        $time = new Time(
            new Hour($hour),
            new Minute($minutes),
            new Second($seconds)
        );

        $this->assertInstanceOf('Gentle\Embeddable\Time', $time);
    }

    /**
     * @param $hour
     * @param $minutes
     * @param $seconds
     *
     * @dataProvider validTimeProvider
     */
    public function testTimezoneChange($hour, $minutes, $seconds)
    {
        $time1 = new Time(new Hour($hour), new Minute($minutes), new Second($seconds));
        $this->assertEquals(date_default_timezone_get(), $time1->asDateTime()->getTimezone()->getName());

        $random = $this->getRandomTimeZone();
        $time   = $time1->withTimeZone(new \DateTimeZone($random));

        $this->assertEquals($random, $time->asDateTime()->getTimezone()->getName());
        $this->assertNotSame($time1, $time);
    }

    /**
     * @return string
     */
    private function getRandomTimeZone()
    {
        $timezones = array_values(\DateTimeZone::listIdentifiers());

        return $timezones[array_rand($timezones, 1)];
    }

    /**
     * @param $hour
     * @param $minutes
     * @param $seconds
     *
     * @dataProvider invalidTimeSegmentsRangeErrorProvider
     * @expectedException \OutOfRangeException
     */
    public function testRangeError($hour, $minutes, $seconds)
    {
        new Time(
            new Hour($hour),
            new Minute($minutes),
            new Second($seconds)
        );
    }

    /**
     * @param $hour
     * @param $minutes
     * @param $seconds
     *
     * @dataProvider validTimeProvider
     */
    public function testEqualityByValue($hour, $minutes, $seconds)
    {
        $expected = new Time(
            new Hour($hour),
            new Minute($minutes),
            new Second($seconds)
        );

        $actual = new Time(
            new Hour($hour),
            new Minute($minutes),
            new Second($seconds)
        );

        $this->assertTrue($expected->equals($actual));
        $this->assertNotSame($expected, $actual);
    }

    /**
     * @param $hour
     * @param $minutes
     * @param $seconds
     *
     * @dataProvider validTimeProvider
     */
    public function testNativeDateTime($hour, $minutes, $seconds)
    {
        $time = new Time(
            new Hour($hour),
            new Minute($minutes),
            new Second($seconds)
        );

        $this->assertEquals((string)$time, $time->asDateTime()->format('H:i:s'));
    }

    /**
     * @param $hour
     * @param $minutes
     * @param $seconds
     *
     * @dataProvider validTimeProvider
     */
    public function testFromNativeDateTime($hour, $minutes, $seconds)
    {
        $native = \DateTime::createFromFormat(
            'H:i:s',
            sprintf(
                '%s:%s:%s',
                str_pad($hour, 2, 0, STR_PAD_LEFT),
                str_pad($minutes, 2, 0, STR_PAD_LEFT),
                str_pad($seconds, 2, 0, STR_PAD_LEFT)
            )
        );

        $this->assertInstanceOf('Gentle\Embeddable\Time', Time::from($native));
    }

    /**
     * @return array
     */
    public function validTimeProvider()
    {
        return [
            [02, 3, 21],
            ['05', 11, 14],
            [11, '05', 23],
            [11, '25', '04'],
            ['21', '32', '41'],
            ['00', 0, '00']
        ];
    }

    /**
     * @return array
     */
    public function invalidTimeSegmentsRangeErrorProvider()
    {
        return [
            ['00', '00', 60],
            ['24', '10', 12],
            ['23', '60', 59],
            ['23', 59, '60']
        ];
    }
}
