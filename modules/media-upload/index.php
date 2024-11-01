<?php

/**
 *  WeddingCity Media Upload
 */

if( ! class_exists( 'WeddingCity_Media_Upload' ) ){

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Media_Upload{

        /**
         * Member Variable
         *
         * @var instance
         */
        private static $instance;

        /**
         *  Initiator
         */
        public static function get_instance() {
          
            if ( ! isset( self::$instance ) ) {
              self::$instance = new self;
            }
            return self::$instance;
        }

        public function __construct() {

            add_action( 'wp_enqueue_scripts', array( $this, 'WeddingCity_Upload_File_AJAX_Script' ) );

            add_action( 'wp_ajax_WeddingCity_Upload_File_Delete',  array( $this, 'WeddingCity_Upload_File_Delete' ) );
            
            add_action( 'wp_ajax_nopriv_WeddingCity_Upload_File_Delete', array( $this, 'WeddingCity_Upload_File_Delete' ) );

            self:: weddingcity_media_object_runtime_ajax();
        }

        public static function weddingcity_media_object_runtime_ajax(){

            /**
             *  Gallery Upload Library
             */
            add_action( 'wp_ajax_WeddingCity_Gallery_Media',  function(){ 
                self:: media_files( esc_html( 'Media_Upload_Gallery_Files' ) ); 
            } );
            add_action( 'wp_ajax_nopriv_WeddingCity_Gallery_Media', function(){ 
                self:: media_files( esc_html( 'Media_Upload_Gallery_Files' ) ); 
            } );

            /**
             *  Vendor Bussiness Gallery
             */
            add_action( 'wp_ajax_vendor_bussiness_gallery_media',  function(){ 
                self:: media_files( esc_html( 'vendor_bussiness_media_upload_gallery_files' ) ); 
            } );
            add_action( 'wp_ajax_nopriv_vendor_bussiness_gallery_media', function(){ 
                self:: media_files( esc_html( 'vendor_bussiness_media_upload_gallery_files' ) ); 
            } );

            /**
             *  User Profile Upload Library
             */
            add_action( 'wp_ajax_WeddingCity_Profile_Media',  function(){ 
                self:: media_files( esc_html( 'Media_Upload_Profile_Files' ) ); 
            } );
            add_action( 'wp_ajax_nopriv_WeddingCity_Profile_Media', function(){ 
                self:: media_files( esc_html( 'Media_Upload_Profile_Files' ) ); 
            } );

            /**
             *  Featured Image Upload Library
             */
            add_action( 'wp_ajax_WeddingCity_Featured_Image_Media',  function(){ 
                self:: media_files( esc_html( 'Featured_Image_Upload_Files' ) ); 
            } );
            add_action( 'wp_ajax_nopriv_WeddingCity_Featured_Image_Media', function(){ 
                self:: media_files( esc_html( 'Featured_Image_Upload_Files' ) ); 
            } );

            /**
             *  Real Wedding Featured Image Upload Library
             */
            add_action( 'wp_ajax_WeddingCity_Realwedding_Featured_Image_Media',  function(){ 
                self:: media_files( esc_html( 'Realwedding_Featured_Image_Upload_Files' ) ); 
            } );
            add_action( 'wp_ajax_nopriv_WeddingCity_Realwedding_Featured_Image_Media', function(){ 
                self:: media_files( esc_html( 'Realwedding_Featured_Image_Upload_Files' ) ); 
            } );

            /**
             *  Vendor Bussiness Profile Banner Image Upload Library
             */
            add_action( 'wp_ajax_vendor_bussiness_profile_image_media',  function(){ 
                self:: media_files( esc_html( 'vendor_bussiness_profile_banner_upload_files' ) ); 
            } );
            add_action( 'wp_ajax_nopriv_vendor_bussiness_profile_image_media', function(){ 
                self:: media_files( esc_html( 'vendor_bussiness_profile_banner_upload_files' ) ); 
            } );

            /**
             *  Vendor Bussiness Profile Brand Icon
             */
            add_action( 'wp_ajax_vendor_bussiness_profile_brand_media',  function(){ 
                self:: media_files( esc_html( 'vendor_bussiness_profile_brand_upload_files' ) ); 
            } );
            add_action( 'wp_ajax_nopriv_vendor_bussiness_profile_brand_media', function(){ 
                self:: media_files( esc_html( 'vendor_bussiness_profile_brand_upload_files' ) ); 
            } );

            /**
             *  Bride Profile Upload
             */
            add_action( 'wp_ajax_bride_media_action',  function(){ 
                self:: media_files( esc_html( 'bride_media_upload_files' ) ); 
            } );
            add_action( 'wp_ajax_nopriv_bride_media_action', function(){ 
                self:: media_files( esc_html( 'bride_media_upload_files' ) ); 
            } );

            /**
             *  Bride Profile Upload
             */
            add_action( 'wp_ajax_groom_media_action',  function(){ 
                self:: media_files( esc_html( 'groom_media_upload_files' ) ); 
            } );
            add_action( 'wp_ajax_nopriv_groom_media_action', function(){ 
                self:: media_files( esc_html( 'groom_media_upload_files' ) ); 
            } );
        }

        public static function WeddingCity_Upload_File_Delete(){

            wp_delete_attachment( absint( $_POST['attach_id'] ), true );

            die( json_encode( array( 

                    'message'=> sprintf( 'Delted media id is -> %1$s', $_POST['attach_id'] )
            ) ) );
        }

        public static function weddingcity_media_objects(){

            return array(

                'Gallery_Upload_Object'

                =>  array(

                        // 0 - $title
                        esc_html( 'Gallery' ),

                        // 1 - $button
                        esc_html( 'gallery_upload_browse_button' ),

                        // 2 - $container
                        esc_html( 'gallery_upload_container' ),

                        // 3 - $files
                        esc_html( 'Media_Upload_Gallery_Files' ),

                        // 4 - $action
                        esc_html( 'WeddingCity_Gallery_Media' ),

                        // 5 - image size & width action
                        array(),

                        // 6 - Upload Process Error & Success ID
                        esc_attr( 'gallery_upload_process_content' ),

                        // 7 - Image Preview Id
                        esc_attr( 'gallery_image_list' ),

                        // 8 - parent id
                        esc_attr( 'wc_gallery_upload' )
                    ),

                'Vendor_Business_Gallery'

                =>  array(

                        // 0 - $title
                        esc_html( 'Vendor Business Gallery' ),

                        // 1 - $button
                        esc_html( 'vendor_bussiness_gallery_upload_browse_button' ),

                        // 2 - $container
                        esc_html( 'vendor_bussiness_gallery_upload_container' ),

                        // 3 - $files
                        esc_html( 'vendor_bussiness_media_upload_gallery_files' ),

                        // 4 - $action
                        esc_html( 'vendor_bussiness_gallery_media' ),

                        // 5 - image size & width action
                        array(

                            'resize' => array(

                                'width'     => absint( '800' ),
                                'height'    => absint( '800' ),
                                'crop'      => true,
                            )
                        ),

                        // 6 - Upload Process Error & Success ID
                        esc_attr( 'vendor_bussiness_gallery_upload_process_content' ),

                        // 7 - Image Preview Id
                        esc_attr( 'vendor_bussiness_gallery_image_list' ),

                        // 8 - parent id
                        esc_attr( 'wc_vendor_gallery_upload' )
                    ),

                'Profile_Upload_Object'     

                =>  array( 

                        // 0 - $title
                        esc_html( 'Profile' ),

                        // 1 - $button
                        esc_html( 'profile_upload_browse_button' ),

                        // 2 - $container
                        esc_html( 'profile_upload_container_area' ),

                        // 3 - $files
                        esc_html( 'Media_Upload_Profile_Files' ),

                        // 4 - $action
                        esc_html( 'WeddingCity_Profile_Media' ),

                        // 5 - image size & width action
                        array(

                            'resize' => array(

                                'width'     => absint( '100' ),
                                'height'    => absint( '100' ),
                                'crop'      => true,
                            )
                        ),

                        // 6 - Upload Process Error & Success ID
                        esc_attr( 'profile_upload_process_content' ),

                        // 7 - Image Preview Id
                        esc_attr( 'user-profile-image-preview-container' ),

                        // 8 - parent id
                        esc_attr( 'wc_profile_upload' )
                    ),

                'Featured_Image_Object'     

                =>  array(

                        // 0 - $title
                        esc_html( 'Featured_Image' ),

                        // 1 - $button
                        esc_html( 'featured_image_upload_browse_button' ),

                        // 2 - $container
                        esc_html( 'Featured_Image_Upload_Container' ),

                        // 3 - $files
                        esc_html( 'Featured_Image_Upload_Files' ),

                        // 4 - $action
                        esc_html( 'WeddingCity_Featured_Image_Media' ),

                        // 5 - image size & width action
                        array(

                            'resize' => array(

                                'width'     => absint( '1900' ),
                                'height'    => absint( '520' ),
                                'crop'      => true,
                            )
                        ),

                        // 6 - Upload Process Error & Success ID
                        esc_attr( 'featured_image_upload_process_content' ),

                        // 7 - Image Preview Id
                        esc_attr( 'featured_image_preview' ),

                        // 8 - parent id
                        esc_attr( 'wc_featured_upload' )
                    ),

                'RealWedding_Featured_Image_Object'

                =>  array(

                        // 0 - $title
                        esc_html( 'realwedding_featured_Image' ),

                        // 1 - $button
                        esc_html( 'realwedding_featured_image_upload_browse_button' ),

                        // 2 - $container
                        esc_html( 'realwedding_featured_image_upload_container' ),

                        // 3 - $files
                        esc_html( 'Realwedding_Featured_Image_Upload_Files' ),

                        // 4 - $action
                        esc_html( 'WeddingCity_Realwedding_Featured_Image_Media' ),

                        // 5 - image size & width action
                        array(

                            'resize' => array(

                                'width'     => absint( '1900' ),
                                'height'    => absint( '520' ),
                                'crop'      => true,
                            )
                        ),

                        // 6 - Upload Process Error & Success ID
                        esc_attr( 'realwedding_featured_image_upload_process_content' ),

                        // 7 - Image Preview Id
                        esc_attr( 'realwedding_featured_image_preview' ),

                        // 8 - parent id
                        esc_attr( 'wc_realwedding_featured_upload' )
                    ),


                'Vendor_Bussiness_Profile_Banner'

                =>  array(

                        // 0 - $title
                        esc_html( 'vendor_bussiness_profile_banner_image' ),

                        // 1 - $button
                        esc_html( 'vendor_bussiness_profile_banner_image_upload_browse_button' ),

                        // 2 - $container
                        esc_html( 'vendor_bussiness_profile_banner_image_upload_container' ),

                        // 3 - $files
                        esc_html( 'vendor_bussiness_profile_banner_upload_files' ),

                        // 4 - $action
                        esc_html( 'vendor_bussiness_profile_image_media' ),

                        // 5 - image size & width action
                        array(

                            'resize' => array(

                                'width'     => absint( '1900' ),
                                'height'    => absint( '310' ),
                                'crop'      => true,
                            )
                        ),

                        // 6 - Upload Process Error & Success ID
                        esc_attr( 'vendor_bussiness_image_banner_upload_process_content' ),

                        // 7 - Image Preview Id
                        esc_attr( 'vendor_business_banner_image_preview' ),

                        // 8 - parent id
                        esc_attr( 'wc_vendor_profile_banner_upload' )
                    ),

                'Vendor_Bussiness_Profile_Brand_Icon'

                =>  array(

                        // 0 - $title
                        esc_html( 'vendor_bussiness_profile_brand_image' ),

                        // 1 - $button
                        esc_html( 'vendor_bussiness_profile_brand_image_upload_browse_button' ),

                        // 2 - $container
                        esc_html( 'vendor_bussiness_profile_brand_image_upload_container' ),

                        // 3 - $files
                        esc_html( 'vendor_bussiness_profile_brand_upload_files' ),

                        // 4 - $action
                        esc_html( 'vendor_bussiness_profile_brand_media' ),

                        // 5 - image size & width action
                        array(

                            'resize' => array(

                                'width'     => absint( '140' ),
                                'height'    => absint( '140' ),
                                'crop'      => true,
                            )
                        ),

                        // 6 - Upload Process Error & Success ID
                        esc_attr( 'vendor_profile_brand_icon_process_content' ),

                        // 7 - Image Preview Id
                        esc_attr( 'vendor-profile-brand-image-preview-container' ),

                        // 8 - parent id
                        esc_attr( 'wc_vendor_business_brand_upload' )
                    ),


                'Bride_Profile_Upload_Object'

                =>  array( 

                        // 0 - $title
                        esc_html( 'Bride' ),

                        // 1 - $button
                        esc_html( 'bride_upload_button' ),

                        // 2 - $container
                        esc_html( 'bride_upload_container' ),

                        // 3 - $files
                        esc_html( 'bride_media_upload_files' ),

                        // 4 - $action
                        esc_html( 'bride_media_action' ),

                        // 5 - image size & width action
                        array(

                            'resize' => array(

                                'width'     => absint( '250' ),
                                'height'    => absint( '250' ),
                                'crop'      => true,
                            )
                        ),

                        // 6 - Upload Process Error & Success ID
                        esc_attr( 'bride_upload_process' ),

                        // 7 - Image Preview Id
                        esc_attr( 'bride_profile_image' ),

                        // 8 - parent id
                        esc_attr( 'wc_bride_upload' )
                    ),

                'Groom_Profile_Upload_Object'

                =>  array( 

                        // 0 - $title
                        esc_html( 'Groom' ),

                        // 1 - $button
                        esc_html( 'groom_upload_button' ),

                        // 2 - $container
                        esc_html( 'groom_upload_container' ),

                        // 3 - $files
                        esc_html( 'groom_media_upload_files' ),

                        // 4 - $action
                        esc_html( 'groom_media_action' ),

                        // 5 - image size & width action
                        array(

                            'resize' => array(

                                'width'     => absint( '250' ),
                                'height'    => absint( '250' ),
                                'crop'      => true,
                            )
                        ),

                        // 6 - Upload Process Error & Success ID
                        esc_attr( 'groom_upload_process' ),

                        // 7 - Image Preview Id
                        esc_attr( 'groom_profile_image' ),

                        // 8 - parent id
                        esc_attr( 'wc_groom_upload' )
                    ),
            );
        }

        public static function WeddingCity_Upload_File_AJAX_Script(){

            global $page, $post, $wp_query;

            if( isset( $_GET['dashboard'] ) && !empty( $_GET['dashboard'] ) &&

                    ( 
                        $_GET['dashboard'] == 'add-listing' || $_GET['dashboard'] == 'update-listing' ||
                        $_GET['dashboard'] == 'vendor-profile' || $_GET['dashboard'] == 'couple-profile' ||
                        $_GET['dashboard'] == 'wedding-website' || $_GET['dashboard'] == 'real-wedding' || 
                        $_GET['dashboard'] == 'couple-profile'
                    ) 
            ){

                // @ref : https://github.com/rajeshtandukar/wordpress-ajax-upload

                // plupload jQuery

                wp_register_script('WeddingCity_Media_AJAX',

                        esc_url( plugin_dir_url( __FILE__ ).'script.js' ),

                            array( 'jquery', 'plupload-handlers' ), WEDDINGCITY_PLUGIN_VERSION, true
                );

                wp_enqueue_script(  'WeddingCity_Media_AJAX' );

                foreach ( self:: weddingcity_media_objects() as $key => $value) {
                
                    wp_localize_script( 'WeddingCity_Media_AJAX', $key, 

                        self:: media_upload(

                            $value[0],
                            $value[1],
                            $value[2],
                            $value[3],
                            $value[4],
                            $value[5]
                        )
                    );
                }
            }
        }

        public static function media_upload( $title, $button, $container, $files, $action, $_get_file_size ){

            return

            array(  'ajaxurl'           =>  admin_url( 'admin-ajax.php' ),
                    'nonce'             =>  wp_create_nonce( sprintf( '%1$s_upload', esc_html( $title ) ) ),
                    'remove'            =>  wp_create_nonce( sprintf( '%1$s_remove', esc_html( $title ) ) ),
                    'number'            =>  1,
                    'upload_enabled'    =>  true,
                    'path'              =>  esc_url( get_template_directory_uri() ),
                    'confirmMsg'        =>  esc_html__('Are you sure you want to delete this?','weddingcity'),
                    'plupload'          =>  array_merge( array(

                                                'runtimes'          => 'html5,flash,html4',
                                                'browse_button'     => esc_html( $button ),
                                                'container'         => esc_html( $container ),
                                                'file_data_name'    => esc_html( $files ),
                                                'max_file_size'     => '4mb',

                                                'url'               =>  sprintf( '%1$s?action=%2$s&nonce=%3$s',

                                                                            // 1
                                                                            admin_url( 'admin-ajax.php' ),

                                                                            // 2
                                                                            esc_html( $action ),

                                                                            // 3
                                                                            wp_create_nonce( $button )
                                                                        ),

                                                'flash_swf_url'         => includes_url('js/plupload/plupload.flash.swf'),

                                                'silverlight_xap_url'   => includes_url('js/plupload/plupload.silverlight.xap'),

                                                'filters'               => array(   array(  

                                                                                'title'         =>  esc_html__( 'Allowed Files','weddingcity' ),

                                                                                'extensions'    =>  "jpeg,jpg,gif,png"

                                                                            )   ),

                                                'multipart'             => true,

                                                'urlstream_upload'      => true,

                                            ),   $_get_file_size )
            );
        }

        public static function media_files( $args ){

            $file = array(
                'name'      => $_FILES[ $args ]['name'],
                'type'      => $_FILES[ $args ]['type'],
                'tmp_name'  => $_FILES[ $args ]['tmp_name'],
                'error'     => $_FILES[ $args ]['error'],
                'size'      => $_FILES[ $args ]['size']
            );

            $file = self:: media_upload_process( $file );
        }

        public static function media_upload_process( $file ){

            $attachment = self:: media_request($file);

            if ( is_array( $attachment ) ) {

                $response = array(

                    'success'   => true,
                    'html'      => wp_get_attachment_url( $attachment['id'] ),
                    'attach'    => $attachment['id']
                );

                print json_encode( $response );
                exit;
            }

            $response = array('success' => false);

            print json_encode( $response );

            exit;
        }

        public static function media_request( $upload_data ){

            $return = false;

            $uploaded_file = wp_handle_upload( $upload_data, array('test_form' => false) );

            if ( isset( $uploaded_file['file'] ) ) {

                $file_loc       =   $uploaded_file['file'];

                $file_name      =   basename( $upload_data['name'] );

                $file_type      =   wp_check_filetype( $file_name );

                $attachment = array(

                    'post_mime_type'    => $file_type['type'],
                    'post_title'        => preg_replace('/\.[^.]+$/', '', basename($file_name)),
                    'post_content'      => '',
                    'post_status'       => 'inherit'
                );

                $attach_id      =   wp_insert_attachment($attachment, $file_loc);
                $attach_data    =   wp_generate_attachment_metadata($attach_id, $file_loc);

                wp_update_attachment_metadata($attach_id, $attach_data);

                $return = array( 'data' => $attach_data, 'id' => $attach_id);

                return $return;
            }

            return $return;
        }

        public static function media_object_args_pass( $_key ){

            if( empty( $_key ) )
                return;

            foreach ( self:: weddingcity_media_objects() as $key => $value) {

                if( $key == $_key ){

                    return $value;
                }
            }
        }

        /**
         *  Gallery Upload
         */
        public static function weddingcity_multiple_media_upload( $_objects, $image_id ){

            if( empty( $_objects ) )
                return;

            $_args      =   self:: media_object_args_pass( $_objects );

            return  

            sprintf(    '<div id="%11$s" data-upload-limit="%12$s" data-media-show="%10$s">

                            <div id="upload-container" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group" id="%1$s">
                                   <input id="%3$s" name="%2$s" class="browse_button btn btn-primary btn-block" type="file">
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div id="%10$s" data-attached_id="%5$s" class="row">%8$s</div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 display_error_div" id="%9$s"></div>

                        </div>',

                        // 1
                        esc_attr( $_args[ absint( '2' ) ] ),

                        // 2
                        esc_attr( 'filebutton' ),

                        // 3
                        esc_attr( $_args[ absint( '1' ) ] ),

                        // 4
                        esc_attr( 'vendor_gallery' ),

                        // 5
                        esc_html( $image_id ),
                        
                        // 6
                        esc_attr( 'attachthumb' ),

                        // 7
                        absint( $thumbid ),
                        
                        // 8
                        self:: gallery_thumb( $image_id ),

                        // 9 - process content
                        esc_attr( $_args[ absint( '6' ) ] ),

                        // 10 - Image display id
                        esc_attr( $_args[ absint( '7' ) ] ),

                        // 11 - parent id
                        esc_attr( $_args[ absint( '8' ) ] ),

                        // 12 - upload limit
                        esc_attr( 'multiple' )
            );
        }

        public static function weddingcity_multiple_media_upload_e( $_objects, $image_id ){

            echo self:: weddingcity_multiple_media_upload( $_objects, $image_id );
        }

        /**
         * [featured_image_e description]
         * @param  [type] $image_id  [description]
         * @param  [type] $image_src [description]
         * @param  [type] $btn_label [description]
         * @return [type]            [description]
         */
        public static function weddingcity_single_media_upload_e( $_object, $image_id, $image_src, $btn_label ){

            if( empty( $_object ) )
                return;

            echo self:: weddingcity_single_media_upload( $_object, $image_id, $image_src, $btn_label );
        }

        public static function weddingcity_single_media_upload( $_object, $image_id, $image_src, $btn_label ){

            if( empty( $_object ) )
                return;

            $_args      =   self:: media_object_args_pass( $_object );

            return

            sprintf('   <div id="%9$s" data-upload-limit="%10$s">

                            <div id="%1$s" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                                <div id="%7$s">
                                    <img class="image-preview" data-attached_id="%5$s" src="%6$s">
                                </div>

                                <div class="display_error_div" id="%4$s"></div>

                                <label for="%2$s" id="%2$s" class="browse_button custom-label mt-3">%3$s</label>

                            </div>

                        </div>',

                        // 1
                        esc_html( $_args[ absint( '2' ) ] ),

                        // 2
                        esc_attr( $_args[ absint( '1' ) ] ),

                        // 3
                        esc_html( $btn_label ),

                        // 4 - process error - success msg show
                        esc_attr( $_args[ absint( '6' ) ] ),

                        // 5
                        absint( $image_id ),

                        // 6
                        $image_src,

                        // 7 - image preview id
                        esc_attr( $_args[ absint( '7' ) ] ),

                        // 8 - object
                        esc_attr( $_object ),

                        // 9 - parent id
                        esc_attr( $_args[ absint( '8' ) ] ),

                        // 10 - upload limit
                        esc_attr( 'single' )
            );
        }


        /**
         *  Default Thumbs
         */
        public static function gallery_thumb( $vendor_gallery ){

            $string = '';

            if ($vendor_gallery != '') {

                    foreach (explode(',', $vendor_gallery) as $key) {

                        if (isset($key) && $key != '') {

                            $string .=

                            sprintf('   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                                              <div class="gallery-upload-img">
                                                <img src="%1$s" data-image-id="%2$s" class="img-fluid">
                                                <span class="delete-gallery-img"><i class="fa  fa-times-circle" data-image-id="%2$s"></i></span>
                                            </div>
                                        </div>',

                                // 1
                                wp_get_attachment_url($key), 

                                // 2
                                $key

                            );
                        }
                    }

            } else {

                for ( $i = absint( '0' ); $i <= absint( '5' ); $i++ ) {

                    $string .=
                    
                    sprintf('   <div class="default-vendor-gallery col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                                        <div class="gallery-upload-img">
                                            <img src="%1$s" alt="%2$s" class="img-fluid">
                                            <span class="delete-gallery-img"><i class="fa fa-times-circle"></i></span>
                                        </div>
                                    </div>',

                            // 1
                            esc_url( WEDDINGCITY_THEME_DIR . 'images/gallery-thumb.jpg' ),

                            // 2
                            get_option('blogname')
                    );
                }
            }

            return $string;
        }

    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Media_Upload::get_instance();
}