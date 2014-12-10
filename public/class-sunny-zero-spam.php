<?php
/**
 * @package 	Sunny
 * @subpackage 	Sunny/public
 * @author		Tang Rufus <tangrufus@gmail.com>
 * @link 		http://tangrufus.com
 * @since  		1.4.11
 *
 */

/**
 * This class intergates with WordPress Zero Spam plugin.
 */
class Sunny_Zero_Spam {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.11
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Initialize the class and purge after post saved
	 *
	 * @since     1.4.11
	 *
	 */
	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;

	} // end __construct

	/**
	 * Check if site admin enabled this function or not
	 *
	 * @return 	boolean 	True if enabled
	 *
	 * @since 	1.4.11
	 *
	 */
	private function is_enabled() {

		$enabled = Sunny_Option::get_option( 'zero_spam' );
		return ( isset( $enabled ) && '1' == $enabled );

	} // end is_enabled

	/**
	 * Check if an extenal ip address
	 *
	 * @param 	string 	$ip
	 * @return 	boolean 			True if ip is ban-able
	 *
	 * @since 	1.4.11
	 *
	 */
	private function should_ban( $ip ) {

		return Sunny_Helper::is_valid_ip( $ip ) && ! Sunny_Helper::is_localhost( $ip );

	} // end should_ban

	/**
	 * Ban IP if Zero Spam marks it as a spam comment
	 *
	 * @since 	1.4.13
	 */
	public function ban_spam() {

		$ip = Sunny_Helper::get_remoteaddr();

		// Quit early if not enabled OR not a ban-able IP
		if ( ! $this->is_enabled() || ! $this->should_ban( $ip ) ) {
			return;
		}

		$response = Sunny_Lock::ban_ip( $ip );

		if ( Sunny_Helper::is_api_success( $response ) ) {

			$notice = array(
				'ip' => $ip,
				'date' => current_time( 'timestamp' ),
				'reason' => __( 'Zero Spam marks it as a spam', $this->plugin_name )
				);

			do_action( 'sunny_banned_zero_spam', $notice );

		}

	} // end ban_spam_comment

} // end Sunny_Zero_Spam
