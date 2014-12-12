<?php
/**
 * @package    Sunny
 * @subpackage Sunny/modules
 * @author     Tang Rufus <rufus@wphuman.com>
 * @since      1.4.15
 *
 */

/**
 * This class intergates with Contact Form 7 plugin.
 */
class Sunny_Contact_Form_7 {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.15
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Initialize the class and purge after post saved
	 *
	 * @since     1.4.15
	 *
	 */
	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;

	} // end __construct

	/**
	 * Check if site admin enabled this function or not
	 *
	 * @return  boolean   True if enabled
	 *
	 * @since   1.4.15
	 *
	 */
	private function is_enabled() {

		$enabled = Sunny_Option::get_option( 'contact_form_7' );
		return ( isset( $enabled ) && '1' == $enabled );

	} // end is_enabled

	/**
	 * Check if an extenal ip address
	 *
	 * @param   string  $ip
	 * @return  boolean       True if ip is ban-able
	 *
	 * @since   1.4.15
	 *
	 */
	private function should_ban( $ip ) {

		return Sunny_Helper::is_valid_ip( $ip ) && ! Sunny_Helper::is_localhost( $ip );

	} // end should_ban

	/**
	 * Ban IP if Contact Form 7 marks it as a spam
	 *
	 * @since   1.4.15
	 */
	public function ban_spam( $is_spam ) {

		// Quit early if not spam
		if ( ! $is_spam ) {
			return $is_spam;
		}

		$ip = Sunny_Helper::get_remoteaddr();

		// Quit early if not enabled OR not a ban-able IP
		if ( ! $this->is_enabled() || ! $this->should_ban( $ip ) ) {
			return $is_spam;
		}

		$response = Sunny_Lock::ban_ip( $ip );

		if ( Sunny_Helper::is_api_success( $response ) ) {

			$notice = array(
				'ip' => $ip,
				'date' => current_time( 'timestamp' ),
				'reason' => __( 'Contact Form 7 marks it as a spam', $this->plugin_name )
				);

			do_action( 'sunny_banned_contact_form_7', $notice );

		}

		return $is_spam;

	} // end ban_spam_comment

} // end Sunny_Contact_Form_7
