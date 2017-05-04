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

namespace TypistTech\Sunny;

use TypistTech\Sunny\Admin\Notifications\Notifier;
use TypistTech\Sunny\Ads\I18nPromoter;
use TypistTech\Sunny\Ads\ReviewNotice;
use TypistTech\Sunny\Api\Admin as ApiAdmin;
use TypistTech\Sunny\Posts\Listener as PostsListener;
use TypistTech\Sunny\REST\Controllers\Posts\Caches\DeleteController as PostsCachesDeleteController;
use TypistTech\Sunny\REST\Controllers\Posts\RelatedUrls\IndexController as PostsRelatedUrlsIndexController;
use TypistTech\Sunny\Vendor\League\Container\Container;
use TypistTech\Sunny\Vendor\League\Container\ReflectionContainer;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Loader;

/**
 * Final class Sunny
 *
 * The core plugin class.
 */
final class Sunny implements LoadableInterface
{
    /**
     * The dependency injection container.
     *
     * @var Container
     */
    private $container;

    /**
     * The loader that's responsible for maintaining and registering allByPost hooks that power
     * the plugin.
     *
     * @var Loader Maintains and registers allByPost hooks for the plugin.
     */
    private $loader;

    /**
     * Sunny constructor.
     */
    public function __construct()
    {
        $this->container = new Container;
        $this->loader = new Loader($this->container);

        $optionStore = new OptionStore;
        $admin = new Admin($optionStore);
        $this->container->delegate(new ReflectionContainer);
        $this->container->add('\\' . OptionStore::class, $optionStore);
        $this->container->add('\\' . Admin::class, $admin);

        $loadables = [
            __CLASS__,
            Admin::class,
            ApiAdmin::class,
            I18n::class,
            I18nPromoter::class,
            Notifier::class,
            PostsCachesDeleteController::class,
            PostsListener::class,
            PostsRelatedUrlsIndexController::class,
            ReviewNotice::class,
        ];

        foreach ($loadables as $loadable) {
            /* @var LoadableInterface $loadable */
            $this->loader->add(...$loadable::getHooks());
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [
            new Action(__CLASS__, 'plugin_loaded', 'giveContainer', 5),
        ];
    }

    /**
     * Expose Container via WordPress action.
     *
     * @return void
     */
    public function giveContainer()
    {
        do_action('sunny_get_container', $this->getContainer());
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
     * Run the loader to add all the hooks to WordPress.
     *
     * @return void
     */
    public function run()
    {
        $this->loader->run();
    }
}
