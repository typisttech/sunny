<?php
/**
 * @package    Sunny
 * @subpackage Sunny/includes
 * @author     Tang Rufus <rufus@wphuman.com>
 * @since      1.3.0
 */

Class Sunny_Lock {
	/**
	 * Request CloudFlare to blacklist an IP.
	 *
	 * @return 	object 	$response 	Array of results including HTTP
	 * 								headers or WP_Error if the request failed.
	 * @since 	1.3.0
	 */
	public static function ban_ip( $ip ) {

		$email = Sunny_Option::get_option( 'cloudflare_email' );
		$api_key = Sunny_Option::get_option( 'cloudflare_api_key' );

		$api_helper = new Sunny_CloudFlare_API_Helper( $email, $api_key );

		return $api_helper->ban( $ip );

	} // end ban_ip

} // end Sunny_Lock
