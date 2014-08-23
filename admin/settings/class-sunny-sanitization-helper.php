<?php

/**
 * Sunny Sanitization Helper Class
 *
 * The callback functions of the options page
 *
 * @package    Sunny
 * @subpackage Sunny/admin/settings
 * @author     Tang Rufus <tangrufus@gmail.com>
 */
class Sunny_Sanitization_Helper {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The array of plugin settings.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      array     $registered_settings    The array of plugin settings.
	 */
	private $registered_settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.4.0
	 * @var      string    $name       The name of this plugin.
	 */
	public function __construct( $name, array $registered_settings ) {

		$this->name = $name;
		$this->registered_settings = $registered_settings;
		add_filter( 'sunny_settings_sanitize_text', array( $this, 'sanitize_text_field' ) );
		add_filter( 'sunny_settings_sanitize_email', array( $this, 'sanitize_email_field' ) );

	}

	/**
	 * Settings Sanitization
	 *
	 * Adds a settings error (for the updated message)
	 * At some point this will validate input
	 *
	 * @since 1.4.0
	 *
	 * @param array $input The value inputted in the field
	 *
	 * @return string $input Sanitizied value
	 */
	public function settings_sanitize( $input = array() ) {

		global $sunny_options;

		if ( empty( $_POST['_wp_http_referer'] ) ) {
			return $input;
		}

		parse_str( $_POST['_wp_http_referer'], $referrer );


		$settings = $this->registered_settings;
		$tab      = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';

		$input = $input ? $input : array();
		$input = apply_filters( 'sunny_settings_' . $tab . '_sanitize', $input );

		// Loop through each setting being saved and pass it through a sanitization filter
		foreach ( $input as $key => $value ) {

		// Get the setting type (checkbox, select, etc)
			$type = isset( $settings[$tab][$key]['type'] ) ? $settings[$tab][$key]['type'] : false;

			if ( $type ) {
				// Field type specific filter
				$value = apply_filters( 'sunny_settings_sanitize_' . $type, $value, $key );

			}

			// General filter
			$input[$key] = apply_filters( 'sunny_settings_sanitize', $value, $key );

		}

		// Loop through the whitelist and unset any that are empty for the tab being saved
		if ( ! empty( $settings[$tab] ) ) {
			foreach ( $settings[$tab] as $key => $value ) {

				if ( empty( $input[$key] ) ) {
					unset( $sunny_options[$key] );
				}

			}
		}

		// Merge our new settings with the existing
		$output = array_merge( $sunny_options, $input );

		add_settings_error( 'sunny-notices', '', __( 'Settings updated.', $this->name ), 'updated' );

		return $output;
	}

	/**
	 * Sanitize text fields
	 *
	 * @since 	1.4.0
	 * @param 	array $input The field value
	 * @return 	string $input Sanitizied value
	 */
	public function sanitize_text_field( $input ) {

		return sanitize_text_field( $input );

	}

	/**
	 * Sanitize email fields
	 *
	 * @since 	1.4.0
	 * @param 	array $input The field value
	 * @return 	string $input Sanitizied value
	 */
	public function sanitize_email_field( $input ) {

		return sanitize_email( $input );

	}


}
