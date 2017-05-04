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

namespace TypistTech\Sunny\Api;

use TypistTech\Sunny\OptionStore;
use TypistTech\Sunny\Vendor\Cloudflare\Zone\Cache as CloudflareCache;

/**
 * Final class Cache
 *
 * Api adopter
 */
final class Cache
{
    /**
     * The api client
     *
     * @var CloudflareCache
     */
    private $client;

    /**
     * The Sunny option store
     *
     * @var OptionStore
     */
    private $optionStore;

    /**
     * Cache constructor.
     *
     * @param OptionStore          $optionStore The Sunny option store.
     * @param CloudflareCache|null $client      Optional. The api client.
     */
    public function __construct(OptionStore $optionStore, CloudflareCache $client = null)
    {
        $this->optionStore = $optionStore;
        $this->client = $client ?? new CloudflareCache;
    }

    /**
     * Purge individual files (permission needed: #zone:edit).
     * Remove one or more files from CloudFlare's cache.
     *
     * @param string|string[] ...$urls URLs that should be removed from cache. Maximum: 30 urls.
     *
     * @return array|\WP_Error
     */
    public function purgeFiles(string ...$urls)
    {
        $this->setUpClient();

        return $this->client->purge_files(
            $this->optionStore->getZoneId(),
            $urls
        );
    }

    /**
     * Set up client auth key and email.
     *
     * @return void
     */
    private function setUpClient()
    {
        $this->client->setAuthKey(
            $this->optionStore->getApiKey()
        );
        $this->client->setEmail(
            $this->optionStore->getEmail()
        );
    }
}
