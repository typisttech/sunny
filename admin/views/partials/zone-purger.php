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
<div id="sunny-zone-purger" class="wrap">
	<form id="sunny-zone-purger-form" method="POST">
		<?php wp_nonce_field( 'sunny-purge-zone', 'sunny-zone-purger-nonce'); ?>
		<p>Immediately clear all cached resources for your website.</p>
		<p>This function will purge CloudFlare of any cached files. <br />
			It may take up to 48 hours for the cache to rebuild and optimum performance to be achieved so this function should be used sparingly.
		</p>
		<?php submit_button( __('Purge All Cache Now', $plugin_slug ), 'primary', 'sunny-zone-purger-button' ); ?>
	</form>
	<br class="clear">
	<div id="sunny-zone-purger-result" style="display: none">
		<h3 id="sunny-zone-purger-result-heading">Zone Purge Result</h3>
		<img id="sunny-zone-purger-form-spinner" style="display: none" src="<?php echo admin_url(); ?>images/spinner-2x.gif">
	</div>
</div>
