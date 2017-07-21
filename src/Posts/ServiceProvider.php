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

namespace TypistTech\Sunny\Posts;

use TypistTech\Sunny\Posts\RelatedUrls\RelatedUrls;
use TypistTech\Sunny\Posts\RelatedUrls\Strategies\AdjacentPostUrls;
use TypistTech\Sunny\Posts\RelatedUrls\Strategies\AuthorUrls;
use TypistTech\Sunny\Posts\RelatedUrls\Strategies\Culprit;
use TypistTech\Sunny\Posts\RelatedUrls\Strategies\FeedUrls;
use TypistTech\Sunny\Posts\RelatedUrls\Strategies\PostTypeArchiveUrls;
use TypistTech\Sunny\Posts\RelatedUrls\Strategies\TermsUrls;
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
        'related_urls_strategies',
        RelatedUrls::class,
    ];

    /**
     * This is where the magic happens, within the method you can
     * access the container and register or retrieve anything
     * that you need to, but remember, every alias registered
     * within this method must be declared in the `$provides` array.
     */
    public function register()
    {
        $this->getContainer()->share(
            'related_urls_strategies',
            function () {
                return [
                    new Culprit(),
                    new AdjacentPostUrls(),
                    new TermsUrls('category'),
                    new TermsUrls('post_tag'),
                    new AuthorUrls(),
                    new PostTypeArchiveUrls(),
                    new FeedUrls(),
                ];
            }
        );

        $this->getContainer()->share(
            RelatedUrls::class,
            function () {
                return new  RelatedUrls(
                    $this->getContainer()->get('related_urls_strategies')
                );
            }
        );
    }
}
