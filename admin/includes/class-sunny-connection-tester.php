<?php

/**
 *
 * @package   Sunny_Admin
 * @author    Tang Rufus <tangrufus@gmail.com>
 * @license   GPL-2.0+
 * @link      http://tangrufus.com
 * @copyright 2014 Tang Rufus
 */

/**
 * @package Sunny_Connection_Tester
 * @author  Tang Rufus <tangrufus@gmail.com>
 */

/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */

/**
 * Initializes the plugin options page by registering the Sections,
 * Fields, and Settings.
 *
 * This file should be registered with the 'admin_init' hook in Sunny_Admin class
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Sunny_Connection_Tester {

    public static function process_connection_test() {
        // Check that user has proper secuity level
        if ( !current_user_can( 'manage_options') ) {
            die( 'Not allowed');
        }

        //Check the nonce field
        check_admin_referer( 'sunny_test_connection', 'sunny_test_connection_nonce' );

        $plugin = Sunny::get_instance();
        $domain = $plugin->get_domain();

        $api_call = CloudFlare_API_Helper::get_instance();
        $response = $api_call->rec_load_all( $domain);


        Sunny_API_Debugger::write_report( $response, 'Test_Connection' );


        $return_arg['connection_test_result'] = '1';


        if ( is_wp_error( $response ) ) {
            $return_arg['status'] = 'wp_error';
            $return_arg['message'] = str_replace( " ", "%20", implode( "<br/>", $response->get_error_messages() ) );

        }// end WP Error
        else { // api
            $response_array = json_decode( $response['body'], true );

            if ( $response_array['result'] == 'error' ) {
               $return_arg['status'] = 'api_error';
               $return_arg['message'] = str_replace( " ", "%20", $response_array['msg'] );
           } else {
                $return_arg['status'] = 'api_success';

                $domain = parse_url( site_url(), PHP_URL_HOST );
                $dns_match = false;

                foreach( $response_array['response']['recs']['objs'] as $obj ){
                    if ( $obj['name'] == $domain ) {
                        $dns_match = true;
                        $return_arg['dns_record_found'] = ( $obj['type'] == 'A' || $obj['type'] == 'AAAA' || $obj['type'] == 'CNAME' ) ? '1' : '0';
                        $return_arg['service_mode_on'] = ( $obj['service_mode'] == '1' ) ? '1' : '0';
                        break;
                    }
                }

                $return_arg['dns_match'] = ( $dns_match === true ) ? '1' : '0';

        } // end connection success

        }// end api else

    $return_arg['page'] = $plugin->get_plugin_slug();
    wp_redirect( add_query_arg( $return_arg, admin_url( 'options-general.php' ) ) );
    die;
    } // end process_connection_test

} //end Sunny_Test Class
