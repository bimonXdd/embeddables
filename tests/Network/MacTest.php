<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Test\Network;

use Gentle\Embeddable\Network\Mac;
use Gentle\Embeddable\Test\TestCase;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class MacTest extends TestCase
{
    /**
     * @dataProvider validMacProvider
     */
    public function testValidMac($value): void
    {
        $obj = new Mac($value);
        $this->assertInstanceOf(Mac::class, $obj);
        $this->assertEquals($value, (string)$obj);
    }

    /**
     * @dataProvider validMacProvider
     */
    public function testEqualityByValue($value): void
    {
        $obj1 = new Mac($value);
        $obj2 = new Mac($value);

        $this->assertTrue($obj1->equals($obj2));
    }

    /**
     * @dataProvider invalidMacProvider
     */
    public function testInvalidMac($value): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Mac($value);
    }

    /**
     * @return array
     */
    public function validMacProvider(): array
    {
        return [
            'IEEE 802' => ['01-23-45-67-89-ab'],
            'six groups of two hexadecimal digits separated by colons' => ['01:23:45:67:89:ab'],
            'three groups of four hexadecimal digits separated by dots (CISCO)' => ['0123.4567.89ab']
        ];
    }

    /**
     * @return array
     */
    public function invalidMacProvider(): array
    {
        return [
            [new \stdClass()], ['43'], ['21.3'], ['4,21'], [[]], ['not mac'], [2], [41], ['127.0.0.1'], ['192.168.1.4'],
            'too short mac #1'              => ['01-23-45-67-89-a'],
            'too short mac #2'              => ['01-23-45-67-89'],
            'too long mac #1'               => ['01-23-45-67-89-ab-4'],
            'too long mac #2'               => ['01-23-45-67-89-ab-42'],
            'mac with mixed separators 1'   => ['01-23-45-67:89-ab'],
            'mac with mixed separators 2'   => ['01:23:45-67:89:ab']
        ];
    }
}
