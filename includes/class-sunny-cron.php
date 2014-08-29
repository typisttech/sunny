<?php
/**
 * This class defining cron job hooks.
 *
 * @package    Sunny
 * @subpackage Sunny/includes
 * @author     Tang Rufus <tangrufus@gmail.com>
 * @since      1.4.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Sunny_Cron {

	/**
	 * Schedule WP cron job (create hooks) for notification sending.
	 *
	 * @param 	string 	$frequency 	The frequency of notification sending
	 *
	 * @since  	1.4.0
	 */
	public static function set_schedule() {

		$frequency = Sunny_Option::get_option( 'notification_frequency' );
		$frequency = ( 'immediately' == $frequency ) ? null : $frequency;

		$due = wp_next_scheduled( 'sunny_cron_send_notification' );

		if ( !empty( $frequency  ) && empty( $due ) ) {

			wp_schedule_event( time() + 30, $frequency, 'sunny_cron_send_notification' );

		} elseif ( empty( $frequency ) && !empty( $due ) ) {

			wp_clear_scheduled_hook( 'sunny_cron_send_notification' );

		}

	} // end of set_schedule


	/**
	 * Update WP cron job schedule for notification sending.
	 *
	 * @param 	string 	$frequency 	The frequency of notification sending
	 *
	 * @since  	1.4.0
	 */
	public static function update_schedule( $frequency ) {

		$frequency = ( 'immediately' == $frequency ) ? null : $frequency;

		$due = wp_next_scheduled( 'sunny_cron_send_notification' );

		if ( !empty( $frequency  ) && empty( $due ) ) {

			wp_schedule_event( time() + 30, $frequency, 'sunny_cron_send_notification' );

		} elseif ( !empty( $frequency  ) && !empty( $due ) ) {

			wp_clear_scheduled_hook( 'sunny_cron_send_notification' );
			wp_schedule_event( time() + 30, $frequency, 'sunny_cron_send_notification' );

		} elseif ( empty( $frequency ) ) {

			wp_clear_scheduled_hook( 'sunny_cron_send_notification' );

		}

	}

}