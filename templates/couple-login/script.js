/**
 *  Couple Login & Register Script Here
 */

(function($) {

  'use strict';

    /**
     *. @- Couple Register Script
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

    if( $('form#couple_signup').length ){

        $('form#couple_signup').on('submit', function(e){

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: WeddingCity_AJAX_OBJECT.ajaxurl,
                    data: { 
                        'action'                :   'weddingcity_couple_register',
                        'couple_username'       : $('form#couple_signup #couple_username').val(), 
                        'couple_email'          : $('form#couple_signup #couple_email').val(), 
                        'couple_wedding_date'   : $('form#couple_signup #weddingdate').val(), 
                        'security'              : $('form#couple_signup #couple_security').val() 
                    },
                    success: function(data){

                        weddingcity_alert_message( data );
                    }
                });
                e.preventDefault();
        });
    }

    if( $('form#couple_login').length ){   // Couple Login

        $('form#couple_login').on('submit', function(e){

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: WeddingCity_AJAX_OBJECT.ajaxurl,
                data: { 
                    'action'                    : 'weddingcity_couple_login_module',
                    'WeddingCity_Username'      : $( 'form#couple_login #WeddingCity_Username').val(), 
                    'WeddingCity_password'      : $( 'form#couple_login #WeddingCity_password').val(), 
                    'user_type'                 : $(this).attr('id'),
                    'security'                  : $( 'form#couple_login  #weddingcity-login').val() 
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

    // Date Picker Option
    // @ref : http://$ui.com/datepicker/#min-max

    if( $( '.wedding_date' ).length ){

        if( $( ".wedding_date" ).attr( 'data-wedding-date') ){

            $( ".wedding_date" ).datepicker({

                minDate: "+1", 
                maxDate: "+2M "+ $( ".wedding_date" ).attr( 'data-wedding-date'),
            });            

        }else{

            $( ".wedding_date" ).datepicker({

                minDate: "+1", 
                maxDate: "+1Y +3M",
            });
        }

        $('#ui-datepicker-div').before('<div class="default-skin"></div>');
        $('#ui-datepicker-div').appendTo('.default-skin').contents();
    }

})(jQuery);