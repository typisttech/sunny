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

namespace TypistTech\Sunny\RelatedUrls;

use TypistTech\Sunny\RelatedUrls\Strategies\AuthorUrls;
use TypistTech\Sunny\RelatedUrls\Strategies\FeedUrls;
use TypistTech\Sunny\RelatedUrls\Strategies\PostTypeArchiveUrls;
use TypistTech\Sunny\RelatedUrls\Strategies\StrategyInterface;
use TypistTech\Sunny\RelatedUrls\Strategies\TermsUrls;
use WP_Post;

/**
 * Collects URLs related to a WP_Post object.
 *
 * Attempts to find all URLs that are related to an individual post URL. This is helpful when purging a group of URLs
 * based on an individual URL.
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
     * Strategies
     *
     * @var StrategyInterface[]
     */
    private $strategies;

    /**
     * RelatedUrls constructor.
     *
     * @param WP_Post             $post          You can send a post ID, a post object or a URL to the class and it
     *                                           will find related URLs.
     * @param StrategyInterface[] ...$strategies Strategies to get related urls.
     */
    public function __construct(WP_Post $post, StrategyInterface ...$strategies)
    {
        $this->post = $post;

        $strategies = count($strategies) > 0 ? $strategies : [
            new TermsUrls('category'),
            new TermsUrls('post_tag'),
            new AuthorUrls,
            new PostTypeArchiveUrls,
            new FeedUrls,
        ];

        $filteredStrategies = apply_filters('sunny_related_urls_strategies', $strategies, $post);

        $this->setStrategies(...$filteredStrategies);
    }

    /**
     * Strategies setter.
     *
     * @param StrategyInterface[] ...$strategies New strategies to get related urls.
     *
     * @return void
     */
    private function setStrategies(StrategyInterface ...$strategies)
    {
        $this->strategies = $strategies;
    }

    /**
     * Locate all related URLs.
     *
     * @return array The related URLs.
     */
    public function locate(): array
    {
        $related = array_reduce($this->strategies, function (array $carry, StrategyInterface $strategy) {
            $carry[ $strategy->getKey() ] = $strategy->locate($this->post);

            return $carry;
        }, []);

        return apply_filters(
            'sunny_related_urls_for_post',
            array_filter($related),
            $this->post
        );
    }
}
