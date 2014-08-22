(function( $ ) {
	'use strict';

	/**
	 * All of the code for your Dashboard-specific JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 */

	 $(function() {

		// Meta Box
		postboxes.add_postbox_toggles(pagenow);

		// Ajax
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

	/**
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */

	})( jQuery );
