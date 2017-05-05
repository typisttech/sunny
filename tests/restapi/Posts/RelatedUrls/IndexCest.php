<?php

declare(strict_types=1);

namespace TypistTech\Sunny\REST\Posts\RelatedUrls;

use TypistTech\Sunny\RestapiTester;

class IndexCest
{
    public function testIndex(RestapiTester $I)
    {
        $siteUrl = $I->grabSiteUrl();
        $id = 167;

        $I->sendGET('/sunny/v2/posts/' . $id . '/related-urls');

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

    public function testNonFound(RestapiTester $I)
    {
        $id = 9999999999999;

        $I->sendGET('/sunny/v2/posts/' . $id . '/related-urls');

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(404);
        $I->seeResponseContainsJson([
            'code' => 'sunny_not_found',
            'message' => 'Post not found for the given id',
            'data' => [
                'id' => $id,
            ],
        ]);
    }
}
