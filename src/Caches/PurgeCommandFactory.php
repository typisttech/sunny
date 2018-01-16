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

use TypistTech\Sunny\Posts\RelatedUrls\RelatedUrls;
use TypistTech\Sunny\Targets\Targets;
use WP_Post;

/**
 * Final class PurgeCommandFactory
 */
final class PurgeCommandFactory
{
    /**
     * Related urls finder
     *
     * @var RelatedUrls
     */
    private $relatedUrls;

    /**
     * Targets finder
     *
     * @var Targets
     */
    private $targets;

    /**
     * PurgeCommandFactory constructor.
     *
     * @param RelatedUrls $relatedUrls Related urls finder.
     * @param Targets     $targets     Targets finder.
     */
    public function __construct(RelatedUrls $relatedUrls, Targets $targets)
    {
        $this->relatedUrls = $relatedUrls;
        $this->targets = $targets;
    }

    /**
     * Build a purge command for a post.
     *
     * @param WP_Post $post   Post to be purged.
     * @param string  $reason Reason to perform a purge.
     *
     * @return PurgeCommand
     */
    public function buildForPost(WP_Post $post, string $reason): PurgeCommand
    {
        return new PurgeCommand(
            $reason,
            $this->targets,
            $this->relatedUrls->allByPost($post)
        );
    }
}
