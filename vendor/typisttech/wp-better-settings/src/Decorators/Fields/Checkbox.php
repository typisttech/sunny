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
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\ViewInterface;

/**
 * Final class Checkbox
 *
 * This class defines necessary methods for rendering `src/partials/fields/checkbox.php`.
 */
final class Checkbox extends AbstractField
{
    /**
     * The label
     *
     * @var string
     */
    private $label = '';

    /**
     * Label getter.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Label setter.
     *
     * @param string $label The new label.
     *
     * @return void
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultView(): ViewInterface
    {
        return ViewFactory::build('fields/checkbox');
    }
}
