<?php
/**
 *
 * @package   Sunny
 * @author    Tang Rufus <tangrufus@gmail.com>
 * @license   GPL-2.0+
 * @link      http://tangrufus.com
 * @copyright 2014 Tang Rufus
 */

/**
 * Helper class. Dealing user inputs in WordPress admin dashboard.
 *
 * @package Sunny_Helper
 * @author  Tang Rufus <tangrufus@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
     die;
}

class Sunny_Helper {
	/**
     * Return an instance of this class.
     * Originally get_instance()
     *
     * @since     1.0.0
	 *
     * @param 	  $input  	The unsanitized option.
     *
     * @return    string    A single instance of this class.
     */
     public static function sanitize_alphanumeric( $input ) {
     	return preg_replace('/[^a-zA-Z0-9]/', '' , strip_tags( stripslashes( $input ) ) );
     }
}// end Sunny_Helper class