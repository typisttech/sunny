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
 * Final class Targets
 */
final class Targets implements LoadableInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [
            new Action('sunny_debuggers_content', __CLASS__, 'renderHtml'),
            new Action('admin_enqueue_scripts', __CLASS__, 'enqueueAdminScripts'),
        ];
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
            'sunny_debuggers_targets',
            plugins_url('partials/targets/targets.js', __FILE__),
            [ 'jquery' ],
            Sunny::VERSION
        );

        wp_localize_script('sunny_debuggers_targets', 'sunnyDebuggersTargets', [
            'route' => esc_url_raw(rest_url('sunny/v2/targets')),
            'nonce' => wp_create_nonce('wp_rest'),
        ]);

        if ('sunny_page_sunny-debuggers' !== $hook) {
            return;
        }

        wp_enqueue_script('sunny_debuggers_targets');
    }

    /**
     * Render the debugger HTML.
     *
     * @return void
     */
    public function renderHtml()
    {
        $view = new View(__DIR__ . '/partials/targets/targets.php');
        $view->echoKses($this);
    }
}
