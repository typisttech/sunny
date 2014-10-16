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
	 * @since  	1.4.0
	 */
	public static function set_notification_schedule() {

		// The frequency of notification sending
		$frequency = Sunny_Option::get_option( 'notification_frequency' );
		$frequency = ( 'immediately' == $frequency ) ? null : $frequency;

		$due = wp_next_scheduled( 'sunny_cron_send_notification' );

		if ( !empty( $frequency  ) && empty( $due ) ) {

			wp_schedule_event( time() + 30, $frequency, 'sunny_cron_send_notification' );

		} elseif ( empty( $frequency ) && !empty( $due ) ) {

			wp_clear_scheduled_hook( 'sunny_cron_send_notification' );

		}

	} // end of set_notification_schedule


	/**
	 * Update WP cron job schedule for notification sending.
	 *
	 * @param 	string 	$frequency 	The frequency of notification sending
	 *
	 * @since  	1.4.0
	 */
	public static function update_notification_schedule( $frequency ) {

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

	} // end update_notification_schedule

	/**
	 * Schedule WP cron job (create hooks) for checking iThemes Security lockouts.
	 *
	 * @since  	1.4.12
	 */
	public static function set_ithemes_security_schedule() {

		$is_enabled = (bool) ( '1' == Sunny_Option::get_option( 'ithemes_security' ) );
		$due = wp_next_scheduled( 'sunny_cron_check_ithemes_security_lockouts' );

		if ( $is_enabled && empty( $due ) ) {

			wp_schedule_event( time() + 30, 'every_ten_min', 'sunny_cron_check_ithemes_security_lockouts' );

		} elseif ( ! $is_enabled && !empty( $due ) ) {

			wp_clear_scheduled_hook( 'sunny_cron_check_ithemes_security_lockouts' );

		}

	} // end of set_ithemes_security_schedule

	/**
	 * Define WP corn interval
	 * @param [type] $schedules [description]
	 *
	 * @since  1.4.12
	 */
	public static function add_intervals( $schedules ) {

		// Adds once weekly to the existing schedules.
		$schedules['every_ten_min'] = array(
			'interval' => 600,
			'display' => __( 'Every 10 mins', 'sunny' )
		);

		return $schedules;

	} // end add_every_ten_min

}