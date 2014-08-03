<?php
/**
 *
 * @package   Sunny
 * @author    Tang Rufus <tangrufus@gmail.com>
 * @license   GPL-2.0+
 * @link      http://tangrufus.com
 * @copyright 2014 Tang Rufus
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-plugin-name-admin.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package Sunny
 * @author  Tang Rufus <tangrufus@gmail.com>
 */
class Sunny {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.1.1';

	/**
	 * @TODO - Rename "plugin-name" to the name of your plugin
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'sunny';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 *
	 * String of TLD
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $domain = '';

	/**
	 * Return CloudFlare Account Email from Database
	 *
	 * @since     1.0.0
	 *
	 * @return    string    CloudFlare Account Email
	 */
	public function get_domain() {
		$host_names = explode( '.', parse_url( site_url(), PHP_URL_HOST ) );
		return $host_names[count( $host_names )-2] . '.' . $host_names[count( $host_names )-1];
	}

	/**
	 *
	 * String of CloudFlare Account Email
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $cloudflare_email = '';

	 /**
	 * Return CloudFlare Account Email from Database
	 *
	 * @since     1.0.0
	 *
	 * @return    string    CloudFlare Account Email
	 */
	 public function get_cloudflare_email() {
		$cloudflare_account = get_option( 'sunny_cloudflare_account' );
		return sanitize_email( $cloudflare_account['email'] );
	 }

	/**
	 *
	 * String of CloudFlare Account API Key
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $cloudflare_api_key = '';

	 /**
	 * Return CloudFlare Account API Key from Database
	 *
	 * @since     1.0.0
	 *
	 * @return    string    CloudFlare Account API Key
	 */
	 public function get_cloudflare_api_key() {
		$cloudflare_account = get_option( 'sunny_cloudflare_account' );
		return Sunny_Helper::sanitize_alphanumeric( $cloudflare_account['api_key'] );
	 }

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		// Set CloudFlare Account Info
		$cloudflare_email = $this->get_cloudflare_email();
		$cloudflare_api_key = $this->get_cloudflare_api_key();

		// Load dependencies for admin area
		$this->load_public_dependencies();

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet and JavaScript.
		// add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		// add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Hide admin bar
		add_action( 'wp_loaded', array( 'Sunny_Admin_Bar_Hider', 'get_instance' ) );

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();

					restore_current_blog();
				}

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

					restore_current_blog();

				}

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
		WHERE archived = '0' AND spam = '0'
		AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		if( false != get_option( 'sunny_cloudflare_email' ) ) {
			delete_option( 'sunny_cloudflare_email' );
		}

		if( false != get_option( 'sunny_cloudflare_api_key' ) ) {
			delete_option( 'sunny_cloudflare_api_key' );
		}

		$options = get_option( 'sunny_cloudflare_account' );
		if( false == $options || '' == $options ) {
			$options = array( 'sunny_cloudflare_email' => 'you@exampl.com', 'sunny_cloudflare_api_key' => 'abcd1234' );
			delete_option( 'sunny_cloudflare_account' );
			add_option( 'sunny_cloudflare_account', $options );
		}
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	// public function enqueue_styles() {
	// 	wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
	// }

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	// public function enqueue_scripts() {
	// 	wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION );
	// }

	/**
	 * Load dependencies for admin area
	 *
	 * @since    1.2.0
	 */
	private function load_public_dependencies() {

		// Helpers
		require_once( 'includes/class-sunny-admin-bar-hider.php' );

	} // end load_public_dependencies
}// end of class