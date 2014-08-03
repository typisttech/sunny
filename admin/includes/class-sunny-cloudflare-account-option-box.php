<?php
/**
 * @package     Sunny
 * @subpackage  Sunny_Admin
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @license     GPL-2.0+
 * @link        http://tangrufus.com
 * @copyright   2014 Tang Rufus
 * @author      Tang Rufus <tangrufus@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


if ( ! class_exists( 'Sunny_Option_Box_Base', false ) ) {
	require_once( 'class-sunny-option-box-base.php' );
}

class Sunny_CloudFlare_Account_Option_Box extends Sunny_Option_Box_Base {

	protected function set_class_properties() {

		$this->option_group         = 'sunny_cloudflare_account';

		$this->button_text          = __('Save CloudFlare Account Settings', $this->plugin_slug );

		$this->meta_box             = array(
											'title'     => __( 'CloudFlare Account', $this->plugin_slug ),
											'context'   => 'advanced',
											);

		$this->settings_fields[]    = array(
											'id' 		=> 'cloudflare_email',
											'title'     => __( 'Email', $this->plugin_slug ),
											'callback' 	=> array( $this, 'text' ),
											'args'      => array (
																'id'        => 'email',
																'type'      => 'email',
																'value' 	=> Sunny::get_instance()->get_cloudflare_email(),
																'desc'      => __( 'The email address associated with the CloudFlare account.', $this->plugin_slug ),
																),
															);

		$this->settings_fields[]    = array(
											'id'        => 'cloudflare_api_key',
											'title'     => __( 'API Key', $this->plugin_slug ),
											'callback'  => array( $this, 'text' ),
											'args'      => array (
																'id'        => 'api_key',
																'type'      => 'text',
																'value'     => Sunny::get_instance()->get_cloudflare_api_key(),
																'desc'      => __( 'This is the API key made available on your <a href="https://www.cloudflare.com/my-account.html">CloudFlare Account</a> page.', $this->plugin_slug )
																),
											);

	}

	/**
	 * This function provides a simple description for the Sunny Settings page.
	 * It is passed as a parameter in the add_settings_section function.
	 *
	 * @since 1.0.0
	 */
	public function render_section() {

		echo '<p>';
			_e( 'Additional purge during post updated.', $this->plugin_slug );
		echo '</p>';

	} // end render_section

	/* ------------------------------------------------------------------------ *
	 * Setting Callbacks
	 * ------------------------------------------------------------------------ */
	/**
	 * Sanitization callback for the email option.
	 * Use is_email for Sanitization
	 *
	 * @param   $input  The email user inputed
	 *
	 * @return          The sanitized email.
	 *
	 * @since   1.2.0
	 */
	public function validate_section( $input ) {

		$output = array();

		// Email

		// Get old value from DB
		$plugin = Sunny::get_instance();
		$output['email'] = $plugin->get_cloudflare_email();
		$output['api_key'] = $plugin->get_cloudflare_api_key();

		// Don't trust users
		$clean_input_email = sanitize_email( $input['email'] );

		if ( empty( $clean_input_email ) || ! is_email( $clean_input_email ) || $clean_input_email != $input['email'] ) {

			add_settings_error( $this->option_group, 'invalid-email', __( 'You have entered an invalid email.', $this->plugin_slug ) );

		}

		$output['email'] = $clean_input_email;

		// API Key

		// Don't trust users
		// Strip all HTML and PHP tags and properly handle quoted strings
		$clean_input_api_key = Sunny_Helper::sanitize_alphanumeric( $input['api_key'] );
		$output['api_key'] = $clean_input_api_key;

		if( empty( $clean_input_api_key ) || $clean_input_api_key != $input['api_key'] ) {

			add_settings_error( $this->option_group, 'invalid-api-key', __( 'You have entered an invalid API key.', $this->plugin_slug ) );

		}

		return $output;

	} //end validate_section

} // end Sunny_Option Class
