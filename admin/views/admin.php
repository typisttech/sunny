<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package 	Sunny
 * @author 		Tang Rufus <tangrufus@gmail.com>
 * @license  	GPL-2.0+
 * @link  		http://tangrufus.com
 * @copyright 	2014 Tang Rufus
 * @subpackage 	Sunny_Admin
 */
?>

<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	  <form action="options.php" method="POST">
	  		<?php $plugin = Sunny::get_instance(); ?>
	  		<?php $plugin_slug = $plugin->get_plugin_slug(); ?>
            <?php settings_fields( 'sunny_cloudflare_account_section' ); ?>
            <?php do_settings_sections( $plugin_slug ); ?>
            <?php submit_button( __('Save', $plugin_slug ) ); ?>
        </form>
</div>
