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

/**
 * Plugin Name:     Sunny
 * Plugin URI:      https://www.typist.tech/
 * Description:     Automatically purge CloudFlare cache, including cache everything rules.
 * Version:         2.4.0
 * Author:          Typist Tech
 * Author URI:      https://www.typist.tech/
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     sunny
 * Domain Path:     /languages
 */

declare(strict_types=1);

namespace TypistTech\Sunny;

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

/**
 * Begins execution of the plugin.
 *
 * @return void
 */
function run()
{
    $plugin = new Sunny();
    $plugin->run();
}

run();
