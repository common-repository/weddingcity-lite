<?php

/**
 *  WeddingCity Email Builder
 */

if( ! class_exists( 'WeddingCity_Template' ) ){

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Template{

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

        }

        /**
         *  WeddingCity Get Template Page
         * @param  [type] $template [description]
         * @param  [type] $response [description]
         * @return [type]           [description]
         */
        public static function get_template( $template, $response ){

          if( $template == '' ) return;

          if( $response == '' ){ $response = 'link'; }

              $pages = get_pages( array(

                    'meta_key' => '_wp_page_template',
                    'meta_value' => sprintf('user-template/%1$s', $template )
                ) );
          
            if( $pages ){

              if( $response == 'url' || $response == 'link' )
                return get_permalink($pages[0]->ID);

              if( $response == 'id' )
              return $pages[0]->ID;

              if( $response == 'title' )
              return $pages[0]->post_title;

            }else{

              if( $response == 'url' || $response == 'link' )
                return home_url( '/' );

              if( $response == 'id' )
              return get_option( 'page_on_front' );

              if( $response == 'title' )
              return get_the_title( get_option( 'page_on_front' ) );
            }
        }

        /**
         * [couple_login_template description]
         * @return [template link] [couple login register template get]
         */
        public static function couple_login_template(){


            $_couple_login_register_template =

                // 1
                ( self::get_template( 'couple-login-register.php', 'link' ) != '' )

                ? self::get_template( 'couple-login-register.php', 'link' )

                : home_url();


            return esc_url( $_couple_login_register_template );
        }

        /**
         * [vendor_login_template description]
         * @return [template link] [vendor login register template link]
         */
        public static function vendor_login_template(){


            $_vendor_login_register_template =

                // 1
                ( self::get_template( 'vendor-login-register.php', 'link' ) != '' )

                ? self::get_template( 'vendor-login-register.php', 'link' )

                : home_url();


            return esc_url( $_vendor_login_register_template );
        }

        /**
         * [vendor_dashboard_template description]
         * @return [Vendor Dashboard Link Template]
         */
        public static function vendor_dashboard_template(){

            $_vendor_dashboard =

                // 1
                ( self::get_template( 'vendor-dashboard.php', 'link' ) != '' )

                ? self::get_template( 'vendor-dashboard.php', 'link' )

                : home_url();


            return esc_url( $_vendor_dashboard );
        }

        /**
         * [couple_dashboard_template description]
         * @return [Couple Dashboard Link Template]
         */
        public static function couple_dashboard_template(){

            $_couple_dashboard =

                // 1
                ( self::get_template( 'couple-dashboard.php', 'link' ) != '' )

                ? self::get_template( 'couple-dashboard.php', 'link' )

                : home_url();


            return esc_url( $_couple_dashboard );
        }

        /**
         * [vendor_texonomy_template description]
         * @return [Get Vendors Texonomy Page]
         */
        public static function vendor_texonomy_template(){

            $_vendor_texonomy_template =

                // 1
                ( self::get_template( 'listing-category.php', 'link' ) != '' )

                ? self::get_template( 'listing-category.php', 'link' )

                : home_url();


            return esc_url( $_vendor_texonomy_template );
        }

        /**
         * [location_texonomy_template description]
         * @return [Get Location Texonomy Page]
         */
        public static function location_texonomy_template(){

            $_location_texonomy_template =

                // 1
                ( self::get_template( 'listing-location.php', 'link' ) != '' )

                ? self::get_template( 'listing-location.php', 'link' )

                : home_url();


            return esc_url( $_location_texonomy_template );
        }

        /**
         * [search_listing_template description]
         * @return Search Listing Page Template
         */
        public static function search_listing_template(){

            $_search_listing_template =

                // 1
                ( self::get_template( 'search-listing.php', 'link' ) != '' )

                ? self::get_template( 'search-listing.php', 'link' )

                : home_url();

            return esc_url( $_search_listing_template );
        }

        /**
         * [forgot_password_template description]
         * @return Forgot Page Template Page Link
         */
        public static function forgot_password_template(){

            $_forgot_password_template =

                // 1
                ( self::get_template( 'forgot-password.php', 'link' ) != '' )

                ? self::get_template( 'forgot-password.php', 'link' )

                : home_url();

            return esc_url( $_forgot_password_template );
        }        
    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Template::get_instance();
}

