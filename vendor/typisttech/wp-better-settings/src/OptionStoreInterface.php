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

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings;

/**
 * Interface OptionStoreInterface.
 *
 * This is a adapter for the WordPress get_option() function that can be configured to supply consistent interface for
 * particular options.
 */
interface OptionStoreInterface
{
    /**
     * Get an option value.
     *
     * @param string $optionName Name of option to retrieve. Expected to not be SQL-escaped.
     *
     * @return mixed
     */
    public function get(string $optionName);

    /**
     * Cast option value into boolean.
     *
     * @param string $optionName Name of option to retrieve. Expected to not be SQL-escaped.
     *
     * @return bool
     */
    public function getBoolean(string $optionName): bool;

    /**
     * Cast option value into integer.
     *
     * @param string $optionName Name of option to retrieve. Expected to not be SQL-escaped.
     *
     * @return int
     */
    public function getInt(string $optionName): int;

    /**
     * Cast option value into string.
     *
     * @param string $optionName Name of option to retrieve. Expected to not be SQL-escaped.
     *
     * @return string
     */
    public function getString(string $optionName): string;
}
