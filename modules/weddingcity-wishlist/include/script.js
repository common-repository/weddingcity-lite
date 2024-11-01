
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

                if( ! $(this).hasClass( 'disabled' ) ){

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
                }
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
    }   

    WeddingCity_Wishlist();

})(jQuery);