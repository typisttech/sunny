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

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\DecoratorAwareInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\DecoratorAwareTrait;

/**
 * Final class MenuPageConfig.
 *
 * Config details for a single menu page.
 */
final class MenuPage implements PageInterface, DecoratorAwareInterface
{
    use DecoratorAwareTrait;
    use PageTrait;

    /**
     * The URL to the icon to be used for this menu.
     *
     * @var string
     */
    private $iconUrl;

    /**
     * The position in the menu order this one should appear.
     *
     * @var int|null
     */
    private $position;

    /**
     * MenuPage constructor.
     *
     * @param string      $menuSlug   The slug name to refer to this menu by (should be unique for this menu).
     * @param string      $menuTitle  The text to be displayed in the title tags of the page when the menu is selected.
     * @param string|null $pageTitle  Optional. The text to be used for the menu.
     * @param string|null $capability Optional. The capability required for this menu to be displayed to the user.
     * @param string|null $iconUrl    Optional. The URL to the icon to be used for this menu.
     * @param int|null    $position   Optional. The position in the menu order this one should appear.
     */
    public function __construct(
        string $menuSlug,
        string $menuTitle,
        string $pageTitle = null,
        string $capability = null,
        string $iconUrl = null,
        int $position = null
    ) {
        $this->menuSlug = $menuSlug;
        $this->menuTitle = $menuTitle;

        $this->pageTitle = $pageTitle ?? $menuTitle;
        $this->capability = $capability ?? 'manage_options';
        $this->iconUrl = $iconUrl ?? '';
        $this->position = $position ?? null;
    }

    /**
     * Hook suffix getter.
     *
     * @return string
     */
    public function getHookSuffix(): string
    {
        return get_plugin_page_hookname($this->menuSlug, '');
    }

    /**
     * IconUrl getter.
     *
     * @return string
     */
    public function getIconUrl(): string
    {
        return $this->iconUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return $this->position;
    }
}
