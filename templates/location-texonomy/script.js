/**
 *  Couple Login & Register Script Here
 */

(function($) {

  'use strict';

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