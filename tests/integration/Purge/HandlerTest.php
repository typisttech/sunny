<?php

declare(strict_types=1);

namespace TypistTech\Sunny\Purge;

use AspectMock\Test;
use Codeception\TestCase\WPTestCase;
use TypistTech\Sunny\Cloudflare\Cache;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;

/**
 * @coversDefaultClass \TypistTech\Sunny\Purge\handler
 */
class HandlerTest extends WPTestCase
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
     * @var Handler
     */
    private $handler;

    public function setUp()
    {
        parent::setUp();

        $container = $this->tester->getContainer();
        $this->cache = Test::double(
            $container->get(Cache::class),
            [
                'purge' => [ true ],
            ]
        );
        $container->add(Cache::class, $this->cache->getObject());
        $this->handler = $container->get(Handler::class);
    }

    /**
     * @coversNothing
     */
    public function testGetFromContainer()
    {
        $this->assertInstanceOf(
            Handler::class,
            $this->tester->getContainer()->get(Handler::class)
        );
    }

    /**
     * @covers ::handle
     */
    public function testHandlePurgeEvent()
    {
        $urls = [
            'https://www.example.com/1',
            'https://www.example.com/2',
        ];
        $event = new Command('Post 123 updated', ...$urls);

        $this->handler->handle($event);

        $this->cache->verifyInvokedMultipleTimes('purge', 1);
        $this->cache->verifyInvokedOnce('purge', [ $urls ]);
    }

    /**
     * @covers ::getHooks
     */
    public function testHookedIntoSunnyPurge()
    {
        $this->tester->assertHooked(
            new Action('sunny_do_purge', Handler::class, 'handle')
        );
    }
}
