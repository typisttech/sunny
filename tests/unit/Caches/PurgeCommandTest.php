<?php

declare(strict_types=1);

namespace TypistTech\Sunny\Caches;

use AspectMock\Test;
use Codeception\Test\Unit;
use InvalidArgumentException;
use TypistTech\Sunny\Targets\Targets;
use TypistTech\Sunny\UnitTester;

/**
 * @coversDefaultClass \TypistTech\Sunny\Caches\PurgeCommand
 */
class PurgeCommandTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Targets
     */
    private $targets;

    /**
     * @covers ::getReason
     */
    public function testGetReason()
    {
        $event = new PurgeCommand('Post 123 updated', $this->targets, [ 'https://www.example.com/1' ]);

        $actual = $event->getReason();

        $this->assertSame('Post 123 updated', $actual);
    }

    /**
     * @covers ::getUrls
     */
    public function testGetSingleUrl()
    {
        $event = new PurgeCommand('Post 123 updated', $this->targets, [ 'https://www.example.com/1' ]);

        $actual = $event->getUrls();

        $this->assertSame([ 'https://www.example.com/1' ], $actual);
    }

    /**
     * @covers ::getUrls
     */
    public function testGetUrls()
    {
        $urls = [
            'cat' => [
                'https://www.example.com/1',
                'https://www.example.com/2',
            ],
            'https://www.example.com/3',
        ];
        $event = new PurgeCommand('Post 123 updated', $this->targets, $urls);

        $actual = $event->getUrls();

        $expected = [
            'https://www.example.com/3',
            'https://www.example.com/1',
            'https://www.example.com/2',
        ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::setUrls
     */
    public function testNoUrlGiven()
    {
        $this->tester->expectException(new InvalidArgumentException('You must provide at least one url'), function () {
            new PurgeCommand('Post 123 updated', $this->targets, []);
        });
    }

    protected function _before()
    {
        $this->targets = Test::double(
            Test::double(Targets::class)->make(),
            [
                'all' => [],
            ]
        )->getObject();
    }
}
