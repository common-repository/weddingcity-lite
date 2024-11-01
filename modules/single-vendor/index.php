<?php

/**
 *  WeddingCity Vendor Single Page
 */

if( ! class_exists( 'WeddingCity_Vendor_Single' ) ){

    /**
     *  WeddingCity Listing Requests
     */
    class WeddingCity_Vendor_Single{

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

            add_action( 'weddingcity_vendor_single', array( $this, 'weddingcity_vendor_single_markup' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'weddingcity_vendor_single_scripts' ) );

            add_action( 'wp_ajax_weddingcity_vendor_singular_page_listing_inquiry',  array( $this, 'weddingcity_vendor_singular_page_listing_inquiry' ) );

            add_action( 'wp_ajax_nopriv_weddingcity_vendor_singular_page_listing_inquiry', array( $this, 'weddingcity_vendor_singular_page_listing_inquiry' ) );
        }

        public static function weddingcity_vendor_singular_page_listing_inquiry(){

            global $current_user, $post, $wp_query;
            
            check_ajax_referer( 'request_for_listing', 'security' );

            $new_request_list   = array();

            $_listing_post_id   = absint( $_POST['listing_post_id'] );

            $request_array      = array( array(

                  'title'             =>  sprintf( '%1$s %2$s',

                                                // 1
                                                $_POST['request_name'],

                                                // 2
                                                esc_html__(' Request for your Listing.', 'weddingcity' )
                                          ),

                  'request_name'      =>  $_POST['request_name'],

                  'request_email'     =>  $_POST['request_email'],

                  'request_phone'     =>  $_POST['request_phone'],

                  'weddingdate'       =>  $_POST['weddingdate'],

                  'request_comment'   =>  $_POST['request_comment']
            ) );

            $request_list_array   = get_post_meta( $_listing_post_id, 'listing_request', true );

            if( WeddingCity_Loader:: array_condition( $request_list_array ) ){

                  $new_request_list  =  array_merge_recursive( $request_list_array, $request_array );       

            }else{

                  $new_request_list  =  $request_array;
            }

            update_post_meta( $_listing_post_id, 'listing_request', $new_request_list );

            $autho_ID     = get_post( $_listing_post_id )->post_author;

            $post_id      = WeddingCity_User::author_info( $autho_ID, 'user_access_post_id' );

            $venue_requests =  absint( get_post_meta( $post_id, 'request_quote', true ) );

            update_post_meta( $post_id, 'request_quote', $venue_requests + absint('1') );

            die( json_encode( array(

              'redirect'    =>    false, 
              
              'message'     =>    WeddingCity_Alert:: success(

                                      esc_html__('Your Request Send Successfully!','weddingcity')
                                  )

            ) ) );
        }

        public static function weddingcity_vendor_single_scripts(){

            if( is_singular( 'vendor' ) ){

                wp_enqueue_style( 'weddingcity-vendor-singular-style', plugin_dir_url( __FILE__ ).'style.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

                wp_enqueue_script( 'weddingcity-vendor-singular-script', plugin_dir_url( __FILE__ ).'script.js', array( 'jquery', 'google-map' ), WEDDINGCITY_PLUGIN_VERSION, true );
            }
        }

        public static function weddingcity_vendor_single_markup(){

            get_header();

                self:: weddingcity_vendor_single_page_content();

            get_footer();
        }

        public static function weddingcity_vendor_single_page_content(){

            self:: weddingcity_vendor_single_page_banner();

            self:: weddingcity_vendor_single_page_details();

            self:: weddingcity_vendor_single_page_tabs();
        }

        public static function get_vendor_profile_banner(){

            $_banner = get_post_meta( get_the_ID(), WeddingCity_Vendor_Meta:: business_profile_user_banner_image_meta_name(), true );

            if( $_banner != '' ){

                return sprintf( 'style="background: url(%1$s) no-repeat center;"', esc_url( $_banner ) );

            }else{

                return esc_url( plugin_dir_url( __FILE__ ).'images/vendor-profile-banner.jpg' );
            }
        }

        public static function weddingcity_vendor_single_page_banner(){

            ?><div class="vendor-profile-pageheader" <?php echo self:: get_vendor_profile_banner(); ?>></div><?php
        }


        public static function get_vendor_profile_icon(){

            $_icon = get_post_meta( get_the_ID(), WeddingCity_Vendor_Meta:: business_profile_brand_image_meta_name(), true );

            if( $_icon != '' ){

                return esc_url( $_icon );

            }else{

                return esc_url( plugin_dir_url( __FILE__ ).'images/vendor-profile-img.jpg' );
            }
        }        

        public static function get_vendor_business_name(){

            return get_post_meta( get_the_ID(), WeddingCity_Vendor_Meta:: profile_business_name_meta_name()   , true );
        }

        public static function get_vendor_location(){

            return get_post_meta( get_the_ID(), WeddingCity_Vendor_Meta:: profile_user_address_meta_name()   , true );
        }

        public static function get_vendor_website(){

            $_website = get_post_meta( get_the_ID(), WeddingCity_Vendor_Meta:: profile_user_website_meta_name()   , true );

            return esc_url( $_website );
        }

        public static function weddingcity_vendor_single_page_details(){

            ?>
            <div class="vendor-profile-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                            <div class="vendor-profile-detail-img">
                                <img src="<?php echo self:: get_vendor_profile_icon(); ?>" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="vendor-profile-detail-text">
                                <h2 class="vendor-profile-detail-text-title"><?php echo self:: get_vendor_business_name(); ?></h2>
                                <p class="vendor-profile-detail-address"><?php echo self:: get_vendor_location(); ?></p>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-4 col-sm-12 col-12 text-right">
                            <a href="<?php echo self:: get_vendor_website(); ?>" target="_blank" class="btn btn-light"><?php esc_html_e( 'Website', 'weddingcity' ); ?></a>
                            <a href="javascript:" data-toggle="modal" data-target="#listing_vendro_request_model" class="btn btn-default d-none"><?php esc_html_e( 'Request A Quote', 'weddingcity' ); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php

            self:: weddingcity_vendor_request_quote();
        }

        public static function weddingcity_vendor_request_quote(){

            ?>
            <div class="modal fade" id="listing_vendro_request_model" tabindex="-1" role="dialog" aria-labelledby="listing_vendor_request_quote_model" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">

                        <form id="vendor_singular_page_booking_request" method="post" autocomplete="off">

                            <div class="modal-header">
                                <h5 class="modal-title" id="listing_vendor_request_quote_model"><?php esc_html_e( 'Request Quote', 'weddingcity' ); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>


                            <div class="modal-body"><?php self:: weddingcity_vendor_singular_request_quote_form_markup(); ?></div>

                            <div class="modal-footer">

                                <button type="button" id="request_quote_close_model" class="btn btn-secondary d-none" data-dismiss="modal"><?php esc_html_e( 'Close', 'weddingcity' ); ?></button>

                                <button type="submit" class="btn btn-default btn-block"><?php esc_html_e( 'Submit Quote', 'weddingcity' ) ?></button>

                                <?php wp_nonce_field( 'request_for_listing', 'request_for_listing' ); ?>

                            </div>

                        </form>

                    </div>
                </div>
            </div>
            <?php
        }

        public static function weddingcity_vendor_singular_request_quote_form_markup(){

          ?>
                <div class="row">

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <input id="<?php esc_attr_e( 'request_name' ); ?>" name="<?php esc_attr_e( 'request_name' ); ?>" type="text" 
                            placeholder="<?php esc_attr_e( 'Name', 'weddingcity' ); ?>" class="form-control input-md" required>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                           <input id="<?php esc_attr_e( 'request_email' ); ?>" name="<?php esc_attr_e( 'request_email' ); ?>" type="email"
                           placeholder="<?php esc_attr_e( 'Email', 'weddingcity' ) ?>" class="form-control input-md" required>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                           <input  id="<?php esc_attr_e( 'request_phone', 'weddingcity' ); ?>" name="<?php esc_attr_e( 'request_phone', 'weddingcity' ); ?>" type="number" 
                           placeholder="<?php esc_attr_e( 'Phone', 'weddingcity' ); ?>" class="form-control input-md" required>
                        </div>
                     </div>

                     <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                           <select id="listing_post_id" name="listing_post_id">
                                <?php

                                    $args = array( 

                                            'post_type'         => 'listing',

                                            'post_status'       =>  array( 'publish' ),

                                            'posts_per_page'    => -1,

                                            'orderby'           => 'menu_order ID',

                                            'order'             => 'post_date',

                                            'author'            =>  get_post_meta( get_the_ID(), 'user_id', true )
                                    );

                                    $item = new WP_Query( $args );

                                    if( $item->have_posts() ){

                                        while ( $item->have_posts() ){

                                            $item->the_post();

                                            printf( '<option value="%2$s">%1$s</option>', get_the_title(), get_the_ID() );

                                        }   wp_reset_postdata();              


                                    }else{

                                        printf( '<option value="%2$s">%1$s</option>', esc_html__( 'Post Not Found...' ), absint( '0' ) );
                                    }

                                ?>
                           </select>
                        </div>
                     </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                      <div class="form-group">
                          <input id="<?php esc_attr_e( 'weddingdate' ); ?>" name="<?php esc_attr_e( 'weddingdate' ); ?>" type="text" 
                          placeholder="<?php esc_attr_e( 'Wedding Date', 'weddingcity' ); ?>" 
                            class="form-control input-md wedding_date" reqired>
                          <div class="venue-form-calendar"><i class="far fa-calendar-alt"></i></div>
                      </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">

                            <textarea class="form-control" id="<?php esc_attr_e( 'request_comment' ); ?>"
                            name="<?php esc_attr_e( 'request_comment' ); ?>" rows="6" 
                            placeholder="<?php esc_attr_e( 'Write Comment', 'weddingcity' ); ?>" required></textarea>

                        </div>
                    </div>

                </div>

          <?php
        }

        public static function weddingcity_vendor_single_page_tabs(){

            self:: vendor_single_page_tab_before();

            self:: vendor_single_page_tab_markup();

            self:: vendor_single_page_tab_after();
        }

        public static function vendor_single_page_tab_before(){

            ?>
                <div class="vendor-profile-tabs">
                    <div class="container">
                        <?php
        }

        public static function vendor_single_page_tab_after(){

                        ?>
                    </div>
                </div>
            <?php
        }

        public static function get_list_of_tabs(){

            $_list      =   array();

            $_list[]    =   array(

                'tab_name'  =>  esc_html__( 'Listings', 'weddingcity' ),
                'active'    =>  true,
                'function'  => 'vendor_publish_number_of_listings',
                'print'     =>  false,
            );

            $_list[]    =   array(
                    
                'tab_name'  =>  esc_html__( 'About', 'weddingcity' ),
                'active'    =>  false,
                'function'  => 'vendor_profile_about_us',
                'print'     =>  true,
            );

            $_list[]    =   array(
                    
                'tab_name'  =>  esc_html__( 'Reviews', 'weddingcity' ),
                'active'    =>  false,
                'function'  => 'vendor_number_of_listing_reviews',
                'print'     =>  true,
            );

            $_list[]    =   array(
                    
                'tab_name'  =>  esc_html__( 'Location', 'weddingcity' ),
                'active'    =>  false,
                'function'  => 'vendor_bussiness_location',
                'print'     =>  true,
            );

            $_list[]    =   array(
                    
                'tab_name'  =>  esc_html__( 'Gallery', 'weddingcity' ),
                'active'    =>  false,
                'function'  => 'vendor_bussiness_gallery',
                'print'     =>  false,
            );

            $_list[]    =   array(
                    
                'tab_name'  =>  esc_html__( 'Video', 'weddingcity' ),
                'active'    =>  false,
                'function'  => 'vendor_bussiness_video',
                'print'     =>  false,
            );

            // $_list[]    =   array(
                    
            //     'tab_name'  =>  esc_html__( 'Availability', 'weddingcity' ),
            //     'active'    =>  false,
            //     'function'  => '_test_5',
            //     'print'     =>  true,
            // );

            return $_list;
        }

        public static function vendor_bussiness_gallery(){

            $_data  = get_post_meta( get_the_ID(), WeddingCity_Vendor_Meta:: business_gallery_meta_name(), true );

            if( empty( $_data ) ){
                return;
            }

            $_gallery_list  = explode( ',', $_data );
            
            if( WeddingCity_Loader:: array_condition( $_gallery_list ) ){

                ?>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                <?php

                                    foreach ( $_gallery_list as $key ) {

                                        printf( '   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">
                                                        <div class="gallery-img mb30"> 
                                                            <a href="%1$s" class="image-link" title="%2$s">
                                                                <img src="%1$s" alt="%2$s" class="img-fluid">
                                                            </a>
                                                        </div>
                                                    </div>',

                                                    // 1 - image src
                                                    esc_url( wp_get_attachment_url( $key ) ),

                                                    // 2 - alt
                                                    get_the_title()
                                        );
                                    }

                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }

        }

        public static function vendor_bussiness_video(){

            $_video_src     = get_post_meta( get_the_ID(), WeddingCity_Vendor_Meta:: business_video_meta_name(), true );

            $_video_bg      = get_post_meta( get_the_ID(), WeddingCity_Vendor_Meta:: business_video_bg_image_meta_name(), true );

            if( ! empty( $_video_src ) ){

                ?>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="vendor-video-block">
                                        <div class="vendor-video-block-img"><img src="<?php echo esc_url( $_video_bg ); ?>" alt="" class="img-fluid"></div>
                                        <div class="video"><iframe src="<?php printf( 'https://www.youtube.com/embed/%1$s', $_video_src ); ?>" allowfullscreen></iframe></div>
                                        <a href="#" class="video-play"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php

            }else{

                esc_html__( 'Vendor does not have video..', 'weddingcity' );
            }
        }


        public static function vendor_publish_number_of_listings(){

            global $post, $wp_query;
        
            $args = array( 

                    'post_type'         => 'listing',

                    'post_status'       => 'publish', 

                    'posts_per_page'    => -1,

                    'orderby'           => 'menu_order ID',

                    'order'             => 'post_date',

                    'author'            => get_post_meta( get_the_ID(), 'user_id', true )
            );

            $item = new WP_Query( $args );

            if( $item->have_posts() ){

                print '<div class="row">';

                while ( $item->have_posts() ){

                    $item->the_post();

                    printf( '<div class="col-xl-4">%1$s</div>',  

                        // 1 - get listing data
                        WeddingCity_Listing:: weddingcity_listing( get_the_ID() )
                    );
                    
                }   wp_reset_postdata();  

                print '</div>';

            }else{
                
                esc_html_e( 'This vendor can not publish any post.', 'weddingcity' );
            }
        }

        public static function vendor_profile_about_us(){

            $_content  =   get_post_field( esc_attr( 'post_content' ), get_the_ID() );

            if( $_content != '' && ! empty( $_content ) ){

                return $_content;

            }else{

                return sprintf( esc_html__( 'Welcome %1$s', 'weddingcity' ), get_the_title() );
            }
        }

        public static function vendor_number_of_listing_reviews(){ 

            global $post, $wp_query;

            $args = array( 

                    'post_type'         => 'listing',

                    'post_status'       => 'publish', 

                    'posts_per_page'    => -1,

                    'orderby'           => 'menu_order ID',

                    'order'             => 'post_date',

                    'author'            => get_post_meta( get_the_ID(), 'user_id', true )
            );

            $item = new WP_Query( $args );

            if( $item->have_posts() ){

                print '<div class="row">';

                while ( $item->have_posts() ){

                    $item->the_post();

                    $var   =  get_the_ID();

                    $var     = WeddingCity_Review_Meta:: listing_reviews( $var );

                    if( WeddingCity_Loader:: array_condition( $var  ) ){

                        foreach( $var as $key => $value) {

                            // array_merge( $value, array( 'timestamp' => strtotime( $value[ 'date_and_time' ] ) ) )

                            printf('    <div class="card border card-shadow-none col-12">
                                            <div class="card-header bg-white mb0">
                                                <div class="review-user">
                                                    <div class="user-img"> <img src="%1$s" alt="%2$s star rating" class="rounded-circle"></div>
                                                    <div class="user-meta">
                                                        <h5 class="user-name mb-0">%2$s  <span class="user-review-date">%3$s</span></h5>
                                                        <div class="given-review">
                                                            <span class="weddingcity_review" data-review="%4$s"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="review-descriptions">
                                                    <p>%5$s</p>
                                                </div>
                                            </div>
                                        </div>',

                                        // 1
                                        ( get_post_meta( $value[ 'couple_id' ], 'user_image', true ) != '' )

                                        ?   esc_url( get_post_meta( $value[ 'couple_id' ], 'user_image', true ) )

                                        :   WeddingCity_User_Meta:: default_avtar(),
                                        
                                        // 2
                                        ( get_post_meta( $value[ 'couple_id' ], 'user_name', true ) != '' )

                                        ?   get_post_meta( $value[ 'couple_id' ], 'user_name', true )

                                        :   esc_html( 'Username' ), 

                                        // 3
                                        human_time_diff(

                                            strtotime( $value[ 'date_and_time' ] ), current_time( 'timestamp' ) 
                                        ),

                                        // 4
                                        $value[ 'average_rating' ],

                                        // 5
                                        $value[ 'user_comment' ]
                            );
                        }
                    }

                }   wp_reset_postdata();

                print '</div>';

            }else{
                
                esc_html_e( 'This vendor can not publish any post.', 'weddingcity' );
            }
        }

        public static function vendor_bussiness_location(){

            return

            sprintf( '  <div id="view-map"><div class="card-body">
                            <div id="vendor_bussiness_location_singular_page" data-latitude="%1$s" data-longitude="%2$s" data-marker="%3$s"></div>
                        </div></div>',

                        // 1 - longitude
                        (WeddingCity_Vendor_Meta:: vendor_bussiness_latitude( get_the_ID() ) != '')
                        ? WeddingCity_Vendor_Meta:: vendor_bussiness_latitude( get_the_ID() )
                        : esc_html( '23.0732195' ),

                        // 2 - latitude
                        (WeddingCity_Vendor_Meta:: vendor_bussiness_longitude( get_the_ID() ))
                        ?WeddingCity_Vendor_Meta:: vendor_bussiness_longitude( get_the_ID() )
                        :esc_html( '72.5646902' ),

                        // 3 - icon
                        ( weddingcity_option( 'google_map_icon' ) != '' )

                        ? esc_url( weddingcity_option( 'google_map_icon' ) )

                        : esc_url( WEDDINGCITY_PLUGIN_IMAGE . 'map-pin.png' )
            );
        }

        public static function _test_5(){ return 'Availability Comming Soon....'; }

        public static function vendor_single_page_tab_markup(){

            ?>
            <div class="vendor-profile-tabs">
                <div class="container">
                    <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
                        <?php

                            foreach( self:: get_list_of_tabs() as $key => $value ){

                                printf( '<li class="nav-item">
                                            <a class="nav-link %4$s" id="%1$s-tab" data-toggle="pill" href="#%1$s" role="tab" aria-controls="%1$s" aria-selected="%3$s">%2$s</a>
                                         </li>',

                                        // 1
                                        sanitize_title( $value[ 'tab_name' ] ),

                                        // 2
                                        esc_html( $value[ 'tab_name' ] ),

                                        // 3
                                        $value[ 'active' ],

                                        // 4
                                        ( $value[ 'active' ] == true ) ? 'active' : ''
                                );
                            }

                        ?>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <?php

                            foreach( self:: get_list_of_tabs() as $key => $value ){

                                printf( '<div class="tab-pane fade %3$s" id="%1$s" role="tabpanel" aria-labelledby="%1$s-tab">',

                                        // 1
                                        sanitize_title( $value[ 'tab_name' ] ),

                                        // 2
                                        $value[ 'active' ],

                                        // 3
                                        ( $value[ 'active' ] == true ) ? 'show active' : ''
                                );

                                /**
                                 *  @link https://www.geeksforgeeks.org/php-call_user_func-function/
                                 */
                                if( $value[ 'print' ] == true ){

                                    print call_user_func( array( 'WeddingCity_Vendor_Single', $value[ 'function' ] ) );

                                }else{

                                    call_user_func( array( 'WeddingCity_Vendor_Single', $value[ 'function' ] ) );
                                }

                                print '</div>';
                            }
                        ?>
                  </div>
               </div>
            </div>
            <?php
        }


    } /* class end **/

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Vendor_Single:: get_instance();
}

