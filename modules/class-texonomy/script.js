/**
 *  Texonomy Scripts Here
 */

(function($) {

  'use strict';

    if( $('._country_taxonomy_').length ){

        $('._country_taxonomy_').on('change', function(e){

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: WeddingCity_AJAX_OBJECT.ajaxurl,
                data: { 
                    'action'   : 'weddingcity_get_category_data',
                    'taxonomy' : $('._country_taxonomy_').attr( 'data-taxonomy' ),
                    'country'  : $('._country_taxonomy_').val(),
                },
                success: function(data){

                    if( data.html != null ){
                        $('._state_taxonomy_').empty();
                        $('._state_taxonomy_').append( data.html );
                        $('._state_taxonomy_').niceSelect('update');
                    }

                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: WeddingCity_AJAX_OBJECT.ajaxurl,
                        data: { 
                            'action'    : 'weddingcity_get_category_data',
                            'taxonomy'  : $('._state_taxonomy_').attr( 'data-taxonomy' ),
                            'state'     : $('._state_taxonomy_').val(),
                        },
                        success: function(data){

                            if( data.html != null ){
                                $('._city_taxonomy_').empty();
                                $('._city_taxonomy_').append( data.html );
                                $('._city_taxonomy_').niceSelect('update');                      
                            }
                        }
                    });

                }
            });
            e.preventDefault();
        });
    }

    if( $('._state_taxonomy_').length ){

        $('._state_taxonomy_').on('change', function(e){

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: WeddingCity_AJAX_OBJECT.ajaxurl,
                data: { 
                    'action'   : 'weddingcity_get_category_data',
                    'taxonomy' : $('._state_taxonomy_').attr( 'data-taxonomy' ),
                    'state'    : $('._state_taxonomy_').val(),
                },
                success: function(data){

                    if( data.html != null ){
                        $('._city_taxonomy_').empty();
                        $('._city_taxonomy_').append( data.html ); 
                        $('._city_taxonomy_').niceSelect('update'); 
                    }
                }
            });
            e.preventDefault();
        });
    }


    /**
     *  Listing category
     */

    if( $('#listing_category').length ){

        $('#listing_category').on('change', function(e){

            var id = '#' + $(this).attr('id');

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: WeddingCity_AJAX_OBJECT.ajaxurl,
                data: { 
                    'action'            :   'weddingcity_texonomy_venue_action',
                    'vendor_type'       : $('#listing_category').val(), 
                },
                success: function(data){

                    console.log( data.error );

                    if( data.error === true ){

                        $( '#_seat_capacity_, #_aminities_' ).removeClass('d-none');

                        $( '#_seat_capacity_' ).find( 'input' ).val( '' );
                        $( '#_aminities_' ).find( 'input' ).removeAttr( 'checked' );

                    }else{

                        $( '#_seat_capacity_, #_aminities_' ).addClass('d-none');
                    }
                }
            });
            e.preventDefault();
        });
    }

})(jQuery);