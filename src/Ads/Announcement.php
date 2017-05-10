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

use TypistTech\Sunny\Admin;
use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;

/**
 * Final class Announcement
 */
final class Announcement implements LoadableInterface
{
    /**
     * The Sunny admin.
     *
     * @var Admin
     */
    private $admin;

    /**
     * Announcement constructor.
     *
     * @param Admin $admin The Sunny admin.
     */
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [
            new Action('admin_menu', __CLASS__, 'run', 20),
        ];
    }

    /**
     * Render announcement.
     *
     * @return void
     */
    public function render()
    {
        $first = __('<code>Sunny</code> 2 is a major update. Please reconfigure your Cloudflare credentials.', 'sunny');

        // Translators: %1$s is the url of WP Cloudflare Guard.
        $secondFormat = __(
            'Security functionalities have been separated to <a href="%1$s">WP Cloudflare Guard</a>',
            'sunny'
        );
        $second = sprintf($secondFormat, 'https://wordpress.org/plugins/wp-cloudflare-guard/');

        echo wp_kses_post($first . '<br/>' . $second);
    }

    /**
     * Add announcement to all Sunny menu pages.
     *
     * @return void
     */
    public function run()
    {
        $hooks = array_map(function (string $menuSlug) {
            return str_replace('-', '_', $menuSlug . '_after_option_form');
        }, $this->admin->getMenuSlugs());

        foreach ($hooks as $hook) {
            add_action($hook, [ $this, 'render' ]);
        }
    }
}
