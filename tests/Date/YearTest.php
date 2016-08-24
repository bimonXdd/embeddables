<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Test\Date;

use Gentle\Embeddable\Date\Year;
use Gentle\Embeddable\Test\TestCase;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class YearTest extends TestCase
{
    /**
     * @param string|int $value
     *
     * @dataProvider validYearProvider
     */
    public function testInstantiateSuccess($value)
    {
        $year = new Year($value);
        $this->assertInstanceOf('Gentle\Embeddable\Date\Year', $year);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider invalidYearProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInstantiateError($value)
    {
        new Year($value);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider invalidYearLengthProvider
     * @expectedException \LengthException
     */
    public function testLenghtError($value)
    {
        new Year($value);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider validYearProvider
     */
    public function testEqualityByValue($value)
    {
        $year1 = new Year($value);
        $year2 = new Year($value);

        $this->assertTrue($year1->equals($year2));
        $this->assertNotSame($year1, $year2);
    }

    /**
     * @return array
     */
    public function validYearProvider()
    {
        return [
            ['2014'], [1893], ['1981'], ['0129'], ['0041'], ['0001']
        ];
    }

    /**
     * @return array
     */
    public function invalidYearProvider()
    {
        return [
            ['24a9'], ['aa4b'], ['not valid'], ['43.12'], ['14.1'], ['43,01'], [new \stdClass()], ['4321a'], [['3412']],
        ];
    }

    public function invalidYearLengthProvider()
    {
        return [
            [999], [41], [3], ['014'], ['24'], ['1']
        ];
    }
}
