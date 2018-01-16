<?php
/**
 * WP Contained Hook
 *
 * Lazily instantiate objects from dependency injection container
 * to WordPress hooks (actions and filters).
 *
 * @package   TypistTech\WPContainedHook
 * @author    Typist Tech <wp-contained-hook@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   MIT
 * @see       https://www.typist.tech/projects/wp-contained-hook
 */

declare(strict_types=1);

namespace TypistTech\Sunny\Vendor\TypistTech\WPContainedHook;

use TypistTech\Sunny\Vendor\League\Container\ContainerInterface as Container;

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 */
final class Loader
{
    /**
     * The container.
     *
     * @var Container
     */
    private $container;

    /**
     * Array of hooks registered with WordPress.
     *
     * @var AbstractHook[]
     */
    private $hooks;

    /**
     * Initialize the collections used to maintain the hooks.
     *
     * @param Container $container The container.
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->hooks     = [];
    }

    /**
     * Add new hooks to the collection to be registered with WordPress.
     *
     * @param AbstractHook|AbstractHook[] ...$hooks Hooks to be registered.
     *
     * @return void
     */
    public function add(AbstractHook ...$hooks)
    {
        $this->hooks = array_unique(
            array_merge($this->hooks, $hooks),
            SORT_REGULAR
        );
    }

    /**
     * Register the hooks to the container and WordPress.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->hooks as $hook) {
            $hook->setContainer($this->container);
            $hook->registerToContainer();
            $hook->registerToWordPress();
        }
    }
}
