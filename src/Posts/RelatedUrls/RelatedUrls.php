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

namespace TypistTech\Sunny\Posts\RelatedUrls;

use TypistTech\Sunny\Posts\RelatedUrls\Strategies\StrategyInterface;
use WP_Post;

/**
 * Collects URLs related to a WP_Post object.
 *
 * Attempts to find URLs that are related to an individual post.
 *
 * @see  https://github.com/CondeNast/purgely/blob/master/src/classes/related-urls.php
 */
final class RelatedUrls
{
    /**
     * Strategies
     *
     * @var StrategyInterface[]
     */
    private $strategies;

    /**
     * Post constructor.
     *
     * @param StrategyInterface[] $strategies Strategies to get related urls.
     */
    public function __construct(array $strategies)
    {
        $this->setStrategies(...$strategies);
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
     * @param WP_Post $post The WP_Post object from which relationships are determined.
     *
     * @return array The related URLs.
     */
    public function allByPost(WP_Post $post): array
    {
        $related = array_reduce($this->strategies, function (array $carry, StrategyInterface $strategy) use ($post) {
            $carry[ $strategy->getKey() ] = $strategy->locate($post);

            return $carry;
        }, []);

        return apply_filters(
            'sunny_post_related_urls',
            array_filter($related),
            $post
        );
    }
}
