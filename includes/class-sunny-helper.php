<?php
/**
 * @package    Sunny
 * @subpackage Sunny_Helper
 * @author     Tang Rufus <tangrufus@gmail.com>
 * @license    GPL-2.0+
 * @link       http://tangrufus.com
 * @copyright  2014 Tang Rufus
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Helper class. Dealing user inputs in WordPress admin dashboard.
 */
class Sunny_Helper {
	/**
	  * sanitize input to an alphanumeric-only string
	  *
	  * @since     1.0.0
	  *
	  * @param 	  string  $input  	The unsanitized string.
	  *
	  * @return   string            The sanitized alphanumeric-only string.
	  */
	public static function sanitize_alphanumeric( $input ) {

		return preg_replace('/[^a-zA-Z0-9]/', '' , strip_tags( stripslashes( $input ) ) );

	}

	 /**
	  * to check if a url live in site's domain
	  *
	  * @since     1.1.0
	  *
	  * @param    string  $url      The test url
	  *
	  * @return   boolean           True if a url is in site's domain
	  */
	 public static function url_match_site_domain( $url ) {


	 	return ( self::get_domain( $url ) == Sunny::get_instance()->get_domain() );

	 } // end url_match_site_domain( $url )

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

}// end Sunny_Helper class