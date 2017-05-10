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
    jQuery("form#sunny_post_related_url_debugger-form").submit(function (event) {
        event.preventDefault();

        resetResultArea();
        getResult();
    });

    function resetResultArea() {
        jQuery('div#sunny_post_related_url_debugger-result').replaceWith(
            '<div id="sunny_post_related_url_debugger-result">' +
            '<div class="notice-info notice"><p class="row-title">Fetching data...</p></div>' +
            '</div>'
        );
    }

    function getResult() {
        id = jQuery("input#sunny_post_related_url_debugger-post-id").val();

        jQuery.ajax({
            url: sunny_post_related_url_debugger.route + id + '/related-urls/',
            method: 'GET',
            'data': {
                'id': id
            },
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', sunny_post_related_url_debugger.nonce);
            }
        }).done(function (response) {
            jQuery('div#sunny_post_related_url_debugger-result').replaceWith(
                '<div id="sunny_post_related_url_debugger-result">' +
                '<table id="sunny_post_related_url_debugger-table" class="widefat striped cache-status">' +
                '<thead>' +
                '<tr>' +
                '<th scope="col">Group</th>' +
                '<th scope="col">Urls</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="sunny_post_related_url_debugger-result-body"></tbody>' +
                '</table>' +
                '</div>'
            );

            jQuery.map(response, function (values, index) {
                jQuery('tbody#sunny_post_related_url_debugger-result-body').append(
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
            jQuery('div#sunny_post_related_url_debugger-result').replaceWith(
                '<div id="sunny_post_related_url_debugger-result">' +
                '<div class="notice-error notice">' +
                '<p class="row-title">Error fetching data.</p>' +
                '<p>' +
                'Status: ' + response.status + ' ' + response.statusText + '<br/>' +
                'Code: <code>' + response.responseJSON.code + '</code><br/>' +
                'Message: <strong>' + response.responseJSON.message + '</strong><br/>' +
                'Post ID: <strong>' + response.responseJSON.data.id + '</strong>' +
                '</p>' +
                '</div>' +
                '</div>'
            );
        });
    }
});
