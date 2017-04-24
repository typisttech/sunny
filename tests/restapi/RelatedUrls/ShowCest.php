<?php

declare(strict_types=1);

namespace TypistTech\Sunny\REST\RelatedUrls;

use TypistTech\Sunny\RestapiTester;

class ShowCest
{
    public function testMissingParams(RestapiTester $I)
    {
        $I->sendGET('/sunny/v2/related-urls');

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson([
            'code' => 'rest_missing_callback_param',
            'message' => 'Missing parameter(s): url',
        ]);
    }

    public function testNonQueryable(RestapiTester $I)
    {
        $siteUrl = $I->grabSiteUrl();

        $I->sendGET('/sunny/v2/related-urls', [
            'url' => $siteUrl . '/not/exist',
        ]);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'code' => 'sunny_related_urls_non_queryable',
            'message' => "The given url doesn't match any post",
            'data' => [
                'sanitized-url' => $siteUrl . '/not/exist',
            ],
        ]);
    }

    public function testShow(RestapiTester $I)
    {
        $siteUrl = $I->grabSiteUrl();

        $I->sendGET('/sunny/v2/related-urls', [
            'url' => $siteUrl . '/2012/11/01/many-tags',
        ]);

        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsJson([
            'category' => [
                $siteUrl . '/category/uncategorized/',
            ],
            'post_tag' => [
                $siteUrl . '/tag/8bit/',
                $siteUrl . '/tag/articles/',
                $siteUrl . '/tag/dowork/',
                $siteUrl . '/tag/fail/',
                $siteUrl . '/tag/ftw/',
                $siteUrl . '/tag/fun/',
                $siteUrl . '/tag/love/',
                $siteUrl . '/tag/mothership/',
                $siteUrl . '/tag/mustread/',
                $siteUrl . '/tag/nailedit/',
                $siteUrl . '/tag/pictures/',
                $siteUrl . '/tag/success/',
                $siteUrl . '/tag/swagger/',
                $siteUrl . '/tag/tags/',
                $siteUrl . '/tag/unseen/',
                $siteUrl . '/tag/wordpress/',
            ],
            'author' => [
                $siteUrl . '/author/manovotny/',
                $siteUrl . '/author/manovotny/feed/',
            ],
            'post-type-archive' => [
                $siteUrl,
                $siteUrl . '?feed=rss2',
            ],
            'feed' => [
                $siteUrl . '/feed/rdf/',
                $siteUrl . '/feed/rss/',
                $siteUrl . '/feed/',
                $siteUrl . '/feed/atom/',
                $siteUrl . '/comments/feed/',
                $siteUrl . '/2012/11/01/many-tags/feed/',
            ],
        ]);
    }
}
