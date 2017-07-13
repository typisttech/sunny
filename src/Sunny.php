<?php
/**
 * Sunny
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

namespace TypistTech\Sunny;

use TypistTech\Sunny\AdminBars\AdminBar;
use TypistTech\Sunny\AdminBars\AdminBarAdmin;
use TypistTech\Sunny\Ads\Announcement;
use TypistTech\Sunny\Ads\DonateMeNotice;
use TypistTech\Sunny\Ads\HireMeNotice;
use TypistTech\Sunny\Ads\I18nPromoter;
use TypistTech\Sunny\Ads\Newsletter;
use TypistTech\Sunny\Ads\ReviewMeNotice;
use TypistTech\Sunny\Api\ApiAdmin;
use TypistTech\Sunny\Debuggers\CacheStatusDebugger;
use TypistTech\Sunny\Debuggers\DebuggerAdmin;
use TypistTech\Sunny\Debuggers\PostRelatedUrlDebugger;
use TypistTech\Sunny\Debuggers\TargetDebugger;
use TypistTech\Sunny\Notifications\Notifier;
use TypistTech\Sunny\Notifications\ServiceProvider as NotificationsServiceProvider;
use TypistTech\Sunny\Posts\PostListener;
use TypistTech\Sunny\Posts\ServiceProvider as PostsServiceProvider;
use TypistTech\Sunny\REST\Controllers\Caches\Status\ShowController as CachesStatusShowController;
use TypistTech\Sunny\REST\Controllers\Posts\Caches\DeleteController as PostsCachesDeleteController;
use TypistTech\Sunny\REST\Controllers\Posts\RelatedUrls\IndexController as PostsRelatedUrlsIndexController;
use TypistTech\Sunny\REST\Controllers\Targets\IndexController as TargetsIndexController;
use TypistTech\Sunny\ServiceProvider as AppServiceProvider;
use TypistTech\Sunny\Vendor\League\Container\Container;
use TypistTech\Sunny\Vendor\League\Container\ReflectionContainer;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Loader;

/**
 * Final class Sunny
 *
 * The core plugin class.
 */
final class Sunny
{
    const VERSION = '2.2.1';

    const LOADABLES = [
        Admin::class,
        AdminBar::class,
        AdminBarAdmin::class,
        Announcement::class,
        ApiAdmin::class,
        CachesStatusShowController::class,
        CacheStatusDebugger::class,
        DebuggerAdmin::class,
        DonateMeNotice::class,
        HireMeNotice::class,
        I18n::class,
        I18nPromoter::class,
        Newsletter::class,
        Notifier::class,
        PostListener::class,
        PostRelatedUrlDebugger::class,
        PostsCachesDeleteController::class,
        PostsRelatedUrlsIndexController::class,
        ReviewMeNotice::class,
        TargetDebugger::class,
        TargetsIndexController::class,
    ];

    const SERVICE_PROVIDERS = [
        AppServiceProvider::class,
        NotificationsServiceProvider::class,
        PostsServiceProvider::class,
    ];

    /**
     * The dependency injection container.
     *
     * @var Container
     */
    private $container;

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @var Loader Maintains and registers all hooks for the plugin.
     */
    private $loader;

    /**
     * Sunny constructor.
     */
    public function __construct()
    {
        $this->container = new Container;
        $this->container->delegate(new ReflectionContainer);

        $this->loader = new Loader($this->container);
    }

    /**
     * Expose Container via WordPress action.
     *
     * Within the `sunny_register` action, you should only bind things into the container. You should never attempt to
     * register any hooks, actions, filters or any other piece of functionality within `sunny_register` action.
     * Otherwise, you may accidentally use an instance which has not been loaded yet.
     *
     * This is equivalent to Laravel's `register` method.
     *
     * @return void
     */
    public function register()
    {
        do_action('sunny_register', $this->getContainer());
    }

    /**
     * Container getter.
     *
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * Expose Container via WordPress action.
     *
     * The `sunny_boot` action is called after this plugin and all its addons have been registered, meaning you have
     * access to all instance that have been registered by this plugin and its addons.
     *
     * This is equivalent to Laravel's `boot` method.
     *
     * @return void
     */
    public function boot()
    {
        do_action('sunny_boot', $this->getContainer());
    }

    /**
     * Run the loader to add all the hooks to WordPress.
     * And bind necessary instance to the container.
     *
     * This method should only be called once in sunny.php
     *
     * @internal
     *
     * @return void
     */
    public function run()
    {
        $this->addServiceProviders();

        $this->addHooks();

        $this->loader->run();
    }

    /**
     * Add service providers into the container.
     *
     * @return void
     */
    private function addServiceProviders()
    {
        $this->container->share(__CLASS__, $this);

        foreach (self::SERVICE_PROVIDERS as $serviceProvider) {
            $this->container->addServiceProvider($serviceProvider);
        }
    }

    /**
     * Add all actions and filters to loader.
     *
     * @return void
     */
    private function addHooks()
    {
        add_action('plugins_loaded', [ $this, 'register' ], PHP_INT_MIN + 1000);
        add_action('plugins_loaded', [ $this, 'boot' ], PHP_INT_MAX - 1000);

        foreach (self::LOADABLES as $loadable) {
            $this->loader->add(...$loadable::getHooks());
        }
    }
}
