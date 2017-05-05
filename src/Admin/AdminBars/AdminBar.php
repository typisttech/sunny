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

namespace TypistTech\Sunny\Admin\AdminBars;

use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\OptionStore;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Filter;

/**
 * Final class AdminBar
 */
final class AdminBar implements LoadableInterface
{
    /**
     * Option store
     *
     * @var OptionStore
     */
    private $optionStore;

    /**
     * AdminBar constructor.
     *
     * @param OptionStore $optionStore The option store.
     */
    public function __construct(OptionStore $optionStore)
    {
        $this->optionStore = $optionStore;
    }

    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [ new Filter('show_admin_bar', __CLASS__, 'run') ];
    }

    /**
     * Hide admin bar if needed.
     *
     * @param bool $isShow Whether the admin bar should be shown.
     *
     * @return bool
     */
    public function run(bool $isShow): bool
    {
        if ($this->optionStore->getBoolean('sunny_admin_bar_disable_hide')) {
            return $isShow;
        }

        return false;
    }
}
