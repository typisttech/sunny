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

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators;

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\ViewAwareInterface;

/**
 * Interface DecoratorAwareInterface
 */
interface DecoratorAwareInterface
{
    /**
     * Returns the function to be called to output the content for this page.
     *
     * @return callable
     */
    public function getCallbackFunction(): callable;

    /**
     * Decorator getter.
     *
     * @return ViewAwareInterface
     */
    public function getDecorator(): ViewAwareInterface;

    /**
     * Decorator setter.
     *
     * @param ViewAwareInterface $decorator New decorator.
     *
     * @return void
     */
    public function setDecorator(ViewAwareInterface $decorator);
}
