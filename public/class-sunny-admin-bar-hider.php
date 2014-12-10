<?php
/**
 * @package    Sunny
 * @subpackage Sunny/public
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
	 * @return void
	 *
	 * @since  1.4.0
	 */
	public function hide() {

		$enabled = Sunny_Option::get_option( 'hide_admin_bar' );
		return ! ( isset( $enabled ) && '1' == $enabled );

	} // end hide

} // end Sunny_Admin_Bar_Hider
