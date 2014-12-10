<?php
/**
 * @package 	Sunny
 * @subpackage 	Sunny/public
 * @author		Tang Rufus <tangrufus@gmail.com>
 * @link 		http://tangrufus.com
 * @since  		1.4.12
 *
 */

/**
 * This class intergates with iThemes Security plugin.
 */
class Sunny_iThemes_Security {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.12
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Initialize the class and purge after post saved
	 *
	 * @since     1.4.12
	 *
	 */
	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;

	} // end __construct

	/**
	 * Check if site admin enabled this function and iThemes_Security is activated
	 *
	 * @return 	boolean 	True if enabled and activated
	 *
	 * @since 	1.4.12
	 *
	 */
	private function is_enabled() {

		$enabled = Sunny_Option::get_option( 'ithemes_security' );

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$is_activated = is_plugin_active( 'better-wp-security/better-wp-security.php' );

		return ( true === $is_activated && !empty( $enabled ) && '1' == $enabled );

	} // end is_enabled

	/**
	 * Check if an extenal ip address
	 *
	 * @param 	string 	$ip
	 * @return 	boolean 			True if ip is ban-able
	 *
	 * @since 	1.4.12
	 *
	 */
	private function should_ban( $ip ) {

		return Sunny_Helper::is_valid_ip( $ip ) && ! Sunny_Helper::is_localhost( $ip );

	} // end should_ban

	/**
	 * Ban IPs if iThemes Security locks them.
	 * This is a wp cron job callback.
	 *
	 * @since 	1.4.12
	 */
	public function maybe_new_lockout() {

		// Early quit if not enabled or class ITSEC_Lockout doesn't exist
		if ( ! $this->is_enabled() && ! class_exists( 'ITSEC_Lockout' ) ) {
			return;
		}

		// Get current host lockouts
		$itsec_lockout = new ITSEC_Lockout();
		$lockouts = $itsec_lockout->get_lockouts( 'host', false );

		// Early quit if no lockouts
		if ( empty( $lockouts ) ) {
			return;
		}

		foreach ( $lockouts as $lockout ) {
			$this->ban_lockout( $lockout );
		}

	} // end maybe_new_lockout

	/**
	 * [ban_lockout description]
	 *
	 * @since  1.4.12
	 *
	 * @param  [type]	$lockout
	 * @return void
	 */
	private function ban_lockout( $lockout ) {

		$ip = $lockout['lockout_host'];
		$reason = $lockout['lockout_type'];
		$start_gmt = $lockout['lockout_start_gmt'] . 'GMT';

		// Quit early if $ip is not ban-able
		if ( ! $this->should_ban( $ip ) ) {
			return;
		}

		// Quit early if $lockout older than 10 mins(600 seconds)
		if ( strtotime( 'now GMT' ) - strtotime( $start_gmt ) > 600 ) {
			return;
		}

		$response = Sunny_Lock::ban_ip( $ip );

		if ( Sunny_Helper::is_api_success( $response ) ) {

			$notice = array(
				'ip' => $ip,
				'date' => current_time( 'timestamp' ),
				'reason' => sprintf( __( 'iThemes Security lockout because of %s', $this->plugin_name ), $reason )
				);

			do_action( 'sunny_banned_ithemes_security', $notice, $reason );

		} // end if api success

	} // end ban_lockout

} // end Sunny_iThemes_Security
