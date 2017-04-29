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

namespace TypistTech\Sunny\Post;

/**
 * Final class Finder
 */
final class Finder
{
    /**
     * Find WP_Post by its Url.
     *
     * @param string $url Url of the targeted post.
     *
     * @return \WP_Post|null
     */
    public static function findWpPostByUrl(string $url)
    {
        $cleanUrl = esc_url_raw($url);

        if (empty($cleanUrl)) {
            return;
        }

        // @codingStandardsIgnoreStart
        $postId = url_to_postid($cleanUrl);

        // @codingStandardsIgnoreEnd

        return self::findWpPostById($postId);
    }

    /**
     * Find WP_Post by its id.
     *
     * @param int $postId Id of the targeted post.
     *
     * @return \WP_Post|null
     */
    public static function findWpPostById(int $postId)
    {
        if ($postId < 1) {
            return;
        }

        return get_post(absint($postId));
    }
}
