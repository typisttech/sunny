<?php
/**
 * @package 	Sunny
 * @subpackage 	Sunny/public
 * @author		Tang Rufus <tangrufus@gmail.com>
 * @link 		http://tangrufus.com
 * @since  		1.3.0
 */

/**
 * This class blacklist logins with bad usernames.
 */
class Sunny_Ban_Bad_Login {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Initialize the class and purge after post saved
	 *
	 * @since     1.3.0
	 */
	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;

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
	 * Check if username is bad
	 *
	 * @return 	boolean 	True if bad
	 *
	 * @since 	1.4.4
	 */
	private function is_bad_username( $_username ) {

		$bad_usernames = array(
			'admin',
			'administrator' );

		$customized_bad_usernames = Sunny_Option::get_option( 'bad_usernames' );

		if ( !empty( $customized_bad_usernames ) ) {
			$customized_bad_usernames = explode( ',', $customized_bad_usernames );

			foreach( $customized_bad_usernames as $username ) {
				$bad_usernames[] = strtolower( trim( sanitize_user( $username, true ) ) );
			} //end foreach

		} //end if

		return in_array( $_username, $bad_usernames );

	} // end is_bad_username

	/**
	 * Check if user aptemp to login as Admin and his ip address
	 *
	 * @param 	string 	$username
	 * @return 	boolean 			True if username equals `admin` AND not on localhost
	 *
	 * @since 	1.3.0
	 */
	private function should_ban( $username, $ip ) {

		$username = strtolower( trim( sanitize_user( $username, true ) ) );

		return $this->is_bad_username( $username )
		&& Sunny_Helper::is_valid_ip( $ip )
		&& ! Sunny_Helper::is_localhost( $ip );

	} // end should_ban

	/**
	 * Ban IP if login with username `Admin`
	 *
	 * @param  string $username Login name
	 */
	public function ban_login_with_bad_username( $username ) {

		$ip = Sunny_Helper::get_remoteaddr();

		// Quit early if not enabled OR should not ban
		if ( ! $this->is_enabled() || ! $this->should_ban( $username, $ip ) ) {
			return;
		}

		$response = Sunny_Lock::ban_ip( $ip );

		if ( Sunny_Helper::is_api_success( $response ) ) {

			$notice = array(
				'ip' => $ip,
				'date' => current_time( 'timestamp' ),
				'reason' => sprintf( __( 'Tried to login as `%s`', $this->plugin_name ), $username )
				);

			do_action( 'sunny_banned_login_with_bad_username', $notice );

		}

	} // end ban_login_with_bad_username

} // end Sunny_Ban_Bad_Login
