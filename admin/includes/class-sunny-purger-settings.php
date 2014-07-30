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
 * This class handles the purger settings.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Sunny_Purger_Settings {
    /**
     * Instance of this class.
     *
     * @since    1.2.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Initialize the plugin by registrating settings
     *
     * @since     1.2.0
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
        $this->tab_slug = 'general_settings';

        $this->register_settings();
        $this->generate_meta_box();

    }

    /**
     * Return an instance of this class.
     *
     * @since     1.2.0
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
     *
     * @since     1.2.0
     */
    private function register_settings() {

        // First, we register a section. This is necessary since all future settingss must belong to one.
        add_settings_section(
            'sunny_purger_settings_section',     // ID used to identify this section and with which to register options
            NULL,                                // Title to be displayed on the administration page
            array( $this, 'sunny_display_purger_settings' ), // Callback used to render the description of the section
            'sunny_purger_settings_section'                  // Page on which to add this section of options
            );

        // Next, we will introduce the fields for CloudFlare Account info.
        add_settings_field(
            'purge_homepage',                   // ID used to identify the field throughout the theme
            __( 'Homepage', $this->plugin_slug ),          // The label to the left of the option interface element
            array( $this, 'sunny_render_form_html' ),   // The name of the function responsible for rendering the option interface
            'sunny_purger_settings_section',         // The page on which this option will be displayed
            'sunny_purger_settings_section',         // The name of the section to which this field belongs
            array (
                'label_for' => 'purge_homepage',
                'desc'      => __( 'Purge homepage whenever post updated.', $this->plugin_slug ),
                ) // The array of arguments to pass to the callback.
            );

        add_settings_field(
            'purge_associated',                   // ID used to identify the field throughout the theme
            __( 'Associated Pages', $this->plugin_slug ),          // The label to the left of the option interface element
            array( $this, 'sunny_render_form_html' ),   // The name of the function responsible for rendering the option interface
            'sunny_purger_settings_section',         // The page on which this option will be displayed
            'sunny_purger_settings_section',         // The name of the section to which this field belongs
            array (
                'label_for' => 'purge_associated',
                'desc'      => __( 'Purge associated pages(e.g.: tags, categories and custom taxonomies) whenever post updated.', $this->plugin_slug ),
                ) // The array of arguments to pass to the callback.
            );

        // Finally, we register the fields with WordPress
        register_setting(
            'sunny_purger_settings_section', // The settings group name. Must exist prior to the register_setting call.
            'sunny_purger_settings'           // The name of an option to sanitize and save.
            );

    }// end Setting Registration
    /* ------------------------------------------------------------------------ *
     * Section Callbacks
     * ------------------------------------------------------------------------ */

    /**
     *
     * @since 1.2.0
     */
    public function sunny_display_purger_settings() {
        echo '<p>';
        _e( 'The CloudFlare account associated to this site.', $this->plugin_slug );
        echo '</p>';
    } // end sunny_display_purger_settings

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

        $id     = $args[ 'label_for' ];
        $desc   = $args[ 'desc' ];
        $value  = $args[ 'value' ];

        // Render the output
        $options = get_option( 'sunny_purger_settings' );
        $html = '<input type="checkbox" id="' . $id . '" name="sunny_purger_settings[' . $id . ']" value="1"' . checked( 1, $options[ $id ], false ) . '/>';
        $html .= '<br /><span class="description">' . $desc . '</span>';
        echo $html;

    } // end sunny_render_cloudflare_email_input_html

    /**
     * Generate the meta box on options page.
     *
     * @since     1.2.0
     */
    private function generate_meta_box() {

        add_meta_box(
        'sunny_purger_settings', //Meta box ID
        __( 'Purger Settings', $this->plugin_slug ), //Meta box Title
        array( $this, 'render_meta_box' ), //Callback defining the plugin's innards
        $this->tab_slug, // Screen to which to add the meta box
        'normal' // Context
        );

    }

    /**
     * Print the meta box on options page.
     *
     * @since     1.2.0
     */
    public function render_meta_box() {
        require( $this->view_dir_path . '/partials/purger-settings.php' );

    }


} //end Sunny_Option Class
