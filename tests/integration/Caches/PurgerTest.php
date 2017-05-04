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
     * @var \AspectMock\Proxy\FuncProxy
     */
    private $applyFiltersMock;

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

        $this->applyFiltersMock = Test::func(__NAMESPACE__, 'apply_filters', function ($_tag, $value, $_param) {
            return $value;
        });

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

    /**
     * @covers ::execute
     */
    public function testExecuteInBatches()
    {
        $urls = [];
        for ($i = 0; $i < 45; $i++) {
            $urls[] = 'https://www.example.com/' . $i;
        }

        $event = new PurgeCommand('Post 123 updated', $urls);

        $this->purger->execute($event);

        $expectedFirstBatch = [];
        for ($i = 0; $i < 30; $i++) {
            $expectedFirstBatch[] = 'https://www.example.com/' . $i;
        }
        $expectedSecondBatch = [];
        for ($i = 30; $i < 45; $i++) {
            $expectedSecondBatch[] = 'https://www.example.com/' . $i;
        }

        $this->cache->verifyInvokedMultipleTimes('purgeFiles', 2);
        $this->cache->verifyInvokedOnce('purgeFiles', [ $expectedFirstBatch ]);
        $this->cache->verifyInvokedOnce('purgeFiles', [ $expectedSecondBatch ]);
    }

    public function testSunnyPurgerUrlsFilter()
    {
        $event = new PurgeCommand('Post 123 updated', [ 'https://www.example.com/1' ]);

        $this->purger->execute($event);

        $expected = [
            'sunny_purger_urls',
            [ 'https://www.example.com/1' ],
            $event,
        ];

        $this->applyFiltersMock->verifyInvokedMultipleTimes(1);
        $this->applyFiltersMock->verifyInvokedOnce($expected);
    }
}
