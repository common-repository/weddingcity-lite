/**
 *  Post Removed through front end on click method
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

    /**
     *   Wishlist Icon Facility
     */

    function WeddingCity_Wishlist(){

        /**
         *   Listing Single Page Wishlist
         */

        if( ( $('.btn-default-wishlist').length || $('.remove-wishlist-single').length ) && ! $( '#disable-wishlist' ).length ){

            $('.btn-default-wishlist').live('click', function(e){

                $(this).addClass( 'remove-wishlist-single' ).removeClass( 'btn-default-wishlist' );
               
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: WeddingCity_AJAX_OBJECT.ajaxurl,
                    data: { 
                        'action'            :   'weddingcity_add_wishlist',
                        'listing_id'       :  $(this).attr('data-wishlist'),
                    },
                    success: function(data){

                        $( '#single-wishlist-content' ).text( 'In Wishlist' );

                        weddingcity_alert_message( data );
                        
                        if( data.redirect == true ){
                            setTimeout(function(){ document.location.href = data.dashboard; }, 5000 );
                        }
                    }
                });
                e.preventDefault();
            });

            $('.remove-wishlist-single').live( 'click', function(e){
               
                $(this).removeClass( 'remove-wishlist-single' ).addClass( 'btn-default-wishlist' );

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: WeddingCity_AJAX_OBJECT.ajaxurl,
                    data: { 
                        'action'       :   'weddingcity_remove_wishlist',
                        'listing_id'   :  $(this).attr('data-wishlist'),
                    },
                    success: function(data){

                        $( '#single-wishlist-content' ).text( 'Add To Wishlist' );

                        weddingcity_alert_message( data );
                        
                        if( data.redirect == true ){
                            setTimeout(function(){ document.location.href = data.dashboard; }, 5000 );
                        }
                    }
                });
                e.preventDefault();
            });
        }

        /**
         *   Listing Search with ShortCode Hart icon Wishlist
         */

        if( ( $('.btn-wishlist').length || $('.remove-wishlist').length ) && ! $( '#disable-wishlist' ).length ){

            $('.btn-wishlist').live('click', function(e){

                if( ! $(this).hasClass( 'disabled' ) ){

                        $(this).attr( 'class', 'remove-wishlist' );
                        $(this).find('i').attr( 'class','fas fa-times');
                       
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: WeddingCity_AJAX_OBJECT.ajaxurl,
                            data: { 
                                'action'            :   'weddingcity_add_wishlist',
                                'listing_id'       :  $(this).attr('data-wishlist'),
                            },
                            success: function(data){

                                weddingcity_alert_message( data );
                                
                                if( data.redirect == true ){
                                    setTimeout(function(){ document.location.href = data.dashboard; }, 5000 );
                                }
                            }
                        });
                        e.preventDefault();
                }
            });

            $('.remove-wishlist').live( 'click', function(e){
               
                $(this).attr('class','btn-wishlist');
                $(this).find('i').attr( 'class','fa fa-heart');

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: WeddingCity_AJAX_OBJECT.ajaxurl,
                    data: { 
                        'action'       :   'weddingcity_remove_wishlist',
                        'listing_id'   :  $(this).attr('data-wishlist'),
                    },
                    success: function(data){

                        weddingcity_alert_message( data );
                        
                        if( data.redirect == true ){
                            setTimeout(function(){ document.location.href = data.dashboard; }, 5000 );
                        }
                    }
                });
                e.preventDefault();
            });
        }

    }   WeddingCity_Wishlist();

    /**
     *  Review dispaly with this class
     */
     function weddingcity_review(){

        if( $('.weddingcity_review').length ){

            $('.weddingcity_review').map(function( index, value ){

                var review = $(this).attr( 'data-review' );

                $( $(this) ).rateYo({
                        readOnly: true,
                        rating: review,
                        starWidth: "16px",
                        halfStar: true,
                        normalFill: "#d9d5d4",
                        ratedFill: "#ff775a"
                });
            });
        }

    }   weddingcity_review();

    /**
     *  Search Listing
     */

    function weddingcity_get_listing(){

        $('#listing_search_result').empty();

        if( $("#listing_map").length ){
            $("#listing_map").empty();  // .hide();
        }

        var div = '<div class="row"><div class="col-12" id="search_loader"></div></div>';

        $( div ).insertBefore( $('#listing_search_result') );

        $('#search_loader').html( WeddingCity_AJAX_OBJECT.ajax_loading  );

        var listing_amenities = {};

        if( $('input[name=listing_amenities]').length ){

            $('input[name=listing_amenities]:checked').each(function( index, news ) {
                listing_amenities[ $(this).attr( 'data-value' ) ] = news.value;
            });
        }

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: WeddingCity_AJAX_OBJECT.ajaxurl,
            data: { 
                'action'                : 'weddingcity_search_venue_results',
                'column'                : $('#column').val(),
                'listing-category'           : $('#listing-category').val(),
                'listing_category_id'   : $("#listing_category_id").val(),
                'listing_amenities'     : listing_amenities,
                'min_price'             : $('#min_price').val(),
                'max_price'             : $('#max_price').val(),
                'min_seat'              : $('#min_seat').val(),
                'max_seat'              : $('#max_seat').val(),
                'listing-city'          : $('#listing-city').val(),
                'venue_map'             : $('#listing_map_position').val(),
                'pagination'            : $('#pagination').val(),
            },
            success: function(data){

                $('#search_loader').parent().remove();
                $('#listing_search_result').html( data.html ).append( data.get_pagination );

                if( data.map_show == true ){

                    if( $( '.WeddingCity_listing' ).length ){

                        WeddingCity_Listing_Data();

                        /**
                         *  Old style Listing Functionlity
                         *
                         *  -->  WeddingCity_Venue_Listing();
                         */

                        if( $('.WeddingCity_listing .d-none').length ){
                            $('.WeddingCity_listing .d-none').remove();
                        }

                        WeddingCity_Pagination();

                        if( $( '.wishlist-sign' ).length ){

                            WeddingCity_Wishlist();
                        }
                        
                        WeddingCity_Get_Reviews();
                    }
                }
            }
        });
    }

    /**
     *  Review dispaly with this class
     */
     function WeddingCity_Get_Reviews(){

        if( $('.weddingcity_review').length ){

            $('.weddingcity_review').map(function( index, value ){

                var review = $(this).attr( 'data-review' );

                $( $(this) ).rateYo({
                        readOnly: true,
                        rating: review,
                        starWidth: "16px",
                        halfStar: true,
                        normalFill: "#d9d5d4",
                        ratedFill: "#ff775a"
                });
            });
        }

    }   WeddingCity_Get_Reviews();
    

    if( $("#listing_search_result").length ){
        weddingcity_get_listing();
    }


    function WeddingCity_Clear_Marker( id ){

        var clear_all = document.getElementById( id );
        google.maps.event.addDomListener(clear_all, 'click', clearClusters);
    }

    if( $('form#seach_result_form').length ){

        $('form#seach_result_form').on('submit', function(e){            
            weddingcity_get_listing();
            e.preventDefault();
        });

        if( $('#listing-category').length ){
            $('#listing-category').change( function(e) {

                var clear_all = document.getElementById( 'listing-category' );
                google.maps.event.addDomListener(clear_all, 'click', clearClusters);

                weddingcity_get_listing();
                e.preventDefault();
            });
        }

        if( $('#listing-city').length ){
            $('#listing-city').change( function(e) {
                weddingcity_get_listing();
                e.preventDefault();
            });
        }

        if( $('input[name=listing_amenities]').length ){
            $('input[name=listing_amenities]').change( function(e) {
                weddingcity_get_listing();
                e.preventDefault();
            });
        }

        if( $("#price_filter").length ){
            $("#price_filter").change(function(e){

                var min      = $('option:selected', this).attr('data-min');
                var max      = $('option:selected', this).attr('data-max');
                var compare  = $('option:selected', this).attr('data-compare');

                $('#max_price').val( max );
                $('#min_price').val( min );

                weddingcity_get_listing();
                e.preventDefault();
            });
        }

        if( $("#seat_capacity").length ){
            $("#seat_capacity").change(function(e){

                var min      = $('option:selected', this).attr('data-min');
                var max      = $('option:selected', this).attr('data-max');

                $('#max_seat').val( max );
                $('#min_seat').val( min );

                if( $('.WPORGANIC_DEBUG_IS_ON').length )
                    console.log( 'min seat =>'+min+'\nMax seat =>'+max );

                weddingcity_get_listing();
                e.preventDefault();

            });
        }

        if( $("#listing_category_id").length ){
            $("#listing_category_id").change(function(e){
                weddingcity_get_listing();
                e.preventDefault();
            });
        }
    }




    // Map Pagination

    // @ref : https://jsfiddle.net/yw7y4wez/1739/

    function WeddingCity_Pagination(){

        var paination = 9;

        if( $( '#pagination' ).length ){

            var paination = $( '#pagination' ).val();
        }

        if( $('#listing-pagination').length ){

            $('#listing-pagination').twbsPagination({

                totalPages: $( 'div.listing-post' ).length,
                // the current page that show on start
                startPage: 1,

                // maximum visible pages
                visiblePages: $( 'div.listing-post' ).length,

                initiateStartPageClick: true,

                // template for pagination links
                href: false,

                // variable name in href template for page number
                hrefVariable: '{{number}}',

                // Text labels
                first: false,
                prev: 'Previous',
                next: 'Next',
                last: false,

                // carousel-style pagination
                loop: false,

                // callback function
                onPageClick: function (event, page) {
                    $('.page-active').removeClass('page-active');
                    $('#listing-section'+page).addClass('page-active');
                },

                // pagination Classes
                paginationClass: 'pagination justify-content-center',
                nextClass: 'next',
                prevClass: 'prev',
                lastClass: 'last',
                firstClass: 'first',
                pageClass: 'listing-post',
                activeClass: 'active',
                disabledClass: 'disabled'

            });

        }else{

            if( $( 'div.listing-post' ).length ){

                $( 'div.listing-post' ).show();
            }
        }


        if( $( 'li.listing-post' ).length ){

            $( 'li.listing-post' ).map( function( index ){

                    $( this ).attr( 'id', 'listing_pagination_'+ index );
            } );
        }
    }

    if( $("#singlelistmap").length ){

        var i = parseFloat( $("#singlelistmap").attr( 'data-latitude' ) );
        var j = parseFloat( $("#singlelistmap").attr( 'data-longitude' ) );

        var category_icon = $("#singlelistmap").attr( 'data-marker' );

        if( i !== null && j !== null ){

            var _position = {
                lat: parseFloat( i ),
                lng: parseFloat( j )
            };
            var map = new google.maps.Map(document.getElementById('singlelistmap'), {
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

    // function WeddingCity_Venue_Listing(){

    //     if( $("#listing_map").length ){

    //         $("#listing_map").show();

    //         if( $('.WeddingCity_listing').length ){

    //             var _lat_ = parseFloat( $('.WeddingCity_listing').find('.venue_latitude').val() );
    //             var _lng_ = parseFloat( $('.WeddingCity_listing').find('.venue_longitude').val() );

    //             var map = new google.maps.Map(document.getElementById('listing_map'), {
    //                 zoom: 14,
    //                 center: { lat: parseFloat( _lat_ ), lng: parseFloat( _lng_ ) }
    //             });

    //             var allMyMarkers = [];

    //             var infoWin = new google.maps.InfoWindow();

    //             // Create an array of alphabetical characters used to label the markers.
    //             var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    //         }else{

    //             var map = new google.maps.Map(document.getElementById('listing_map'), {
    //                 zoom: 7,
    //                 center: { lat: parseFloat( 23.0199968 ), lng: parseFloat( 72.2995501 ) }
    //             });
    //         }

    //         var locations = new Array();

    //         $('.WeddingCity_listing').map(function( index, value ) {

    //             locations.push({
    //                 'id'        : $(this).attr('id'),
    //                 'lat'       : parseFloat( $(this).find('.venue_latitude').val() ),
    //                 'lng'       : parseFloat( $(this).find('.venue_longitude').val() ),
    //                 'url'       : $(this).find('.venue_page_link').val(),
    //                 'title'     : $(this).find('.venue_title').val(),
    //                 'image'     : $(this).find('.venue_image').val(),
    //                 'address'   : $(this).find('.venue_address').val(),
    //                 'icon'      : $(this).find('.venue_icon').val(),
    //             });
    //         });

    //         var markers = locations.map(function(location, i) {

    //             var marker = new google.maps.Marker({
    //                 position: new google.maps.LatLng(location.lat, location.lng),
    //                 map: map,
    //                 icon: location.icon,
    //                 id: location.id
    //             });

    //             var link_6e = is_null(location.url) ? location.url : window.location;

    //             var title = is_null(location.title) ? '<h2 class="vendor-title"><a href="' + link_6e + '" class="title">' + location.title + '</a></h2>' : '';

    //             var image_6e = is_null(location.image) ? '<a href="' + link_6e + '"><img src="' + location.image + '" alt="map-image" class="img-fluid"></a>' : '';

    //             var address = is_null(location.address) ? '<p class="vendor-address">' + location.address + '</p>' : '';

    //             var content = '<div class="vendor-listing-window">' +
    //                 '<div class="vendor-img">' +
    //                 image_6e +
    //                 '<div class="wishlist-sign">' +
    //                 '<a href="' + link_6e + '" class="btn-wishlist"><i class="fa fa-heart"></i></a>' +
    //                 '</div>' +
    //                 '</div>' +
    //                 '<div class="vendor-content">' +
    //                 title + location.address +
    //                 '</div>';

    //                 // https://codepen.io/Marnoto/pen/xboPmG

    //               google.maps.event.addListener( infoWin, 'domready', function() {

    //                  var hal_no_brother = $('.gm-style-iw');

    //                  var big_brother    = $('.gm-style-iw').parent();

    //                  $( big_brother ).attr('id', 'Infowindow-wrapper' );

    //                  $( hal_no_brother ).attr('id', 'weddingcity_infowindow_content' );

    //                  $( '#Infowindow-wrapper' ).children().attr( 'id', 'infowindow-div-first' );
    //                  $( '#infowindow-div-first' ).next().attr( 'id', 'infowindow-div-sec' );
    //                  $( '#infowindow-div-sec' ).next().attr( 'id', 'infowindow-div-third' );

    //               });

    //             google.maps.event.addListener(marker, 'click', function(evt) {
    //                 infoWin.setContent(content);
    //                 infoWin.open(map, marker);
    //             })

    //             allMyMarkers.push(marker);

    //             return marker;

    //         });

    //         function is_null($args) {

    //             if ($args != '' && $args != null && $args != 'undefined')
    //                 return true;

    //             else
    //                 return false;
    //         }

    //         if ($('.WeddingCity_listing').length) {

    //             $('.WeddingCity_listing').on('mouseover', function() {

    //                 var selectedID = $(this).attr('id');
    //                 toggleBounce(selectedID);
    //             });

    //             function toggleBounce(selectedID) {

    //                 var pinID = selectedID;

    //                 for (var j = 0; j < allMyMarkers.length; j++) {

    //                     if ( allMyMarkers[j].id == pinID ) {

    //                         if (allMyMarkers[j].getAnimation() != null) {

    //                             allMyMarkers[j].setAnimation(null);

    //                         } else {

    //                             allMyMarkers[j].setAnimation(google.maps.Animation.BOUNCE);
    //                             map.setCenter(allMyMarkers[j].getPosition());

    //                         }
    //                         break;
    //                     }
    //                 }
    //             }
    //         }

    //     var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    //     var markerCluster = new MarkerClusterer(map, markers,
    //         {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
    //     }
    // }


})(jQuery);