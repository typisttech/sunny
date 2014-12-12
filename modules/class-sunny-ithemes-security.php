<?php
/**
 * @package    Sunny
 * @subpackage Sunny/modules
 * @author     Tang Rufus <rufus@wphuman.com>
 * @since      1.4.12
 *
 */

/**
 * This class intergates with iThemes Security plugin.
 */
class Sunny_iThemes_Security extends Sunny_Abstract_Spam_Module {

	/**
	 * Set intergrated plugin slug during class initialization
	 *
	 * @since 		1.5.0
	 *
	 */
	protected function set_intergrated_plugin_slug() {
		$this->intergrated_plugin_slug = 'ithemes_security';
	}

	/**
	 * Ban IPs if iThemes Security locks them.
	 * This is a wp cron job callback.
	 *
	 * @since 	1.5.0
	 */
	public function ban( $_ip = '', $_early_quit_arg = false, $_reason = '' ) {

		// Early quit if not enabled or
		if ( ! $this->is_enabled() ) {
			return;
		}

		// Early quit if class ITSEC_Lockout doesn't exist
		if ( ! class_exists( 'ITSEC_Lockout' ) ) {
			return;
		}

		// Get current host (ip) lockouts
		$itsec_lockout = new ITSEC_Lockout();
		$lockouts = $itsec_lockout->get_lockouts( 'host', false );

		foreach ( $lockouts as $lockout ) {
			$this->ban_lockout( $lockout );
		}

	} // end ban

	/**
	 * Check if an loackout is too old
	 *
	 * @param   string  	$start_gmt
	 * @return  boolean 					True if lockout is older than 600 seconds
	 * @since   1.5.0
	 *
	 */
	protected function should_early_quit_banning( $start_gmt = false ) {
		if ( false === $start_gmt ) {
			return parent::should_early_quit_banning();
		} else {
			return ( strtotime( 'now GMT' ) - strtotime( $start_gmt ) > 600 );
		}
	}


	/**
	 * @param   string  $reason
	 * @return  string 				Reason of banning
	 * @since   1.5.0
	 */
	protected function get_reason( $reason = '' ) {
		if ( empty( $reason ) ) {
			return parent::get_reason();
		} else {
			return sprintf( __( 'iThemes Security lock this ip out because of %s', $this->plugin_name ), $reason );
		}
	}

	/**
	 * Ban a lockout
	 *
	 * @param  array	$lockout
	 * @return void
	 * @since  1.4.12
	 */
	private function ban_lockout( $lockout ) {

		$ip 					= $lockout['lockout_host'];
		$reason_lockout_type 	= (String) $lockout['lockout_type'];
		$start_gmt 				= $lockout['lockout_start_gmt'] . 'GMT';

		parent::ban( $ip, $start_gmt, $reason_lockout_type );

	} // end ban_lockout

} // end Sunny_iThemes_Security
