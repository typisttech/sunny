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
 * Final class DonateMeNotice
 */
final class DonateMeNotice extends AbstractDelayedNotice
{
    const NOTICE_HANDLE = 'sunny_donate_me_notice';

    const TIME_LIMIT = '-1 month';

    const TIMESTAMP_OPTION_KEY = 'sunny_donate_me_notice_last_enqueue';

    /**
     * {@inheritdoc}
     */
    protected function getNoticeMessage(): string
    {
        // @codingStandardsIgnoreStart
        // Translators: %1$s is the donation url, %2$s is the url to my contact form.
        $messageFormat = __(
            '<code>Typist Tech:</code> Are you enjoying <strong>Sunny</strong>? Would you consider either a <a href="%1$s" target="_blank">small donation</a> or a <a href="%2$s" target="_blank">hire me</a> to help continue development of this plugin?',
            'sunny'
        );

        // @codingStandardsIgnoreEnd

        return sprintf(
            $messageFormat,
            'https://www.typist.tech/donate/sunny/',
            'https://www.typist.tech/contact/'
        );
    }
}
