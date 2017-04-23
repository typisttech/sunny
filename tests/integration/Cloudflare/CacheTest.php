<?php

declare(strict_types=1);

namespace TypistTech\Sunny\Cloudflare;

use AspectMock\Test;
use Codeception\TestCase\WPTestCase;
use TypistTech\Sunny\Container;
use TypistTech\Sunny\OptionStore;
use TypistTech\Sunny\Vendor\Cloudflare\Zone\Cache as CloudflareCache;

/**
 * @coversDefaultClass \TypistTech\Sunny\Cloudflare\Cache
 */
class CacheTest extends WPTestCase
{
    /**
     * @var \TypistTech\Sunny\IntegrationTester
     */
    protected $tester;

    /**
     * @var \AspectMock\Proxy\InstanceProxy
     */
    private $cloudflareCache;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Cache
     */
    private $cache;

    public function setUp()
    {
        parent::setUp();
        $this->cloudflareCache = Test::double(
            new CloudflareCache,
            [
                'purge_files' => [ true ],
            ]
        );
        $this->container = $this->tester->getContainer();
        $optionStore = Test::double(
            $this->container->get(OptionStore::class),
            [
                'getApiKey' => 'my-api-key',
                'getEmail' => 'me@example.com',
                'getZoneId' => 'my-zone',
            ]
        )->getObject();
        $this->container->add(OptionStore::class, $optionStore);
        $this->cache = new Cache(
            $optionStore,
            $this->cloudflareCache->getObject()
        );
    }

    /**
     * @covers ::purge
     */
    public function testPurgeUrls()
    {
        $urls = [
            'https://www.example.com/1',
            'https://www.example.com/2',
        ];

        $this->cache->purge(...$urls);

        $this->cloudflareCache->verifyInvokedMultipleTimes('setEmail', 1);
        $this->cloudflareCache->verifyInvokedOnce('setEmail', [ 'me@example.com' ]);
        $this->cloudflareCache->verifyInvokedMultipleTimes('setAuthKey', 1);
        $this->cloudflareCache->verifyInvokedOnce('setAuthKey', [ 'my-api-key' ]);
        $this->cloudflareCache->verifyInvokedMultipleTimes('purge_files', 1);
        $this->cloudflareCache->verifyInvokedOnce('purge_files', [ 'my-zone', $urls ]);
    }
}
