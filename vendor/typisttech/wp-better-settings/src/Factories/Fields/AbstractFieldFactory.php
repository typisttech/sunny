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

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\Fields\AbstractField as AbstractFieldDecorator;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields\AbstractField;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\OptionStore;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\View;

/**
 * Final class AbstractFieldFactory
 */
abstract class AbstractFieldFactory
{
    /**
     * The plugin option store.
     *
     * @var OptionStore
     */
    protected $optionStore;

    /**
     * CheckboxFactory constructor.
     *
     * @param OptionStore $optionStore The plugin option store.
     */
    public function __construct(OptionStore $optionStore)
    {
        $this->optionStore = $optionStore;
    }

    /**
     * Build a AbstractField and its decorator.
     *
     * @param string $id    ID of this field. Should be unique for each section/page.
     * @param string $title Title of the field.
     * @param array  $args  Configuration for this AbstractField and its decorator.
     *
     * @return AbstractField
     */
    abstract public function build(string $id, string $title, array $args);

    /**
     * Configure a Decorators\Fields\AbstractField
     *
     * @param AbstractFieldDecorator $decorator The field decorator.
     * @param array                  $args      Configuration for this field decorator.
     *
     * @return void
     */
    protected function buildAbstractFieldDecorator(AbstractFieldDecorator $decorator, array $args)
    {
        if (($args['view'] ?? null) instanceof View) {
            $decorator->setView($args['view']);
        }

        if (is_string($args['description'] ?? null)) {
            $decorator->setDescription($args['description']);
        }

        if (is_string($args['htmlClass'] ?? null)) {
            $decorator->setHtmlClass($args['htmlClass']);
        }

        if (is_bool($args['enabled'] ?? null) && $args['enabled']) {
            $decorator->enable();
        }

        if (is_bool($args['disabled'] ?? null) && $args['disabled']) {
            $decorator->disable();
        }

        if ($args['$value'] ?? $this->optionStore->get($args['id'])) {
            $decorator->setValue($args['$value']);
        }
    }
}
