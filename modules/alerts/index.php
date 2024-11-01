<?php

if( ! class_exists( 'WeddingCity_Alert' ) ){

    class WeddingCity_Alert{

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

            add_action( 'wp_enqueue_scripts', array( $this, 'weddingcity_alert_scripts' ) );
        }

        public static function weddingcity_alert_scripts(){

            wp_enqueue_style( 'weddingcity-alert', plugin_dir_url( __FILE__ ).'style.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

            wp_enqueue_script( 'weddingcity-alert', plugin_dir_url( __FILE__ ).'script.js', array( 'jquery', 'toastr' ), WEDDINGCITY_PLUGIN_VERSION, true );
        }

        /**
         *  Successfully Activate
         */
        public static function success_e( $_message ){

            if( ! empty( $_message ) ){

                  echo self:: success( $_message );
            }
        }

        public static function success( $_message ){

            if( ! empty( $_message ) ){

                  return $_message;

                  // return

                  // sprintf( '<span class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i> %1$s </span>',

                  //       // 1
                  //       $_message
                  // );
            }
        }

        /**
         *  Danger Message
         */
        
        public static function danger_e( $_message ){

            if( ! empty( $_message ) ){

                  echo self:: danger( $_message );
            }
        }

        public static function danger( $_message ){

            if( ! empty( $_message ) ){

                  return $_message;

                  // return 

                  // sprintf( '<span class="alert alert-danger"><i class="fa fa-times" aria-hidden="true"></i> %1$s</span>',

                  //       // 1
                  //       $_message
                  // );
            }
        }

        /**
         *  Warning Message
         */
        public static function warning_e( $_message ){

            if( ! empty( $_message ) ){

                  echo self:: warning( $_message );
            }
        }

        public static function warning( $_message ){

            if( ! empty( $_message ) ){

                  return $_message;

                  // return 

                  // sprintf( '<span class="alert alert-warning">%1$s</span>',

                  //       // 1
                  //       $_message
                  // );
            }
        }


        /**
         *  Ajax Loading
         */
        public static function ajax_loading_e(){

            echo self:: ajax_loading();
        }

        public static function ajax_loading(){

            return

            sprintf( '<span class="alert alert-info"> %1$s <i class="fa fa-spinner fa-spin"></i></span>', 

                // 1
                esc_html__('Please wait...', 'weddingcity') 
            );
        }

        
    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Alert::get_instance();
}
