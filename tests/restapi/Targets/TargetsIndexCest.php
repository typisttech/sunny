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

    public function testGetContainsHomepage(RestapiTester $I)
    {
        $I->setAdminAuth();

        $I->sendGET('/sunny/v2/targets');

        $siteUrl = $I->grabSiteUrl();

        $I->seeResponseContainsJson([
            'homepage' => [
                $siteUrl,
                $siteUrl . '/blog/',
            ],
        ]);
    }

    public function testGetReturnsJson(RestapiTester $I)
    {
        $I->setAdminAuth();

        $I->sendGET('/sunny/v2/targets');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
