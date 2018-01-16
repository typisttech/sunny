<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   TypistTech\WPBetterSettings
 *
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 *
 * @see       https://www.typist.tech/projects/wp-better-settings
 * @see       https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings;

/* @var Decorators\Pages\TabbedPageInterface $context Context */

?>

<div class="wrap">

    <?php do_action($context->getSnakecasedMenuSlug() . '_before_page_title'); ?>

    <h1><?php echo esc_html($context->getPageTitle()); ?></h1>

    <?php do_action($context->getSnakecasedMenuSlug() . '_after_page_title'); ?>

    <?php do_action($context->getSnakecasedMenuSlug() . '_before_nav_tabs'); ?>

    <h2 class="nav-tab-wrapper">

        <?php
        /* @var Decorators\Page $tab */
        foreach ($context->getTabs() as $tab) {
            $active = '';
            if ($context->getMenuSlug() === $tab->getMenuSlug()) {
                $active = ' nav-tab-active';
            }

            echo sprintf(
                '<a href="%1$s" class="nav-tab%2$s" id="%3$s-tab">%4$s</a>',
                esc_url($tab->getUrl()),
                esc_attr($active),
                esc_attr($tab->getMenuSlug()),
                esc_html($tab->getMenuTitle())
            );
        }
        ?>

    </h2>

    <?php do_action($context->getSnakecasedMenuSlug() . '_after_nav_tabs'); ?>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">

            <div id="post-body-content">
                <?php include __DIR__ . '/options-form.php'; ?>
            </div><!-- #post-body-content -->

            <?php do_action($context->getSnakecasedMenuSlug() . '_before_postbox_containers'); ?>
            <div id="postbox-container-1" class="postbox-container">
                <?php do_meta_boxes($context->getSnakecasedMenuSlug(), 'side', null); ?>
            </div>

            <div id="postbox-container-2" class="postbox-container">
                <?php do_meta_boxes($context->getSnakecasedMenuSlug(), 'normal', null); ?>
                <?php do_meta_boxes($context->getSnakecasedMenuSlug(), 'advanced', null); ?>
            </div>
            <?php do_action($context->getSnakecasedMenuSlug() . '_after_postbox_containers'); ?>
        </div><!-- #post-body -->

    </div><!-- #poststuff -->

</div><!-- .warp -->
