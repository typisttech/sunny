<?php

class Sunny_API_Debugger {
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