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

namespace TypistTech\Sunny\REST\Controllers\Targets;

use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;
use WP_REST_Request;
use WP_REST_Server;

/**
 * Final class IndexController
 */
final class IndexController implements LoadableInterface
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
     * Get all targets of Purger::execute
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return \WP_REST_Response|\WP_Error
     */
    public function index(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $group = $params['group'] ?? null;

        $targets = apply_filters('sunny_purger_targets', [], null);

        if (null !== $group) {
            return rest_ensure_response([
                $group => $targets[ $group ] ?? [],
            ]);
        }

        return rest_ensure_response($targets);
    }

    /**
     * Register the routes for the objects of the controller.
     *
     * @return void
     */
    public function registerRoutes()
    {
        $groups = apply_filters('sunny_target_groups', []);

        register_rest_route(self::NAMESPACE, '/targets', [
            [
                'callback' => [ $this, 'index' ],
                'methods' => WP_REST_Server::READABLE,
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
            ],
            'args' => [
                'group' => [
                    'description' => __('Group of the targets.', 'sunny'),
                    'enum' => $groups,
                    'required' => false,
                    'sanitize_callback' => 'sanitize_key',
                    'type' => 'string',
                    'validate_callback' => function ($param) use ($groups) {
                        return in_array($param, $groups, true);
                    },
                ],
            ],
        ]);
    }
}
