/*
 * Sunny
 *
 * Automatically purge CloudFlare cache, including cache everything rules.
 *
 * @package   Sunny
 *
 * @author Typist Tech <sunny@typist.tech>
 * @copyright 2017 Typist Tech
 * @license GPL-2.0+
 *
 * @see https://www.typist.tech/projects/sunny
 * @see https://wordpress.org/plugins/sunny/
 */

jQuery(document).ready(function () {
    jQuery("form#sunny_cache_status_debugger-form").submit(function (event) {
        event.preventDefault();

        resetResultArea();
        getResult();
    });

    function resetResultArea() {
        jQuery('div#cache-status-result').replaceWith(
            '<div id="cache-status-result">' +
            '<div class="notice-info notice"><p class="row-title">Fetching data...</p></div>' +
            '</div>'
        );
    }

    function getResult() {
        jQuery.ajax({
            url: sunny_cache_status_debugger.route,
            method: 'GET',
            'data': {
                'url': jQuery("input#sunny_cache_status_debugger-url").val()
            },
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', sunny_cache_status_debugger.nonce);
            }
        }).done(function (response) {
            jQuery('div#cache-status-result').replaceWith(
                '<div id="cache-status-result">' +
                '<table id="cache-status-table" class="widefat striped cache-status">' +
                '<tbody id="cache-status-result-body">' +

                '<tr>' +
                "<td><strong class='row-title'>URL</strong></td>" +
                '<td><span>' + response.url + '</span></td>' +
                '</tr>' +

                '<tr>' +
                "<td><strong class='row-title'>Is served by Cloudflare?</strong></td>" +
                '<td><span>' + response.is_cloudflare + '</span></td>' +
                '</tr>' +

                '<tr>' +
                "<td><strong class='row-title'>Cache Status</strong></td>" +
                '<td><span>' + response.status + '</span></td>' +
                '</tr>' +

                '<tr>' +
                "<td><strong class='row-title'>Cache Status Explanation</strong></td>" +
                '<td><span>' + response.status_message + '</span></td>' +
                '</tr>' +

                '</tbody>' +
                '</table>' +
                '</div>'
            );
        }).fail(function (response) {
            jQuery('div#cache-status-result').replaceWith(
                '<div id="cache-status-result">' +
                '<div class="error notice">' +
                '<p class="row-title">Error fetching data.</p>' +
                '<p>' +
                'Status: ' + response.status + ' ' + response.statusText + '<br/>' +
                'Code: <code>' + response.responseJSON.code + '</code><br/>' +
                'Message: <strong>' + response.responseJSON.message + '</strong><br/>' +
                'Url: <strong>' + response.responseJSON.data.url + '</strong>' +
                '</p>' +
                '</div>' +
                '</div>'
            );
        });
    }
});
