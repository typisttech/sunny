<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * this starts the plugin.
 *
 * @link              http://tangrufus.com
 * @since             1.0.0
 * @package           Sunny
 *
 * @wordpress-plugin
 * Plugin Name:       Sunny (Connecting CloudFlare and WordPress)
 * Plugin URI:        http://tangrufus.com/refer/sunny
 * Description:       Automatically clear CloudFlare cache. And, protect your WordPress site at DNS level.
 * Version:           1.4.12
 * Author:            Tang Rufus
 * Author URI:        http://tangrufus.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sunny
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-sunny-activator.php';

/**
 * The code that runs during plugin deactivation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-sunny-deactivator.php';

/** This action is documented in includes/class-sunny-activator.php */
register_activation_hook( __FILE__, array( 'Sunny_Activator', 'activate' ) );

/** This action is documented in includes/class-sunny-deactivator.php */
register_deactivation_hook( __FILE__, array( 'Sunny_Deactivator', 'deactivate' ) );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-sunny.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.4.0
 */
function run_plugin_name() {

	$plugin = new Sunny();
	$plugin->run();

}
run_plugin_name();
