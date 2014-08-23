<?php

/**
 * Sunny Callback Helper Class
 *
 * The callback functions of the options page
 *
 * @package    Sunny
 * @subpackage Sunny/admin/settings
 * @author     Tang Rufus <tangrufus@gmail.com>
 */
class Sunny_Callback_Helper {

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
	 * @since    1.0.0
	 * @var      string    $name       The name of this plugin.
	 */
	public function __construct( $name ) {

		$this->name = $name;

	}

	/**
	 * Missing Callback
	 *
	 * If a function is missing for settings callbacks alert the user.
	 *
	 * @since 	1.4.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function missing_callback( $args ) {
		printf( __( 'The callback function used for the <strong>%s</strong> setting is missing.', $this->name ), $args['id'] );
	}

	/**
	 * Header Callback
	 *
	 * Renders the header.
	 *
	 * @since 	1.4.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function header_callback( $args ) {
		echo '<hr/>';
	}

	/**
	 * Checkbox Callback
	 *
	 * Renders checkboxes.
	 *
	 * @since 	1.4.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$sunny_options Array of all the Sunny Options
	 * @return 	void
	 */
	public function checkbox_callback( $args ) {
		global $sunny_options;

		$checked = isset( $sunny_options[ $args[ 'id' ] ] ) ? checked( 1, $sunny_options[ $args[ 'id' ] ], false ) : '';
		$html = '<input type="checkbox" id="sunny_settings[' . $args['id'] . ']" name="sunny_settings[' . $args['id'] . ']" value="1" ' . $checked . '/>';
		$html .= '<label for="sunny_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Multicheck Callback
	 *
	 * Renders multiple checkboxes.
	 *
	 * @since 	1.4.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$sunny_options Array of all the Sunny Options
	 * @return 	void
	 */
	public function multicheck_callback( $args ) {

		if ( empty( $args['options'] ) ) {
			return;
		}

		global $sunny_options;

		foreach( $args['options'] as $key => $option ) {

			if( isset( $sunny_options[$args['id']][$key] ) ) {
				$enabled = $option;
			} else {
				$enabled = NULL;
			}

			echo '<input name="sunny_settings[' . $args['id'] . '][' . $key . ']" id="sunny_settings[' . $args['id'] . '][' . $key . ']" type="checkbox" value="' . $option . '" ' . checked($option, $enabled, false) . '/>&nbsp;';
			echo '<label for="sunny_settings[' . $args['id'] . '][' . $key . ']">' . $option . '</label><br/>';

		}

		echo '<p class="description">' . $args['desc'] . '</p>';

	}

	/**
	 * Radio Callback
	 *
	 * Renders radio boxes.
	 *
	 * @since 	1.4.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$sunny_options Array of all the Sunny Options
	 * @return 	void
	 */
	public function radio_callback( $args ) {
		global $sunny_options;

		foreach ( $args['options'] as $key => $option ) {
			$checked = false;

			if ( isset( $sunny_options[ $args['id'] ] ) && $sunny_options[ $args['id'] ] == $key ) {
				$checked = true;
			} elseif( isset( $args['std'] ) && $args['std'] == $key && ! isset( $sunny_options[ $args['id'] ] ) ) {
				$checked = true;
			}

			echo '<input name="sunny_settings[' . $args['id'] . ']"" id="sunny_settings[' . $args['id'] . '][' . $key . ']" type="radio" value="' . $key . '" ' . checked(true, $checked, false) . '/>&nbsp;';
			echo '<label for="sunny_settings[' . $args['id'] . '][' . $key . ']">' . $option . '</label><br/>';

		}

		echo '<p class="description">' . $args['desc'] . '</p>';
	}

	/**
	 * Text Callback
	 *
	 * Renders text fields.
	 *
	 * @since 	1.4.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$sunny_options Array of all the Sunny Options
	 * @return 	void
	 */
	public function text_callback( $args ) {
		global $sunny_options;

		if ( isset( $sunny_options[ $args['id'] ] ) ) {
			$value = $sunny_options[ $args['id'] ];
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="text" class="' . $size . '-text" id="sunny_settings[' . $args['id'] . ']" name="sunny_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		$html .= '<label for="sunny_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Number Callback
	 *
	 * Renders number fields.
	 *
	 * @since 	1.4.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$sunny_options Array of all the Sunny Options
	 * @return 	void
	 */
	public function number_callback( $args ) {
		global $sunny_options;

		if ( isset( $sunny_options[ $args['id'] ] ) ) {
			$value = $sunny_options[ $args['id'] ];
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$max  = isset( $args['max'] ) ? $args['max'] : 999999;
		$min  = isset( $args['min'] ) ? $args['min'] : 0;
		$step = isset( $args['step'] ) ? $args['step'] : 1;

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="number" step="' . esc_attr( $step ) . '" max="' . esc_attr( $max ) . '" min="' . esc_attr( $min ) . '" class="' . $size . '-text" id="sunny_settings[' . $args['id'] . ']" name="sunny_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		$html .= '<label for="sunny_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Textarea Callback
	 *
	 * Renders textarea fields.
	 *
	 * @since 	1.4.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$sunny_options Array of all the Sunny Options
	 * @return 	void
	 */
	public function textarea_callback( $args ) {
		global $sunny_options;

		if ( isset( $sunny_options[ $args['id'] ] ) ) {
			$value = $sunny_options[ $args['id'] ];
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<textarea class="large-text" cols="50" rows="5" id="sunny_settings[' . $args['id'] . ']" name="sunny_settings[' . $args['id'] . ']">' . esc_textarea( stripslashes( $value ) ) . '</textarea>';
		$html .= '<label for="sunny_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Password Callback
	 *
	 * Renders password fields.
	 *
	 * @since 	1.4.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$sunny_options Array of all the Sunny Options
	 * @return 	void
	 */
	public function password_callback( $args ) {
		global $sunny_options;

		if ( isset( $sunny_options[ $args['id'] ] ) ) {
			$value = $sunny_options[ $args['id'] ];
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="password" class="' . $size . '-text" id="sunny_settings[' . $args['id'] . ']" name="sunny_settings[' . $args['id'] . ']" value="' . esc_attr( $value ) . '"/>';
		$html .= '<label for="sunny_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Select Callback
	 *
	 * Renders select fields.
	 *
	 * @since 	1.4.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$sunny_options Array of all the Sunny Options
	 * @return 	void
	 */
	public function select_callback( $args ) {
		global $sunny_options;

		if ( isset( $sunny_options[ $args['id'] ] ) ) {
			$value = $sunny_options[ $args['id'] ];
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$html = '<select id="sunny_settings[' . $args['id'] . ']" name="sunny_settings[' . $args['id'] . ']"/>';

		foreach ( $args['options'] as $option => $name ) {
			$selected = selected( $option, $value, false );
			$html .= '<option value="' . $option . '" ' . $selected . '>' . $name . '</option>';
		}

		$html .= '</select>';
		$html .= '<label for="sunny_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Rich Editor Callback
	 *
	 * Renders rich editor fields.
	 *
	 * @since 	1.4.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$sunny_options Array of all the Sunny Options
	 * @global 	$wp_version WordPress Version
	 */
	public function rich_editor_callback( $args ) {
		global $sunny_options, $wp_version;

		if ( isset( $sunny_options[ $args['id'] ] ) ) {
			$value = $sunny_options[ $args['id'] ];
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		if ( $wp_version >= 3.3 && function_exists( 'wp_editor' ) ) {
			ob_start();
			wp_editor( stripslashes( $value ), 'sunny_settings_' . $args['id'], array( 'textarea_name' => 'sunny_settings[' . $args['id'] . ']' ) );
			$html = ob_get_clean();
		} else {
			$html = '<textarea class="large-text" rows="10" id="sunny_settings[' . $args['id'] . ']" name="sunny_settings[' . $args['id'] . ']">' . esc_textarea( stripslashes( $value ) ) . '</textarea>';
		}

		$html .= '<br/><label for="sunny_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Upload Callback
	 *
	 * Renders upload fields.
	 *
	 * @since 	1.4.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$sunny_options Array of all the Sunny Options
	 * @return 	void
	 */
	public function upload_callback( $args ) {
		global $sunny_options;

		if ( isset( $sunny_options[ $args['id'] ] ) ) {
			$value = $sunny_options[$args['id']];
		} else {
			$value = isset($args['std']) ? $args['std'] : '';
		}

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="text" class="' . $size . '-text sunny_upload_field" id="sunny_settings[' . $args['id'] . ']" name="sunny_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		$html .= '<span>&nbsp;<input type="button" class="sunny_settings_upload_button button-secondary" value="' . __( 'Upload File', $this->name ) . '"/></span>';
		$html .= '<label for="sunny_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

}