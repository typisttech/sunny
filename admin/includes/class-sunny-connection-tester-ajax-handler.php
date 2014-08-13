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
 * This class handles the connection tester ajax requests.
 */
class Sunny_Connection_Tester_Ajax_Handler extends Sunny_Ajax_Handler_Base {

	/**
	 * @since     1.2.0
	 */
	public function process_ajax() {

		header('Content-Type: application/json');

		// Check that user has proper secuity level  && Check the nonce field
		if ( ! current_user_can( 'manage_options') || ! check_ajax_referer( 'sunny_connection_tester', 'nonce', false ) ) {

			$return_args = array(
				"result" => "Error",
				"message" => "403 Forbidden",
				);
			$response = json_encode( $return_args );
			echo $response;

			die;

		}

		$domain = Sunny::get_instance()->get_domain();


		$cf_response = CloudFlare_API_Helper::get_instance()->rec_load_all( $domain );

		$return_args = $this->check_response( $cf_response );
		$response = json_encode( $return_args  );

		// return json response
		echo $response;

		die;

	} // process_ajax

	 /**
	 * @since     1.2.0
	 *
	 * @param     $_response        The response after api call, could be WP Error object or HTTP return object.
	 *
	 * @return    $_return_arg      array of arguments for making json response
	 */
	 private function check_response( $_response ) {

		$return_arg['connection_test_result'] = '1';

		if ( is_wp_error( $_response ) ) {

			$return_arg['result'] = 'WP Error';
			$return_arg['message'] = $_response->get_error_messages();

		}// end if //WP Error

		else {
			// API call made
			$_response_array = json_decode( $_response['body'], true );

			if ( 'error' == $_response_array['result'] ) {

				$return_arg['result'] = 'Error';
				$return_arg['message'] = $_response_array['msg'];

			} else {

				$return_arg['result'] = 'Success';

				$domain = parse_url( site_url(), PHP_URL_HOST );

				$dns_record_found = 'No';
				$service_mode_on = 'No';

				foreach( $_response_array['response']['recs']['objs'] as $obj ){

					if ( $obj['name'] == $domain ) {

						$dns_match = true;
						$dns_record_found = ( 'A' == $obj['type'] || 'AAAA' == $obj['type'] || 'CNAME' == $obj['type'] ) ? 'Yes' : 'No';
						$service_mode_on = ( '1' == $obj['service_mode'] ) ? 'Yes' : 'No';
						break;

					} // end if

				} // end foreach

				$dns_match = ( true === $dns_match ) ? 'Yes' : 'No';

				$str_message = '<br />';
				$str_message .= 'DNS record for ' . $domain . ' found: ' . $dns_record_found . '<br />';
				$str_message .= 'Service mode turned on: ' . $service_mode_on . '<br />';
				$return_arg['message'] = $str_message;

			} // end else // apiconnection success

		}// end else // api connection

		return $return_arg;

	} // end check_response

} // end Sunny_Connection_Tester_Ajax_Handler