<?php

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.4.0
 * @package    Sunny
 * @subpackage Sunny/includes
 * @author     Tang Rufus <tangrufus@gmail.com>
 */
class Sunny_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.4.0
	 */
	public static function deactivate() {

		wp_clear_scheduled_hook( 'sunny_cron_send_notification' );

		if ( false != get_option( 'sunny_enqueued_notices' ) || '' == get_option( 'sunny_enqueued_notices' ) ) {
			delete_option( 'sunny_enqueued_notices' );
		}

	}

}
