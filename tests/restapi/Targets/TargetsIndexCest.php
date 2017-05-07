<?php

declare(strict_types=1);

namespace TypistTech\Sunny\REST\Targets;

use TypistTech\Sunny\RestapiTester;

class TargetsIndexCest
{
    public function testForbidden(RestapiTester $I)
    {
        $I->assertForbiddenGet('/sunny/v2/targets');
    }
}
