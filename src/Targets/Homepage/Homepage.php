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

namespace TypistTech\Sunny\Targets\Homepage;

use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Filter;

/**
 * Final class Homepage
 */
final class Homepage implements LoadableInterface
{
    const GROUP = 'homepage';

    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [
            new Filter('sunny_purger_targets', __CLASS__, 'pushTargets'),
            new Filter('sunny_target_groups', __CLASS__, 'pushGroup'),
        ];
    }

    /**
     * Push group key to target groups.
     *
     * @param string[] $groups Registered target groups.
     *
     * @return string[]
     */
    public function pushGroup(array $groups): array
    {
        $groups[] = self::GROUP;

        return $groups;
    }

    /**
     * Push homepage urls to purger targets.
     *
     * @param array $urls Urls to be purged.
     *
     * @return array
     */
    public function pushTargets(array $urls): array
    {
        // This is equivalent to array_values(array_unique()).
        $urls[ self::GROUP ] = array_keys(
            array_count_values(
                $this->getTargets()
            )
        );

        return $urls;
    }

    /**
     * Targets getter.
     *
     * @return string[]
     */
    protected function getTargets(): array
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
}
