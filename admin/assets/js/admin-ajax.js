jQuery(document).ready(function($) {
    "use strict";
    jQuery("#sunny-zone-purger-form").submit(function(){
        event.preventDefault();
        jQuery("#sunny-zone-purger-result").show();
        jQuery("#sunny-zone-purger-form-spinner").show();
        jQuery("#sunny-zone-purger-button").attr("disabled", "disabled")
        var data = {
            action: 'sunny-purge-zone',
            nonce:  jQuery('#sunny-zone-purger-nonce').val()// The security nonce
        };
        jQuery.post( ajaxurl, data, function (response) {
            var output = "<p>" + response.result + ": " + response.message + "</p>";
            jQuery("#sunny-zone-purger-result").append(jQuery(output).fadeIn('slow'));
            jQuery("#sunny-zone-purger-form-spinner").hide();
            jQuery("#sunny-zone-purger-button").removeAttr("disabled");
        }, 'json');
        // Prevent Default Action Again
        return false;
    }); // end #sunny-zone-purger-form submit

    jQuery("#sunny-connection-tester-form").submit(function(){
        event.preventDefault();
        jQuery("#sunny-connection-tester-result").show();
        jQuery("#sunny-connection-tester-form-spinner").show();
        jQuery("#sunny-connection-tester-button").attr("disabled", "disabled")
        var data = {
            action: 'sunny-test-connection',
            nonce:  jQuery('#sunny-connection-tester-nonce').val()// The security nonce
        };
        jQuery.post( ajaxurl, data, function (response) {
            var output = "<p>" + response.result + ": " + response.message + "</p>";
            jQuery("#sunny-connection-tester-result").append(jQuery(output).fadeIn('slow'));
            jQuery("#sunny-connection-tester-form-spinner").hide();
            jQuery("#sunny-connection-tester-button").removeAttr("disabled");
        }, 'json');
        // Prevent Default Action Again
        return false;
    }); // end #connection-tester-form submit

    jQuery("#sunny-url-purger-form").submit(function(){
        event.preventDefault();
        jQuery("#sunny-url-purger-result").show();
        jQuery("#sunny-url-purger-form-spinner").show();
        jQuery("#sunny-url-purger-button").attr("disabled", "disabled")
        var data = {
            action:     'sunny-purge-url',
            nonce:      jQuery('#sunny-url-purger-nonce').val(),// The security nonce
            "post-url": jQuery('#post-url').val()
        };
        jQuery.post( ajaxurl, data, function (response) {
            var output = "<p>" + response.message + "</p>";
            jQuery("#sunny-url-purger-result").append(jQuery(output).fadeIn('slow'));
            jQuery("#sunny-url-purger-form-spinner").hide();
            jQuery("#sunny-url-purger-button").removeAttr("disabled");
        }, 'json');
        // Prevent Default Action Again
        return false;
    }); // end #url-purger-form submit
});