<?php

/**
 *  WeddingCity Page Header Banner
 */
if( ! class_exists( 'WeddingCity_Plugin_Page_Header_Banner' ) ){

    /**
     *  WeddingCity_Plugin_Page_Header_Banner
     */
    class WeddingCity_Plugin_Page_Header_Banner {

        /**
         * Member Variable
         *
         * @var instance
         */
        private static $instance;

        /**
         *  @var page_header
         */
        public $page_header;

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

            add_action( 'weddingcity_realwedding_page_header',  array( $this, 'weddingcity_realwedding_page_header_markup' ) );

            add_action( 'weddingcity_couple_page_header',  array( $this, 'weddingcity_couple_page_header_markup' ) );

            add_action( 'weddingcity_listing_category_page_header',  array( $this, 'weddingcity_texonomy_page_header_markup' ) );

            add_action( 'weddingcity_listing_location_page_header',  array( $this, 'weddingcity_texonomy_page_header_markup' ) );
        }

        /**
         *  Realwedding Taxonomy
         */
        public static function realwedding_location_textonomy( $_post_id ){

            if( empty( $_post_id ) )
                return;

            $_texonomy_ids = wp_get_post_terms( absint( $_post_id ), \WeddingCity_Texonomy:: realwedding_location_taxonomy(), array( 'fields' => 'ids', 'orderby' => 'parent', 'order' => 'desc' ) );

            if( empty( $_texonomy_ids ) )
                return;

            $_texonomy = '';

            $_arguments = array();

            if( is_array( $_texonomy_ids ) && ! empty( $_texonomy_ids ) ){

                foreach( $_texonomy_ids as $key => $value ){

                    $_arguments[] = 

                    sprintf( '%1$s',

                        // 1
                        \WeddingCity_Texonomy:: weddingcity_get_term_name( 

                            \WeddingCity_Texonomy:: realwedding_location_taxonomy(),

                            // 1
                            $value,

                            // 2
                            'name' 
                        )
                    );
                }
            }

            $_texonomy .= '<span class="real-wedding-place ml-4 text-white"><i class="fas fa-map-marker-alt pr-2"></i> ';

            $_texonomy .= implode( ', ', $_arguments );

            $_texonomy .= '</span>';


            return $_texonomy;
        }

        /**
         *  Realwedding Page Header Banner
         */
        public static function weddingcity_realwedding_page_header_markup(){

                $_realweding_header_image   =   get_post_meta( get_the_ID(), WeddingCity_Real_Wedding_Meta:: real_wedding_page_banner_meta_name(), true );
                    
                $page_header_banner_style   =   

                sprintf('background:url(%1$s);background-size:cover;',

                        // 1
                        ( ! empty( $_realweding_header_image ) )

                        ? esc_url( $_realweding_header_image )

                        : esc_url( plugin_dir_url( __FILE__ ) . 'images/realwedding-page-banner.jpg' )
                );

                printf('<div class="real-wedding-single-img" style="%1$s">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                        <div class="realwed-caption">
                                            <h1 class="real-wedding-single-title">%2$s %3$s %4$s</h1>
                                            %6$s
                                            %5$s
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>',

                        // 1
                        $page_header_banner_style,

                        // 2
                        ( get_post_meta( get_the_ID(),  WeddingCity_Real_Wedding_Meta::bride_first_name_meta_name(), true ) != '' )

                        ? get_post_meta( get_the_ID(),  WeddingCity_Real_Wedding_Meta::bride_first_name_meta_name(), true )

                        : esc_html__( 'Mr', 'weddingcity' ),

                        // 3
                        esc_html__( '&amp;', 'weddingcity' ),

                        // 4
                        ( get_post_meta( get_the_ID(), WeddingCity_Real_Wedding_Meta::groom_first_name_meta_name(), true ) != '' )

                        ? get_post_meta( get_the_ID(), WeddingCity_Real_Wedding_Meta::groom_first_name_meta_name(), true )

                        : esc_html__( 'Mrs', 'weddingcity' ),

                        // 5
                        self:: realwedding_location_textonomy( get_the_ID() ),

                        // 6
                        ( get_post_meta( get_the_ID(), WeddingCity_Real_Wedding_Meta:: real_wedding_date_meta_name(), true ) != '' )

                        ?   sprintf( '<span class="real-wedding-date text-white">%1$s</span>',

                                // 1
                                date( "d M, Y", strtotime( get_post_meta( get_the_ID(), WeddingCity_Real_Wedding_Meta:: real_wedding_date_meta_name(), true ) ) )
                            )

                        :   ''
                );
        }

        /**
         *  Couple page Header Banner
         */
        public static function weddingcity_couple_page_header_markup(){

            /**
             *  Singular Couple Page Header Banner
             */

            $_couple_banner = get_the_post_thumbnail_url( get_the_ID(), 'full' );

            if( empty( $_couple_banner ) ){

                $_couple_banner = esc_url( plugin_dir_url( __FILE__ ) . 'images/couple-single-page-header-banner.jpg' );
            }

            if( $_couple_banner != '' ){

                $page_header_banner_style = 

                sprintf('background:url(%1$s);background-size:cover;', 

                        // 1
                        esc_url( $_couple_banner )
                );
            }

            $_bride_name    =  get_post_meta( absint( get_the_ID() ), WeddingCity_Couple_Meta:: bride_first_name_meta_name(), true );

            $_groom_name    =  get_post_meta( absint( get_the_ID() ), WeddingCity_Couple_Meta:: groom_first_name_meta_name(), true );

            printf('<div class="rsvp-page-header" style="%1$s">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="rsvp-page-caption">
                                        <h1 class="rsvp-page-title">%2$s &amp; %3$s</h1>
                                        <p class="rsvp-wedding-date">%4$s</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>',

                    // 1
                    $page_header_banner_style,

                    // 2
                    ( $_bride_name !== '' ) ? $_bride_name : esc_html__( 'Mr', 'weddingcity' ),

                    // 3
                    ( $_groom_name !== '' ) ? $_groom_name : esc_html__( 'Mrs', 'weddingcity' ),

                    // 4
                    date_i18n( get_option( 'date_format' ), strtotime(

                        get_post_meta( absint( get_the_ID() ), WeddingCity_Couple_Meta:: profile_wedding_date_meta_name(), true ) 

                    ) )
            );
        }

        /**
         *  Listing Category Page Header Banner
         */
        public static function weddingcity_texonomy_page_header_markup(){

            if( is_tax( WeddingCity_Texonomy:: listing_category_taxonomy() ) ){

                self:: weddingcity_listing_category_texonomy_page_header_markup();
            }

            if( is_tax( WeddingCity_Texonomy:: listing_location_taxonomy() ) ){

                self:: weddingcity_listing_location_texonomy_page_header_markup();
            }
        }

        public static function weddingcity_listing_category_texonomy_page_header_markup(){

            $category = get_term_by( 'name', single_cat_title( '', false ), WeddingCity_Texonomy:: listing_category_taxonomy() );

            $image_id =  get_term_meta( $category->term_id, 'header_banner_image_id', true );

            return self:: get_texonomy_page_header_image( $image_id );
        }

        public static function weddingcity_listing_location_texonomy_page_header_markup(){

            $category = get_term_by( 'name', single_cat_title( '', false ), WeddingCity_Texonomy:: listing_location_taxonomy() );

            $image_id =  get_term_meta( $category->term_id, 'header_banner_image_id', true );

            return self:: get_texonomy_page_header_image( $image_id );
        }  

        /**
         *  Get Texonomy Page Header Banner
         */
        public static function get_texonomy_page_header_image( $image_id ){

            $_get_texonomy_image = '';

            if( $image_id != '' ){

                $_get_texonomy_image  =  esc_url( wp_get_attachment_image_src( $image_id, 'full', false )['0'] );
            }

            if( empty( $_get_texonomy_image ) ){

                $_get_texonomy_image  =  esc_url( plugin_dir_url( __FILE__ ) . 'images/category-page-header-image.jpg' );
            }

            if( WeddingCity_Page_Header_Banner:: weddingcity_page_header_banner_option() == absint( '1' ) ){

                return WeddingCity_Page_Header_Banner:: weddingcity_default_image_page_header_banner( esc_url( $_get_texonomy_image ) );

            }else{

                return WeddingCity_Page_Header_Banner:: weddingcity_default_solid_header_banner();
            }
        }


    } // class end

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Plugin_Page_Header_Banner::get_instance();
}
