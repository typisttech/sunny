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
    console.log('hi');

    jQuery.ajax({
        url: sunnyDebuggersTargets.route,
        method: 'GET',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', sunnyDebuggersTargets.nonce);
        },
        data: {
            'title': 'Hello Moon'
        }
    }).done(function (response) {
        jQuery.map(response, function (values, index) {
            jQuery('tbody#targets-table-body').append(
                "<tr id='" + index + "'>" +
                "<th scope='row'><h4>" + index + '</h4></th>' +
                '<td></td>' +
                '</tr>'
            );

            jQuery.map(values, function (value) {
                jQuery('tr#' + index + '>td').append(
                    value + '<br/>'
                );
            });
        })
    }).fail(function (response) {
        jQuery('tbody#targets-table-body').append(
            '<p>Error fetching data.<br/>' +
            'Status: ' + response.status + ' ' + response.statusText + '<br/>' +
            'Code: ' + response.responseJSON.code + '<br/>' +
            'Message: ' + response.responseJSON.message + '<br/>' +
            '</p>'
        );
        console.log(response);
    });
});
