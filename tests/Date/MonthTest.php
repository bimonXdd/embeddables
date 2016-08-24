<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Test\Date;

use Gentle\Embeddable\Date\Month;
use Gentle\Embeddable\Test\TestCase;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class MonthTest extends TestCase
{
    /**
     * @param string|int $value
     *
     * @dataProvider validMonthProvider
     */
    public function testInstantiateSuccess($value)
    {
        $month = new Month($value);
        $this->assertInstanceOf('Gentle\Embeddable\Date\Month', $month);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider invalidMonthProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInstantiateError($value)
    {
        new Month($value);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider invalidMonthRangeProvider
     * @expectedException \OutOfRangeException
     */
    public function testMonthRangeError($value)
    {
        new Month($value);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider validMonthProvider
     */
    public function testEqualityByValue($value)
    {
        $month1 = new Month($value);
        $month2 = new Month($value);

        $this->assertTrue($month1->equals($month2));
        $this->assertNotSame($month1, $month2);
    }

    /**
     * @return array
     */
    public function validMonthProvider()
    {
        return [
            ['04'], [2], ['12'], ['8'], ['09']
        ];
    }

    /**
     * @return array
     */
    public function invalidMonthProvider()
    {
        return [
            ['aa4b'], ['not valid'], ['43.12'], ['14.1'], ['43,01'], [new \stdClass()], ['4321a'], [['3412']],
        ];
    }

    public function invalidMonthRangeProvider()
    {
        return [
            [999], [312], ['014'], ['24'], ['100']
        ];
    }
}
