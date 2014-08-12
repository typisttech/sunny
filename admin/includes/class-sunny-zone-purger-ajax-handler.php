<?php
/**
 * @package     Sunny
 * @subpackage  Sunny_Admin
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @license     GPL-2.0+
 * @link        http://tangrufus.com
 * @copyright   2014 Tang Rufus
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @since 		1.2.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Sunny_Ajax_Handler_Base', false ) ) {
	require_once( 'class-sunny-ajax-handler-base.php' );
}

/**
 * This class handles the zone purger ajax requests.
 */
class Sunny_Zone_Purger_Ajax_Handler extends Sunny_Ajax_Handler_Base {

	/**
	 * @since     1.2.0
	 */
	public function process_ajax() {

		header('Content-Type: application/json');

		// Check that user has proper secuity level  && Check the nonce field
		if ( ! current_user_can( 'manage_options') || ! check_ajax_referer( 'sunny_zone_purger', 'nonce', false ) ) {

			$return_args = array(
								"result" => "Error",
								"message" => "403 Forbidden",
								);
			$response = json_encode( $return_args );
			echo $response;

			die;

		}

		$cf_response = Sunny_Purger::purge_cloudflare_cache_all();
		$return_args = $this->check_response( $cf_response );
		$response = json_encode( $return_args  );

		// return json response
		echo $response;

		die;

	} // end process_ajax

	/**
	 * @since     1.2.0
	 *
	 * @param     $_response        The response after api call, could be WP Error object or HTTP return object.
	 *
	 * @return    $_return_arg      array of arguments for making json response
	 */
	private function check_response( $_response ) {

		$_return_arg['zone_purge_result'] = '1';

		if ( is_wp_error( $_response ) ) {

			$_return_arg['result'] = 'WP Error';
			$_return_arg['message'] = $_response->get_error_messages();

		} // end wp error
		else {

			// API made
			$_response_array = json_decode( $_response['body'], true );

			if ( 'error' == $_response_array['result'] ) {

				$_return_arg['result'] = 'API Error';
				$_return_arg['message'] = $_response_array['msg'];

			} // end api returns error
			elseif ( 'success' == $_response_array['result'] ) {

				$_return_arg['result'] = 'Success';
				$_return_arg['message'] = 'All cache has been purged.';

			} // end api success

		} // end connection success

		return $_return_arg;

	} // end check_response

} // end Sunny_Zone_Purger_Ajax_Handler