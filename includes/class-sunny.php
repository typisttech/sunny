<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @package    Sunny
 * @subpackage Sunny/includes
 * @author     Tang Rufus <rufus@wphuman.com>
 * @since      1.0.0
 */
class Sunny {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.4.0
	 * @access   protected
	 * @var      Sunny_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.4.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'sunny';
		$this->version = '1.5.1';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_module_hooks();
		$this->define_mailer_hooks();
		$this->define_cron_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sunny_Loader. Orchestrates the hooks of the plugin.
	 * - Sunny_i18n. Defines internationalization functionality.
	 * - Sunny_Admin. Defines all hooks for the dashboard.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-cloudflare-api-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-cron.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-lock.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-option.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-purger.php';



		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-sunny-callback-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-sunny-meta-box.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-sunny-sanitization-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-sunny-settings.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/tools/class-sunny-ajax-handler.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/tools/class-sunny-connection-tester.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/tools/class-sunny-tools-handler.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/tools/class-sunny-tools.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/tools/class-sunny-url-purger.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/tools/class-sunny-zone-purger.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sunny-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sunny-mailing-list-box.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sunny-updater.php';



		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'mailer/class-sunny-email-template.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'mailer/class-sunny-mailer.php';



		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/class-sunny-abstract-spam-module.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/class-sunny-admin-bar-hider.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/class-sunny-ban-bad-login.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/class-sunny-contact-form-7.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/class-sunny-ithemes-security.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/class-sunny-post-purger.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/class-sunny-zero-spam.php';



		$this->loader = new Sunny_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sunny_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.4.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Sunny_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Sunny_Admin( $this->get_plugin_name(), $this->get_version() );

