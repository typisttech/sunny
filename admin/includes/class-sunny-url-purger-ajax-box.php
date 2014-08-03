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
 * This class handles the url purger ajax requests.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Sunny_Ajax_Box_Base', false ) ) {
	require_once( 'class-sunny-ajax-box-base.php' );
}

/**
 * This class handles the url purger ajax requests.
 */
class Sunny_URL_Purger_Ajax_Box extends Sunny_Ajax_Box_Base {

	protected function set_class_properties() {

		$this->option_group 		= 'sunny_url_purger';

		$this->button_text          = __('Purge', $this->plugin_slug );

		$this->meta_box 			= array(
											'title'		=> __( 'URL Purger', $this->plugin_slug ),
											'context'	=> 'normal',
											);

		$this->settings_fields[]	= array(
											'id'		=> 'sunny_post_url',
											'title'		=> __( 'Post URL', $this->plugin_slug ),
											'callback'	=> array( $this, 'text' ),
											'args'		=> array (
																'id'	=> 'sunny_post_url',
																'type'	=> 'url',
																'size'	=> '30',
																'value'	=> 'http://example.com/hello-world/',
																'desc'	=> __( 'The URL you want to purge.', $this->plugin_slug ),
																),
											);

	} // end set_class_properties

	/**
	 * This function provides a simple description for the url purger section.
	 *
	 * @since 1.2.0
	 */
	public function render_section() {

		echo '<p>';
			_e( 'Purge a post by URL and (if enabled) its associated pages(e.g: categories, tags and archives).', $this->plugin_slug );
		echo '</p>';

	} // end render_section

}