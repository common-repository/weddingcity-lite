
(function($) {  "use strict"; 

    var media_objects = new Array(), weddingcity_media_object = new Array();

    weddingcity_media_object.push({
    
        'object'    :  Groom_Profile_Upload_Object,
        'media_id'  :  '#wc_groom_upload',
    });

    weddingcity_media_object.push({
    
        'object'    :  Bride_Profile_Upload_Object,
        'media_id'  :  '#wc_bride_upload',
    });

    weddingcity_media_object.push({
    
        'object'    :  Gallery_Upload_Object,
        'media_id'  :  '#wc_gallery_upload',
    });

    weddingcity_media_object.push({
    
        'object'    :  Vendor_Business_Gallery,
        'media_id'  :  '#wc_vendor_gallery_upload',
    });

    weddingcity_media_object.push({
    
        'object'    :  Profile_Upload_Object,
        'media_id'  :  '#wc_profile_upload',
    });

    weddingcity_media_object.push({
    
        'object'    :  Featured_Image_Object,
        'media_id'  :  '#wc_featured_upload',
    });

    weddingcity_media_object.push({
    
        'object'    :  RealWedding_Featured_Image_Object,
        'media_id'  :  '#wc_realwedding_featured_upload',
    });

    weddingcity_media_object.push({
    
        'object'    :  Vendor_Bussiness_Profile_Banner,
        'media_id'  :  '#wc_vendor_profile_banner_upload',
    });

    weddingcity_media_object.push({
    
        'object'    :  Vendor_Bussiness_Profile_Brand_Icon,
        'media_id'  :  '#wc_vendor_business_brand_upload',
    });


    weddingcity_media_object.map( function( i ) {

        if( $( i.media_id ).attr( 'data-upload-limit' ) == 'single' ){

            media_objects.push({
            
                'object_name'           :  i.object,
                'browse_button'         :  ( $( i.media_id ).find('.browse_button').val() ),
                'image_preview'         :  ( $( i.media_id + ' img' ) ),
                'add_image_id'          :  ( $( i.media_id + ' img' ) ),
                'old_image_id'          :  ( $( i.media_id + ' img' ) ),
                'display_error_div'     :  ( $( '#' + $( i.media_id ).find('.display_error_div').attr( 'id' ) ) ),
                'upload_limit'          :  ( $( i.media_id ).attr( 'data-upload-limit' ) ),
            });

        }else if( $( i.media_id ).attr( 'data-upload-limit' ) == 'multiple' ){

            media_objects.push({
            
                'object_name'           :  i.object,
                'browse_button'         :  ( $( i.media_id ).find('.browse_button').val() ),
                'image_preview'         :  ( '#' + $( i.media_id ).attr( 'data-media-show' ) ),
                'add_image_id'          :  ( '#' + $( i.media_id ).attr( 'data-media-show' ) ),
                'old_image_id'          :  ( '#' + $( i.media_id ).attr( 'data-media-show' ) ),
                'display_error_div'     :  ( $( '#' + $( i.media_id ).find('.display_error_div').attr( 'id' ) ) ),
                'upload_limit'          :  ( $( i.media_id ).attr( 'data-upload-limit' ) ),
            });
        }
    });

    var wc_variable = '0';

    media_objects.map( function( _x ) { wc_variable++;

        console.log( wc_variable );

        if (typeof(plupload) !== 'undefined') {

            var wc_variable = new plupload.Uploader( _x.object_name.plupload );

            wc_variable.init();

            wc_variable.bind('FilesAdded', function (up, files) {
               
                $.each(files, function (i, file) {
                    
                    $( _x.display_error_div ).append(

                        '<div class="alert alert-success" id="' + file.id + '">' +
                        file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                        '</div>');
                });

                up.refresh(); // Reposition Flash/Silverlight

                wc_variable.start();
            });

            wc_variable.bind('UploadProgress', function (up, file) {
                $('#' + file.id + " b").html(file.percent + "%");
            });

            // On erro occur
            wc_variable.bind('Error', function (up, err) {

                $( _x.display_error_div ).append("<div class='file_upload_error alert alert-danger'>Error: " + err.code +

                    ", Message: " + err.message +
                    (err.file ? ", File: " + err.file.name : "") +
                    "</div>"
                );

                setTimeout(function(){ $( '.file_upload_error' ).slideUp( "slow" ); }, 10000 );

                up.refresh(); // Reposition Flash/Silverlight
            });

            wc_variable.bind('FileUploaded', function (up, file, response) {

                if( _x.upload_limit == 'single' ){

                    var $_old_image_id =  $( _x.old_image_id ).attr('data-attached_id');
                    console.log( '[WeddingCity Debug] Before Uploaded Image id :'+  $_old_image_id );

                    var fileCount = up.files.length,
                        i = 0,
                        ids = $.map(up.files, function (item) { return item.id; });

                    for (i = 0; i < fileCount; i++) {
                        wc_variable.removeFile(wc_variable.getFile(ids[i]));
                    }                 
                
                    var result = $.parseJSON(response.response);
                 
                    $('#' + file.id).remove();
                    if (result.success) {

                        console.log( result );

                        if( $_old_image_id != 0 && $_old_image_id != null ){

                            removed_image_id( $_old_image_id );
                        }                

                        $( _x.image_preview ).attr('src',result.html);
                        $( _x.add_image_id ).attr('data-attached_id',result.attach);

                        console.log( '[WeddingCity Debug] After Uploaded Image id :'+  result.attach );
                    }
                }

                if( _x.upload_limit == 'multiple' ){

                    var result = $.parseJSON(response.response);
                 
                    $('#' + file.id).remove();

                    if (result.success) {  

                        console.log( result );
                        
                        var gallery_ids  =   $( _x.old_image_id ).attr( 'data-attached_id' );

                        if( gallery_ids != null && gallery_ids != '' ){

                            gallery_ids  =   gallery_ids  +   "," +   result.attach;

                        }else{

                            gallery_ids  =  result.attach;
                        }

                        $( _x.add_image_id ).attr( 'data-attached_id', gallery_ids );
                                
                        if (result.html!==''){

                            $('.default-vendor-gallery').remove();

                            $( _x.image_preview ).
                                append('<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">'
                                        +  '<div class="gallery-upload-img">'
                                        +      '<img src="'+result.html+'" data-image-id="'+result.attach+'" class="img-fluid">'
                                        +      '<span class="delete-gallery-img"><i class="fa fa-times-circle" data-image-id="'+result.attach+'"></i></span>'
                                        +  '</div>'
                                        + '</div>');
                            
                        }else{

                            $( _x.image_preview ).
                                append('<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">'
                                        +  '<div class="gallery-upload-img">'
                                        +      '<img src="../images/gallery-thumb.jpg" data-image-id="0" class="img-fluid">'
                                        +      '<span class="delete-gallery-img"><i class="fa  fa-times-circle"></i></span>'
                                        +  '</div>'
                                        + '</div>');

                        }
                        
                        delete_binder();
                    }
                }

            });

            if( $( _x.browse_button ).length ){
                $( _x.browse_button ).on( 'click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    wc_variable.start();
                });
            }
        }

    });

    function removed_image_id( $id ){

        if( $id !== 0 &&  $id !== null ){

            $.ajax({
                type        : 'POST',
                url         : WeddingCity_AJAX_OBJECT.ajaxurl,
                dataType    : 'json',
                data:       { 

                    'action'        :  'WeddingCity_Upload_File_Delete',
                    'attach_id'    :   $id
                },
                success: function (data) {
                
                    console.log( '[WeddingCity Debug] '+ data.message );
                }
            });
        }
    }

    function delete_binder(){

        if( $('span.delete-gallery-img i').length ){

            $('span.delete-gallery-img i').on( 'click', function(e){

                var image_id_exists = $(this).attr( 'data-image-id' );

                /**
                 * @link - https://css-tricks.com/snippets/jquery/make-an-jquery-hasattr/#article-header-id-0
                 */
                
                if( typeof image_id_exists !== typeof undefined && image_id_exists !== false ){

                    var _gallery_parent_id = '#' + $(this).closest( '.row' ).attr( 'id' );

                    var curent = '';

                    if ( ! confirm( 'Are you sure ?' )  ){
                        return false;
                    }

                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: WeddingCity_AJAX_OBJECT.ajaxurl,
                        data: { 
                            'action'      :   'WeddingCity_Upload_File_Delete',
                            'attach_id'   :   $(this).attr( 'data-image-id' ),
                        },
                        success: function(data){

                            if( $('.WPORGANIC_DEBUG_IS_ON').length )
                                console.log( data.message );

                        },
                        error: function (errorThrown) {
                            console.log( 'Error for id' );
                        }
                    });

                    e.preventDefault();

                    $(this).parent().parent().parent().remove();

                    $( _gallery_parent_id + ' img').each(function(){

                        if( $( this ).attr( 'data-image-id' ) != '' ){

                            curent = curent + ',' + $(this).attr('data-image-id'); 
                        }
                    });

                    $( _gallery_parent_id ).attr( 'data-attached_id', curent);

                    if( $('.WPORGANIC_DEBUG_IS_ON').length )
                        console.log( curent );

                }else{

                    console.log( 'Image Not Found...' );
                }

            });
        }               
    }

    delete_binder();

})(jQuery);  // END of jQuery
