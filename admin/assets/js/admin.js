jQuery(document).ready(function($) {
    "use strict";

    // Meta Box
    postboxes.add_postbox_toggles(pagenow);

    // Ajax
    jQuery("#sunny_zone_purger_form").submit(function(){
        event.preventDefault();
        jQuery("#sunny_zone_purger_result").show();
        jQuery("#sunny_zone_purger_form_spinner").show();
        jQuery("#sunny_zone_purger_button").attr("disabled", "disabled")
        var data = {
            action: 'sunny_purge_zone',
            nonce:  jQuery('#sunny_zone_purger_nonce').val()// The security nonce
        };
        jQuery.post( ajaxurl, data, function (response) {
            var output = "<p>" + response.result + ": " + response.message + "</p>";
            jQuery("#sunny_zone_purger_result").append(jQuery(output).fadeIn('slow'));
            jQuery("#sunny_zone_purger_form_spinner").hide();
            jQuery("#sunny_zone_purger_button").removeAttr("disabled");
        }, 'json');
        // Prevent Default Action Again
        return false;
    }); // end #sunny_zone_purger_form submit

    jQuery("#sunny_connection_tester_form").submit(function(){
        event.preventDefault();
        jQuery("#sunny_connection_tester_result").show();
        jQuery("#sunny_connection_tester_form_spinner").show();
        jQuery("#sunny_connection_tester_button").attr("disabled", "disabled")
        var data = {
            action: 'sunny_test_connection',
            nonce:  jQuery('#sunny_connection_tester_nonce').val()// The security nonce
        };
        jQuery.post( ajaxurl, data, function (response) {
            var output = "<p>" + response.result + ": " + response.message + "</p>";
            jQuery("#sunny_connection_tester_result").append(jQuery(output).fadeIn('slow'));
            jQuery("#sunny_connection_tester_form_spinner").hide();
            jQuery("#sunny_connection_tester_button").removeAttr("disabled");
        }, 'json');
        // Prevent Default Action Again
        return false;
    }); // end #connection_tester_form submit

    jQuery("#sunny_url_purger_form").submit(function(){
        event.preventDefault();
        jQuery("#sunny_url_purger_result").show();
        jQuery("#sunny_url_purger_form_spinner").show();
        jQuery("#sunny_url_purger_button").attr("disabled", "disabled")
        var data = {
            action:     'sunny_purge_url',
            nonce:      jQuery('#sunny_url_purger_nonce').val(),// The security nonce
            "post_url": jQuery('#sunny_post_url').val()
        };
        jQuery.post( ajaxurl, data, function (response) {
            var output = "<p>" + response.message + "</p>";
            jQuery("#sunny_url_purger_result").append(jQuery(output).fadeIn('slow'));
            jQuery("#sunny_url_purger_form_spinner").hide();
            jQuery("#sunny_url_purger_button").removeAttr("disabled");
        }, 'json');
        // Prevent Default Action Again
        return false;
    }); // end #url_purger_form submit
});