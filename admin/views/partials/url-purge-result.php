<?php
/**
 * Represents the `Purge All` result view for the administration dashboard.
 *
 * @package     Sunny
 * @subpackage  Sunny_Admin
 * @author      Tang Rufus <tangrufus@gmail.com>
 * @license     GPL-2.0+
 * @link        http://tangrufus.com
 * @copyright   2014 Tang Rufus
 * @since       1.1.0
 */

if ( ! isset( $_GET['url_purge_result'] ) || '1' != $_GET['url_purge_result'] )
    return;

$plugin = Sunny::get_instance();
$plugin_slug = $plugin->get_plugin_slug();
?>
<div id="url-purge-result" class="wrap">
    <h2>URL Purge Result</h2>
    <p>
        <?php
       if ( isset( $_GET['msg'] ) && 'error' == $_GET['msg'] ) {

            _e( 'Error! Make sure that the URL is correct.', $plugin_slug );

        } elseif ( isset( $_GET['msg'] ) && 'hostname-not-match' == $_GET['msg'] ) {

            _e( 'Error! The URL does not live in your site.', $plugin_slug );

        } elseif ( isset( $_GET['msg'] ) && 'error' != $_GET['msg'] ) {

            _e( 'These URLs will be purged if your post updated: ', $plugin_slug );
            echo '<br />';
            echo str_replace( ',', '<br />', $_GET['msg'] );
            _e( 'Sunny has <strong>tried</strong> to clear these caches. <br />
                If you want to verify the settings, use the Connection Tester instead.', $plugin_slug );

        }

        else  {

            _e( 'Unknown error.', $plugin_slug );

        }?>
    </p>
    <br />
</div>