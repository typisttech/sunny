<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @package    Sunny
 * @subpackage Sunny/includes
 * @author     Tang Rufus <rufus@wphuman.com>
 * @since      1.4.0
 */
class Sunny_Activator {

	/**
	 *
	 * @since    1.4.0
	 */
	public static function activate( $network_wide ) {

		// Sunny should never be network wide
		if ( $network_wide ) {

			deactivate_plugins( plugin_basename( __FILE__ ), true, true );
			wp_die( "Sunny doesn't work network wide.<br />See the <a href='https://wordpress.org/plugins/sunny/faq/'>FAQ</a> for more information.", 'Activation Error', array( 'back_link' => true ) );

		} // end of activate
	}
}
