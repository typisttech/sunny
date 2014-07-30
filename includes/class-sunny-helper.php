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
          $temp_url = explode( '.', parse_url( esc_url_raw( $url ), PHP_URL_HOST ) );

          if ( '' == $temp_url ) {
          	return false;
          }

          $url_host_names = $temp_url[count( $temp_url )-2] . '.' . $temp_url[count( $temp_url )-1];
          $plugin = Sunny::get_instance();
          return ( $url_host_names == $plugin->get_domain() );
     }
}// end Sunny_Helper class