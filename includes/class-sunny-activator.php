<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.4.0
 * @package    Sunny
 * @subpackage Sunny/includes
 * @author     Tang Rufus <tangrufus@gmail.com>
 */
class Sunny_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.4.0
	 */
	public static function activate() {

		$sunny_version = get_option( 'sunny_version' );

		if ( ! $sunny_version ) {
			// 1.3.0 is the last version didn't use this option so we must add it
			$sunny_version = '1.3.0';
		}

		$sunny_version = preg_replace( '/[^0-9.].*/', '', $sunny_version );

		// Upgrade from v1.3.0 or before
		if ( version_compare( $sunny_version, '1.4.0', '<' ) ) {
			self::upgrade_to_v140();
			self::activate();
		}

		// Bump version number
		if ( false != get_option( 'sunny_version' ) || '' == get_option( 'sunny_version' ) ) {
			delete_option( 'sunny_version' );
		}
		$current_version = '1.4.1';
		add_option( 'sunny_version', $current_version );

	}

	/**
	 * Delete old options
	 *
	 * @since  1.4.0
	 * @return void
	 */
	private static function upgrade_to_v140() {

		if ( false != get_option( 'sunny_cloudflare_email' ) || '' == get_option( 'sunny_cloudflare_email' ) ) {
			delete_option('sunny_cloudflare_email');
		}

		if ( false != get_option( 'sunny_cloudflare_api_key' ) || '' == get_option( 'sunny_cloudflare_api_key' ) ) {
			delete_option('sunny_cloudflare_api_key');
		}

		if ( false != get_option( 'sunny_cloudflare_account' ) || '' == get_option( 'sunny_cloudflare_account' ) ) {
			delete_option('sunny_cloudflare_account');
		}

		if ( false != get_option( 'sunny_purger_settings' ) || '' == get_option( 'sunny_purger_settings' ) ) {
			delete_option('sunny_purger_settings');
		}

		if ( false != get_option( 'sunny_admin_bar' ) || '' == get_option( 'sunny_admin_bar' ) ) {
			delete_option('sunny_admin_bar');
		}

		if ( false != get_option( 'sunny_security' ) || '' == get_option( 'sunny_security' ) ) {
			delete_option('sunny_security');
		}

		// Bump version number to v1.4.0
		if ( false != get_option( 'sunny_version' ) || '' == get_option( 'sunny_version' ) ) {
			delete_option( 'sunny_version' );
		}
		add_option( 'sunny_version', '1.4.0' );

		// Add admin notice
		self::enqueue_to_v140_notice();

	}

	/**
	 *
	 * @since  1.4.0
	 * @return void
	 */
	private static function enqueue_to_v140_notice() {

		$notice = array(
			'class'  => 'updated',
			'message' => sprintf( __( '<strong>Action Required: </strong>Sunny has been gone through a major upgrade, click <a href="%s"><strong>here</strong></a> to reset all necessary settings.', 'sunny' ),
				admin_url( 'admin.php?page=sunny&tab=accounts' )
				)
			);

		self::enqueue_admin_notice( $notice );

	}

	/**
	 * Enqueue an admin notice to database
	 * 
	 * @since  1.4.0
	 * @param  array  $notice 
	 * @return void
	 */
	private static function enqueue_admin_notice( array $notice ) {
		
		// Early quit if no notices
		if ( empty( $notice ) ) {
			return;
		}

		$old_notices = get_option( 'sunny_enqueued_admin_notices', array() );
		$new_notices = array_push( $old_notices, $notice );
		$new_notices = apply_filters( 'sunny_enqueued_admin_notices', $old_notices, $notice);

		delete_option( 'sunny_enqueued_admin_notices' );
		add_option( 'sunny_enqueued_admin_notices', $new_notices );

	}

}
