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

namespace TypistTech\Sunny\Posts\RelatedUrls\Strategies;

use WP_Post;

/**
 * Final class PostTypeArchiveUrls
 */
final class PostTypeArchiveUrls implements StrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function getKey(): string
    {
        return 'post-type-archive';
    }

    /**
     * Get the post type archives associated with the post.
     *
     * @param WP_Post $post The WP_Post object from which relationships are determined.
     *
     * @return string[]
     */
    public function locate(WP_Post $post): array
    {
        $postType = get_post_type($post);

        return [
            get_post_type_archive_link($postType),
            get_post_type_archive_feed_link($postType),
        ];
    }
}
