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
    public function testInstantiateSuccess($value): void
    {
        $day = new Day($value);
        $this->assertInstanceOf(Day::class, $day);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider invalidDayProvider
     */
    public function testInstantiateError($value): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Day($value);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider invalidDayRangeProvider
     */
    public function testDayRangeError($value): void
    {
        $this->expectException(\OutOfRangeException::class);
        new Day($value);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider validDayProvider
     */
    public function testEqualityByValue($value): void
    {
        $day1 = new Day($value);
        $day2 = new Day($value);

        $this->assertTrue($day1->equals($day2));
        $this->assertNotSame($day1, $day2);
    }

    /**
     * @return array
     */
    public function validDayProvider(): array
    {
        return [
            ['04'], [2], ['12'], ['8'], ['09'], ['31'], [29], ['013']
        ];
    }

    /**
     * @return array
     */
    public function invalidDayProvider(): array
    {
        return [
            ['aa4b'], ['not valid'], ['43.12'], ['14.1'], ['43,01'], [new \stdClass()], ['4321a'], [['3412']]
        ];
    }

    public function invalidDayRangeProvider(): array
    {
        return [
            [999], [312], ['41'], ['32'], ['100']
        ];
    }
}
