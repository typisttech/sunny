<?php

/**
 *
 * @package 	Sunny
 * @subpackage 	Sunny/includes
 * @author 		Tang Rufus <tangrufus@gmail.com>
 * @since 		1.4.0
 */

class Sunny_Option {

	/**
	 * Get Settings
	 *
	 * Retrieves all plugin settings.
	 *
	 * @since 	1.4.0
	 * @return 	array Sunny settings
	 */
	static public function set_global_options() {

		global $sunny_options;

		$sunny_options = get_option( 'sunny_settings' );
		if ( empty( $sunny_options ) ) {
			$sunny_options = array();
		}
		$sunny_options = apply_filters( 'sunny_get_settings', $sunny_options );

	}

	/**
	 * Get an option
	 *
	 * Looks to see if the specified setting exists, returns default if not.
	 *
	 * @since 	1.4.0
	 * @return 	mixed
	 */
	static public function get_option( $key = '', $default = false ) {

		global $sunny_options;

		if ( empty( $sunny_options ) ) {

			self::set_global_options();
		}

		$value = !empty( $sunny_options[ $key ] ) ? $sunny_options[ $key ] : $default;
		$value = apply_filters( 'sunny_get_option', $value, $key, $default );
		return apply_filters( 'sunny_get_option_' . $key, $value, $key, $default );

	}

	/**
	 * Get enqueued admin notices
	 *
	 * Looks to see if notices exists, returns default if not.
	 *
	 * @since 	1.4.0
	 * @return 	array
	 */
	static public function get_enqueued_admin_notices( $default = array() ) {

		$notices = get_option( 'sunny_enqueued_admin_notices' );

		if ( empty( $notices ) ) {
			$notices = $default;
		}

		return apply_filters( 'sunny_get_enqueued_admin_notices', $notices, $default );

	}

	/**
	 * Enqueue an admin notice
	 *
	 * @since 	1.4.0
	 *
	 * @param   array 	$notices 	Notice to be enqueued
	 * @return 	array
	 */
	static public function enqueue_admin_notice( array $notice ) {

		// Early quit if no notices
		if ( empty( $notice ) ) {
			return;
		}

		$old_notices = self::get_enqueued_admin_notices();
		$new_notices = array_push( $old_notices, $notice );
		$new_notices = apply_filters( 'sunny_enqueue_admin_notice', $old_notices, $notice);

		delete_option( 'sunny_enqueued_admin_notices' );
		add_option( 'sunny_enqueued_admin_notices', $new_notices );

	}

	/**
	 * Delete enqueued admin notices
	 *
	 * @since  1.4.0
	 * @param  array  	$notices 		Notices to be dequeued
	 * @return void
	 */
	static public function dequeue_admin_notices( array $notices ) {

		// Early quit if no new admin notices
		if ( empty( $notices ) ) {
			return;
		}

		$old_notices = self::get_enqueued_admin_notices();

		// Early quit if no old admin notices
		if ( empty( $old_notices ) ) {
			return;
		}

		// @TODO Fix: multidimentional array_diff throws `Array to string conversion` notice
		$new_notices = array_diff( $old_notices, $notices );

		$new_notices = apply_filters( 'sunny_dequeue_admin_notices', $new_notices, $notices, $old_notices );

		delete_option( 'sunny_enqueued_admin_notices' );

		if ( !empty( $new_notices ) ) {
			add_option( 'sunny_enqueued_admin_notices', $new_notices );
		}

	}

	/**
	 * Delete all enqueued admin notices
	 *
	 * @since 	1.4.0
	 * @return 	void
	 */
	static public function dequeue_all_admin_notices() {

		if ( false !== get_option( 'sunny_enqueued_admin_notices' ) ) {

			delete_option( 'sunny_enqueued_admin_notices' );

		}

	}

	/**
	 * Enqueue notifications
	 *
	 * @since 	1.4.6
	 *
	 * @param   array 	$notifications 	notifications to be enqueued
	 * @return 	void
	 */
	static public function enqueue_notification( array $notification ) {

		// Early quit if no notifications
		if ( empty( $notification ) ) {
			return;
		}

		$old_notifications = self::get_enqueued_notifications();
		array_push( $old_notifications, $notification );
		$new_notifications = apply_filters( 'sunny_enqueue_notification', $old_notifications, $notification);

		delete_option( 'sunny_enqueue_notifications' );
		add_option( 'sunny_enqueue_notifications', $new_notifications );

	}

	/**
	 * Get enqueued notifications
	 *
	 * Looks to see if notifications exists, returns default if not.
	 *
	 * @since 	1.4.6
	 * @return 	array
	 */
	static public function get_enqueued_notifications( $default = array() ) {

		$notifications = get_option( 'sunny_enqueue_notifications', $default );

		return apply_filters( 'sunny_get_enqueued_notifications', $notifications, $default );

	}

	/**
	 * Delete enqueued notifications
	 *
	 * @since  1.4.6
	 * @param  array  	$notifications 		notifications to be dequeued
	 * @return void
	 */
	static public function dequeue_notifications( array $notifications ) {

		// Early quit if no notifications
		if ( empty( $notifications ) ) {
			return;
		}

		$old_notifications = self::get_enqueued_notifications();

		if ( !empty( $old_notifications ) ) {

			$new_notifications = array_diff( $old_notifications, $notifications );
			$new_notifications = apply_filters( 'sunny_dequeue_notifications', $new_notifications, $notifications, $old_notifications );

			delete_option( 'sunny_enqueue_notifications' );

			if ( !empty( $new_notifications ) ) {
				add_option( 'sunny_enqueue_notifications', $new_notifications );
			}

		}

	}

}