<?php
/**
 * @package 	Sunny
 * @author 		Tang Rufus <tangrufus@gmail.com>
 * @license  	GPL-2.0+
 * @link  		http://tangrufus.com
 * @copyright 	2014 Tang Rufus
 * @subpackage 	Sunny_Purger
 */

Class Sunny_Purger {
	/**
	 * Purge CloudFlare of any cached files by making `fpurge_ts` calls
	 *
	 * @return object 	$response 	Array of results including HTTP
	 * 								headers or WP_Error if the request failed.
	 * @since    1.0.0
	 */
	public static function purge_cloudflare_cache_all() {
		$plugin = Sunny::get_instance();
        $domain = $plugin->get_domain();
		$cf_api_helper = CloudFlare_API_Helper::get_instance();
		$response = $cf_api_helper->fpurge_ts( $domain );

		Sunny_API_Logger::write_report( $response, 'fpurge_ts' );
		return $response;
	}

	/**
	 * Purge single file in CloudFlare's cache by making `zone_file_purge` calls
	 *
	 * @since    1.0.0
	 *
	 * @param    array    $url    Url to be purged
	 */
	public static function purge_cloudflare_cache_by_url( $url ) {
		$plugin = Sunny::get_instance();
        $domain = $plugin->get_domain();

		$cf_api_helper = CloudFlare_API_Helper::get_instance();
		$response = $cf_api_helper->zone_file_purge( $domain, $url );
		Sunny_API_Logger::write_report( $response, $url );
	}
} // end Sunny_Purger