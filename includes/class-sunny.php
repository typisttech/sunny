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
 * @since      1.0.0
 * @package    Sunny
 * @subpackage Sunny/includes
 * @author     Tang Rufus <tangrufus@gmail.com>
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
		$this->version = '1.4.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sunny_Loader. Orchestrates the hooks of the plugin.
	 * - Sunny_i18n. Defines internationalization functionality.
	 * - Sunny_Admin. Defines all hooks for the dashboard.
	 * - Sunny_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-i18n.php';

		/**
		 * The class responsible for reading options/settings from WP database.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-option.php';

		/**
		 * The class responsible for defining all helper methods.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-helper.php';

		/**
		 * The class responsible for making CLoudFlare purge API calls.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-purger.php';

		/**
		 * The class responsible for making CloudFlare Client API calls.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-cloudflare-api-helper.php';

		/**
		 * The class responsible for making CloudFlare API requests about IP blacklisting.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sunny-lock.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sunny-admin.php';

		/**
		 * The class responsible for the purge process.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sunny-post-purger.php';

		/**
		 * The class responsible for defing the mailing list sign up box.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sunny-mailing-list-box.php';

		/**
		 * The class responsible for registerating all settings via Settings API.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-sunny-settings.php';

		/**
		 * The class responsible for defining all options page meta boxes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-sunny-meta-box.php';

		/**
		 * The class responsible for sending emails.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/mailer/class-sunny-mailer.php';

		/**
		 * The class responsible for defining styling emails.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/mailer/class-sunny-email-template.php';

		/**
		 * The class responsible for defining ajax toolboxes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/tools/class-sunny-tools.php';

		/**
		 * The class responsible for defining ajax handlers.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/tools/class-sunny-ajax-handler.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sunny-public.php';

		/**
		 * The class responsible for blacklisting logins with bad usernames.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sunny-ban-bad-login.php';

		/**
		 * The class responsible for hiding the admin bar from the public.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sunny-admin-bar-hider.php';

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

		// Add the options page and menu item.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );


		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_name . '.php' );
		$this->loader->add_action( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

		// Built the option page
		$plugin_settings = new Sunny_Settings( $this->get_plugin_name() );
		$this->loader->add_action( 'admin_init' , $plugin_settings, 'register_settings' );

		$plugin_meta_box = new Sunny_Meta_Box( $this->get_plugin_name(), $plugin_admin->get_options_tabs() );
		$this->loader->add_action( 'load-toplevel_page_sunny' , $plugin_meta_box, 'add_meta_boxes' );

		$plugin_mailing_list_box = new Sunny_Mailing_List_Box( $this->get_plugin_name() );
		$this->loader->add_action( 'load-toplevel_page_sunny' , $plugin_mailing_list_box, 'add_meta_boxes' );

		$plugin_tools = new Sunny_Tools( $this->get_plugin_name() );
		$this->loader->add_action( 'load-toplevel_page_sunny' , $plugin_tools, 'add_meta_boxes' );

		$plugin_ajax_handler = new Sunny_Ajax_Handler( $this->get_plugin_name() );
		$this->loader->add_action( 'wp_ajax_sunny_test_connection' , $plugin_ajax_handler, 'process_connection_test' );
		$this->loader->add_action( 'wp_ajax_sunny_purge_zone' , $plugin_ajax_handler, 'process_zone_purge' );
		$this->loader->add_action( 'wp_ajax_sunny_purge_url' , $plugin_ajax_handler, 'process_url_purge' );

		// Hook Post Purger into Hooks
		$post_purger = new Sunny_Post_Purger( $this->get_plugin_name() );
		$this->loader->add_action( 'transition_post_status', $post_purger, 'purge_post_on_status_transition', 100, 3 );
		$this->loader->add_action( 'edit_post', $post_purger, 'purge_post_on_edit', 100 ); // leaving a comment called edit_post

		// Mailer Hooks
		$mailer = new Sunny_Mailer( $this->get_plugin_name() );
		$this->loader->add_action( 'sunny_banned_login_with_bad_username', $mailer, 'email_blacklist_notification', 100 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 */
	private function define_public_hooks() {

		// $plugin_public = new Sunny_Public( $this->get_plugin_name(), $this->get_version() );

		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'init', 'Sunny_Option', 'set_global_options' );

		$this->loader->add_action( 'sunny_after_cloudflare_api_request', 'Sunny_Helper', 'write_report', 10, 2 );

		$ban_bad_login = new Sunny_Ban_Bad_Login( $this->get_plugin_name() );
		$this->loader->add_action( 'wp_authenticate', $ban_bad_login, 'ban_login_with_bad_username', -10 );

		$admin_bar_hider = new Sunny_Admin_Bar_Hider();
		$this->loader->add_filter( 'show_admin_bar', $admin_bar_hider, 'hide' );

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
