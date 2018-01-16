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

/* @var Decorators\Fields\Checkbox $context Context */

echo '<fieldset>';
echo '<legend class="screen-reader-text"><span>' . esc_html($context->getTitle()) . '</span></legend>';

echo '<label for="' . esc_html($context->getId()) . '">';

echo '<input type="checkbox" value="1" ';
echo 'class="' . esc_attr($context->getHtmlClass()) . '" ';
echo 'name="' . esc_attr($context->getId()) . '" ';
echo 'id="' . esc_attr($context->getId()) . '" ';
if (! empty($context->getDescription())) {
    echo 'aria-describedby="' . esc_attr(esc_attr($context->getId() . '-description')) . '" ';
}
disabled($context->isDisabled());
checked($context->getValue());
echo ' >';

echo wp_kses_post($context->getLabel());

echo '</label>';

if (! empty($context->getDescription())) {
    echo '<p class="description" ';
    echo 'id="' . esc_attr($context->getId() . '-description') . '">';
    echo wp_kses_post($context->getDescription());
    echo '</p>';
}

echo '</fieldset>';
