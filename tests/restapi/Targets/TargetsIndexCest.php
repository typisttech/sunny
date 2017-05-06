<?php

declare(strict_types=1);

namespace TypistTech\Sunny\REST\Targets;

use TypistTech\Sunny\RestapiTester;

class TargetsIndexCest
{
    public function testIndex(RestapiTester $I)
    {
        $siteUrl = $I->grabSiteUrl();

        $I->sendGET('/sunny/v2/targets');

        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'homepage' => [
                $siteUrl,
                $siteUrl . '/blog/',
            ],
        ]);
    }
}
