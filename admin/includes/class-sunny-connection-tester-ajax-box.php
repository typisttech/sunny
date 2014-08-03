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

/**
 * This class handles the purger settings.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Sunny_Ajax_Box_Base', false ) ) {
	require_once( 'class-sunny-ajax-box-base.php' );
}

class Sunny_Connection_Tester_Ajax_Box extends Sunny_Ajax_Box_Base {

	protected function set_class_properties() {

		$this->option_group 		= 'sunny_connection_tester';

		$this->button_text          = __('Test Connection', $this->plugin_slug );

		$this->meta_box 			= array(
											'title'		=> __( 'Test Connection', $this->plugin_slug ),
											'context'	=> 'normal',
											);

	}

	/**
	 * This function provides a simple description for the url purger section.
	 *
	 * @since 1.2.0
	 */
	public function render_section() {

		echo '<p>';
			_e( "To check if Sunny can connect to CloudFlare's server", $this->plugin_slug );
		echo '</p>';

	}

}