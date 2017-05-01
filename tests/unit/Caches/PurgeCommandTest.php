<?php

declare(strict_types=1);

namespace TypistTech\Sunny\Caches;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \TypistTech\Sunny\Caches\PurgeCommand
 */
class PurgeCommandTest extends Unit
{
    /**
     * @covers ::getReason
     */
    public function testGetReason()
    {
        $event = new PurgeCommand('Post 123 updated', [ 'https://www.example.com/1' ]);

        $actual = $event->getReason();

        $this->assertSame('Post 123 updated', $actual);
    }

    /**
     * @covers ::getUrls
     */
    public function testGetSingleUrl()
    {
        $event = new PurgeCommand('Post 123 updated', [ 'https://www.example.com/1' ]);

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
        $event = new PurgeCommand('Post 123 updated', $urls);

        $actual = $event->getUrls();

        $expected = [
            'https://www.example.com/1',
            'https://www.example.com/2',
            'https://www.example.com/3',
        ];

        $this->assertSame($expected, $actual);
    }
}
