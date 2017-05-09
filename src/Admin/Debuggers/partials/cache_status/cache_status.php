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

use TypistTech\Sunny\Admin\Debuggers\AbstractDebugger;

/* @var AbstractDebugger $context Context */

?>

<p>Check how does Cloudflare cache your site.</p>

<form id="<?php echo esc_attr($context->getId()); ?>-form">
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr($context->getId()); ?>-url">Enter a Url: </label>
            </th>
            <td>
                <input name="<?php echo esc_attr($context->getId()); ?>-url"
                       id="<?php echo esc_attr($context->getId()); ?>-url"
                       type="url"
                       class="regular-text"
                       aria-describedby="<?php echo esc_attr($context->getId()); ?>-url-description"/>
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

