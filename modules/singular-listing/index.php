<?php

/**
 *  WeddingCity Email Builder
 */

if( ! class_exists( 'WeddingCity_Listing_Singular' ) ){

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Listing_Singular{

        /**
         * Member Variable
         *
         * @var instance
         */
        private static $instance;

        /**
         *  @var $listing_var
         */
        private $listing_var;


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

            global $post, $wp_query;

            add_action( 'weddingcity_listing_singular_page', array( $this, 'weddingcity_listing_singular_page_markup' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'weddingcity_listing_singular_page_script' ) );
        }

        public static function weddingcity_listing_singular_page_script(){

            if(     is_singular( 'listing' )

                    ||

                    is_archive( 'listing' )
            ){

                wp_enqueue_style( 'weddingcity-listing-singular', plugin_dir_url( __FILE__ ).'style.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

                wp_enqueue_script( 'weddingcity-listing-singular', plugin_dir_url( __FILE__ ).'script.js', array( 'jquery', 'review', 'google-map' ), WEDDINGCITY_PLUGIN_VERSION, true );
            }
        }

        public static function get_category_marker( $_post_id ){

            if( empty( $_post_id ) )
                return;

            $_marker_option = 

            get_term_meta(

                absint( array_values( wp_get_post_terms( $_post_id, WeddingCity_Texonomy:: listing_category_taxonomy(), array( 'fields' => 'ids' ) ) )[ 0 ] ),

                'marker_option',

                true 
            );

            if( $_marker_option != '0' ){

                // return esc_url( WEDDINGCITY_PLUGIN_IMAGE . '1244505.svg' );

                return  esc_url(  WEDDINGCITY_PLUGIN_URL . '/assets/images/vendor-category/'. $_marker_option .'.svg'  );

            }else{

                return

                wp_get_attachment_image_src ( 

                    get_term_meta(

                        absint( array_values( wp_get_post_terms( $_post_id, WeddingCity_Texonomy:: listing_category_taxonomy(), array( 'fields' => 'ids' ) ) )[ 0 ] ),

                        'marker_image_id',

                        true 
                    )
                )[ absint( '0' ) ];

            }
        }

        public static function weddingcity_similar_listing_markup(){

            global $post, $wp_query;

            /**
             *  1. Goto Post ID
             *  2. Get Texonomy Ids
             */
            $similar_listing = absint( array_values( wp_get_post_terms( get_the_ID(), WeddingCity_Texonomy:: listing_category_taxonomy(), array( 'fields' => 'ids' ) ) )[ 0 ] );

            $vendor_find = array(

                'taxonomy'  => WeddingCity_Texonomy:: listing_category_taxonomy(),
                'field'     => 'id',
                'terms'     => absint( $similar_listing )
            );

            $args = array( 
                'post_type'         => 'listing',
                'post_status'       => 'publish', 
                'posts_per_page'    => absint( '3' ),
                'orderby'           => 'menu_order ID',
                'order'             => 'post_date',
                'post__not_in'      => array( get_the_ID() ),
                'tax_query'         => array(
                    'relation'  => 'AND',
                    $vendor_find
                ),
            );

            $item = new WP_Query( $args );

            if( $item->have_posts() ){

                printf(   '<div class="space-small"><div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                    <h2>%1$s</h2>
                                </div>
                            </div>

                            <div class="row">',

                            // 1
                            esc_html__( 'Similar Vendor', 'weddingcity' )
                );

                while ( $item->have_posts() ){  $item->the_post();

                        print '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">';

                            WeddingCity_Listing:: weddingcity_listing_e( get_the_ID() );

                        print '</div>';
                }

                print '</div></div>';

                wp_reset_postdata();   // while end 
            }
        }

        /** 
         *.  @Share Listing...
         */
        
        public static function weddingcity_listing_sharing_markup(){

            if( weddingcity_option( 'share_listing' ) == 'on' ){

                printf('<div class="card"><div class="card-body">

                            <h4 class="widget-title">%1$s</h4>
                            <div class="social-icons">%2$s</div>

                        </div></div>',

                        // 1
                        esc_html__( 'Share Listing', 'weddingcity' ),

                        // 2
                        ( function_exists( 'weddingcity_share_post' ) )

                        ? weddingcity_share_post( weddingcity_option( 'listing_share' ) )

                        : ''
                );
            }
        }

        /**
         *.  @Listing - Map
         */
        
        public static function weddingcity_listing_page_map_markup(){

            printf( '<div class="card border card-shadow-none">

                        <h3 id="map_section" class="card-header bg-white">%1$s</h3>
                        <div class="card-body">
                            <div id="singlelistmap" data-latitude="%2$s" data-longitude="%3$s" data-marker="%4$s"></div>
                        </div>

                    </div>',

                    // 1
                    esc_html__('Location - Map','weddingcity'),

                    // 2
                    WeddingCity_Listing_Meta:: listing_latitude( get_the_ID() ),

                    // 3
                    WeddingCity_Listing_Meta:: listing_longitude( get_the_ID() ),

                    // 4
                    weddingcity_option( 'google_map_icon' )
            );
        }

        /**
         *.   @Accommodations / Amenities Included /
         */
        public static function weddingcity_listing_page_amenities_markup(){

            $_listing_aminities = WeddingCity_Listing_Meta:: listing_venue_amenities( get_the_ID() );

            if( WeddingCity_Loader:: array_condition( $_listing_aminities ) ){

                if( weddingcity_option( 'venue_amenities' ) != '' ){ 

                    $_store_aminities = '';

                    foreach( weddingcity_option( 'venue_amenities' ) as $args_value ){

                        if(  $args_value['name'] != '' ){

                            if( in_array( sanitize_title( $args_value['name'] ) , $_listing_aminities ) ){

                                $_store_aminities .=

                                sprintf( '  <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 venue_aminities_single">
                                                <span><i class="fas fa-check-circle"></i>%1$s</i></span>
                                            </div>',

                                            // 1
                                            esc_html( $args_value['name'] )
                                );
                            }
                        }
                    }
                }

                ?>  <div class="card border card-shadow-none">

                            <h3 class="card-header bg-white"><?php esc_html_e( 'Accommodations / Amenities Included', 'weddingcity' ); ?></h3>

                            <?php if( $_store_aminities != '' ){ ?><div class="card-body"><?php echo $_store_aminities; ?></div><?php } ?>

                        </div>
                <?php
            }
        }

        public static function weddingcity_listin_page_content_markup(){

            printf( '<div class="card border card-shadow-none">

                        <h3 class="card-header bg-white">%1$s</h3> %2$s

                    </div>',

                    // 1
                    esc_html__( 'About Listing', 'weddingcity' ),

                    // 2
                    ( get_the_content() != '' )

                    ?   sprintf( '<div class="card-body">%1$s</div>',

                            // 1
                            wp_specialchars_decode( get_the_content() )
                        )

                    :   ''
                );
        }

        public static function listing_single_page_currency_possition( $_listing_price ){

            if( empty( $_listing_price ) )
                return;

            global $post, $wp_query;

            $_possition = weddingcity_option( '_currencty_possition_' );

            if( $_possition == 'right' ){

                    return

                    sprintf(    '<div class="vendor-meta-item vendor-meta-item-bordered">

                                    <span class="vendor-price">%2$s%1$s</span>
                                    <span class="vendor-text">%3$s</span>

                                </div>',

                            // 1
                            ( weddingcity_option( 'listing_currency_sign' ) != '' )

                            ? esc_html( weddingcity_option( 'listing_currency_sign' ) )

                            : esc_html__( '$', 'weddingcity' ),

                            // 2
                            $_listing_price,

                            // 3
                            esc_html__( 'Start From', 'weddingcity' )
                    );

            }else{

                    return

                    sprintf(    '<div class="vendor-meta-item vendor-meta-item-bordered">

                                    <span class="vendor-price">%1$s%2$s</span>
                                    <span class="vendor-text">%3$s</span>

                                </div>',

                            // 1
                            ( weddingcity_option( 'listing_currency_sign' ) != '' )

                            ? esc_html( weddingcity_option( 'listing_currency_sign' ) )

                            : esc_html__( '$', 'weddingcity' ),

                            // 2
                            $_listing_price,

                            // 3
                            esc_html__( 'Start From', 'weddingcity' )
                    );
            }
        }


        /**
         *    Start From / Seat Capacity / Reviews 
         */
        public static function weddingcity_listing_page_features_markup(){

            $_listing_price     =   WeddingCity_Listing_Meta:: listing_price( get_the_ID() );

            $_seat_capacity     =   WeddingCity_Listing_Meta:: seat_capacity( get_the_ID() );

            $_review_post_id    =   get_the_ID();

            $_average_review    =   ( class_exists( 'WeddingCity_Listing_Reviews' ) )

                                    ? WeddingCity_Listing_Reviews:: review_data( $_review_post_id, 'average_rating' )

                                    : absint( '0' );

            printf( '<div class="vendor-meta bg-white border m-0 mb-4">%1$s %2$s %3$s</div>',

                // 1
                ( $_listing_price != '' && $_listing_price != '0' )

                ?   self:: listing_single_page_currency_possition( $_listing_price )

                :   '',

                // 2
                ( $_seat_capacity != '' && $_seat_capacity != '0' )

                ?   sprintf(   '<div class="vendor-meta-item vendor-meta-item-bordered">

                                    <span class="vendor-guest">%1$s%2$s</span>
                                    <span class="vendor-text">%3$s</span>

                                </div>',

                            // 1
                            $_seat_capacity,

                            // 2
                            esc_html__( '+', 'weddingcity' ),

                            // 3
                            esc_html__( 'Guest', 'weddingcity' )
                    )

                :   '',

                // 3
                ( class_exists( 'WeddingCity_Listing_Reviews' ) )

                ?   sprintf(    '<div class="vendor-meta-item vendor-meta-item-bordered">

                                    <span class="rating-box vendor-meta-box">
                                        <span class="weddingcity_review rating-star" data-review="%2$s"></span>
                                        <span id="%3$s" class="rating-count rating-badge">%2$s</span>
                                        <a href="javascript:void(0);" id="goto_review" class="review-comment small"> %1$s</a>
                                    </span>

                                </div>',

                            // 1
                            esc_html__( 'Write Review', 'weddingcity' ),
                            
                            // 2
                            $_average_review,
                            
                            // 3
                            rand()
                    )

                :   ''
            );
        }

        /**
         *  @listing - weddingcity singel page popup gallery
         */
        public static function listing_singular_popup_gallery_section(){

            $vendor_featured_image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );

            if( empty( $vendor_featured_image_url ) ){

                $vendor_featured_image_url = esc_url( WEDDINGCITY_THEME_DIR . 'images/listing-banner.jpg' );
            }

            if( $vendor_featured_image_url != '' ){

                $vendor_featured_image = sprintf('background: linear-gradient(0deg,rgba(54, 50, 59, 0.35),rgba(43, 38, 47, 0.35)), url(%1$s);', esc_url( $vendor_featured_image_url ) );
            }

            $vendor_gallery   =  WeddingCity_Listing_Meta:: listing_gallery( get_the_ID() );

            if( $vendor_gallery != '' ){ $i = absint('1');

                print '<div id="gallery-1" class="d-none">';
            
                    foreach( explode( ',', $vendor_gallery ) as $key ){
                
                        if( isset( $key ) && $key != '' ){
                
                            printf( '<a href="%1$s">%2$s</a>',

                                    // 1
                                    wp_get_attachment_url( $key ), 

                                    // 2
                                    sprintf( esc_html__('Vendor Gallery %1$s', 'weddingcity' ), $i++ )
                            );
                        }
                    }
            
                print '</div>';
            }

            printf('    <div class="venue-pageheader" style="%1$s">
                            <div class="container">
                                <div class="row align-items-end page-section">
                                    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                                        <div class="">
                                            <h1 class="vendor-heading">%2$s</h1>
                                            <p class="text-white single-listing-address"><span class="mr-2"><i class="fas fa-map-marker-alt "></i></span>%3$s <a href="javascript:void(0);" id="goto_map" class="btn-default-link">%4$s</a></p>
                                        </div>
                                    </div>
                                    <div class="col-xl-5 text-lg-right">
                                         <div class="mt-xl-4">
                                            %5$s %6$s
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>',

                        // 1
                        $vendor_featured_image,

                        // 2
                        get_the_title(),

                        // 3
                        WeddingCity_Listing_Meta:: listing_map_address( get_the_ID() ),

                        // 4
                        esc_html__( 'view map', 'weddingcity' ),

                        // 5
                        ( ! empty( $vendor_gallery ) )

                        ?   sprintf( '<a href="#gallery-1" class="btn btn-primary btn-gallery">%1$s</a>',

                                // 1
                                esc_html__( 'View Gallery', 'weddingcity' ) 

                            ) 

                        : '',

                        // 6
                        ( class_exists( 'WeddingCity_Couple_Wishlist' ) )

                        ? WeddingCity_Couple_Wishlist:: weddingcity_wishlist_singular_page( get_the_ID() )  :   ''
            );
        }

        public static function listing_singular_gallery_variation( $_gallery_column ){

            if( $_gallery_column == absint( '4' ) ){

                self:: listing_singular_gallerys_heading_section( $_gallery_column, 'list-single-third' );

                self:: listing_singular_gallerys();                

            }elseif( $_gallery_column == absint( '1' ) ){

                self:: listing_singular_gallerys();

                self:: listing_singular_gallerys_heading_section( $_gallery_column, 'list-single-second' );
            }
        }

        public static function listing_singular_gallerys_heading_section( $_gallery_column, $_class ){

            ?>
            <div class="<?php echo $_class; ?> listing_gallery_slider" data-gallery="<?php echo absint( $_gallery_column ); ?>">
                <div class="container">
                    <div class="">
                       <div class="row d-flex align-items-center">
                          <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                             <div class="vendor-head">
                                <h2 class="vendor-head-title"><?php the_title(); ?></h2>
                                <p class="vendor-address"><?php echo WeddingCity_Listing_Meta:: listing_address( get_the_ID() ); ?></p>
                             </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                             <div class="vendor-head text-xl-right">
                                <?php echo WeddingCity_Couple_Wishlist:: weddingcity_wishlist_singular_page(  

                                                get_the_ID()

                                        ); ?>
                             </div>
                          </div>
                       </div>
                    </div>
                </div>
            </div>
            <?php
        }

        public static function listing_singular_gallerys(){

            $vendor_gallery   =  WeddingCity_Listing_Meta:: listing_gallery( get_the_ID() );

            if( $vendor_gallery != '' ){ $i = absint('1');

                print '<div class="list-single-carousel"><div class="owl-carousel owl-theme owl-second">';
            
                    foreach( explode( ',', $vendor_gallery ) as $key ){
                
                        if( isset( $key ) && $key != '' ){
                
                            printf( '<div class="item"><img src="%1$s" alt=""></div>',

                                    // 1
                                    wp_get_attachment_url( $key ), 

                                    // 2
                                    sprintf( esc_html__('Vendor Gallery %1$s', 'weddingcity' ), $i++ )
                            );
                        }
                    }
            
                print '</div></div>';
            }
        }



        public static function listing_singular_video_section(){

            ?>
            <div class="videosection" data-src="<?php echo get_post_meta( get_the_ID(), 'venue_video', true ); ?>"></div>
            <div class="list-single-second">
                <div class="container">
                    <div class="">
                        <div class="row">
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                <div class="vendor-head text-left">
                                    <h2 class="mb10"><?php the_title(); ?></h2>
                                    <p class="vendor-address"><?php echo WeddingCity_Listing_Meta:: listing_address( get_the_ID() ); ?> <a href="javascript:void(0);" id="goto_map" 
                                        class="btn-secondary-link ml-2"><?php esc_html_e( 'View Map', 'weddingcity' ); ?></a></p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="vendor-head text-xl-right">
                                    <?php echo WeddingCity_Couple_Wishlist:: weddingcity_wishlist_singular_page(  

                                                WeddingCity_User_Meta:: user_post_id()

                                        ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        public static function weddingcity_listing_page_header_banner_markup(){

            $_layout_option     =   weddingcity_option( 'listing_single_page_layout' );

            if( is_page_template( 'user-template/listing-gallery-full-width.php' ) ){

                self:: listing_singular_gallery_variation( absint( '1' ) );

            }elseif( is_page_template( 'user-template/listing-gallery-four-column.php' ) ){

                self:: listing_singular_gallery_variation( absint( '4' ) );

            }elseif( is_page_template( 'user-template/listing-video.php' ) ){

                self:: listing_singular_video_section();

            }elseif( $_layout_option == 'listing_slider_gallery'  ){

                $_listin_setting = absint( weddingcity_option( 'listing_single_page_gallery_layout' ) );

                self:: listing_singular_gallery_variation( $_listin_setting );

            }elseif( $_layout_option == 'listing_video' ){

                self:: listing_singular_video_section();

            }else{

                self:: listing_singular_popup_gallery_section();
            }
        }

        public static function weddingcity_listing_singular_page_markup(){

            get_header();

                if ( have_posts() ){

                    while ( have_posts() ){ the_post();

                        /**
                         *  Page Header Banner - listing single page
                         */
                        
                        self:: weddingcity_listing_page_header_banner_markup();  ?>


                        <div class="vendor-content-wrapper">

                            <div class="container">

                                <div class="row">

                                    <div class="col-xl-8 col-lg-8 col-md-7 col-sm-12 col-12"><?php

                                            /**
                                             *    Start From / Seat Capacity / Reviews 
                                             */

                                            self:: weddingcity_listing_page_features_markup();


                                            /**
                                             *.   @About Description
                                             */
                                            
                                            self:: weddingcity_listin_page_content_markup();

                                            /**
                                             *.   @Accommodations / Amenities Included /
                                             */
                                            
                                            self:: weddingcity_listing_page_amenities_markup();


                                            /**
                                             *.  Listing Rating Overview
                                             */

                                            do_action( 'weddingcity_listing_review_overview' );


                                            /**
                                             *.  Listing Reviews Comment.
                                             */

                                            do_action( 'weddingcity_listing_review_comments' );


                                            /**
                                             *.  Review Form
                                             */

                                            do_action( 'weddingcity_listing_review_form' );



                                            /**
                                             *.  @Listing - Map
                                             */

                                            self:: weddingcity_listing_page_map_markup();    ?>


                                    </div><!-- // End of Col-md-8 -->

                                    <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">

                                        <div class="sidebar-venue"><?php

                                            /**
                                             *   Listing Availibility
                                             */
                                            do_action( 'weddingcity_listing_avaibility' );
                                            

                                            /**
                                             *  Listing Request Form
                                             */
                                            
                                            do_action( 'weddingcity_listing_request_form' );


                                            /**
                                             *  Vendor Profile
                                             */
                                            
                                            do_action( 'weddingcity_sidebar_vendor_information' );


                                            /** 
                                             *.  @Share Listing...
                                             */

                                            self:: weddingcity_listing_sharing_markup();


                                            /**
                                             *  Claim Listing Widget
                                             */
                                            do_action( 'weddingcity_claim_listing_widget' );

                                            ?>

                                        </div>

                                    </div><!-- //. col-md-4 Ending... -->


                                </div><!-- Row Ending -->

                                <?php

                                    /**
                                     *  Similar Listing
                                     */

                                    self:: weddingcity_similar_listing_markup();

                                ?>

                            </div>
                        </div>

                    <?php

                    } // while endign

                } // if ending.

            get_footer(); 
        }

    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Listing_Singular::get_instance();
}
