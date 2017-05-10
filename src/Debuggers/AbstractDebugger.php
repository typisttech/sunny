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

namespace TypistTech\Sunny\Debuggers;

use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Sunny;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\View;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;

/**
 * Abstract class AbstractDebugger
 */
abstract class AbstractDebugger implements LoadableInterface
{
    const NAME = self::NAME;

    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [
            new Action('sunny_add_debugger_boxes', static::class, 'addMetaBox'),
            new Action('admin_enqueue_scripts', static::class, 'enqueueAdminScripts'),
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
            $this->getId(),
            $this->getMetaBoxTitle(),
            [ $this, 'renderHtml' ],
            'sunny_debuggers',
            'normal'
        );
    }

    /**
     * Id getter.
     *
     * @return string
     */
    public function getId(): string
    {
        return 'sunny_' . static::NAME . '_debugger';
    }

    /**
     * Meta box title getter.
     *
     * @return mixed
     */
    abstract protected function getMetaBoxTitle(): string;

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
            $this->getId(),
            plugins_url('partials/' . static::NAME . '/' . static::NAME . '.js', __FILE__),
            [ 'jquery' ],
            Sunny::VERSION
        );

        wp_localize_script($this->getId(), $this->getId(), [
            'route' => $this->getJsRoute(),
            'nonce' => wp_create_nonce('wp_rest'),
        ]);

        if (Admin::HOOK_SUFFIX !== $hook) {
            return;
        }

        wp_enqueue_script($this->getId());
    }

    /**
     * JS route getter.
     *
     * @return string
     */
    abstract protected function getJsRoute(): string;

    /**
     * Render the debugger HTML.
     *
     * @return void
     */
    public function renderHtml()
    {
        $view = new View(__DIR__ . '/partials/' . static::NAME . '/' . static::NAME . '.php');
        $view->echoKses($this);
    }
}
