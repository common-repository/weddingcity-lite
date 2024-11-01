<?php

/**
 *  WeddingCity Script / Styles
 */

if( ! class_exists( 'WeddingCity_Plugin_Scripts' ) ){
	
	class WeddingCity_Plugin_Scripts {

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

			add_action( 'wp_enqueue_scripts', array( $this, 'weddingcity_plugin_script' ) );

            add_action( 'init', array( $this, 'weddingcity_ajax_localize_script' ) );
        }

        public static function weddingcity_ajax_localize_script(){

            /**
             *  @link https://developer.wordpress.org/reference/functions/wp_localize_script/#comment-content-1391
             */

            wp_enqueue_script( 'WeddingCity_AJAX', plugin_dir_url( __FILE__ ).'script.js', array('jquery'), null, true );

            wp_localize_script( 'WeddingCity_AJAX', 'WeddingCity_AJAX_OBJECT',

                        array_merge(

                            /**
                             *  1. General Settings
                             */
                            array(

                                'ajaxurl'                   =>  admin_url( 'admin-ajax.php' ),

                                'home_url'                  =>  home_url('/'),

                                'map_icon'                  =>  WeddingCity_Options:: _map_icon(),

                                'map_marker'                =>  WeddingCity_Options:: _map_cluster(),

                                'close_icon'                =>  WeddingCity_Options:: _map_infobox_close(),

                                'ajax_loading'              =>  WeddingCity_Alert:: ajax_loading(),

                                'weddingcity_latitude'      =>  WeddingCity_Options:: _map_latitude(),

                                'weddingcity_longitude'     =>  WeddingCity_Options:: _map_longitude(),

                                'paypal_currency_code'      =>  WeddingCity_Options:: _paypal_currency_code(),

                                'strip_currency_code'       =>  WeddingCity_Options:: _strip_currency_code()
                            ),

                            /**
                             *. Stripe Payment Getway options
                             */
                            ( class_exists( 'WeddingCity_Stripe_Payment_Getway' ) )

                            ?   WeddingCity_Stripe_Payment_Getway:: weddingcity_stripe_payment_keys()

                            :   array()
                        )
            );

            /**
             *  Script Strings Translation Process....
             */
            wp_localize_script( 'WeddingCity_AJAX', 'WeddingCity_Translation_Strings',

                    /**
                     *  Couple Wedding Countdown
                     */
                    array(

                        'wedding_days'          =>  esc_attr__( 'Days'          ,'weddingcity' ),
                        'wedding_hours'         =>  esc_attr__( 'Hours'         ,'weddingcity' ),
                        'wedding_min'           =>  esc_attr__( 'Minutes'       ,'weddingcity' ),
                        'wedding_sec'           =>  esc_attr__( 'Seconds'       ,'weddingcity' ),
                        'happy_wedding_msg'     =>  esc_attr__( 'Happy Wedding..' ,'weddingcity' ),
                    )
            );
        }

        public static function weddingcity_plugin_script(){

            global $post, $wp_query, $page;

	        if(	is_user_logged_in() && ( WeddingCity_User_Meta:: is_vendor() || WeddingCity_User_Meta:: is_couple() ) ){

	        	if( isset( $_GET['dashboard'] ) && !empty( $_GET['dashboard'] ) ){

	        		if(  $_GET['dashboard'] == 'couple-todo-list' || $_GET['dashboard'] == 'couple-budget'  ){

	        			self::slide_reveal_scripts();
	        		}

	        		if(  $_GET['dashboard'] == 'couple-todo-list' || $_GET['dashboard'] == 'couple-profile' || $_GET['dashboard'] == 'real-wedding'  ){

						self::date_picker_scripts();
					}

					if(  $_GET['dashboard'] == 'couple-guestlist'  ){

						self::data_table_script();
					}

					if( $_GET['dashboard'] == 'wedding-website' ){

						self::clipboard_script();
					}

					if(  $_GET['dashboard'] == 'real-wedding'  ){

						self::select2_script();
					}

					if( $_GET['dashboard'] == 'couple-profile'   || 
						$_GET['dashboard'] == 'vendor-profile' 	 || 
						$_GET['dashboard'] == 'real-wedding'  	 ||
						$_GET['dashboard'] == 'add-listing'  	 ||
						$_GET['dashboard'] == 'update-listing'   ){

						self::summery_editor_script();
					}

                    if(  $_GET['dashboard'] == 'update-listing' || $_GET['dashboard'] == 'add-listing'  ){

                        self::listing_map_scripts();
                    }
	        	}
			}

            /**
             *  Listing Search Templates scripts..
             */
            if(     is_page_template( 'user-template/search-listing.php' )      || 
                    is_page_template( 'user-template/right-side-listing.php' )  ||


                    is_page_template( 'user-template/listing-category.php' )  ||
                    is_page_template( 'user-template/listing-location.php' )  ||

                    is_page_template( 'user-template/left-side-listing.php' )   ||
                    is_page_template( 'user-template/top-side-listing.php' )    ){

                    self::pagination_script();

                    self::listing_map_scripts();
            }

            if( is_page_template( 'user-template/couple-login-register.php' ) ||
                is_singular( 'listing' ) ||
                is_singular( 'vendor' )
            ){
                self::date_picker_scripts();
            }

            if( current_user_can('subscriber') ) {

                if( !( WeddingCity_User:: is_vendor() || WeddingCity_User:: is_couple() ) ){

                    self::date_picker_scripts();
                }
            }

            if( is_singular( 'listing' ) || is_singular( 'vendor' ) ){

                self::magnific_popup();
            }

            if( is_singular( 'listing' )                                    ||
                is_page_template( 'user-template/search-listing.php' )      || 
                is_page_template( 'user-template/right-side-listing.php' )  ||
                is_page_template( 'user-template/left-side-listing.php' )   ||
                is_page_template( 'user-template/listing-category.php' )    ||
                is_page_template( 'user-template/listing-location.php' )  ||
                is_page_template( 'user-template/top-side-listing.php' )    ||
                is_tax( WeddingCity_Texonomy:: listing_location_taxonomy() )        ||
                is_tax( WeddingCity_Texonomy:: listing_category_taxonomy()   )        ||

                        (   
                            is_a( $post, 'WP_Post' ) && 

                            (   has_shortcode( $post->post_content, 'listing' )             ||
                                has_shortcode( $post->post_content, 'weddingcity-listing' ) ||
                                has_shortcode( $post->post_content, 'testimonials' )        ||
                                has_shortcode( $post->post_content, 'elementor-widget-weddingcity-listing' )
                            )
                        )   
                ){

                    // bg video
                    self:: background_video();

                    // self::review_script();
                    self:: map_script();
            }

            if( is_singular( 'vendor' ) ){

                self:: map_script();
            }

            self:: flaticon();

            self:: fontello();

            self:: nice_select();

            self:: review_script();

            self:: map_script();

            self:: toastr();

            self:: slick();

            self:: weddingcity_custom_scripts();
        }

        public static function weddingcity_custom_scripts(){

            wp_enqueue_style( 'weddingcity-plugin-style', plugin_dir_url( __FILE__ ).'style.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

            wp_enqueue_script( 'weddingcity-plugin-script', plugin_dir_url( __FILE__ ).'script.js', array( 'jquery' ), WEDDINGCITY_PLUGIN_VERSION, false );
        }

        public static function map_script(){

            if( weddingcity_option( 'google_map_api_key_here' ) != '' || WEDDINGCITY_PLUGIN_DEV_ON ){

                if( WEDDINGCITY_PLUGIN_DEV_ON ){

                    $query_args = array(
                        'key'       => '',
                        'ver'       => absint( '1' ),
                        'libraries' => 'places',
                        'region'    => 'uk',
                        'language'  => 'en',
                        'sensor'    => 'true'
                    );

                    wp_enqueue_script( 'google-map', esc_url( add_query_arg( $query_args, 'https://maps.googleapis.com/maps/api/js' ) ), array('jquery'), WEDDINGCITY_PLUGIN_VERSION, true );  

                }else{

                    $query_args = array(
                        'key'       => weddingcity_option( 'google_map_api_key_here' ),
                        'libraries' => 'places',
                        'ver'       => absint( '1' ),
                        'region'    => 'uk',
                        'language'  => 'en',
                        'sensor'    => 'true'
                    );

                    wp_enqueue_script( 'google-map', esc_url( add_query_arg( $query_args, 'https://maps.googleapis.com/maps/api/js' ) ), array('jquery'), WEDDINGCITY_PLUGIN_VERSION, true );  
                }
            }
        }

        public static function listing_map_scripts(){

            if( weddingcity_option( 'google_map_api_key_here' ) != '' || WEDDINGCITY_PLUGIN_DEV_ON ){

                self:: map_script();

                if( is_page_template('user-template/search-listing.php') ){

                        wp_enqueue_script( "google-map-cluster", 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js', array('jquery'), WEDDINGCITY_PLUGIN_VERSION, true );
                }
            }

            if( weddingcity_option( 'google_map_api_key_here' ) != '' || WEDDINGCITY_PLUGIN_DEV_ON ){

                wp_enqueue_script( 'infowindow', esc_url( WEDDINGCITY_PLUGIN_LIBRARY . 'map/infobox.js' ), array( 'jquery', 'google-map' ), WEDDINGCITY_PLUGIN_VERSION, true );

                wp_enqueue_script( 'markerclusterer', esc_url( WEDDINGCITY_PLUGIN_LIBRARY . 'map/markerclusterer.js' ), array( 'jquery', 'google-map' ), WEDDINGCITY_PLUGIN_VERSION, true );

                wp_enqueue_script( 'map-infowindow', esc_url( WEDDINGCITY_PLUGIN_LIBRARY . 'map/google-map-script.js' ), array( 'jquery', 'google-map' ), WEDDINGCITY_PLUGIN_VERSION, true );
            }
        }

        public static function flaticon(){

            wp_enqueue_style( 'weddingcity-flaticon', WEDDINGCITY_PLUGIN_LIBRARY . 'flaticon/flaticon.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );
        }

        public static function fontello(){

            wp_enqueue_style( 'fontello', WEDDINGCITY_PLUGIN_LIBRARY . 'fontello/css/fontello.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );
        }

        public static function nice_select(){

            /**
             *  Nice Select Script
             */

            wp_enqueue_script( 'nice-select', WEDDINGCITY_PLUGIN_LIBRARY . 'nice-select/jquery.nice-select.min.js', array( 'jquery' ), WEDDINGCITY_PLUGIN_VERSION, false );
        }

        public static function magnific_popup(){

            /**
             *  Magnific Popup Script
             */

            wp_enqueue_style( 'magnific-popup', WEDDINGCITY_PLUGIN_LIBRARY . 'magnific-popup/magnific-popup.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

            wp_enqueue_script( 'magnific-popup', WEDDINGCITY_PLUGIN_LIBRARY . 'magnific-popup/magnific-popup.min.js', array('jquery'), WEDDINGCITY_PLUGIN_VERSION, true );
        }

        public static function toastr(){

            /**
             *  Toaster @link https://codeseven.github.io/toastr/
             */

            wp_enqueue_style( 'toastr', WEDDINGCITY_PLUGIN_LIBRARY . 'toastr/toastr.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

            wp_enqueue_script( 'toastr', WEDDINGCITY_PLUGIN_LIBRARY . 'toastr/toastr.js', array('jquery', 'WeddingCity_AJAX' ), WEDDINGCITY_PLUGIN_VERSION, true );
        }

        public static function slick(){

            wp_enqueue_style( 'slick', WEDDINGCITY_PLUGIN_LIBRARY . 'slick/css/slick.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

            wp_enqueue_style( 'slick-theme', WEDDINGCITY_PLUGIN_LIBRARY . 'slick/css/slick-theme.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

            wp_enqueue_script( 'slick', WEDDINGCITY_PLUGIN_LIBRARY . 'slick/js/slick.min.js', array('jquery'), WEDDINGCITY_PLUGIN_VERSION, true );
        }

        public static function review_script(){

            /**
             *  Review Script
             */
            wp_enqueue_style( 'review',  WEDDINGCITY_PLUGIN_LIBRARY . 'review/jquery.rateyo.min.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

            wp_enqueue_script( 'review', WEDDINGCITY_PLUGIN_LIBRARY . 'review/jquery.rateyo.min.js', array( 'jquery' ), WEDDINGCITY_PLUGIN_VERSION, true );
        }

        public static function background_video(){

            /**
             *  Review Script
             */

            wp_enqueue_script( 'background-video', WEDDINGCITY_PLUGIN_LIBRARY . 'background-video/background-video.js', array( 'jquery' ), WEDDINGCITY_PLUGIN_VERSION, true );
        }

        public static function pagination_script(){

            /**
             *  jQuery - Pagination
             */
            wp_enqueue_script( 'pagination', WEDDINGCITY_PLUGIN_LIBRARY . 'pagination/pagination.min.js', array( 'jquery' ), WEDDINGCITY_PLUGIN_VERSION, true );
        }

        public static function summery_editor_script(){

	        /**
	         *   Editor
	         */

	        wp_enqueue_style( 'summernote',  WEDDINGCITY_PLUGIN_LIBRARY . 'summernote/summernote.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

	        wp_enqueue_script( 'summernote', WEDDINGCITY_PLUGIN_LIBRARY . 'summernote/summernote.js', array( 'jquery' ), WEDDINGCITY_PLUGIN_VERSION, true );
        }

        public static function clipboard_script(){

            /**
             *  Clipboard
             */

            wp_enqueue_script( 'clipboard', WEDDINGCITY_PLUGIN_LIBRARY . 'clipboard/clipboard.min.js', array( 'jquery' ), WEDDINGCITY_PLUGIN_VERSION, true );
        }

        public static function select2_script(){

            /**
             *  Select 2
             */

            wp_enqueue_style( 'select2',  WEDDINGCITY_PLUGIN_LIBRARY . 'select2/select2.min.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

            wp_enqueue_script( 'select2', WEDDINGCITY_PLUGIN_LIBRARY . 'select2/select2.min.js', array( 'jquery' ), WEDDINGCITY_PLUGIN_VERSION, true );
        }
        
        public static function slide_reveal_scripts(){

            /**
             *  Slide Reveal
             */
            wp_enqueue_script( 'slide-reveal', WEDDINGCITY_PLUGIN_LIBRARY . 'slide-reveal/slide-reveal.min.js', array( 'jquery' ), WEDDINGCITY_PLUGIN_VERSION, true );
        }

        public static function date_picker_scripts(){

            /**
             *  Date Picker
             */
            wp_enqueue_script( 'jquery-ui-datepicker' );

            wp_enqueue_style( 'date-picker',  WEDDINGCITY_PLUGIN_LIBRARY . 'datepicker/date-picker.min.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );
        }

        public static function data_table_script(){

            /**
             *  Data table
             */

            wp_enqueue_style( 'date-table',  WEDDINGCITY_PLUGIN_LIBRARY . 'data-table/data-table.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

            wp_enqueue_script( 'date-table', WEDDINGCITY_PLUGIN_LIBRARY . 'data-table/data-table.min.js', array( 'jquery' ), WEDDINGCITY_PLUGIN_VERSION, true );
        }
	}

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Plugin_Scripts:: get_instance();
}

?>