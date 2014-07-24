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
});