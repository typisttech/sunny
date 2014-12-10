<?php

/**
 *
 * @package    Sunny
 * @subpackage Sunny/admin/tools
 * @author     Tang Rufus <rufus@wphuman.com>
 * @since  	   1.4.4
 */
class Sunny_Tools_Handler {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.4
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.4.4
	 * @var      string    $plugin_name       The name of this plugin.
	 */
	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;

	}

	/**
	 * Check if an post request valid.
	 * Note that check_admin_referer also do wp_die
	 *
	 * @param  string 	$id 	Ajax Action ID
	 * @return boolean     		True if pass, otherwise, Die with 403
	 *
	 * @since  1.4.0
	 */
	private function secuity_check( $id ) {

		// Check that user has proper secuity level && Check the nonce field && Check refer from Tools tab
		if ( current_user_can( 'manage_options') && check_admin_referer( 'sunny_tools_' . $id . '-options' ) && !empty( $_POST['_wp_http_referer'] ) && isset( $_POST['_wp_http_referer'] ) ) {

			$_wp_http_referer = $_POST['_wp_http_referer'];
			$_wp_http_referer = strstr( $_wp_http_referer, '?');
			$_wp_http_referer = str_replace( '?', '', $_wp_http_referer );
			parse_str( $_wp_http_referer, $referrer );

			if ( isset( $referrer['tab'] ) && 'tools' == $referrer['tab'] && isset( $referrer['page'] ) && 'sunny' == $referrer['page']) {

				return true;

			}

		}

		// FAIL
		wp_die( "You don't have sufficient permission.", 'Secuity Check Error', array( 'back_link' => true ) );

	} // end ajax_secuity_check

	/**
	 * Esacap the result message
	 *
	 * @since  1.4.4
	 *
	 * @param  array 	$_return_args
	 *
	 * @return string   $_message 		clean URL encoded message
	 */
	private function prepare_result_message( $_return_args ) {

		$_message = '';

		if ( !empty( $_return_args['message'] ) ) {

			$_message = $_return_args['message'];

				// Escaping line breaks
				// Turn it back to <br /> at sunny-tool-box-display.php
			$line_breaks = array( '<br />', '<br>', '<br/>', '\n' );
			$_message = str_replace( $line_breaks, '!!!!!', $_message );

				// Escaping spaces to &nbsp;
			$_message = str_replace( ' ', '%20', $_message );


		}

		return $_message;

	}

	/**
	 * Send GET response back to browser
	 *
	 * @since  1.4.4
	 *
	 * @param  array 	$_return_args
	 */
	private function send_GET_response( $_return_args ) {

		// $_return_arg['result'] 		= $_return_arg['result'];
		$_return_args['message']	= $this->prepare_result_message( $_return_args );
		$_return_args['page']		= $this->plugin_name;
		$_return_args['tab']		= 'tools';

		wp_redirect( add_query_arg( $_return_args, admin_url( 'admin.php' ) ) );
		die;

	}

	/**
	 * @since     1.4.4
	 */
	public function process_connection_test() {

		$this->secuity_check( 'connection_tester' );

		$connection_tester = new Sunny_Connection_Tester( $this->plugin_name );
		$return_args = $connection_tester->get_result();

		$this->send_GET_response( $return_args );
		die;

	} // process_connection_test

	/**
	 * @since     1.4.4
	 */
	public function process_zone_purge() {

		$this->secuity_check( 'zone_purger' );

		$zone_purger = new Sunny_Zone_Purger( $this->plugin_name );
		$return_args = $zone_purger->get_result();

		$this->send_GET_response( $return_args );
		die;

	} // end process_zone_purge

	/**
	 * @since     1.4.4
	 */
	public function process_url_purge() {

		$this->secuity_check( 'url_purger' );

		$url_purger = new Sunny_Url_Purger( $this->plugin_name );
		$return_args = $url_purger->get_result();

		$this->send_GET_response( $return_args );
		die;

	} // end process_url_purge

}
