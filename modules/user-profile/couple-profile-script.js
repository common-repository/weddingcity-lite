/**
 *  Couple Profile Update
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
     *  Couple Profile Update
     */
    if( $('form#weddingcity_couple_profile_update').length ){

        $('form#weddingcity_couple_profile_update').on('submit', function (e) {

            var form_id    = '#'+ $( this ).attr( 'id' );

            $('html, body').animate({ scrollTop: 0 }, 'slow');
            
                $.ajax({

                    type        : 'POST',
                    url         : WeddingCity_AJAX_OBJECT.ajaxurl,
                    dataType    : 'json',
                    data        : {

                        'action'            : 'weddingcity_couple_profile_action',
                        'security'          : $( form_id + ' #profile_update').val(),
                        'user_image'        : $( form_id + ' #user-profile-image-preview-container img').attr( 'src' ),
                        'user_image_id'     : $( form_id + ' #user-profile-image-preview-container img').attr( 'data-attached_id' ),
                        'first_name'        : $( form_id + ' #first_name').val(),
                        'user_email'        : $( form_id + ' #user_email').val(),
                        'user_contact'      : $( form_id + ' #user_contact').val(),
                        'user_address'      : $( form_id + ' #user_address').val(),
                        'user_website'      : $( form_id + ' #user_website').val(),
                        'post_content'      : get_editor_value( '.note-editable'),
                    },

                    success: function (data) {

                        toastr.success( data.message );
                    }
                });

                e.preventDefault();
        });
    }

    /**
     *  Password Chagne
     */
    if( $('#user_password_change').length ){

        $('#user_password_change').on( 'submit', function (e) {

                var form_id =  '#' + $(this).attr( 'id' );

                $('html, body').animate({ scrollTop: 0 }, 'slow');
            
                $.ajax({
                    type: 'POST',
                    url: WeddingCity_AJAX_OBJECT.ajaxurl,
                    dataType    : 'json',
                    data: {
                        'action'        : 'weddingcity_user_password_change',
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

                        $( form_id + ' .status').delay(5000).slideUp( "slow", function() {

                            if( data.redirect == true ){

                                document.location.href = WeddingCity_AJAX_OBJECT.home_url;
                            }
                        });
                    },
                    error: function (errorThrown) {

                        toastr.error( data.message ); // $('#user_password_change .status').show().html(data.message);
                    }
                });

                e.preventDefault();
        });


        /**
         *   @ref : https://jsfiddle.net/corbacho/6eQZX/
         */
        $('#user_password_change :password').each(function(){

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

    /**
     *  Social Profile Update
     */
    if( $('#weddingcity_couple_social_notification').length ){

        $('#weddingcity_couple_social_notification').on('submit', function (e) {

                var form_id    = '#'+ $( this ).attr( 'id' );

                $('html, body').animate({ scrollTop: 0 }, 'slow');
            
                $.ajax({

                    type        : 'POST',
                    url         : WeddingCity_AJAX_OBJECT.ajaxurl,
                    dataType    : 'json',
                    data        : {

                        'action'            : 'weddingcity_couple_social_profile_action',
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
     *  Wedding Info
     */
    if( $('form#weddingcity_couple_wedding_info_account').length ){

        $('form#weddingcity_couple_wedding_info_account').on('submit', function (e) {

                var form_id = '#'+ $( this ).attr( 'id' );

                $('html, body').animate({ scrollTop: 0 }, 'slow');

                $.ajax({
                    type        : 'POST',
                    url         : WeddingCity_AJAX_OBJECT.ajaxurl,
                    dataType    : 'json',
                    data:       {

                        'action'                :   'weddingcity_couple_wedding_information',
                        'security'              : $( form_id + ' #wedding_information').val(),
                        'wedding_date'          : $( form_id + ' #wedding_date').val(),
                        'wedding_address'       : $( form_id + ' #real_wedding_address').val(),

                        'bride_first_name'      : $( form_id + ' #bride_first_name').val(), 
                        'bride_last_name'       : $( form_id + ' #bride_last_name').val(),
                        'groom_first_name'      : $( form_id + ' #groom_first_name').val(),
                        'groom_last_name'       : $( form_id + ' #groom_last_name').val(),

                        'bride_image'        : $( form_id + ' #bride_profile_image img').attr( 'src' ),
                        'bride_image_id'     : $( form_id + ' #bride_profile_image img').attr( 'data-attached_id' ),

                        'groom_image'        : $( form_id + ' #groom_profile_image img').attr( 'src' ),
                        'groom_image_id'     : $( form_id + ' #groom_profile_image img').attr( 'data-attached_id' ),
                    },
                    success: function (data) {
                        
                        toastr.success( data.message );
                    }
                });

                e.preventDefault();
        });
    }

    /**
     *  Date Show
     *  ---------
     *  @ref : http://$ui.com/datepicker/#min-max
     */
    if( $( '.wedding_date' ).length ){

        if( $( ".wedding_date" ).attr( 'data-wedding-date') ){

            $( ".wedding_date" ).datepicker();

            // $( ".wedding_date" ).datepicker({

            //     minDate: "+1", 
            //     maxDate: "+2M "+ $( ".wedding_date" ).attr( 'data-wedding-date'),
            // });

        }else{

            $( ".wedding_date" ).datepicker();

            // $( ".wedding_date" ).datepicker({

            //     minDate: "+1", 
            //     maxDate: "+1Y +3M",
            // });
        }

        $('#ui-datepicker-div').before('<div class="default-skin"></div>');
        $('#ui-datepicker-div').appendTo('.default-skin').contents();
    }


})(jQuery);