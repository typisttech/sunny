<?php
/**
 * Sunny
 *
 * Automatically purge CloudFlare cache, including cache everything rules.
 *
 * @package   Sunny
 *
 * @author    Typist Tech <sunny@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 *
 * @see       https://www.typist.tech/projects/sunny
 * @see       https://wordpress.org/plugins/sunny/
 */

declare(strict_types=1);

namespace TypistTech\Sunny\Caches;

use TypistTech\Sunny\Api\Cache;

/**
 * Final class Purger
 */
final class Purger
{
    /**
     * Api adopter for caches
     *
     * @var Cache
     */
    private $cache;

    /**
     * Handler constructor.
     *
     * @param Cache $cache Api adopter for caches.
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Purge urls from Cloudflare cache, 30 urls per batch.
     *
     * @param PurgeCommand $command Purge command.
     *
     * @return void
     */
    public function execute(PurgeCommand $command)
    {
        $batches = array_chunk(
            $command->getUrls(),
            30
        );

        foreach ($batches as $batch) {
            $this->cache->purgeFiles(
                ...$batch
            );
        }
    }
}
