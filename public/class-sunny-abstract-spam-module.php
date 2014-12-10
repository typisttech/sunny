<?php
/**
 * @package    Sunny
 * @subpackage Sunny/public
 * @author     Tang Rufus <rufus@wphuman.com>
 * @since      1.5.0
 *
 */

abstract class Sunny_Abstract_Spam_Module {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.5.0
	 * @access   protected
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The name of the intergrated plugin.
	 *
	 * @since 		1.5.0
	 * @access   	protected
	 * @var      	string    $intergrated_plugin_name    The name of the intergrated plugin.
	 */
	protected $intergrated_plugin_name;

	/**
	 * Initialize the class and purge after post saved
	 *
	 * @since     1.5.0
	 *
	 */
	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;
		$this->set_intergrated_plugin_name();

	} // end __construct

	/**
	 * Set intergrated plugin name during class initialization
	 *
	 * @since     1.5.0
	 *
	 */
	abstract protected function set_intergrated_plugin_name();

	/**
	 * Get intergrated plugin name
	 * @return 		string   	Intergrated plugin name
	 * @since 		1.5.0
	 *
	 */
	protected function get_intergrated_plugin_name() {
		return $this->intergrated_plugin_name;
	}

	/**
	 * Check if site admin enabled this function or not
	 *
	 * @return  boolean   True if enabled
	 * @since   1.5.0
	 *
	 */
	protected function is_enabled() {

		$enabled = Sunny_Option::get_option( $this->get_intergrated_plugin_name() );
		return ( isset( $enabled ) && '1' == $enabled );

	} // end is_enabled

	/**
	 * Check if an valid extenal ip address
	 *
	 * @param   string  $target_ip
	 * @return  boolean       		True if ip is ban-able
	 * @since   1.5.0
	 *
	 */
	protected function should_ban( $target_ip ) {
		return Sunny_Helper::is_valid_ip( $target_ip ) && ! Sunny_Helper::is_localhost( $target_ip );
	} // end should_ban

	/**
	 * Check if early quit needed during banning
	 *
	 * @param   mixed  	$_early_quit_arg
	 * @return  boolean 					True if should early quit banning
	 * @since   1.5.0
	 *
	 */
	protected function should_early_quit_banning( $_early_quit_arg = false ) {
		return false;
	}

	/**
	 * @param   string  $_reason
	 * @return  string 				Reason of banning
	 * @since   1.5.0
	 */
	protected function get_reason( $_reason = '' ) {
		return ( $this->get_intergrated_plugin_name() . __( ' marks it as a spam', $this->plugin_name ) );
	}

	/**
	 * Ban IP
	 *
	 * @param   string  $ip
	 * @param   mixed  	$early_quit_arg
	 * @param   string  $reason
	 * @since   1.5.0
	 */
	public function ban( $ip = '', $early_quit_arg = false, $reason = '' ) {

		// Quit early if not enabled OR not a ban-able IP
		if ( ! $this->is_enabled() ) {
			return;
		}

		if ( $this->should_early_quit_banning( $early_quit_arg ) ) {
			return;
		}

		$ip = ( empty($ip) ) ? Sunny_Helper::get_remoteaddr() : $ip;

		if ( ! $this->should_ban( $ip ) ) {
			return;
		}

		$response = Sunny_Lock::ban_ip( $ip );

		if ( Sunny_Helper::is_api_success( $response ) ) {

			$notice = array(
				'ip' => $ip,
				'date' => current_time( 'timestamp' ),
				'reason' => $this->get_reason( $reason )
				);

			do_action( 'sunny_banned_' . $this->get_intergrated_plugin_name(), $notice );

		}

	} // end ban

} // end Sunny_Abstract_Spam_Module
