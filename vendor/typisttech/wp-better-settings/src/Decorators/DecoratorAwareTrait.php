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
 * Trait DecoratorAwareTrait
 */
trait DecoratorAwareTrait
{
    /**
     * Decorator for this object.
     *
     * @var ViewAwareInterface
     */
    protected $decorator;

    /**
     * Default decorator getter.
     *
     * @return ViewAwareInterface
     */
    abstract protected function getDefaultDecorator(): ViewAwareInterface;

    /**
     * {@inheritdoc}
     */
    public function getCallbackFunction(): callable
    {
        return $this->getDecorator()->getCallbackFunction();
    }

    /**
     * {@inheritdoc}
     */
    public function getDecorator(): ViewAwareInterface
    {
        $this->decorator = $this->decorator ?? $this->getDefaultDecorator();

        return $this->decorator;
    }

    /**
     * Decorator setter.
     *
     * @param ViewAwareInterface $decorator New decorator.
     *
     * @return void
     */
    public function setDecorator(ViewAwareInterface $decorator)
    {
        $this->decorator = $decorator;
    }
}
