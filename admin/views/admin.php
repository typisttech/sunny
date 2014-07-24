<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package 	Sunny
 * @subpackage 	Sunny_Admin
 * @author 		Tang Rufus <tangrufus@gmail.com>
 * @license  	GPL-2.0+
 * @link  		http://tangrufus.com
 * @copyright 	2014 Tang Rufus
 * @since 		1.0.0
 */
?>

<div class="wrap" >
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<?php $plugin = Sunny::get_instance(); ?>
	<?php $plugin_slug = $plugin->get_plugin_slug(); ?>

	<?php settings_errors(); ?>
	<form action="options.php" method="POST">
		<div class="postbox-container" style="width: 60%;">

			<div class="metabox-holder">
				<?php do_meta_boxes( $plugin_slug, 'advanced' ); ?>
				<?php do_meta_boxes( $plugin_slug, 'normal' ); ?>
			</div>

		</div>
	</form>
	<div class="postbox-container side" style="width: 261px;">

		<div class="metabox-holder">
			<?php do_meta_boxes( $plugin_slug, 'side' ); ?>
		</div>

	</div>

</div>

<script>jQuery(document).ready(function(){ postboxes.add_postbox_toggles(pagenow); });</script>

