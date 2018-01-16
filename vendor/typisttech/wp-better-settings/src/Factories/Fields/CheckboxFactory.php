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

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Factories\Fields;

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\Fields\Checkbox as CheckboxDecorator;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields\Checkbox;

/**
 * Final class CheckboxFactory
 */
final class CheckboxFactory extends AbstractFieldFactory
{
    /**
     * Build a Fields\Checkbox and its decorator.
     *
     * @param string $id    ID of this field. Should be unique for each section/page.
     * @param string $title Title of the field.
     * @param array  $args  Configuration for this Fields\Checkbox and its decorator.
     *
     * @return Checkbox
     */
    public function build(string $id, string $title, array $args): Checkbox
    {
        $checkbox = new Checkbox($id, $title, $args['sanitizeCallback'] ?? null);

        /* @var CheckboxDecorator $decorator */
        $decorator = $checkbox->getDecorator();

        $args['$value'] = $args['$value'] ?? $this->optionStore->getBoolean($id);
        $this->buildAbstractFieldDecorator($decorator, $args);

        if (is_string($args['label'] ?? null)) {
            $decorator->setLabel($args['label']);
        }

        return $checkbox;
    }
}
