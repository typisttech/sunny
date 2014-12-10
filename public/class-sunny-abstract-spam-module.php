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
	abstract public function set_intergrated_plugin_name();

	/**
	 * Get intergrated plugin
	 *
	 * @since     1.5.0
	 *
	 */
	public function get_intergrated_plugin_name() {
		return $this->intergrated_plugin_name;
	}

	/**
	 * Check if site admin enabled this function or not
	 *
	 * @return  boolean   True if enabled
	 *
	 * @since   1.5.0
	 *
	 */
	protected function is_enabled() {

		$enabled = Sunny_Option::get_option( $this->get_intergrated_plugin_name() );
		return ( isset( $enabled ) && '1' == $enabled );

	} // end is_enabled

	/**
	 * Check if an extenal ip address
	 *
	 * @param   string  $ip
	 * @return  boolean       True if ip is ban-able
	 *
	 * @since   1.5.0
	 *
	 */
	protected function should_ban( $ip ) {

		// return Sunny_Helper::is_valid_ip( $ip ) && ! Sunny_Helper::is_localhost( $ip );
		return Sunny_Helper::is_valid_ip( $ip );

	} // end should_ban

	/**
	 * Ban IP
	 *
	 * @since   1.5.0
	 */
	public function ban_spam() {

		$ip = Sunny_Helper::get_remoteaddr();

		// Quit early if not enabled OR not a ban-able IP
		if ( ! $this->is_enabled() || ! $this->should_ban( $ip ) ) {
			return $is_spam;
		}

		$response = Sunny_Lock::ban_ip( $ip );

		if ( Sunny_Helper::is_api_success( $response ) ) {

			$notice = array(
				'ip' => $ip,
				'date' => current_time( 'timestamp' ),
				'reason' => $this->get_intergrated_plugin_name() . __( ' marks it as a spam', $this->plugin_name )
				);

			do_action( 'sunny_banned_' . $this->get_intergrated_plugin_name(), $notice );

		}

	} // end ban_spam

} // end Sunny_Abstract_Spam_Module
