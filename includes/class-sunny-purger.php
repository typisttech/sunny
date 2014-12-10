<?php

/**
 * This class makes CLoudFlare purge API calls.
 *
 * @package    Sunny
 * @subpackage Sunny/includes
 * @author     Tang Rufus <rufus@wphuman.com>
 * @since      1.0.0
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

		$email = Sunny_Option::get_option( 'cloudflare_email' );
		$api_key = Sunny_Option::get_option( 'cloudflare_api_key' );
		$cf_api_helper = new Sunny_CloudFlare_API_Helper( $email, $api_key );

		$domain = Sunny_Helper::get_domain( get_option( 'home' ) );

		return $cf_api_helper->fpurge_ts( $domain );
	}

	/**
	 * Purge single file in CloudFlare's cache by making `zone_file_purge` calls
	 *
	 * @since    1.0.0
	 *
	 * @param    array    $url    Url to be purged
	 */
	public static function purge_cloudflare_cache_by_url( $url ) {

		$email = Sunny_Option::get_option( 'cloudflare_email' );
		$api_key = Sunny_Option::get_option( 'cloudflare_api_key' );
		$cf_api_helper = new Sunny_CloudFlare_API_Helper( $email, $api_key );

		$domain = Sunny_Helper::get_domain( get_option( 'home' ) );

		$response = $cf_api_helper->zone_file_purge( $domain, $url );

		return $response;
	}

} // end Sunny_Purger
