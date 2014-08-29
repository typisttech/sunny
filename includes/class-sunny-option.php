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
	 * Get enqueued notices
	 *
	 * Looks to see if notices exists, returns default if not.
	 *
	 * @since 	1.4.0
	 * @return 	array
	 */
	static public function get_enqueued_notices( $default = array() ) {

		$notices = get_option( 'sunny_enqueued_notices', $default );

		return apply_filters( 'sunny_get_enqueued_notices', $notices, $default );

	}

	/**
	 * Enqueue a notice
	 *
	 * @since 	1.4.0
	 *
	 * @param   array 	$notices 	Notice to be enqueued
	 * @return 	array
	 */
	static public function enqueue_notice( array $notice ) {

		// Early quit if no notices
		if ( empty( $notice ) ) {
			return;
		}

		$old_notices = self::get_enqueued_notices();
		$new_notices = array_push( $old_notices, $notice );
		$new_notices = apply_filters( 'sunny_enqueue_notice', $old_notices, $notice);

		delete_option( 'sunny_enqueued_notices' );
		add_option( 'sunny_enqueued_notices', $new_notices );

	}

	/**
	 * Delete enqueued notices
	 *
	 * @since  1.4.0
	 * @param  array  	$notices 		Notices to be dequeued
	 * @return void
	 */
	static public function dequeue_notices( array $notices ) {

		// Early quit if no notices
		if ( empty( $notices ) ) {
			return;
		}

		$old_notices = self::get_enqueued_notices();

		if ( !empty( $old_notices ) ) {

			$new_notices = array_diff( $old_notices, $notices );
			$new_notices = apply_filters( 'sunny_dequeue_notices', $new_notices, $notices );

			delete_option( 'sunny_enqueued_notices' );

			if ( !empty( $new_notices ) ) {
				add_option( 'sunny_enqueued_notices', $new_notices );
			}

		}

	}

	/**
	 * Delete all enqueued notices
	 *
	 * @since 	1.4.0
	 * @return 	void
	 */
	static public function dequeue_all_notice() {

		if ( false != get_option( 'sunny_enqueued_notices' ) || '' == get_option( 'sunny_enqueued_notices' ) ) {

			delete_option( 'sunny_enqueued_notices' );

		}

	}

}