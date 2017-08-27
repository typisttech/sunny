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
 * Plugin Name:     Sunny
 * Plugin URI:      https://www.typist.tech/
 * Description:     Automatically purge CloudFlare cache, including cache everything rules.
 * Version:         1.6.0
 * Author:          Typist Tech
 * Author URI:      https://www.typist.tech/
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     sunny
 * Domain Path:     /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

add_action('admin_notices', 'sample_admin_notice__error');
function sample_admin_notice__error()
{
    ?>
    <div class="notice notice-error">
        <h2>Action Required: Upgrade to Sunny v2</h2>

        <p>Sunny v1 uses Cloudflare API v1 which <a
                    href="https://blog.cloudflare.com/sunsetting-api-v1-in-favor-of-cloudflares-current-client-api-api-v4/">deprecated
                since 9th November, 2016</a>.<br/>
            Thus, <strong>Sunny version 1 doesn't work anymore</strong>.</p>

        <h3>What does Sunny v2 require?</h3>

        <ol>
            <li>PHP 7 or later</li>
            <li>WordPress 4.7 or later</li>
        </ol>

        <h3>What is my current PHP version?</h3>

        <p><?php echo PHP_VERSION ?></p>

        <h3>What is my current WordPress version?</h3>

        <p><?php echo get_bloginfo('version') ?></p>

        <h3>Does Sunny v2 work on PHP 5?</h3>

        <p>No.</p>

        <h3>Should I install Sunny version 1 because of PHP 5 incompatibles?</h3>

        <p>No. It won't work.</p>

        <h3> How to update PHP? </h3>

        <ol>
            <li>Contact you hosting company</li>
            <li>Switch to a better hosting such as <a
                        href="https://www.typist.tech/go/wp-engine-isnt-business-worth-29-month/">WP Engine</a></li>
            <li>Hire me <a href="https://www.typist.tech/contact">https://www.typist.tech/contact</a></li>
        </ol>

        <h3>Does it hurt to use PHP 5.5 (or previous)?</h3>

        <p>Yes.<br/>
            PHP.net has ended <a href="http://php.net/eol.php">support for PHP 5.5 since July 2016</a>.<br/>
            That means no more bug fixes nor security fixes.
        </p>

        <h3>But WordPress still work on PHP 5.6?</h3>

        <ol>
            <li><a href="https://wordpress.org/about/requirements/">WordPress advocates for PHP 7</a></li>
            <li>PHP 7 is faster and more secure</li>
            <li>Writing PHP 7 code is easier. Remember: you didn't paid for the development hours</li>
        </ol>

        <h3>What about PHP 6?</h3>

        <p>You have bigger issues. There is no reason to use PHP 6.</p>

        <h3>Is this annoying notice a bug? Should I file a bug report?</h3>

        <p>No. It is annoying by design.</p>

        <h3>How can I get rid of this annoying notice?</h3>

        <p>Upgrade to Sunny v2</p>

    </div>
    <?php
}
