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
 * Final class AuthorUrls
 */
final class AuthorUrls implements StrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function getKey(): string
    {
        return 'author';
    }

    /**
     * Get author links related to this post.
     *
     * @param WP_Post $post The WP_Post object from which relationships are determined.
     *
     * @return string[]
     */
    public function locate(WP_Post $post): array
    {
        $author = $post->post_author;

        $related = [
            get_author_posts_url($author),
            get_author_feed_link($author),
        ];

        return array_values(array_filter($related));
    }
}
