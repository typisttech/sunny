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

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields;

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\Fields\Checkbox as CheckboxDecorator;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\ViewAwareInterface;

/**
 * Final class Checkbox
 */
final class Checkbox extends AbstractField
{
    /**
     * Sanitize checkbox
     *
     * Sanitize any input other than '1' to empty string.
     *
     * @param mixed $input User submitted value.
     *
     * @return string Empty string OR '1'
     */
    public function sanitizeCheckbox($input): string
    {
        $sanitizedInput = sanitize_text_field($input);

        return ('1' === $sanitizedInput) ? '1' : '';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDecorator(): ViewAwareInterface
    {
        return new CheckboxDecorator($this);
    }

    /**
     * {@inheritdoc}
     */
    public function getSanitizeCallback(): callable
    {
        return $this->sanitizeCallback ?? [ $this, 'sanitizeCheckbox' ];
    }
}
