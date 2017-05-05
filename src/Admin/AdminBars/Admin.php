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
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Factories\Fields\CheckboxFactory;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Pages\SubmenuPage;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Section;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Filter;

/**
 * Final class Admin.
 *
 * The admin-specific functionality of Cloudflare Api settings.
 */
final class Admin implements LoadableInterface
{
    /**
     * Option store
     *
     * @var OptionStore
     */
    private $optionStore;

    /**
     * Admin constructor.
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
        return [
            new Filter('sunny_pages', __CLASS__, 'addPage'),
            new Filter('sunny_settings_sections', __CLASS__, 'addSettingsSection'),
        ];
    }

    /**
     * Add the menu page config.
     *
     * @param (MenuPage|SubmenuPage)[] $pages Menu and submenu page configurations.
     *
     * @return (MenuPage|SubmenuPage)[]
     */
    public function addPage(array $pages): array
    {
        $pages[] = new SubmenuPage(
            'sunny-cloudflare',
            'sunny-admin-bar',
            __('Sunny - Admin Bar', 'sunny')
        );

        return $pages;
    }

    /**
     * Add settings section config.
     *
     * @param Section[] $sections Settings section configurations.
     *
     * @return Section[]
     */
    public function addSettingsSection(array $sections): array
    {
        $checkboxFactory = new CheckboxFactory($this->optionStore);
        $disableHide = $checkboxFactory->build(
            'sunny_admin_bar_disable_hide',
            __('Disable admin bar hide', 'sunny'),
            [
                'description' => 'Show admin bar on public-facing pages. Admin bar will be cached by Cloudflare.',
            ]
        );

        $sections[] = new Section(
            'sunny-admin-bar',
            __('Admin Bar Settings', 'sunny'),
            $disableHide
        );

        return $sections;
    }
}
