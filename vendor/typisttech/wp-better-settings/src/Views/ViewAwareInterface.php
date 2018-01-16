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
 * Interface ViewAwareInterface.
 */
interface ViewAwareInterface
{
    /**
     * Echo the view safely.
     *
     * @return void
     */
    public function echoView();

    /**
     * Returns the function to be called to output the content for this page.
     *
     * @return callable
     */
    public function getCallbackFunction(): callable;

    /**
     * View setter.
     *
     * @param ViewInterface $view The view object.
     *
     * @return void
     */
    public function setView(ViewInterface $view);
}
