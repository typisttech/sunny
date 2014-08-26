<?php

/**
 *
 * @package    Sunny
 * @subpackage Sunny/admin/mailer
 * @author     Tang Rufus <tangrufus@gmail.com>
 * @since  	   1.4.0
 */
class Sunny_Mailer {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      string    	$name    The ID of this plugin.
	 */
	private $name;

	/**
	 * Initialize the class and set its propertie.
	 *
	 * @since 	1.4.0
	 * @param 	string 		$name    The ID of this plugin.
	 */
	public function __construct( $to_name ) {

		$this->name = $to_name;

	}

	/**
	 * Send blacklist notification
	 * 
	 * @since  1.4.0
	 * 
	 * @param  array  $notices Blacklisted IP details
	 * @return void
	 */
	public function email_blacklist_notification( array $notices ) {

		// Set To Email Address
		$to_address = Sunny_Option::get_option( 'cloudflare_email' );

		// Set To Name
		$user = get_user_by( 'email', $to_address );
		if ( !empty( $user ) ) {
			$to_name = $user->display_name;
		} else {
			$to_name = $to_address;
		}

		// Set Body Content
		$template = new Sunny_Email_Template( $this->name );
		$message = $template->get_email_body_header();
		$message .= $template->get_blacklist_email_body_content( $notices, $to_name );
		$message .= $template->get_email_body_footer();

		// Set Email Headers
		// From Name
		$option_email_from_name = Sunny_Option::get_option( 'email_from_name' );
		$from_name = ( !empty( $option_email_from_name ) ) ? $option_email_from_name : get_bloginfo('name');
		$from_name = apply_filters( 'sunny_blacklist_email_from_name', $from_name, $to_address, $to_name, $notices );

		// From Email Address
		$option_email_from_address = Sunny_Option::get_option( 'email_from_address' );
		$from_address = ( !empty( $option_email_from_address ) ) ? $option_email_from_address : get_option('admin_email');
		$from_address = apply_filters( 'sunny_blacklist_email_from_address', $from_address, $from_name, $to_address, $to_name, $notices );

		// Subject
		$option_blacklist_email_subject = Sunny_Option::get_option( 'blacklist_email_subject' );
		$subject = ( ! empty( $option_blacklist_email_subject ) ) ? wp_strip_all_tags( $option_blacklist_email_subject, true ) : __( 'Blacklist Notification', $this->name );
		$subject = apply_filters( 'sunny_blacklist_email_subject', $subject, $from_address, $from_name, $to_address, $to_name, $notices );

		// Combine Email Headers
		$headers = 'From: ' . stripslashes_deep( html_entity_decode( $from_name, ENT_COMPAT, 'UTF-8' ) ) . " <" . $from_address . ">\r\n";
		$headers .= 'Reply-To: ' . $from_address . "\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";

		$headers = apply_filters( 'sunny_blacklist_email_headers', $headers, $subject, $from_address, $from_name, $to_address, $to_name, $notices );

		// Send Email
		if ( apply_filters( 'sunny_email_blacklist_notification', true ) ) {

			wp_mail( $to_address, $subject, $message, $headers );

		}
	}
}
