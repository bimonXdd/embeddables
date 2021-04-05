<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Test\Time;

use Gentle\Embeddable\Time\Hour;
use Gentle\Embeddable\Test\TestCase;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class HourTest extends TestCase
{
    /**
     * @param string|int $value
     *
     * @dataProvider validHourProvider
     */
    public function testInstantiateSuccess($value): void
    {
        $month = new Hour($value);
        $this->assertInstanceOf(Hour::class, $month);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider invalidHourProvider
     */
    public function testInstantiateError($value): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Hour($value);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider invalidHourRangeProvider
     */
    public function testMonthRangeError($value): void
    {
        $this->expectException(\OutOfRangeException::class);
        new Hour($value);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider validHourProvider
     */
    public function testEqualityByValue($value): void
    {
        $hour1 = new Hour($value);
        $hour2 = new Hour($value);

        $this->assertTrue($hour1->equals($hour2));
        $this->assertNotSame($hour1, $hour2);
    }

    /**
     * @return array
     */
    public function validHourProvider(): array
    {
        return [
            ['04'], [2], ['12'], ['8'], ['09'], ['00'], [0]
        ];
    }

    /**
     * @return array
     */
    public function invalidHourProvider(): array
    {
        return [
            ['aa4b'], ['not valid'], ['43.12'], ['14.1'], ['43,01'], [new \stdClass()], ['4321a'], [['3412']],
        ];
    }

    public function invalidHourRangeProvider(): array
    {
        return [
            [999], [312], ['034'], ['100'], [24], ['24']
        ];
    }
}
