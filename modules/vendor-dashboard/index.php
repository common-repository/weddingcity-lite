<?php

/**
 *  WeddingCity Vendor Dashboard
 */

if( ! class_exists( 'WeddingCity_Vendor_Dashboard' ) ){

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Vendor_Dashboard{

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

            add_action( 'weddingcity_vendor_dashboard', array( $this, 'weddingcity_vendor_dashboard_markup' ) );
        }

        /**
         * [page_title description]
         * @return [ Page Title ]
         */
        public static function page_title(){

            return esc_html__( 'Hi, Vendor.', 'weddingcity' );
        }

        public static function page_description(){

            return esc_html__( 'Here what\'s happening with your wedding business today.', 'weddingcity' );
        }

        public static function weddingcity_vendor_dashboard_page_title(){

            WeddingCity_Dashboard:: dashboard_page_header(

                    // 1
                    self:: page_title(),

                    // 2
                    self:: page_description()
            );
        }

        public static function weddingcity_vendor_dashboard_markup(){

            self:: weddingcity_vendor_dashboard_page_title();

            self:: weddingcity_vendor_dashboard_body_before();

            self:: weddingcity_vendor_dashboard_body_content();

            self:: weddingcity_vendor_dashboard_body_after();

            /**
             *  If amount is get
             */
            
            do_action( 'weddingcity_listing_pricing_setup' );
        }

        public static function weddingcity_vendor_dashboard_body_before(){

            ?><div class="row"><?php
        }

        public static function weddingcity_vendor_dashboard_body_after(){
          
            ?></div><?php
        }

        public static function weddingcity_vendor_dashboard_body_content(){

            $_get_sammarys = apply_filters( 'weddingcity_vendor_dashboard_summary', array() );

            if( WeddingCity_Loader:: array_condition( $_get_sammarys ) ){

                foreach ( $_get_sammarys as $value) {

                    printf('<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="card card-summary">
                                    <div class="card-body">
                                        <div class="summary-count">%1$s</div>
                                        <p>%2$s</p>
                                    </div>
                                    <div class="card-footer text-center"><a href="%3$s">%4$s</a></div>
                                </div>
                            </div>',

                            // 1
                            absint( $value[ 'counter' ] ),

                            // 2
                            esc_html( $value[ 'title' ] ),

                            // 3
                            esc_url( $value[ 'btn_link' ] ),

                            // 4
                            esc_html( $value[ 'btn_text' ] )
                    );
                }
            }
        }
    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Vendor_Dashboard::get_instance();
    
}