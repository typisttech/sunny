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
 * This class handles the manual `purge all` request from settings page
 */
class Sunny_Zone_Purger {
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
        add_action( 'admin_post_sunny_zone_purge', array( $this, 'process_sunny_zone_purger' ) );
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
     * @since     1.0.0
     *
     * @return    void      This function has no return.
     */
    public function process_sunny_zone_purger() {
        // Check that user has proper secuity level
        if ( ! current_user_can( 'manage_options') ) {
            die( 'Not allowed');
        }

        //Check the nonce field
        check_admin_referer( 'sunny_zone_purger', 'sunny_zone_purger_nonce' );

        $response = Sunny_Purger::purge_cloudflare_cache_all();
        $return_arg = $this->check_response( $response );

        $plugin = Sunny::get_instance();
        $return_arg['page'] = $plugin->get_plugin_slug();

        wp_redirect( add_query_arg( $return_arg, admin_url( 'options-general.php' ) ) );
        die;
    } // end process_connection_test

    /**
     * @since     1.0.0
     *
     * @param     $_response        The response after api call, could be WP Error object or HTTP return object.
     *
     * @return    $_return_arg      array of arguments for making redirect url
     */
    private function check_response( $_response ) {
        $_return_arg['zone_purge_result'] = '1';
        if ( is_wp_error( $_response ) ) {
            $_return_arg['result'] = 'WP_Error';
            $_return_arg['message'] = str_replace( ' ', '%20', implode( '<br/>', $_response->get_error_messages() ) );
        }// end wp error
        else {
            // API made
            $_response_array = json_decode( $_response['body'], true );

            if ( 'error' == $_response_array['result'] ) {
                $_return_arg['result'] = 'Error';
                $_return_arg['message'] = str_replace( ' ', '%20', $_response_array['msg'] );
            }
            elseif ( 'success' == $_response_array['result'] ) {
                $_return_arg['result'] = 'Success';
                $_return_arg['message'] = str_replace( ' ', '%20', 'All cache has been purged.' );
            } // end connection success
        }
        return $_return_arg;
    }
} //end Sunny_Test Class