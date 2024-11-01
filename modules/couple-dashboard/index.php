<?php

/**
 *  WeddingCity Vendor Dashboard
 */

if( ! class_exists( 'WeddingCity_Couple_Dashboard' ) ){

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Couple_Dashboard{

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

            add_action( 'weddingcity_couple_dashboard', array( $this, 'weddingcity_couple_dashboard_markup' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'weddingcity_couple_dashboard' ) );
        }

        public static function weddingcity_couple_dashboard(){

            wp_enqueue_style( 'weddingcity-couple-dashboard-script', plugin_dir_url( __FILE__ ).'style.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

            wp_enqueue_script( 'weddingcity-couple-dashboard-script', plugin_dir_url( __FILE__ ).'script.js', array( 'jquery' ), WEDDINGCITY_PLUGIN_VERSION, true );
        }        

        /**
         * [page_title description]
         * @return [ Page Title ]
         */
        public static function page_title(){

            return esc_html__( 'Couple Dashboard', 'weddingcity' );
        }

        public static function page_description(){

            return esc_html__( 'Welcome couple. You can check and manage your wishlist, checklist, budget and guestlist overview.', 'weddingcity' );
        }

        public static function weddingcity_couple_dashboard_page_title(){

            WeddingCity_Dashboard:: dashboard_page_header(

                    // 1
                    self:: page_title(),

                    // 2
                    self:: page_description()
            );
        }

        public static function weddingcity_couple_dashboard_markup(){

            self:: weddingcity_couple_dashboard_page_title();

            self:: weddingcity_couple_dashboard_body_content();
        }

        public static function couple_table_seating_information(){

            ?>      <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 d-none">
                        <div class="card summary-block summary-table-seating">
                            <div class="card-body summary-content">
                                <h3 class="summary-title "><?php esc_html_e( 'Table Seating', 'weddingcity' ); ?></h3>
                                <div class="summary-count"><?php esc_html_e( '300', 'weddingcity' ); ?></div>
                                <p class="summary-text"><?php esc_html_e( '15 Seat remain', 'weddingcity' ); ?></p>
                            </div>
                            <div class="card-footer text-center"><a href="<?php home_url( '/' ); ?>"><?php esc_html_e( 'View All', 'weddingcity' ); ?></a></div>
                        </div>
                    </div>
            <?php
        }

        public static function get_image( $args = '' ){

            if( ! empty( $args ) ){

                return esc_url( $args );

            }else{

                return esc_url( plugin_dir_url( __FILE__ ). 'images/default.jpg' );
            }
        }

        public static function weddingcity_couple_dashboard_body_content(){

            ?><div class="row"><?php

                $_get_sammarys = apply_filters( 'weddingcity_couple_dashboard_summary', array() );

                if( WeddingCity_Loader:: array_condition( $_get_sammarys ) ){

                    foreach ( $_get_sammarys as $value) {

                        ?>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">

                            <div class="card summary-block summary-guest-list">
                                
                                <?php

                                    printf( '<div class="card-body summary-content">
                                                    <h3 class="summary-title">%1$s</h3>
                                                    <div class="summary-count">%2$s</div>
                                                    <p class="summary-text">%3$s</p>
                                            </div>
                                            <div class="card-footer text-center">
                                                    <a href="%4$s">%5$s</a>
                                            </div>',

                                            // 1
                                            esc_html( $value[ 'title' ] ),

                                            // 2
                                            $value[ 'counter' ],

                                            // 3
                                            $value[ 'overview' ],

                                            // 4
                                            esc_url( $value[ 'btn_link' ] ),

                                            // 5
                                            esc_html( $value[ 'btn_text' ] )
                                    );
                                ?>

                            </div>

                        </div>
                        <?php
                    }
                }

            ?></div><?php
        }
    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Couple_Dashboard::get_instance();
    
}