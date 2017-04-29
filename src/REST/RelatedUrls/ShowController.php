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

namespace TypistTech\Sunny\REST\RelatedUrls;

use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Post\Finder;
use TypistTech\Sunny\RelatedUrls\RelatedUrls;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

/**
 * Final class ShowController
 */
final class ShowController implements LoadableInterface
{
    const NAMESPACE = 'sunny/v2';

    const BASE = 'related-urls';

    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [ new Action('rest_api_init', __CLASS__, 'registerRoutes') ];
    }

    /**
     * Check if a given request has access to get a specific item
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return bool
     */
    public function doPermissionsCheck(WP_REST_Request $request): bool
    {
        // TODO: Check current_user_can manage_options.
        return true;
    }

    /**
     * Register the routes for the objects of the controller.
     */
    public function registerRoutes()
    {
        register_rest_route(self::NAMESPACE, self::BASE, [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [ $this, 'show' ],
                'permission_callback' => [ $this, 'doPermissionsCheck' ],
                'args' => [
                    'url' => [
                        'type' => 'string',
                        'required' => true,
                        'sanitize_callback' => function ($param) {
                            return sanitize_text_field($param);
                        },
                    ],
                ],
            ],
        ]);
    }

    /**
     * Get one item from the collection
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return WP_REST_Response|WP_Error
     */
    public function show(WP_REST_Request $request)
    {
        $params = $request->get_params();

        $wpPost = Finder::getWpPostByUrl($params['url']);

        if (null === $wpPost) {
            return new WP_Error(
                'sunny_related_urls_non_queryable',
                __("The given url doesn't match any post", 'sunny'),
                [
                    'status' => 422,
                    'sanitized-url' => $params['url'],
                ]
            );
        }

        $relatedUrls = new RelatedUrls($wpPost);

        return new WP_REST_Response($relatedUrls->locateAll());
    }
}
