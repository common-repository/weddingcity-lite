<?php

/**
 *  WeddingCity Couple Reviews
 */

if( ! class_exists( 'WeddingCity_Couple_Reviews' ) ){

    /**
     *  WeddingCity Listing Requests
     */
    class WeddingCity_Couple_Reviews{

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

            add_action( 'weddingcity_couple_reviews', array( $this, 'weddingcity_couple_reviews_markup' ) );
        }

        public static function weddingcity_couple_reviews_markup(){

            self:: page_title_markup();
        }

        public static function page_title(){

            return esc_html__( 'Couple Reviews', 'weddingcity' );
        }

        public static function page_description(){

            return  esc_html__( 'You Given Reviews', 'weddingcity' );
        }

        public static function page_title_markup(){

            WeddingCity_Dashboard:: dashboard_page_header(

                    // 1
                    self:: page_title(),

                    // 2
                    self:: page_description()
            );
        }


    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Couple_Reviews:: get_instance();
}

