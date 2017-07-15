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
use TypistTech\Sunny\Targets\Targets;

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
     * PurgeCommand constructor.
     *
     * @param string        $reason  Reason to trigger a purge.
     * @param Targets       $targets Inject targets to every purge.
     * @param string[]|null $urls    Optional. Urls to be purged.
     */
    public function __construct(string $reason, Targets $targets, array $urls = null)
    {
        $this->reason = $reason;
        $this->setUrls($urls ?? [], $targets);
    }

    /**
     * Urls setter.
     *
     * @todo Test Me!!!
     *
     * @param string[] $urls    Urls to be purged. Maybe multidimensional.
     * @param Targets  $targets Inject targets to every purge.
     *
     * @throws InvalidArgumentException If no url is given.
     *
     * @return void
     */
    private function setUrls(array $urls, Targets $targets)
    {
        $this->urls = $this->flattenIntoStringArray([
            $urls,
            $targets->all(),
        ]);

        if (count($this->urls) < 1) {
            throw new InvalidArgumentException('You must provide at least one url');
        }
    }

    /**
     * Flatten an multi-dimensional array into string[].
     *
     * @todo Move into an utility class.
     *
     * @param array $items Multi-dimensional array to be fattened.
     *
     * @return string[]
     */
    private function flattenIntoStringArray(array $items): array
    {
        $result = [];
        $resultArrays = [];

        foreach ($items as $item) {
            if (is_array($item)) {
                $resultArrays[] = $this->flattenIntoStringArray($item);
            } elseif (is_string($item)) {
                $result[] = $item;
            }
        }

        return array_merge($result, ...$resultArrays);
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
