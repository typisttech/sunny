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
use TypistTech\Sunny\Notifications\Notifier;

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
     * Notifier
     *
     * @var Notifier
     */
    private $notifier;

    /**
     * Handler constructor.
     *
     * @param Cache    $cache    Api adopter for caches.
     * @param Notifier $notifier Notifier.
     */
    public function __construct(Cache $cache, Notifier $notifier)
    {
        $this->cache = $cache;
        $this->notifier = $notifier;
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
        $randomNoticeId = 'sunny_purger_execute_' . wp_hash(date('c') . random_int(10, 15));

        // Translators: %1$s is the reason to purge.
        $noticeMessageFormat = __('<b>Sunny</b>: Purge initiated.<br/>Reason: %1$s', 'sunny');
        $noticeMessage = sprintf(
            $noticeMessageFormat,
            $command->getReason()
        );

        $this->notifier->enqueue($randomNoticeId, $noticeMessage);

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
