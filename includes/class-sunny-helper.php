<?php

/**
 * Helper methods.
 * All methods are static.
 *
 * @link       http://tangrufus.com
 * @since      1.4.0
 *
 * @package    Sunny
 * @subpackage Sunny/includes
 * @author     Tang Rufus <tangrufus@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Helper class.
 */
class Sunny_Helper {

	 /**
	  * to check if a url live in site's domain
	  *
	  * @since     1.1.0
	  *
	  * @param    string  $url      The test url
	  * @return   boolean           True if a url is in site's domain
	  */
	 public static function url_match_site_domain( $url ) {

		return ( self::get_domain( $url ) == self::get_domain( get_option( 'home' ) ) );

	 } // end url_match_site_domain

	 /**
	 * Get all related links, including tags, categories and all custom taxonomies
	 *
	 * @param   string 		$post_url   The targeted post url
	 *
	 * @return  array 		$urls		The list of all related links
	 *
	 * @see 	http://codex.wordpress.org/Function_Reference/get_the_terms
	 *
	 * @since 	1.1.0
	 */
	 public static function get_all_terms_links_by_url( $post_url ){

		$urls = array();

			// get post id
		$post_id = url_to_postid( $post_url );

			// get post type by post
		$post_type = get_post_type( $post_id );

			// get all taxonomies for the post type
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );

		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

				// get the terms related to post
			$terms = get_the_terms( $post_id, $taxonomy_slug );

