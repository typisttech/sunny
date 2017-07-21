<?php

declare(strict_types=1);

namespace TypistTech\Sunny\Caches;

use AspectMock\Test;
use Codeception\TestCase\WPTestCase;

/**
 * @coversDefaultClass \TypistTech\Sunny\Caches\Status
 */
class StatusTest extends WPTestCase
{
    public function statusesProvider(): array
    {
        // @codingStandardsIgnoreStart
        return [
            'HIT' => [ 'HIT', 'Resource in cache, served from Cloudflare CDN cache' ],
            'MISS' => [ 'MISS', 'Resource not in Cloudflare  cache, served from origin server' ],
            'EXPIRED' => [
                'EXPIRED',
                'Resource was in Cloudflare cache but has since expired, served from origin server',
            ],
            'STALE' => [
                'STALE',
                "Resource is in cache but is expired, served from Cloudflare CDN cache because another visitor's request has caused the CDN to fetch the resource from the origin server. This is a very uncommon occurrence and will only impact visitors that want the page right when it expires.",
            ],
            'IGNORED' => [
                'IGNORED',
                "Resource is cacheable but not in Cloudflare cache because it hasn't met the threshold (number of requests, usually 3), served from origin server. Will become a HIT once it passes the threshold.",
            ],
            'REVALIDATED' => [
                'REVALIDATED',
                'REVALIDATED means Cloudflare had a stale representation of the object in Cloudflare cache, but Cloudflare revalidated it by checking using an If-Modified-Since header.',
            ],
            'UPDATING' => [
                'UPDATING',
                'A status of UPDATING indicates that the cache is currently populating for that resource and the response was served stale from the existing cached item. This status is typically only seen when large and/or very popular resources are being added to the cache.',
            ],
        ];
        // @codingStandardsIgnoreEnd
    }

    /**
     * @covers       \TypistTech\Sunny\Caches\Status
     * @dataProvider statusesProvider
     *
     * @param string $status        Cf cache status header.
     * @param string $statusMessage Expected status message.
     */
    public function testKnownStatus(string $status, string $statusMessage)
    {
        Test::func(
            __NAMESPACE__,
            'wp_safe_remote_get',
            [
                'headers' => [
                    'cf-ray' => 'abc123',
                    'cf-cache-status' => $status,
                ],
            ]
        );

        $subject = new Status('https://example.com');

        $actual = $subject->check();

        $expected = [
            'result' => 'done',
            'url' => 'https://example.com',
            'is_cloudflare' => true,
            'status' => $status,
            'status_message' => $statusMessage,
        ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Sunny\Caches\Status
     */
    public function testNotCloudflare()
    {
        Test::func(
            __NAMESPACE__,
            'wp_safe_remote_get',
            [
                'headers' => [],
            ]
        );

        $status = new Status('https://example.com');

        $actual = $status->check();

        $expected = [
            'result' => 'done',
            'url' => 'https://example.com',
            'is_cloudflare' => false,
            'status' => 'NOT_CF',
            'status_message' => 'Resource is not served by Cloudflare',
        ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Sunny\Caches\Status
     */
    public function testUnknownStatus()
    {
        Test::func(
            __NAMESPACE__,
            'wp_safe_remote_get',
            [
                'headers' => [
                    'cf-ray' => 'abc123',
                    'cf-cache-status' => 'weird',
                ],
            ]
        );

        $status = new Status('https://example.com');

        $actual = $status->check();

        // @codingStandardsIgnoreStart
        $expected = [
            'result' => 'done',
            'url' => 'https://example.com',
            'is_cloudflare' => true,
            'status' => 'UNKNOWN',
            'status_message' => 'Resource is not something Cloudflare would ordinarily cache. Check your cache everything page rules.',
        ];
        // @codingStandardsIgnoreEnd

        $this->assertSame($expected, $actual);
    }
}
