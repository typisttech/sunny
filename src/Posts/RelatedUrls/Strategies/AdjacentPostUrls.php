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
 * Final class AdjacentPostUrls
 *
 * @todo This class needs refactor!
 * @todo Don't use global objects.
 * @todo Needs a better way to find next/previous posts.
 */
final class AdjacentPostUrls implements StrategyInterface
{
    const MAX_TRY = 5;

    /**
     * {@inheritdoc}
     */
    public function getKey(): string
    {
        return 'adjacent-post';
    }

    /**
     * Get adjacent post urls related to this post.
     *
     * @param WP_Post $post The WP_Post object from which relationships are determined.
     *
     * @return string[]
     */
    public function locate(WP_Post $post): array
    {
        return array_values(array_filter([
            $this->getPreviousPostLink($post, self::MAX_TRY),
            $this->getNextPostLink($post, self::MAX_TRY),
        ]));
    }

    /**
     * Find the previous publicly published post url. Quit when counter reaches zero.
     *
     * @param WP_Post $currentPost Current post.
     * @param int     $counter     Trials left before quit.
     *
     * @return string|null
     */
    private function getPreviousPostLink(WP_Post $currentPost, int $counter)
    {
        global $post;

        if ($counter < 1) {
            return null;
        }
        $counter--;

        // @codingStandardsIgnoreStart
        $post = $currentPost;
        $prevPost = get_previous_post();
        // @codingStandardsIgnoreEnd

        if (! $prevPost instanceof WP_Post) {
            return null;
        }

        if ('publish' !== get_post_status($prevPost->ID)) {
            return $this->getPreviousPostLink($prevPost, $counter);
        }

        $url = get_permalink($prevPost->ID);
        if (! is_string($url)) {
            return null;
        }

        return $url;
    }

    /**
     * Find the previous publicly published post url. Quit when counter reaches zero.
     *
     * @param WP_Post $currentPost Current post.
     * @param int     $counter     Trials left before quit.
     *
     * @return string|null
     */
    private function getNextPostLink(WP_Post $currentPost, int $counter)
    {
        global $post;

        if ($counter < 1) {
            return null;
        }
        $counter--;

        // @codingStandardsIgnoreStart
        $post = $currentPost;
        $nextPost = get_next_post();
        // @codingStandardsIgnoreEnd

        if (! $nextPost instanceof WP_Post) {
            return null;
        }

        if ('publish' !== get_post_status($nextPost->ID)) {
            return $this->getNextPostLink($nextPost, $counter);
        }

        $url = get_permalink($nextPost->ID);
        if (! is_string($url)) {
            return null;
        }

        return $url;
    }
}
