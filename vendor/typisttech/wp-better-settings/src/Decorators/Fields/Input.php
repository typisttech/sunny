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

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Factories\ViewFactory;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields\FieldInterface as OriginalField;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\ViewInterface;

/**
 * Final class Input
 *
 * This class defines necessary methods for rendering `src/partials/fields/input.php`.
 */
final class Input extends AbstractField
{
    /**
     * Type of this input.
     *
     * @var string
     */
    private $type;

    /**
     * Input constructor.
     *
     * @param OriginalField $original The object being decorated.
     * @param string        $type     The input type.
     */
    public function __construct(OriginalField $original, string $type)
    {
        parent::__construct($original);
        $this->type = $type;
    }

    /**
     * Type getter.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultView(): ViewInterface
    {
        return ViewFactory::build('fields/input');
    }
}
