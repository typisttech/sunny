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

use WP_Post;

/**
 * Final class PostType
 */
final class PostType
{
    /**
     * Get singular post type name for a given post.
     *
     * @param WP_Post $post The post object to determine singular post type name.
     *
     * @return string
     */
    public static function getSingularNameFor(WP_Post $post): string
    {
        $postTypeObject = get_post_type_object($post->post_type);

        if (null === $postTypeObject) {
            return __('Unknown Post Type', 'sunny');
        }

        return $postTypeObject->labels->singular_name;
    }
}
