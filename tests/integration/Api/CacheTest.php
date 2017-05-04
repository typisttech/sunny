<?php

declare(strict_types=1);

namespace TypistTech\Sunny\Api;

use AspectMock\Test;
use Codeception\TestCase\WPTestCase;
use TypistTech\Sunny\OptionStore;
use TypistTech\Sunny\Vendor\Cloudflare\Zone\Cache as CloudflareCache;

/**
 * @coversDefaultClass \TypistTech\Sunny\Api\Cache
 */
class CacheTest extends WPTestCase
{
    /**
     * @var \TypistTech\Sunny\IntegrationTester
     */
    protected $tester;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var \AspectMock\Proxy\InstanceProxy
     */
    private $cloudflareCache;

    public function setUp()
    {
        parent::setUp();
        $this->cloudflareCache = Test::double(
            new CloudflareCache,
            [
                'purgeFiles' => [ true ],
            ]
        );
        $container = $this->tester->getContainer();
        $optionStore = Test::double(
            $container->get(OptionStore::class),
            [
                'getApiKey' => 'my-api-key',
                'getEmail' => 'me@example.com',
                'getZoneId' => 'my-zone',
            ]
        )->getObject();
        $container->add(OptionStore::class, $optionStore);
        $this->cache = new Cache(
            $optionStore,
            $this->cloudflareCache->getObject()
        );
    }

    /**
     * @covers ::purgeFiles
     */
    public function testPurgeUrls()
    {
        $urls = [
            'https://www.example.com/1',
            'https://www.example.com/2',
        ];

        $this->cache->purgeFiles(...$urls);

        $this->cloudflareCache->verifyInvokedMultipleTimes('setEmail', 1);
        $this->cloudflareCache->verifyInvokedOnce('setEmail', [ 'me@example.com' ]);
        $this->cloudflareCache->verifyInvokedMultipleTimes('setAuthKey', 1);
        $this->cloudflareCache->verifyInvokedOnce('setAuthKey', [ 'my-api-key' ]);
        $this->cloudflareCache->verifyInvokedMultipleTimes('purge_files', 1);
        $this->cloudflareCache->verifyInvokedOnce('purge_files', [ 'my-zone', $urls ]);
    }
}
