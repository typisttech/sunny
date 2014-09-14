<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Sunny
 * @subpackage Sunny/admin
 * @author     Tang Rufus <tangrufus@gmail.com>
 */
class Sunny_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sunny_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sunny_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 *
		 * Return early if no settings page is registered.
		 */

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {

			wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/sunny-admin.css', array(), $this->version, 'all' );

		}

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sunny_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sunny_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 *
		 * Return early if no settings page is registered.
		 */
		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {

			wp_enqueue_script( 'postbox' );
			wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/sunny-admin.js', array( 'jquery' ), $this->version, true );

		}

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.4.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 */

		$this->plugin_screen_hook_suffix = add_menu_page(
			__( 'Sunny (Connecting CloudFlare and WordPress)', $this->name ),
			__( 'Sunny', $this->name ),
			'manage_options',
			$this->name,
			array( $this, 'display_plugin_admin_page' )
			);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {

		include_once( 'partials/sunny-admin-display.php' );

	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'admin.php?page=' . $this->name ) . '">' . __( 'Settings', $this->name ) . '</a>'
				),
			$links
			);

	}

	/**
	 * Retrieve settings tabs
	 *
	 * @since 	1.4.0
	 * @param 	array $input The field value
	 * @return 	string $input Sanitizied value
	 */
	public function get_options_tabs() {

		$tabs 					= array();
		$tabs['accounts'] 		= __( 'Accounts', $this->name );
		$tabs['general']  		= __( 'General', $this->name );
		$tabs['emails']			= __( 'Emails', $this->name );
		$tabs['tools']			= __( 'Tools', $this->name );
		// $tabs['integration']	= __( 'Integration', $this->name );

		return apply_filters( 'sunny_settings_tabs', $tabs );
	}

	/**
	 * Show defered admin notices
	 *
	 * @since  1.4.0
	 * @see  http://stackoverflow.com/questions/9807064/wordpress-how-to-display-notice-in-admin-panel-on-plugin-activation
	 */
	public function show_enqueued_admin_notices() {

		$notices = Sunny_Option::get_enqueued_admin_notices();

		// Quit early if nosaved  admin notices
		if ( empty( $notices ) ) {
			return;
		}

		foreach( $notices as $notice ) {
			echo "<div class='$notice[class]'><p>$notice[message]</p></div>";
		}

		Sunny_Option::dequeue_admin_notices( $notices );

	} // end show_enqueued_admin_notices
}