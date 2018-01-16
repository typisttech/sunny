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

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\DecoratorAwareInterface;

/**
 * Interface FieldInterface
 */
interface FieldInterface extends DecoratorAwareInterface
{
    /**
     * Returns the function to be called to output the content for this page.
     *
     * @return callable
     */
    public function getCallbackFunction(): callable;

    /**
     * Id getter.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * SanitizeCallback getter.
     *
     * @return callable
     */
    public function getSanitizeCallback(): callable;

    /**
     * Title getter.
     *
     * @return string
     */
    public function getTitle(): string;
}
