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
use TypistTech\Sunny\Vendor\Yoast_I18n_WordPressOrg_v2;

/**
 * Final class I18nPromoter
 */
final class I18nPromoter implements LoadableInterface
{
    /**
     * The Sunny admin.
     *
     * @var Admin
     */
    private $admin;

    /**
     * I18nPromoter constructor.
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
     * Initialize Yoast i18n module to all Sunny menu pages.
     *
     * @return void
     */
    public function run()
    {
        $hooks = array_map(
            function (string $menuSlug) {
                return $menuSlug . '_after_postbox_containers';
            },
            $this->admin->getSnakecasedMenuSlugs()
        );

        foreach ($hooks as $hook) {
            new Yoast_I18n_WordPressOrg_v2(
                [
                    'textdomain' => 'sunny',
                    'plugin_name' => 'Sunny',
                    'hook' => $hook,
                ]
            );
        }
    }
}
