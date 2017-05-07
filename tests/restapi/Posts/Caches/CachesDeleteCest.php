<?php

declare(strict_types=1);

namespace TypistTech\Sunny\REST\Posts\Caches;

use TypistTech\Sunny\RestapiTester;

class CachesDeleteCest
{
    public function testForbidden(RestapiTester $I)
    {
        $id = 167;
        $I->assertForbiddenDelete('/sunny/v2/posts/' . $id . '/caches', [
            'reason' => 'just do it',
        ]);
    }
}
