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

namespace TypistTech\Sunny\Purge;

/**
 * Final class Event
 *
 * Immutable data transfer object that holds necessary information about this action.
 */
final class Event
{
    /**
     * Reason to trigger a purge
     *
     * @var string
     */
    private $reason;

    /**
     * Urls to be purged
     *
     * @var string[]
     */
    private $urls;

    /**
     * Event constructor.
     *
     * @param string          $reason  Reason to trigger a purge.
     * @param string|string[] ...$urls Urls to be purged.
     */
    public function __construct(string $reason, string ...$urls)
    {
        $this->reason = $reason;
        $this->urls = $urls;
    }

    /**
     * Reason getter.
     *
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * Urls getter.
     *
     * @return string[]
     */
    public function getUrls(): array
    {
        return $this->urls;
    }
}