			if ( !empty( $terms ) && ! is_wp_error( $terms ) ) {

				foreach ( $terms as $term) {

					$term_link = get_term_link( $term );

					if ( ! is_wp_error( $term_link ) ) {

						array_push( $urls, $term_link );

					} //end if

				} // end foreach

			} // end if

		} // end foreach

		return $urls;

	} // end get_all_terms_links_by_url

	/**
	 * @see   https://gist.github.com/pocesar/5366899
	 *
	 * @param   string  $domain   Pass $_SERVER['SERVER_NAME'] here
	 * @param   bool  $debug
	 *
	 * @return  string
	 *
	 * @since  	1.2.3
	 */
	public static function get_domain( $domain ) {

		$original = $domain = parse_url( strtolower( esc_url_raw( $domain ) ), PHP_URL_HOST );

		if ( filter_var( $domain, FILTER_VALIDATE_IP ) ) {

			return $domain;

		}

		$arr = array_slice(array_filter(explode('.', $domain, 4), function($value){
			return $value !== 'www';
				}), 0); //rebuild array indexes

		if ( 2 < count( $arr ) ) {

			$count = count( $arr );
			$_sub = explode('.', $count === 4 ? $arr[3] : $arr[2]);

			if ( 2 === count( $_sub ) ) { // two level TLD

				$removed = array_shift( $arr );
				if ( 4 === $count ) { // got a subdomain acting as a domain

					$removed = array_shift( $arr );
				}

			} elseif ( 1 === count( $_sub ) ) { // one level TLD

				$removed = array_shift( $arr ); //remove the subdomain

				if ( 2 === strlen( $_sub[0] ) && 3 === $count ) { // TLD domain must be 2 letters

					array_unshift( $arr, $removed );

				} else {

					// non country TLD according to IANA
					$tlds = array(
						'aero',
						'arpa',
						'asia',
						'biz',
						'cat',
						'com',
						'coop',
						'edu',
						'gov',
						'info',
						'jobs',
						'mil',
						'mobi',
						'museum',
						'name',
						'net',
						'org',
						'post',
						'pro',
						'tel',
						'travel',
						'xxx',
						);


					if ( 2 < count($arr)  && in_array( $_sub[0], $tlds ) !== false ) { //special TLD don't have a country

					array_shift( $arr );

				}
			}

			} else { // more than 3 levels, something is wrong

				for ( $i = count( $_sub ); $i > 1; $i--) {

					$removed = array_shift($arr);

				}
			}

		} elseif ( 2 === count( $arr ) ) {

			$arr0 = array_shift( $arr );

			if ( false === strpos( join( '.', $arr ), '.')
					&& false === in_array( $arr[0], array( 'localhost', 'test', 'invalid' ) ) ) { // not a reserved domain

				// seems invalid domain, restore it
				array_unshift( $arr, $arr0 );

		}
	}

	return join('.', $arr);

	} // end get_domain( $domain )

	/**
	 *
	 * @since 	1.4.6
	 *
	 * @return  boolean
	 */
	private static function should_write_report() {

		return defined( 'WP_DEBUG' ) && WP_DEBUG != false && 'false' !== WP_DEBUG && '0' !== WP_DEBUG;

	} // end should_write_report

	/**
	 * Log debug messages in php error log after email sent
	 *
	 * @since 	1.4.0
	 *
	 * @param 	$reason
	 * @param 	$to_address
	 *
	 * @return  void 		No return
	 */
	public static function write_email_report( $reason, $to_address ) {

		if ( ! self::should_write_report() ) {
			return;
		}

		error_log( "Sunny: sent $reason to $to_address" );

	}

	/**
	 * Log debug messages in php error log after CloudFlare API calls
	 *
	 * @since 	1.0.0
	 *
	 * @param 	$response 	The response after api call, could be WP Error object or HTTP return object
	 * @param 	$data 		The JSON response from CloudFlare
	 *
	 * @return  void 		No return
	 */
	public static function write_api_report( $response, $data ) {

		if ( ! self::should_write_report() ) {
			return;
		}

		$action = $data['a'];

		$target = '';
		$target .= ( isset( $data['z'] ) && ! isset( $data['url'] ) ) ? $data['z'] : '';
		$target .= isset( $data['url'] ) ? $data['url']  : '';
		$target .= isset( $data['key'] ) ? $data['key'] : '';

		if ( is_wp_error( $response ) ) {

			error_log( "Sunny: $action $target -- WP Error " . $response->get_error_message() );

		}// end WP Error
		else {
			// API made
			$response_array = json_decode( $response['body'], true );

			if ( 'error' == $response_array['result'] ) {

				error_log( "Sunny: $action $target -- API Error " . $response_array['msg'] );

			} else {

				error_log( "Sunny: $action $target -- Success" );

			}

		}

	} // end write_api_report

	/**
	 * Retrieve the real ip address of the user in the current request.
	 *
	 * @return string The real ip address of the user in the current request.
	 *
	 * @since  1.3.0
	 *
	 * @see  sucuri-scanner.php sucuriscan_get_remoteaddr()
	 */
	public static function get_remoteaddr() {

		$alternatives = array(
			'HTTP_X_REAL_IP',
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR',
			'SUCURI_RIP',
			);
		foreach($alternatives as $alternative){

			if( !isset( $_SERVER[$alternative] ) )
				continue;

			$remote_addr = preg_replace('/[^0-9a-z.,: ]/', '', $_SERVER[$alternative]);

			if($remote_addr)
				break;

		} //end foreach

		if( $remote_addr == '::1' )
			$remote_addr = '127.0.0.1';

		return $remote_addr;

	} // get_remoteaddr

	/**
	 * Check whether the IP address specified is a valid IPv4 format.
	 *
	 * @param  string  $remote_addr The host IP address.
	 * @return boolean              true if the address specified is a valid IPv4 format, false otherwise.
	 *
	 * @since  1.3.0
	 * @see  sucuri-scanner.php sucuriscan_is_valid_ipv4
	 */
	public static function is_valid_ipv4( $remote_addr = '' ){

		if( preg_match('/^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$/', $remote_addr, $match) ){

			for( $i=0; $i<4; $i++ ){

				if( $match[$i] > 255 ) {

					return false;

				}

			}

			return true;
		}

		return false;

	} // end is_valid_ipv4

	/**
	 * Check whether the IP address is a localhost ip.
	 *
	 * @param  string  $remote_addr The host IP address.
	 * @return boolean              true if the address specified is a localhost IP, false otherwise.
	 *
	 * @since  1.3.0
	 */
	public static function is_localhost( $remote_addr = '' ){

		$localhost = array(
			'127.0.0.0',
			'127.0.0.1',
			'127.0.0.2',
			'127.0.0.3',
			'127.0.0.4',
			'127.0.0.5',
			'127.0.0.6',
			'127.0.0.7',
			'127.0.0.8',
			'127.0.0.9',
			'127.0.1.0',
			'::1'
			);

		return in_array( $remote_addr, $localhost );

	} // end is_localhost

	/**
	 * Check if a API request success
	 *
	 * @param  Mixed  	$response 	The CloudFlare API response
	 * @return boolean           	True if success
	 *
	 * @since  1.4.0
	 */
	public static function is_api_success( $response ) {

		// WP Error
		if ( is_wp_error( $response ) ) {

			return false;

		}

		// API Sent to CloudFlare
		// Check if CloudFlare returns 'success'
		$response_array = json_decode( $response['body'], true );

		return 'success' == $response_array['result'];

	}

}// end Sunny_Helper class