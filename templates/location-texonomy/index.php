<?php

/**
 *  WeddingCity Location Texonomy
 */

if( ! class_exists( 'WeddingCity_Location_Texonomy' ) ){

    /**
     *  WeddingCity Location Texonomy
     */
    class WeddingCity_Location_Texonomy{

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

            add_action( 'weddingcity_location_texonomy_template', array( $this, 'weddingcity_location_texonomy_template_markup' ) );

            add_action( 'weddingcity_listing_location_texonomy_page', array( $this, 'weddingcity_listing_location_texonomy_page_markup' ) );
        }

        public static function location_texonomy_before(){

            do_action( 'weddingcity_full_width_container_start' );

            ?><div class="container"><div class="row"><?php
        }

        public static function location_texonomy_after(){
            
            ?></div></div><?php

            do_action( 'weddingcity_full_width_container_end' );
        }

        public static function location_texonomy_content(){

            $args = get_terms( WeddingCity_Texonomy:: listing_location_taxonomy(), array(

                    'hide_empty'       => absint('0'),
                    'childless'        => true,
            ));

            foreach( $args as $key ){

                $category_image = '';

                $image_id       =  get_term_meta( $key->term_id, 'term_image_id', true );


                if( $image_id != '' ){

                    $category_image   =   wp_get_attachment_image_src( $image_id,  'full', false )[ '0' ];

                }else{

                    $category_image   =   esc_url( WEDDINGCITY_THEME_DIR . '/images/category-image.jpg' );
                }

                printf('<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="card-category">
                                <div class="category-image zoomimg"><a href="%3$s"><img src="%1$s" alt="%2$s"></a></div>
                                <div class="category-content">
                                    <h3 class="cateogry-title">%2$s <span class="category-count">(%4$s)</span></h3>
                                </div>
                            </div>
                        </div>',

                        // 1
                        esc_url( $category_image ),
                        
                        // 2
                        $key->name,

                        // 3
                        get_term_link( $key ),

                        // 4
                        absint( $key->count )
                );
            }
        }

        public static function weddingcity_location_texonomy_template_markup(){

            self:: location_texonomy_before();

            self:: location_texonomy_content();

            self:: location_texonomy_after();
        }

        /**
         *  Location Texonomy Childs page - taxonomy-location.php
         */
        
        public static function weddingcity_listing_location_texonomy_page_markup(){

            self:: location_texonomy_page_before();

            self:: location_texonomy_page_content();

            self:: location_texonomy_page_after();
        }

        public static function location_texonomy_page_before(){

            do_action( 'weddingcity_full_width_container_start' );

                ?><div class="row" id="search_category_result"><?php
        }

        public static function location_texonomy_page_after(){

                ?></div><?php

            do_action( 'weddingcity_full_width_container_end' );
        }

        public static function location_texonomy_page_content(){

            global $post, $wp_query;

            $category = get_term_by( 'name', single_cat_title( '', false ), WeddingCity_Texonomy:: listing_location_taxonomy() );

            $_pagination = false;

            if( ! empty( $category ) ){

                    $category_type_array = array();

                    if( isset( $category ) && !empty( $category ) ){

                        $category_type_array = array(

                            'taxonomy'  => WeddingCity_Texonomy:: listing_location_taxonomy(),
                            'field'     => 'id',
                            'terms'     => absint ( $category->term_id )
                        );
                    }

                    $args = array( 
                        'post_type'         => 'listing',
                        'post_status'       => 'publish', 
                        'posts_per_page'    => -1,
                        'orderby'           => 'menu_order ID',
                        'order'             => 'post_date',
                        'tax_query'         => array(

                                'relation'  => 'AND',
                                $category_type_array,
                        ),
                    );

                    $get_data       = '';
                    $per_page       = absint( '6' );
                    $start_div      = $per_page;
                    $end_div        = $page_counter  =  absint( '1' );


                    $item = new WP_Query( $args );

                    $get_data = '';

                    if( $item->have_posts() ){

                        while ( $item->have_posts() ){  $item->the_post();

                            if( $start_div % $per_page == absint( '0' ) && ( $item->post_count >= $per_page ) && $_pagination ){

                                $get_data   .=  sprintf( '<div class="col-12 vendor-section vendor-post" id="vendor-section%1$s"><div class="row">', $page_counter );

                                $page_counter++;
                            }

                            $get_data .=   '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">';                            

                                $get_data .=    WeddingCity_Listing:: weddingcity_listing( get_the_ID() );

                            $get_data .=    '</div>';


                            if( $end_div % $per_page == absint( '0' ) && ( $item->post_count >= $per_page ) && $_pagination ){

                                    $get_data .= '</div></div>';
                            }

                            $end_div++; $start_div++;


                        } wp_reset_postdata();   // while end


                        printf( $get_data );
                    }

                    if( $_pagination ){

                        ?><div class="col-xs-12"><ul id="texonomy_pagination" class=""></ul></div><?php
                    }

            } // ending
        }
    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Location_Texonomy::get_instance();
}

