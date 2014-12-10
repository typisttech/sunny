<?php

/**
 *
 * @package    Sunny
 * @subpackage Sunny/admin/tools
 * @author     Tang Rufus <tangrufus@gmail.com>
 * @since  	   1.4.4
 */
class Sunny_Url_Purger {

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
	 * @since     1.4.4
	 *
	 * @return    $return_arg      array of arguments for making json response / $_GET response
	 */
	public function get_result() {

		// Prepare return message
		$message = '';
		$links = array();


		if ( !empty( $_POST["sunny_settings"]["post_url"] ) ) {
			// non ajax
			$raw_url = $_POST["sunny_settings"]["post_url"];
		} else if ( !empty( $_POST["post_url"] ) ) {
			// ajax
			$raw_url = $_POST['post_url'];
		} else {
			// unexpected
			$raw_url = '';
		}

		$post_url = esc_url_raw( $raw_url, array( 'http', 'https' ) );

		if ( '' == $post_url || $raw_url != $post_url ) {

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
			'result' => 'url_purger',
			'message'=> $message
			);

		return $return_args;

	} // end get result

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

	} // end check_url_purge_response

}
