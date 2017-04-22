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

namespace TypistTech\Sunny;

use TypistTech\Sunny\Ads\I18nPromoter;
use TypistTech\Sunny\Ads\ReviewNotice;
use TypistTech\Sunny\Cloudflare\Admin as CloudflareAdmin;
use TypistTech\Sunny\Vendor\League\Container\Container as LeagueContainer;
use TypistTech\Sunny\Vendor\League\Container\ReflectionContainer;

/**
 * Final class Container.
 */
final class Container extends LeagueContainer
{
    /**
     * Initialize container.
     *
     * @return void
     */
    public function initialize()
    {
        $this->delegate(new ReflectionContainer);
        $this->add(self::class, $this);

        $optionStore = new OptionStore;
        $admin = new Admin($optionStore);
        $this->add('\\' . OptionStore::class, $optionStore);
        $this->add('\\' . Admin::class, $admin);

        $keys = [
            CloudflareAdmin::class,
            I18n::class,
            I18nPromoter::class,
            ReviewNotice::class,
        ];
        foreach ($keys as $key) {
            $this->add('\\' . $key);
        }
    }
}
