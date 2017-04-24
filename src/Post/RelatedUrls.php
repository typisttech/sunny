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

use WP_Post;

/**
 * Collects URLs related to another URL.
 *
 * Attempts to find all URLs that are related to an individual post URL. This is helpful when purging a group of URLs
 * based on an individual URL.
 *
 * This class takes a URL, ID or post object as input. This method will use that input to standardize it to a
 * WP_Post object. This makes all of the other methods much simpler in that they can operate on a WP_Post object
 * instead of various inputs.
 *
 * @see  https://github.com/CondeNast/purgely/blob/master/src/classes/related-urls.php
 */
final class RelatedUrls
{
    /**
     * The WP_Post object from which relationships are determined.
     *
     * @var WP_Post The WP_Post object from which relationships are determined.
     */
    private $post;

    /**
     * The list of URLs related to the main URL.
     *
     * @var array The list of URLs related to the main URL.
     */
    private $relatedUrls = [];

    /**
     * RelatedUrls constructor.
     *
     * @param WP_Post $post You can send a post ID, a post object or a URL to the class and it will find related URLs.
     */
    public function __construct(WP_Post $post)
    {
        $this->post = $post;
        $this->postId = $this->getPost()->ID;
    }

    /**
     * Get the main post object.
     *
     * @return WP_Post The main post object.
     */
    private function getPost(): WP_Post
    {
        return $this->post;
    }

    /**
     * Locate all of the URLs.
     *
     * @todo Support custom terms.
     *
     * @return array The related URLs.
     */
    public function locateAll(): array
    {
        // Set all of the URLs.
        $this->locateTermsUrls('category');
        $this->locateTermsUrls('post_tag');
        $this->locateAuthorUrls();
        $this->locatePostTypeArchiveUrl();
        $this->locateFeedUrls();

        // Return what has been found.
        return $this->getRelatedUrls();
    }

    /**
     * Get the term link pages for all terms associated with a post in a particular taxonomy.
     *
     * @param string $taxonomy The taxonomy to look for associated terms.
     *
     * @return array The URLs for term pages associated with this post.
     */
    public function locateTermsUrls(string $taxonomy): array
    {
        $postId = $this->getPostId();
        $terms = get_the_terms($postId, $taxonomy);
        if (! is_array($terms)) {
            return [];
        }

        $related = [];
        foreach ($terms as $term) {
            // @codingStandardsIgnoreStart
            $link = get_term_link($term, $taxonomy);
            // @codingStandardsIgnoreEnd

            if (is_wp_error($link)) {
                continue;
            }

            $related[] = $link;
            $this->setRelatedUrl($link, $taxonomy);
        }

        return $related;
    }

    /**
     * Get the main post ID.
     *
     * @return int The main post ID.
     */
    private function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * Set a single related URL by type of URL.
     *
     * @param string $url  The url to add to the collection.
     * @param string $type The category to place the URL in.
     *
     * @return void
     */
    private function setRelatedUrl(string $url, string $type)
    {
        $this->relatedUrls[ $type ][] = $url;
    }

    /**
     * Get author links related to this post.
     *
     * @return array The related author URLs.
     */
    public function locateAuthorUrls(): array
    {
        $post = $this->getPost();
        $author = $post->post_author;
        $authorPage = get_author_posts_url($author);
        $authorFeed = get_author_feed_link($author);
        $this->setRelatedUrl($authorPage, 'author');
        $this->setRelatedUrl($authorFeed, 'author');

        return [
            $authorPage,
            $authorFeed,
        ];
    }

    /**
     * Get the post type archives associated with the post.
     *
     * @return array The related post type archive URLs.
     */
    public function locatePostTypeArchiveUrl(): array
    {
        $post = $this->getPost();
        $postType = get_post_type($post);

        $related = [];
        $related[] = get_post_type_archive_link($postType);
        $related[] = get_post_type_archive_feed_link($postType);

        $related = array_values(array_filter($related));

        if (! empty($related)) {
            $this->setRelatedUrlsByCategory($related, 'post-type-archive');
        }

        return $related;
    }

    /**
     * Set a group of related URLs by type of URL.
     *
     * @param array  $urls The urls to add to the collection.
     * @param string $type The category to place the URLs in.
     *
     * @return void
     */
    private function setRelatedUrlsByCategory(array $urls, string $type)
    {
        $this->relatedUrls[ $type ] = $urls;
    }

    /**
     * Get all of the feed URLs.
     *
     * @return array The feed URLs.
     */
    public function locateFeedUrls(): array
    {
        $feeds = [
            get_bloginfo_rss('rdf_url'),
            get_bloginfo_rss('rss_url'),
            get_bloginfo_rss('rss2_url'),
            get_bloginfo_rss('atom_url'),
            get_bloginfo_rss('comments_rss2_url'),
            get_post_comments_feed_link(
                $this->getPostId()
            ),
        ];
        $this->setRelatedUrlsByCategory($feeds, 'feed');

        return $feeds;
    }

    /**
     * Get the related URLs.
     *
     * @param string|null $type The category of URL to get. All will be returned if this is left blank.
     *
     * @return array The related URLs.
     */
    public function getRelatedUrls(string $type = null): array
    {
        $type = $type ?? '';
        $urls = $this->relatedUrls;

        if ('' !== $type) {
            return $urls[ $type ] ?? [];
        }

        return $urls;
    }
}
