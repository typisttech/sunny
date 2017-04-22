// This file is cloned from julien731/wp-dismissible-notices-handler@1.0.0
// @see https://github.com/julien731/WP-Dismissible-Notices-Handler/commit/85ce1debbdfd4543e5b835dfe6670b9de99ddf6b
// @see https://github.com/julien731/WP-Dismissible-Notices-Handler/

jQuery(document).ready(function($) {
    $( '.notice.is-dismissible' ).on('click', '.notice-dismiss', function ( event ) {
        event.preventDefault();
        var $this = $(this);
        if( 'undefined' == $this.parent().attr('id') ){
            return;
        }
        $.post( ajaxurl, {
            action: 'dnh_dismiss_notice',
            url: ajaxurl,
            id: $this.parent().attr('id')
        });

    });
});
