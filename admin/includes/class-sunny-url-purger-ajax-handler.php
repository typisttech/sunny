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
 * This class handles the url purger ajax requests.
 */
class Sunny_URL_Purger_Ajax_Handler extends Sunny_Ajax_Handler_Base {

	/**
	 * @since     1.2.0
	 */
	public function process_ajax() {

		header('Content-Type: application/json');

		// Check that user has proper secuity level  && Check the nonce field
		if ( ! current_user_can( 'manage_options') || ! check_ajax_referer( 'sunny_url_purger', 'nonce', false ) ) {

			$return_args = array(
								"result" => "Error",
								"message" => "403 Forbidden",
								);
			$response = json_encode( $return_args );
			echo $response;

			die;

		}

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

			$links = Sunny_Admin_Helper::get_all_terms_links_by_url( $post_url );

			// Add the input url at front
			array_unshift( $links, $post_url );

			foreach ( $links as $link ) {

				$tmp_message = '';
				$_response = Sunny_Purger::purge_cloudflare_cache_by_url( $link );

				if ( is_wp_error( $_response ) ) {

					$tmp_message .= 'WP Error: ';

				} // end wp error
				else {

					// API made
					$_response_array = json_decode( $_response['body'], true );

					if ( 'error' == $_response_array['result'] ) {

						$tmp_message .= 'API Error: ';

					} // end api returns error
					elseif ( 'success' == $_response_array['result'] ) {

						$tmp_message .= 'Success: ';

					} // end api success //end elseif

					$tmp_message .= esc_url( $link );

					$message .= $tmp_message . '<br />';

				} // end else

			} // end foreach

		} // end elseif

		$return_args = array(
							'message' => $message,
							);
		$response = json_encode( $return_args );
		echo $response;

		die;

	} // end process_ajax

} //end Sunny_URL_Purger_Ajax_Handler