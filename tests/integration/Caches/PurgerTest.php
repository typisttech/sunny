<?php

declare(strict_types=1);

namespace TypistTech\Sunny\Caches;

use AspectMock\Test;
use Codeception\TestCase\WPTestCase;
use TypistTech\Sunny\Api\Cache;

/**
 * @coversDefaultClass \TypistTech\Sunny\Caches\Purger
 */
class PurgerTest extends WPTestCase
{
    /**
     * @var \TypistTech\Sunny\IntegrationTester
     */
    protected $tester;

    /**
     * @var \AspectMock\Proxy\InstanceProxy
     */
    private $cache;

    /**
     * @var Purger
     */
    private $purger;

    public function setUp()
    {
        parent::setUp();

        $container = $this->tester->getContainer();
        $this->cache = Test::double(
            $container->get(Cache::class),
            [
                'purgeFiles' => [ true ],
            ]
        );
        $container->add(Cache::class, $this->cache->getObject());
        $this->purger = $container->get(Purger::class);
    }

    /**
     * @covers ::execute
     */
    public function testExecute()
    {
        $urls = [
            'https://www.example.com/1',
            'https://www.example.com/2',
        ];
        $event = new PurgeCommand('Post 123 updated', $urls);

        $this->purger->execute($event);

        $this->cache->verifyInvokedMultipleTimes('purgeFiles', 1);
        $this->cache->verifyInvokedOnce('purgeFiles', [ $urls ]);
    }
}
