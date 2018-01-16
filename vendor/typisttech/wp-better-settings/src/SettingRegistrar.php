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

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields\FieldInterface as Field;

/**
 * Final class SettingRegistrar.
 *
 * This class registers settings via the WordPress Settings API.
 * Thus, you don't have to deal with all the confusing callback code that the WordPress
 * Settings API forces you to use.
 */
final class SettingRegistrar
{
    /**
     * Option store instance.
     *
     * @var OptionStoreInterface;
     */
    private $optionStore;

    /**
     * Section instances.
     *
     * @var Section[];
     */
    private $sections;

    /**
     * Instantiate Settings object.
     *
     * @param OptionStoreInterface $optionHelper Option helper.
     * @param Section|Section[]    ...$sections  Section configuration.
     */
    public function __construct(OptionStoreInterface $optionHelper, Section ...$sections)
    {
        $this->optionStore = $optionHelper;
        $this->sections = $sections;
    }

    /**
     * Sections setter.
     *
     * @param Section|Section[] ...$sections Fields to be added.
     *
     * @return void
     */
    public function addSections(Section ...$sections)
    {
        $this->sections = array_unique(
            array_merge($this->sections, $sections),
            SORT_REGULAR
        );
    }

    /**
     * Initialize the settings persistence.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->sections as $section) {
            $this->registerSection($section);
        }
    }

    /**
     * Add a single settings section.
     *
     * @param Section $section Arguments for the `add_settings_section` WP function.
     *
     * @return void
     */
    private function registerSection(Section $section)
    {
        add_settings_section(
            $section->getPage(),
            $section->getTitle(),
            $section->getCallbackFunction(),
            $section->getPage()
        );

        foreach ($section->getFields() as $field) {
            $this->registerField($field, $section->getPage());
        }
    }

    /**
     * Register a single settings field to WordPress by `register_setting` and `add_settings_field`.
     *
     * @param Field  $field Arguments for the add_settings_field WP function.
     * @param string $page  Page which this field should be shown.
     *
     * @return void
     */
    private function registerField(Field $field, string $page)
    {
        $field->getDecorator()
              ->setValue($this->optionStore->get(
                  $field->getId()
              ));

        register_setting(
            $page,
            $field->getId(),
            $field->getSanitizeCallback()
        );

        add_settings_field(
            $field->getId(),
            $field->getTitle(),
            $field->getCallbackFunction(),
            $page,
            $page,
            [
                'label_for' => $field->getId(),
            ]
        );
    }
}
