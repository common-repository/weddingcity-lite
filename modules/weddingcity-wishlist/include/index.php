<?php

/**
 *  WeddingCity Listing Requests
 */

if( ! class_exists( 'WeddingCity_Couple_Wishlist' ) ){

    /**
     *  WeddingCity Listing Requests
     */
    class WeddingCity_Couple_Wishlist extends WeddingCity_User{

        /**
         * Member Variable
         *
         * @var instance
         */
        private static $instance;

        /**
         * Member Variable
         *
         * @var instance
         */
        private static $counter;


        /**
         * Member Variable
         *
         * @var instance
         */
        private static $tab_counter;

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

            add_action( 'weddingcity_couple_wishlist', array( $this, 'weddingcity_couple_wishlist_markup' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'weddingcity_listing_request_script' ) );

            add_action( 'wp_ajax_weddingcity_add_wishlist',  array( $this, 'weddingcity_add_wishlist' ) );

            add_action( 'wp_ajax_nopriv_weddingcity_add_wishlist', array( $this, 'weddingcity_add_wishlist' ) );

            add_action( 'wp_ajax_weddingcity_remove_wishlist',  array( $this, 'weddingcity_remove_wishlist' ) );

            add_action( 'wp_ajax_nopriv_weddingcity_remove_wishlist', array( $this, 'weddingcity_remove_wishlist' ) );

            self:: weddingcity_wishlist_sammary();

            self:: weddingcity_dashboard_menu();
        }

        public static function weddingcity_wishlist_sammary(){

            add_filter( 'weddingcity_couple_dashboard_summary',

                function ( $args ){

                    return array_merge( $args, array(

                            array(

                                  // 1
                                  'title'     =>  esc_html__( 'Vendors Wishlist', 'weddingcity' ),

                                  // 2
                                  'counter'   =>  absint( self:: number_of_wishlist() ),

                                  // 3
                                  'overview'  =>  esc_html__( 'Compare &amp; Finalize', 'weddingcity' ),

                                  // 4
                                  'btn_link'  =>  esc_url( WeddingCity_Couple_Menu:: wishlist_page() ),

                                  // 5
                                  'btn_text'  =>  esc_html__( 'View All', 'weddingcity' )
                            )
                    )  );
                },

                absint( '10' )
            );
        }

        public static function weddingcity_dashboard_menu(){

            add_filter( 'weddingcity_couple_dashboard_menu',

                function ( $args ){

                    return array_merge( $args, array(

                            'wishlist'          => array(

                                'menu_show'     =>  true,

                                'menu_name'     =>  esc_html__( 'My Wishlist', 'weddingcity' ),

                                'menu_icon'     =>  'fas fa-heart',

                                'menu_active'   =>  ( $_REQUEST['dashboard'] == 'couple-wishlist' )   ?   esc_html( 'active' )  :  '',

                                'menu_link'     =>  esc_url(

                                                        add_query_arg( array(

                                                          'dashboard' => esc_html( 'couple-wishlist' )

                                                        ), WeddingCity_Template:: couple_dashboard_template() )
                                                    ),
                            ),
                    )  );
                },

                absint( '10' )
            );
        }

        public static function weddingcity_listing_request_script(){

            global $post, $wp_query;

            if(   

                  (   isset( $_GET['dashboard'] ) && !empty( $_GET['dashboard'] ) && $_GET['dashboard'] == 'couple-wishlist' ) ||

                  (   is_singular( 'listing' )  ) ||

                  (   is_page_template( 'user-template/search-listing.php' )      ||
                      is_page_template( 'user-template/right-side-listing.php' )  ||
                      is_page_template( 'user-template/left-side-listing.php' )   ||
                      is_page_template( 'user-template/top-side-listing.php' )     
                  )

                  ||

                  ( is_front_page() || is_tax( WeddingCity_Texonomy:: listing_category_taxonomy() )  || is_tax( WeddingCity_Texonomy:: listing_location_taxonomy()  )  )

            ){

                wp_enqueue_style( 'weddingcity-couple-wishlist', plugin_dir_url( __FILE__ ).'style.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

                wp_enqueue_script( 'weddingcity-couple-wishlist', plugin_dir_url( __FILE__ ).'script.js', array('jquery'), WEDDINGCITY_PLUGIN_VERSION, true );
            }
        }

        public static function weddingcity_couple_wishlist_markup(){

            self:: weddingcity_couple_wishlist_page_title_markup();

            self:: weddingcity_couple_wishlist_content();
        }

        public static function page_title(){

            return esc_html__( 'My Wishlist', 'weddingcity' );
        }

        public static function page_description(){

            return  esc_html__( 'The wishlist is great way to keep track your wedding vendor and their service availablity in your wishlist board.', 'weddingcity' );
        }

        public static function weddingcity_couple_wishlist_page_title_markup(){

            WeddingCity_Dashboard:: dashboard_page_header(

                    // 1
                    self:: page_title(),

                    // 2
                    self:: page_description()
            );
        }

        public static function get_vendor_texonomy( $args ){

            $_listing_ids = $_listing_category = array();

            $_get_data    = WeddingCity_Wishlist_Meta:: weddingcity_wishlist();

            $_create_new_array = array();

            if( WeddingCity_Loader:: array_condition( $_get_data ) ){

                  foreach ( $_get_data as $key => $value) {

                        $_listing_category[]  = $value[ WeddingCity_Wishlist_Meta:: weddingcity_listing_category_id_meta_name() ];
                        
                        $_listing_ids[]       = $value[ WeddingCity_Wishlist_Meta:: weddingcity_listing_id_meta_name() ];
                  }
            }

            if( $args == 'listing_category' ){

                return array_unique( $_listing_category );
            }

            if( $args == 'listing_ids' ){

                return array_unique( $_listing_ids );
            }
        }

        public static function vendor_texonomy_tabs(){

            $_listing_category = self:: get_vendor_texonomy( 'listing_category' );

            if( WeddingCity_Loader:: array_condition( $_listing_category ) ){

                ?><ul class="nav nav-pills" id="mywishlist-tab" role="tablist"><?php

                foreach( $_listing_category as $key => $value ){

                    if( isset( $value ) && ! empty( $value ) ){

                        printf('<li class="nav-item">
                                    <a class="nav-link %2$s" id="wishlist_%3$s" data-toggle="tab" href="#wishlist_link_%3$s" role="tab" aria-controls="venue" aria-selected="true">%1$s</a>
                                </li>',
                                  
                                  // 1,
                                  get_term( absint( $value ), WeddingCity_Texonomy:: listing_category_taxonomy() )->name,

                                  // 2
                                  ( $counter == absint('0') ) ? sanitize_html_class( 'active' ) : '',

                                  // 3
                                  $key
                        );

                        $counter++;
                    }
                }

                ?></ul><?php
            }
        }

        public static function vendor_texonomy_tab_content(){

            $_listing_category = self:: get_vendor_texonomy( 'listing_category' );

            $_listing_ids = self:: get_vendor_texonomy( 'listing_ids' );

            $_get_data    = WeddingCity_Wishlist_Meta:: weddingcity_wishlist();

            if( WeddingCity_Loader:: array_condition( $_listing_category ) ){

                ?><div class="tab-content" id="mywishlist-tab"><?php

                foreach( $_listing_category as $_category_key => $_category_id ){

                    if( isset( $_category_id ) && ! empty( $_category_id ) ){

                        printf( '<div class="tab-pane fade %1$s" id="wishlist_link_%2$s" role="tabpanel" aria-labelledby="%2$s-tab"><div class="wishlist-tab-board row">', 
                                  ( $tab_counter == absint('0') ) ? 'active show' : '',
                                    $_category_key
                        );

                          foreach( $_get_data as $_key => $_listing_id ){

                              if( $_listing_id[ WeddingCity_Wishlist_Meta:: weddingcity_listing_category_id_meta_name() ] == $_category_id ){

                                  print '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">';

                                      WeddingCity_Listing:: weddingcity_listing_e( $_listing_id[ WeddingCity_Wishlist_Meta:: weddingcity_listing_id_meta_name() ] );

                                  print '</div>';
                              }
                          }

                        print '</div></div>';

                        $tab_counter++;
                    }
                }

                ?></div><?php
            }
        }

        public static function weddingcity_couple_wishlist_content(){

            self:: vendor_texonomy_tabs();

            self:: vendor_texonomy_tab_content();
        }

        public static function weddingcity_add_wishlist(){

            if( ! is_user_logged_in() ){

                die( json_encode( array(

                    'redirect'  =>  true,

                    'notice'    =>  absint('2'),

                    'dashboard' =>  WeddingCity_Template:: couple_login_template(),

                    'message'   =>  esc_html__( 'You must be login then you can wishlist for this listing.', 'weddingcity' )

                ) ) );
            }

            global $current_user, $post, $wp_query;
          
            if( isset( $_POST[ 'listing_id' ] ) && WeddingCity_User_Meta::is_couple()  ){

                  $_listing_post_id   = absint( $_POST[ 'listing_id' ] );

                  $_get_data          = WeddingCity_Wishlist_Meta:: weddingcity_wishlist();

                  $_vendor_id         = get_post_meta( $_listing_post_id, WeddingCity_Listing_Meta:: listing_vendor_meta_name(), true );

                  $_listing_category  = array_values(

                                            wp_get_post_terms( 

                                              $_listing_post_id, 

                                              WeddingCity_Texonomy:: listing_category_taxonomy(), 

                                              array( "fields" => "ids" )

                                            )

                                        )[ 0 ];

                  $new_request_list     =   array();

                  $request_array        =   array( array(

                          'title'                     => sprintf(   esc_html__( 'Wishlist for : %1$s', 'weddingcity' ), 

                                                                    // 1
                                                                    get_the_title( $_listing_post_id )
                                                          ),

                          'wishlist_listing_category' => absint( $_listing_category ),

                          'wishlist_listing_id'       => absint( $_listing_post_id ),

                          'wishlist_vendor_id'        => absint( $_vendor_id ),

                          'wishlist_unique_id'        => rand(),

                          'wishlist_timestrap'        => date( 'now' ),
                  ) );

                  $request_list_array   = get_post_meta( parent:: post_id(), WeddingCity_Wishlist_Meta:: weddingcity_wishlist_meta_name(), true );

                  if( $request_list_array != '' && is_array( $request_list_array ) ){

                      foreach ( $request_list_array as $key => $value) {
                        
                          if( $value[ WeddingCity_Wishlist_Meta:: weddingcity_listing_id_meta_name() ] == $_listing_post_id ){

                              die( json_encode( array(

                                  'redirect'  =>  false,

                                  'notice'    =>  absint('2'),

                                  'message'   =>  esc_html__( 'Already Wishlist!', 'weddingcity' )

                              ) ) );
                          }
                      }

                      $new_request_list  =  array_merge_recursive( $request_list_array, $request_array );       

                  }else{

                      $new_request_list  =  $request_array;
                  }

                  update_post_meta( parent:: post_id(), WeddingCity_Wishlist_Meta:: weddingcity_wishlist_meta_name(), $new_request_list );


                  die( json_encode( array(

                      'redirect'  =>  false,

                      'notice'    =>  absint('1'),

                      'message'   =>  esc_html__( 'Wishlist Added!', 'weddingcity' )

                  ) ) );
            }
        }

        public static function weddingcity_remove_wishlist(){

            global $current_user, $post, $wp_query;

            if( ! is_user_logged_in() ){

                  die( json_encode( array(

                      'redirect'    =>  true,

                      'notice'      =>  '2',

                      'dashboard'   =>  WeddingCity_Template:: couple_login_template(),

                      'message'     =>  esc_html__( 'You must be login then you can wishlist for this venue.', 'weddingcity' )
                    
                  ) ) );
            }
            
            if( isset( $_POST[ 'listing_id' ] ) && WeddingCity_User_Meta::is_couple()  ){

                $_listing_post_id   =   absint( $_POST[ 'listing_id' ] );

                /**
                 *  Wishlist removed in group
                 */

                $get_data   = get_post_meta( parent:: post_id(), WeddingCity_Wishlist_Meta:: weddingcity_wishlist_meta_name(), true );

                foreach ( $get_data as $key => $value) {
                  
                    if( $value[ WeddingCity_Wishlist_Meta:: weddingcity_listing_id_meta_name() ] == $_listing_post_id ){

                        unset( $get_data[ $key ] );

                        update_post_meta( parent:: post_id(), WeddingCity_Wishlist_Meta:: weddingcity_wishlist_meta_name(), $get_data );
                    }
                }

                die( json_encode( array(

                    'redirect'  =>  false,

                    'notice'    =>  absint('2'),

                    'message'   =>  esc_html__( 'Wishlist Removed!.', 'weddingcity' )

                ) ) );
            }
        }

        public static function number_of_wishlist_e() {

            echo self:: number_of_wishlist();
        }

        public static function number_of_wishlist() {

            $get_wishlist = WeddingCity_Wishlist_Meta:: weddingcity_wishlist();

            if(  WeddingCity_Loader:: array_condition( $get_wishlist )  ) {

                  return count( $get_wishlist );
            }

            return absint( '0' );
        }

        /**
         * 
         * [weddingcity_wishlist description]
         * 
         * @param  [ listing_id ] $_listing_post_id [ couple wishlist ]
         * 
         * @return [ integer ] [ listin box page wishlist icon button ]
         * 
         */
        public static function weddingcity_wishlist( $_listing_post_id ){

              global $post, $wp_query, $current_user;

              if( $_listing_post_id == '' ) return;

              if( ! is_user_logged_in() || WeddingCity_User:: is_couple() ){

                    $get_wishlist = WeddingCity_Wishlist_Meta:: weddingcity_wishlist();

                    $_in_wishlist_ = false;

                    if( WeddingCity_Loader:: array_condition( $get_wishlist ) ){

                        foreach ( $get_wishlist as $key => $value) {
                          
                            if( $value[ WeddingCity_Wishlist_Meta:: weddingcity_listing_id_meta_name() ] == $_listing_post_id ){

                                $_in_wishlist_ = true;
                            }
                        }
                    }

                    if( $_in_wishlist_ ){

                        return

                        sprintf( '<div class="wishlist-sign">
                                      <a href="javascript:" data-wishlist="%1$s" class="remove-wishlist"><i class="fas fa-times"></i></a>
                                  </div>', 

                                  // 1
                                  $_listing_post_id
                        );

                    }else{

                        return

                        sprintf( '<div class="wishlist-sign">
                                      <a href="javascript:" data-wishlist="%1$s" class="btn-wishlist"><i class="fa fa-heart"></i></a>
                                  </div>', 

                                  // 1
                                  $_listing_post_id  
                        );
                    }
                
              }else{

                  return

                  sprintf( '<div class="wishlist-sign">
                              <a href="javascript:" data-wishlist="%1$s" class="btn-wishlist disabled" role="button" aria-disabled="true">
                                  <i class="fa fa-heart"></i>
                              </a>
                            </div>', 

                            // 1
                            $_listing_post_id 
                  );
              }
        }

        /** 
         * 
         * [weddingcity_wishlist_singular_page description]
         * 
         * @param  [ listing_id ] $_listing_post_id [ couple wishlist ]
         * 
         * @return [ integer ] [ listin single page wishlist button ]
         * 
         */
        public static function weddingcity_wishlist_singular_page( $_listing_post_id ){

            global $post, $wp_query, $current_user;

            if( $_listing_post_id == '' ) return;

            if( ! is_user_logged_in() || WeddingCity_User_Meta:: is_couple() ){

                $get_wishlist   = WeddingCity_Wishlist_Meta:: weddingcity_wishlist();

                $_in_wishlist_  = false;

                if( WeddingCity_Loader:: array_condition( $get_wishlist ) ){

                      foreach ( $get_wishlist as $key => $value) {
                          
                          if( $value[ WeddingCity_Wishlist_Meta:: weddingcity_listing_id_meta_name() ] == $_listing_post_id ){

                              $_in_wishlist_ = true;

                          }
                      }

                      /**
                       *  Is in wishlist ?
                       */
                      if( $_in_wishlist_ ){

                          return

                          sprintf( '<a href="javascript:" data-wishlist="%2$s" class="remove-wishlist-single"><i class="fa fa-heart"></i> 
                                        <span class="pl-1" id="single-wishlist-content" >%1$s</span>
                                    </a>',

                                    // 1
                                    esc_html__( 'Already Added', 'weddingcity' ),

                                    // 2
                                    $_listing_post_id
                          );

                      }else{

                            return

                            sprintf( '<a href="javascript:" data-wishlist="%2$s" class="btn-default-wishlist"><i class="fa fa-heart"></i> 
                                          <span id="single-wishlist-content" class="pl-1">%1$s</span>
                                      </a>',

                                      // 1
                                      esc_html__( 'Add To Wishlist', 'weddingcity' ),

                                      // 2
                                      $_listing_post_id
                            );
                      }

                }else{

                    return

                    sprintf( '<a href="javascript:" data-wishlist="%2$s" class="btn-default-wishlist"><i class="fa fa-heart"></i> 
                                  <span id="single-wishlist-content" class="pl-1">%1$s</span>
                              </a>',

                              // 1
                              esc_html__( 'Add To Wishlist', 'weddingcity' ),

                              // 2
                              $_listing_post_id
                    );
                }
            }else{

                  return

                  sprintf( '<a href="javascript:" data-wishlist="%2$s" class="btn-default-wishlist disabled"><i class="fa fa-heart"></i> 
                                <span id="single-wishlist-content" class="pl-1">%1$s</span>
                            </a>',

                            // 1
                            esc_html__( 'Add To Wishlist', 'weddingcity' ),

                            // 2
                            $_listing_post_id
                  );
            }
        }

      } // class ending

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Couple_Wishlist:: get_instance();
}

