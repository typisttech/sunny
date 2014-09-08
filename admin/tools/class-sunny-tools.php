<?php

/**
 *
 * @package    Sunny
 * @subpackage Sunny/admin/tools
 * @author     Tang Rufus <tangrufus@gmail.com>
 * @since  	   1.4.0
 */
class Sunny_Tools {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The array of plugin settings.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      array     $registered_tools    The array of plugin settings.
	 */
	private $registered_tools;

	/**
	 * The callback helper to render HTML elements for settings forms.
	 *
	 * @since    1.4.0
	 * @access   protected
	 * @var      Sunny_Callback_Helper    $callback    Render HTML elements.
	 */
	protected $callback;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.4.0
	 * @var      string    $name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name ) {

		$this->name = $name;
		$this->registered_tools = $this->set_registered_tools();

		if ( ! class_exists( 'Sunny_Callback_Helper' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'settings/class-sunny-callback-helper.php';
		}
		$this->callback = new Sunny_Callback_Helper( $this->name );

	}

	/**
	 * Register all settings sections and fields.
	 *
	 * @since 	1.4.0
	 * @return 	void
	*/
	public function add_meta_boxes() {

		foreach( $this->registered_tools as $tool ) {

			/**
			 * First, we register a section. This is necessary since all future settings must belong to one.
			 */
			// add_meta_box( $id, $title, $callback, $post_type, $context, $priority, $callback_args );
			add_meta_box(
				'sunny_tools_box_' . $tool['id'],	// Meta box ID
				$tool['title'],						// Meta box Title
				array( $this, 'render_meta_box' ),	// Callback defining the plugin's innards
				'sunny_settings_tools',				// Screen to which to add the meta box
				'normal',							// Context
				'default',							// $priority
				array(
					'id' 		=> $tool['id'],
					'action' 	=> $tool['action'],
					'desc' 		=> $tool['desc'],
					'btn_text' 	=> isset( $tool['btn_text'] ) ? $tool['btn_text'] : __( 'Go', $this->name ),
					)
				);


			// add_settings_section( $id, $title, $callback, $page )
			add_settings_section(
				'sunny_tools_' . $tool['id'],
				__return_null(),
				'__return_false',
				'sunny_tools_' . $tool['id']
				);

			if ( ! isset( $tool['settings'] ) ) {

				continue;

			}

			// Then, we register all fields. Each field represents an element in the array.
			foreach ( $tool['settings'] as $option ) {

				$_name = isset( $option['name'] ) ? $option['name'] : '';

				// add_settings_field( $id, $title, $callback, $page, $section, $args )
				add_settings_field(
					'sunny_tools[' . $option['id'] . ']',
					$_name,
					method_exists( $this->callback, $option['type'] . '_callback' ) ? array( $this->callback, $option['type'] . '_callback' ) : array( $this->callback, 'missing_callback' ),
					'sunny_tools_' . $tool['id'],
					'sunny_tools_' . $tool['id'],
					array(
						'id'      => isset( $option['id'] ) ? $option['id'] : null,
						'desc'    => !empty( $option['desc'] ) ? $option['desc'] : '',
						'name'    => isset( $option['name'] ) ? $option['name'] : null,
						'size'    => isset( $option['size'] ) ? $option['size'] : null,
						'options' => isset( $option['options'] ) ? $option['options'] : '',
						'std'     => isset( $option['std'] ) ? $option['std'] : ''
						)
					);

			} // end foreach

		} // end foreach

	}

	/**
	 * Set the array of plugin settings
	 *
	 * @since 	1.4.0
	 * @return 	array 	$settings
	*/
	private function set_registered_tools() {

	/**
	 * 'Whitelisted' Sunny settings, filters are provided for each settings
	 * section to allow extensions and other plugins to add their own settings
	 */
	$tools[] = array(
		'id' 		=> 'connection_tester',
		'title' 	=> __( 'Test Connection', $this->name ),
		'action' 	=> 'sunny_connection_test',
		'btn_text' 	=> __( 'Test Connection', $this->name ),
		'desc'		=> __( "To check if <code>Sunny</code> can connect to CloudFlare's server", $this->name )
		);

	$tools[] = array(
		'id' 		=> 'zone_purger',
		'title' 	=> __( 'Zone Purger', $this->name ),
		'action' 	=> 'sunny_zone_purge',
		'btn_text' 	=> __( 'Clear all cache', $this->name ),
		'desc'		=> __( "Clear CloudFlare's cache.<br />This function will purge CloudFlare of any cached files. It may take up to 48 hours for the cache to rebuild and optimum performance to be achieved so this function should be used sparingly.", $this->name )
		);

	$tools[] = array(
		'id' 		=> 'url_purger',
		'title' 	=> __( 'URL Purger', $this->name ),
		'action' 	=> 'sunny_url_purge',
		'btn_text' 	=> __( 'Clear cache', $this->name ),
		'desc'		=> __( 'Purge a post by URL and (if enabled) its associated pages(e.g: categories, tags and archives).', $this->name ),
		'settings' 	=> array(
			'post_url' 	=> array(
				'id'   	=> 'post_url',
				'name' 	=> __( 'Post URL', $this->name ),
				'desc' 	=> __( 'The URL you want to purge.', $this->name ),
				'type' 	=> 'text',
				'std'  	=> 'http://example.com/hello/',
				)
			)
		);

	return $tools;

	} // end set_registered_tools

	/**
	 * Print the meta box on options page.
	 *
	 * @since     1.4.0
	 */
	public function render_meta_box( $post, $metabox ) {

		require( plugin_dir_path( dirname( __FILE__ ) ) . 'partials/sunny-tool-box-display.php' );

	} // end render_meta_box

}