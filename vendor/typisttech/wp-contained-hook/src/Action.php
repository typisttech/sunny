<?php
/**
 * WP Contained Hook
 *
 * Lazily instantiate objects from dependency injection container
 * to WordPress hooks (actions and filters).
 *
 * @package   TypistTech\WPContainedHook
 * @author    Typist Tech <wp-contained-hook@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   MIT
 * @see       https://www.typist.tech/projects/wp-contained-hook
 */

declare(strict_types=1);

namespace TypistTech\Sunny\Vendor\TypistTech\WPContainedHook;

/**
 * Final class Action
 */
final class Action extends AbstractHook
{
    const ID_PREFIX = 'action';

    /**
     * {@inheritdoc}
     */
    public function registerToWordPress()
    {
        add_action(
            $this->hook,
            [ $this, 'run' ],
            $this->priority,
            $this->acceptedArgs
        );
    }

    /**
     * The actual callback that WordPress going to fire.
     *
     * @param array ...$args Arguments which pass on to the actual instance.
     */
    public function run(...$args)
    {
        $instance = $this->container->get($this->classIdentifier);
        $instance->{$this->callbackMethod}(...$args);
    }
}
