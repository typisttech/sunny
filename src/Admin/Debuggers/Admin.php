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

namespace TypistTech\Sunny\Admin\Debuggers;

use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Pages\SubmenuPage;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\View;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Filter;

/**
 * Final class Admin.
 *
 * The admin-specific functionality of Cloudflare Api settings.
 */
final class Admin implements LoadableInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [
            new Filter('sunny_pages', __CLASS__, 'addPage'),
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
        $debuggers = new SubmenuPage(
            'sunny-cloudflare',
            'sunny-debuggers',
            __('Debuggers', 'sunny'),
            __('Sunny - Debuggers', 'sunny')
        );

        $debuggersView = new View(__DIR__ . '/partials/debuggers.php');
        $debuggers->getDecorator()
                  ->setView($debuggersView);

        $pages[] = $debuggers;

        return $pages;
    }
}
