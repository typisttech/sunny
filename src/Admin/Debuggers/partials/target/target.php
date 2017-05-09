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

use TypistTech\Sunny\Admin\Debuggers\AbstractDebugger;

/* @var AbstractDebugger $context Context */

?>

<p>Sunny purges these additional urls for <strong>every purge</strong>, no matter what triggers one.</p>

<div id="<?php echo esc_attr($context->getId()); ?>-result">
</div>

<p>Targets are filterable by <code>sunny_targets_strategies</code> and <code>sunny_targets</code></p>
