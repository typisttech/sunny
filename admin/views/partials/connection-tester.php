<?php
/**
 * Represents the tester view for the administration dashboard.
 *
 * @package   Sunny_Connection_Tester
 * @author    Tang Rufus <tangrufus@gmail.com>
 * @license   GPL-2.0+
 * @link      http://tangrufus.com
 * @copyright 2014 Tang Rufus
 */
?>

<div id="sunny-connection-tester" class="wrap">
	<h2>Sunny Tester</h2>
	<h3>Connection Tester</h3>
		<p>Test your CloudFlare connection by clicking the test button below.</p>
		<form action="admin-post.php" method="POST">
		<?php wp_nonce_field( 'sunny_test_connection', 'sunny_test_connection_nonce' ) ?>
		<input type="hidden" name="action" value="sunny_connection_test">
	  		<?php submit_button( __('Test Connection', $plugin_slug ) ); ?>
    </form>
</div>