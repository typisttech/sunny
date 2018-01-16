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

use TypistTech\Sunny\Vendor\League\Container\ContainerAwareInterface;
use TypistTech\Sunny\Vendor\League\Container\ContainerAwareTrait;

/**
 * Abstract class AbstractHook.
 */
abstract class AbstractHook implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    const ID_PREFIX = 'hook';

    /**
     * The number of arguments that should be passed to the $callback.
     *
     * @var integer
     */
    protected $acceptedArgs;

    /**
     * The callback method name.
     *
     * @var string
     */
    protected $callbackMethod;

    /**
     * Identifier of the entry to look for from container.
     *
     * @var string
     */
    protected $classIdentifier;

    /**
     * The name of the WordPress hook that is being registered.
     *
     * @var string
     */
    protected $hook;

    /**
     * The priority at which the function should be fired.
     *
     * @var integer
     */
    protected $priority;

    /**
     * Filter constructor.
     *
     * @param string       $hook            The name of the WordPress hook that is being registered.
     * @param string       $classIdentifier Identifier of the entry to look for from container.
     * @param string       $callbackMethod  The callback method name.
     * @param integer|null $priority        Optional.The priority at which the function should be fired. Default is 10.
     * @param integer|null $acceptedArgs    Optional. The number of arguments that should be passed to the $callback.
     *                                      Default is 1.
     */
    public function __construct(
        string $hook,
        string $classIdentifier,
        string $callbackMethod,
        int $priority = null,
        int $acceptedArgs = null
    ) {
        $this->hook            = $hook;
        $this->classIdentifier = $classIdentifier;
        $this->callbackMethod  = $callbackMethod;
        $this->priority        = $priority ?? 10;
        $this->acceptedArgs    = $acceptedArgs ?? 1;
    }

    /**
     * Add this hook to WordPress via add_action or add_filter.
     *
     * @return void
     */
    abstract public function registerToWordPress();

    /**
     * The actual callback that WordPress going to fire.
     *
     * @param array ...$args Arguments which pass on to the actual instance.
     *
     * @return mixed
     */
    abstract public function run(...$args);

    /**
     * Add this instance to container.
     *
     * @return void
     */
    public function registerToContainer()
    {
        $this->container->add(
            $this->getId(),
            $this,
            true
        );
    }

    /**
     * ID getter.
     *
     * @return string
     */
    public function getId(): string
    {
        return sprintf(
            '%1$s-%2$s-%3$s-%4$s-%5$d-%6$d',
            static::ID_PREFIX,
            $this->hook,
            $this->classIdentifier,
            $this->callbackMethod,
            $this->priority,
            $this->acceptedArgs
        );
    }
}
