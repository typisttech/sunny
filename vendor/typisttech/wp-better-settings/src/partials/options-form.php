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

/* @var Decorators\Pages\TabbedPageInterface $context Context*/

settings_errors();

do_action($context->getSnakecasedMenuSlug() . '_before_option_form');
echo '<form action="options.php" method="post">';

settings_fields($context->getMenuSlug());

do_action($context->getSnakecasedMenuSlug() . '_before_settings_sections');
do_settings_sections($context->getMenuSlug());
do_action($context->getSnakecasedMenuSlug() . '_after_settings_sections');

do_action($context->getSnakecasedMenuSlug() . '_before_submit_button');
submit_button();
do_action($context->getSnakecasedMenuSlug() . '_after_submit_button');

echo '</form>';
do_action($context->getSnakecasedMenuSlug() . '_after_option_form');
