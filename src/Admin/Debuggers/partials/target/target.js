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
    jQuery.ajax({
        url: sunny_target_debugger.route,
        method: 'GET',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', sunny_target_debugger.nonce);
        }
    }).done(function (response) {
        jQuery.map(response, function (values, index) {
            jQuery('tbody#targets-list').append(
                "<tr id='" + index + "'>" +
                "<td class='target-group'><strong class='row-title'>" + index + '</strong></td>' +
                "<td class='target-urls'></td>" +
                '</tr>'
            );

            jQuery.map(values, function (value) {
                jQuery('tr#' + index + '>td.target-urls').append(
                    value + '<br/>'
                );
            });
        })
    }).fail(function (response) {
        jQuery('table#targets').replaceWith(
            '<div class="error notice">' +
            '<p class="row-title">Error fetching data.</p>' +
            '<p>' +
            'Status: ' + response.status + ' ' + response.statusText + '<br/>' +
            'Code: <code>' + response.responseJSON.code + '</code><br/>' +
            'Message: <strong>' + response.responseJSON.message + '</strong>' +
            '</p></div>'
        );
    });
});
