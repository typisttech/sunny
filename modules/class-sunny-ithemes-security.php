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

		// Early quit if class ITSEC_Core doesn't exist
		if ( ! class_exists( 'ITSEC_Core' ) ) {
			return;
		}

		// Get current host (ip) lockouts
		$lockouts = $this->get_lockouts( 'host', false );

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

	/**
	 * Shows all lockouts currently in the database.
	 *
	 * @see better-wp-security/core/class-itsec-lockout.php
	 *
	 * @since 1.5.1
	 *
	 * @param string $type    'all', 'host', or 'user'
	 * @param bool   $current true for all lockouts, false for current lockouts
	 *
	 * @return array all lockouts in the system
	 */
	private function get_lockouts( $type = 'all', $current = false ) {

		global $wpdb, $itsec_globals;

		if ( $type !== 'all' || $current === true ) {
			$where = " WHERE ";
		} else {
			$where = '';
		}

		switch ( $type ) {

			case 'host':
				$type_statement = "`lockout_host` IS NOT NULL && `lockout_host` != ''";
				break;
			case 'user':
				$type_statement = "`lockout_user` != 0";
				break;
			case 'username':
				$type_statement = "`lockout_username` IS NOT NULL && `lockout_username` != ''";
				break;
			default:
				$type_statement = '';
				break;

		}

		if ( $current === true ) {

			if ( $type_statement !== '' ) {
				$and = ' AND ';
			} else {
				$and = '';
			}

			$active = $and . " `lockout_active`=1 AND `lockout_expire_gmt` > '" . date( 'Y-m-d H:i:s', $itsec_globals['current_time_gmt'] ) . "'";

		} else {

			$active = '';

		}

		return $wpdb->get_results( "SELECT * FROM `" . $wpdb->base_prefix . "itsec_lockouts`" . $where . $type_statement . $active . ";", ARRAY_A );

	}

} // end Sunny_iThemes_Security
