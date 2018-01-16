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

use TypistTech\Sunny\Debuggers\AbstractDebugger;

/* @var AbstractDebugger $context Context */

?>

<p>When you change or comment on a post, a page or any custom post type, we purge its related urls as well.</p>

<form id="<?php echo esc_attr($context->getId()); ?>-form">
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr($context->getId()); ?>-post-id">Enter a Post ID: </label>
            </th>
            <td>
                <input name="<?php echo esc_attr($context->getId()); ?>-post-id"
                    id="<?php echo esc_attr($context->getId()); ?>-post-id"
                    type="number"
                    class="regular-text"
                    step="1"
                    min="1"
                    value=""
                    aria-describedby="<?php echo esc_attr($context->getId()); ?>-post-id-description"/>
                <p class="description" id="<?php echo esc_attr($context->getId()); ?>-post-id-description">
                    <a href="https://www.typist.tech/go/find-wordpress-post-id/">How to find WordPress post id?</a>
                </p>
            </td>
        </tr>
        </tbody>
    </table>

    <?php submit_button('Check Related URLs', 'primary'); ?>
</form>

<br/>
<br/>

<div id="<?php echo esc_attr($context->getId()); ?>-result">
</div>

<p>
    Post related urls are filterable by <code>Strategies</code> and <code>sunny_post_related_urls</code>. See
    examples on <a href="https://github.com/TypistTech/sunny-purge-extra-urls-example">Sunny Purge Extra URLs
        Example</a>.
</p>
