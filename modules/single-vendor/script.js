/**
 *  Update Listing Script
 */

(function($) {

  'use strict';

    if( $("#vendor_bussiness_location_singular_page").length ){

        var i = parseFloat( $("#vendor_bussiness_location_singular_page").attr( 'data-latitude' ) );
        var j = parseFloat( $("#vendor_bussiness_location_singular_page").attr( 'data-longitude' ) );

        var category_icon = $("#vendor_bussiness_location_singular_page").attr( 'data-marker' );

        if( i !== null && j !== null ){

            var _position = {
                lat: parseFloat( i ),
                lng: parseFloat( j )
            };
            var map = new google.maps.Map(document.getElementById('vendor_bussiness_location_singular_page'), {
                zoom: 13,
                center: _position
            });
            var marker = new google.maps.Marker({
                position: _position,
                map: map,
                icon: category_icon ? category_icon : WeddingCity_AJAX_OBJECT.map_icon
            });
        }
    }


    $(".video-play").on('click', function(e) {
        e.preventDefault();
        var vidWrap = $(this).parent(),
            iframe = vidWrap.find('.video iframe'),
            iframeSrc = iframe.attr('src'),
            iframePlay = iframeSrc += "?autoplay=1";
        vidWrap.children('.vendor-video-block-img').fadeOut();
        vidWrap.children('.video-play').fadeOut();
        vidWrap.find('.video iframe').attr('src', iframePlay);
    });


    $('.image-link').magnificPopup({

        type: 'image',
        mainClass: 'mfp-with-zoom', 
        zoom: {

            enabled: true, 
            duration: 300, 
            easing: 'ease-in-out', 

            opener: function(openerElement) {
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        },
        image: {
            titleSrc: 'title'
        },
        gallery: {
            enabled: true
        },
    }); 

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


    if( $('form#vendor_singular_page_booking_request').length ){

        $('form#vendor_singular_page_booking_request').on('submit', function(e){

            var form_id = '#'+$(this).attr( 'id' );

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: WeddingCity_AJAX_OBJECT.ajaxurl,
                data: { 
                    'action'            :   'weddingcity_vendor_singular_page_listing_inquiry',
                    'request_name'      : $( form_id +' #request_name').val(), 
                    'request_email'     : $( form_id +' #request_email').val(), 
                    'request_phone'     : $( form_id +' #request_phone').val(), 
                    'weddingdate'       : $( form_id +' #weddingdate').val(), 
                    'request_comment'   : $( form_id +' #request_comment').val(),
                    'listing_post_id'   : $( form_id +' #listing_post_id').val(),
                    'security'          : $( form_id +' #request_for_listing').val()
                },
                success: function(data){

                    $( form_id + ' #request_quote_close_model' ).trigger( 'click' );

                    toastr.success( data.message ); // $( form_id +' span.status').html(data.message);

                    $( form_id +' input, form#vendor_singular_page_booking_request textarea').val('');

                    setTimeout(function(){ 

                        $( form_id +' span.status').slideUp( 'slow' )

                    }, 2000 );

                },
                error: function (errorThrown) {

                    $( form_id +' span.status').html( errorThrown );

                    setTimeout(function(){ 

                        $( form_id +' span.status').slideUp( 'slow' )
                        
                    }, 2000 );
                }
            });
            e.preventDefault();
        });
    }

})(jQuery);