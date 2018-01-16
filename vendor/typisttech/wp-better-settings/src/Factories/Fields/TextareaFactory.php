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

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\Fields\Textarea as TextareaDecorator;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields\Textarea;

/**
 * Final class TextareaFactory
 */
final class TextareaFactory extends AbstractFieldFactory
{
    /**
     * Build a Fields\Textarea and its decorator.
     *
     * @param string $id    ID of this field. Should be unique for each section/page.
     * @param string $title Title of the field.
     * @param array  $args  Configuration for this Fields\Textarea and its decorator.
     *
     * @return Textarea
     */
    public function build(string $id, string $title, array $args): Textarea
    {
        $textarea = new Textarea($id, $title, $args['sanitizeCallback'] ?? null);

        /* @var TextareaDecorator $decorator */
        $decorator = $textarea->getDecorator();

        $args['$value'] = $args['$value'] ?? $this->optionStore->getString($id);
        $this->buildAbstractFieldDecorator($decorator, $args);

        if (is_int($args['rows'] ?? null)) {
            $decorator->setRows($args['rows']);
        }

        return $textarea;
    }
}
