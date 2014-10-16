<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Sunny
 * @subpackage Sunny/admin/settings
 * @author     Tang Rufus <tangrufus@gmail.com>
 */
class Sunny_Settings {

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
	 * The callback helper to render HTML elements for settings forms.
	 *
	 * @since    1.4.0
	 * @access   protected
	 * @var      Sunny_Callback_Helper    $callback    Render HTML elements.
	 */
	protected $callback;

	/**
	 * The sanitization helper to sanitize and validate settings.
	 *
	 * @since    1.4.0
	 * @access   protected
	 * @var      Sunny_Sanitization_Helper    $sanitization    Sanitize and validate settings.
	 */
	protected $sanitization;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name ) {

		$this->name = $name;
		$this->registered_settings = $this->set_registered_settings();

		if ( ! class_exists( 'Sunny_Callback_Helper' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'settings/class-sunny-callback-helper.php';
		}
		$this->callback = new Sunny_Callback_Helper( $this->name );

		if ( ! class_exists( 'Sunny_Sanitization_Helper' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'settings/class-sunny-sanitization-helper.php';
		}
		$this->sanitization = new Sunny_Sanitization_Helper( $this->name, $this->registered_settings );

	}

	/**
	 * Register all settings sections and fields.
	 *
	 * @since 	1.4.0
	 * @return 	void
	*/
	public function register_settings() {

		if ( false == get_option( 'sunny_settings' ) ) {
			add_option( 'sunny_settings' );
		}

		foreach( $this->registered_settings as $tab => $settings ) {

			// add_settings_section( $id, $title, $callback, $page )
			add_settings_section(
				'sunny_settings_' . $tab,
				__return_null(),
				'__return_false',
				'sunny_settings_' . $tab
				);

			foreach ( $settings as $option ) {

				$_name = isset( $option['name'] ) ? $option['name'] : '';

				// add_settings_field( $id, $title, $callback, $page, $section, $args )
				add_settings_field(
					'sunny_settings[' . $option['id'] . ']',
					$_name,
					method_exists( $this->callback, $option['type'] . '_callback' ) ? array( $this->callback, $option['type'] . '_callback' ) : array( $this->callback, 'missing_callback' ),
					'sunny_settings_' . $tab,
					'sunny_settings_' . $tab,
					array(
						'id'      => isset( $option['id'] ) ? $option['id'] : null,
						'desc'    => !empty( $option['desc'] ) ? $option['desc'] : '',
						'name'    => isset( $option['name'] ) ? $option['name'] : null,
						'section' => $tab,
						'size'    => isset( $option['size'] ) ? $option['size'] : null,
						'options' => isset( $option['options'] ) ? $option['options'] : '',
						'std'     => isset( $option['std'] ) ? $option['std'] : ''
						)
					);
			} // end foreach

		} // end foreach

		// Creates our settings in the options table
		register_setting( 'sunny_settings', 'sunny_settings', array( $this->sanitization, 'settings_sanitize' ) );

	}

	/**
	 * Set the array of plugin settings
	 *
	 * @since 	1.4.0
	 * @return 	array 	$settings
	*/
	private function set_registered_settings() {

	/**
	 * 'Whitelisted' Sunny settings, filters are provided for each settings
	 * section to allow extensions and other plugins to add their own settings
	 */
	$settings = array(
		/** Accounts Settings */
		'accounts' => apply_filters( 'sunny_settings_accounts',
			array(
				'cloudflare_accounts' => array(
					'id' => 'cloudflare_accounts',
					'name' => '<strong>' . __( 'CloudFlare Accounts', $this->name ) . '</strong>',
					'desc' => __( 'This free version of Sunny only support a signle CloudFlare Account.', $this->name ),
					'type' => 'header'
					),
				'cloudflare_email' => array(
					'id' => 'cloudflare_email',
					'name' => __( 'CloudFlare Email', $this->name ),
					'desc' => __( 'The email address associated with the CloudFlare account.', $this->name ),
					'type' => 'email'
					),
				'cloudflare_api_key' => array(
					'id' => 'cloudflare_api_key',
					'name' => __( 'CloudFlare API Key', $this->name ),
					'desc' => __( "This is the API key made available on your <a href='https://www.cloudflare.com/my-account.html'>CloudFlare Account</a> page. Read <a href='https://wphuman.com/make-cloudflare-supercharge-wordpress-sites/#api-key'>this tutorial</a> for detailed instruction", $this->name ),
					'type' => 'text'
					)
				) // end Accounts Settings
			), // apply_filters
		/** General Settings */
		'general' => apply_filters( 'sunny_settings_general',
			array(
				'purger_settings' => array(
					'id' => 'purger_settings',
					'name' => '<strong>' . __( 'Purger Settings', $this->name ) . '</strong>',
					'type' => 'header'
					),
				'purge_homepage' => array(
					'id' => 'purge_homepage',
					'name' => __( 'Homepage', $this->name ),
					'desc' => __( 'Purge homepage whenever post updated..', $this->name ),
					'type' => 'checkbox'
					),
				'purge_taxonomies' => array(
					'id' => 'purge_taxonomies',
					'name' => __( 'Purge Taxonomies', $this->name ),
					'desc' => __( 'Purge associated pages(e.g.: tags, categories and custom taxonomies) whenever post updated.', $this->name ),
					'type' => 'checkbox'
					),
				'admin_bar_settings' => array(
					'id' => 'admin_bar_settings',
					'name' => '<strong>' . __( 'Admin Bar Settings', $this->name ) . '</strong>',
					'type' => 'header'
					),
				'hide_admin_bar' => array(
					'id' => 'hide_admin_bar',
					'name' => __( 'Hide Admin Bar', $this->name ),
					'desc' => __( 'Hide admin bar on public-facing pages.', $this->name ),
					'type' => 'checkbox'
					),
				'security_settings' => array(
					'id' => 'security_settings',
					'name' => '<strong>' . __( 'Security Settings', $this->name ) . '</strong>',
					'type' => 'header'
					),
				'ban_login_with_bad_usernames' => array(
					'id' => 'ban_login_with_bad_usernames',
					'name' => __( 'Ban Login with Bad Usernames', $this->name ),
					'desc' => __( 'Blacklist IP which attempt to login with bad usernames.', $this->name ),
					'type' => 'checkbox'
					),
				'bad_usernames' => array(
					'id' => 'bad_usernames',
					'name' => __( 'Customize Bad Usernames', $this->name ),
					'desc' => __( 'Sunny bans <code>Admin</code> and <code>Administrator</code> by default. You can define your own bad usernames here, separated by commas.<br />Example: <code>root, test, wordpress</code>', $this->name ),
					'type' => 'text'
					)
				) // end General Settings
			), // end apply_filters
		/** Emails Settings */
		'emails' => apply_filters( 'sunny_settings_emails',
			array(
				'notification_settings' => array(
					'id' => 'notification_settings',
					'name' => '<strong>' . __( 'Notification Settings', $this->name ) . '</strong>',
					'type' => 'header'
					),
				'notification_frequency' => array(
					'id' => 'notification_frequency',
					'name' => __( 'Notification Frequency', $this->name ),
					'desc' => __( 'How often do you want to receive notification emails?', $this->name ),
					'type' => 'select',
					'options' => array(
						'immediately' => __( 'Immediately', $this->name ),
						'hourly' => __( 'Hourly', $this->name ),
						'twicedaily' => __( 'Twice Daily', $this->name ),
						'daily' => __( 'Daily', $this->name ),
						'never' => __( 'Never', $this->name )
						)
					),
				'blacklist_email_subject' => array(
					'id' => 'blacklist_email_subject',
					'name' => __( 'Blacklist Notification Subject', $this->name ),
					'desc' => __( 'This subject will be used in all blacklist notification emails.', $this->name ),
					'type' => 'text'
					),
				'sender_settings' => array(
					'id' => 'sender_settings',
					'name' => '<strong>' . __( 'Sender Settings', $this->name ) . '</strong>',
					'type' => 'header'
					),
				'email_from_name' => array(
					'id' => 'email_from_name',
					'name' => __( 'From Email', $this->name ),
					'desc' => __( 'Name the recipients will see in their email clients.', $this->name ),
					'type' => 'text'
					),
				'email_from_address' => array(
					'id' => 'email_from_address',
					'name' => __( 'From Address', $this->name ),
					'desc' => __( 'This email address will be used as the sender of the outgoing emails.', $this->name ),
					'type' => 'email'
					),
						) // end Emails Settings
					), // apply_filters
		/** Integration Settings */
		'integration' => apply_filters( 'sunny_settings_integration',
			array(
				'integration_settings' => array(
					'id' => 'integration_settings',
					'name' => '<strong>' . __( 'Integration Settings', $this->name ) . '</strong>',
					'type' => 'header'
					),
				'ithemes_security' => array(
					'id' => 'ithemes_security',
					'name' => __( 'iThemes Security', $this->name ),
					'desc' => __( 'When <a href="http://ithemes.com/security/">iThemes Security</a> blocks an IP, tell CloudFlare to blacklist it also.', $this->name ),
					'type' => 'checkbox'
					),
				'zero_spam' => array(
					'id' => 'zero_spam',
					'name' => __( 'Zero Spam', $this->name ),
					'desc' => __( 'When <a href="https://wordpress.org/plugins/zero-spam/">WordPress Zero Spam</a> blocks registration spam and spam in comments, ban its IP as well.', $this->name ),
					'type' => 'checkbox'
					),
						) // end Integration Settings
					), // apply_filters
				); // end $sunny_settings

		return $settings;

	} // end set_registered_settings

}