<?php
/**
 * Sunny
 *
 * Automatically purge CloudFlare cache, including cache everything rules.
 *
 * @package   Sunny
 *
 * @author    Typist Tech <sunny@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 *
 * @see       https://www.typist.tech/projects/sunny
 * @see       https://wordpress.org/plugins/sunny/
 */

declare(strict_types=1);

namespace TypistTech\Sunny\Targets;

use TypistTech\Sunny\Targets\Strategies\StrategyInterface;

/**
 * Final class Targets
 */
final class Targets
{
    /**
     * Strategies
     *
     * @var StrategyInterface[]
     */
    private $strategies;

    /**
     * Post constructor.
     *
     * @param StrategyInterface[] $strategies Strategies to get related urls.
     */
    public function __construct(array $strategies)
    {
        $this->setStrategies(...$strategies);
    }

    /**
     * Strategies setter.
     *
     * @param StrategyInterface[] ...$strategies New strategies to get related urls.
     *
     * @return void
     */
    private function setStrategies(StrategyInterface ...$strategies)
    {
        $this->strategies = $strategies;
    }

    /**
     * Locate all targets.
     *
     * @return array The targeted URLs.
     */
    public function all(): array
    {
        $targets = array_reduce($this->strategies, function (array $carry, StrategyInterface $strategy) {
            $carry[ $strategy->getKey() ] = $strategy->all();

            return $carry;
        }, []);

        return apply_filters(
            'sunny_targets',
            array_filter($targets)
        );
    }
}
