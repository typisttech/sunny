<?php
/**
 * @package    Sunny
 * @subpackage Sunny/modules
 * @author     Tang Rufus <rufus@wphuman.com>
 * @since      1.2.0
 */

/**
 * This class hides the admin bar from the public.
 */
class Sunny_Admin_Bar_Hider {

	/**
	 * Hide the admin bar.
	 *
	 * @return bool 	true if should show admin bar
	 *
	 * @since  1.4.0
	 */
	public function hide( $should_show ) {

		return ( $should_show && ! Sunny_Option::get_option( 'hide_admin_bar' ) );

	} // end hide

} // end Sunny_Admin_Bar_Hider
