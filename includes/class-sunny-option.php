<?php

/**
 *
 * @package    Sunny
 * @subpackage Sunny/includes
 * @author     Tang Rufus <tangrufus@gmail.com>
 */

class Sunny_Option {

	/**
	 * Get Settings
	 *
	 * Retrieves all plugin settings
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
	 * Looks to see if the specified setting exists, returns default if not
	 *
	 * @since 	1.4.0
	 * @return 	mixed
	 */
	static public function get_option( $key = '', $default = false ) {

		global $sunny_options;

		if ( empty( $sunny_options ) ) {

			self::set_global_options();

		}

		$value = ! empty( $sunny_options[ $key ] ) ? $sunny_options[ $key ] : $default;
		$value = apply_filters( 'sunny_get_option', $value, $key, $default );
		return apply_filters( 'sunny_get_option_' . $key, $value, $key, $default );

	}

}