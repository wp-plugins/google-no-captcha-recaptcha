jQuery( window ).load( function () {
       
    var captcha_count = jQuery( 'div[id^="wdm-nocapt-recapt-id-recaptcha"]' ).length;
    if ( captcha_count > 0 ) {
        jQuery.each( jQuery( 'div[id^="wdm-nocapt-recapt-id-recaptcha"]' ), function () {
            var id = jQuery( this ).attr( 'id' );
            a[i] = id;
            var theme = jQuery( this ).attr( 'theme' );
            var widgetId2 = grecaptcha.render( id, {
                'sitekey': wdm_recaptcha.sitekey,
                'theme': theme
            } );           
        } );
    }

} );