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

use TypistTech\Sunny\Debuggers\AbstractDebugger;

/* @var AbstractDebugger $context Context */

?>

<p>Sunny purges these additional urls for <strong>every purge</strong>, no matter what triggers one.</p>

<div id="<?php echo esc_attr($context->getId()); ?>-result">
</div>

<p>
    Targets are filterable by <code>Strategies</code> and <code>sunny_targets</code>. See
    examples on <a href="https://github.com/TypistTech/sunny-purge-extra-urls-example">Sunny Purge Extra URLs
        Example</a>.
</p>
