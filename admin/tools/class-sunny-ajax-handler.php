<?php

/**
 *
 * @package    Sunny
 * @subpackage Sunny/admin/settings
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
	 * @var      string    $version    The version of this plugin.
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

		header('Content-Type: application/json');

		// Check that user has proper secuity level && Check the nonce field && Check refer from Tools tab
		if ( current_user_can( 'manage_options') && check_ajax_referer( 'sunny_tools_' . $id . '-options', '_nonce', false ) && ! empty( $_POST['_wp_http_referer'] ) && isset( $_POST['_wp_http_referer'] ) ) {

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
		$response = json_encode( $return_args );
		echo $response;

		die;

	} // end secuity_check

	/**
	 * @since     1.2.0
	 */
	public function process_connection_test() {

		if ( ! $this->secuity_check( 'connection_tester' ) ) {

			die;

		}

		$email = Sunny_Option::get_option( 'cloudflare_email' );
		$api_key = Sunny_Option::get_option( 'cloudflare_api_key' );
		$cf_api_helper = new Sunny_CloudFlare_API_Helper( $email, $api_key );

		$domain = Sunny_Helper::get_domain( get_option( 'home' ) );
		$cf_response = $cf_api_helper->rec_load_all( $domain );

		$return_args = $this->check_connection_test_response( $cf_response );
		$response = json_encode( $return_args  );

		// return json response
		echo $response;

		die;

	} // process_connection_test

	 /**
	 * @since     1.2.0
	 *
	 * @param     $_response        The response after api call, could be WP Error object or HTTP return object.
	 *
	 * @return    $_return_arg      array of arguments for making json response
	 */
	 private function check_connection_test_response( $_response ) {

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

				$domain = parse_url( get_option( 'home' ), PHP_URL_HOST );

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

	} // end check_connection_test_response

	/**
	 * @since     1.2.0
	 */
	public function process_url_purge() {

		$this->secuity_check( 'url_purger' );

		// It's safe to carry on
		// Prepare return message
		$message = '';
		$links = array();

		$post_url = esc_url_raw( $_REQUEST['post_url'], array( 'http', 'https' ) );

		if ( '' == $post_url || $_REQUEST['post_url'] != $post_url ) {

			$message = 'Error: Invalid URL.';

		} elseif ( '' != $post_url && ! Sunny_Helper::url_match_site_domain( $post_url ) ) {

			$message = 'Error: This URL does not live in your domain.';

		} elseif ( '' != $post_url  ) {

			$links = Sunny_Helper::get_all_terms_links_by_url( $post_url );

			// Add the input url at front
			array_unshift( $links, $post_url );

			foreach ( $links as $link ) {

				$_response = Sunny_Purger::purge_cloudflare_cache_by_url( $link );
				$message .= $this->check_url_purge_response( $_response ) . ' - ' . esc_url( $link ) . '<br />';

			} // end foreach

		} // end elseif

		$return_args = array(
			'message' => $message,
			);
		$response = json_encode( $return_args );
		echo $response;

		die;

	} // end process_ajax

	/**
	 *
	 * @since  1.3.0
	 */
	private function check_url_purge_response( $_response ) {

		$message = '';

		if ( is_wp_error( $_response ) ) {

			$message .= 'WP Error: ' . $_response->get_error_message();

		} // end wp error
		else {

			// API made
			$_response_array = json_decode( $_response['body'], true );

			if ( 'error' == $_response_array['result'] ) {

				$message .= 'API Error: ' . $_response_array['msg'];

			} // end api returns error
			elseif ( 'success' == $_response_array['result'] ) {

				$message .= 'Success: ';

			} // end api success //end elseif

		} // end else

		return $message;

	}


	/**
	 * @since     1.2.0
	 */
	public function process_zone_purge() {

		$this->secuity_check( 'zone_purger' );

		$cf_response = Sunny_Purger::purge_cloudflare_cache_all();
		$return_args = $this->check_zone_purge_response( $cf_response );
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
	private function check_zone_purge_response( $_response ) {

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


} //end Sunny_URL_Purger_Ajax_Handler