<?php
/**
 * @package     Sunny
 * @subpackage  Sunny_Admin
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @license     GPL-2.0+
 * @link        http://tangrufus.com
 * @copyright   2014 Tang Rufus
 * @author      Tang Rufus <tangrufus@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * This class handles the connection tester callback from settings page
 */
class Sunny_Connection_Tester {
    /**
     * Instance of this class.
     *
     * @since    1.0.4
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Initialize the class and purge after post saved
     *
     * @since     1.0.4
     */
    private function __construct() {
        add_action( 'admin_post_sunny_connection_test', array( $this, 'process_connection_test' ) );
    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.4
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {
        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function process_connection_test() {
        // Check that user has proper secuity level
        if ( !current_user_can( 'manage_options') ) {
            die( 'Not allowed');
        }

        //Check the nonce field
        check_admin_referer( 'sunny_test_connection', 'sunny_test_connection_nonce' );

        $plugin = Sunny::get_instance();
        $domain = $plugin->get_domain();

        $api_helper = CloudFlare_API_Helper::get_instance();
        $response = $api_helper->rec_load_all( $domain);

        Sunny_API_Logger::write_report( $response, 'Test_Connection' );

        $return_arg['connection_test_result'] = '1';

        if ( is_wp_error( $response ) ) {
            $return_arg['status'] = 'wp_error';
            $return_arg['message'] = str_replace( ' ', '%20', implode( '<br/>', $response->get_error_messages() ) );
        }// end WP Error
        else {
            // API call made
            $response_array = json_decode( $response['body'], true );

            if ( 'error' == $response_array['result'] ) {
             $return_arg['status'] = 'api_error';
             $return_arg['message'] = str_replace( ' ', '%20', $response_array['msg'] );
         } else {
            $return_arg['status'] = 'api_success';

            $domain = parse_url( site_url(), PHP_URL_HOST );
            $dns_match = false;

            foreach( $response_array['response']['recs']['objs'] as $obj ){
                if ( $obj['name'] == $domain ) {
                    $dns_match = true;
                    $return_arg['dns_record_found'] = ( 'A' == $obj['type'] || 'AAAA' == $obj['type'] || 'CNAME' == $obj['type'] ) ? '1' : '0';
                    $return_arg['service_mode_on'] = ( '1' == $obj['service_mode'] ) ? '1' : '0';
                    break;
                }
            }

            $return_arg['dns_match'] = ( true === $dns_match ) ? '1' : '0';
        } // end connection success
        }// end api else

        $return_arg['page'] = $plugin->get_plugin_slug();
        wp_redirect( add_query_arg( $return_arg, admin_url( 'options-general.php' ) ) );
        die;
    } // end process_connection_test

} //end Sunny_Test Class
