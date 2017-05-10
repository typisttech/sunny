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

namespace TypistTech\Sunny\Ads;

use TypistTech\Sunny\Debuggers\DebuggerAdmin;
use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Sunny;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\View;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;
use WP_User;

/**
 * Final class Newsletter
 */
final class Newsletter implements LoadableInterface
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
     * @todo Add to all Sunny pages.
     *
     * @return void
     */
    public function addMetaBox()
    {
        add_meta_box(
            'sunny_newsletter',
            __('Newsletter', 'sunny'),
            [ $this, 'renderHtml' ],
            'sunny_debuggers',
            'side'
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
        wp_register_style(
            'sunny_mailerlite',
            plugins_url('partials/newsletter/newsletter.css', __FILE__),
            [],
            Sunny::VERSION
        );

        wp_register_script(
            'sunny_mailerlite_form',
            plugins_url('partials/newsletter/newsletter.js', __FILE__),
            [],
            Sunny::VERSION
        );

        wp_register_script(
            'sunny_mailerlite',
            '//static.mailerlite.com/js/w/webforms.min.js?v3772b61f1ec61c541c401d4eadfdd02f',
            [ 'sunny_mailerlite_form' ],
            Sunny::VERSION
        );

        if (DebuggerAdmin::HOOK_SUFFIX !== $hook) {
            return;
        }

        wp_enqueue_script('sunny_mailerlite');
        wp_enqueue_style('sunny_mailerlite');
    }

    /**
     * Current user email getter.
     *
     * @return string
     */
    public function getCurrentUserEmail(): string
    {
        $currentUser = wp_get_current_user();

        if (! $currentUser instanceof WP_User) {
            return '';
        }

        return $currentUser->user_email;
    }

    /**
     * Render the newsletter form HTML.
     *
     * @return void
     */
    public function renderHtml()
    {
        $view = new View(__DIR__ . '/partials/newsletter/newsletter.php');
        $view->echoKses($this);
    }
}
