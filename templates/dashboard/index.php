<?php

if( ! class_exists( 'WeddingCity_Dashboard' ) ){

    class WeddingCity_Dashboard{

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

            add_action( 'weddingcity_dashboard',  array( $this, 'weddingcity_dashboard_markup' ) );

            add_action( 'weddingcity_dashboard_top',  array( $this, 'weddingcity_dashboard_top_markup' ) );

            add_action( 'weddingcity_dashboard_content',  array( $this, 'weddingcity_dashboard_content_markup' ) );

            add_action( 'weddingcity_dashboard_bottom',  array( $this, 'weddingcity_dashboard_bottom_markup' ) );

            add_action( 'weddingcity_dashboard_menu', array( $this, 'weddingcity_dashboard_sidebar_menu_markup' ) );

            add_action( 'weddingcity_dashboard_before', array( $this, 'weddingcity_dashboard_before_markup' ) );

            add_action( 'weddingcity_dashboard_header', array( $this, 'weddingcity_dashboard_header_markup' ) );

            add_action( 'weddingcity_dashboard_header_before', array( $this, 'weddingcity_dashboard_header_before_markup' ) );

            add_action( 'weddingcity_dashboard_header_after', array( $this, 'weddingcity_dashboard_header_after_markup' ) );

            add_action( 'weddingcity_dashboard_header_top', array( $this, 'weddingcity_dashboard_header_top_markup' ) );

            add_action( 'weddingcity_dashboard_header_bottom', array( $this, 'weddingcity_dashboard_header_bottom_markup' ) );

            add_action( 'weddingcity_dashboard_header_menu', array( $this, 'weddingcity_dashboard_header_menu_markup' ) );
        }


        public static function weddingcity_dashboard_before_markup(){

                do_action( 'weddingcity_dashboard_header_top' );

                do_action( 'weddingcity_dashboard_header' );

                do_action( 'weddingcity_dashboard_header_bottom' );
        }

        public static function weddingcity_dashboard_header_top_markup(){

            ?>
                <div class="dashboard-header">
                  <div class="container-fluid">
                    <div class="row align-items-center wp-organic-dashboard-header">
            <?php
        }


        public static function weddingcity_dashboard_header_before_markup(){

            ?>

              <div class="col-xl-10 col-lg-9 col-md-8 col-sm-8 col-6">
                  <div class="header-logo">

                    <?php weddingcity_theme_logo( $args = 'header_logo_2' ); ?>

                  </div>
              </div>

            <?php
        }

        public static function weddingcity_dashboard_header_markup(){

                do_action( 'weddingcity_dashboard_header_before' );

                do_action( 'weddingcity_dashboard_header_after' );
        }

        public static function weddingcity_dashboard_header_after_markup(){

            ?>  <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 text-right">

                    <?php do_action( 'weddingcity_dashboard_header_menu' ); ?>

                </div>
            <?php
        }

        /**
         * [weddingcity_dashboard_header_menu_markup description]
         * @return [couple and vendor side menu]
         */
        public static function weddingcity_dashboard_header_menu_markup(){

            if( WeddingCity_User:: is_vendor() ){

                  echo WeddingCity_Vendor_Menu:: dashboard_menu( 'top' );
            }

            if( WeddingCity_User:: is_couple() ){

                  echo WeddingCity_Couple_Menu:: dashboard_menu( 'top' );
            }
        }

        public static function weddingcity_dashboard_header_bottom_markup(){

            ?>
                    </div>
                  </div>
                </div>

                <div class="navbar-expand-lg">
                    <button class="navbar-toggler" type="button" data-toggle="offcanvas">
                        <span id="icon-toggle" class="fa fa-bars"></span></button>
                    </button>
                </div>

            <?php
        }

        /**
         * [weddingcity_dashboard_markup description]
         * @return [Dashboard page action]
         */
        public static function weddingcity_dashboard_markup(){

                do_action( 'weddingcity_dashboard_before' );

                do_action( 'weddingcity_dashboard_top' );

                do_action( 'weddingcity_dashboard_content' );

                do_action( 'weddingcity_dashboard_bottom' );

                do_action( 'weddingcity_dashboard_after' );
        }

        /**
         * [weddingcity_dashboard_top_markup description]
         * @return [get dashboard top body]
         */
        public static function weddingcity_dashboard_top_markup(){

            ?>

              <div class="dashboard-wrapper">

                <?php do_action( 'weddingcity_dashboard_menu' ); ?>

                <div class="dashboard-content">

                  <div class="container-fluid">

            <?php
        }

        /**
         * [weddingcity_dashboard_content_markup description]
         * @return [get dashboard pages]
         */
        public static function weddingcity_dashboard_content_markup(){
          
            if( isset( $_GET['dashboard'] ) && !empty( $_GET['dashboard'] ) ){

                if( WeddingCity_User:: is_vendor() ){

                    get_template_part( 'dashboard/vendor/' .$_GET['dashboard'] );
                }

                if( WeddingCity_User:: is_couple() ){

                    get_template_part( 'dashboard/couple/' .$_GET['dashboard'] );
                }

            }else {

                exit( esc_html__( 'Dashboard Page Error..', 'weddingcity' ) );
            }
        }

        /**
         * [weddingcity_dashboard_bottom_markup description]
         * @return [bottom body]
         */
        public static function weddingcity_dashboard_bottom_markup(){
          
              ?>
                          </div>
                        </div>
                      </div>
              <?php
        }

        /**
         * [weddingcity_dashboard_sidebar_menu_markup description]
         * @return [couple and vendor side menu]
         */
        public static function weddingcity_dashboard_sidebar_menu_markup(){

            if( WeddingCity_User:: is_vendor() ){

                  echo WeddingCity_Vendor_Menu::dashboard_menu( 'side' );
            }

            if( WeddingCity_User:: is_couple() ){

                  echo WeddingCity_Couple_Menu::dashboard_menu( 'side' );
            }
        }

        /**
         * [dashboard_page_header description]
         * @param  [type] $title       [get title]
         * @param  [type] $description [get description]
         * @return [ Display Title & Description ]
         */
        public static function dashboard_page_header( $title, $description ){

            ?>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                      <div class="dashboard-page-header">
                        <h3 class="dashboard-page-title"><?php echo $title; ?></h3>
                        <p><?php echo $description; ?></p>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Dashboard::get_instance();
}
