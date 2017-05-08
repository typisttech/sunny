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

    jQuery("input#sunny-debugger-post-id-submit").on('click', showRelatedUrls);

    function showRelatedUrls() {

        // Reset results table.
        jQuery('#post-related-urls-results').html(
            '<table id="post-related-urls" class="widefat striped posts">' +
            '<thead>' +
            '<tr>' +
            '<th scope="col">Group</th>' +
            '<th scope="col">Urls</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="post-related-urls-list"></tbody>' +
            '</table>'
        );

        var id = jQuery("input#sunny-debugger-post-id").val();

        if (!jQuery.isNumeric(id)) {
            jQuery('table#post-related-urls').replaceWith(
                '<div class="error notice">' +
                '<p class="row-title">Error fetching data.</p>' +
                '<p>' +
                'Message: <strong>Please enter a valid post ID. It should be a positive integer.</strong>' +
                '</p>' +
                '</div>'
            );
            return;
        }

        jQuery.ajax({
            url: sunnyDebuggersPosts.route + id + '/related-urls',
            method: 'GET',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', sunnyDebuggersPosts.nonce);
            }
        }).done(function (response) {
            jQuery.map(response, function (values, index) {
                jQuery('tbody#post-related-urls-list').append(
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
            });
        }).fail(function (response) {
            jQuery('table#post-related-urls').replaceWith(
                '<div class="error notice">' +
                '<p class="row-title">Error fetching data.</p>' +
                '<p>' +
                'Status: ' + response.status + ' ' + response.statusText + '<br/>' +
                'Code: <code>' + response.responseJSON.code + '</code><br/>' +
                'Message: <strong>' + response.responseJSON.message + '</strong>' +
                '</p>' +
                '</div>'
            );
        });
    }
});
