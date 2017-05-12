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
 * Final class HireMeNotice
 */
final class HireMeNotice extends AbstractDelayedNotice
{
    const NOTICE_HANDLE = 'sunny_hire_me_notice';

    const TIME_LIMIT = '-2 weeks';

    const TIMESTAMP_OPTION_KEY = 'sunny_hire_me_notice_last_enqueue';

    /**
     * {@inheritdoc}
     */
    protected function getNoticeMessage(): string
    {
        // @codingStandardsIgnoreStart
        // Translators: %1$s is the email link, %2$s is the url to my contact form.
        $messageFormat = __(
            '<code>Typist Tech:</code> Hey! You\'ve been using my plugin <code>Sunny</code> quite a while. Hope it makes your life more enjoyable. If you\'re looking for help with development, hosting, email setup, or literally anything else web related then I\'ve got your back! Shoot me an email %1$s or via my <a href="%2$s" target="_blank">contact form</a>.',
            'sunny'
        );

        // @codingStandardsIgnoreEnd

        return sprintf(
            $messageFormat,
            '<a href="mailto:info@typist.tech">info@typist.tech</a>',
            'https://www.typist.tech/contact/'
        );
    }
}
