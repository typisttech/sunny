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

/**
 * This class handles the purger settings.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Sunny_Option_Box_Base', false ) ) {
	require_once( 'class-sunny-option-box-base.php' );
}

class Sunny_Purger_Settings_Option_Box extends Sunny_Option_Box_Base {

	/**
	 *
	 * @since 1.2.0
	 */
	protected function set_class_properties() {

		$this->option_group         = 'sunny_purger_settings';

		$this->button_text			= __('Save Purge Settings', $this->plugin_slug );

		$this->meta_box             = array(
										'title'     => __( 'Purger Settings', $this->plugin_slug ),
										'context'   => 'normal',
										);

		$this->settings_fields[]    = array(
										'id'        => 'purge_homepage',
										'title'     => __( 'Homepage', $this->plugin_slug ),
										'callback'  => array( $this, 'checkbox' ),
										'args'      => array (
															'id'        => 'purge_homepage',
															'desc'      => __( 'Purge homepage whenever post updated.', $this->plugin_slug ),
															),
										);

		$this->settings_fields[]    = array(
										'id'        => 'purge_associated',
										'title'     => __( 'Associated Pages', $this->plugin_slug ),
										'callback'  => array( $this, 'checkbox' ),
										'args'      => array (
															'id'        => 'purge_associated',
															'desc'      => __( 'Purge associated pages(e.g.: tags, categories and custom taxonomies) whenever post updated.', $this->plugin_slug ),
															),
										);

	} // end set_class_properties

	/**
	 *
	 * @since 1.2.0
	 */
	public function render_section() {

		echo '<p>';
			_e( 'The CloudFlare account associated to this site.', $this->plugin_slug );
		echo '</p>';

	} // end render_section

} //end Sunny_Option Class
