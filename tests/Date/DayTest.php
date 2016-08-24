<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Test\Date;

use Gentle\Embeddable\Date\Day;
use Gentle\Embeddable\Test\TestCase;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class DayTest extends TestCase
{
    /**
     * @param string|int $value
     *
     * @dataProvider validDayProvider
     */
    public function testInstantiateSuccess($value)
    {
        $day = new Day($value);
        $this->assertInstanceOf('Gentle\Embeddable\Date\Day', $day);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider invalidDayProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInstantiateError($value)
    {
        new Day($value);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider invalidDayRangeProvider
     * @expectedException \OutOfRangeException
     */
    public function testDayRangeError($value)
    {
        new Day($value);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider validDayProvider
     */
    public function testEqualityByValue($value)
    {
        $day1 = new Day($value);
        $day2 = new Day($value);

        $this->assertTrue($day1->equals($day2));
        $this->assertNotSame($day1, $day2);
    }

    /**
     * @return array
     */
    public function validDayProvider()
    {
        return [
            ['04'], [2], ['12'], ['8'], ['09'], ['31'], [29], ['013']
        ];
    }

    /**
     * @return array
     */
    public function invalidDayProvider()
    {
        return [
            ['aa4b'], ['not valid'], ['43.12'], ['14.1'], ['43,01'], [new \stdClass()], ['4321a'], [['3412']]
        ];
    }

    public function invalidDayRangeProvider()
    {
        return [
            [999], [312], ['41'], ['32'], ['100']
        ];
    }
}
