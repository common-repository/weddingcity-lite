<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }  /* Exit if accessed directly. */

if( ! class_exists( 'WeddingCity_Wishlist_Plugin' ) ){

    class WeddingCity_Wishlist_Plugin {

        /**
         * A reference to an instance of this class.
         */
        private static $instance;

        /**
         * Returns an instance of this class.
         */
        public static function get_instance() {

            if ( null == self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }
        
        /**
         * Initializes the plugin by setting filters and administration functions.
         */
        private function __construct() {

            add_action( 'plugins_loaded', function(){

                    /**
                     *  WeddingCity Core
                     */
                    foreach ( glob(  plugin_dir_path( __FILE__ ) . '*/*.php' ) as $_wc_file ) {

                        require_once $_wc_file;
                    }
            } );
        }
    }

    WeddingCity_Wishlist_Plugin:: get_instance();
}