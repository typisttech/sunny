<?php
/**
 * @package     Sunny
 * @subpackage  Sunny_Admin
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @license     GPL-2.0+
 * @link        http://tangrufus.com
 * @copyright   2014 Tang Rufus
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @since 		1.2.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

abstract class Sunny_Ajax_Handler_Base {

	/**
	 * @since     1.2.0
	 */
	public function __construct( $action ) {

		if ( !empty($action) ) {

			add_action( "wp_ajax_$action", array( $this, 'process_ajax' ) );

		} // end if

	} // end __construc

	/**
	 * @since     1.2.0
	 */
	abstract public function process_ajax();

} // end Sunny_Ajax_Handler_Base