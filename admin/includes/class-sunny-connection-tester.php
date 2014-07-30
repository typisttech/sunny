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
     * Initialize the class and hook `Purge All` button callback
     *
     * @since     1.0.4
     */
    private function __construct() {
        /*
         * Call $plugin_slug from public plugin class.
         */
        $plugin = Sunny::get_instance();
        $this->plugin_slug = $plugin->get_plugin_slug();

        /*
         * Call $view_dir_path from admin plugin class.
         */
        $admin = Sunny_Admin::get_instance();
        $this->view_dir_path = $admin->get_view_dir_path();

        $this->generate_meta_box();

        add_action( 'wp_ajax_sunny-test-connection', array( $this, 'process_ajax' ) );
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

    /**
     * @since     1.2.0
     */
    public function process_ajax() {

        header('Content-Type: application/json');

        // Check that user has proper secuity level  && Check the nonce field
        if ( ! current_user_can( 'manage_options') ||
         ! wp_verify_nonce( $_POST['nonce'], 'sunny-test-connection' ) ) {

            $return_args = array(
                "result" => "Error",
                "message" => "403 Forbidden",
                );
            $response = json_encode( $return_args );
            echo $response;
            die;
        }

        $plugin = Sunny::get_instance();
        $domain = $plugin->get_domain();

        $api_helper = CloudFlare_API_Helper::get_instance();
        $cf_response = $api_helper->rec_load_all( $domain );
        Sunny_API_Logger::write_report( $cf_response, 'Test_Connection' );
        $return_args = $this->check_response( $cf_response );
        $response = json_encode( $return_args  );

        // return json response
        echo $response;

        die;
    }

    /**
     * @since     1.2.0
     *
     * @param     $_response        The response after api call, could be WP Error object or HTTP return object.
     *
     * @return    $_return_arg      array of arguments for making json response
     */
    private function check_response( $_response ) {

        $return_arg['connection_test_result'] = '1';

        if ( is_wp_error( $_response ) ) {
            $return_arg['result'] = 'WP Error';
            $return_arg['message'] = $_response->get_error_messages();
        }// end WP Error
        else {
            // API call made
            $_response_array = json_decode( $_response['body'], true );

            if ( 'error' == $_response_array['result'] ) {
                $return_arg['result'] = 'Error';
                $return_arg['message'] = $_response_array['msg'];
            } else {
                $return_arg['result'] = 'Success';

                $domain = parse_url( site_url(), PHP_URL_HOST );

                $dns_record_found = 'No';
                $service_mode_on = 'No';

                foreach( $_response_array['response']['recs']['objs'] as $obj ){
                    if ( $obj['name'] == $domain ) {
                        $dns_match = true;
                        $dns_record_found = ( 'A' == $obj['type'] || 'AAAA' == $obj['type'] || 'CNAME' == $obj['type'] ) ? 'Yes' : 'No';
                        $service_mode_on = ( '1' == $obj['service_mode'] ) ? 'Yes' : 'No';
                        break;
                    }
                }

                $dns_match = ( true === $dns_match ) ? 'Yes' : 'No';

                $str_message = '<br />';
                $str_message .= 'DNS record for ' . $domain . ' found: ' . $dns_record_found . '<br />';
                $str_message .= 'Service mode turned on: ' . $service_mode_on . '<br />';
                $return_arg['message'] = $str_message;
        } // end connection success
        }// end api else

        return $return_arg;

    }

    /**
     * Generate the meta box on options page.
     *
     * @since     1.2.0
     */
    private function generate_meta_box() {

        add_meta_box(
        'sunny_connection_tester', //Meta box ID
        __( 'Connection Tester', $this->plugin_slug ), //Meta box Title
        array( $this, 'render_meta_box' ), //Callback defining the plugin's innards
        $this->plugin_slug, // Screen to which to add the meta box
        'normal' // Context
        );

    }

    /**
     * Print the meta box on options page.
     *
     * @since     1.2.0
     */
    public function render_meta_box() {
        require( $this->view_dir_path . '/partials/connection-tester.php' );

    }

} //end Sunny_Test Class