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

/**
 * Trait PageTrait
 *
 * Common interface between MenuPage and SubmenuPage.
 */
interface PageInterface
{
    /**
     * Capability getter.
     *
     * @return string
     */
    public function getCapability(): string;

    /**
     * Hook suffix getter.
     *
     * @return string
     */
    public function getHookSuffix(): string;

    /**
     * MenuSlug getter.
     *
     * @return string
     */
    public function getMenuSlug(): string;

    /**
     * MenuTitle getter.
     *
     * @return string
     */
    public function getMenuTitle(): string;

    /**
     * PageTitle getter.
     *
     * @return string
     */
    public function getPageTitle(): string;

    /**
     * Return MenuSlug in snake_case.
     *
     * @return string
     */
    public function getSnakecasedMenuSlug(): string;
}
