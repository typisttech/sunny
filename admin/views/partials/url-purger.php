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

<div id="sunny-url-purger" class="wrap">
	<h2>URL Purge</h2>
		<p>To check what pages will be purged when you update a post.<br />
		This function also tries to clear the caches of a post and its associated<br />
		However, it <strong>will not</strong> show the purge request is success or not.</p>
		<form action="admin-post.php" method="POST">
		<?php wp_nonce_field( 'sunny_url_purger', 'sunny_url_purger_nonce' ) ?>
		<input type="hidden" name="action" value="sunny_url_purge">
		<label for="post-url">Post URL: </label>
  		<input type="url" name="post-url" size="60" id="post-url">
	  	<?php submit_button( __('Purge this URL & related', $plugin_slug ) ); ?>
    </form>
</div>