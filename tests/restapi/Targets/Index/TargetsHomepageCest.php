<?php

declare(strict_types=1);

namespace TypistTech\Sunny\REST\Targets\Index;

use TypistTech\Sunny\RestapiTester;

class TargetsHomepageCest
{
    public function testForbidden(RestapiTester $I)
    {
        $id = 167;
        $I->assertForbiddenGet('/sunny/v2/targets', [
            'group' => 'homepage',
        ]);
    }
}
