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

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\Fields;

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields\FieldInterface as OriginalField;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\ViewAwareInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\ViewAwareTrait;

/**
 * Abstract class AbstractField
 */
abstract class AbstractField implements ViewAwareInterface
{
    use ViewAwareTrait;

    /**
     * Description
     *
     * @var string
     */
    protected $description = '';

    /**
     * Should be rendered as disabled
     *
     * @var bool
     */
    protected $disabled = false;

    /**
     * HTML class for this field
     *
     * @var string
     */
    protected $htmlClass = 'regular-text';

    /**
     * The object being decorated.
     *
     * @var OriginalField
     */
    protected $original;

    /**
     * Value of this field
     *
     * @var mixed
     */
    protected $value;

    /**
     * AbstractField constructor.
     *
     * @param OriginalField $original The object being decorated.
     */
    public function __construct(OriginalField $original)
    {
        $this->original = $original;
    }

    /**
     * Set disabled to true
     *
     * @return void
     */
    public function disable()
    {
        $this->disabled = true;
    }

    /**
     * Set disabled to false
     *
     * @return void
     */
    public function enable()
    {
        $this->disabled = false;
    }

    /**
     * Description getter.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Description setter.
     *
     * @param string $description The new description.
     *
     * @return void
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * HtmlClass getter.
     *
     * @return string
     */
    public function getHtmlClass(): string
    {
        return $this->htmlClass;
    }

    /**
     * HtmlClass setter.
     *
     * @param string $htmlClass The new html class.
     *
     * @return void
     */
    public function setHtmlClass(string $htmlClass)
    {
        $this->htmlClass = $htmlClass;
    }

    /**
     * Id getter.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->original->getId();
    }

    /**
     * Title getter.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->original->getTitle();
    }

    /**
     * Value getter.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Value setter.
     *
     * @param mixed $value Field value.
     *
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get disabled from extra.
     *
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
