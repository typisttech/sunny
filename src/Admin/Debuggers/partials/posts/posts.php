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

<div class="inside">
    <p>When you change or comment on a post, a page or any custom post type, we purge its related urls as well.</p>

    <div>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label for="sunny-debugger-post-id">Enter a Post ID: </label></th>
                <td>
                    <input name="sunny-debugger-post-id"
                           id="sunny-debugger-post-id"
                           type="number"
                           class="regular-text"
                           step="1"
                           min="1"
                           value=""
                           aria-describedby="sunny-debugger-post-id-description">
                    <p class="description" id="sunny-debugger-post-id-description">
                        <a href="https://www.typist.tech/go/find-wordpress-post-id/">How to find WordPress post id?</a>
                    </p>
                </td>
            </tr>
            </tbody>
        </table>

        <?php
        submit_button(
            'Check Related URLs',
            'primary',
            'sunny-debugger-post-id-submit',
            true,
            [
                'id' => 'sunny-debugger-post-id-submit',
            ]
        );
        ?>
    </div>

    <br/>
    <br/>

    <div id="post-related-urls-results">
    </div>

    <p>
        Related urls are filterable by <code>sunny_related_urls_strategies</code> and
        <code>sunny_related_urls_for_post</code>
    </p>
</div>
