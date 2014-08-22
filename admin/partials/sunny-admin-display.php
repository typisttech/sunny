<?php

/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://tangrufus.com
 * @since      1.4.0
 *
 * @package    Sunny
 * @subpackage Sunny/admin/partials
 */

/**
 * <!-- This file should primarily consist of HTML with a little bit of PHP. -->
 */

/**
 * Options Page
 *
 * Renders the options page contents.
 * 
 * @since       1.4.0
*/

echo 'Options Page'

// global $sunny_options;

// $active_tab = isset( $_GET[ 'tab' ] ) && array_key_exists( $_GET['tab'], $this->get_options_tabs() ) ? $_GET[ 'tab' ] : 'settings';

// ob_start();
// ?>
// <div class="wrap">
// 	<h2 class="nav-tab-wrapper">
// 		<?php
// 		foreach( $this->get_options_tabs() as $tab_id => $tab_name ) {

// 			$tab_url = add_query_arg( array(
// 				'settings-updated' => false,
// 				'tab' => $tab_id
// 				) );

// 			$active = $active_tab == $tab_id ? ' nav-tab-active' : '';

// 			echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $tab_name ) . '" class="nav-tab' . $active . '">';
// 			echo esc_html( $tab_name );
// 			echo '</a>';
// 		}
// 		?>
// 	</h2>
// 	<div id="tab_container">
// 		<form method="post" action="options.php">
// 			<table class="form-table">
// 				<?php
// 				settings_fields( 'sunny_options' );
// 				do_settings_fields( 'sunny_options_' . $active_tab, 'sunny_options_' . $active_tab );
// 				?>
// 			</table>
// 			<?php submit_button(); ?>
// 		</form>
// 	</div><!-- #tab_container-->
// </div><!-- .wrap -->
// <?php
// 	echo ob_get_clean();
