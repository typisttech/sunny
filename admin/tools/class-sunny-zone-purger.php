<?php

/**
 *
 * @package    Sunny
 * @subpackage Sunny/admin/tools
 * @author     Tang Rufus <tangrufus@gmail.com>
 * @since  	   1.4.4
 */
class Sunny_Zone_Purger {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.4
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.4.4
	 * @var      string    $name       The name of this plugin.
	 */
	public function __construct( $name ) {

		$this->name = $name;

	}
	/**
	 * @since     1.4.4
	 *
	 * @return    $return_arg      array of arguments for making json response / $_GET response
	 */
	public function get_result() {

		$cf_response = Sunny_Purger::purge_cloudflare_cache_all();
		$return_args = $this->check_zone_purge_response( $cf_response );
		return $return_args;

	}




	/**
	 * @since     1.2.0
	 *
	 * @param     $_response        The response after api call, could be WP Error object or HTTP return object.
	 *
	 * @return    $_return_arg      array of arguments for making json response
	 */
	private function check_zone_purge_response( $_response ) {

		$_return_arg['result'] = 'zone_purger';
		$_return_arg['message'] = '';

		if ( is_wp_error( $_response ) ) {

			$_return_arg['message'] = 'WP Error: ' . $_response->get_error_message();

		} // end wp error
		else {

			// API made
			$_response_array = json_decode( $_response['body'], true );

			if ( 'error' == $_response_array['result'] ) {

				$_return_arg['message'] = 'API Error: ' . $_response_array['msg'];

			} // end api returns error
			elseif ( 'success' == $_response_array['result'] ) {

				$_return_arg['message'] = 'Success: All cache has been purged.';

			} // end api success

		} // end connection success

		return $_return_arg;

	} // end check_response

}