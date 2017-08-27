<?php
/**
 * Sunny
 *
 * Automatically purge CloudFlare cache, including cache everything rules.
 *
 * @package   Sunny
 *
 * @author    Typist Tech <sunny@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 *
 * @see       https://www.typist.tech/projects/sunny
 * @see       https://wordpress.org/plugins/sunny/
 */

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 */

// If uninstall not called from WordPress, then exit.
if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

$keys = [
    'sunny_admin_bar',
    'sunny_admin_bar_disable_hide',
    'sunny_cloudflare_account',
    'sunny_cloudflare_api_key',
    'sunny_cloudflare_email',
    'sunny_cloudflare_zone_id',
    'sunny_donate_me_notice_last_enqueue',
    'sunny_enqueue_notifications',
    'sunny_enqueued_admin_notices',
    'sunny_enqueued_notices',
    'sunny_hire_me_notice_last_enqueue',
    'sunny_notifier_admin_notices',
    'sunny_purger_settings',
    'sunny_review_me_notice_last_enqueue',
    'sunny_security',
    'sunny_settings',
    'sunny_version',
];

foreach ($keys as $key) {
    delete_option($key);
}
