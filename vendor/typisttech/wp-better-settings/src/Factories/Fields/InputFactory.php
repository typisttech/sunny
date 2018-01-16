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

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\Fields\Input as InputDecorator;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields\AbstractField;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields\Email;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields\Text;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields\Url;

/**
 * Final class InputFactory
 */
final class InputFactory extends AbstractFieldFactory
{
    /**
     * Build a Fields\Input and its decorator.
     *
     * @param string $id    ID of this field. Should be unique for each section/page.
     * @param string $title Title of the field.
     * @param array  $args  Configuration for this Fields\Input and its decorator.
     *
     * @return AbstractField
     */
    public function build(string $id, string $title, array $args): AbstractField
    {
        $input = $this->buildInput(
            $args['type'] ?? 'text',
            $id,
            $title,
            $args['sanitizeCallback'] ?? null
        );

        /* @var InputDecorator $decorator */
        $decorator = $input->getDecorator();

        $args['$value'] = $args['$value'] ?? $this->optionStore->getBoolean($id);
        $this->buildAbstractFieldDecorator($decorator, $args);

        return $input;
    }

    /**
     * Build input.
     *
     * @param string     $type             The input type, one of: email, url or text.
     * @param string     $id               ID of this field. Should be unique for each section/page.
     * @param string     $title            Title of the field.
     * @param mixed|null $sanitizeCallback Optional. Function that sanitize this field.
     *
     * @return AbstractField
     */
    private function buildInput(string $type, string $id, string $title, $sanitizeCallback): AbstractField
    {
        switch ($type) {
            case 'email':
                return new Email($id, $title, $sanitizeCallback);
            case 'url':
                return new Url($id, $title, $sanitizeCallback);
            default:
                return new Text($id, $title, $sanitizeCallback);
        }
    }
}
