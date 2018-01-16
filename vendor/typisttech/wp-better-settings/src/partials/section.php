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

/* @var Decorators\Section $context Context */

do_action($context->getSnakecasedMenuSlug() . '_before_section_content');

if (! empty($context->getContent())) {
    echo wp_kses_post($context->getContent());
}

do_action($context->getSnakecasedMenuSlug() . '_after_section_content');
