<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Test\Time;

use Gentle\Embeddable\Time\Seconds;
use Gentle\Embeddable\Test\TestCase;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class SecondsTest extends TestCase
{
    /**
     * @param string|int $value
     *
     * @dataProvider validSecondsProvider
     */
    public function testInstantiateSuccess($value)
    {
        $seconds = new Seconds($value);
        $this->assertInstanceOf('Gentle\Embeddable\Time\Seconds', $seconds);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider invalidSecondsProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInstantiateError($value)
    {
        new Seconds($value);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider invalidSecondsRangeProvider
     * @expectedException \OutOfRangeException
     */
    public function testSecondsRangeError($value)
    {
        new Seconds($value);
    }

    /**
     * @param string|int $value
     *
     * @dataProvider validSecondsProvider
     */
    public function testEqualityByValue($value)
    {
        $seconds1 = new Seconds($value);
        $seconds2 = new Seconds($value);

        $this->assertTrue($seconds1->equals($seconds2));
        $this->assertNotSame($seconds1, $seconds2);
    }

    /**
     * @return array
     */
    public function validSecondsProvider()
    {
        return [
            ['04'], [2], ['12'], ['8'], ['09'], ['00'], [0]
        ];
    }

    /**
     * @return array
     */
    public function invalidSecondsProvider()
    {
        return [
            ['aa4b'], ['not valid'], ['43.12'], ['14.1'], ['43,01'], [new \stdClass()], ['4321a'], [['3412']], ['3.14']
        ];
    }

    public function invalidSecondsRangeProvider()
    {
        return [
            [999], [312], ['034'], ['100'], [60], ['61']
        ];
    }
}