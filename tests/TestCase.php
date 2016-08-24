<?php
/**
 * Copyright 2016 Alexandru Guzinschi <alex@gentle.ro>
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */
namespace Gentle\Embeddable\Test;

use PHPUnit_Framework_TestCase;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    private static $cloneCache = [];

    public function setUp()
    {
        $this->autoCheckCloning(
            str_replace(array('Test\\', 'Test'), '', get_class($this))
        );
    }

    /**
     * Automaticaly check each class if is clonable.
     *
     * This is used as a method to enforce no cloning rule for any
     * future objects.
     *
     * @param string $class
     */
    private function autoCheckCloning($class)
    {
        if (!in_array($class, self::$cloneCache, false)) {
            self::$cloneCache[] = $class;
            $this->assertObjectCantBeCloned($class);
        }
    }

    /**
     * Make sure the `__clone` method is not part of the public API.
     *
     * @param string $class
     */
    protected function assertObjectCantBeCloned($class)
    {
        $ref = new \ReflectionClass($class);
        if (false !== $ref->isCloneable()) {
            $this->fail(sprintf("A Value Object should not be clonable. [%s]", $class));
        }
    }
}
