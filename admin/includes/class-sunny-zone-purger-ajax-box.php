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

class Sunny_Zone_Purger_Ajax_Box extends Sunny_Ajax_Box_Base {

	protected function set_class_properties() {

		$this->option_group 		= 'sunny_zone_purger';

		$this->button_text          = __('Purge All Files', $this->plugin_slug );

		$this->meta_box 			= array(
											'title'		=> __( 'Zone Purger', $this->plugin_slug ),
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
			_e( "Clear CloudFlare's cache. <br />This function will purge CloudFlare of any cached files. It may take up to 48 hours for the cache to rebuild and optimum performance to be achieved so this function should be used sparingly.", $this->plugin_slug );
		echo '</p>';

	}

}