/**
 *  Vendor Login & Register Script Here
 */

(function($) {

  'use strict';

    /**
     *. @- Vendor Register Script
     */
    
    function weddingcity_alert_message( data ){

        if( data !== null && data !== '' ){

            if( data.notice == '0' ){

                toastr.error( data.message );
            }

            if( data.notice == '1' ){
                
                toastr.success( data.message );
            }

            if( data.notice == '2' ){
                
                toastr.info( data.message );
            }

            if( data.notice == '3' ){
                
                toastr.warning( data.message );
            }
        }
    }

    if( $('form#vendor_signup').length ){

        $('form#vendor_signup').on('submit', function(e){

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: WeddingCity_AJAX_OBJECT.ajaxurl,
                data: { 
                    
                    'action'            :   'weddingcity_vendor_register',
                    'vendor_username'   : $('form#vendor_signup #vendor_username').val(), 
                    'vendor_email'      : $('form#vendor_signup #vendor_email').val(), 
                    'vendor_type'       : $('form#vendor_signup #vendor_type').val(), 
                    'security'          : $('form#vendor_signup #vendor_security').val() 
                },
                success: function(data){

                    weddingcity_alert_message( data );
                }
            });
            e.preventDefault();
        });
    }


    if( $('form#vendor_login').length ){   // Vendor Login

        $('form#vendor_login').on('submit', function(e){

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: WeddingCity_AJAX_OBJECT.ajaxurl,
                data: { 
                    'action'                    : 'weddingcity_vendor_login_module',
                    'WeddingCity_Username'      : $( 'form#vendor_login #WeddingCity_Username').val(), 
                    'WeddingCity_password'      : $( 'form#vendor_login #WeddingCity_password').val(), 
                    'user_type'                 : $(this).attr('id'),
                    'security'                  : $( 'form#vendor_login  #weddingcity-login').val() 
                },
                success: function(data){

                    weddingcity_alert_message( data );

                    if ( data.redirect == true ){
                        document.location.href = data.dashbaord;
                    }

                    if( data.redirect == false ){
                        setTimeout(function(){ document.location.href = data.dashbaord; }, 5000 );
                    }

                }
            });
            e.preventDefault();
        });
    }

})(jQuery);