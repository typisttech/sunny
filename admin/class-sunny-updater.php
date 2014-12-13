<?php

/**
 * Fired during plugin upgrade.
 *
 * This class defines all code necessary to run during the plugin's update.
 *
 * @package    Sunny
 * @subpackage Sunny/admin
 * @author     Tang Rufus <rufus@wphuman.com>
 * @since      1.5.0
 */
class Sunny_Updater {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.5.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.5.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.5.0
	 * @var      string    $plugin_name       The name of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 *
	 * @since    1.5.0
	 */
	public function update() {

		$sunny_version = get_option( 'sunny_version' );
		$this->version = '1.5.1';

		if ( ! $sunny_version ) {
		// 1.3.0 is the last version didn't use this option so we must add it
			$sunny_version = '1.3.0';
		}

		if ( $sunny_version == $this->version) {
			return;
		}

		$sunny_version = preg_replace( '/[^0-9.].*/', '', $sunny_version );

		// Upgrade from v1.3.0 or before
		if ( version_compare( $sunny_version, '1.4.0', '<' ) ) {
			$this->upgrade_to_v1_4_0();
		}

		// Upgrade from v1.4.1 or before
		if ( version_compare( $sunny_version, '1.4.2', '<' ) ) {
			$this->enqueue_to_v1_4_2_admin_notice();
		}

		// Upgrade from v1.4.10 or before
		if ( version_compare( $sunny_version, '1.4.11', '<' ) ) {
			$this->enqueue_to_v1_4_11_admin_notice();
		}

		update_option( 'sunny_version', $this->version );

	}

	/**
	 *
	 * @since  1.4.11
	 * @return void
	 */
	private function enqueue_to_v1_4_11_admin_notice() {

		$notice = array(
			'class'  => 'updated',
			'message' => sprintf( __( '<strong>News: </strong> WP Human has published a <a href="%s">tutorial</a> about using CloudFlare on WordPress. Be sure to <a href="%s">check it out</a>.', $this->plugin_name ),
				'https://wphuman.com/make-cloudflare-supercharge-wordpress-sites/',
				'https://wphuman.com/make-cloudflare-supercharge-wordpress-sites/'
				)
			);

		$this->enqueue_admin_notice( $notice );

	}

	/**
	 *
	 * @since  1.4.2
	 * @return void
	 */
	private function enqueue_to_v1_4_2_admin_notice() {

		$notice = array(
			'class'  => 'updated',
			'message' => sprintf( __( '<strong>Important: </strong> If you have previously installed Sunny version v1.3.0 or before, you would lost the Cloudflare credentials and settings. This is because version 1.5.0 is a major upgrade and most of the code is changed. <br /><strong>Good news</strong> Email notifications can been disabled since version 1.4.2. Click <a href="%s"><strong>here</strong></a> to review all necessary settings.', $this->plugin_name ),
				admin_url( 'admin.php?page=sunny&tab=accounts' )
				)
			);

		$this->enqueue_admin_notice( $notice );

	}

	/**
	 * Delete old options
	 *
	 * @since  1.4.0
	 * @return void
	 */
	private function upgrade_to_v1_4_0() {

		if ( false !== get_option( 'sunny_cloudflare_email' ) ) {
			delete_option('sunny_cloudflare_email');
		}

		if ( false !== get_option( 'sunny_cloudflare_api_key' ) ) {
			delete_option('sunny_cloudflare_api_key');
		}

		if ( false !== get_option( 'sunny_cloudflare_account' ) ) {
			delete_option('sunny_cloudflare_account');
		}

		if ( false !== get_option( 'sunny_purger_settings' ) ) {
			delete_option('sunny_purger_settings');
		}

		if ( false !== get_option( 'sunny_admin_bar' ) ) {
			delete_option('sunny_admin_bar');
		}

		if ( false !== get_option( 'sunny_security' ) ) {
			delete_option('sunny_security');
		}

	}

	/**
	 * Enqueue an admin notice to database
	 *
	 * @since  1.5.0
	 * @param  array  $notice
	 * @return void
	 */
	private function enqueue_admin_notice( array $notice ) {

	// Early quit if no notices
		if ( empty( $notice ) ) {
			return;
		}

		Sunny_Option::enqueue_admin_notice( $notice );

	}

}
