<?php

declare(strict_types=1);

namespace TypistTech\Sunny\REST\Posts\RelatedUrls;

use TypistTech\Sunny\RestapiTester;

class RelatedUrlsIndexCest
{
    const POST_ID = 167;

    public function testForbidden(RestapiTester $I)
    {
        $I->assertForbiddenGet('/sunny/v2/posts/' . self::POST_ID . '/related-urls');
    }

    public function testGetContainsAdjacentPost(RestapiTester $I)
    {
        $this->assertGetContains(
            $I,
            'adjacent-post',
            '/2012/10/02/many-categories/',
            '/2012/12/02/post-format-video-videopress/'
        );
    }

    private function assertGetContains(RestapiTester $I, string $group, string ...$urls)
    {
        $I->setAdminAuth();

        $I->sendGET('/sunny/v2/posts/' . self::POST_ID . '/related-urls');

        $siteUrl = $I->grabSiteUrl();
        $expected = array_map(
            function (string $url) use ($siteUrl) {
                return $siteUrl . $url;
            },
            $urls
        );

        $I->seeResponseContainsJson(
            [
                $group => $expected,
            ]
        );
    }

    public function testGetContainsAuthor(RestapiTester $I)
    {
        $this->assertGetContains(
            $I,
            'author',
            '/author/manovotny/',
            '/author/manovotny/feed/'
        );
    }

    public function testGetContainsCategory(RestapiTester $I)
    {
        $this->assertGetContains(
            $I,
            'category',
            '/category/uncategorized/'
        );
    }

    public function testGetContainsFeed(RestapiTester $I)
    {
        $this->assertGetContains(
            $I,
            'feed',
            '/feed/rdf/',
            '/feed/rss/',
            '/feed/',
            '/feed/atom/',
            '/comments/feed/',
            '/2012/11/01/many-tags/feed/'
        );
    }

    public function testGetContainsPostTag(RestapiTester $I)
    {
        $this->assertGetContains(
            $I,
            'post_tag',
            '/tag/8bit/',
            '/tag/articles/',
            '/tag/dowork/',
            '/tag/fail/',
            '/tag/ftw/',
            '/tag/fun/',
            '/tag/love/',
            '/tag/mothership/',
            '/tag/mustread/',
            '/tag/nailedit/',
            '/tag/pictures/',
            '/tag/success/',
            '/tag/swagger/',
            '/tag/tags/',
            '/tag/unseen/',
            '/tag/wordpress/'
        );
    }

    public function testGetContainsPostTypeArchive(RestapiTester $I)
    {
        $this->assertGetContains(
            $I,
            'post-type-archive',
            '/blog/',
            '/blog/?feed=rss2'
        );
    }

    public function testGetReturnsJson(RestapiTester $I)
    {
        $I->setAdminAuth();

        $I->sendGET('/sunny/v2/posts/' . self::POST_ID . '/related-urls');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
