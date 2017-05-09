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

namespace TypistTech\Sunny\Admin\Debuggers;

use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Sunny;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\View;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;

/**
 * Final class CacheStatus
 */
final class CacheStatus implements LoadableInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [
            new Action('sunny_add_debugger_boxes', __CLASS__, 'addMetaBox'),
            new Action('admin_enqueue_scripts', __CLASS__, 'enqueueAdminScripts'),
        ];
    }

    /**
     * Register meta box.
     *
     * @return void
     */
    public function addMetaBox()
    {
        add_meta_box(
            'debugger_cache_status',
            __('Cache Status', 'sunny'),
            [ $this, 'renderHtml' ],
            'sunny_debuggers',
            'normal'
        );
    }

    /**
     * Enqueue admin scripts.
     *
     * @param string|null $hook Hook suffix of the current admin page.
     *
     * @return void
     */
    public function enqueueAdminScripts(string $hook = null)
    {
        wp_register_script(
            'sunny_debuggers_cache_status',
            plugins_url('partials/cache_status/cache_status.js', __FILE__),
            [ 'jquery' ],
            Sunny::VERSION
        );

        wp_localize_script('sunny_debuggers_cache_status', 'sunnyDebuggersCacheStatus', [
            'route' => esc_url_raw(rest_url('sunny/v2/caches/status')),
            'nonce' => wp_create_nonce('wp_rest'),
        ]);

        if (Admin::HOOK_SUFFIX !== $hook) {
            return;
        }

        wp_enqueue_script('sunny_debuggers_cache_status');
    }

    /**
     * Render the debugger HTML.
     *
     * @return void
     */
    public function renderHtml()
    {
        $view = new View(__DIR__ . '/partials/cache_status/cache_status.php');
        $view->echoKses($this);
    }
}
