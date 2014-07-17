<?php
/**
 * Represents the test result view for the administration dashboard.
 * @package     Sunny
 * @subpackage  Sunny_Admin
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @license     GPL-2.0+
 * @link        http://tangrufus.com
 * @copyright   2014 Tang Rufus
 */

if ( ! isset( $_GET['connection_test_result'] ) || '1' != $_GET['connection_test_result'] )
	return;

$plugin = Sunny::get_instance();
$plugin_slug = $plugin->get_plugin_slug();
?>
<div id="connection-test-result" class="wrap">
    <h2>Connection Test Result</h2>
    <p>
        <?php if ( 'wp_error' == $_GET['status'] ) {
            _e( 'Error: There was a problem between WordPress and CloudFlare.', $plugin_slug );
            echo '<br />';
            if ( isset( $_GET['message'] ) ) {
                echo $_GET['message'];
            }
        } elseif ( 'api_error' == $_GET['status'] ) {
            _e( 'Error: CloudFlare returns a problem.', $plugin_slug );
            echo '<br />';
            if ( isset( $_GET['message'] ) ) {
                echo $_GET['message'];
            }
        } elseif ( 'api_success' == $_GET['status'] ) {
            _e( 'Your WordPress hostname: ', $plugin_slug );
            echo parse_url( site_url(), PHP_URL_HOST ) . '<br />';
            _e( 'Your WordPress hostname should be found on CloudFlare: ', $plugin_slug );
            echo ( isset( $_GET['dns_match'] ) && '1' == $_GET['dns_match'] ) ? '<span style="color: #0a0; font-weight: bold;">Pass</span>' : '<span style="color: #e31010; font-weight: bold;">Fail</span>';
            echo '<br />';
            _e( 'This DNS record type should be either "A", "AAAA" or "CNAME": ', $plugin_slug );
            echo ( isset( $_GET['dns_record_found'] ) && '1' == $_GET['dns_record_found'] ) ? '<span style="color: #0a0; font-weight: bold;">Pass</span>' : '<span style="color: #e31010; font-weight: bold;">Fail</span>';
            echo '<br />';
            _e( 'CloudFlare Proxy should be enabled (orange cloud): ', $plugin_slug );
            echo ( isset( $_GET['service_mode_on'] ) && '1' == $_GET['service_mode_on'] ) ? '<span style="color: #0a0; font-weight: bold;">Pass</span>' : '<span style="color: #e31010; font-weight: bold;">Fail</span>';
            echo '<br />';
            if ( isset( $_GET['dns_match'] ) && isset( $_GET['dns_record_found'] ) && isset( $_GET['service_mode_on'] ) &&
                '1' == $_GET['dns_match'] && '1' == $_GET['dns_record_found'] && '1' == $_GET['service_mode_on'] ) {
                echo '<strong>';
                _e( 'Your system is ready for Sunny.', $plugin_slug );
                echo '</strong>';
            } else {
                _e( 'Your system is <span style="color: #e31010; font-weight: bold;">NOT</span> ready for Sunny.', $plugin_slug );
            }
        } else{
            _e( 'Unknown error.', $plugin_slug );
        } ?>
    </p>
</div>