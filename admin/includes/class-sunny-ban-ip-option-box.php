<?php
/**
 * @package     Sunny
 * @subpackage  Sunny_Admin
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @license     GPL-2.0+
 * @link        http://tangrufus.com
 * @copyright   2014 Tang Rufus
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @since 		1.3.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Sunny_Option_Box_Base', false ) ) {
	require_once( 'class-sunny-option-box-base.php' );
}

class Sunny_Ban_Ip_Option_Box extends Sunny_Option_Box_Base {

	protected function set_class_properties() {

		$this->option_group 		= 'sunny_security';

		$this->button_text			= __('Save Security Settings', $this->plugin_slug );

		$this->meta_box 			= array(
											'title'		=> __( 'Security Settings', $this->plugin_slug ),
											'context'	=> 'normal',
											);

		$this->settings_fields[]	= array(
											'id'		=> 'ban_login_as_admin',
											'title'		=> __( 'Ban login as `Admin`', $this->plugin_slug ),
											'callback'	=> array( $this, 'checkbox' ),
											'args'		=> array (
																'id'		=> 'ban_login_as_admin',
																'label_for' => 'ban_login_as_admin',
																'desc'      => __( 'Blacklist IP which attempt to login with the username `Admin.', $this->plugin_slug ),
																),
											);

	} // end set_class_properties

	/**
	 * This function provides a simple description for the section.
	 * It is passed as a parameter in the add_settings_section function.
	 *
	 * @since     	1.2.0
	 */
	public function render_section() {

		echo '<p>';
			_e( 'Tell Sunny when to ban a bad IP.', $this->plugin_slug );
		echo '</p>';

	} // end render_section

} // end Sunny_Ban_Ip_Option_Box