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

namespace TypistTech\Sunny;

/**
 * Interface LoadableInterface
 */
interface LoadableInterface
{
    /**
     * Hooks (Action or Filter) getter.
     *
     * @return \TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\AbstractHook[]
     */
    public static function getHooks(): array;
}
