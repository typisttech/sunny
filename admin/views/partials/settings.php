<?php
$plugin = Sunny::get_instance();
$plugin_slug = $plugin->get_plugin_slug();
settings_fields( 'sunny_cloudflare_account_section' );
do_settings_sections( $plugin_slug );
submit_button( __('Save', $plugin_slug ) );