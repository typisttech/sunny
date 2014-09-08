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
	private function ajax_secuity_check( $id ) {

		// Check that user has proper secuity level && Check the nonce field && Check refer from Tools tab
		if ( current_user_can( 'manage_options') && check_ajax_referer( 'sunny_tools_' . $id . '-options', '_nonce', false ) && !empty( $_POST['_wp_http_referer'] ) && isset( $_POST['_wp_http_referer'] ) ) {

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

	} // end ajax_secuity_check

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

	}

	/**
	 * @since     1.2.0
	 */
	public function process_ajax_connection_test() {

		$this->ajax_secuity_check( 'connection_tester' );

		$connection_tester = new Sunny_Connection_Tester( $this->name );
		$return_args = $connection_tester->get_result();

		$this->send_JSON_response( $return_args );
		die;

	} // process_ajax_connection_test



	/**
	 * @since     1.2.0
	 */
	public function process_ajax_url_purge() {

		$this->ajax_secuity_check( 'url_purger' );

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

	} // end process_ajax_ajax

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
	public function process_ajax_zone_purge() {

		$this->ajax_secuity_check( 'zone_purger' );

		$cf_response = Sunny_Purger::purge_cloudflare_cache_all();
		$return_args = $this->check_zone_purge_response( $cf_response );
		$response = json_encode( $return_args  );

		// return json response
		echo $response;

		die;

	} // end process_ajax_ajax

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