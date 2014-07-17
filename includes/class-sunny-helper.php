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
}// end Sunny_Helper class