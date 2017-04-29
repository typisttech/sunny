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

namespace TypistTech\Sunny\RelatedUrls\Strategies;

use WP_Post;
use WP_Term;

/**
 * Final class TermsUrls
 */
final class TermsUrls implements StrategyInterface
{
    /**
     * The taxonomy to look for associated terms.
     *
     * @var string
     */
    private $taxonomy;

    /**
     * TermsUrls constructor.
     *
     * @param string $taxonomy The taxonomy to look for associated terms.
     */
    public function __construct($taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey(): string
    {
        return $this->taxonomy;
    }

    /**
     * Get the term link pages for all terms associated with a post in a particular taxonomy.
     *
     * @param WP_Post $post The WP_Post object from which relationships are determined.
     *
     * @return string[]
     */
    public function locate(WP_Post $post): array
    {
        $terms = get_the_terms($post->ID, $this->taxonomy);

        if (! is_array($terms)) {
            return [];
        }

        /* @codingStandardsIgnoreStart */
        $related = array_map(function (WP_Term $term) {
            $link = get_term_link($term, $this->taxonomy);

            return is_string($link) ? $link : null;
        }, $terms);

        /* @codingStandardsIgnoreEnd */

        return array_values(array_filter($related));
    }
}
