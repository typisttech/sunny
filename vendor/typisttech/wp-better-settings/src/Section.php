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

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings;

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\DecoratorAwareInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\DecoratorAwareTrait;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\Section as SectionDecorator;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields\AbstractField;

/**
 * Final class Section
 */
final class Section implements DecoratorAwareInterface
{
    use DecoratorAwareTrait;

    /**
     * Fields of this section.
     *
     * @var AbstractField[]
     */
    private $fields = [];

    /**
     * The page slug name which this section should be shown.
     *
     * @var string
     */
    private $page;

    /**
     * Title of the section.
     *
     * @var string
     */
    private $title;

    /**
     * Section constructor.
     *
     * @param string                        $page      The page slug name which this section should be shown.
     * @param string                        $title     Title of the section.
     * @param AbstractField|AbstractField[] ...$fields Fields of this section.
     */
    public function __construct(string $page, string $title, AbstractField ...$fields)
    {
        $this->page = $page;
        $this->title = $title;
        $this->fields = $fields;
    }

    /**
     * Fields setter.
     *
     * @param AbstractField|AbstractField[] ...$fields Fields to be added.
     *
     * @return void
     */
    public function addFields(AbstractField ...$fields)
    {
        $this->fields = array_unique(
            array_merge($this->fields, $fields),
            SORT_REGULAR
        );
    }

    /**
     * Fields getter.
     *
     * @return AbstractField[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Page getter.
     *
     * @return string
     */
    public function getPage(): string
    {
        return $this->page;
    }

    /**
     * Title getter.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDecorator(): SectionDecorator
    {
        return new SectionDecorator($this);
    }
}
