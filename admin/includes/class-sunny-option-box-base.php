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

if ( ! class_exists( 'Sunny_Box_Base', false ) ) {
	require_once( 'class-sunny-box-base.php' );
}

abstract class Sunny_Option_Box_Base extends Sunny_Box_Base {

	/**
	 * @since     1.2.0
	 */
	public function register_settings() {

		Parent::register_settings();

		// Finally, we register the fields with WordPress ( if not ajax )
		register_setting(
				$this->option_group, 				// The settings group name. Must exist prior to the register_setting call.
				$this->option_group,           		// The name of an option to sanitize and save.
				array( $this, 'validate_section' )	// A callback function that sanitizes the option's value.
				);

	}

	/**
	 * @since 		1.2.0
	 */
	public function validate_section( $input ){

		return $input;

	}

	/**
	 * Print the meta box on options page.
	 *
	 * @since     1.2.0
	 */
	public function render_meta_box() {

		require( $this->view_dir_path . '/partials/option-box.php' );

	}

} //end Sunny_Option_Box_Base