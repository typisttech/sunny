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
 * Version:         2.2.0
 * Author:          Typist Tech
 * Author URI:      https://www.typist.tech/
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     sunny
 * Domain Path:     /languages
 */

declare(strict_types=1);

namespace TypistTech\Sunny;

use TypistTech\Sunny\Vendor\WPUpdatePhp;

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

/**
 * Check requirements:
 * - PHP version > 7.0.0
 *
 * Side effect: WPUpdatePhp prints admin notices.
 *
 * @todo Check WordPress core version.
 *
 * @return bool
 */
function sunny_is_requirements_meet()
{
    require_once plugin_dir_path(__FILE__) . '/lib/wpupdatephp/wp-update-php/src/WPUpdatePhp.php';

    $updatePhp = new WPUpdatePhp('7.0.0');
    $updatePhp->set_plugin_name('Sunny');

    return $updatePhp->does_it_meet_required_php_version();
}

/**
 * Begins execution of the plugin.
 *
 * @return void
 */
function run()
{
    require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

    $plugin = new Sunny;
    $plugin->run();
}

/**
 * Deactivate sunny.
 *
 * @return void
 */
function sunny_self_deactivate()
{
    deactivate_plugins(plugin_basename(__FILE__));
}

/*
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
if (sunny_is_requirements_meet()) {
    run();
} else {
    add_action('admin_init', '\TypistTech\Sunny\sunny_self_deactivate');
}
