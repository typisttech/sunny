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
 * Trait ViewAwareTrait.
 */
trait ViewAwareTrait
{
    /**
     * ViewInterface object to render.
     *
     * @var ViewInterface
     */
    protected $view;

    /**
     * Default view getter.
     *
     * @return ViewInterface
     */
    abstract protected function getDefaultView(): ViewInterface;

    /**
     * Echo the view safely.
     *
     * @return void
     */
    public function echoView()
    {
        $this->getView()->echoKses($this);
    }

    /**
     * View getter.
     *
     * @return ViewInterface
     */
    protected function getView(): ViewInterface
    {
        $this->view = $this->view ?? $this->getDefaultView();

        return $this->view;
    }

    /**
     * View setter.
     *
     * @param ViewInterface $view The view object.
     *
     * @return void
     */
    public function setView(ViewInterface $view)
    {
        $this->view = $view;
    }

    /**
     * Returns the function to be called to output the content for this page.
     *
     * @return callable
     */
    public function getCallbackFunction(): callable
    {
        return [ $this, 'echoView' ];
    }
}
