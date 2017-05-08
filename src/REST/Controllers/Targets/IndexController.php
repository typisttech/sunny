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
use TypistTech\Sunny\Targets\Targets;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;
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
     * @return \WP_REST_Response|\WP_Error
     */
    public function index()
    {
        $targets = new Targets;

        return rest_ensure_response(
            $targets->all()
        );
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
        ]);
    }
}
