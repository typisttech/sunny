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

class Sunny_Option {
    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Initialize the plugin by registrating settings
     *
     * @since     1.0.0
     */
    private function __construct() {

        /*
         * @TODO :
         *
         * - Uncomment following lines if the admin class should only be available for super admins
         */
        /* if( ! is_super_admin() ) {
            return;
        } */

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

    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

        /*
         * @TODO :
         *
         * - Uncomment following lines if the admin class should only be available for super admins
         */
        /* if( ! is_super_admin() ) {
            return;
        } */

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Register the CloudFlare account section, CloudFlare email field
     * and CloudFlare api key field
     *
     * @since     1.0.0
     */
    private function register_settings() {

        // First, we register a section. This is necessary since all future settingss must belong to one.
        add_settings_section(
            'sunny_cloudflare_account_section',     // ID used to identify this section and with which to register options
            NULL,                                   // Title to be displayed on the administration page
            array( $this, 'sunny_display_cloudflare_account' ),    // Callback used to render the description of the section
            $this->plugin_slug                      // Page on which to add this section of options
            );

        // Next, we will introduce the fields for CloudFlare Account info.
        add_settings_field(
            'sunny_cloudflare_email',                   // ID used to identify the field throughout the theme
            __( 'Email', $this->plugin_slug ),          // The label to the left of the option interface element
            array( $this, 'sunny_render_form_html' ),   // The name of the function responsible for rendering the option interface
            $this->plugin_slug,                         // The page on which this option will be displayed
            'sunny_cloudflare_account_section',         // The name of the section to which this field belongs
            array (
                'label_for' => 'sunny_cloudflare_email',
                'type'      => 'text',
                'value'     => Sunny::get_instance()->get_cloudflare_email(),
                'desc'      => __( 'The e-mail address associated with the CloudFlare account.', $this->plugin_slug ),
                ) // The array of arguments to pass to the callback.
            );

        add_settings_field(
            'sunny_cloudflare_api_key',
            __( 'API Key', $this->plugin_slug ),
            array( $this, 'sunny_render_form_html' ),
            $this->plugin_slug,
            'sunny_cloudflare_account_section',
                        array (
                'label_for' => 'sunny_cloudflare_api_key',
                'type'      => 'text',
                'value'     => Sunny::get_instance()->get_cloudflare_api_key(),
                'desc'      => __( 'This is the API key made available on your <a href="https://www.cloudflare.com/my-account.html">CloudFlare Account</a> page.', $this->plugin_slug )

                ) // The array of arguments to pass to the callback.
            );

        // Finally, we register the fields with WordPress
        register_setting(
            'sunny_cloudflare_account_section',     // The settings group name. Must exist prior to the register_setting call.
            'sunny_cloudflare_email',     // The name of an option to sanitize and save.
            array( $this, 'sunny_validate_input_cloudflare_email' )
            );

        register_setting(
            'sunny_cloudflare_account_section',
            'sunny_cloudflare_api_key',
            array( $this, 'sunny_validate_input_cloudflare_api_key' )
            );

    }// end Setting Registration
    /* ------------------------------------------------------------------------ *
     * Section Callbacks
     * ------------------------------------------------------------------------ */

    /**
     * This function provides a simple description for the Sunny Settings page.
     * It is passed as a parameter in the add_settings_section function.
     *
     * @since 1.0.0
     */
    public function sunny_display_cloudflare_account() {
        echo '<p>';
        _e( 'Sunny purges CloudFlare cache when post updated.', $this->plugin_slug );
        echo '</p>';
    } // end sunny_display_cloudflare_account

    /* ------------------------------------------------------------------------ *
     * Field Callbacks
     * ------------------------------------------------------------------------ */
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

    /* ------------------------------------------------------------------------ *
     * Setting Callbacks
     * ------------------------------------------------------------------------ */

    /**
     * Sanitization callback for the email option.
     * Use is_email for Sanitization
     *
     * @param  $input  The email user inputed
     *
     * @return         The sanitized email.
     *
     * @since 1.0.0
     */
    public function sunny_validate_input_cloudflare_email ( $input ) {
        // Get old value from DB
        $plugin = Sunny::get_instance();
        $sunny_cloudflare_email = $plugin->get_cloudflare_email();

        // Don't trust users
        $input = sanitize_email( $input );

        if ( !empty( $input ) || is_email( $input ) ) {
            $output = $input;
        }
        else
            add_settings_error( 'sunny_cloudflare_account_section', 'invalid-email', __( 'You have entered an invalid email.', $this->plugin_slug ) );

        return apply_filters( 'sunny_before_save_cloudflare_email', $output, $input );

    } //end sunny_validate_input_cloudflare_email


    /**
     * Sanitization callback for the email option.
     * Use is_email for Sanitization
     *
     * @param  $input  The api key user inputed
     *
     * @return         The sanitized api key.
     *
     * @since 1.0.0
     */
    public function sunny_validate_input_cloudflare_api_key( $input ) {
        // Get old value
        $plugin = Sunny::get_instance();
        $output = $plugin->get_cloudflare_api_key();

        // Don't trust users
        // Strip all HTML and PHP tags and properly handle quoted strings
        $input = Sunny_Helper::sanitize_alphanumeric( $input );
        if( !empty( $input ) ) {
            $output = $input;
        }
        else
            add_settings_error( 'sunny_cloudflare_account_section', 'invalid-api-key', __( 'You have entered an invalid API key.', $this->plugin_slug ) );

        return apply_filters( 'after_sunny_validate_input_cloudflare_api_key', $output, $input );

    } // end sunny_validate_input_cloudflare_api_key

    /**
     * Generate the meta box on options page.
     *
     * @since     1.2.0
     */
    private function generate_meta_box() {

        add_meta_box(
        'sunny_cloudflare_account', //Meta box ID
        __( 'CloudFlare Account', $this->plugin_slug ), //Meta box Title
        array( $this, 'render_meta_box' ), //Callback defining the plugin's innards
        $this->plugin_slug, // Screen to which to add the meta box
        'advanced' // Context
        );

    }

    /**
     * Print the meta box on options page.
     *
     * @since     1.2.0
     */
    public function render_meta_box() {
        require( $this->view_dir_path . '/partials/settings.php' );

    }


} //end Sunny_Option Class
