<?php

/**
 *  WeddingCity user management
 */
if( ! class_exists( 'WeddingCity_User' ) ) {

	/**
	 *  Get User Access & Information
	 */
	class WeddingCity_User{

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

	    public function __construct(){}

	    public static function post_id(){

		    global $current_user;
		    
		    return absint( wp_get_current_user()->user_access_post_id );
	    }

	    public static function realwedding_post_id(){

	    	global $post, $wp_query;

	    	if( self:: is_couple() ){

	    		$realwedding_post_id = get_post_meta( self:: post_id(), sanitize_key( 'realwedding_post_id' ), true );

	    		if( ! empty( $realwedding_post_id ) ){

	    			return absint( $realwedding_post_id );
	    		}
	    	}
	    }

	    public static function author_id(){

		    global $current_user;
		    
		    return absint( wp_get_current_user()->ID );
	    }

	    public static function get_realwedding_data( $args ){

	    	global $post, $wp_query;

	    	if( empty( $args ) ){
	    		return false;
	    	}

	    	return get_post_meta( absint( self:: realwedding_post_id() ), sanitize_key( $args ), true );
	    }

	    public static function get_data( $args ){

	    	global $post, $wp_query;

	    	if( empty( $args ) ){
	    		return false;
	    	}

	    	return get_post_meta( self:: post_id(), $args, true );
	    }

	    public static function get_post_data( $post_id, $args ){

	    	global $post, $wp_query;

	    	if( empty( $post_id ) && empty( $args ) ){
	    		return false;
	    	}

	    	return get_post_meta( $post_id, $args, true );
	    }

	    public static function user_type( $post_id ){

	    	global $post, $wp_query;

	    	return get_post_meta( $post_id, 'user_type', true );
	    }

	    public static function is_vendor(){

	    	global $post, $wp_query, $current_user;

	    	if( self:: user_type( self:: post_id() ) == 'vendor' ){
	    		return true;
	    	}

	    	return false;
	    }

	    public static function is_couple(){

	    	global $post, $wp_query, $current_user;

	    	if( self:: user_type( self:: post_id() ) == 'couple' ){
	    		return true;
	    	}

	    	return false;
	    }

	    public static function author_info( $author_id, $get_value ){

	    	global $post, $wp_query, $current_user;

	    	if( empty( $id ) && empty( $get_value ) ){
	    		return;
	    	}

			return get_user_by( 'id', $author_id  )->$get_value; 
	    }

	    public static function login_author_info( $author_id, $get_value ){

	    	global $post, $wp_query, $current_user;

	    	if( empty( $id ) && empty( $get_value ) ){
	    		return;
	    	}

			return get_user_by( 'id', absint( self:: author_id() )  )->$get_value; 
	    }
	}

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_User::get_instance();	
}