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
    public function testInstantiateSuccess($value): void
    {
        $year = new Year($value);
        $this->assertInstanceOf(Year::class, $year);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider invalidYearProvider
     */
    public function testInstantiateError($value): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Year($value);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider invalidYearLengthProvider
     */
    public function testLenghtError($value): void
    {
        $this->expectException(\LengthException::class);
        new Year($value);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider validYearProvider
     */
    public function testEqualityByValue($value): void
    {
        $year1 = new Year($value);
        $year2 = new Year($value);

        $this->assertTrue($year1->equals($year2));
        $this->assertNotSame($year1, $year2);
    }

    /**
     * @return array
     */
    public function validYearProvider(): array
    {
        return [
            ['2014'], [1893], ['1981'], ['0129'], ['0041'], ['0001']
        ];
    }

    /**
     * @return array
     */
    public function invalidYearProvider(): array
    {
        return [
            ['24a9'], ['aa4b'], ['not valid'], ['43.12'], ['14.1'], ['43,01'], [new \stdClass()], ['4321a'], [['3412']],
        ];
    }

    public function invalidYearLengthProvider(): array
    {
        return [
            [999], [41], [3], ['014'], ['24'], ['1']
        ];
    }
}
