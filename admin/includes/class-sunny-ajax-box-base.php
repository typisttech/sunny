<?php
/**
 * @package     Sunny
 * @subpackage  Sunny_Admin
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @license     GPL-2.0+
 * @link        http://tangrufus.com
 * @copyright   2014 Tang Rufus
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @since  		1.2.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Sunny_Box_Base', false ) ) {
	require_once( 'class-sunny-box-base.php' );
}

abstract class Sunny_Ajax_Box_Base extends Sunny_Box_Base {

	/**
	 * Print the meta box on options page.
	 *
	 * @since     1.2.0
	 */
	public function render_meta_box() {

		require( $this->view_dir_path . '/partials/ajax-box.php' );

	}

} //end Sunny_Ajax_Box_Base