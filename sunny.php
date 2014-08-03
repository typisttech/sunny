<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   Sunny
 * @author    Tang Rufus <tangrufus@gmail.com>
 * @license   GPL-2.0+
 * @link      http://tangrufus.com
 * @copyright 2014 Tang Rufus
 *
 * @wordpress-plugin
 * Plugin Name:       Sunny (Purge CloudFlare Cache)
 * Plugin URI:        http://tangrufus.com/
 * Description:       Automatic CloudFlare Purge
 * Version:           1.1.1
 * Author:            Tang Rufus
 * Author URI:        http://tangrufus.com
 * Text Domain:       sunny
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * WordPress-Plugin-Boilerplate: v2.6.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-plugin-name.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-sunny.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @TODO:
 *
 * - replace Plugin_Name with the name of the class defined in
 *   `class-plugin-name.php`
 */
register_activation_hook( __FILE__, array( 'Sunny', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Sunny', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace Plugin_Name with the name of the class defined in
 *   `class-plugin-name.php`
 */
add_action( 'plugins_loaded', array( 'Sunny', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-plugin-name-admin.php` with the name of the plugin's admin file
 * - replace Plugin_Name_Admin with the name of the class defined in
 *   `class-plugin-name-admin.php`
 *
 * If you don't want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
 *
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */

if ( is_admin() ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-sunny-admin.php' );
	add_action( 'plugins_loaded', array( 'Sunny_Admin', 'get_instance' ) );

}

/*----------------------------------------------------------------------------*
 * Helper Functionality
 *----------------------------------------------------------------------------*/

// Load helper class in sunny/includes
add_action( 'plugins_loaded', 'load_dependencies', 5 );
function load_dependencies() {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-sunny-helper.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-cloudflare-api-helper.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-sunny-purger.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-sunny-api-logger.php' );
}