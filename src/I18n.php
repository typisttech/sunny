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

use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 */
final class I18n implements LoadableInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [
            new Action('plugins_loaded', __CLASS__, 'loadPluginTextdomain'),
        ];
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @return void
     */
    public function loadPluginTextdomain()
    {
        load_plugin_textdomain(
            'sunny',
            false,
            dirname(plugin_basename(__FILE__), 2) . '/languages/'
        );
    }
}
