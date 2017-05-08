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

?>

<div class="inside">
    <p>Sunny purges these additional urls for <strong>every purge</strong>, no matter what triggers one.</p>

    <table id="targets" class="widefat striped targets">
        <thead>
        <tr>
            <th scope="col">Group</th>
            <th scope="col">Urls</th>
        </tr>
        </thead>

        <tbody id="targets-list"></tbody>
    </table>

    <p>Targets are filterable by <code>sunny_purger_targets</code> and <code>sunny_target_groups</code></p>
</div>
