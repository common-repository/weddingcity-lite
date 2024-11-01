<?php

/**
 *  WeddingCity Email Builder
 */

if( ! class_exists( 'WeddingCity_Update_Listing' ) && class_exists( 'WeddingCity_Form_Fields' ) ){

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Update_Listing extends WeddingCity_Form_Fields{

        /**
         * Member Variable
         *
         * @var instance
         */
        private static $instance;

        /**
         *  @var post_id
         */
        public static $_listing_post_id = '';

        /**
         *  @var the_post
         */
        public static $the_post = '';

        /**
         *  Initiator
         */
        public static function get_instance() {
          
            if ( ! isset( self::$instance ) ) {
              self::$instance = new self;
            }
            return self::$instance;
        }

        public static function post_id(){

            return absint( $_GET['listing_id'] );
        }

        public static function user_id(){

            return WeddingCity_User_Meta:: user_post_id();
        }

        public function __construct() {

            do_action( 'weddingcity_texonomy' );

            add_action( 'weddingcity_update_listing', array( $this, 'weddingcity_update_listing_markup' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'weddingcity_update_listing_script' ) );

            add_action( 'wp_ajax_weddingcity_update_listing_action',  array( $this, 'weddingcity_update_listing_action' ) );

            add_action( 'wp_ajax_nopriv_weddingcity_update_listing_action', array( $this, 'weddingcity_update_listing_action' ) );

            self:: weddingcity_dashboard_menu();
        }

        public static function weddingcity_dashboard_menu(){

            add_filter( 'weddingcity_vendor_dashboard_menu',

                function ( $args ){

                    return array_merge( $args, array(

                            'update_listing'   => array(

                                'menu_show'     =>  false,

                                'menu_name'     =>  esc_html__( 'Update Listing', 'weddingcity' ),

                                'menu_icon'     =>  'fas fa-list-alt',

                                'menu_active'   =>  ( $_REQUEST['dashboard'] == 'update-listing' )

                                                    ? esc_html( 'active' ) : '',

                                'menu_link'     =>  esc_url(

                                                        add_query_arg( array(

                                                            'dashboard' => esc_html( 'update-listing' )

                                                        ), WeddingCity_Template:: vendor_dashboard_template() )
                                                    ),
                            ),
                    )  );
                },

                absint( '20' )
            );
        }

        public static function weddingcity_update_listing_script(){

            if( isset( $_GET['dashboard'] ) && !empty( $_GET['dashboard'] ) && $_GET['dashboard'] == 'update-listing' ){

                wp_enqueue_style( sanitize_title( get_class($this) ), plugin_dir_url( __FILE__ ).'style.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

                wp_enqueue_script( sanitize_title( get_class($this) ), plugin_dir_url( __FILE__ ).'script.js', array( 'jquery', 'summernote', 'google-map' ), WEDDINGCITY_PLUGIN_VERSION, true );
            }
        }

        public static function weddingcity_lisitng_post_status(){

            $_status_option = weddingcity_option( 'new_listing_status' );

            if( $_status_option == absint( '0' ) ){

                return esc_html( 'pending' );

            }elseif( $_status_option == absint( '1' ) ){

                return esc_html( 'publish' );
                
            }else{

                return esc_html( 'publish' );
            }
        }

        public static function weddingcity_update_listing_action(){

            $user_id                    =   WeddingCity_User_Meta:: user_post_id();

            $post_title                 =   $_POST['post_title'];

            $post_content               =   wp_filter_post_kses( $_POST['post_content'] );
            
            check_ajax_referer( 'vendor_update_listing', 'security' );

            $arr = array();

            if( isset( $_POST['venue_amenities'] ) && ! empty( $_POST['venue_amenities'] ) ){

                foreach( $_POST['venue_amenities'] as $key => $value ){

                        $arr[ $key ] = $value;
                }               
            }

            $post = array(
                
                    'post_author'       =>   WeddingCity_User_Meta:: user_id(),
                    'post_name'         =>   $post_title,
                    'post_title'        =>   $post_title,
                    'post_content'      =>   $post_content,
                    'post_status'       =>   esc_html( self:: weddingcity_lisitng_post_status() ),
                    'post_type'         =>   'listing'
            );

            $my_udate_meta_array = array(

                'venue_address'             =>  esc_html( $_POST['venue_address'] ),
                'venue_latitude'            =>  esc_html( $_POST['venue_latitude'] ),
                'venue_longitude'           =>  esc_html( $_POST['venue_longitude'] ),
                'venue_map_address'         =>  esc_html( $_POST['venue_map_address'] ),
                'venue_video'               =>  esc_url( $_POST['venue_video'] ),
                'vendor_featured_image'     =>  esc_url( $_POST['vendor_featured_image'] ),
                'vendor_gallery'            =>  esc_html( $_POST['vendor_gallery'] ),
                'listing_category'          =>  absint( $_POST[ 'listing_category' ] ),
                'seat_capacity'             =>  absint( $_POST['seat_capacity'] ),
                'venue_price'               =>  absint( $_POST['venue_price'] ),                
                'vendor_featured_id'        =>  absint( $_POST['vendor_featured_id'] ),
                'venue_country'             =>  absint( $_POST['venue_country'] ),
                'venue_state'               =>  absint( $_POST['venue_state'] ),
                'venue_city'                =>  absint( $_POST['venue_city'] ),
                'listing_vendor'            =>  absint( $user_id ),
                'venue_amenities'           =>  $arr,
            );

            if( $_POST['vendor_post_update'] != '' ){
                
                    $_listing_post_id =  absint( $_POST['vendor_post_update'] );
            }else{
                    $_listing_post_id =  wp_insert_post( $post );
            }


            if( isset( $_listing_post_id ) && $_listing_post_id != '' ){

                $post_is_updated = wp_update_post( array(

                    'post_title'        =>  $_POST['post_title'], 
                    'post_content'      =>  $post_content,
                    'ID'                =>  $_listing_post_id,

                ), true );

                                          
                if ( is_wp_error( $post_is_updated ) ) {

                    $errors = $_listing_post_id->get_error_messages();

                    foreach ($errors as $error) {

                        die( json_encode( array(
                            
                                'redirect'  =>  false, 

                                'message'   =>  WeddingCity_Alert:: danger(

                                                    $error
                                                )
                        ) ) );
                    }

                }else{

                    set_post_thumbnail( absint( $_listing_post_id ), absint( $_POST['vendor_featured_id'] ) );

                    wp_set_post_terms( absint( $_listing_post_id ), array( absint( $_POST['listing_category'] ) ), WeddingCity_Texonomy:: listing_category_taxonomy() );

                    wp_set_post_terms(

                        absint( $_listing_post_id ), 

                            array( 

                                absint( $_POST['venue_country'] ),
                                absint( $_POST['venue_state'] ),
                                absint( $_POST['venue_city'] )
                            ), 

                        WeddingCity_Texonomy:: listing_location_taxonomy(), false

                    );

                    foreach( $my_udate_meta_array as $key => $value ){
                        
                        update_post_meta( $_listing_post_id, $key, $value );
                    }

                    if( $_POST[ 'featured_listing' ] == 'on' ){

                        $_capacity_featured_listing = absint( get_post_meta( $user_id, 'capacity_featured_listing', true ) );
                        $_number_of_featured_listing = absint( get_post_meta( $user_id, 'number_of_featured_listing', true ) );

                        if( $_capacity_featured_listing > absint( '0' ) && $_capacity_featured_listing > $_number_of_featured_listing ){

                            $number_of_listing =  absint( get_post_meta( $user_id, 'number_of_featured_listing', true ) );
                            update_post_meta( $user_id, 'number_of_featured_listing', absint( $number_of_listing + absint('1') ) );
                            update_post_meta( $_listing_post_id, 'is_featured_listing', esc_html( $_POST[ 'featured_listing' ] ) );
                        }
                    }

                    if( $_POST[ 'featured_listing' ] == 'off' ){

                        $_capacity_featured_listing = absint( get_post_meta( $user_id, 'capacity_featured_listing', true ) );
                        $_number_of_featured_listing = absint( get_post_meta( $user_id, 'number_of_featured_listing', true ) );

                        if( $_capacity_featured_listing > absint( '0' ) && $_capacity_featured_listing >= $_number_of_featured_listing ){

                            $number_of_listing =  absint( get_post_meta( $user_id, 'number_of_featured_listing', true ) );
                            update_post_meta( $user_id, 'number_of_featured_listing', absint( $number_of_listing - absint('1' ) ) );
                            update_post_meta( $_listing_post_id, 'is_featured_listing', esc_html( $_POST[ 'featured_listing' ] ) );
                        }
                    }

                    if( isset( $_POST[ 'vendor_edit_listing' ] ) ){

                        die( json_encode( array( 

                            'redirect'          =>  true, 

                            'redirect_link'     =>  WeddingCity_Vendor_Menu:: page_link( absint( '1' ) ),

                            'message'           =>  WeddingCity_Alert:: success(

                                                        esc_html__('Your Listing is Updated.','weddingcity')
                                                    )
                        ) ) );

                    }else{

                        $number_of_listing =  absint( get_post_meta( $user_id, 'total_listing', true ) );
                        update_post_meta( $user_id, 'total_listing', $number_of_listing + absint('1') );

                        if( $_POST[ 'featured_listing' ] == 'on' ){

                            $_capacity_featured_listing = absint( get_post_meta( $user_id, 'capacity_featured_listing', true ) );
                            $_number_of_featured_listing = absint( get_post_meta( $user_id, 'number_of_featured_listing', true ) );

                            if( $_capacity_featured_listing > absint( '0' ) && $_capacity_featured_listing > $_number_of_featured_listing ){

                                $number_of_listing =  absint( get_post_meta( $user_id, 'number_of_featured_listing', true ) );
                                update_post_meta( $user_id, 'number_of_featured_listing', absint( $number_of_listing + absint('1') ) );
                                update_post_meta( $_listing_post_id, 'featured_listing', esc_html( $_POST[ 'featured_listing' ] ) );
                            }
                        }

                        if( $_POST[ 'featured_listing' ] == 'off' ){

                            $_capacity_featured_listing = absint( get_post_meta( $user_id, 'capacity_featured_listing', true ) );
                            $_number_of_featured_listing = absint( get_post_meta( $user_id, 'number_of_featured_listing', true ) );

                            if( $_capacity_featured_listing > absint( '0' ) && $_capacity_featured_listing > $_number_of_featured_listing ){

                                $number_of_listing =  absint( get_post_meta( $user_id, 'number_of_featured_listing', true ) );
                                update_post_meta( $user_id, 'number_of_featured_listing', absint( $number_of_listing - absint('1' ) ) );
                                update_post_meta( $_listing_post_id, 'featured_listing', esc_html( $_POST[ 'featured_listing' ] ) );
                            }
                        }

                        die( json_encode( array( 

                            'redirect'          =>  true,

                            'redirect_link'     =>  WeddingCity_Vendor_Menu:: vendor_listing_link(),

                            'message'           =>  WeddingCity_Alert:: success(

                                                        esc_html__('Your Listing is Added.','weddingcity')
                                                    )
                        ) ) );
                    }

                }

            }else{

                die( json_encode( array( 

                    'redirect'  =>  false, 

                    'message'   =>  WeddingCity_Alert:: danger(

                                        esc_html__('Your Listing is Not Added.','weddingcity')
                                    )
                ) ) );
            }
        }

        /**
         * [page_title description]
         * @return [ Page Title ]
         */
        public static function page_title(){

            return esc_html__( 'Update Listing', 'weddingcity' );
        }

        public static function page_description(){

            return esc_html__( 'Update your business listing with under list category, title, descriptions, google map, gallery and featured image, etc..', 'weddingcity' );
        }

        public static function weddingcity_update_listing_page_title_markup(){

            WeddingCity_Dashboard:: dashboard_page_header(

                    // 1
                    self:: page_title(),

                    // 2
                    self:: page_description()
            );
        }

        public static function weddingcity_update_listing_markup(){

            self:: weddingcity_update_listing_page_title_markup();

            if( WeddingCity_Loader:: array_condition( self:: get_list_of_tabs() ) ){

                parent:: display_card_section_with_content( self:: get_list_of_tabs() );
            }
        }

        public static function get_list_of_tabs(){

            $_list      =   array();

            $_list[]    =   array(

                'class'         =>  __CLASS__,
                'function'      => 'weddingcity_update_listing_body_content',
                'tab_name'      =>  '',
                'active'        =>  true,
                'form_id'       => 'vendor-update-listing',
                'form_top'      =>  '',
                'form_bottom'   =>  sprintf( '<input type="hidden" id="vendor_post_update" value="%1$s">', absint( self:: post_id() ) ),
                'btn_id'        =>  'vendor_update_listing_btn',
                'btn_name'      =>  esc_html__( 'Update Listing', 'weddingcity' ),
                'nonce'         =>  'vendor_update_listing, vendor_edit_listing',
            );

            return $_list;
        }

        public static function weddingcity_update_listing_body_content(){

            global $current_user, $post, $wp_query;

            $_listing_post_id    =  absint( $_GET['listing_id'] );

            $the_post   =  get_post( $_listing_post_id );

            if ( $current_user->ID != $the_post->post_author ) {
                
                parent:: weddingcity_dashboard_section_info( array(

                    'grid'              =>  absint( '12' ),

                    'lable'             =>  esc_html__( 'You don\'t have the rights to edit this Listing.', 'weddingcity' ),
                ) );

                exit();
            }

            if ( isset( $_GET['listing_id'] ) && absint( $_GET['listing_id'] ) ) {

                self:: weddingcity_update_listing_form_content();
            }
        }

        public static function weddingcity_update_listing_form_content(){

            /**
             *  Section Info
             */
            parent:: weddingcity_dashboard_section_info( array(

                'grid'              =>  absint( '12' ),

                'lable'             =>  esc_html__( 'Listing Category', 'weddingcity' ),

                'border_top'        =>  false,

                'group_end'         =>  false
            ) );

            /**
             *  Listing Categories
             */
            parent:: weddingcity_dashboard_section_select( array(

                'grid'              =>  absint( '12' ),

                'lable'             =>  esc_html__( 'Listing Category', 'weddingcity' ),

                'name'              =>  WeddingCity_Listing_Meta:: listing_category_meta_name(),

                'options'           =>  WeddingCity_Texonomy:: get_vendors_list(  

                                            WeddingCity_Listing_Meta:: listing_category( self:: post_id() ), 

                                            array( '0' => esc_html__( 'Select Category', 'weddingcity' ) ) 
                                        ),

                'border_top'        =>  false,

                'group_start'       =>  false

            ) );

            /**
             *  Section Info
             */
            parent:: weddingcity_dashboard_section_info( array(

                'grid'              =>  absint( '12' ),

                'lable'             =>  esc_html__( 'Listing Info', 'weddingcity' ),

                'group_end'         =>  false
            ) );

            /**
             *  title
             */
            parent:: weddingcity_dashboard_section_text( array(

                'lable'             =>  esc_attr__( 'Title', 'weddingcity' ),

                'placeholder'       =>  esc_attr__( 'Title', 'weddingcity' ),

                'name'              =>  esc_attr( 'post_title' ),

                'value'             =>  get_the_title( self:: post_id() ),

                'group_end'         =>  false,

                'border_top'        =>  false,

                'group_start'       =>  false
            ) );

            /**
             *  Price
             */
            parent:: weddingcity_dashboard_section_number( array(

                  'lable'             =>  esc_attr__( 'Price', 'weddingcity' ),

                  'placeholder'       =>  esc_attr__( 'Price', 'weddingcity' ),

                  'name'              =>  WeddingCity_Listing_Meta:: listing_price_meta_name(),

                  'value'             =>  WeddingCity_Listing_Meta:: listing_price( self:: post_id() ),

                  'group_start'       =>   false,

                  'border_top'        =>   false,

                  'group_end'         =>   false
            ) );

            /**
             *  Address
             */
            parent:: weddingcity_dashboard_section_text( array(

                  'lable'             =>  esc_attr__( 'Address', 'weddingcity' ),

                  'placeholder'       =>  esc_attr__( 'Street address', 'weddingcity' ),

                  'name'              =>  WeddingCity_Listing_Meta:: listing_address_meta_name(),

                  'value'             =>  WeddingCity_Listing_Meta:: listing_address( self:: post_id() ),

                  'group_start'       =>   false,

                  'border_top'        =>   false,

                  'group_end'         =>   false
            ) );

            /**  country  */
            parent:: weddingcity_dashboard_section_select( array(

                    'lable'             =>  esc_html__( 'Select Country', 'weddingcity' ),

                    'name'              =>  WeddingCity_Listing_Meta:: listing_country_meta_name(),

                    'options'           =>  WeddingCity_Texonomy:: get_location_list(

                                                WeddingCity_Texonomy:: listing_location_taxonomy(),

                                                WeddingCity_Listing_Meta:: listing_country( self:: post_id() ), 

                                                array( '0' => esc_html__( 'Select Country', 'weddingcity' ) )
                                            ),

                    'group_start'       =>   false,

                    'border_top'        =>   false,

                    'group_end'         =>   false,

                    'data_taxonomy'     =>  WeddingCity_Texonomy:: listing_location_taxonomy(),

                    'class'             =>  sanitize_html_class( '_country_taxonomy_' )
            ) );

            /**
             * state
             */
            parent:: weddingcity_dashboard_section_select( array(

                  'lable'             =>    esc_html__( 'Select State', 'weddingcity' ),

                  'name'              =>    WeddingCity_Listing_Meta:: listing_state_meta_name(),

                  'options'           =>    WeddingCity_Texonomy:: create_select_option(

                                                  $get_parents = WeddingCity_Texonomy:: get_texonomy_child(

                                                                    WeddingCity_Texonomy:: listing_location_taxonomy(), 

                                                                    WeddingCity_Listing_Meta:: listing_country( self:: post_id() ) 
                                                                ),

                                                  $label = array('0' => esc_html__( 'Select State', 'weddingcity' ) ),

                                                  $default_select = WeddingCity_Listing_Meta:: listing_state( self:: post_id() )
                                            ),

                  'group_start'       =>   false,

                  'border_top'        =>   false,

                  'group_end'         =>   false,

                    'data_taxonomy'     =>  WeddingCity_Texonomy:: listing_location_taxonomy(),

                    'class'             =>  sanitize_html_class( '_state_taxonomy_' )
            ) );

            /**
             * City
             */
            parent:: weddingcity_dashboard_section_select( array(

                  'lable'             =>    esc_html__( 'Select City', 'weddingcity' ),

                  'name'              =>    WeddingCity_Listing_Meta:: listing_city_meta_name(),

                  'options'           =>    WeddingCity_Texonomy:: create_select_option(

                                                  $get_parents = WeddingCity_Texonomy:: get_texonomy_child(

                                                                    WeddingCity_Texonomy:: listing_location_taxonomy(), 

                                                                    WeddingCity_Listing_Meta:: listing_state( self:: post_id() )
                                                                ),

                                                  $label = array( '0' => esc_html__( 'City', 'weddingcity' ) ),

                                                  $default_select = WeddingCity_Listing_Meta:: listing_city( self:: post_id() )
                                            ),

                  'group_start'       =>   false,

                  'border_top'        =>   false,

                    'data_taxonomy'     =>  WeddingCity_Texonomy:: listing_location_taxonomy(),

                    'class'             =>  sanitize_html_class( '_city_taxonomy_' )
            ) );

            /**
             *  Section Info
             */
            parent:: weddingcity_dashboard_section_info( array(

                'grid'              =>  absint( '12' ),

                'lable'             =>  esc_html__( 'Write Descriptions for your Listing', 'weddingcity' ),

                'group_end'         =>  false
            ) );

            /**
             * Post_content
             */
            parent:: weddingcity_dashboard_section_textarea( array(

                  'lable'             =>  '',

                  'name'              =>  esc_html( 'post_content' ),

                  'value'             =>  get_post_field( 'post_content', self:: post_id() ),

                  'placeholder'       =>  esc_attr__( 'Descriptions', 'weddingcity' ),

                  'group_start'       =>  false,

                  'border_top'        =>  false
            ) );

            /**
             *  Section Info
             */
            parent:: weddingcity_dashboard_section_info( array(

                'grid'              =>  absint( '12' ),

                'lable'             =>  esc_html__( 'Location Map', 'weddingcity' ),

                'group_end'         =>  false
            ) );

            /**
             * Latitude
             */
            parent:: weddingcity_dashboard_section_text( array(

                'grid'              =>  absint( '6' ),

                'lable'             =>  esc_attr__( 'Latitude', 'weddingcity' ),

                'placeholder'       =>  esc_attr__( 'e.g. 23.0732195', 'weddingcity' ),

                'name'              =>  WeddingCity_Listing_Meta:: listing_latitude_meta_name(),

                'value'             =>  WeddingCity_Listing_Meta:: listing_latitude( self:: post_id() ),

                'class'             =>  sanitize_html_class( 'MapLat' ),

                'group_start'       =>  false,

                'group_end'         =>  false,

                'border_top'        =>  false,

            ) );

            /**
             * Longitude
             */
            parent:: weddingcity_dashboard_section_text( array(

                'grid'              =>  absint( '6' ),

                'lable'             =>  esc_attr__( 'Latitude', 'weddingcity' ),

                'placeholder'       =>  esc_attr__( 'e.g. 72.5646902', 'weddingcity' ),

                'name'              =>  WeddingCity_Listing_Meta:: listing_longitude_meta_name(),

                'value'             =>  WeddingCity_Listing_Meta:: listing_longitude( self:: post_id() ),

                'class'             =>  sanitize_html_class( 'MapLon' ),

                'group_start'       =>  false,

                'group_end'         =>  false,

                'border_top'        =>  false,
            ) );

            /**
             *  Google Map
             */
            parent:: weddingcity_map( array(

                'id'                =>  esc_attr( 'map_canvas' ),

                'group_start'       =>  false,

                'border_top'        =>  false,
            ) );

            /**
             *  Section Info
             */
            parent:: weddingcity_dashboard_section_info( array(

                'grid'              =>  absint( '12' ),

                'lable'             =>  esc_html__( 'Listing Featured Image', 'weddingcity' ),

                'group_end'         =>  false
            ) );


            /**
             *  Featured Image
             */
            parent:: weddingcity_single_image_upload( array(

                    'image_id'      => get_post_thumbnail_id( self:: post_id() ),

                    'image_src'     => get_the_post_thumbnail_url( self:: post_id(), 'full' ),

                    'btn_lable'     => esc_html__( 'Upload Image', 'weddingcity' ),

                    'group_start'   => false,

                    'border_top'    => false
            ) );

            parent:: weddingcity_featured_listing( array(

                    'post_id'       => absint( self:: post_id() ),
            ) );
        }
    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Update_Listing::get_instance();
}