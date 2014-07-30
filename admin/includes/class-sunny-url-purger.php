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

        $this->register_settings();
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

    } elseif ( '' != $post_url && ! Sunny_Helper::url_match_site_domain( $post_url ) ) {

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

    /**
     * Register the CloudFlare account section, CloudFlare email field
     * and CloudFlare api key field
     *
     * @since     1.0.0
     */
    private function register_settings() {

        add_settings_section(
            'sunny_url_purger_section',     // ID used to identify this section and with which to register options
            NULL,                                   // Title to be displayed on the administration page
            array( $this, 'sunny_display_url_purger' ),    // Callback used to render the description of the section
           'sunny_url_purger_section'                     // Page on which to add this section of options
            );

        add_settings_field(
            'sunny_post_url',                   // ID used to identify the field throughout the theme
            __( 'Post URL', $this->plugin_slug ),          // The label to the left of the option interface element
            array( $this, 'sunny_render_form_html' ),   // The name of the function responsible for rendering the option interface
            'sunny_url_purger_section',                         // The page on which this option will be displayed
            'sunny_url_purger_section',         // The name of the section to which this field belongs
            array (
                'label_for' => 'sunny_post_url',
                'type'      => 'text',
                'value'     => 'http://example.com/hello-world/',
                'desc'      => __( 'The URL you want to purge.', $this->plugin_slug ),
                ) // The array of arguments to pass to the callback.
            );

    }// end Setting Registration

    /**
     * This function provides a simple description for the url purger section.
     *
     * @since 1.0.0
     */
    public function sunny_display_url_purger() {
        echo '<p>';
        _e( 'Purge a post and its related pages(e.g: categories, tags and archives) by URL.', $this->plugin_slug );
        echo '</p>';
    } // end sunny_display_cloudflare_account

    /**
     * This function provides a simple description for the Sunny Settings page.
     * It is passed as a parameter in the add_settings_field function.
     *
     * @param array     $args   from add_settings_field
     *
     * @since 1.2.0
     */
    public function sunny_render_form_html ( $args ) {

        $type   = $args[ 'type' ];
        $id     = $args[ 'label_for' ];
        $desc   = $args[ 'desc' ];
        $value  = $args[ 'value' ];

        // Render the output
        echo '<input type="' . $type .'" id="' . $id . '" name="' . $id . '" size="40" value="' . $value . '" /><br/>';
        echo '<span class="description">' . $desc . '</span>';

    } // end sunny_render_cloudflare_email_input_html

} //end Sunny_Test Class