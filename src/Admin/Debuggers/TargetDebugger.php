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
 * Final class TargetDebugger
 */
final class TargetDebugger implements LoadableInterface
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
            'sunny_target_debugger',
            __('Targets', 'sunny'),
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
            'sunny_target_debugger',
            plugins_url('partials/target/target.js', __FILE__),
            [ 'jquery' ],
            Sunny::VERSION
        );

        wp_localize_script('sunny_target_debugger', 'sunny_target_debugger', [
            'route' => esc_url_raw(rest_url('sunny/v2/targets')),
            'nonce' => wp_create_nonce('wp_rest'),
        ]);

        if (Admin::HOOK_SUFFIX !== $hook) {
            return;
        }

        wp_enqueue_script('sunny_target_debugger');
    }

    /**
     * Render the debugger HTML.
     *
     * @return void
     */
    public function renderHtml()
    {
        $view = new View(__DIR__ . '/partials/target/target.php');
        $view->echoKses($this);
    }
}
