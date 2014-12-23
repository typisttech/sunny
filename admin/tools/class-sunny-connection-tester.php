<?php

/**
 *
 * @package    Sunny
 * @subpackage Sunny/admin/tools
 * @author     Tang Rufus <rufus@wphuman.com>
 * @since  	   1.4.4
 */
class Sunny_Connection_Tester {

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
	 * Perform connection test
	 *
	 * @since     1.4.4
	 *
	 * @return    $_return_arg      array of arguments for making json response / $_GET response
	 */
	public function get_result() {

		$cf_response = $this->perform_api_request();
		return $this->check_connection_test_response( $cf_response );

	}

	/**
	 * Perform rec_load_all api call
	 *
	 * @since  1.4.4
	 *
	 * @return $_cf_response     The response after rec_load_all api call, could be WP Error object or HTTP return object.
	 */
	private function perform_api_request() {

		$email = Sunny_Option::get_option( 'cloudflare_email' );
		$api_key = Sunny_Option::get_option( 'cloudflare_api_key' );
		$cf_api_helper = new Sunny_CloudFlare_API_Helper( $email, $api_key );

		$domain = Sunny_Helper::get_domain( get_option( 'siteurl' ) );
		$_cf_response = $cf_api_helper->rec_load_all( $domain );

		return $_cf_response;

	}

	/**
	 * @since     1.2.0
	 *
	 * @param     $_cf_response     The response after rec_load_all api call, could be WP Error object or HTTP return object.
	 *
	 * @return    $_return_arg      array of arguments for making json response / $_GET response
	 */
	private function check_connection_test_response( $_cf_response ) {

		$return_arg['result'] = 'connection_tester';

		if ( is_wp_error( $_cf_response ) ) {

			$return_arg['message'] = 'WP Error: ' . $_cf_response->get_error_message();

		}// end if //WP Error

		else {
			// API call made
			$_cf_response_array = json_decode( $_cf_response['body'], true );

			if ( 'error' == $_cf_response_array['result'] ) {

				$return_arg['message'] = 'Error: ' . $_cf_response_array['msg'];

			} else {

				$return_arg['message'] = 'Success';

				$domain = Sunny_Helper::get_domain( get_option( 'siteurl' ) );

				$dns_record_found = 'No';
				$service_mode_on = 'No';

				foreach( $_cf_response_array['response']['recs']['objs'] as $obj ){

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
				$return_arg['message'] .= $str_message;

			} // end else // apiconnection success

		}// end else // api connection

		return $return_arg;

	} // end check_connection_test_response

} // end class Sunny_Connection_Tester
