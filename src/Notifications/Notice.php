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

/**
 * Final class Notice
 */
final class Notice
{
    /**
     * The notification's ID. Also used to permanently dismiss a dismissible notification. If a given handle has
     * previously been registered, a PHP notice will be triggered.
     *
     * @var string
     */
    private $handle;

    /**
     * The text/HTML content of the notification.
     *
     * @var string
     */
    private $html;

    /**
     * An additional CSS class to be added to the notification for styling purposes.
     *
     * @var string
     */
    private $htmlClass;

    /**
     * Whether to enqueue a "dismiss" button to allow the user to permanently dismiss the notification.
     *
     * @var bool
     */
    private $isSticky;

    /**
     * The notification's type. One of error, warning, info, success.
     *
     * @var string
     */
    private $type;

    /**
     * Notice constrictor.
     *
     * @todo Fix: Non-sticky notices wont show on acceptance and functional tests.
     *
     * @param string      $handle    The notification's ID. Also used to permanently dismiss a dismissible
     *                               notification.
     * @param string      $html      The text/HTML content of the notification.
     * @param string|null $type      Optional. The notification's type. One of error, warning, info, success.
     * @param bool|null   $isSticky  Optional. Whether to enqueue a "dismiss" button to allow the user to permanently
     *                               dismiss the notification.
     * @param string|null $htmlClass Optional. An additional CSS class to be added to the notification for styling
     *                               purposes.
     */
    public function __construct(
        string $handle,
        string $html,
        string $type = null,
        bool $isSticky = null,
        string $htmlClass = null
    ) {
        $this->handle = sanitize_key($handle);
        $this->html = wp_kses_post($html);
        $this->type = sanitize_html_class($type ?? 'info');
        $this->isSticky = $isSticky ?? false;
        $this->htmlClass = sanitize_html_class($htmlClass ?? 'sunny-admin-notice');
    }

    /**
     * Handle getter.
     *
     * @return string
     */
    public function getHandle(): string
    {
        return $this->handle;
    }

    /**
     * Html getter.
     *
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * HtmlClass getter.
     *
     * @return string
     */
    public function getHtmlClass(): string
    {
        return $this->htmlClass;
    }

    /**
     * Type getter.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * IsSticky getter.
     *
     * @return bool
     */
    public function isSticky(): bool
    {
        return $this->isSticky;
    }
}
