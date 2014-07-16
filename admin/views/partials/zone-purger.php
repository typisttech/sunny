<?php
/**
 * Represents the tester view for the administration dashboard.
 *
 * @package   Sunny_Zone_Purger
 * @author    Tang Rufus <tangrufus@gmail.com>
 * @license   GPL-2.0+
 * @link      http://tangrufus.com
 * @copyright 2014 Tang Rufus
 */
?>

<div id="sunny-zone-purger" class="wrap">
	<h2>Cache Purge</h2>
		<p>Immediately purge cached resources for your website.</p>
		<p>This function will purge CloudFlare of any cached files. <br />It may take up to 48 hours for the cache to rebuild and optimum performance to be achieved so this function should be used sparingly.</p>
		<form action="admin-post.php" method="POST">
		<?php wp_nonce_field( 'sunny_zone_purger', 'sunny_zone_purger_nonce' ) ?>
		<input type="hidden" name="action" value="sunny_zone_purge">
	  		<?php submit_button( __('Purge All Cache Now', $plugin_slug ) ); ?>
    </form>
</div>