/**
 *  Update Listing Script
 */

(function($) {

  'use strict';

    function button_disable( $id ){

        $('#'+$id).attr( 'type', 'button' );
        $('#'+$id).css("cursor", "default");
        $('#'+$id).addClass( 'disabled' ).attr( 'aria-disabled', 'true"' );
    }

    function get_editor_value( agrs ){

        if( $( agrs ).length ){

            return ( $( agrs ).html() );
        }
    }

    /**
     *  Vendor Profile Data Submit
     */
    
    if( $('#weddingcity_vendor_profile_update').length ){

        $('#weddingcity_vendor_profile_update').on('submit', function (e) {

                var form_id =  '#' + $(this).attr( 'id' );

                $('html, body').animate({ scrollTop: 0 }, 'slow');

                $.ajax({

                    type        : 'POST',
                    url         : WeddingCity_AJAX_OBJECT.ajaxurl,
                    dataType    : 'json',
                    data        : {

                        'action'            : 'weddingcity_vendor_profile_action',
                        'security'          : $( form_id + ' #profile_update').val(),
                        'user_image'        : $( form_id + ' #user-profile-image-preview-container img').attr( 'src' ),
                        'user_image_id'     : $( form_id + ' #user-profile-image-preview-container img').attr( 'data-attached_id' ),
                        'first_name'        : $( form_id + ' #first_name').val(),
                        'user_email'        : $( form_id + ' #user_email').val(),
                        'user_contact'      : $( form_id + ' #user_contact').val(),
                        'user_address'      : $( form_id + ' #user_address').val(),
                        'business_name'     : $( form_id + ' #business_name').val(),
                    },

                    success: function (data) {

                        toastr.success( data.message );
                    }
                });

                e.preventDefault();
        });
    }


    // Perform AJAX change-password on form submit
    if( $('#vendor_user_password_change').length ){

        $('#vendor_user_password_change').on( 'submit', function (e) {

                var form_id =  '#' + $(this).attr( 'id' );

                $('html, body').animate({ scrollTop: 0 }, 'slow');
            
                $.ajax({
                    type: 'POST',
                    url: WeddingCity_AJAX_OBJECT.ajaxurl,
                    dataType    : 'json',
                    data: {
                        'action'        : 'weddingcity_vendor_user_password_change',
                        'security'      : $( form_id + ' #change_password_security').val(),
                        'old_pwd'       : $( form_id + ' #old_pwd').val(),
                        'new_pwd'       : $( form_id + ' #new_pwd').val(),
                        'confirm_pwd'   : $( form_id + ' #confirm_pwd').val(),
                    },
                    success: function (data) {

                        if( data.notice == '0' ){

                            toastr.error( data.message );

                        }else if( data.notice == '1' ){

                            toastr.success( data.message );

                        }else if( data.notice == '2' ){

                            toastr.info( data.message );
                        }

                        // $('#vendor_user_password_change .status').show().html(data.message);

                        $('#vendor_user_password_change .status').delay(5000).slideUp( "slow", function() {

                            if( data.redirect == true ){

                                document.location.href = WeddingCity_AJAX_OBJECT.home_url;

                                // @ref : https://stackoverflow.com/questions/7276677/$-redirect-to-url-after-specified-time#answer-7276692
                                // setTimeout(function(){ document.location.href = WeddingCity_AJAX_OBJECT.home_url; }, 5000 );
                            }
                        });
                    },
                    error: function (errorThrown) {

                        toastr.error( data.message ); // $('#vendor_user_password_change .status').show().html(data.message);
                    }
                });

                e.preventDefault();
        });


        // @ref : https://jsfiddle.net/corbacho/6eQZX/

        $('#vendor_user_password_change :password').each(function(){

            $( '.input-group-prepend' ).on('click', function (e) {

              e.preventDefault();

              if ($(this).data('state') === 'hidden') {

                $(this).parent().find(':password').attr('type', 'text');
                $(this).html('<div class="input-group-prepend" data-state="shown"><span class="input-group-text"><i class="fas fa fa-eye-slash"></i></span></div>');
                $(this).data('state','shown');

              }else {

                $(this).parent().find(':text').attr('type', 'password');
                $(this).html('<div class="input-group-prepend" data-state="hidden"><span class="input-group-text"><i class="fas fa fa-eye"></i></span></div>');
                $(this).data('state','hidden');
              }

            });
        });
    }



    // Vendor AJAX user-profile on form submit
    if( $('#weddingcity_vendor_social_notification').length ){

        $('#weddingcity_vendor_social_notification').on('submit', function (e) {

                var form_id =  '#' + $(this).attr( 'id' );

                $('html, body').animate({ scrollTop: 0 }, 'slow');
            
                $.ajax({

                    type        : 'POST',
                    url         : WeddingCity_AJAX_OBJECT.ajaxurl,
                    dataType    : 'json',
                    data        : {

                        'action'            : 'weddingcity_vendor_social_profile_action',
                        'security'          : $( form_id + ' #social_media_update').val(),
                        'facebook'          : $( form_id + ' #facebook').val(),
                        'twitter'           : $( form_id + ' #twitter').val(),
                        'instagram'         : $( form_id + ' #instagram').val(),
                        'youtube'           : $( form_id + ' #youtube').val(),
                    },

                    success: function (data) {

                        toastr.success( data.message );
                    }
                });

                e.preventDefault();
        });
    }


    /**
     *  Plugin Version 1.1
     */
    function weddingcity_vendor_bussines_profile_location_update() {

        var

        _lat     =  ( $('#bussiness_latitude').val() != '' )  ? parseFloat( $('#bussiness_latitude').val() )  : parseFloat( WeddingCity_AJAX_OBJECT.weddingcity_latitude ),
        _lng     =  ( $('#bussiness_longitude').val() != '' ) ? parseFloat( $('#bussiness_longitude').val() ) : parseFloat( WeddingCity_AJAX_OBJECT.weddingcity_longitude ),
        _image   =  WeddingCity_AJAX_OBJECT.map_icon;

        var myLatlng = {lat: parseFloat( _lat ), lng: parseFloat( _lng ) };

        var map = new google.maps.Map(document.getElementById('vendor_bussiness_map'), {
            zoom: 9,
            center: myLatlng
        });

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            icon: WeddingCity_AJAX_OBJECT.map_icon
        });

        map.addListener('click', function(e) {

            $('.MapLat').val( e.latLng.lat() );
            $('.MapLon').val( e.latLng.lng() );

            // map.setCenter(e.latLng);
            marker.setPosition(e.latLng);
        });
    }

    if( $('#vendor_bussiness_map').length ){
        
        /**
         *  @credit : http://jsfiddle.net/pmrotule/jcg6j5qr/
         */
        weddingcity_vendor_bussines_profile_location_update();
    }

    if( $( '#vendor_bussiness_map' ).length ){

        $( document ).on( 'change hover mouseover mouseout mousemove', function(e){

            if( $( 'button.dismissButton' ).length ){

                $( 'button.dismissButton' ).trigger( 'click' );
            }
            
        } );
    }

})(jQuery);