<?php
/**
 * @package 	Sunny
 * @subpackage 	Sunny/public
 * @author		Tang Rufus <tangrufus@gmail.com>
 * @link 		http://tangrufus.com
 * @since  		1.3.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * This class blacklist logins with bad usernames.
 */
class Sunny_Ban_Bad_Login {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * Initialize the class and purge after post saved
	 *
	 * @since     1.3.0
	 */
	public function __construct( $name ) {

		$this->name = $name;

	} // end __construct

	/**
	 * Check if site admin enabled this function or not
	 *
	 * @return 	boolean 	True if enabled
	 *
	 * @since 	1.3.0
	 */
	private function is_enabled() {

		$enabled = Sunny_Option::get_option( 'ban_login_with_bad_usernames' );
		return ( isset( $enabled ) && '1' == $enabled );

	} // end is_enabled

	/**
	 * Check if user aptemp to login as Admin and his ip address
	 *
	 * @param 	string 	$username
	 * @return 	boolean 			True if username equals `admin` AND not on localhost
	 *
	 * @since 	1.3.0
	 */
	private function should_ban( $username, $ip ) {

		$_username 		= strtolower( trim( sanitize_text_field( $username ) ) );
		$bad_usernames 	= array( 'admin',
								'administrator' );
		$is_bad_username = in_array( $_username, $bad_usernames );

		return $is_bad_username
				&& Sunny_Helper::is_valid_ipv4( $ip )
				&& ! Sunny_Helper::is_localhost( $ip );

	} // end should_ban

	/**
	 * Ban IP if login with username `Admin`
	 *
	 * @param  string $username Login name
	 */
	public function ban_login_with_bad_username( $username ) {

		$ip = Sunny_Helper::get_remoteaddr();

		if ( $this->is_enabled() && $this->should_ban( $username, $ip ) ) {

			$response = Sunny_Lock::ban_ip( $ip );

		} // end if

	} // end ban_login_with_bad_username

} // end Sunny_Admin_Bar_Hider