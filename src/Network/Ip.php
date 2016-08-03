<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>.
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Network;

use Gentle\Embeddable\Embeddable;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
final class Ip extends Embeddable
{
    /** @var int */
    private $version = 4;

    /**
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value)
    {
        if (false === filter_var($value, FILTER_VALIDATE_IP)) {
            throw new \InvalidArgumentException('Invalid IP address.');
        }

        $this->value = (string)$value;

        if (false !== filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $this->version = 6;
            $this->value = $this->getCondensed();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function equals(Embeddable $object)
    {
        return get_class($object) === 'Gentle\Embeddable\Network\Ip' && $this->value === (string)$object;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * @access public
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @access public
     * @return string
     */
    public function getExpanded()
    {
        if ($this->version === 4) {
            return $this->value;
        }

        $hex = unpack('H*hex', $this->toBinary());

        return strtolower(substr(preg_replace('/([a-fA-F0-9]{4})/', '$1:', $hex['hex']), 0, -1));
    }

    /**
     * All leading zeros are removed.
     *
     * @access public
     * @return string
     */
    public function getAlternate()
    {
        if ($this->version === 4) {
            return $this->value;
        }

        return preg_replace('/(^|:)0+(\d)/', '\1\2', $this->getExpanded());
    }

    /**
     * All consecutive sections of zeroes are removed.
     *
     * @access public
     * @return string
     */
    public function getCondensed()
    {
        if ($this->version === 4) {
            return $this->value;
        }

        $addr = preg_replace('/(^|:)0+(\d)/', '\1\2', $this->getExpanded());

        if (preg_match_all('/(?:^|:)(?:0(?::|$))+/', $addr, $matches, PREG_OFFSET_CAPTURE)) {
            $max = 0;
            $pos = null;

            foreach ($matches[0] as $match) {
                if (strlen($match[0]) > $max) {
                    $max = mb_strlen($match[0]);
                    $pos = $match[1];
                }
            }

            $addr = substr_replace($addr, '::', $pos, $max);
        }

        return $addr;
    }

    /**
     * @access public
     * @return string
     */
    public function toLong()
    {
        if ($this->version === 4) {
            return sprintf('%u', ip2long($this->value));
        }

        $octet = 16 - 1;
        $long = 0;

        foreach (unpack('C*', inet_pton($this->value)) as $char) {
            $long = bcadd($long, bcmul($char, bcpow(256, $octet--)));
        }

        return $long;
    }

    /**
     * @access public
     * @return string
     */
    public function toHex()
    {
        return '0x'.unpack('H*hex', inet_pton($this->value))['hex'];
    }

    /**
     * @access public
     * @return string
     */
    public function toBinary()
    {
        if ($this->version === 4) {
            return str_pad(
                current(unpack('a4', inet_pton($this->value))),
                16,
                "\0",
                STR_PAD_LEFT
            );
        }

        return current(unpack('a16', inet_pton($this->value)));
    }
}
