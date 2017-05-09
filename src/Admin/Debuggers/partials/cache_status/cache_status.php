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

declare(strict_types=1);

?>

<p>Check how does Cloudflare cache your site.</p>

<form id="sunny-debugger-cache-status-form">
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><label for="sunny-debugger-cache-status-url">Enter a Url: </label></th>
            <td>
                <input name="sunny-debugger-cache-status-url"
                       id="sunny-debugger-cache-status-url"
                       type="url"
                       class="regular-text"
                       aria-describedby="sunny-debugger-cache-status-url-description"/>
            </td>
        </tr>
        </tbody>
    </table>

    <?php submit_button('Check Cache Status', 'primary'); ?>
</form>

<br/>
<br/>

<div id="cache-status-result">
</div>

<p>
    Learn more about <code>Cache Status</code> on
    <a href="https://support.cloudflare.com/hc/en-us/articles/200168266">Cloudflare knowledge base</a>
</p>

