<?php
/**
 * @package     Sunny
 * @subpackage  Sunny_Admin
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @license     GPL-2.0+
 * @link        http://tangrufus.com
 * @copyright   2014 Tang Rufus
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @since 1.2.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Sunny_Option_Box_Base', false ) ) {
	require_once( 'class-sunny-option-box-base.php' );
}

class Sunny_Admin_Bar_Option_Box extends Sunny_Option_Box_Base {

	protected function set_class_properties() {

		$this->option_group 		= 'sunny_admin_bar';

		$this->button_text			= __('Save Admin Bar Settings', $this->plugin_slug );

		$this->meta_box 			= array(
											'title'		=> __( 'Admin Bar Settings', $this->plugin_slug ),
											'context'	=> 'normal',
											);

		$this->settings_fields[]	= array(
											'id'		=> 'show',
											'title'		=> __( 'Hide Admin Bar', $this->plugin_slug ),
											'callback'	=> array( $this, 'checkbox' ),
											'args'		=> array (
																'id'		=> 'show',
																'label_for' => 'show',
																'desc'      => __( 'Hide admin bar on public-facing pages.', $this->plugin_slug ),
																),
											);

	}

	/**
     * This function provides a simple description for the section.
     * It is passed as a parameter in the add_settings_section function.
     *
	 * @since     	1.2.0
	 */
	public function render_section() {

		echo '<p>';
			_e( 'If you have set a `Cache Everything` Page Rule, you want to hide the admin bar in case of CloudFlare caching it for the public.', $this->plugin_slug );
		echo '</p>';

	}

}