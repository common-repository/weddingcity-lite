<?php

/**
 *  WeddingCity Email Builder
 */

if( ! class_exists( 'WeddingCity_User_Meta' ) ){

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_User_Meta{

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

            $GLOBALS[ 'WeddingCity_User_meta' ] = array(

                array(

                    'section_title'         =>  esc_html__('WeddingCity User Access key', 'weddingcity' ),
                    'user_access_post_id'   =>  'User Access Key',
                ),
            );


            add_action( 'edit_user_profile', array( $this, 'WeddingCity_User_profile_fields' ) );

            add_action( 'show_user_profile', array( $this, 'WeddingCity_User_profile_fields' ) );

            add_action( 'edit_user_profile_update', array( $this, 'WeddingCity_save_profile_fields' ) );
            
            add_action( 'personal_options_update',  array( $this, 'WeddingCity_save_profile_fields' ) );            
        }


        public static function WeddingCity_User_profile_fields( $user ){

            if( isset( $GLOBALS[ 'WeddingCity_User_meta' ] ) ){

                foreach( $GLOBALS[ 'WeddingCity_User_meta' ] as $auth_key => $auth_value ){

                    foreach ($auth_value as $key => $value) {

                        if( $key == 'section_title' ){

                            printf('<h2>%1$s</h2><table class="form-table">', $value );

                        }else{

                            printf('<tr><th><label for="%1$s">%3$s</label></th>
                                        <td>
                                            <input type="text" name="%1$s" id="%1$s" value="%2$s" class="regular-text"/>
                                            <span class="description">User access key cannot be changed..</span>
                                        </td>
                                    </tr>',

                                // 1
                                esc_attr( $key ),

                                // 2
                                esc_attr( get_the_author_meta( $key, $user->ID ) ),

                                // 3
                                esc_html( $value )
                            );
                        }
                    }

                    print '</table>';
                }
            }
        }


        public static function WeddingCity_save_profile_fields( $user_id ) {

            if ( !current_user_can( 'edit_user', $user_id ) )
                return false;

            if( isset( $GLOBALS[ 'WeddingCity_User_meta' ] ) ){

                foreach( $GLOBALS[ 'WeddingCity_User_meta' ] as $auth_key => $auth_value ){

                    foreach ($auth_value as $key => $value) {

                        if( ! ( $key == 'section_title' ) ){

                            update_user_meta( $user_id, $key, sanitize_text_field( $_POST[ $key ] ) ); 
                        }

                    }
                }

            }else{

                exit( esc_html( 'Global Variable for author meta not found.')  );
            }
        }
        
        public static function another_methord_to_get(){
             
            global $current_user; 
             
            return ( get_currentuserinfo() );
             
            if ( $current_user ) {

                return get_user_meta( $current_user->ID, 'ID', true );
            } 
        }


        /**
         *  Created User Access Post Id
         */
        

        public static function user_post_id(){

            global $current_user;
            
            return absint( wp_get_current_user()->user_access_post_id );
        }

        public static function user_id(){

            global $current_user;

            return absint( wp_get_current_user()->ID );
        }

        public static function user_email(){

            global $current_user;
            
            return sanitize_email( wp_get_current_user()->user_email );
        }

        public static function user_login(){

            global $current_user;
            
            return esc_html( wp_get_current_user()->user_login );
        }

        public static function default_avtar(){

            return esc_url( WEDDINGCITY_PLUGIN_IMAGE . 'user.png' );
        }

        public static function image_exists( $args ){

            if( ! empty( $args ) && @getimagesize( $args ) ){

                return esc_url( $args );

            }else{

                return self:: default_avtar();
            }
        }

        public static function user_type( $post_id ){

            global $post, $wp_query;

            return get_post_meta( $post_id, 'user_type', true );
        }

        public static function is_vendor(){

            global $post, $wp_query, $current_user;

            if( self::user_type( self::user_post_id() ) == 'vendor' )
                return true;

            return false;
        }

        public static function is_couple(){

            global $post, $wp_query, $current_user;

            if( self::user_type( self::user_post_id() ) == 'couple' )
                return true;

            return false;
        }

    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_User_Meta::get_instance();
}

