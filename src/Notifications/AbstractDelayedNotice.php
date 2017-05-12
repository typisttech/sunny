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

namespace TypistTech\Sunny\Notifications;

use DateTime;
use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\OptionStore;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;

/**
 * Abstract class AbstractDelayedNotice
 */
abstract class AbstractDelayedNotice implements LoadableInterface
{
    const NOTICE_HANDLE = self::NOTICE_HANDLE;

    const TIME_LIMIT = self::TIME_LIMIT;

    const TIMESTAMP_OPTION_KEY = self::TIMESTAMP_OPTION_KEY;

    /**
     * Notifier instance
     *
     * @var Notifier
     */
    private $notifier;

    /**
     * Option store instance
     *
     * @var OptionStore
     */
    private $optionStore;

    /**
     * AbstractDelayedNotice constructor.
     *
     * @param OptionStore $optionStore Option store instance.
     * @param Notifier    $notifier    Notifier instance.
     */
    public function __construct(OptionStore $optionStore, Notifier $notifier)
    {
        $this->optionStore = $optionStore;
        $this->notifier = $notifier;
    }

    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [
            new Action('admin_init', static::class, 'run'),
        ];
    }

    /**
     * Enqueue delayed notice and update last enqueue timestamp if needed
     *
     * @return void
     */
    public function run()
    {
        $lastEnqueue = $this->optionStore->get(static::TIMESTAMP_OPTION_KEY);

        // First run.
        if (! $lastEnqueue instanceof DateTime) {
            update_option(
                static::TIMESTAMP_OPTION_KEY,
                new DateTime
            );

            return;
        }

        if (! $this->isTime($lastEnqueue)) {
            return;
        }

        $this->notifier->enqueue(
            static::NOTICE_HANDLE,
            $this->getNoticeMessage(),
            'info',
            true
        );

        update_option(
            static::TIMESTAMP_OPTION_KEY,
            new DateTime
        );
    }

    /**
     * Check if older than time limit.
     *
     * @param DateTime $lastEnqueue Last enqueue timestamp.
     *
     * @return bool
     */
    protected function isTime(DateTime $lastEnqueue): bool
    {
        $timeLimit = new DateTime(static::TIME_LIMIT);

        return $lastEnqueue < $timeLimit;
    }

    /**
     * Notice message html.
     *
     * @return string
     */
    abstract protected function getNoticeMessage(): string;
}
