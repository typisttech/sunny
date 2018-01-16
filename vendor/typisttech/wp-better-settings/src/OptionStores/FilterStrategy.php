<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   TypistTech\WPBetterSettings
 *
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 *
 * @see       https://www.typist.tech/projects/wp-better-settings
 * @see       https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\OptionStores;

/**
 * Final class FilterStrategy
 */
final class FilterStrategy implements StrategyInterface
{
    /**
     * Get an option value from constant or database.
     *
     * Wrapper around the WordPress function `get_option`.
     * Can be overridden by constant `OPTION_NAME`.
     *
     * @param string $optionName Name of option to retrieve.
     * @param mixed  $value      The value on which the filters hooked to $tag are applied on.
     *
     * @return mixed
     */
    public function get(string $optionName, $value)
    {
        return apply_filters(
            $this->filterTagFor($optionName),
            $value
        );
    }

    /**
     * Normalize option name and key to snake_case filter tag.
     *
     * @param string $optionName Name of option to retrieve.
     *                           Expected to not be SQL-escaped.
     *
     * @return string
     */
    private function filterTagFor(string $optionName): string
    {
        return strtolower($optionName);
    }
}
