<?php
/**
 * Represents the `Purge All` button view for the administration dashboard.
 *
 * @package 	Sunny
 * @subpackage 	Sunny_Admin
 * @author 		Tang Rufus <tangrufus@gmail.com>
 * @license  	GPL-2.0+
 * @link  		http://tangrufus.com
 * @copyright 	2014 Tang Rufus
 */
?>

<?php $plugin = Sunny::get_instance(); ?>
<?php $plugin_slug = $plugin->get_plugin_slug(); ?>

<div id="sunny-admin-bar" class="wrap">
	<form action="options.php" method="POST">
		<?php settings_fields( 'sunny_admin_bar' ); ?>
		<?php do_settings_sections( 'sunny_admin_bar' ); ?>
		<?php submit_button( __('Save', $plugin_slug ), 'primary' ); ?>
		<br class="clear" />
	</form>
</div>
