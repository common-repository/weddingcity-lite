<?php

/**
 *  WeddingCity user management
 */
if( ! class_exists( 'WeddingCity_Dashboard_Summary' ) ) {

	/**
	 *  Get User Access & Information
	 */
	class WeddingCity_Dashboard_Summary{

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

	    public function __construct(){
	    }

	    public static function get_vendor_dashboard_summary(){
	    }

	    public static function get_couple_dashboard_summary(){
	    }
	}

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Dashboard_Summary::get_instance();	
}