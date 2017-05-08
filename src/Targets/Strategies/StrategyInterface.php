<?php
/**
 * Sunny
 *
 * Automatically purge CloudFlare cache, including cache everything rules.
 *
 * @package   Sunny
 *
 * @author Typist Tech <sunny@typist.tech>
 * @copyright 2017 Typist Tech
 * @license GPL-2.0+
 *
 * @see https://www.typist.tech/projects/sunny
 * @see https://wordpress.org/plugins/sunny/
 */

declare(strict_types=1);

namespace TypistTech\Sunny\Targets\Strategies;

/**
 * Interface StrategyInterface
 */
interface StrategyInterface
{
    /**
     * Key of the strategy.
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * Get all target urls of this strategy.
     *
     * @return array
     */
    public function all(): array;
}
