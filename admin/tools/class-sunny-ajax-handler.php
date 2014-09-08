<?php

/**
 *
 * @package    Sunny
 * @subpackage Sunny/admin/tools
 * @author     Tang Rufus <tangrufus@gmail.com>
 * @since  	   1.4.0
 */
class Sunny_Ajax_Handler {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.4.0
	 * @var      string    $name       The name of this plugin.
	 */
	public function __construct( $name ) {

		$this->name = $name;

	}

	/**
	 * Check if an Ajax request valid.
	 *
	 * @param  string 	$id Ajax Action ID
	 * @return boolean     	True if pass, otherwise, Die with 403
	 *
	 * @since  1.4.0
	 */
	private function secuity_check( $id ) {

		// Check that user has proper secuity level && Check the nonce field && Check refer from Tools tab
		if ( current_user_can( 'manage_options') && check_ajax_referer( 'sunny_tools_' . $id . '-options', '_wpnonce', false ) && !empty( $_POST['_wp_http_referer'] ) && isset( $_POST['_wp_http_referer'] ) ) {

			parse_str( $_POST['_wp_http_referer'], $referrer );

			if ( isset( $referrer['tab'] ) && 'tools' == $referrer['tab'] ) {

				return true;

			}

		}

		// FAIL
		$return_args = array(
			"result" => "Error",
			"message" => "403 Forbidden",
			);
		$this->send_JSON_response( $return_args );
		die;

	} // end secuity_check

	/**
	 * Send JSON response back to browser
	 *
	 * @since  1.4.4
	 *
	 * @param  array 	$_return_args
	 */
	private function send_JSON_response( $_return_args ) {

		header('Content-Type: application/json');
		$_response = json_encode( $_return_args  );
		echo $_response;
		die;

	} // end send_JSON_response

	/**
	 * @since     1.2.0
	 */
	public function process_connection_test() {

		$this->secuity_check( 'connection_tester' );

		$connection_tester = new Sunny_Connection_Tester( $this->name );
		$return_args = $connection_tester->get_result();

		$this->send_JSON_response( $return_args );
		die;

	} // end process_connection_test

	/**
	 * @since     1.2.0
	 */
	public function process_zone_purge() {

		$this->secuity_check( 'zone_purger' );

		$zone_purger = new Sunny_Zone_Purger( $this->name );
		$return_args = $zone_purger->get_result();

		$this->send_JSON_response( $return_args );
		die;

	} // end process_zone_purge

	/**
	 * @since     1.2.0
	 */
	public function process_url_purge() {

		$this->secuity_check( 'url_purger' );

		$url_purger = new Sunny_Url_Purger( $this->name );
		$return_args = $url_purger->get_result();

		$this->send_JSON_response( $return_args );
		die;

	} // end process_url_purge

} //end Sunny_Ajax_Handler