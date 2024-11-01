<?php

if( ! class_exists( 'WeddingCity_Remove_Author' ) ){

    class WeddingCity_Remove_Author{

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


    /**
     * Start up
     */
    public function __construct(){

        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'weddingcity_bulk_import_script' ) );
    }

    public static function weddingcity_bulk_import_script(){

        global $post, $wp_query;

        wp_enqueue_style( 'weddingcity-remove-author', plugin_dir_url( __FILE__ ).'/style.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

        wp_enqueue_script( 'weddingcity-remove-author', plugin_dir_url( __FILE__ ).'/script.js', array('jquery'), WEDDINGCITY_PLUGIN_VERSION, true );
    }


    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Remove Authors', 
            'Remove Authors',  // menu title
            'manage_options', 
            'remove-authors', 
            array( $this, 'remove_authors' )
        );
    }

    /**
     * Options page callback
     */
    public function remove_authors(){

        ?>

        <div id="weddingcity_bulk_import" class="wrap">

            <h1><?php esc_html_e( 'WeddingCity Remove Author With Assign Post Type!', 'weddingity' ); ?></h1>

            <form method="post" id="weddingity_remove_author_list_with_post_type">

              <?php
                    global $wp_query, $post;

                    $users = get_users();

                    foreach ($users as $user) {

                        printf( 'User id -->%1$s <br/> 
                                 Use Access Id ->%2$s <br/>

                                 User Acccess Post List -> %3$s

                                 <br/><br/>',

                            // 1
                            absint( $user->ID ),

                            // 2
                            absint( $user->user_access_post_id ),

                            self:: use_access_post_types( 

                                // 1 - post id 
                                absint( $user->user_access_post_id ),

                                // 2 - is vendor
                                self::  is_vendor( $user->user_access_post_id ),

                                // 3 - is couple
                                self::  is_couple( $user->user_access_post_id )
                            )
                        );
                    }

              ?>

            </form>
        </div>
        <?php
    }


        public static function use_access_post_types( $_post_id, $_is_vendor, $_is_couple ){

            if( ! empty( $_post_id ) && (  ( $_is_vendor == true ) ||  ( $_is_couple == true ) ) ){

                $post_id = array();

                if( $_is_vendor == true ){

                    $post_id[] = $_post_id;
                }

                if( $_is_couple == true ){
                  

                    $post_id[] = $_post_id;
                    $post_id[] = get_post_meta( $_post_id, 'realwedding_post_id', true );
                }

                return var_dump( $post_id );

            }else{

                return;
            }
        }



        public static function user_type( $post_id ){

            global $post, $wp_query;

            return get_post_meta( $post_id, 'user_type', true );
        }

        public static function is_vendor( $_post_id ){

            global $post, $wp_query, $current_user;

            if( self::user_type( $_post_id ) == 'vendor' )
                return true;

            return false;
        }

        public static function is_couple(){

            global $post, $wp_query, $current_user;

            if( self::user_type( $_post_id ) == 'couple' )
                return true;

            return false;
        }

    /**
     * Register and add settings
     */
    public function page_init(){        



    }
 
        
    } // end class

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    // WeddingCity_Remove_Author::get_instance();
}
