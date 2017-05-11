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

namespace TypistTech\Sunny\Debuggers;

use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Sunny;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Pages\SubmenuPage;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Filter;

/**
 * Final class DebuggerAdmin.
 */
final class DebuggerAdmin implements LoadableInterface
{
    const HOOK_SUFFIX = 'sunny_page_sunny-debuggers';

    const SCREEN = 'sunny_debuggers';

    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [
            new Filter('sunny_pages', __CLASS__, 'addPage'),
            new Action('admin_enqueue_scripts', __CLASS__, 'enqueueAdminScripts'),
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
            'sunny-debuggers',
            __('Debuggers', 'sunny'),
            __('Sunny - Debuggers', 'sunny')
        );

        return $pages;
    }

    /**
     * Enqueue admin scripts.
     *
     * @param string|null $hook Hook suffix of the current admin page.
     *
     * @return void
     */
    public function enqueueAdminScripts(string $hook = null)
    {
        wp_register_style(
            'sunny_debuggers',
            plugins_url('partials/debuggers.css', __FILE__),
            [],
            Sunny::VERSION
        );

        if (self::HOOK_SUFFIX !== $hook) {
            return;
        }

        wp_enqueue_style('sunny_debuggers');
    }
}
