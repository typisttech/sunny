<?php
/**
 * @package 	Sunny
 * @subpackage 	Sunny_Admin
 * @author		Tang Rufus <tangrufus@gmail.com>
 * @license   	GPL-3.0+
 * @link 		http://tangrufus.com
 * @copyright 	2014 Tang Rufus
 * @author 		Tang Rufus <tangrufus@gmail.com>
 * @since  		1.3.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * This class takes care the purge process fired from the admin dashboard.
 */
class Sunny_Ban_Login_As_Admin {
	/**
	 * Instance of this class.
	 *
	 * @since    1.3.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the class and purge after post saved
	 *
	 * @since     1.3.0
	 */
	private function __construct() {

		if ( $this->is_enabled() ) {

			add_action( 'wp_authenticate', array( $this, 'ban_login_as_admin' ), -10 );

		}


	} // end __construct

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.3.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	} // end get_instance


	/**
	 * Check if site admin enabled this function or not
	 * 
	 * @return 	boolean 	True if enabled
	 * 
	 * @since 	1.3.0
	 */
	private function is_enabled() {

		$option = get_option( 'sunny_security' );
		return ( isset( $option['ban_login_as_admin'] ) && '1' == $option['ban_login_as_admin'] );

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

		return ( 'admin' == strtolower( trim( sanitize_text_field( $username ) ) ) ) 
				&& Sunny_Helper::is_valid_ipv4( $ip ) 
				&& ! Sunny_Helper::is_localhost( $ip );
		 

	} // end should_ban

	/**
	 * Ban IP if login with username `Admin`
	 * 
	 * @param  string $username Login name
	 */
	public function ban_login_as_admin( $username ) {

		$ip = Sunny_Helper::get_remoteaddr();

		if ( $this->should_ban( $username, $ip ) ) {

			$response = Sunny_Lock::ban_ip( $ip );

			$this->send_notice_email( $response, $ip );

		} // end if

	} // end ban_login_as_admin


	private function send_notice_email( $response, $ip ) {
		
		if ( is_wp_error( $response ) )
			return;
			
		// API made
		$response_array = json_decode( $response['body'], true );

		if ( 'error' == $response_array['result'] )
			return;

		// IP Banned successfully
		
		$msg = "Dear Site Admin, \r\n";
		$msg .= "\r\n";
		$msg .= "An IP has been blacklisted on CloudFlare. \r\n";
		$msg .= "IP: {$ip} \r\n";
		$msg .= "Reason: Attempt to login with the username `Admin`. \r\n";
		$msg .= "\r\n";
		$msg .= "You can release this lockdown at the CloudFlare dashboard.";
		$msg .= "\r\n";
		$msg .= "\r\n";
		$msg .= "This email is generated automarically by the plugin Sunny(Conneting CloudFlare and WordPress). \n";

		$this->send_mail( Sunny::get_instance()->get_cloudflare_email(), 'Blacklisted IP - Login as `Admin`', $msg );
		

	} // end send_notice_email


	private function send_mail( $email='', $subject='', $message='' ) {
    $headers = array();
    $subject = ucwords( strtolower( $subject ) );
    $wp_domain = isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : get_option('siteurl');
    $debug = FALSE;


    $headers = array( 'Content-type: plain/text' );

        if( $debug ){ 

        	die($message); 

        }

        $email_sent = wp_mail(
            $email,
            "Sunny Notification: {$wp_domain} - {$subject}",
            $message,
            $headers
        );

    return $email_sent;
} // end send_email


} // end Sunny_Admin_Bar_Hider