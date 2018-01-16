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

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Pages;

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\Pages\TabbedPage;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\ViewAwareInterface;

/**
 * Trait PageTrait
 *
 * Common code between MenuPage and SubmenuPage.
 */
trait PageTrait
{
    /**
     * The capability required for this menu to be displayed to the user.
     *
     * @var string
     */
    protected $capability;

    /**
     * The slug name to refer to this menu by (should be unique for this menu).
     *
     * @var string
     */
    protected $menuSlug;

    /**
     * The text to be used for the menu.
     *
     * @var string
     */
    protected $menuTitle;

    /**
     * The text to be displayed in the title tags of the page when the menu is selected.
     *
     * @var string
     */
    protected $pageTitle;

    /**
     * {@inheritdoc}
     */
    public function getCapability(): string
    {
        return $this->capability;
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuTitle(): string
    {
        return $this->menuTitle;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTitle(): string
    {
        return $this->pageTitle;
    }

    /**
     * {@inheritdoc}
     */
    public function getSnakecasedMenuSlug(): string
    {
        $lowercaseMenuSlug = strtolower($this->getMenuSlug());

        return str_replace('-', '_', $lowercaseMenuSlug);
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuSlug(): string
    {
        return $this->menuSlug;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDecorator(): ViewAwareInterface
    {
        /* @var PageInterface $this */
        return new TabbedPage($this);
    }
}
