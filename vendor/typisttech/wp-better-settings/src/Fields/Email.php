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

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\Fields\Input as InputDecorator;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\ViewAwareInterface;

/**
 * Final class Email
 */
final class Email extends AbstractField
{
    /**
     * Sanitize email
     *
     * Strips out all characters that are not allowable in an email address.
     * Add settings error if email is not valid.
     *
     * @param mixed $input Input email.
     *
     * @return string Valid email address OR empty string.
     */
    public function sanitizeEmail($input): string
    {
        $sanitizedInput = sanitize_email($input);
        if (! empty($input) && ! is_email($sanitizedInput)) {
            // @codingStandardsIgnoreStart
            $errorMessage = __(
                'Sorry, that isn&#8217;t a valid email address. Email addresses look like <code>username@example.com</code>.',
                'sunny'
            );
            // @codingStandardsIgnoreEnd
            add_settings_error($this->id, 'invalid_' . $this->id, $errorMessage);
        }

        return $sanitizedInput;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDecorator(): ViewAwareInterface
    {
        return new InputDecorator($this, 'email');
    }

    /**
     * {@inheritdoc}
     */
    public function getSanitizeCallback(): callable
    {
        return $this->sanitizeCallback ?? [ $this, 'sanitizeEmail' ];
    }
}
