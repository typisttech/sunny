<?php
/**
 * Sunny
 *
 * Automatically purge CloudFlare cache, including cache everything rules.
 *
 * @package   Sunny
 *
 * @author Typist Tech <sunny@typist.tech>
 * @copyright 2017 Typist Tech
 * @license GPL-2.0+
 *
 * @see https://www.typist.tech/projects/sunny
 * @see https://wordpress.org/plugins/sunny/
 */

declare(strict_types=1);

namespace TypistTech\Sunny\Admin\Ads;

use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;
use TypistTech\Sunny\Vendor\WP_Review_Me;

/**
 * Final class ReviewNotice
 */
final class ReviewNotice implements LoadableInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [
            new Action('admin_init', __CLASS__, 'run'),
        ];
    }

    /**
     * Initialize WP_Review_Me
     *
     * @return void
     */
    public function run()
    {
        // @codingStandardsIgnoreStart
        $message = __(
            "Hey! <code>Sunny</code> has been purging your site's Cloudflare caches for a while. You might not realize it, but user reviews are such a great help to us. We would be so grateful if you could take a minute to leave a review on WordPress.org. Many thanks in advance :)",
            'sunny'
        );
        // @codingStandardsIgnoreEnd

        new WP_Review_Me([
            'type' => 'plugin',
            'slug' => 'sunny',
            'message' => $message,
        ]);
    }
}
