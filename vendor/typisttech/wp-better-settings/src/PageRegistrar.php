<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   TypistTech\WPBetterSettings
 *
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 *
 * @see       https://www.typist.tech/projects/wp-better-settings
 * @see       https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings;

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\DecoratorAwareInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\Pages\TabbedPageInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Pages\MenuPage;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Pages\SubmenuPage;

/**
 * Final class PageRegistrar
 *
 * This class registers menu pages and submenu pages via the WordPress API.
 *
 * It enables you an entire collection of menu pages and submenu pages as
 * represented by your MenuPage and SubmenuPage objects. In this way, you
 * don't have to deal with all the confusing callback code that the
 * WordPress Settings API forces you to use.
 */
final class PageRegistrar
{
    /**
     * Array of MenuPage instances.
     *
     * @var MenuPage[];
     */
    private $menuPages;

    /**
     * Array of SubmenuPage instances.
     *
     * @var SubmenuPage[];
     */
    private $submenuPages;

    /**
     * MenuPageRegister constructor.
     *
     * @param (MenuPage|SubmenuPage)[] $pages MenuPage or SubmenuPage objects that contains page configurations.
     */
    public function __construct(array $pages)
    {
        $menuPages = array_filter($pages, function ($page) {
            return $page instanceof MenuPage;
        });
        $this->menuPages = array_values($menuPages);

        $submenuPages = array_filter($pages, function ($page) {
            return $page instanceof SubmenuPage;
        });
        $this->submenuPages = array_values($submenuPages);
    }

    /**
     * Add the pages from the configuration objects to the WordPress admin
     * backend. Parent menu pages are invoked first, then submenu pages.
     *
     * @return void
     */
    public function run()
    {
        $allPageDecorators = array_map(function (DecoratorAwareInterface $page) {
            return $page->getDecorator();
        }, array_merge($this->menuPages, $this->submenuPages));

        array_map(function (TabbedPageInterface $tabbedPage) use ($allPageDecorators) {
            $tabbedPage->setTabs(...$allPageDecorators);
        }, $allPageDecorators);

        foreach ($this->menuPages as $menuPage) {
            add_menu_page(
                $menuPage->getPageTitle(),
                $menuPage->getMenuTitle(),
                $menuPage->getCapability(),
                $menuPage->getMenuSlug(),
                $menuPage->getCallbackFunction(),
                $menuPage->getIconUrl(),
                $menuPage->getPosition()
            );
        }

        foreach ($this->submenuPages as $submenuPage) {
            add_submenu_page(
                $submenuPage->getParentSlug(),
                $submenuPage->getPageTitle(),
                $submenuPage->getMenuTitle(),
                $submenuPage->getCapability(),
                $submenuPage->getMenuSlug(),
                $submenuPage->getCallbackFunction()
            );
        }
    }
}
