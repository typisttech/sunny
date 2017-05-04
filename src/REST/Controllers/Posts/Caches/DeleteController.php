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

namespace TypistTech\Sunny\REST\Controllers\Posts\Caches;

use TypistTech\Sunny\Caches\PurgeCommandFactory;
use TypistTech\Sunny\Caches\Purger;
use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Posts\Post;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;
use WP_Error;
use WP_Post;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

/**
 * Final class DeleteController
 */
final class DeleteController implements LoadableInterface
{
    const NAMESPACE = 'sunny/v2';

    /**
     * Purge command factory
     *
     * @var PurgeCommandFactory
     */
    private $purgeCommandFactory;

    /**
     * Purger
     *
     * @var Purger
     */
    private $purger;

    /**
     * DeleteController constructor.
     *
     * @param Purger              $purger              Purger.
     * @param PurgeCommandFactory $purgeCommandFactory Purge command factory.
     */
    public function __construct(Purger $purger, PurgeCommandFactory $purgeCommandFactory)
    {
        $this->purger = $purger;
        $this->purgeCommandFactory = $purgeCommandFactory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [ new Action('rest_api_init', __CLASS__, 'registerRoutes') ];
    }

    /**
     * Purge Cloudflare cache
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return WP_REST_Response|WP_Error
     */
    public function delete(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $reason = $params['reason'];
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

        $command = $this->purgeCommandFactory->buildForPost($post, $reason);
        $this->purger->execute($command);

        return new WP_REST_Response(null, 202);
    }

    /**
     * Register the routes for the objects of the controller.
     *
     * @todo Permission Check
     */
    public function registerRoutes()
    {
        register_rest_route(self::NAMESPACE, '/posts/(?P<id>[\d]+)/caches', [
            [
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => [ $this, 'delete' ],
                'args' => [
                    'id' => [
                        'description' => __('Unique identifier for the post.', 'sunny'),
                        'type' => 'integer',
                        'required' => true,
                        'sanitize_callback' => 'absint',
                    ],
                    'reason' => [
                        'description' => __('Reason for requesting this purge.', 'sunny'),
                        'type' => 'string',
                        'required' => true,
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
            ],
        ]);
    }
}
