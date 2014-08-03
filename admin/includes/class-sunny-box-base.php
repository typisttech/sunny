<?php
/**
 * @package     Sunny
 * @subpackage  Sunny_Admin
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @license     GPL-2.0+
 * @link        http://tangrufus.com
 * @copyright   2014 Tang Rufus
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @since 		1.2.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

abstract class Sunny_Box_Base {

	// Admin Properties
	protected $plugin_slug		= null;
	protected $view_dir_path 	= null;
	protected $tab_slug 		= null;

	// Class Properties
	protected $option_group 	= null;
	protected $button_text		= null;
	protected $button_type		= 'primary';
	protected $meta_box 		= array();
	protected $settings_fields 	= array();

	/**
	 * Subclass should overide this function to set necessary information
	 * about the settings section, settings fields, and meta box properties.
	 *
	 * These properties must be set: -
	 * $option_group
	 * $button_text
	 * $button_type (optional)
	 * $meta_box
	 * $settings_fields (optional)
	 *
	 * @since     1.2.0
	 */
	abstract protected function set_class_properties();

	/**
	 * Print the meta box on options page.
	 *
	 * @since     1.2.0
	 */
	abstract function render_meta_box();

	/**
	 * @since     1.2.0
	 */
	public function __construct( Sunny_Admin $admin, $tab_slug ) {

		$this->set_admin_properties( $admin, $tab_slug );
		$this->set_class_properties();

	} // end __construct

	/**
	 * @since     1.2.0
	 */
	private function set_admin_properties( Sunny_Admin $admin, $tab_slug ) {

		$this->plugin_slug = $admin->get_plugin_slug();
		$this->view_dir_path = $admin->get_view_dir_path();
		$this->tab_slug = $tab_slug;

	} // end set_admin_properties

	/**
	 * @since     1.2.0
	 */
	public function register_settings() {

		/**
		 * First, we register a section. This is necessary since all future settings must belong to one.
		 * Each section represents an array stored in the database.
		 */
		add_settings_section(
				$this->option_group,      			// ID used to identify this section and with which to register options
				null,                               // Title to be displayed on the administration page
				array( $this, 'render_section' ),	// Callback used to render the description of the section
				$this->option_group 				// Page on which to add this section of options
				);

		// Then, we register all fields. Each field represents an element in the array.
		foreach ( $this->settings_fields as $settings_field ) {

			add_settings_field(
					$settings_field['id'],      	// ID used to identify the field throughout the theme
					$settings_field['title'],       // The label to the left of the option interface element
					$settings_field['callback'],   	// The name of the function responsible for rendering the option interface
					$this->option_group,  			// The page on which this option will be displayed
					$this->option_group,  			// The name of the section to which this field belongs
					$settings_field['args']			// The array of arguments to pass to the callback.
					);

		} // end foreach

	} // end register_settings

	/**
	 * This function provides a simple description for the section.
	 * It is passed as a parameter in the add_settings_section function.
	 *
	 * @since     	1.2.0
	 */
	public function render_section() {

		// Do nothing
		return;

	} // end render_section

	/* ------------------------------------------------------------------------ *
	 * Setting Callbacks
	 * ------------------------------------------------------------------------ */
	/**
	 * This function provides a simple description for the Sunny Settings page.
	 * It is passed as a parameter in the add_settings_field function.
	 *
	 * Create a Text input field
	 *
	 * @since 		1.2.0
	 */
	public function text( $args ) {

		if ( is_array( $args ) ) {

			foreach( $args as $key => $val ) {

				${$key} = $val;

			} // end foreach

		} // end if

		$_size = ( ! empty( $size ) ) ? "size='$size'" : null;

		// Render the output
		echo "<input type='$type' id='$id' name='$this->option_group[$id]' value='$value' $_size ><br/>";
		echo "<span class='description'>$desc</span>";

	} //end text

	/**
	 *
	 * Create a Checkbox input field
	 *
	 * @since 		1.2.0
	 */
	public function checkbox( $args ) {

		if ( is_array( $args ) ) {

			foreach( $args as $key => $value ) {

				${$key} = $value;

			} // end foreach

		} // end if

		$options = get_option( $this->option_group );

		$checked = ( isset( $options[$id] ) && '1' == $options[$id] ) ? true : false;

		echo "<input type='checkbox' id='$id' name='$this->option_group[$id]' value='1' " . checked( $checked, true, false ) . " ><br />";
		echo "<span class='description'>$desc</span>";

	} // end checkbox

	/**
	 * Generate the meta box on options page.
	 *
	 * @since     1.2.0
	 */
	public function generate_meta_box() {

		add_meta_box(
				$this->option_group,              	// Meta box ID
				$this->meta_box['title'],           // Meta box Title
				array( $this, 'render_meta_box' ),  // Callback defining the plugin's innards
				$this->tab_slug,                    // Screen to which to add the meta box
				$this->meta_box['context']         	// Context
				);

	} // end generate_meta_box

} //end Sunny_Box_Base