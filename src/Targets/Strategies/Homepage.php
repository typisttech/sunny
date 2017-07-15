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
        return [
            $this->getStaticHomepageUrls(),
            get_home_url(),
            get_site_url(),
        ];
    }

    /**
     * Static homepage urls getter.
     *
     * @return string|null
     */
    private function getStaticHomepageUrls()
    {
        if ('page' !== get_option('show_on_front')) {
            return null;
        }

        $homepageId = (int) get_option('page_for_posts');
        $permalink = get_permalink($homepageId);

        if (! is_string($permalink)) {
            return null;
        }

        return $permalink;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey(): string
    {
        return 'homepage';
    }
}
