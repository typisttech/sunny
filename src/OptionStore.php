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

namespace TypistTech\Sunny;

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\OptionStore as WPBSOptionStore;

/**
 * Final class OptionStore
 *
 * The get_option functionality of the plugin.
 */
final class OptionStore extends WPBSOptionStore
{
    /**
     * Cloudflare api key getter.
     *
     * @return string
     */
    public function getApiKey(): string
    {
        $value = $this->get('sunny_cloudflare_api_key');

        return is_string($value) ? $value : '';
    }

    /**
     * Cloudflare email getter.
     *
     * @return string
     */
    public function getEmail(): string
    {
        $value = $this->get('sunny_cloudflare_email');

        return is_string($value) ? $value : '';
    }

    /**
     * Cloudflare zone id getter.
     *
     * @return string
     */
    public function getZoneId(): string
    {
        $value = $this->get('sunny_cloudflare_zone_id');

        return is_string($value) ? $value : '';
    }
}
