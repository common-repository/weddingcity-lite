/**
 *  Forgot Password script here
 */


(function($) {

  'use strict';

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

    if( $('form#weddingcity_forgot_password').length ){     // Forgot Password

        $('form#weddingcity_forgot_password').on('submit', function (e){

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: WeddingCity_AJAX_OBJECT.ajaxurl,
                data: {
                    'action'     :   'weddingcity_forgot_password',
                    'email'      :   $('form#weddingcity_forgot_password #email').val(),
                    'security'   :   $('form#weddingcity_forgot_password #weddingcity-forgot-password').val(),
                },
                success: function (data) {
                
                    $('form#weddingcity_forgot_password #email').val('');
                    weddingcity_alert_message( data );
                },
                error: function (errorThrown) {

                    weddingcity_alert_message( data );
                }
            });

            e.preventDefault();
            return false;
        });
    }

})(jQuery);