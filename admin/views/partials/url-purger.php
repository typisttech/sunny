<?php
/**
 * Represents the URL Purger view for the administration dashboard.
 *
 * @package 	Sunny
 * @subpackage 	Sunny_Admin
 * @author 		Tang Rufus <tangrufus@gmail.com>
 * @license  	GPL-2.0+
 * @link  		http://tangrufus.com
 * @copyright 	2014 Tang Rufus
 * @since 		1.1.0
 */
?>

<?php $plugin = Sunny::get_instance(); ?>
<?php $plugin_slug = $plugin->get_plugin_slug(); ?>
<div id="sunny-url-purger" class="wrap">
	<form id="sunny-url-purger-form" method="POST">
		<?php wp_nonce_field( 'sunny-purge-url', 'sunny-url-purger-nonce'); ?>
		<?php do_settings_sections( 'sunny_url_purger_section' ); ?>
		<?php submit_button( __('Purge this URL & related pages', $plugin_slug ), 'primary', 'sunny-url-purger-button' ); ?>
	</form>
	<br class="clear">
	<div id="sunny-url-purger-result" style="display: none">
		<h3 id="sunny-url-purger-result-heading">URL Purger Result</h3>
		<img id="sunny-url-purger-form-spinner" style="display: none" src="<?php echo admin_url(); ?>images/spinner-2x.gif">
	</div>
</div>
