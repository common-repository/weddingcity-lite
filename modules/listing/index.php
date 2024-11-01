<?php

/**
 *  WeddingCity Email Builder
 */

if( ! class_exists( 'WeddingCity_Listing' ) ){

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Listing extends WeddingCity_User{

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

            add_action( 'weddingcity_listing', array( $this, 'weddingcity_listing_markup' ) );

            add_action( 'weddingcity_listing_page_title', array( $this, 'weddingcity_listing_page_title_markup' ) );

            add_action( 'weddingcity_listing_body_before', array( $this, 'weddingcity_listing_body_before' ) );

            add_action( 'weddingcity_listing_body_after', array( $this, 'weddingcity_listing_body_after' ) );    
            
            add_action( 'weddingcity_listing_body_content', array( $this, 'weddingcity_listing_body_content' ) );

            add_action( 'weddingcity_listing_body_content_top', array( $this, 'weddingcity_listing_body_content_top' ) );

            add_action( 'weddingcity_listing_body_content_loop', array( $this, 'weddingcity_listing_body_content_loop' ) );

            add_action( 'weddingcity_listing_body_content_bottom', array( $this, 'weddingcity_listing_body_content_bottom' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'weddingcity_listing_script' ) );

            add_action( 'wp_ajax_weddingcity_remove_vendor_listing_post',  array( $this, 'weddingcity_remove_vendor_listing_post' ) );

            add_action( 'wp_ajax_nopriv_weddingcity_remove_vendor_listing_post', array( $this, 'weddingcity_remove_vendor_listing_post' ) );
        }

        public static function weddingcity_listing_script(){

            if( 
                    ( isset( $_GET['dashboard'] ) && !empty( $_GET['dashboard'] ) && $_GET['dashboard'] == 'vendor-listing' ) ||

                    (
                        is_page_template( 'user-template/search-listing.php' )      ||
                        is_page_template( 'user-template/right-side-listing.php' )  ||
                        is_page_template( 'user-template/left-side-listing.php' )   ||
                        is_page_template( 'user-template/top-side-listing.php' )     
                    ) ||

                    is_singular( 'listing' )
            ){

                wp_enqueue_style( 'weddingcity-listing', WEDDINGCITY_PLUGIN_URL . 'modules/listing/style.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

                wp_enqueue_script( 'weddingcity-listing', WEDDINGCITY_PLUGIN_URL . 'modules/listing/script.js', array( 'jquery', 'review', 'google-map' ), WEDDINGCITY_PLUGIN_VERSION, true );
            }
        }

        public static function weddingcity_remove_vendor_listing_post(){

            global $current_user, $post, $wp_query;
            
            $user_id    =   parent:: post_id();

            if( $_POST['listing_id'] != '' ){

                $_listing_post_id = $_POST['listing_id'];

                $_gallery_ids = get_post_meta( $_listing_post_id, 'vendor_gallery', true );

                if( ! empty( $_gallery_ids ) ){

                    foreach ( explode( ',', $_gallery_ids ) as $key => $value ) {

                        wp_delete_attachment( absint( $value ), true );
                    }
                }

                $_featured_image_id = get_post_meta( $_listing_post_id, 'vendor_featured_id', true );

                if( ! empty( $_featured_image_id ) && $_featured_image_id !== '' ){

                    wp_delete_attachment( absint( $_featured_image_id ), true );
                }

                wp_delete_post( $_listing_post_id, true );

                $number_of_listing =  absint( get_post_meta( $user_id, 'total_listing', true ) );

                update_post_meta( $user_id, 'total_listing', $number_of_listing - absint('1') );

                    echo

                    json_encode( array( 

                            'display'   => false, 

                            'message'   =>  WeddingCity_Alert:: success(

                                                esc_html__('Your Listing is Removed Successfully!.','weddingcity')
                                            )
                    ) );            

                die();

            }else{

                    echo

                    json_encode( array( 

                        'display'   =>  true, 

                        'message'   =>  WeddingCity_Alert:: danger(

                                            esc_html__('Listing id not set Properly!.','weddingcity')
                                        )
                    ) );

                die();
            }
        }

        /**
         * [page_title description]
         * @return [ Page Title ]
         */
        public static function page_title(){

            return esc_html__( 'My Listing', 'weddingcity' );
        }

        public static function page_description(){

            return 

            sprintf( 

                esc_html__( 'Create your wedding business listing on %1$s to start building customers.', 'weddingcity' ),

                // 1
                get_option( 'blogname' )
            );
        }

        public static function weddingcity_listing_page_title_markup(){

            WeddingCity_Dashboard:: dashboard_page_header(

                    // 1
                    self:: page_title(),

                    // 2
                    self:: page_description()
            );
        }

        public static function weddingcity_listing_body_before(){
            ?>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right mb20">
                        
                        <a href="<?php echo WeddingCity_Vendor_Menu:: new_listing(); ?>" class="btn btn-default btn-sm"><?php esc_html_e( 'Add New Listing', 'weddingcity' ) ?></a>

                    </div>
                </div>

            <?php
        }

        public static function weddingcity_listing_body_after(){
            
        }

        public static function weddingcity_listing_markup(){

            do_action( 'weddingcity_listing_page_title' );

            do_action( 'weddingcity_listing_body_before' );

            do_action( 'weddingcity_listing_body_content' );

            do_action( 'weddingcity_listing_body_after' );
        }

        public static function weddingcity_listing_body_content(){

            do_action( 'weddingcity_listing_body_content_top' );

            do_action( 'weddingcity_listing_body_content_loop' );

            do_action( 'weddingcity_listing_body_content_bottom' );
        }

        public static function weddingcity_listing_body_content_top(){

            ?><div class="dashboard-vendor-list"><ul class="list-unstyled"><?php
        }

        public static function weddingcity_listing_body_content_loop(){
        
            $args = array( 

                    'post_type'         => 'listing',

                    'post_status'       => 'publish', 

                    'posts_per_page'    => -1,

                    'orderby'           => 'menu_order ID',

                    'order'             => 'post_date',

                    'author'            => parent:: author_id()
            );

            $item = new WP_Query( $args );

            if( $item->have_posts() ){

                while ( $item->have_posts() ){

                    $item->the_post();

                    printf('<li><div class="dashboard-list-block" data-post-id="%8$s" id="listing_id_%8$s">
                                <div class="row">
                                    <div class="col-xl-2 col-lg-6 col-md-5 col-sm-12 col-12">
                                        <div class="dashboard-list-img"><a href="%10$s"><img src="%6$s" alt="%9$s"></a></div>
                                    </div>


                                    <div class="col-xl-10 col-lg-6 col-md-7 col-sm-12 col-12">
                                        <div class="row">

                                        <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="dashboard-list-content">
                                                <h3 class="mb10"><a href="%10$s" class="title">%1$s</a></h3>
                                                <p class="listing-address">%2$s</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                                            <div class="dashboard-list-btn">
                                                <a href="%3$s" class="btn btn-outline-violate btn-xs mr-2">%4$s</a>
                                                <a href="%7$s" class="post-delete btn btn-outline-pink btn-xs">%5$s</a>
                                            </div>
                                        </div>

                                        </div>
                                    </div>

                                </div>
                            </div></li>',

                            // 1
                            get_the_title(),

                            // 2
                            WeddingCity_Listing_Meta:: listing_address( get_the_ID() ),


                            // 3
                            add_query_arg( 

                                    array( 'listing_id' => get_the_ID()  ),

                                    WeddingCity_Vendor_Menu:: update_listing()
                            ),

                            // 4
                            esc_html__( 'edit', 'weddingcity' ),

                            // 5
                            esc_html__( 'delete', 'weddingcity' ),

                            // 6
                            ( get_the_post_thumbnail_url( get_the_ID(), 'weddingcity_vendor_gallery_360x210' ) != '' )

                                ? get_the_post_thumbnail_url( get_the_ID(), 'weddingcity_vendor_gallery_360x210' )

                                : esc_url( WEDDINGCITY_THEME_DIR .'images/listing-thumb.jpg' ),
                                

                            // 7
                            get_delete_post_link( get_the_ID(), '', true ),

                            // 8
                            get_the_ID(),

                            // 9
                            get_option('blogname'),

                            // 10
                            get_the_permalink( get_the_ID() )
                    );
                    
                }   wp_reset_postdata();              


            }else{
                
                sprintf('<li><div class="dashboard-pageheader">
                            <div class="row">
                                <div class="col-xl-12">%1$s</div>
                            </div>
                        </li>',

                        // 1
                        esc_html__('Welcome Vendor, You dont have any listing. Add your first listing free.', 'weddingcity' )
                );
            }
        }

        public static function weddingcity_listing_body_content_bottom(){

            ?></ul></div><?php
        }


        public static function weddingcity_search_venue_results(){

                $meta_query = array();

                $category_type_array = $location_type_array = $vendor_find = '';

                if( isset( $_POST['vendor_type'] ) && $_POST['vendor_type'] != '0' && !empty( $_POST['vendor_type'] ) ){

                    $vendor_find = array(

                        'taxonomy'  => WeddingCity_Texonomy:: vendor_category_taxonomy(),
                        'field'     => 'id',
                        'terms'     => absint ( $_POST['vendor_type'] )
                    );
                }
                
                if( isset( $_POST['listing_category_id'] ) && $_POST['listing_category_id'] != '0' && !empty( $_POST['listing_category_id'] ) ){

                    $category_type_array = array(

                        'taxonomy'  => WeddingCity_Texonomy:: vendor_category_taxonomy(),
                        'field'     => 'id',
                        'terms'     => absint ( $_POST['listing_category_id'] )
                    );
                }

                if( isset( $_POST['listing_city'] ) && $_POST['listing_city'] != '0' && !empty( $_POST['listing_city'] ) ){

                    $location_type_array = array(

                        'taxonomy'  => WeddingCity_Texonomy:: listing_location_taxonomy(),
                        'field'     => 'id',
                        'terms'     => absint ( $_POST['listing_city'] )
                    );
                }

                if( isset( $_POST['min_price'] ) && isset($_POST['max_price'] ) 
                    && $_POST['min_price'] != '' &&  $_POST['max_price'] != '' ){

                    $meta_query[] = array(

                        'key'       => WeddingCity_Listing_Meta:: listing_price_meta_name(),
                        'type'      => 'numeric',
                        'compare'   => 'BETWEEN',
                        'value'     => array( absint( $_POST['min_price'] ), absint( $_POST['max_price'] ) ),
                    );
                }

                if( isset( $_POST['min_seat'] ) && isset($_POST['max_seat'] ) 
                    && $_POST['min_seat'] != '' &&  $_POST['max_seat'] != '' ){

                    $meta_query[] = array(
                        
                        'key'       => WeddingCity_Listing_Meta:: seat_capacity_meta_name(),
                        'type'      => 'numeric',
                        'compare'   => 'BETWEEN',
                        'value'     => array( absint( $_POST['min_seat'] ), absint( $_POST['max_seat'] ) ),
                    );
                }

                $args = array( 
                    'post_type'         => 'listing',
                    'post_status'       => 'publish', 
                    'posts_per_page'    => -1,
                    'orderby'           => 'menu_order ID',
                    'order'             => 'post_date',
                    'meta_query'        => $meta_query,
                    'tax_query'         => array(
                            'relation'  => 'AND',
                            
                            $vendor_find,
                            $category_type_array,
                            $location_type_array,
                    ),
                );

                $item = new WP_Query( $args );

                $html                   = '';
                $get_html               = array();

                if( $item->have_posts() ){  

                    $i=0;
                    
                    while ( $item->have_posts() ){  $item->the_post();

                        if( isset( $_POST['listing_amenities'] ) ){

                            $post_amenities         = array_values( get_post_meta( get_the_ID(), WeddingCity_Listing_Meta:: listing_venue_amenities_meta_name(), true ) );

                            $selected_amenities     = array_values( $_POST['listing_amenities'] );

                            $dif_aminities          = array_diff( $selected_amenities, $post_amenities );


                            if( count( $dif_aminities ) == absint('0') ){

                                $get_html[] = self:: weddingcity_listing( get_the_ID() );

                            }else{

                                $error = array_unique( array_values( $dif_aminities ) );
                            }

                        }else{ 

                            $get_html[] = self:: weddingcity_listing( get_the_ID() );

                        }
               
                    } wp_reset_postdata();   // while end 

                }else{

                    die( json_encode( array(

                            'html'  =>  esc_html__( 'Listing Not Found..', 'weddingcity' ),

                            'map_show' => true,

                    ) ) );
                }

                // @ref : https://jsfiddle.net/yw7y4wez/1739/

                $get_data = '';

                $per_page       = ( isset( $_POST[ 'pagination' ] ) ) ? absint( $_POST[ 'pagination' ] ) : absint( '9' );
                $start_div      = $per_page;
                $end_div        = $page_counter  =  absint( '1' );

                if( is_array( $get_html ) && ! empty( $get_html ) && count( $get_html ) >= absint('1') ){

                    foreach ( $get_html as $key => $value) {

                        if( $start_div % $per_page == absint( '0' ) &&  count( $get_html ) >= $per_page  ){

                            $get_data .=  sprintf( '<div class="col-12 listing-section listing-post" id="listing-section%1$s"><div class="row">', $page_counter );

                            $page_counter++;
                        }

                        $get_data .= $value;


                        if( $end_div % $per_page == absint( '0' )  &&  count( $get_html ) >= $per_page ){

                            $get_data .= '</div></div>';
                        }

                        $end_div++; $start_div++;
                    }

                }else{

                    die( json_encode( array(

                        'html'              =>  esc_html__( 'Listing Not Found..', 'weddingcity' ),
                        'map_show'          =>  true,
                        'get_pagination'    =>  '',

                    ) ) );
                }

                die( json_encode( array(

                        'html'                  =>  $get_data,

                        'map_show'              =>  true,

                        'get_pagination'        =>  sprintf('%1$s',

                                                        // 1
                                                        (  count( $get_html ) >= $per_page  )

                                                        ?   '<div class="st-paginations col-12">
                                                                <ul id="listing-pagination"></ul>
                                                            </div>'

                                                        : ''
                                                    ),

                ) ) );
        }


        public static function weddingcity_listing_e( $post_id ){

            if( empty( $post_id ) ) 
                return;

            echo self:: weddingcity_listing( $post_id );
        }

        public static function listing_location_textonomy( $_post_id ){

            if( empty( $_post_id ) )
                return;

            $_texonomy_ids = wp_get_post_terms( absint( $_post_id ), WeddingCity_Texonomy:: listing_location_taxonomy(), array( 'fields' => 'ids' ) );

            $_texonomy = '';

            $_arguments = array();

            if( is_array( $_texonomy_ids ) && ! empty( $_texonomy_ids ) ){

                foreach( $_texonomy_ids as $key => $value ){

                    $_arguments[] = 

                    sprintf( '%1$s',

                        // 1
                        WeddingCity_Texonomy:: weddingcity_get_term_name( 

                            WeddingCity_Texonomy:: listing_location_taxonomy(),

                            // 1
                            $value,

                            // 2
                            'name' 
                        )
                    );
                }
            }

            $_texonomy .= '<p class="vendor-address"><span class="vendor-address-icon"><i class="fas fa-map-marker-alt"></i></span>';

            $_texonomy .= implode( ', ', $_arguments );

            $_texonomy .= '</p>';


            return $_texonomy;
        }        

        public static function weddingcity_listing( $post_id ){

            if( empty( $post_id ) )
                return;

            $_get_data = '';

            global $wp_query, $post;

            $query = new WP_Query( array(

                    'post_type'         => 'listing', 
                    'post_status'       => 'publish',
                    'posts_per_page'    => -1,
                    'post__in'          =>  array( $post_id )

            ) );

            if ( $query->have_posts() ){

                while ( $query->have_posts() ){  $query->the_post();

                    $_get_data =

                    sprintf('   <div class="WeddingCity_listing %10$s" id="%11$s">%12$s
                                    <div class="vendor-thumbnail">

                                        <div class="vendor-img overlay-dark">
                                            <a href="%1$s"><img src="%2$s" alt="%3$s" class="img-fluid"></a>
                                            %4$s %7$s 
                                        </div>

                                        %13$s

                                        <div class="vendor-content">
                                            <h2 class="vendor-title"><a href="%1$s" class="title">%3$s</a></h2>%5$s %9$s
                                        </div>

                                        <div class="vendor-meta">%8$s</div>

                                    </div>
                                </div>',

                                // 1
                                get_the_permalink(),


                                // 2
                                ( get_the_post_thumbnail_url( get_the_ID(), 'weddingcity_vendor_gallery_360x210' ) != '' )

                                    ? get_the_post_thumbnail_url( get_the_ID(), 'weddingcity_vendor_gallery_360x210' )

                                    : esc_url( WEDDINGCITY_THEME_DIR .'images/listing-thumb.jpg' ),


                                // 3
                                get_the_title(),


                                // 4
                                WeddingCity_Couple_Wishlist:: weddingcity_wishlist( get_the_ID() ),

                                // 5
                                self:: listing_location_textonomy( get_the_ID() ),

                                // 6
                                '',

                                // 7
                                ( WeddingCity_Listing_Meta:: listing_price( get_the_ID() ) != ''
                                    && WeddingCity_Listing_Meta:: listing_price( get_the_ID() ) != '0'
                                )

                                ?   sprintf(   '<div class="vendor-price-block">
                                                    <span class="vendor-price"><sup>$</sup>%1$s</span>
                                                    <span class="vendor-text">%2$s</span>
                                                </div>',

                                                // 1
                                                WeddingCity_Listing_Meta:: listing_price( get_the_ID() ),

                                                // 2
                                                esc_html__( 'Start From', 'weddingcity' )
                                    )
                                        
                                : '',

                                // 8
                                ( WeddingCity_Listing_Meta:: seat_capacity( get_the_ID() ) != '' 
                                    && WeddingCity_Listing_Meta:: seat_capacity( get_the_ID() ) != '0'  ) 

                                ?   sprintf(   '<div class="vendor-meta-item vendor-meta-item-bordered">
                                                    <span class="guest-no">%1$s</span>
                                                    <span class="vendor-text">%2$s</span>
                                                </div>',

                                                // 1
                                                WeddingCity_Listing_Meta:: seat_capacity( get_the_ID() ),

                                                // 2
                                                esc_html__( 'Guest', 'weddingcity' )
                                    )
                                        
                                : '',

                                // 9
                                '',

                                // 10
                                ( isset( $_POST['column'] ) && $_POST['column'] != '' )

                                ? self:: listing_column( $_POST['column'] ) 

                                : '',


                                // 11
                                sprintf( 'WeddingCity_listing__%1$s', get_the_ID() ),


                                // 12
                                self:: listing_map_attributes( get_the_ID() ),

                                // 13
                                ( WeddingCity_Listing_Meta:: featured_listing( get_the_ID() ) == 'on' )

                                ?   '<div class="listing-badge"><div class="badge badge-warning">Featured</div></div>' 

                                : ''

                    ); // sprintf ending..



                }   wp_reset_postdata();
            }

            return $_get_data;
        }
        
        public static function listing_map_attributes( $_post_id ){

            return
                
            sprintf('<div class="d-none">
                        <input type="hidden" value="%1$s" class="listing_latitude"  />
                        <input type="hidden" value="%2$s" class="listing_longitude" />
                        <input type="hidden" value="%3$s" class="listing_image"     />
                        <input type="hidden" value="%4$s" class="listing_title"     />
                        <input type="hidden" value="%5$s" class="listing_address"   />
                        <input type="hidden" value="%6$s" class="listing_single_link"   />
                        <input type="hidden" value="%7$s" class="listing_icon"     />
                    </div>',

                // 1
                WeddingCity_Listing_Meta:: listing_latitude( $_post_id ),

                // 2
                WeddingCity_Listing_Meta:: listing_longitude( $_post_id ),

                // 3
                get_the_post_thumbnail_url( $_post_id, 'weddingcity_vendor_gallery_360x210' ),

                // 4
                get_the_title( $_post_id ),

                // 5
                WeddingCity_Listing_Meta:: listing_map_address( $_post_id ),

                // 6
                get_the_permalink( $_post_id ),

                // 7
                weddingcity_option( 'google_map_icon' )
            );
        }


        public static function listing_column( $atts ){

            $_column_ = '';

            if( $atts === 'col-md-3' || $atts === '4' ){        $_column_ = 'col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12';

            }elseif( $atts == 'col-md-4' || $atts == '3' ){     $_column_ = 'col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12';

            }elseif( $atts == 'col-md-6' || $atts == '2' ){     $_column_ = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'; 

            }elseif( $atts == 'col-md-2' || $atts == '6' ){     $_column_ = 'col-xl-2 col-lg-6 col-md-6 col-sm-4 col-12'; 

            }elseif( $atts == 'col-md-12' || $atts == '1' ){   $_column_ =  'col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'; 

            }else{   $_column_ = 'col-lg-4 col-md-4 col-sm-6 col-12';  }

            return $_column_;
        }



        /**
         *  Listing Template Parts Here
         *
         *  1. Amenities
         * 
         */
        
        public static function get_listing_amenities(){

            $venue_amenities = '';

            if( weddingcity_option( 'venue_amenities' ) != '' ){ 

                $i = absint('0');

                foreach( weddingcity_option( 'venue_amenities' ) as $args_value ){

                    if(  $args_value['name'] != '' ){

                        $venue_amenities .= 

                            sprintf( '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                            <div class="custom-control custom-checkbox">
                                             <input data-value="%3$s" type="checkbox" name="venue_amenities" value="%2$s" class="custom-control-input" id="customCheck%3$s">
                                             <label class="custom-control-label" for="customCheck%3$s">%1$s</label>
                                            </div>
                                          </div>',

                                        //1
                                        esc_html( $args_value['name'] ),

                                        //2
                                        esc_html( sanitize_title( $args_value['name'] ) ), 

                                        //3
                                        $i
                              ); 

                        $i++;
                    }
                }
            }


            if( isset( $_GET[ 'listing_amenities' ] ) &&  $_GET[ 'listing_amenities' ] !=  'hide' ){

                return
                sprintf(   '<div class="col-xl-12 col-lg-12 col-md-3 col-sm-12 col-12 mt-1">
                                <a class="btn-primary-link collapsed" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">%1$s</a>
                                <div class="collapse" id="collapseExample"><div class="aminities"><div class="row">%2$s</div></div></div>
                            </div>',

                            // 1
                            esc_html__( 'Advance Option', 'weddingcity' ),

                            // 2
                            $venue_amenities
                );
            }
        }

        public static function get_listing_price_filter(){

            $price_filter = '';

            if( weddingcity_option( 'price_filter' ) != '' ){ $i = absint('0');

                $select_value = ( isset( $_GET['price_filter'] ) && $_GET['price_filter'] != '' ) ? $_GET['price_filter'] : '';

                foreach( weddingcity_option( 'price_filter' ) as $args_value ){

                    $price_filter .= 

                    sprintf( '<option data-min="%4$s" data-max="%5$s" value="%2$s" %3$s>%1$s</option>',

                        // 1
                        $args_value['name'],

                        // 2
                        esc_html( sanitize_title( $args_value['name'] ) ),

                        // 3
                        ( esc_html( sanitize_title( $args_value['name'] ) ) == $select_value ) ? 'selected' : '',

                        // 4
                        ( $args_value['min-price'] != '' ) ? absint( $args_value['min-price'] ) : '',

                        //5
                        ( $args_value['max-price'] != '' ) ? absint( $args_value['max-price'] ) : ''
                    );
                }
            }

            return

            sprintf(   '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                            <select class="wide" name="price_filter" id="price_filter">%1$s</select>
                            <input type="hidden" id="max_price" value="" />
                            <input type="hidden" id="min_price" value="" />
                        </div>',

                        // 1
                        $price_filter
            );
        }

        public static function get_listing_seat_capacity(){

            $seat_capacity = '';

            if( weddingcity_option( 'seat_capacity' ) != '' ){ $i = absint('0');

                $select_value = ( isset( $_GET['seat_capacity'] ) && $_GET['seat_capacity'] != '' ) ? $_GET['seat_capacity'] : '';

                foreach( weddingcity_option( 'seat_capacity' ) as $args_value ){

                    $seat_capacity .= 

                    sprintf( '<option data-min="%4$s" data-max="%5$s" value="%2$s" %3$s>%1$s</option>',

                        // 1
                        $args_value['name'],

                        // 2
                        esc_html( sanitize_title( $args_value['name'] ) ),

                        // 3
                        ( esc_html( sanitize_title( $args_value['name'] ) ) == $select_value ) ? 'selected' : '',

                        // 4
                        ( $args_value['min-seat'] != '' ) ? absint( $args_value['min-seat'] ) : '',

                        // 5
                        ( $args_value['max-seat'] != '' ) ? absint( $args_value['max-seat'] ) : ''
                    );
                }
            }

            return

            sprintf(   '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                            <select class="wide" name="seat_capacity" id="seat_capacity">%1$s</select>
                            <input id="min_seat" type="hidden" value="" />
                            <input id="max_seat" type="hidden" value="" />
                        </div>',

                        // 1
                        $seat_capacity
            );
        }

        public static function get_vendor_type(){

            if( isset( $_GET['vendor_type'] ) ){

                return

                sprintf(   '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"><select class="wide" name="vendor_type" id="vendor_type">%1$s</select></div>',

                            // 1
                            WeddingCity_Texonomy:: create_select_option(

                                $get_parents = WeddingCity_Texonomy:: get_texonomy_parent( WeddingCity_Texonomy:: vendor_category_taxonomy() ), 

                                $label = array( '0' => 'Vendor' ), 

                                $default_select = absint( $_GET['vendor_type'] ),

                                $print = false
                            )
                );

            }else{

                return

                sprintf(   '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"><select class="wide" name="vendor_type" id="vendor_type">%1$s</select></div>',


                            WeddingCity_Texonomy:: create_select_option(

                                    WeddingCity_Texonomy:: get_texonomy( WeddingCity_Texonomy:: vendor_category_taxonomy() ), 

                                    array( '0' => 'Vendors' )
                            )
                );
            }
        }

        public static function get_listing_category_id(){

            if( isset( $_GET['listing_category_id'] ) ){

                return

                sprintf(   '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <select class="wide" name="listing_category_id" id="listing_category_id">%1$s</select>
                            </div>',

                            // 1
                            WeddingCity_Texonomy:: create_select_option(

                                    $get_parents = WeddingCity_Texonomy:: get_texonomy_child( 

                                                      WeddingCity_Texonomy:: vendor_category_taxonomy(), 

                                                        ( absint( $_GET['venue_id'] ) ) ? 
                                                              absint( $_GET['venue_id'] )
                                                                : absint('0') 
                                                    ), 

                                    $label = array( '0' => 'Listing Type' ), 

                                    $default_select = absint( $_GET['listing_category_id'] ),

                                    $print = false
                            )
                );
            }
        }

        public static function get_listing_location(){

            if( isset( $_GET['listing_city'] ) ||  isset( $_GET['listing_state_id'] )  ){

                return

                sprintf(   '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <select class="wide" name="listing_city" id="listing_city">%1$s</select>
                            </div>',

                            // 2
                            WeddingCity_Texonomy:: create_select_option(

                                    WeddingCity_Texonomy:: get_texonomy_child( 

                                                  WeddingCity_Texonomy:: listing_location_taxonomy(),

                                                  ( $_GET['listing_city'] != '' && $_GET['listing_city'] != '0' )

                                                  ? WeddingCity_Texonomy:: weddingcity_get_term_name( WeddingCity_Texonomy:: listing_location_taxonomy(), absint( $_GET['listing_city'] ), 'parent' )

                                                  : absint( $_GET['listing_state_id'] )

                                    ), 

                                    array( '0' => 'Location' ),

                                    ( $_GET['listing_city'] != '' && $_GET['listing_city'] != '0' ) 

                                    ?  absint( $_GET['listing_city'] )

                                    :  absint( $_GET['listing_city'] ),

                                    false
                            )
                );

            }else{


                return

                sprintf(   '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <select class="wide" name="listing_city" id="listing_city">%1$s</select>
                            </div>',

                            // 1
                            WeddingCity_Texonomy:: create_select_option(

                                    WeddingCity_Texonomy:: get_texonomy( 'location' ), 

                                    array( '0' => 'Location' )
                            )
                );
            }
        }

        public static function get_pagination(){

            return
            sprintf( '<input type="hidden" name="pagination" id="pagination" value="%1$s" />',

                    // 1
                    absint( '9' )
            );
        }

        public static function get_listing_filter_button(){

                return

                sprintf(    '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <button class="btn btn-default btn-block btn-lg" id="seach_result_btn" type="submit">%1$s</button>
                            </div>',

                            // 1 - Search Button Text
                            esc_html__( 'Search', 'weddingcity' )
                );
        }

        public static function get_column(){

            $_column = '';

            if( isset( $_GET[ 'column' ] ) ){

                $_column = absint( $_GET[ 'column' ] );

            }else{

                $_column = absint( '3' );
            }

            return  sprintf( '<input type="hidden" name="column" id="column" value="%1$s" />',  

                            absint( $_column ) 
                    );
        }

        public static function get_listing_filter_options(){

            return

            sprintf('   <div class="filter-form col-12">
                            <form id="seach_result_form" class="form-row" method="post">

                                %1$s <!-- vendors list dropdown -->

                                %2$s <!-- listing categories dropdown -->

                                %3$s <!-- listing location filter -->

                                %4$s <!-- price filter option -->

                                %5$s <!-- search button -->

                                %6$s <!-- column -->

                                %7$s <!-- map position -->

                                %8$s <!-- pagination -->

                                %9$s <!-- listing aminities -->

                            </form>
                        </div>',

                        // 1 = vendor type option
                        self:: get_vendor_type(),

                        // 2 = listing categories id
                        self:: get_listing_category_id(),

                        // 3 = listing locations
                        self:: get_listing_location(),

                        // 4 = price filter option
                        self:: get_listing_price_filter(),

                        // 5 = Button
                        self:: get_listing_filter_button(),

                        // 6 - column
                        self:: get_column(),

                        // 7 - map position
                        self:: get_map_attributes(),

                        // 8 - pagination loop
                        self:: get_pagination(),

                        // 9 - Listing aminities
                        self:: get_listing_amenities()
            );
        }

        public static function get_map_position(){

            $_map_position = '';

            if( isset( $_GET[ 'listing_map' ] ) && $_GET[ 'listing_map' ] != esc_html( 'hide' ) ){

                $_map_position = esc_html( $_GET[ 'listing_map' ] );

            }else{

                $_map_position = esc_html( 'right' );
            }

            return $_map_position;
        }

        public static function get_map_attributes(){
            
            return 
            sprintf( '<input type="hidden" name="listing_map_position" id="listing_map_position" value="%1$s" />',

                    // 1
                    self:: get_map_position()
            );
        }

        public static function weddingcity_top_map_listing_markup(){

            if( ( self:: get_map_position() == 'top' && self:: get_map_position() != 'hide' ) ||  is_page_template( 'user-template/top-side-listing.php' )  ){

                self::weddingcity_listing_template_before();

                printf('    <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 nopl nopr">
                                    <div id="listing_map" class="top_listing"></div>
                                </div>
                            </div>

                            <div class="container"><div class="col-12">%1$s</div></div>
                            
                            <div class="content container">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="row" id="listing_search_result"></div>
                                </div>
                            </div>',

                            // 1
                            self::get_listing_filter_options()
                );

                self::weddingcity_listing_template_after();
            }
        }

        public static function weddingcity_right_map_listing_markup(){

            if( ( self:: get_map_position() == 'right' && self:: get_map_position() != 'hide' ) ||  is_page_template( 'user-template/right-side-listing.php' )  ){  

                self::weddingcity_listing_template_before();

                printf('<div class="row">
                            <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">%1$s</div>
                                <div class="row scroll-content" id="listing_search_result"></div>
                            </div>
                            <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12 nopl nopr">
                                <div id="listing_map" class="right_listing"></div>
                            </div>
                        </div>',

                        // 1
                        self::get_listing_filter_options()
                );

                self::weddingcity_listing_template_after();
            }
        }

        public static function weddingcity_listing_template_before(){

            global $post, $wp_query, $page;

            get_header();
            
                ?><div class="container-fluid"><?php
        }

        public static function weddingcity_listing_template_after(){

                ?></div><?php

            get_footer();
        }


        public static function weddingcity_left_map_listing_markup(){

            if( ( self:: get_map_position() == 'left' && self:: get_map_position() != 'hide' ) ||  is_page_template( 'user-template/left-side-listing.php' )  ){

                self::weddingcity_listing_template_before();

                printf('<div class="row">
                            <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12 nopl nopr">
                                <div id="listing_map" class="left_listing"></div>
                            </div>
                            <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">%1$s</div>
                                <div class="row scroll-content" id="listing_search_result"></div>
                            </div>
                        </div>',

                        // 1
                        self::get_listing_filter_options()
                );

                self::weddingcity_listing_template_after();
            }
        }

        public static function weddingcity_find_listing_markup(){

            do_action( 'weddingcity_top_map_listing' );

            do_action( 'weddingcity_right_map_listing' );

            do_action( 'weddingcity_left_map_listing' );   
        }

        public static function weddingcity_similar_listing_markup(){

            global $post, $wp_query;

            /**
             *  1. Goto Post ID
             *  2. Get Texonomy Ids
             */
            $similar_listing = absint( array_values( wp_get_post_terms( get_the_ID(), WeddingCity_Texonomy:: vendor_category_taxonomy(), array( 'fields' => 'ids' ) ) )[ 0 ] );

            $vendor_find = array(

                'taxonomy'  => WeddingCity_Texonomy:: vendor_category_taxonomy(),
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

                            self:: weddingcity_listing_e( get_the_ID() );

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

            if( weddingcity_option( 'share_listing' ) == 'on' && class_exists( 'WeddingCity_Plugin' ) ){

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
                            <div id="singlelistmap" data-latitude="%2$s" data-longitude="%3$s"></div>
                        </div>

                    </div>',

                    // 1
                    esc_html__('Location - Map','weddingcity'),

                    // 2
                    WeddingCity_Listing_Meta:: listing_latitude( get_the_ID() ),

                    // 3
                    WeddingCity_Listing_Meta:: listing_longitude( get_the_ID() )
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


        /**
         *    Start From / Seat Capacity / Reviews 
         */
        public static function weddingcity_listing_page_features_markup(){

            $_listing_price     =   WeddingCity_Listing_Meta:: listing_price( get_the_ID() );

            printf( '<div class="vendor-meta bg-white border m-0 mb-4">%1$s</div>',

                // 1
                ( $_listing_price != '' && $_listing_price != '0' )

                ?   sprintf(    '<div class="vendor-meta-item vendor-meta-item-bordered">

                                    <span class="vendor-price">%1$s%2$s</span>
                                    <span class="vendor-text">%3$s</span>

                                </div>',

                            // 1
                            esc_html__( '$', 'weddingcity' ),

                            // 2
                            $_listing_price,

                            // 3
                            esc_html__( 'Start From', 'weddingcity' )
                    )

                :   ''
            );
        }

        public static function weddingcity_listing_page_header_banner_markup(){

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
                        WeddingCity_Couple_Wishlist:: weddingcity_wishlist_singular_page( get_the_ID() )
            );
        }

        public static function weddingcity_listing_singular_page_markup(){

            get_header();

                if ( have_posts() ){

                    while ( have_posts() ){ the_post();

                        /**
                         *  Page Header Banner - listing single page
                         */
                        
                        do_action( 'weddingcity_listing_page_header_banner' );  ?>


                        <div class="vendor-content-wrapper">

                            <div class="container">

                                <div class="row">

                                    <div class="col-xl-8 col-lg-8 col-md-7 col-sm-12 col-12"><?php

                                            /**
                                             *    Start From / Seat Capacity / Reviews 
                                             */

                                            do_action( 'weddingcity_listing_page_features' );


                                            /**
                                             *.   @About Description
                                             */

                                            do_action( 'weddingcity_listin_page_content' );

                                            /**
                                             *.   @Accommodations / Amenities Included /
                                             */
                                            
                                            do_action( 'weddingcity_listing_page_amenities' );


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

                                            do_action( 'weddingcity_listing_page_map' );    ?>


                                    </div><!-- // End of Col-md-8 -->

                                    <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">

                                        <div class="sidebar-venue"><?php

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
                                            do_action( 'weddingcity_listing_sharing' ); ?>

                                            
                                        </div>

                                    </div><!-- //. col-md-4 Ending... -->


                                </div><!-- Row Ending -->

                                <?php

                                    /**
                                     *  Similar Listing
                                     */
                                    do_action( 'weddingcity_similar_listing' );

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
    WeddingCity_Listing::get_instance();
}
