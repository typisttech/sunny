<?php
/**
 * @package 	Sunny
 * @subpackage 	Sunny_Admin
 * @author		Tang Rufus <tangrufus@gmail.com>
 * @license   	GPL-2.0+
 * @link 		http://tangrufus.com
 * @copyright 	2014 Tang Rufus
 * @author 		Tang Rufus <tangrufus@gmail.com>
 * @since  		1.2.0
 */

/**
 * This class takes care the purge process fired from the admin dashboard.
 */
class Sunny_Admin_Bar_Hider {
	/**
	 * Instance of this class.
	 *
	 * @since    1.2.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the class and purge after post saved
	 *
	 * @since     1.2.0
	 */
	private function __construct() {

		if ( $this->should_hide() ) {

			add_filter('show_admin_bar', '__return_false');

		} //end if

	} // end __construct

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.2.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	} // end get_instance


	private function should_hide() {

		$option = get_option( 'sunny_admin_bar' );
		return ( isset( $option['show'] ) && '1' == $option['show'] );

	} // end should_hide

} // end Sunny_Admin_Bar_Hider