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

use TypistTech\Sunny\LoadableInterface;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;

/**
 * Final class Notifier
 */
final class Notifier implements LoadableInterface
{
    const OPTION_KEY = 'sunny_notifier_admin_notices';

    /**
     * Notices.
     *
     * @var Notice[]
     */
    private $notices;

    /**
     * Notifier constructor.
     */
    public function __construct()
    {
        $maybeNotices = get_option(self::OPTION_KEY);

        if (! is_array($maybeNotices)) {
            $maybeNotices = [];
        }

        $this->notices = array_filter(
            $maybeNotices,
            function ($notice) {
                return $notice instanceof Notice;
            }
        );

        update_option(
            self::OPTION_KEY,
            array_filter(
                $this->notices,
                function (Notice $notice) {
                    return $notice->isSticky();
                }
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function getHooks(): array
    {
        return [
            new Action('admin_notices', __CLASS__, 'renderNotices'),
            new Action('wp_ajax_sunny_dismiss_sticky_notice', __CLASS__, 'dismissStickyNotice'),
            new Action('admin_footer', __CLASS__, 'renderScript'),
        ];
    }

    /**
     * Dismiss a sticky notice from database.
     *
     * @todo Move to rest controller.
     *
     * @return void
     */
    public function dismissStickyNotice()
    {
        $stickyNotices = array_filter(
            $this->notices,
            function (Notice $notice) {
                return $notice->isSticky();
            }
        );

        $dismissed = sanitize_key(
            filter_input(INPUT_POST, 'handle', FILTER_SANITIZE_STRING)
        );

        update_option(
            self::OPTION_KEY,
            array_filter(
                $stickyNotices,
                function (Notice $notice) use ($dismissed) {
                    return $notice->getHandle() !== $dismissed;
                }
            )
        );

        wp_die();
    }

    /**
     * Enqueue an admin notice to database.
     *
     * @param string      $handle    The notification's ID. Also used to permanently dismiss a dismissible
     *                               notification.
     * @param string      $html      The text/HTML content of the notification.
     * @param string|null $type      Optional. The notification's type. One of error, warning, info, success.
     * @param bool|null   $isSticky  Optional. Whether to enqueue a "dismiss" button to allow the user to permanently
     *                               dismiss the notification.
     * @param string|null $htmlClass Optional. An additional CSS class to be added to the notification for styling
     *                               purposes.
     *
     * @return void
     */
    public function enqueue(
        string $handle,
        string $html,
        string $type = null,
        bool $isSticky = null,
        string $htmlClass = null
    ) {
        $this->notices[ $handle ] = new Notice($handle, $html, $type, $isSticky, $htmlClass);

        update_option(self::OPTION_KEY, $this->notices);
    }

    /**
     * Render all notices.
     *
     * @return void
     */
    public function renderNotices()
    {
        foreach ($this->notices as $notice) {
            $this->renderNotice($notice);
        }
    }

    /**
     * Render notice.
     *
     * @param Notice $notice Notice to be rendered.
     *
     * @return void
     */
    private function renderNotice(Notice $notice)
    {
        printf(
            '<div id="%1$s" data-handle="%1$s" class="notice notice-%2$s %3$s %4$s"><p>%5$s</p></div>',
            esc_attr($notice->getHandle()),
            esc_attr($notice->getType()),
            $notice->isSticky() ? 'is-sticky is-dismissible' : '',
            sanitize_html_class($notice->getHtmlClass()),
            wp_kses_post($notice->getHtml())
        );
    }

    /**
     * Render ajax script.
     *
     * @todo Use `admin_enqueue_scripts` and `wp_enqueue_script` instead.
     *
     * @return void
     */
    public function renderScript()
    {
        if (count($this->notices) < 1) {
            return;
        }

        echo '<script>';
        echo 'jQuery(document).ready(function ($) {';
        echo "$('.notice.is-sticky').on('click', '.notice-dismiss', function (event) {";
        echo '$.post(ajaxurl, {';
        echo "action: 'sunny_dismiss_sticky_notice',";
        echo "handle: $(this).parent().data('handle')";
        echo '})});});</script>';
    }
}
