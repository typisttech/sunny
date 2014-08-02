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

if ( ! class_exists( 'Sunny_Option_Box_Base', false ) ) {
	require_once( 'class-sunny-option-box-base.php' );
}

/**
 *
 * @since 1.2.0
 */
class Sunny_Admin_Bar_Option_Box extends Sunny_Option_Box_Base {

	protected function set_class_properties() {

		$this->view_file			= 'admin-bar';
	    $this->option_group 		= 'sunny_admin_bar';
	    $this->meta_box 			= array(
	    								'id' 		=> 'sunny_admin_bar',
	    								'title'		=> __( 'Admin Bar', $this->plugin_slug ),
	    								'context'	=> 'normal',
	    								);

	    $this->settings_fields[]	= array(
										'id'		=> 'show',
										'title'		=> __( 'Admin Bar', $this->plugin_slug ),
										'callback'	=> array( $this, 'checkbox' ),
										'args'		=> array (
															'id'		=> 'show',
                											'label_for' => 'show',
                											'desc'      => __( 'If you have set a `Cache Everything` Page Rule, you want to hide the admin bar in case of CloudFlare caching it for the public.', $this->plugin_slug ),
                											),
										);

	}

}