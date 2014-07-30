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
$plugin = Sunny::get_instance();
$plugin_slug = $plugin->get_plugin_slug();

echo '<div id="sunny-account-settings" class="wrap">';
echo '<form action="options.php" method="POST">';
		settings_fields( 'sunny_cloudflare_account_section' );
		do_settings_sections( $plugin_slug );
		submit_button( __('Save', $plugin_slug ) );
echo '</form>';
echo '</div>';