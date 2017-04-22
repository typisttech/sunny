<?php

declare(strict_types=1);

namespace TypistTech\Sunny\Helper;

use AspectMock\Test;
use Codeception\Module;
use Codeception\TestInterface;

/**
 * Here you can define custom actions
 * All public methods declared in helper class will be available in $I
 */
class Unit extends Module
{
    public function _after(TestInterface $test)
    {
        Test::clean();
    }
}
