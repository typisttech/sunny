<?php
/**
 * Sunny
 *
 * Automatically purge CloudFlare cache, including cache everything rules.
 *
 * @package   Sunny
 *
 * @author    Typist Tech <sunny@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 *
 * @see       https://www.typist.tech/projects/sunny
 * @see       https://wordpress.org/plugins/sunny/
 */

declare(strict_types=1);

namespace TypistTech\Sunny\Cloudflare;

use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields\Email;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Fields\Text;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Pages\MenuPage;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Section;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Filter;

/**
 * Final class Admin.
 *
 * The admin-specific functionality of Cloudflare settings.
 */
final class Admin implements LoadableInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [
            new Filter('sunny_pages', __CLASS__, 'addPage'),
            new Filter('sunny_settings_sections', __CLASS__, 'addSettingsSection'),
        ];
    }

    /**
     * Add the menu page config.
     *
     * @param (MenuPage|SubmenuPage)[] $pages Menu and submenu page configurations.
     *
     * @return (MenuPage|SubmenuPage)[]
     */
    public function addPage(array $pages): array
    {
        $pages[] = new MenuPage(
            'sunny-cloudflare',
            __('Sunny', 'sunny'),
            __('Sunny - Cloudflare', 'sunny'),
            null,
            'dashicons-shield'
        );

        return $pages;
    }

    /**
     * Add settings section config.
     *
     * @param Section[] $sections Settings section configurations.
     *
     * @return Section[]
     */
    public function addSettingsSection(array $sections): array
    {
        $email = new Email(
            'sunny_cloudflare_email',
            __('Cloudflare Email', 'sunny')
        );
        $email->getDecorator()
              ->setDescription(
                  __(
                      'The email address associated with your Cloudflare account.',
                      'sunny'
                  )
              );

        $apiKey = new Text(
            'sunny_cloudflare_api_key',
            __('Global API Key', 'sunny')
        );
        $apiKeyDesc = sprintf(
            // Translators: %1$s is the url to Cloudflare document.
            __('Help: <a href="%1$s">Where do I find my Cloudflare API key?</a>', 'sunny'),
            esc_url_raw(
                'https://support.cloudflare.com/hc/en-us/articles/200167836-Where-do-I-find-my-CloudFlare-API-key-'
            )
        );
        $apiKey->getDecorator()
               ->setDescription($apiKeyDesc);

        $zoneId = new Text(
            'sunny_cloudflare_zone_id',
            __('Zone ID', 'sunny')
        );
        $zoneId->getDecorator()
               ->setDescription(
                   __('Zone identifier for this domain', 'sunny')
               );

        $sections[] = new Section(
            'sunny-cloudflare',
            __('Cloudflare Settings', 'sunny'),
            $email,
            $apiKey,
            $zoneId
        );

        return $sections;
    }
}
