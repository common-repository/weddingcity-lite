/**
 *  Post Removed through front end on click method
 */

(function($) {

  'use strict';

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

})(jQuery);