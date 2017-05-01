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

namespace TypistTech\Sunny\Posts;

/**
 * Final class Post
 */
final class Post
{
    /**
     * Find WP_Post by its Url.
     *
     * @param string $url Url of the targeted post.
     *
     * @return \WP_Post|null
     */
    public static function findByUrl(string $url)
    {
        $cleanUrl = esc_url_raw($url);

        // @codingStandardsIgnoreStart
        $postId = url_to_postid($cleanUrl);

        // @codingStandardsIgnoreEnd

        return self::findById($postId);
    }

    /**
     * Find WP_Post by its id.
     *
     * @param int $postId Id of the targeted post.
     *
     * @return \WP_Post|null
     */
    public static function findById(int $postId)
    {
        if ($postId < 1) {
            return null;
        }

        return get_post($postId);
    }
}
