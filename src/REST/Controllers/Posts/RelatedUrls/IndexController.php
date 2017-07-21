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

namespace TypistTech\Sunny\REST\Controllers\Posts\RelatedUrls;

use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Posts\Post;
use TypistTech\Sunny\Posts\RelatedUrls\RelatedUrls;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;
use WP_Error;
use WP_Post;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

/**
 * Final class IndexController
 */
final class IndexController implements LoadableInterface
{
    const NAMESPACE = 'sunny/v2';

    /**
     * Related urls finder
     *
     * @var RelatedUrls
     */
    private $relatedUrls;

    /**
     * IndexController constructor.
     *
     * @param RelatedUrls $relatedUrls Related urls finder.
     */
    public function __construct(RelatedUrls $relatedUrls)
    {
        $this->relatedUrls = $relatedUrls;
    }

    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [ new Action('rest_api_init', __CLASS__, 'registerRoutes') ];
    }

    /**
     * Get related urls for a post
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return WP_REST_Response|WP_Error
     */
    public function index(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $id = $params['id'];

        $post = Post::findById($id);

        if (! $post instanceof WP_Post) {
            return new WP_Error(
                'sunny_not_found',
                'Post not found for the given id',
                [
                    'status' => 404,
                    'id' => $id,
                ]
            );
        }

        return new WP_REST_Response(
            $this->relatedUrls->allByPost($post)
        );
    }

    /**
     * Register the routes for the objects of the controller.
     *
     * @return void
     */
    public function registerRoutes()
    {
        register_rest_route(
            self::NAMESPACE,
            '/posts/(?P<id>[\d]+)/related-urls',
            [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [ $this, 'index' ],
                    'permission_callback' => function () {
                        return current_user_can('manage_options');
                    },
                    'args' => [
                        'id' => [
                            'description' => __('Unique identifier for the post.', 'sunny'),
                            'type' => 'integer',
                            'required' => true,
                            'sanitize_callback' => 'absint',
                        ],
                    ],
                ],
            ]
        );
    }
}
