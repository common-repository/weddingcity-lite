<?php

if( ! class_exists( 'WeddingCity_Options' ) ){

    class WeddingCity_Options{

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

        public static function _currency_possition(){

            global $post, $wp_query;

            $_position =  esc_attr( weddingcity_option( '_currencty_possition_' ) );

            if( ! empty( $_position ) )
                return esc_attr( $_position );

            return esc_attr( 'left' );
        }

        public static function _currency_sign(){

            global $post, $wp_query;

            $_sing  =   esc_attr( weddingcity_option( 'listing_currency_sign' ) );

            if( ! empty( $_sing ) )
                return  esc_html( weddingcity_option( 'listing_currency_sign' ) );

            return esc_html__( '$', 'weddingcity' );
        }

        public static function _map_icon(){

            global $post, $wp_query;

            $_map_icon = weddingcity_option( 'google_map_icon' );

            if( ! empty( $_map_icon ) )
                return esc_url( weddingcity_option( 'google_map_icon' ) );

            return esc_url( WEDDINGCITY_PLUGIN_IMAGE . 'map-pin.png' );
        }

        public static function _map_cluster(){

            global $post, $wp_query;

            $_map_cluster = weddingcity_option( 'google_map_cluster' );

            if( ! empty( $_map_cluster ) )
                return esc_url( weddingcity_option( 'google_map_cluster' ) );

            return esc_url( WEDDINGCITY_PLUGIN_IMAGE . 'm1.png' );
        }

        public static function _map_latitude(){

            global $post, $wp_query;

            $_latitude = weddingcity_option( 'weddingcity_latitude' );

            if( ! empty( $_latitude ) )
                return esc_attr( weddingcity_option( 'weddingcity_latitude' ) );

            return esc_html( '23.019469943904543' );
        }

        public static function _map_longitude(){

            global $post, $wp_query;

            $_latitude = weddingcity_option( 'weddingcity_longitude' );

            if( ! empty( $_latitude ) )
                return esc_attr( weddingcity_option( 'weddingcity_longitude' ) );

            return esc_html( '72.5730813242451' );
        }

        public static function _map_infobox_close(){

            global $post, $wp_query;

            return esc_url( WEDDINGCITY_PLUGIN_IMAGE . 'crosss.png' );
        }


        public static function _paypal_currency_code(){

            global $post, $wp_query;

            $_paypal_currency_code = weddingcity_option( 'Currency_For_Paypal' );

            if( ! empty( $_paypal_currency_code ) )
                return esc_html( $_paypal_currency_code );

            return esc_html( 'USD' );
        }

        public static function _strip_currency_code(){

            global $post, $wp_query;

            $_strip_currency_code = weddingcity_option( 'stripe_currency' );

            if( ! empty( $_strip_currency_code ) )
                return esc_html( $_strip_currency_code );

            return esc_html( 'USD' );
        }

        public static function _strip_enable(){

            global $post, $wp_query;

            $_enable = weddingcity_option( 'stripe_gateway_on_off' );

            if( $_enable == 'on' ){

                return true;

            }else{

                return false;
            }
        }

        public static function _paypal_enable(){

            global $post, $wp_query;

            $_enable = weddingcity_option( 'paypal_gateway_on_off' );

            if( $_enable == 'on' ){

                return true;

            }else{

                return false;
            }
        }
    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Options::get_instance();
}
