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

namespace TypistTech\Sunny\Post;

/**
 * Final class Finder
 */
final class Finder
{
    public static function getWpPostByUrl(string $url)
    {
        $cleanUrl = esc_url_raw($url);

        if (empty($cleanUrl)) {
            return null;
        }

        $postId = url_to_postid($cleanUrl);

        return self::getWpPostById($postId);
    }

    public static function getWpPostById(int $postId)
    {
        if ($postId < 1) {
            return null;
        }

        return get_post(absint($postId));
    }
}
