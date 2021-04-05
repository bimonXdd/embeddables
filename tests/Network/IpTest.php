<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Test\Network;

use Gentle\Embeddable\Network\Ip;
use Gentle\Embeddable\Test\TestCase;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class IpTest extends TestCase
{
    /**
     * @dataProvider validProvider
     */
    public function testValidIp($version, $expanded, $alternate, $condensed, $hex, $long, $binary): void
    {
        $obj = new Ip($expanded);
        $this->assertInstanceOf('Gentle\Embeddable\Network\Ip', $obj);
        $this->assertEquals($condensed, (string)$obj);
    }

    /**
     * @dataProvider validProvider
     */
    public function testVersion($version, $expanded, $alternate, $condensed, $hex, $long, $binary): void
    {
        $obj = new Ip($alternate);
        $this->assertEquals($version, $obj->getVersion());
    }

    /**
     * @dataProvider validProvider
     */
    public function testEqualityByValue($version, $expanded, $alternate, $condensed, $hex, $long, $binary): void
    {
        $obj1 = new Ip($expanded);
        $obj2 = new Ip($condensed);

        $this->assertTrue($obj1->equals($obj2));
    }

    /**
     * @dataProvider invalidIpProvider
     * @param $value
     */
    public function testInvalidIp($value): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Ip($value);
    }

    /**
     * @dataProvider validProvider
     */
    public function testToLongConversion($version, $expanded, $alternate, $condensed, $hex, $long, $binary): void
    {
        $obj = new Ip($expanded);
        $this->assertEquals($long, $obj->toLong());

        $obj = new Ip($alternate);
        $this->assertEquals($long, $obj->toLong());

        $obj = new Ip($condensed);
        $this->assertEquals($long, $obj->toLong());
    }

    /**
     * @dataProvider validProvider
     */
    public function testToHexConversion($version, $expanded, $alternate, $condensed, $hex, $long, $binary): void
    {
        $obj = new Ip($expanded);
        $this->assertEquals($hex, $obj->toHex());

        $obj = new Ip($alternate);
        $this->assertEquals($hex, $obj->toHex());

        $obj = new Ip($condensed);
        $this->assertEquals($hex, $obj->toHex());
    }

    /**
     * @dataProvider validProvider
     */
    public function testToBinaryConversion($version, $expanded, $alternate, $condensed, $hex, $long, $binary): void
    {
        $obj = new Ip($expanded);
        $this->assertEquals($binary, base64_encode($obj->toBinary()));

        $obj = new Ip($alternate);
        $this->assertEquals($binary, base64_encode($obj->toBinary()));

        $obj = new Ip($condensed);
        $this->assertEquals($binary, base64_encode($obj->toBinary()));
    }

    /**
     * @dataProvider validProvider
     */
    public function testExpand($version, $expanded, $alternate, $condensed, $hex, $long, $binary): void
    {
        $obj = new Ip($expanded);
        $this->assertEquals(strtolower($expanded), $obj->getExpanded());

        $obj = new Ip($alternate);
        $this->assertEquals(strtolower($expanded), $obj->getExpanded());

        $obj = new Ip($condensed);
        $this->assertEquals(strtolower($expanded), $obj->getExpanded());
    }

    /**
     * @dataProvider validProvider
     */
    public function testAlternate($version, $expanded, $alternate, $condensed, $hex, $long, $binary): void
    {
        $obj = new Ip($expanded);
        $this->assertEquals(strtolower($alternate), $obj->getAlternate());

        $obj = new Ip($alternate);
        $this->assertEquals(strtolower($alternate), $obj->getAlternate());

        $obj = new Ip($condensed);
        $this->assertEquals(strtolower($alternate), $obj->getAlternate());
    }

    /**
     * @dataProvider validProvider
     */
    public function testCondensed($version, $expanded, $alternate, $condensed, $hex, $long, $binary): void
    {
        $obj = new Ip($expanded);
        $this->assertEquals(strtolower($condensed), $obj->getCondensed());

        $obj = new Ip($alternate);
        $this->assertEquals(strtolower($condensed), $obj->getCondensed());

        $obj = new Ip($condensed);
        $this->assertEquals(strtolower($condensed), $obj->getCondensed());
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Note: Any binary data *should* be stored as base64 encoded string.
     *
     * @return array
     */
    public function validProvider(): array
    {
        return [
            // Format: version, expanded, alternate, condensed, hex, long, base64 encoded binary
            'ipv4 localhost'        => [4, '127.0.0.1', '127.0.0.1', '127.0.0.1', '0x7f000001', '2130706433', 'AAAAAAAAAAAAAAAAfwAAAQ=='],
            'ipv4 class C'          => [4, '192.168.1.4', '192.168.1.4', '192.168.1.4', '0xc0a80104', '3232235780', 'AAAAAAAAAAAAAAAAwKgBBA=='],
            'ipv6 localhost'        => [6, '0000:0000:0000:0000:0000:0000:0000:0001', '0:0:0:0:0:0:0:1', '::1', '0x00000000000000000000000000000001', '1', 'AAAAAAAAAAAAAAAAAAAAAQ=='],
            'ipv6 google dns#1'     => [
                6,
                '2001:4860:4860:0000:0000:0000:0000:8888',
                '2001:4860:4860:0:0:0:0:8888',
                '2001:4860:4860::8888',
                '0x20014860486000000000000000008888',
                '42541956123769884636017138956568135816',
                'IAFIYEhgAAAAAAAAAACIiA=='
            ],
            'ipv6 google dns#2'     => [
                6,
                '2001:4860:4860:0000:0000:0000:0000:8844',
                '2001:4860:4860:0:0:0:0:8844',
                '2001:4860:4860::8844',
                '0x20014860486000000000000000008844',
                '42541956123769884636017138956568135748',
                'IAFIYEhgAAAAAAAAAACIRA=='
            ],
            'google #1'             => [
                6,
                '2A00:1450:4017:0805:0000:0000:0000:200E',
                '2a00:1450:4017:805:0:0:0:200e',
                '2a00:1450:4017:805::200e',
                '0x2a00145040170805000000000000200e',
                '55827987829246424630098187155429924878',
                'KgAUUEAXCAUAAAAAAAAgDg=='
            ],
            'yahoo #1'              => [
                6,
                '2a00:1288:0110:0002:0000:0000:0000:4001',
                '2a00:1288:110:2:0:0:0:4001',
                '2a00:1288:110:2::4001',
                '0x2a001288011000020000000000004001',
                '55827951681698262191806107587214065665',
                'KgASiAEQAAIAAAAAAABAAQ=='
            ]
        ];
    }

    /**
     * @return array
     */
    public function invalidIpProvider(): array
    {
        return [
            [new \stdClass()], ['43'], ['21.3'], ['4,21'], [[]], ['not ip'], [2], [41], ['127.0.0'], ['192.1'],
            'too short ipv6'            => ['2a00:1288:0110:0002:0000:0000:0000'],
            'too long ipv6'             => ['2a00:1288:0110:0002:0000:0000:0000:4001:4004'],
            'ipv6 with triple colon'    => ['2a00:1288:110:2:::4001'],
            'ipv6 invalid alternate'    => ['2001:4860:4860:0::::8888']
        ];
    }
}
