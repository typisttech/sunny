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

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views;

/**
 * Interface ViewInterface
 *
 * Accepts a context and echo its content on request.
 */
interface ViewInterface
{
    /**
     * Echo a given view safely.
     *
     * @param mixed $context Context for which to render the view.
     *
     * @return void
     */
    public function echoKses($context);
}
