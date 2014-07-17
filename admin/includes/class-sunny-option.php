<?php

/**
 *
 * @package     Sunny
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @license     GPL-2.0+
 * @link        http://tangrufus.com
 * @copyright   2014 Tang Rufus
 * @subpackage  Sunny_Option
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

        // Register Settings
        $this->register_settings();
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

    private function register_settings() {

        // First, we register a section. This is necessary since all future settingss must belong to one.
        add_settings_section(
            'sunny_cloudflare_account_section',     // ID used to identify this section and with which to register options
            'CloudFlare Account',                   // Title to be displayed on the administration page
            array( $this, 'sunny_display_cloudflare_account' ),    // Callback used to render the description of the section
            $this->plugin_slug                      // Page on which to add this section of options
            );

        // Next, we will introduce the fields for CloudFlare Account info.
        add_settings_field(
            'sunny_cloudflare_email',                   // ID used to identify the field throughout the theme
            'Email',                                    // The label to the left of the option interface element
            array( $this, 'sunny_render_cloudflare_email_input_html' ),    // The name of the function responsible for rendering the option interface
            $this->plugin_slug,                         // The page on which this option will be displayed
            'sunny_cloudflare_account_section',         // The name of the section to which this field belongs
            array(                    // The array of arguments to pass to the callback. In this case, just a description.
                'The e-mail address associated with the CloudFlare account.'
                )
            );

        add_settings_field(
            'sunny_cloudflare_api_key',
            'API Key',
            array( $this, 'sunny_render_cloudflare_api_key_input_html' ),
            $this->plugin_slug,
            'sunny_cloudflare_account_section',
            array(
                'This is the API key made available on your <a href="https://www.cloudflare.com/my-account.html">CloudFlare Account</a> page.'
                )
            );

        // Finally, we register the fields with WordPress
        register_setting(
            'sunny_cloudflare_account_section',     // The settings group name. Must exist prior to the register_setting call.
            'sunny_cloudflare_email',     // The name of an option to sanitize and save.
            array( $this, 'sunny_validate_input_cloudflare_email' )
            );

        register_setting(
            'sunny_cloudflare_account_section',     // The settings group name. Must exist prior to the register_setting call.
            'sunny_cloudflare_api_key',     // The name of an option to sanitize and save.
            array( $this, 'sunny_validate_input_cloudflare_api_key' )
            );

    }// end Setting Registration
    /* ------------------------------------------------------------------------ *
     * Section Callbacks
     * ------------------------------------------------------------------------ */

    /**
     * This function provides a simple description for the Sunny Settings page.
     *
     * It is called from the 'sunny_initialize_plugin_settings' function by being passed as a parameter
     * in the add_settings_section function.
     */
    public function sunny_display_cloudflare_account() {
        echo '<p>Sunny purges CloudFlare cache when post updated.</p>';
    } // end sunny_display_cloudflare_account

    /* ------------------------------------------------------------------------ *
     * Field Callbacks
     * ------------------------------------------------------------------------ */

    public function sunny_render_cloudflare_email_input_html($args) {

        // First, we read the option from db
        $plugin = Sunny::get_instance();
        $sunny_cloudflare_email = $plugin->get_cloudflare_email();

        // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
        // Render the output
        echo '<input type="text" id="sunny_input_cloudflare_email" name="sunny_cloudflare_email" size="40" value="' . $sunny_cloudflare_email . '" />';

    } // end sunny_render_cloudflare_email_input_html

    public function sunny_render_cloudflare_api_key_input_html($args) {
        $plugin = Sunny::get_instance();
        $sunny_cloudflare_api_key = $plugin->get_cloudflare_api_key();

        // Render the output
        echo '<input type="text" id="sunny_input_cloudflare_api_key" name="sunny_cloudflare_api_key" size="40" value="' . $sunny_cloudflare_api_key . '" />';

    } // end sunny_render_cloudflare_api_key_input_html

    /* ------------------------------------------------------------------------ *
     * Setting Callbacks
     * ------------------------------------------------------------------------ */

    /**
     * Sanitization callback for the social options. Since each of the social options are text inputs,
     * this function loops through the incoming option and strips all tags and slashes from the value
     * before serializing it.
     *
     * @params  $input  The unsanitized collection of options.
     *
     * @returns         The collection of sanitized values.
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

        // Return the array processing any additional functions filtered by this action
        return apply_filters( 'sunny_before_save_cloudflare_email', $output, $input );

    } //end sunny_validate_input_cloudflare_email

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


        // Return the array processing any additional functions filtered by this action
        return apply_filters( 'after_sunny_validate_input_cloudflare_api_key', $output, $input );

    } // end sunny_validate_input_cloudflare_api_key

} //end Sunny_Option Class