		// Load admin style sheet and JavaScript.
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Show defered admin notices
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'show_enqueued_admin_notices' );

		// Add the options page and menu item.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_name . '.php' );
		$this->loader->add_action( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

		// Run update scripts
		$plugin_updater = new Sunny_Updater( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_init', $plugin_updater, 'update' );

		// Built the option page
		$settings_callback = new Sunny_Callback_Helper( $this->plugin_name );
		$settings_sanitization = new Sunny_Sanitization_Helper( $this->plugin_name );
		$plugin_settings = new Sunny_Settings( $this->get_plugin_name(), $settings_callback, $settings_sanitization);
		$this->loader->add_action( 'admin_init' , $plugin_settings, 'register_settings' );

		$plugin_meta_box = new Sunny_Meta_Box( $this->get_plugin_name(), $plugin_admin->get_options_tabs() );
		$this->loader->add_action( 'load-toplevel_page_sunny' , $plugin_meta_box, 'add_meta_boxes' );

		$plugin_mailing_list_box = new Sunny_Mailing_List_Box( $this->get_plugin_name() );
		$this->loader->add_action( 'load-toplevel_page_sunny' , $plugin_mailing_list_box, 'add_meta_boxes' );

		$plugin_tools = new Sunny_Tools( $this->get_plugin_name() );
		$this->loader->add_action( 'load-toplevel_page_sunny' , $plugin_tools, 'add_meta_boxes' );

		// Ajax Tools
		$plugin_ajax_handler = new Sunny_Ajax_Handler( $this->get_plugin_name() );
		$this->loader->add_action( 'wp_ajax_sunny_connection_test' , $plugin_ajax_handler, 'process_connection_test' );
		$this->loader->add_action( 'wp_ajax_sunny_zone_purge' , $plugin_ajax_handler, 'process_zone_purge' );
		$this->loader->add_action( 'wp_ajax_sunny_url_purge' , $plugin_ajax_handler, 'process_url_purge' );

		// Non-Ajax Tools
		$plugin_tools_handler = new Sunny_Tools_Handler( $this->get_plugin_name() );
		$this->loader->add_action( 'admin_post_sunny_connection_test' , $plugin_tools_handler, 'process_connection_test' );
		$this->loader->add_action( 'admin_post_sunny_zone_purge' , $plugin_tools_handler, 'process_zone_purge' );
		$this->loader->add_action( 'admin_post_sunny_url_purge' , $plugin_tools_handler, 'process_url_purge' );

	}

	/**
	 * Register all of the hooks related to the modular functionality
	 * of the plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 */
	private function define_module_hooks() {

		$this->loader->add_action( 'init', 'Sunny_Option', 'set_global_options' );

		$post_purger = new Sunny_Post_Purger( $this->get_plugin_name() );
		$this->loader->add_action( 'transition_post_status', $post_purger, 'purge_post_on_status_transition', 100, 3 );
		$this->loader->add_action( 'edit_post', $post_purger, 'purge_post_on_edit', 100 ); // leaving a comment called edit_post
		$this->loader->add_action( 'edit_attachment', $post_purger, 'purge_attachment_on_edit', 100 );

		$admin_bar_hider = new Sunny_Admin_Bar_Hider();
		$this->loader->add_filter( 'show_admin_bar', $admin_bar_hider, 'hide' );

		$ban_bad_login = new Sunny_Ban_Bad_Login( $this->get_plugin_name() );
		$this->loader->add_action( 'wp_authenticate', $ban_bad_login, 'ban_login_with_bad_username', -10 );

		$zero_spam = new Sunny_Zero_Spam( $this->get_plugin_name() );
		$this->loader->add_action( 'zero_spam_ip_blocked', $zero_spam, 'ban', 10, 0 );
		$this->loader->add_action( 'zero_spam_found_spam_registration', $zero_spam, 'ban', 10, 0 );
		$this->loader->add_action( 'zero_spam_found_spam_comment', $zero_spam, 'ban', 10, 0 );
		$this->loader->add_action( 'zero_spam_found_spam_cf7_form_submission', $zero_spam, 'ban', 10, 0 );
		$this->loader->add_action( 'zero_spam_found_spam_gf_form_submission', $zero_spam, 'ban', 10, 0 );
		$this->loader->add_action( 'zero_spam_found_spam_buddypress_registration', $zero_spam, 'ban', 10, 0 );

		$contact_form_7 = new Sunny_Contact_Form_7( $this->get_plugin_name() );
		$this->loader->add_filter( 'wpcf7_spam', $contact_form_7, 'ban_spam', 99999 );

	}

	/**
	 * Register all of the hooks related to the mailing functionality
	 * of the plugin.
	 *
	 * @since    1.5.1
	 * @access   private
	 */
	private function define_mailer_hooks() {

		$mailer = new Sunny_Mailer( $this->get_plugin_name() );

		// Mailer corn
		$this->loader->add_action( 'sunny_cron_send_notification', $mailer, 'email_blacklist_notification_digest' );

		$this->loader->add_action( 'sunny_banned_login_with_bad_username', $mailer, 'enqueue_blacklist_notification' );
		$this->loader->add_action( 'sunny_banned_zero_spam', $mailer, 'enqueue_blacklist_notification' );
		$this->loader->add_action( 'sunny_banned_ithemes_security', $mailer, 'enqueue_blacklist_notification' );
		$this->loader->add_action( 'sunny_banned_contact_form_7', $mailer, 'enqueue_blacklist_notification' );

	}

	/**
	 * Register all of the hooks related to the cron job functionality
	 * of the plugin.
	 *
	 * @since    1.5.1
	 * @access   private
	 */
	private function define_cron_hooks() {

		// Cron Jobs
		// Add intervals
		$this->loader->add_filter( 'cron_schedules', 'Sunny_Cron', 'add_intervals' );

		// Set schedules
		$this->loader->add_action( 'init', 'Sunny_Cron', 'set_notification_schedule' );
		$this->loader->add_action( 'init', 'Sunny_Cron', 'set_ithemes_security_schedule' );

		// Update schedules
		$this->loader->add_action( 'sunny_settings_on_change_notification_frequency', 'Sunny_Cron', 'update_notification_schedule' );

		// Set callbacks
		$ithemes_security = new Sunny_iThemes_Security( $this->get_plugin_name() );
		$this->loader->add_action( 'sunny_cron_check_ithemes_security_lockouts', $ithemes_security, 'ban' );

		// Logging
		$this->loader->add_action( 'sunny_after_cloudflare_api_request', 'Sunny_Helper', 'write_api_report', 10, 2 );
		$this->loader->add_action( 'sunny_after_email_sent', 'Sunny_Helper', 'write_email_report', 10, 2 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.4.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.4.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.4.0
	 * @return    Sunny_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
