<?php
/**
 * Represents the connection tester view for the administration dashboard.
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
<div id="sunny-connection-tester" class="wrap">
	<form id="sunny-connection-tester-form" method="POST">
		<?php wp_nonce_field( 'sunny_connection_tester_nonce', 'sunny-connection-tester-nonce') ?>
		<p>Test your CloudFlare connection by clicking the test button below.</p>
		<?php submit_button( __('Test Connection', $plugin_slug ), 'primary', 'sunny-connection-tester-button' ); ?>
	</form>
	<br class="clear">
	<div id="sunny-connection-tester-result" style="display: none">
		<h3 id="sunny-connection-tester-result-heading">Connection Test Result</h3>
		<img id="sunny-connection-tester-form-spinner" style="display: none" src="http://sunny.dev/wp-admin/images/spinner-2x.gif" >
	</div>
</div>
