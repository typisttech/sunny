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

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\Pages;

/**
 * Interface TabbedPageInterface
 *
 * This interface defines necessary methods for rendering `src/partials/tabbed-page.php`.
 */
interface TabbedPageInterface
{
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

    /**
     * Tabs getter.
     *
     * @return self[]
     */
    public function getTabs(): array;

    /**
     * Returns the URL of this page.
     *
     * @return string
     */
    public function getUrl(): string;

    /**
     * Tabs setter.
     *
     * @param self|self[] ...$tabs Other pages of this plugin.
     *
     * @return void
     */
    public function setTabs(self ...$tabs);
}
