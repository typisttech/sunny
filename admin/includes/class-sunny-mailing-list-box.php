<?php
/**
 * @package     Sunny
 * @subpackage  Sunny_Admin
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @license     GPL-2.0+
 * @link        http://tangrufus.com
 * @copyright   2014 Tang Rufus
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @since 		1.2.5
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Sunny_Box_Base', false ) ) {
	require_once( 'class-sunny-box-base.php' );
}


class Sunny_Mailing_List_Box extends Sunny_Box_Base {

	protected function set_class_properties() {

		$this->meta_box 			= array(
											'title'		=> __( 'Sunny Mailing List', $this->plugin_slug ),
											'context'	=> 'side',
											);

	} // end set_class_properties

	/**
	 * Print the meta box on options page.
	 *
	 * @since     1.2.5
	 */
	public function render_meta_box() {

		require( $this->view_dir_path . '/partials/mailing-list-box.php' );

	} // end render_meta_box

}