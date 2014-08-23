<?php

/**
 *
 * @package    Sunny
 * @subpackage Sunny/admin/settings
 * @author     Tang Rufus <tangrufus@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Sunny_Meta_Box {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The araay of settings tabs
	 *
	 * @since 	1.4.0
	 * @access  private
	 * @var   	array 		$options_tabs 	The araay of settings tabs
	 */
	private $options_tabs;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.4.0
	 * @var      string    $name    The name of this plugin.
	 */
	public function __construct( $name, $options_tabs ) {

		$this->name = $name;
		$this->options_tabs = $options_tabs;

	}

	/**
	 * Register the meta boxes on options page.
	 *
	 * @since    1.4.0
	 */
	public function add_meta_boxes() {

		foreach ( $this->options_tabs as $tab_id => $tab_name ) {

		add_meta_box(
				$tab_id,          // Meta box ID
				$tab_name,           // Meta box Title
				array( $this, 'render_meta_box' ),  // Callback defining the plugin's innards
				'sunny_settings_' . $tab_id,                    // Screen to which to add the meta box
				'normal'         	// Context
				);
		}
	}

	/**
	 * Print the meta box on options page.
	 *
	 * @since     1.4.0
	 */
	public function render_meta_box( $active_tab ) {

		require_once( plugin_dir_path( dirname( __FILE__ ) ) . '/partials/sunny-meta-box-display.php' );

	} // end render_meta_box

} //end Sunny_Option_Box_Base