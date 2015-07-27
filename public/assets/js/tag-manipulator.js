
jQuery( document ).ready( function () {
    jQuery( "[name='captcha_combobox']" ).change( function () {
        var size = jQuery( "[name='captcha_combobox']" ).val();
        jQuery( "[name='captcha_size']" ).val( size );
        jQuery( "[name='captcha_size']" ).trigger( "change" );
    } );
} );



