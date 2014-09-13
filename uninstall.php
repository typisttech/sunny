<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @package   	Sunny
 * @author    	Tang Rufus <tangrufus@gmail.com>
 * @license   	GPL-2.0+
 * @link      	http://tangrufus.com
 * @copyright 	2014 Tang Rufus
 * @since 		1.0.0
 */



// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	exit;
}

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Important: Check if the file is the one
// that was registered during the uninstall hook.
if ( 'sunny/sunny.php' !== WP_UNINSTALL_PLUGIN )  {
	exit;
}

// Check if the $_REQUEST content actually is the plugin name
if ( ! in_array( 'sunny/sunny.php', $_REQUEST['checked'] ) ) {
	exit;
}

if ( 'delete-selected' !== $_REQUEST['action'] ) {
	exit;
}

// Check user roles.
if ( ! current_user_can( 'activate_plugins' ) ) {
	exit;
}

// Run an admin referrer check to make sure it goes through authentication
check_admin_referer( 'bulk-plugins' );

// Safe to carry on
//  Options on v1.4.6
if ( false != get_option( 'sunny_enqueue_notifications' ) || '' == get_option( 'sunny_enqueue_notifications' ) ) {
	delete_option( 'sunny_enqueue_notifications' );
}

// Options on v1.4.0
if ( false != get_option( 'sunny_settings' ) || '' == get_option( 'sunny_settings' ) ) {
	delete_option( 'sunny_settings' );
}

if ( false != get_option( 'sunny_enqueued_notices' ) || '' == get_option( 'sunny_enqueued_notices' ) ) {
	delete_option( 'sunny_enqueued_notices' );
}

if ( false != get_option( 'sunny_version' ) || '' == get_option( 'sunny_version' ) ) {
	delete_option( 'sunny_version' );
}

if ( false != get_option( 'sunny_enqueued_admin_notices' ) || '' == get_option( 'sunny_enqueued_admin_notices' ) ) {
	delete_option( 'sunny_enqueued_admin_notices' );
}

// Options on or before v1.3.0
if ( false != get_option( 'sunny_cloudflare_email' ) || '' == get_option( 'sunny_cloudflare_email' ) ) {
	delete_option( 'sunny_cloudflare_email' );
}

if ( false != get_option( 'sunny_cloudflare_api_key' ) || '' == get_option( 'sunny_cloudflare_api_key' ) ) {
	delete_option( 'sunny_cloudflare_api_key' );
}

if ( false != get_option( 'sunny_cloudflare_account' ) || '' == get_option( 'sunny_cloudflare_account' ) ) {
	delete_option( 'sunny_cloudflare_account' );
}

if ( false != get_option( 'sunny_purger_settings' ) || '' == get_option( 'sunny_purger_settings' ) ) {
	delete_option( 'sunny_purger_settings' );
}

if ( false != get_option( 'sunny_admin_bar' ) || '' == get_option( 'sunny_admin_bar' ) ) {
	delete_option( 'sunny_admin_bar' );
}

if ( false != get_option( 'sunny_security' ) || '' == get_option( 'sunny_security' ) ) {
	delete_option( 'sunny_security' );
}
