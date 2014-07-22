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

/**
 * This class takes care the url purge process fired from the admin dashboard.
 *
 * @since 1.1.0
 */
class Sunny_URL_Purger {
    /**
     * Instance of this class.
     *
     * @since    1.1.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Initialize the class and add url purger callback
     *
     * @since     1.1.0
     */
    private function __construct() {
        add_action( 'admin_post_sunny_url_purge', array( $this, 'process_sunny_url_purger' ) );
    }

    /**
     * Return an instance of this class.
     *
     * @since     1.1.0
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
     * @since     1.1.0
     */
    public function process_sunny_url_purger() {
        // Check that user has proper secuity level
        if ( ! current_user_can( 'manage_options') ) {
            die( 'Not allowed');
        }

        // Check the nonce field
        check_admin_referer( 'sunny_url_purger', 'sunny_url_purger_nonce' );

        // Check user input
        if ( ! isset( $_REQUEST['post-url'] ) ) {
            die( 'Invalid Input!');
        }

        // It's safe to carry on
        // Prepare return message
        $msg = '';
        $links = array();

        $post_url = esc_url_raw( $_REQUEST['post-url'], array( 'http', 'https' ) );

        if ( !  Sunny_Helper::url_match_site_domain( $post_url ) && '' != $post_url ) {

            $msg = 'hostname-not-match';

        } elseif ( '' != $post_url  ) {

            $links = Sunny_Admin_Helper::get_all_terms_links_by_url( $post_url );

            // Add the input url at front
            array_unshift( $links, $post_url );

            foreach ( $links as $link ) {

                Sunny_Purger::purge_cloudflare_cache_by_url( $link );
                $msg .= $link . ',';

            }

        } else {

            $msg = 'error';

        }


        $plugin = Sunny::get_instance();
        $return_arg['page'] = $plugin->get_plugin_slug();

        $return_arg['url_purge_result'] = '1';
        $return_arg['msg'] = $msg;

        wp_redirect( add_query_arg( $return_arg, admin_url( 'options-general.php' ) ) );
        die;

    } // end process_connection_test

}