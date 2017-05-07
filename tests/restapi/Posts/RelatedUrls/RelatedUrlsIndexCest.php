<?php

declare(strict_types=1);

namespace TypistTech\Sunny\REST\Posts\RelatedUrls;

use TypistTech\Sunny\RestapiTester;

class RelatedUrlsIndexCest
{
    public function testForbidden(RestapiTester $I)
    {
        $id = 167;
        $I->assertForbiddenGet('/sunny/v2/posts/' . $id . '/related-urls');
    }
}
