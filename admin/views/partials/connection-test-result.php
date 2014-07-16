<?php
/**
 * Represents the test result view for the administration dashboard.
 *
 * @package   Sunny_Connection_Tester
 * @author    Tang Rufus <tangrufus@gmail.com>
 * @license   GPL-2.0+
 * @link      http://tangrufus.com
 * @copyright 2014 Tang Rufus
 */

if ( !isset( $_GET['connection_test_result'] ) || $_GET['connection_test_result'] != '1' )
	return;

$plugin = Sunny::get_instance();
$plugin_slug = $plugin->get_plugin_slug();
?>
<div id="connection-test-result" class="wrap">
    <h2>Connection Test Result</h2>
    <p>
        <?php if ( $_GET['status'] == 'wp_error' ) {
            _e( 'Error: There was a problem between WordPress and CloudFlare.', $plugin_slug );
            echo '<br />';
            if ( isset( $_GET['message'] ) ) {
                echo $_GET['message'];
            }
        }else if ( $_GET['status'] == 'api_error' ) {
            _e( 'Error: CloudFlare returns a problem.', $plugin_slug );
            echo '<br />';
            if ( isset( $_GET['message'] ) ) {
                echo $_GET['message'];
            }
        }else if ( $_GET['status'] == 'api_success' ) {
            _e( 'Your WordPress hostname: ', $plugin_slug );
            echo parse_url( site_url(), PHP_URL_HOST ) . '<br />';
            _e( 'Your WordPress hostname should be found on CloudFlare: ', $plugin_slug );
            echo ( isset ( $_GET['dns_match'] ) && $_GET['dns_match'] == '1' ) ? '<span style="color: #0a0; font-weight: bold;">Pass</span>' : '<span style="color: #e31010; font-weight: bold;">Fail</span>';
            echo '<br />';
            _e( 'This DNS record type should be either "A", "AAAA" or "CNAME": ', $plugin_slug );
            echo ( isset ( $_GET['dns_record_found'] ) && $_GET['dns_record_found'] == '1' ) ? '<span style="color: #0a0; font-weight: bold;">Pass</span>' : '<span style="color: #e31010; font-weight: bold;">Fail</span>';
            echo '<br />';
            _e( 'CloudFlare Proxy should be enabled (orange cloud): ', $plugin_slug );
            echo ( isset ( $_GET['service_mode_on'] ) && $_GET['service_mode_on'] == '1' ) ? '<span style="color: #0a0; font-weight: bold;">Pass</span>' : '<span style="color: #e31010; font-weight: bold;">Fail</span>';
            echo '<br />';
            if ( isset ( $_GET['dns_match'] ) && isset ( $_GET['dns_record_found'] ) && isset ( $_GET['service_mode_on'] ) &&
                $_GET['dns_match'] == '1' && $_GET['dns_record_found'] == '1' && $_GET['service_mode_on'] == '1' ) {
                echo '<strong>';
                _e( 'Your system is ready for Sunny.', $plugin_slug );
                echo '</strong>';
            }else {
                _e( 'Your system is <span style="color: #e31010; font-weight: bold;">NOT</span> ready for Sunny.', $plugin_slug );
            }
        }else{
            _e( 'Unknown error.', $plugin_slug );
        } ?>
    </p>
</div>