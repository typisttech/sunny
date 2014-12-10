<?php

/**
 *
 * @package 		Sunny
 * @subpackage 		Sunny/admin/mailer
 * @author 			Tang Rufus <rufus@wphuman.com>
 * @since 			1.4.0
 */
class Sunny_Email_Template {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Initialize the class and set its propertie.
	 *
	 * @since    1.4.0
	 * @var      string    $plugin_name       The name of this plugin.
	 */
	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;

		// Set Default Template
		add_filter( 'sunny_blacklist_email_body_content', array( $this, 'email_default_formatting' ) );
		add_filter( 'sunny_blacklist_email_body_content', array( $this, 'apply_email_template' ), 20, 3 );
		add_action( 'sunny_email_template_default', array( $this, 'default_email_template' ) );
		add_filter( 'sunny_email_default', array( $this, 'default_email_styling' ) );

	}

	/**
	 * Email Template Header
	 *
	 * @access public
	 * @since  1.4.0
	 * @return string Email template header
	 */
	public function get_email_body_header() {

		ob_start();
		?>

		<html>
			<head>
				<style type="text/css">#outlook a { padding: 0; }</style>
			</head>
			<body dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">

		<?php
		do_action( 'sunny_email_body_header' );
		return ob_get_clean();

	}

	/**
	 * Email Template Body
	 *
	 * @since 	1.4.0
	 * @param 	array 	$notices 	Notice details
	 * @return 	string 	$to_name 	Name of Recipient
	 */
	public function get_blacklist_email_body_content( array $notices, $to_name ) {

		$recipient_name = is_email( $to_name ) ? 'Site Admin' : $to_name;
		$default_email_body = __( 'Howdy ', $this->plugin_name ) . $recipient_name . ",\n\n";

		// Check if more than one notice
		$is_plural = ( count( $notices ) > 1 );

		$default_email_body .= $is_plural ? __( 'These IPs have been blacklisted in CloudFlare.', $this->plugin_name ) : __( 'This IP has been blacklisted in CloudFlare.', $this->plugin_name );
		$default_email_body .= "\n\n";

		$default_email_body .= $is_plural ? '<ul>' : null;

		foreach ( $notices as $notice ) {

			$default_email_body .= '<ul>';

				$default_email_body .= '<li>' . __( 'IP Address', $this->plugin_name ) . ': ' . $notice['ip'] . '</li>';

				$default_email_body .= '<li>' . __( 'Due To', $this->plugin_name ) . ': ' . $notice['reason'] . '</li>';

				$date_format = get_option( 'date_format' );
				$time_format = get_option( 'time_format' );
				$date_time = date( "{$date_format} {$time_format}", $notice['date'] );
				$default_email_body .= '<li>' . __( 'Date/Time', $this->plugin_name ) . ': ' . $date_time . '</li>';

			$default_email_body .= '</ul>';

		}
		$default_email_body .= $is_plural ? '</ul>' : null;
		$default_email_body .= "\n\n";

		$default_email_body .= $is_plural ? __( 'These IPs would be locked out from your site <strong>forever</strong>. To unlist this IP please vist your <a href="https://www.cloudflare.com/threat-control/">CloudFlare Dashboard</a>.', $this->plugin_name ) : __( 'This IP would be locked out from your site <strong>forever</strong>. To unlist this IP please vist your <a href="https://www.cloudflare.com/threat-control/">CloudFlare Dashboard</a>.', $this->plugin_name );
		$default_email_body .= "\n\n";


		$plugin_settings_url = admin_url( 'admin.php?page=sunny&tab=emails' );
		$default_email_body .= sprintf( __( '*This email was generated automatically by <a href="http://wordpress.org/plugins/sunny/">Sunny(Connecting CloudFlare &amp; WordPress)</a>. To change your email preferences please visit the <a href="%s">plugin settings</a>.', $this->plugin_name ), $plugin_settings_url );
		$default_email_body .= "\n\n";

		return apply_filters( 'sunny_blacklist_email_body_content', $default_email_body, $notices, $to_name );

	}


	/**
	 * Email Template Footer
	 *
	 * @access public
	 * @since  1.4.0
	 * @return string Email template footer
	 */
	public function get_email_body_footer() {

		ob_start();
		do_action( 'sunny_email_body_footer' );
		?>

			</body>
		</html>

		<?php
		return ob_get_clean();

	}

	/**
	 * Applies the Chosen Email Template
	 *
	 * @since  1.4.0
	 * @param  string $email_body 		  Email template without styling
	 * @param  array  $notices            Blacklist details
	 * @param  string $to_name            Name of Recipient
	 * @return string $email              Email template with styling
	 */
	public function apply_email_template( $email_body, array $notices, $to_name ) {

		$template_name = Sunny_Option::get_option( 'email_template' );

		$template_name = !empty( $template_name ) ? $template_name : 'default';
		$template_name = apply_filters( 'sunny_email_template', $template_name, $notices );

		ob_start();

		// Add <div> stuffs, Does not involve $email_body
		do_action( 'sunny_email_template_' . $template_name );

		$template = ob_get_clean();

		// Styling <p>, <ul>, <ol>, <li> stuffs in $email_body
		$email_body = apply_filters( 'sunny_email_' . $template_name, $email_body );

		$email = str_replace( '{email}', $email_body, $template );

		return $email;

	}

	/**
	 * Default Email Template
	 *
	 * @access public
	 * @since  1.4.0
	 */
	public function default_email_template() {

		$text_align = is_rtl() ? 'right' : 'left';
		echo '<div style="margin: 0; background-color: #fafafa; width: auto; padding: 30px;"><center>';
			echo '<div style="border: 1px solid #ddd; width: 660px; background: #f0f0f0; padding: 8px; margin: 0;">';
				echo '<div id="edd-email-content" style="background: #fff; border: 1px solid #ddd; padding: 15px; text-align: ' . $text_align . ' !important;">';
					echo '{email}'; // This tag is required in order for the contents of the email to be shown
				echo '</div>';
			echo '</div>';
		echo '</center></div>';

	}

	/**
	 * Default Email Template Styling Extras
	 *
	 * @access public
	 * @since  1.4.0
	 * @param  string 	$email_body 	Email template without styling
	 * @return string 	$email_body 	Email template with styling
	 */
	public function default_email_styling( $email_body ) {

		$first_p  = strpos( $email_body, '<p style="font-size: 14px;">' );
		if( $first_p ) {
			$email_body = substr_replace( $email_body, '<p style="font-size: 14px; margin-top:0;">', $first_p, 3 );
		}
		$email_body = str_replace( '<p>', '<p style="font-size: 14px; line-height: 150%">', $email_body );
		$email_body = str_replace( '<ul>', '<ul style="margin: 0 0 10px 0; padding: 0;">', $email_body );
		$email_body = str_replace( '<li>', '<li style="font-size: 14px; line-height: 150%; display:block; margin: 0 0 4px 0;">', $email_body );

		return $email_body;

	}

	/**
	 * Email Default Formatting
	 *
	 * @since  1.4.0
	 * @param  string 	$message 	Message without <p> tags
	 * @return string 	$message 	Formatted message with <p> tags added
	 */
	public function email_default_formatting( $message ) {

		return wpautop( stripslashes( $message ) );

	}

}
