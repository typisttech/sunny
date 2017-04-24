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

namespace TypistTech\Sunny\Purge;

use TypistTech\Sunny\Cloudflare\Cache;
use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;

/**
 * Final class Handler
 */
final class Handler implements LoadableInterface
{
    /**
     * Api adopter
     *
     * @var Cache
     */
    private $cache;

    /**
     * Handler constructor.
     *
     * @param Cache $cache The api adopter.
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [ new Action('sunny_do_purge', __CLASS__, 'handle') ];
    }

    /**
     * Handle purge command
     *
     * @param Command $event Immutable data transfer object that holds necessary information about this action.
     *
     * @return void
     */
    public function handle(Command $event)
    {
        $this->cache->purge(
            ...$event->getUrls()
        );
    }
}
