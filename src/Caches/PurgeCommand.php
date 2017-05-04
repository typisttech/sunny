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

use InvalidArgumentException;

/**
 * Final class PurgeCommand
 */
final class PurgeCommand
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
    private $urls = [];

    /**
     * Command constructor.
     *
     * @param string   $reason Reason to trigger a purge.
     * @param string[] $urls   Urls to be purged.
     */
    public function __construct(string $reason, array $urls)
    {
        $this->reason = $reason;
        $this->setUrls($urls);
    }

    /**
     * Urls setter.
     *
     * @param string[] $urls Urls to be purged. Maybe multidimensional.
     *
     * @throws InvalidArgumentException If no url is given.
     *
     * @return void
     */
    private function setUrls(array $urls)
    {
        array_map(function ($item) {
            if (is_array($item)) {
                $this->setUrls($item);
            } elseif (is_string($item)) {
                $this->urls[] = $item;
            }
        }, $urls);

        if (count($this->urls) < 1) {
            throw new InvalidArgumentException('You must provide at least one url');
        }
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
