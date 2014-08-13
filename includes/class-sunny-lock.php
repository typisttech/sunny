<?php
/**
 * @package 	Sunny
 * @subpackage 	Sunny_Purger
 * @author 		Tang Rufus <tangrufus@gmail.com>
 * @license  	GPL-2.0+
 * @link  		http://tangrufus.com
 * @copyright 	2014 Tang Rufus
 * @since  		1.3.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

Class Sunny_Lock {
	/**
	 * Purge CloudFlare of any cached files by making `fpurge_ts` calls
	 *
	 * @return 	object 	$response 	Array of results including HTTP
	 * 								headers or WP_Error if the request failed.
	 * @since 	1.3.0
	 */
	public static function ban_ip( $ip ) {

		$plugin = Sunny::get_instance();
		$domain = $plugin->get_domain();

		$cf_api_helper = CloudFlare_API_Helper::get_instance();

		$response = $cf_api_helper->ban( $ip );

		do_action( 'after_sunny_lock_ban_ip', $response, 'ban_ip', $ip );

		return $response;

	} // end ban_ip

} // end Sunny_Lock