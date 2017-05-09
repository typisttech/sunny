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

namespace TypistTech\Sunny\Targets\Strategies;

/**
 * Final class Homepage
 */
final class Homepage implements StrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        // This is equivalent to array_values(array_unique()).
        return array_keys(
            array_count_values(
                $this->getTargets()
            )
        );
    }

    /**
     * Targets getter.
     *
     * @return string[]
     */
    private function getTargets(): array
    {
        $homepage = $this->getStaticHomepageUrls();
        $homepage[] = get_home_url();
        $homepage[] = get_site_url();

        return $homepage;
    }

    /**
     * Static homepage urls getter.
     *
     * @return string[]
     */
    private function getStaticHomepageUrls(): array
    {
        if ('page' !== get_option('show_on_front')) {
            return [];
        }

        $homepageId = (int) get_option('page_for_posts');
        $permalink = get_permalink($homepageId);

        if (false === $permalink) {
            return [];
        }

        return [ $permalink ];
    }

    /**
     * {@inheritdoc}
     */
    public function getKey(): string
    {
        return 'homepage';
    }
}
