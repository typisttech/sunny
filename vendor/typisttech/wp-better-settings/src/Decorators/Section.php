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

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Factories\ViewFactory;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Section as DecoratedSection;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\View;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\ViewAwareInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\ViewAwareTrait;

/**
 * Final class Section
 *
 * This class defines necessary methods for rendering `src/partials/section.php`.
 */
final class Section implements ViewAwareInterface
{
    use ViewAwareTrait;

    /**
     * Content to be printed after the section title.
     *
     * @var string
     */
    private $content = '';

    /**
     * The decorated section.
     *
     * @var DecoratedSection
     */
    private $section;

    /**
     * Section constructor.
     *
     * @param DecoratedSection $section The decorated section.
     */
    public function __construct(DecoratedSection $section)
    {
        $this->section = $section;
    }

    /**
     * Content getter.
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Content setter.
     *
     * @param string $content Content to be printed after the section title.
     *
     * @return void
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * {@inheritdoc}
     */
    public function getSnakecasedMenuSlug(): string
    {
        $lowercaseMenuSlug = strtolower($this->section->getPage());

        return str_replace('-', '_', $lowercaseMenuSlug);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultView(): View
    {
        return ViewFactory::build('section');
    }
}
