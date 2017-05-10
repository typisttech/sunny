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

namespace TypistTech\Sunny\Debuggers;

/**
 * Final class PostRelatedUrlDebugger
 */
final class PostRelatedUrlDebugger extends AbstractDebugger
{
    const NAME = 'post_related_url';

    /**
     * {@inheritdoc}
     */
    protected function getJsRoute(): string
    {
        return esc_url_raw(rest_url('sunny/v2/posts/'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getMetaBoxTitle(): string
    {
        return __('Post Related Urls', 'sunny');
    }
}
