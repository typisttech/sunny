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

namespace TypistTech\Sunny\Caches;

/**
 * Final class Status
 */
final class Status
{
    const STATUSES = [ 'HIT', 'MISS', 'EXPIRED', 'STALE', 'IGNORED', 'REVALIDATED', 'UPDATING' ];

    /**
     * Whether this file is severed by Cloudflare.
     *
     * @var bool
     */
    private $isCloudflare;

    /**
     * Response object.
     *
     * @var array|\WP_Error
     */
    private $response;

    /**
     * Cache status, one of HIT, MISS, EXPIRED, STALE, IGNORED, REVALIDATED, UPDATING, UNKNOWN, NOT_CF
     *
     * @var string
     */
    private $status = 'UNKNOWN';

    /**
     * File url of this status check.
     *
     * @var string
     */
    private $url;

    /**
     * Status constructor.
     *
     * @param string $url File url of this status check.
     */
    public function __construct(string $url)
    {
        $this->url = esc_url_raw($url);
    }

    /**
     * Check cache status.
     *
     * @return array
     */
    public function check(): array
    {
        $this->response = wp_safe_remote_get($this->url);

        if (is_wp_error($this->response)) {
            return [
                'result' => 'error',
                'url' => $this->url,
                'error' => $this->response,
            ];
        }

        $this->setAttributes();

        return [
            'result' => 'done',
            'url' => $this->url,
            'is_cloudflare' => $this->isCloudflare,
            'status' => $this->status,
            'status_message' => $this->getStatusMessage(),
        ];
    }

    /**
     * Set attributes according to response object.
     *
     * @return void
     */
    private function setAttributes()
    {
        if (! is_array($this->response)) {
            return;
        }

        $status = wp_remote_retrieve_header($this->response, 'cf-cache-status');

        if (in_array($status, self::STATUSES, true)) {
            $this->status = $status;
        }

        $this->isCloudflare = ! empty(wp_remote_retrieve_header($this->response, 'cf-ray'));
        if (false === $this->isCloudflare) {
            $this->status = 'NOT_CF';
        }
    }

    /**
     * Status message getter.
     *
     * @return string
     */
    private function getStatusMessage(): string
    {
        // @codingStandardsIgnoreStart
        $messages = [
            'HIT' => __('Resource in cache, served from Cloudflare CDN cache', 'sunny'),
            'MISS' => __('Resource not in Cloudflare  cache, served from origin server', 'sunny'),
            'EXPIRED' => __('Resource was in Cloudflare cache but has since expired, served from origin server', 'sunny'),
            'STALE' => __("Resource is in cache but is expired, served from Cloudflare CDN cache because another visitor's request has caused the CDN to fetch the resource from the origin server. This is a very uncommon occurrence and will only impact visitors that want the page right when it expires.", 'sunny'),
            'IGNORED' => __("Resource is cacheable but not in Cloudflare cache because it hasn't met the threshold (number of requests, usually 3), served from origin server. Will become a HIT once it passes the threshold.", 'sunny'),
            'REVALIDATED' => __('REVALIDATED means Cloudflare had a stale representation of the object in Cloudflare cache, but Cloudflare revalidated it by checking using an If-Modified-Since header.', 'sunny'),
            'UPDATING' => __('A status of UPDATING indicates that the cache is currently populating for that resource and the response was served stale from the existing cached item. This status is typically only seen when large and/or very popular resources are being added to the cache.', 'sunny'),
            'UNKNOWN' => __('Resource is not something Cloudflare would ordinarily cache. Check your cache everything page rules.', 'sunny'),
            'NOT_CF' => __('Resource is not served by Cloudflare', 'sunny'),
        ];

        // @codingStandardsIgnoreEnd

        return $messages[ $this->status ] ?? '';
    }
}
