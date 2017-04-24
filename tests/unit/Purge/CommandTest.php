<?php

declare(strict_types=1);

namespace TypistTech\Sunny\Purge;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \TypistTech\Sunny\Purge\Command
 */
class CommandTest extends Unit
{
    /**
     * @covers ::getReason
     */
    public function testGetReason()
    {
        $event = new Command('Post 123 updated', 'https://www.example.com/1');
        $actual = $event->getReason();
        $this->assertSame('Post 123 updated', $actual);
    }

    /**
     * @covers ::getUrls
     */
    public function testGetSingleUrl()
    {
        $event = new Command('Post 123 updated', 'https://www.example.com/1');
        $actual = $event->getUrls();
        $this->assertSame([ 'https://www.example.com/1' ], $actual);
    }

    /**
     * @covers ::getUrls
     */
    public function testGetUrls()
    {
        $urls = [
            'https://www.example.com/1',
            'https://www.example.com/2',
        ];

        $event = new Command('Post 123 updated', ...$urls);
        $actual = $event->getUrls();
        $this->assertSame($urls, $actual);
    }
}
