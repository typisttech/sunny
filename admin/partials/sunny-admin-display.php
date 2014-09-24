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

// global $sunny_settings;

$active_tab = isset( $_GET[ 'tab' ] ) && array_key_exists( $_GET['tab'], $this->get_options_tabs() ) ? $_GET[ 'tab' ] : 'general';

ob_start();
?>
<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?> </h2>
	<em>by <a href="https://wphuman.com/make-cloudflare-supercharge-wordpress-sites/#sunny">WP Human</a></em>

	<?php settings_errors( 'sunny-notices' ); ?>

	<h2 class="nav-tab-wrapper">
		<?php
		foreach( $this->get_options_tabs() as $tab_id => $tab_name ) {

			$tab_url = add_query_arg( array(
				'settings-updated' => false,
				'tab' => $tab_id
				) );

			$active = $active_tab == $tab_id ? ' nav-tab-active' : '';

			echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $tab_name ) . '" class="nav-tab' . $active . '">';
			echo esc_html( $tab_name );
			echo '</a>';
		}
		?>
	</h2>
	<div id="tab_container">

		<div class="postbox-container" style="width: 60%;">

			<div class="metabox-holder">

				<?php do_meta_boxes( 'sunny_settings_' . $active_tab, 'normal', $active_tab ); ?>

			</div><!-- .metabox-holder-->

		</div><!-- .postbox-container-->

		<div class="postbox-container side" style="width: 261px;">

			<div class="metabox-holder">

				<?php do_meta_boxes( 'sunny_settings_side', 'side', $active_tab ); ?>

			</div><!-- .metabox-holder-->

		</div><!-- .postbox-container.side-->


	</div><!-- #tab_container-->
</div><!-- .wrap -->
<?php
	echo ob_get_clean();
