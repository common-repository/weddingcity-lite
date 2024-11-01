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
     *. @ Vendor Update Own venue through Front end
     */
    if( $('form#vendor-update-listing').length ){

        // @ref : Multiple checkboxes - http://jsfiddle.net/4kwnR/16/

        $('form#vendor-update-listing').on('submit', function(e){

            /**
             *   Form ID
             */
            
            var form_id = '#'+$(this).attr('id');

            button_disable( $( form_id +' button[type=submit]').attr( 'id' ) );

            $('html, body').animate({ scrollTop: 0 }, 'slow');

            $( form_id +' #vendor_add_listing_btn').addClass('disabled').attr('aria-disabled','true');

            var venue_amenities =  {};

            $("input[name=venue_amenities]:checked").map(function( i ) {
                venue_amenities[ $(this).attr( 'data-value' ) ] = $(this).val()
            });

            if( $('.WPORGANIC_DEBUG_IS_ON').length )
                console.log( venue_amenities );

            $( 'input' ).map( function( i ){
                $(this).attr( 'value', $(this).val() );
            });

            var is_featured_listing = 'off';
            $( form_id +' input[name=featured_listing]:checked').each(function( index, news ) {

                if( news.value != '' || news.value != null )
                    is_featured_listing = news.value;
            });

            $.ajax({

                type: 'POST',
                dataType: 'json',
                url: WeddingCity_AJAX_OBJECT.ajaxurl,
                data: {

                    'action'                    : 'weddingcity_update_listing_action',
                    'security'                  : $( form_id +' #vendor_update_listing').val(),
                    'post_title'                : $( form_id +' #post_title').val(),
                    'listing_category'          : $( form_id +' #listing_category').val(),
                    'seat_capacity'             : $( form_id +' #seat_capacity').val(),
                    'venue_price'               : $( form_id +' #venue_price').val(),
                    'venue_address'             : $( form_id +' #venue_address').val(),
                    'venue_state'               : $( form_id +' #venue_state').val(),
                    'venue_country'             : $( form_id +' #venue_country').val(),
                    'venue_city'                : $( form_id +' #venue_city').val(),
                    'venue_latitude'            : $( form_id +' #venue_latitude').val(),
                    'venue_longitude'           : $( form_id +' #venue_longitude').val(),
                    'venue_map_address'         : $( form_id +' #venue_map_address').val(),
                    'venue_video'               : $( form_id +' #venue_video').val(),
                    'vendor_gallery'            : $( form_id +' #gallery_image_list').attr( 'data-attached_id' ),
                    'vendor_featured_image'     : $( form_id +' #featured_image_preview img').attr( 'src' ),
                    'vendor_featured_id'        : $( form_id +' #featured_image_preview img').attr( 'data-attached_id' ),
                    'vendor_post_update'        : $( form_id +' #vendor_post_update').val(),
                    'vendor_edit_listing'       : $( form_id +' #vendor_edit_listing').val(),

                    'post_content'              : get_editor_value( '.note-editable'),
                    'featured_listing'          : is_featured_listing,
                    'venue_amenities'           : venue_amenities,
                },
                success: function(data){
                    
                    toastr.success( data.message );

                    if ( data.redirect == true ){

                        setTimeout(function(){ document.location.href = data.redirect_link; }, 1000 );  
                    }
                }
            });

            e.preventDefault();

        });
    }

    /**
     *  Plugin Version 1.1
     */
    function WeddingCity_Listing_Front_End_InitMap() {

        var

        _lat     =  ( $('#venue_latitude').val() != '' )  ? parseFloat( $('#venue_latitude').val() )  : parseFloat( WeddingCity_AJAX_OBJECT.weddingcity_latitude ),
        _lng     =  ( $('#venue_longitude').val() != '' ) ? parseFloat( $('#venue_longitude').val() ) : parseFloat( WeddingCity_AJAX_OBJECT.weddingcity_longitude ),
        _image   =  WeddingCity_AJAX_OBJECT.map_icon;

        var myLatlng = {lat: parseFloat( _lat ), lng: parseFloat( _lng ) };

        var map = new google.maps.Map(document.getElementById('map_canvas'), {
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

    if( $('#map_canvas').length ){
        
        /**
         *  @credit : http://jsfiddle.net/pmrotule/jcg6j5qr/
         */
        WeddingCity_Listing_Front_End_InitMap();
    }


    if( $( '#map_canvas' ).length ){

        $( document ).on( 'change hover mouseover mouseout mousemove', function(e){

            if( $( 'button.dismissButton' ).length ){

                $( 'button.dismissButton' ).trigger( 'click' );
            }

        } );
    }

})(jQuery);