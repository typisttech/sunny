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

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields;

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\DecoratorAwareTrait;

/**
 * Abstract class AbstractField
 */
abstract class AbstractField implements FieldInterface
{
    use DecoratorAwareTrait;

    /**
     * ID of this field. Should be unique for each section/page.
     *
     * @var string
     */
    protected $id;

    /**
     * Function that sanitize this field.
     *
     * @var callable|null
     */
    protected $sanitizeCallback;

    /**
     * Title of the field.
     *
     * @var string
     */
    protected $title;

    /**
     * AbstractField constructor.
     *
     * @param string     $id               ID of this field. Should be unique for each section/page.
     * @param string     $title            Title of the field.
     * @param mixed|null $sanitizeCallback Optional. Function that sanitize this field.
     */
    public function __construct(
        string $id,
        string $title,
        $sanitizeCallback = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->sanitizeCallback = $sanitizeCallback;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getSanitizeCallback(): callable
    {
        return $this->sanitizeCallback ?? 'sanitize_text_field';
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
