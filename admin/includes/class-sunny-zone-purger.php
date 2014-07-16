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
 * @package Sunny_Zone_Purger
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

class Sunny_Zone_Purger {

    /**
     *
     * @since     1.0.0
     *
     * @param     $_response        The response after api call, could be WP Error object or HTTP return object.
     *
     * @return    $_return_arg      array of arguments for making redirect url
     */
    private static function check_response( $_response ) {
        $_return_arg['zone_purge_result'] = '1';
        if ( is_wp_error( $_response ) ) {
            $_return_arg['result'] = 'WP_Error';
            $_return_arg['message'] = str_replace( " ", "%20", implode( "<br/>", $_response->get_error_messages() ) );
        }// end wp error
        else { // api
            $_response_array = json_decode( $_response['body'], true );

            if ( $_response_array['result'] == 'error' ) {
                $_return_arg['result'] = 'Error';
                $_return_arg['message'] = str_replace( " ", "%20", $_response_array['msg'] );
            }
            else if ( $_response_array['result'] == 'success' ) {
                $_return_arg['result'] = 'Success';
                $_return_arg['message'] = str_replace( " ", "%20", 'All cache has been purged.' );

            } // end connection success
        }
        return $_return_arg;
    }

    public static function process_sunny_zone_purger() {
        // Check that user has proper secuity level
        if ( !current_user_can( 'manage_options') ) {
            die( 'Not allowed');
        }

        //Check the nonce field
        check_admin_referer( 'sunny_zone_purger', 'sunny_zone_purger_nonce' );

        $response = Sunny_Purger::purge_cloudflare_cache_all();
        $return_arg = self::check_response( $response );

        $plugin = Sunny::get_instance();
        $return_arg['page'] = $plugin->get_plugin_slug();
        wp_redirect( add_query_arg( $return_arg, admin_url( 'options-general.php' ) ) );
        die;
    } // end process_connection_test

} //end Sunny_Test Class
