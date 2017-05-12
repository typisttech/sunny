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

namespace TypistTech\Sunny\Ads;

use TypistTech\Sunny\Notifications\AbstractDelayedNotice;

/**
 * Final class ReviewMeNotice
 */
final class ReviewMeNotice extends AbstractDelayedNotice
{
    const NOTICE_HANDLE = 'sunny_review_me_notice';

    const TIME_LIMIT = '-15 days';

    const TIMESTAMP_OPTION_KEY = 'sunny_review_me_notice_last_enqueue';

    /**
     * {@inheritdoc}
     */
    protected function getNoticeMessage(): string
    {
        // @codingStandardsIgnoreStart
        // Translators: %1$s is the url to wordpress.org review page.
        $messageFormat = __(
            'Hey! <code>Sunny</code> has been purging your site\'s Cloudflare caches for a while. You might not realize it, but user reviews are such a great help to us. We would be so grateful if you could take a minute to <a href="%1$s" target="_blank">leave a review on WordPress.org</a> Many thanks in advance :)',
            'sunny'
        );

        // @codingStandardsIgnoreEnd

        return sprintf(
            $messageFormat,
            'https://wordpress.org/support/plugin/sunny/reviews/?filter=5#new-post'
        );
    }
}
