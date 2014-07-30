<?php
/**
 *
 * @package   	Sunny
 * @subpackage 	Sunny_Admin
 * @author    	Tang Rufus <tangrufus@gmail.com>
 * @license   	GPL-2.0+
 * @link      	http://tangrufus.com
 * @copyright 	2014 Tang Rufus
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * If you're interested in introducing public-facing
 * functionality, then refer to `class-plugin-name.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package Sunny_Admin
 * @author  Tang Rufus <tangrufus@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Sunny_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Path to admin/views directory
	 *
	 * @since    1.2.0
	 *
	 * @var      string
	 */
	protected $view_dir_path = null;

	/**
	 * For easier overriding we declared the keys
	 * here as well as our tabs array
	 *
	 * @since    1.2.0
	 */
	private $plugin_settings_tabs = array();

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		/*
		 * Call $plugin_slug from public plugin class.
		 */
		$plugin = Sunny::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();


		$this->view_dir_path = plugin_dir_path( __FILE__ ) . 'views';

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		// Load dependencies for admin area
		add_action( 'admin_init', array( $this, 'load_admin_dependencies' ), 5 );

		// Hook Post Purger into Save Post
		add_action( 'admin_init', array( 'Sunny_Post_Purger', 'get_instance' ) );

		// Make option page tabs
		add_action( 'admin_init', array( $this, 'make_tabs' ), 5 );
		// Add the option settings
		add_action( 'admin_init', array( 'Sunny_CloudFlare_Account', 'get_instance' ) );
		// Add `Purge URL` handler
		add_action( 'admin_init', array( 'Sunny_URL_Purger', 'get_instance' ) );
		// Add `Purge All` button callback
		add_action( 'admin_init', array( 'Sunny_Zone_Purger', 'get_instance' ) );
		// Add `Connection Test` handler
		add_action( 'admin_init', array( 'Sunny_Connection_Tester', 'get_instance' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Return path to admin/view directory
	 *
	 * @since    1.2.0
	 *
	 * @return   view_dir_path variable.
	 */
	public function get_view_dir_path() {
		return $this->view_dir_path;
	}

	/**
	 * Return plugin settings tabs
	 *
	 * @since    1.2.0
	 *
	 * @return   array 	plugin_settings_tabs variable.
	 */
	public function get_plugin_settings_tabs() {
		return $this->plugin_settings_tabs;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Sunny::VERSION );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( 'postbox' );
			// wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), Sunny::VERSION );
			wp_enqueue_script( $this->plugin_slug . '-admin-ajax-script', plugins_url( 'assets/js/admin-ajax.js', __FILE__ ), array( 'jquery' ), Sunny::VERSION );
		}
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 */

		$this->plugin_screen_hook_suffix = add_menu_page(
			__( 'Sunny Settings - Purge CloudFlare Cache', $this->plugin_slug ),
			__( 'Sunny', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
			);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'admin.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
				),
			$links
			);

	}

	/**
	 * Make tabs in options page.
	 *
	 * @since    1.2.0
	 */
	public function make_tabs() {
		$this->plugin_settings_tabs['general_settings'] = 'Settings';
		$this->plugin_settings_tabs['purger_settings'] = 'Purger';
	}

	/**
	 * Load dependencies for admin area
	 *
	 * @since    1.2.0
	 */
	public function load_admin_dependencies() {
		require_once( 'includes/class-sunny-admin-helper.php' );
		require_once( 'includes/class-sunny-post-purger.php' );
		require_once( 'includes/class-sunny-cloudflare-account.php' );
		require_once( 'includes/class-sunny-connection-tester.php' );
		require_once( 'includes/class-sunny-zone-purger.php' );
		require_once( 'includes/class-sunny-url-purger.php' );
	}

} // end sunny_admin class