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

namespace TypistTech\Sunny;

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\Pages\TabbedPageInterface;

/* @var TabbedPageInterface $context Context */

echo '<div class="wrap">';

do_action($context->getSnakecasedMenuSlug() . '_before_page_title');

echo '<h1>' . esc_html($context->getPageTitle()) . '</h1>';

do_action($context->getSnakecasedMenuSlug() . '_after_page_title');

do_action($context->getSnakecasedMenuSlug() . '_before_nav_tabs');

echo '<h2 class="nav-tab-wrapper">';

/* @var TabbedPageInterface $tab */
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
echo '</h2>';

do_action($context->getSnakecasedMenuSlug() . '_after_nav_tabs');

do_action($context->getSnakecasedMenuSlug() . '_content');

do_action($context->getSnakecasedMenuSlug() . '_after_option_form');
echo '</div>';
