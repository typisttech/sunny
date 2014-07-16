<?php
/**
 *
 * @package   Sunny
 * @author    Tang Rufus <tangrufus@gmail.com>
 * @license   GPL-2.0+
 * @link      http://tangrufus.com
 * @copyright 2014 Tang Rufus
 */

/**
 * Helper class. Logging API calls.
 *
 * @package Sunny_API_Debugger
 * @author  Tang Rufus <tangrufus@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
     die;
}

class Sunny_API_Debugger {
    /**
     *
     * @since     1.0.0
     *
     * @param     $response The response after api call, could be WP Error object or HTTP return object.
     *
     * @param     $url      The Url that API calls.
     *
     * @return    void      No return
     */
	public static function write_report( $response, $url ) {
		if ( is_wp_error( $response ) ) {
			error_log( 'Sunny-' . 'WP_Error-' . $url );
        }// end WP Error
        else { // api
        	$response_array = json_decode( $response['body'], true );

        	if ( $response_array['result'] == 'error' ) {
        		error_log( 'Sunny-' . 'API_Error-' . $response_array['msg'] .'-' . $url );
        	} else {
        		error_log( 'Sunny-' . 'API_Success-' . $url );
        	}
        }
    }

    public static function write_triggered_report( $_report ) {
        error_log( 'Sunny-' . 'Triggered-' . $_report );
    }
}