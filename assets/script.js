(function($) {

  'use strict';

    if( $('.weddingcity-nice-select select').length ){
        $('.weddingcity-nice-select select').niceSelect();

        if( $(".nice-select").length ){

            $(".nice-select").addClass( 'wide' );
        }
    }

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

    if( $('.venue-pageheader a.btn-gallery').length ){

        // @ref : https://codepen.io/bluminethemes/pen/reEJZa
    
        $('.venue-pageheader a.btn-gallery').on('click', function(event) {
            event.preventDefault();
            
            var gallery = $(this).attr('href');
        
            $(gallery).magnificPopup({
                delegate: 'a',
                type:'image',
                gallery: {
                    enabled: true
                }
            }).magnificPopup('open');
        });
    }

    if( $('.user-rate-us').length ){
 
        $('.user-rate-us').map(function( index, value ){

            var _id_   = $(this).attr('id');
            var data   = $(this).attr('data-rating');

            $( '#'+_id_ ).rateYo({
                readOnly: true,
                rating: data,
                starWidth: "16px",
                halfStar: true
            });
        });
    }


    if( $('#select_venue_request').length ){

        $('#select_venue_request').on( 'change', function(e){

            var listing_id  = $(this).val();

            $('.request_div tr').map( function( i ){

                if( $(this).attr('data-listing-id') == listing_id || listing_id == 'all' ){

                        $(this).show();

                }else{
                        $(this).hide();
                }

            });
        });
    }

    /**
     *   Button On click scroll
     */
    function WeddingCity_Scroll_Div( div_id, scroll_div_id ){

        $( '#' + div_id ).on( 'click', function( e ) {

             e.preventDefault();
             
            $('html, body').animate({
                scrollTop: $( '#' + scroll_div_id ).offset().top
            }, 1000);

        });
    }

    WeddingCity_Scroll_Div( 'goto_map', 'map_section' );

    WeddingCity_Scroll_Div( 'goto_review', 'listing_review_process_section' );
    
    WeddingCity_Scroll_Div( 'goto_review_btn', 'listing_review_process_section' );


    /** Dashboard Menu Script */

    if( $('[data-toggle="offcanvas"]').length ){

        $('[data-toggle="offcanvas"]').on('click', function () {

            $('.offcanvas-collapse').toggleClass('open')
        });      
    }


    // Texonomy Pagination

    if( $( '#texonomy_pagination' ).length ){

        $('#texonomy_pagination').twbsPagination({

            totalPages: $( 'div.vendor-post' ).length,
            // the current page that show on start
            startPage: 1,

            // maximum visible pages
            visiblePages: $( 'div.vendor-post' ).length,

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
                $('#vendor-section'+page).addClass('page-active');
            },

            // pagination Classes
            paginationClass: 'pagination justify-content-center',
            nextClass: 'next',
            prevClass: 'prev',
            lastClass: 'last',
            firstClass: 'first',
            pageClass: 'vendor-post',
            activeClass: 'active',
            disabledClass: 'disabled'

        });
    }
    
})(jQuery);