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

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Factories;

use InvalidArgumentException;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\View;

/**
 * Final class ViewFactory
 *
 * Factory for View objects.
 */
final class ViewFactory
{
    /**
     * Relative path to built-in view partials.
     *
     * @var array
     */
    const PARTIALS = [
        'basic-page' => 'partials/basic-page.php',
        'section' => 'partials/section.php',
        'tabbed-page' => 'partials/tabbed-page.php',
        'fields/checkbox' => 'partials/fields/checkbox.php',
        'fields/input' => 'partials/fields/input.php',
        'fields/textarea' => 'partials/fields/textarea.php',
    ];

    /**
     * Private constructor.
     */
    private function __construct()
    {
    }

    /**
     * Built a View object for one of the built-in field types.
     *
     * @param string $type Type of the partial. Must be one of
     *                     the built-in partial.
     *
     * @throws InvalidArgumentException If the partial is not supported.
     *
     * @return View View object for the partial.
     */
    public static function build(string $type): View
    {
        if (! array_key_exists($type, self::PARTIALS)) {
            $errorMessage = sprintf(
                '%1$s: Partial for "%2$s" not found. Build-in partials include "%3$s".',
                __CLASS__,
                $type,
                implode(', ', array_keys(self::PARTIALS))
            );
            throw new InvalidArgumentException($errorMessage);
        }

        return new View(
            plugin_dir_path(__DIR__) . self::PARTIALS[ $type ]
        );
    }
}
