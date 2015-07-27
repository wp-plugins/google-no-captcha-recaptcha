jQuery( window ).load( function () {
   
    var a = [ ], i = 0;
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
            i++;
        } );
    }

    //jQuery("[type='recaptcha']").css({"transform":"scale(0.88)","transform-origin":"0","-webkit-transform":"scale(0.88)"});

    jQuery( '.wpcf7-submit' ).click( function ( event ) {
        var form = jQuery( this ).parents( 'form:first' );
        jQuery( document ).ajaxComplete( function ( event, xhr, options ) {
            jQuery("div [type='recaptcha']").find("iframe").css("opacity","1");
            var response = xhr.responseText;
            var occurance = response.match( /invalids/g );
            if ( occurance === null )
            {
                var id = jQuery( "div[id^='wdm-nocapt-recapt-id-recaptcha-']", form ).attr( "id" );
                
                for ( var x = 0; x < a.length; x++ ) {
                    if ( a[x] === id ) {
                        grecaptcha.reset( x );
                    }
                }
            }
        } );
    } );
} );