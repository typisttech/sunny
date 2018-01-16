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
 * Final class ConstantStrategy
 */
final class ConstantStrategy implements StrategyInterface
{
    /**
     * Get option from constant.
     *
     * @param string $optionName Name of option to retrieve.
     * @param mixed  $value      The value from previous strategy.
     *
     * @return mixed|null Null if option not exists or its value is actually null.
     */
    public function get(string $optionName, $value)
    {
        if (null !== $value) {
            return $value;
        }

        $constantName = $this->constantNameFor($optionName);

        if (! defined($constantName)) {
            return null;
        }

        return constant($constantName);
    }

    /**
     * Normalize option name and key to SCREAMING_SNAKE_CASE constant name.
     *
     * @param string $optionName Name of option to retrieve.
     *
     * @return string
     */
    private function constantNameFor(string $optionName): string
    {
        return strtoupper($optionName);
    }
}
