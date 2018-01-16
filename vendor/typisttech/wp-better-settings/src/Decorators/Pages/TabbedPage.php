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

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Factories\ViewFactory;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Pages\PageInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\ViewAwareInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\ViewAwareTrait;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\ViewInterface;

/**
 * Final class Page
 *
 * This class defines necessary methods for rendering `src/partials/tabbed-page.php`.
 */
final class TabbedPage implements TabbedPageInterface, ViewAwareInterface
{
    use ViewAwareTrait {
        echoView as protected traitEchoView;
    }

    /**
     * All page decorators of this plugin.
     *
     * @var self[]
     */
    protected $tabs;

    /**
     * The decorated page.
     *
     * @var PageInterface
     */
    private $page;

    /**
     * Page constructor.
     *
     * @param PageInterface $page The decorated page.
     */
    public function __construct(PageInterface $page)
    {
        $this->page = $page;
    }

    /**
     * Echo the view safely and trigger meta box registration.
     *
     * @todo Improve JS enqueue.
     * @todo Improve meta box registration.
     * @todo Test hooks around postboxes.
     *
     * @return void
     */
    public function echoView()
    {
        wp_enqueue_script(
            'wpbs_postbox',
            plugins_url(plugin_basename(dirname(__FILE__, 3)) . '/partials/postbox.js'),
            [ 'postbox' ],
            '0.13.0'
        );

        do_action('add_meta_boxes', $this->getSnakecasedMenuSlug(), $this);

        $this->traitEchoView();
    }

    /**
     * {@inheritdoc}
     */
    public function getSnakecasedMenuSlug(): string
    {
        return $this->page->getSnakecasedMenuSlug();
    }

    /**
     * {@inheritdoc}
     */
    public function getTabs(): array
    {
        return $this->tabs;
    }

    /**
     * Tabs setter.
     *
     * @param TabbedPageInterface|TabbedPageInterface[] ...$tabs Other pages of this plugin.
     *
     * @return void
     */
    public function setTabs(TabbedPageInterface ...$tabs)
    {
        $this->tabs = $tabs;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl(): string
    {
        return admin_url('admin.php?page=' . $this->getMenuSlug());
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuSlug(): string
    {
        return $this->page->getMenuSlug();
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuTitle(): string
    {
        return $this->page->getMenuTitle();
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTitle(): string
    {
        return $this->page->getPageTitle();
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultView(): ViewInterface
    {
        return ViewFactory::build('tabbed-page');
    }
}
