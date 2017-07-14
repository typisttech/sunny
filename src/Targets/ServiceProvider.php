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

namespace TypistTech\Sunny\Targets;

use TypistTech\Sunny\Targets\Strategies\Homepage;
use TypistTech\Sunny\Vendor\League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class ServiceProvider
 */
final class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The provides array is a way to let the container
     * know that a service is provided by this service
     * provider. Every service that is registered via
     * this service provider must have an alias added
     * to this array or it will be ignored.
     *
     * @var array
     */
    protected $provides = [
        'targets_strategies',
        Targets::class,
    ];

    /**
     * This is where the magic happens, within the method you can
     * access the container and register or retrieve anything
     * that you need to, but remember, every alias registered
     * within this method must be declared in the `$provides` array.
     */
    public function register()
    {
        $this->getContainer()->share('targets_strategies', function () {
            return [
                new Homepage,
            ];
        });

        $this->getContainer()->share(Targets::class, function () {
            return new Targets(
                $this->getContainer()->get('targets_strategies')
            );
        });
    }
}
