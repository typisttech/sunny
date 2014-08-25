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

class Sunny_Mailing_List_Box {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.4.0
	 * @var      string    $name    The name of this plugin.
	 */
	public function __construct( $name ) {

		$this->name = $name;

	}

	/**
	 * Register the meta boxes on options page.
	 *
	 * @since    1.4.0
	 */
	public function add_meta_boxes() {

		add_meta_box(
				'mailing_list_box',							// Meta box ID
				__( 'Sunny Mailing List', $this->name ), 	// Meta box Title
				array( $this, 'render_meta_box' ),			// Callback defining the plugin's innards
				'sunny_settings_side',						// Screen to which to add the meta box
				'side'									// Context
				);

	}

	/**
	 * Print the meta box on options page.
	 *
	 * @since     1.4.0
	 */
	public function render_meta_box( $active_tab ) {

		require( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/sunny-mailing-list-box-display.php' );

	} // end render_meta_box

} //end Sunny_Option_Box_Base