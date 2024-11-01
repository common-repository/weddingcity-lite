jQuery(document).ready( function($) {

    var _texonomy_media = new Array();

    _texonomy_media.push({
    
        'remove_btn'        :   $( '#header_banner_image_remove' ),
        'image_id'          :   $( "#header_banner_image_id" ),
        'image_section'     :   $( '#header_banner_image_section' ),
        'image_link'        :   $( "#header_banner_image_link" ),
        'image_value'       :   $( '#header_banner_image_media' ),
        'media_title'       :   'Choose Header Banner Image',
        'media_btn_name'    :   'Insert Header Banner Image',
    });

    _texonomy_media.push({
    
        'remove_btn'        :   $( '#term_image_remove' ),
        'image_id'          :   $( "#term_image_id" ),
        'image_section'     :   $( '#term_image_wrapper' ),
        'image_link'        :   $( "#term_image_link" ),
        'image_value'       :   $( '#term_image_media' ),
        'media_title'       :   'Choose Category Image',
        'media_btn_name'    :   'Insert Category Image',
    });

    _texonomy_media.push({
    
        'remove_btn'        :   $( '#marker_image_remove' ),
        'image_id'          :   $( "#marker_image_id" ),
        'image_section'     :   $( '#marker_image_wrapper' ),
        'image_link'        :   $( "#marker_image_link" ),
        'image_value'       :   $( '#marker_image_media' ),
        'media_title'       :   'Choose Category Marker Image',
        'media_btn_name'    :   'Insert Category Marker Image',
    });


    _texonomy_media.map( function( _x ) {

        console.log( _x );

        if( _x.remove_btn ){

            _x.remove_btn.on( 'click', function(){

                    _x.image_id.attr({ value: '' });

                    _x.image_section.hide();

                    _x.image_link.attr( 'src', '' );
            } );
        }

        if( _x.image_value.length ){

            _x.image_value.on('click', function(e) {

                var WeddingCity_Media;

                e.preventDefault();

                if (WeddingCity_Media) {
                    WeddingCity_Media.open();
                    return;
                }

                WeddingCity_Media = wp.media.frames.file_frame = wp.media({

                    title: _x.media_title,
                    button: {
                        text: _x.media_btn_name
                    },
                    multiple: false
                });

                WeddingCity_Media.on('select', function() {

                    var attachment          = WeddingCity_Media.state().get('selection').first().toJSON();

                    // if( $('.WPORGANIC_DEBUG_IS_ON').length ){

                        console.log( 'attachment image' );
                        console.log( attachment );

                        console.log( 'attachment image id' );
                        console.log( attachment['id'] );

                        console.log( 'attachment image url' );
                        console.log( attachment['url'] );
                    // }

                    if( _x.image_id.length ){

                        _x.image_id.attr({ value: attachment['id'] });

                        _x.image_section.show();

                        _x.image_link.attr( 'src', attachment['url'] );

                        _x.image_link.attr( 'srcset', '' );
                    }

                });

                WeddingCity_Media.open();

            });
        }

    });

    // Marker Upload or Selected Condition
    if( $( '#marker_option' ).length ){

        $( '#marker_option' ).on( 'change', function( e ){

            if( $( '#marker_option' ).val() != '0' ){

                $('#section_marker_image_id').hide();

            }else{

                $('#section_marker_image_id').show();
            }

            e.preventDefault();

        } );

        if( $( '#marker_option' ).val() != '0' ){

            $('#section_marker_image_id').hide();

        }else{

            $('#section_marker_image_id').show();
        }
    }

    // Category Icon 
    if( $( '#weddingcity_texonomy_icon' ).length ){

        $( '#weddingcity_texonomy_icon' ).on( 'change', function( e ){

            if( $( '#weddingcity_texonomy_icon' ).val() != '0' ){

                $('#section_term_icon').hide();

            }else{

                $('#section_term_icon').show();
            }

            e.preventDefault();

        } );

        if( $( '#weddingcity_texonomy_icon' ).val() != '0' ){

            $('#section_term_icon').hide();

        }else{

            $('#section_term_icon').show();
        }
    }

});