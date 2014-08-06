<?php
/**
 * @package     Sunny
 * @subpackage  Sunny_API_Logger
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @license     GPL-2.0+
 * @link        http://tangrufus.com
 * @copyright   2014 Tang Rufus
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
     die;
}

/**
 * Helper class. Log API responses.
 */
class Sunny_API_Logger {
    /**
     * Log debug messages in php error log.
     *
     * @since     1.0.0
     *
     * @param     $response The response after api call, could be WP Error object or HTTP return object
     * @param     $url      The Url that API calls
     *
     * @return    void      No return
     */
	public static function write_report( $response, $url ) {

        if ( ! defined( 'WP_DEBUG' ) || WP_DEBUG == false ) {
            return;
        }

		if ( is_wp_error( $response ) ) {

			error_log( 'Sunny ' . 'WP Error ' . $response->get_error_message() .'--' . $url );

        }// end WP Error
        else {
            // API made
        	$response_array = json_decode( $response['body'], true );

        	if ( 'error' == $response_array['result'] ) {
        		error_log( 'Sunny ' . 'API Error ' . $response_array['msg'] .'--' . $url );
        	} else {
        		error_log( 'Sunny ' . 'API Success ' . $url );
        	}
        }
    }
}