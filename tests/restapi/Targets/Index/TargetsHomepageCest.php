<?php

declare(strict_types=1);

namespace TypistTech\Sunny\REST\Targets\Index;

use TypistTech\Sunny\RestapiTester;

class TargetsHomepageCest
{
    public function testHomepageGroup(RestapiTester $I)
    {
        $siteUrl = $I->grabSiteUrl();

        $I->sendGET('/sunny/v2/targets', [
            'group' => 'homepage',
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'homepage' => [
                $siteUrl,
                $siteUrl . '/blog/',
            ],
        ]);
    }
}
