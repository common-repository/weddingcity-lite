<?php

/**
 *  WeddingCity Email Builder
 */

if( ! class_exists( 'WeddingCity_Search_Listing' ) ){

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Search_Listing{

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

            add_action( 'weddingcity_find_listing', array( $this, 'weddingcity_find_listing_markup' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'weddingcity_listing_search_script' ) );

            /**
             *  Template redirect
             */
            add_action( 'weddingcity_top_map_listing', array( $this, 'weddingcity_top_map_listing_markup' ) );

            add_action( 'weddingcity_right_map_listing', array( $this, 'weddingcity_right_map_listing_markup' ) );

            add_action( 'weddingcity_left_map_listing', array( $this, 'weddingcity_left_map_listing_markup' ) );


            /**
             *  Scripts
             */

            add_action( 'wp_ajax_weddingcity_search_venue_results',  array( $this, 'weddingcity_search_venue_results' ) );

            add_action( 'wp_ajax_nopriv_weddingcity_search_venue_results', array( $this, 'weddingcity_search_venue_results' ) );            
        }

        public static function weddingcity_listing_search_script(){

            if(     (
                        is_page_template( 'user-template/search-listing.php' )      ||
                        is_page_template( 'user-template/right-side-listing.php' )  ||
                        is_page_template( 'user-template/left-side-listing.php' )   ||
                        is_page_template( 'user-template/top-side-listing.php' )     
                    )
            ){

                wp_enqueue_style( 'weddingcity-listing-search', plugin_dir_url( __FILE__ ).'style.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

                wp_enqueue_script( 'weddingcity-listing-search', plugin_dir_url( __FILE__ ).'script.js', array( 'jquery', 'review', 'google-map' ), WEDDINGCITY_PLUGIN_VERSION, true );
            }
        }

        public static function number_of_request_quote_for_listing(){ 

            $args = array(

                    'post_type'         => 'listing',

                    'post_status'       =>  array( 'publish', 'pending' ),

                    'posts_per_page'    =>  -1,

                    'orderby'           => 'menu_order ID',

                    'order'             => 'post_date',

                    'author'            => WeddingCity_User::author_id() 
            );

            $item = new WP_Query( $args );

            $_requests = absint( '0' );

            if( $item->have_posts() ){

                while ( $item->have_posts() ){  $item->the_post();

                    $_data = WeddingCity_Listing_Meta:: listing_request( get_the_ID() );

                    if( WeddingCity_Loader:: array_condition( $_data ) ){

                        $_requests += count( $_data );
                    }
                }

                wp_reset_postdata();
            }

            return absint( $_requests );
        }

        public static function weddingcity_search_venue_results(){

                $meta_query = array();

                $category_type_array = $location_type_array = $vendor_find = '';

                if( isset( $_POST['listing-category'] ) && $_POST['listing-category'] != '0' && !empty( $_POST['listing-category'] ) ){

                    $vendor_find = array(

                        'taxonomy'  => WeddingCity_Texonomy:: listing_category_taxonomy(),
                        'field'     => 'id',
                        'terms'     => absint ( $_POST['listing-category'] )
                    );
                }
                
                if( isset( $_POST['listing_category_id'] ) && $_POST['listing_category_id'] != '0' && !empty( $_POST['listing_category_id'] ) ){

                    $category_type_array = array(

                        'taxonomy'  => WeddingCity_Texonomy:: listing_category_taxonomy(),
                        'field'     => 'id',
                        'terms'     => absint ( $_POST['listing_category_id'] )
                    );
                }

                if( isset( $_POST['listing-city'] ) && $_POST['listing-city'] != '0' && !empty( $_POST['listing-city'] ) ){

                    $location_type_array = array(

                        'taxonomy'  => WeddingCity_Texonomy:: listing_location_taxonomy(),
                        'field'     => 'id',
                        'terms'     => absint ( $_POST['listing-city'] )
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

                $_featured_listing_only     =   array( 

                    'post_type'             =>  'listing',
                    'post_status'           =>  'publish',
                    'posts_per_page'        =>  -1,
                    'orderby'               =>  'meta_value menu_order ID',
                    'meta_key'              =>  WeddingCity_Listing_Meta:: is_featured_listing_meta_name(),
                    'meta_value'            =>  'on',
                    'meta_query'            =>  $meta_query,
                    'fields'                =>  'ids',
                    'order'                 =>  'post_date',
                    'tax_query'             =>  array(
                        
                            'relation'      =>  'AND',
                            $vendor_find,
                            $category_type_array,
                            $location_type_array,
                    ),
                );


                $_all_post              =   array( 

                    'post_type'         =>  'listing',
                    'post_status'       =>  'publish',
                    'posts_per_page'    =>  -1,
                    'orderby'           =>  'meta_value menu_order ID',
                    'meta_query'        =>  $meta_query,
                    'fields'            =>  'ids',
                    'order'             =>  'post_date',
                    'tax_query'         =>  array(
                    
                            'relation'  =>  'AND',
                            $vendor_find,
                            $category_type_array,
                            $location_type_array,
                    ),
                );


                /**
                 *  @link https://wordpress.stackexchange.com/questions/166029/get-post-ids-from-wp-query#answer-166034
                 *
                 *  How to get post ids.
                 */
                
                $_featured_post_args    =   new WP_Query( $_featured_listing_only );

                $_all_post_args         =   new WP_Query( $_all_post );


                /**
                 *  @link https://wordpress.stackexchange.com/questions/215511/how-to-list-some-posts-first-in-the-loop-based-on-post-id#answer-215526
                 *
                 *  Specific post display first support link
                 */
                $args                   =   array( 

                    'post_type'         =>  'listing',
                    'post_status'       =>  'publish',
                    'posts_per_page'    =>  -1,
                    'orderby'           =>  'post__in',
                    'post__in'          =>  array_unique( array_merge( $_featured_post_args->posts, $_all_post_args->posts ) )
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

                if( WeddingCity_Loader:: array_condition( $get_html ) ){

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

            $_texonomy_ids = wp_get_post_terms( absint( $_post_id ), WeddingCity_Texonomy:: listing_location_taxonomy(), array( 'fields' => 'ids', 'orderby' => 'parent', 'order' => 'desc' ) );

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

        public static function listing_price_currency_possition( $_post_id ){

            if( empty( $_post_id ) )
                return;

            global $post, $wp_query;

            $_possition = weddingcity_option( '_currencty_possition_' );

            if( $_possition == 'right' ){

                return

                sprintf(   '<div class="vendor-price-block">
                                <span class="vendor-price">%1$s<sup>%3$s</sup></span>
                                <span class="vendor-text">%2$s</span>
                            </div>',

                            // 1
                            WeddingCity_Listing_Meta:: listing_price( $_post_id ),

                            // 2
                            esc_html__( 'Start From', 'weddingcity' ),

                            // 3
                            ( weddingcity_option( 'listing_currency_sign' ) != '' )

                            ? esc_html( weddingcity_option( 'listing_currency_sign' ) )

                            : esc_html__( '$', 'weddingcity' )
                );

            }else{

                return

                sprintf(   '<div class="vendor-price-block">
                                <span class="vendor-price"><sup>%3$s</sup>%1$s</span>
                                <span class="vendor-text">%2$s</span>
                            </div>',

                            // 1
                            WeddingCity_Listing_Meta:: listing_price( $_post_id ),

                            // 2
                            esc_html__( 'Start From', 'weddingcity' ),

                            // 3
                            ( weddingcity_option( 'listing_currency_sign' ) != '' )

                            ? esc_html( weddingcity_option( 'listing_currency_sign' ) )

                            : esc_html__( '$', 'weddingcity' )
                );
            }
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
                                            %4$s <!-- wishlist -->
                                            <div class="listing-categories">
                                                <div class="vendor-category"><a href="%15$s"><i class="%14$s"></i></a></div>
                                            </div>
                                            %7$s 
                                        </div>

                                        %13$s

                                        <div class="vendor-content">
                                            <h2 class="vendor-title"><a href="%1$s" class="title">%3$s</a></h2>

                                            %5$s

                                            %9$s
                                        </div>

                                        <div class="vendor-meta">%8$s</div>

                                    </div>
                                </div>',

                                /**
                                 *  1. Permalink Structure
                                 *
                                 *  @param Get the Listing Single Page Link
                                 */
                                esc_url( get_the_permalink() ),


                                // 2
                                ( get_the_post_thumbnail_url( get_the_ID(), 'weddingcity_vendor_gallery_360x210' ) != '' )

                                ? get_the_post_thumbnail_url( get_the_ID(), 'weddingcity_vendor_gallery_360x210' )

                                : esc_url( WEDDINGCITY_PLUGIN_IMAGE .'listing-thumb.jpg' ),


                                // 3
                                esc_html( get_the_title() ),


                                /**
                                 *  
                                 *  4. Get Wishlist Icon
                                 *
                                 *  WeddingCity Wishlist plugin exists after this features are working
                                 *
                                 *  @param [integer] $[get_the_ID] [get the wishlist for this listing]
                                 * 
                                 */
                                (  class_exists( 'WeddingCity_Couple_Wishlist' )  )

                                ?   WeddingCity_Couple_Wishlist:: weddingcity_wishlist( get_the_ID() ) : '',


                                // 5
                                self:: listing_location_textonomy( get_the_ID() ),

                                // WeddingCity_Texonomy:: weddingcity_get_term_name( WeddingCity_Texonomy:: listing_location_taxonomy(), 

                                //     // 1
                                //     WeddingCity_Listing_Meta:: listing_city( get_the_ID() ),

                                //     // 2
                                //     'name' 
                                // ),

                                // 6
                                '',
                                // WeddingCity_Texonomy:: weddingcity_get_term_name( WeddingCity_Texonomy:: listing_location_taxonomy(),

                                //     // 1
                                //     WeddingCity_Listing_Meta:: listing_state( get_the_ID() ),

                                //     // 2
                                //     'name' 
                                // ),

                                // 7
                                ( WeddingCity_Listing_Meta:: listing_price( get_the_ID() ) != ''
                                    && WeddingCity_Listing_Meta:: listing_price( get_the_ID() ) != '0'
                                )

                                ?   self:: listing_price_currency_possition( get_the_ID() )
                                        
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

                                /**
                                 *  
                                 *  9. Get Listing Reviews
                                 *
                                 *  WeddingCity Review plugin exists after call for avarage review with listing id
                                 *
                                 *  @param [integer] $[get_the_ID] [get the avarage review of this listing]
                                 * 
                                 */
                                
                                ( class_exists( 'WeddingCity_Listing_Reviews' ) )

                                ?  WeddingCity_Listing_Reviews:: listing_box_average_review( get_the_ID() ) :  '',


                                // 10
                                ( isset( $_POST['column'] ) && $_POST['column'] != '' )

                                ? self:: listing_column( $_POST['column'] ) 

                                : '',

                                // 11
                                sprintf( 'WeddingCity_listing__%1$s', get_the_ID() ),


                                // 12
                                self:: listing_map_attributes( get_the_ID() ),

                                /**
                                 *  13. Is Featured Listing ?
                                 */
                                self:: listing_post_is_featured( get_the_ID() ),

                                // 14
                                WeddingCity_Texonomy:: get_taxonomy_icon( 

                                    // post id
                                    get_the_ID(), 

                                    // listing category
                                    WeddingCity_Texonomy:: listing_category_taxonomy() 
                                ),
                                
                                /**
                                 *  15. Get Taxonomy Link
                                 */
                                WeddingCity_Texonomy:: get_taxonomy_singular_link( 

                                    // post id
                                    get_the_ID(), 

                                    // listing category
                                    WeddingCity_Texonomy:: listing_category_taxonomy() 
                                )


                    ); // sprintf ending..

                }   wp_reset_postdata();
            }

            return $_get_data;
        }

        public static function listing_post_is_featured( $_post_id ){

            if( empty( $_post_id ) )
                return;

            if( get_post_meta( get_the_ID(), 'is_featured_listing', true ) == 'on' ){

                    return 

                    sprintf( '<div class="listing-badge"><div class="badge badge-success">%1$s</div></div>',  

                        // 1
                        esc_html__( 'Featured', 'weddingcity' )

                    );
            }
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
                        <input type="hidden" value="%8$s" class="listing_category_icon"     />
                    </div>',

                // 1
                WeddingCity_Listing_Meta:: listing_latitude( $_post_id ),

                // 2
                WeddingCity_Listing_Meta:: listing_longitude( $_post_id ),

                // 3
                ( get_the_post_thumbnail_url( $_post_id, 'weddingcity_vendor_gallery_360x210' ) != '' )

                ? get_the_post_thumbnail_url( $_post_id, 'weddingcity_vendor_gallery_360x210' )

                : esc_url( WEDDINGCITY_PLUGIN_IMAGE .'listing-thumb.jpg' ),

                // 4
                get_the_title( $_post_id ),

                // 5
                WeddingCity_Listing_Meta:: listing_map_address( $_post_id ),

                // 6
                get_the_permalink( $_post_id ),

                // 7
                weddingcity_option( 'google_map_icon' ),

                // 8 
                self:: get_category_marker( $_post_id )

            );
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

            if( isset( $_GET['listing-category'] ) ){

                return

                sprintf(   '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"><select class="wide" name="listing-category" id="listing-category">%1$s</select></div>',

                            // 1
                            WeddingCity_Texonomy:: create_select_option(

                                $get_parents = WeddingCity_Texonomy:: get_texonomy_parent( WeddingCity_Texonomy:: listing_category_taxonomy() ), 

                                $label = array( '0' => esc_html__('Select Category','weddingcity') ), 

                                $default_select = absint( $_GET['listing-category'] ),

                                $print = false
                            )
                );

            }else{

                return

                sprintf(   '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"><select class="wide" name="listing-category" id="listing-category">%1$s</select></div>',


                            WeddingCity_Texonomy:: create_select_option(

                                    WeddingCity_Texonomy:: get_texonomy( WeddingCity_Texonomy:: listing_category_taxonomy() ), 

                                    array( '0' => esc_html__( 'Select Category', 'weddingcity' ) )
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

                                                      WeddingCity_Texonomy:: listing_category_taxonomy(), 

                                                        ( absint( $_GET['venue_id'] ) ) ? 
                                                              absint( $_GET['venue_id'] )
                                                                : absint('0') 
                                                    ), 

                                    $label = array( '0' => esc_html__( 'Listing Type', 'weddingcity' ) ), 

                                    $default_select = absint( $_GET['listing_category_id'] ),

                                    $print = false
                            )
                );
            }
        }

        public static function get_listing_location(){

            if( isset( $_GET['listing-city'] ) ||  isset( $_GET['listing-state'] )  ){

                return

                sprintf(   '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <select class="wide" name="listing-city" id="listing-city">%1$s</select>
                            </div>',

                            // 2
                            WeddingCity_Texonomy:: create_select_option(

                                    WeddingCity_Texonomy:: get_texonomy_child( 

                                                  WeddingCity_Texonomy:: listing_location_taxonomy(),

                                                  ( $_GET['listing-city'] != '' && $_GET['listing-city'] != '0' )

                                                  ? WeddingCity_Texonomy:: weddingcity_get_term_name( WeddingCity_Texonomy:: listing_location_taxonomy(), absint( $_GET['listing-city'] ), 'parent' )

                                                  : absint( $_GET['listing-state'] )

                                    ), 

                                    array( '0' => esc_html__('Select Location', 'weddingcity' ) ),

                                    ( $_GET['listing-city'] != '' && $_GET['listing-city'] != '0' ) 

                                    ?  absint( $_GET['listing-city'] )

                                    :  absint( $_GET['listing-city'] ),

                                    false
                            )
                );

            }else{


                return

                sprintf(   '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <select class="wide" name="listing-city" id="listing-city">%1$s</select>
                            </div>',

                            // 1
                            WeddingCity_Texonomy:: create_select_option(

                                    WeddingCity_Texonomy:: get_texonomy(  WeddingCity_Texonomy:: listing_location_taxonomy() ), 

                                    array( '0' => esc_html__('Select Location', 'weddingcity' ) )
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

        public static function weddingcity_map_warning(){

            if( ! WEDDINGCITY_PLUGIN_DEV_ON ){

                $_warning = '';

                $_API = weddingcity_option( 'google_map_api_key_here' );

                if( empty( $_API ) ){

                    $_warning = sprintf('<h3 class="text-center">Please insert the Google Map API key after this page is working..</h3>' );
                }

                return $_warning;
            }
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
                                        <div class="row" id="listing_search_result">%2$s</div>
                                </div>
                            </div>',

                            // 1
                            self::get_listing_filter_options(),

                            // 2
                            self:: weddingcity_map_warning()
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
                                <div id="listing_map" class="right_listing">%2$s</div>
                            </div>
                        </div>',

                        // 1
                        self::get_listing_filter_options(),

                        // 2
                        self:: weddingcity_map_warning()
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
                                <div class="row scroll-content" id="listing_search_result">%2$s</div>
                            </div>
                        </div>',

                        // 1
                        self::get_listing_filter_options(),

                        // 2
                        self:: weddingcity_map_warning()
                );

                self::weddingcity_listing_template_after();
            }
        }

        public static function weddingcity_find_listing_markup(){

            self:: weddingcity_top_map_listing_markup();

            self:: weddingcity_right_map_listing_markup();

            self:: weddingcity_left_map_listing_markup();
        }
    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Search_Listing::get_instance();
}
