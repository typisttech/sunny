<?php
/**
 * Represents the test result view for the administration dashboard.
 *
 * @package   Sunny_Zone_Purger
 * @author    Tang Rufus <tangrufus@gmail.com>
 * @license   GPL-2.0+
 * @link      http://tangrufus.com
 * @copyright 2014 Tang Rufus
 */

if ( !isset( $_GET['zone_purge_result'] ) || $_GET['zone_purge_result'] != '1' )
    return;

$plugin = Sunny::get_instance();
$plugin_slug = $plugin->get_plugin_slug();
?>
<div id="zone-purge-result" class="wrap">
    <h2>Zone Purge Result</h2>
    <p>
        <?php
        if ( isset( $_GET['result'] ) ) {
            echo __( 'Result: ', $plugin_slug ) . $_GET['result'] . "<br />";
        }
        if ( isset( $_GET['message'] ) ) {
            echo "Message: " . $_GET['message'] . "<br />";
        }
        if ( !isset( $_GET['result'] ) || !isset( $_GET['message'] ) ) {
            _e( 'Unknown error.', $plugin_slug );;
        }?>
    </p>
</div>