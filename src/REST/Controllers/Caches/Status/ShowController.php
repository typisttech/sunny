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

namespace TypistTech\Sunny\REST\Controllers\Caches\Status;

use TypistTech\Sunny\Caches\Status;
use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;
use WP_Error;
use WP_REST_Request;
use WP_REST_Server;

/**
 * Final class ShowController
 */
final class ShowController implements LoadableInterface
{
    const NAMESPACE = 'sunny/v2';

    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [ new Action('rest_api_init', __CLASS__, 'registerRoutes') ];
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
            '/caches/status',
            [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [ $this, 'show' ],
                    'permission_callback' => function () {
                        return current_user_can('manage_options');
                    },
                    'args' => [
                        'url' => [
                            'description' => __('Resource url to check.', 'sunny'),
                            'type' => 'string',
                            'required' => true,
                            'sanitize_callback' => function ($param) {
                                return esc_url_raw($param);
                            },
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Shows a cache status result.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return \WP_REST_Response|\WP_Error
     */
    public function show(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $url = $params['url'];

        $status = new Status($url);
        $result = $status->check();

        if ('error' === $result['result']) {
            $result = $this->prepareErrorResponse($result, $url);
        }

        return rest_ensure_response($result);
    }

    /**
     * Prepare error response.
     *
     * @param array  $result Cache status check result.
     * @param string $url    Resource url to check.
     *
     * @return WP_Error
     */
    private function prepareErrorResponse(array $result, string $url): WP_Error
    {
        $error = $result['error'] ?? null;

        if (! $error instanceof WP_Error) {
            $error = new WP_Error('sunny_unknown', 'Unknown error');
        }

        $error->add_data(
            [
                'status' => 422,
                'url' => $url,
            ]
        );

        return $error;
    }
}
