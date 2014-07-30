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
     * Initialize the class and hook `Purge All` button callback
     *
     * @since     1.1.0
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

        add_action( 'wp_ajax_sunny-purge-url', array( $this, 'process_ajax' ) );
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
    public function process_ajax() {

        header('Content-Type: application/json');

        // Check that user has proper secuity level  && Check the nonce field
        if ( ! current_user_can( 'manage_options') ||
           ! wp_verify_nonce( $_POST['nonce'], 'sunny-purge-url' ) ) {

            $return_args = array(
                "result" => "Error",
                "message" => "403 Forbidden",
                );
        $response = json_encode( $return_args );
        echo $response;
        die;
    }


        // It's safe to carry on
        // Prepare return message
    $message = '';
    $links = array();

    $post_url = esc_url_raw( $_REQUEST['post-url'], array( 'http', 'https' ) );

    if ( '' == $post_url  ) {
        $message = 'Error: Invalid URL.';
    }

    if ( !  Sunny_Helper::url_match_site_domain( $post_url ) && '' != $post_url ) {

        $message = 'Error: This URL does not live in your domain.';

    } elseif ( '' != $post_url  ) {

        $links = Sunny_Admin_Helper::get_all_terms_links_by_url( $post_url );

                // Add the input url at front
        array_unshift( $links, $post_url );

        foreach ( $links as $link ) {
            $tmp_message = '';
            $_response = Sunny_Purger::purge_cloudflare_cache_by_url( $link );

            if ( is_wp_error( $_response ) ) {
                $tmp_message .= 'WP_Error: ';
            } // end wp error
            else {
                    // API made
                $_response_array = json_decode( $_response['body'], true );

                if ( 'error' == $_response_array['result'] ) {
                    $tmp_message .= 'API Error: ';
                } // end api returns error
                elseif ( 'success' == $_response_array['result'] ) {
                    $tmp_message .= 'Success: ';
                } // end api success //end elseif

                $tmp_message .= esc_url( $link );

                $message .= $tmp_message . '<br />';
            } // end else
        } // end foreach
    } // end elseif

    $return_args = array(
        "message" => $message,
        );
    $response = json_encode( $return_args );
    echo $response;
    die;
}

    /**
     * Generate the meta box on options page.
     *
     * @since     1.2.0
     */
    private function generate_meta_box() {

        add_meta_box(
        'sunny_url_purger', //Meta box ID
        __( 'URL Purger', $this->plugin_slug ), //Meta box Title
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
        require( $this->view_dir_path . '/partials/url-purger.php' );

    }

} //end Sunny_Test Class