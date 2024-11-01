<?php

/**
 *  Option Tree
 *
 *  @link( https://github.com/valendesigns/option-tree )
 *
 *  @link( https://github.com/valendesigns/option-tree-theme/blob/master/inc/meta-boxes.php, link)
 */

if( ! class_exists( 'WeddingCity_Wishlist_Meta' ) ){

    /**
     *  WeddingCity Wishlist
     */
    class WeddingCity_Wishlist_Meta extends WeddingCity_User{

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

            if( class_exists('OT_Loader') ){

                /**
                 *  Grouping array
                 */
                add_action('admin_init', array( $this, 'weddingcity_couple_meta') );
            }
        }

        public static function weddingcity_couple_meta(){

            $_couple_wishlist = array(

                'id' => esc_attr( 'weddingcity_couple_wishlist' ),
                'title' => esc_html__( 'Wishlist Data', 'weddingcity' ),
                'desc' => esc_attr__( '', 'weddingcity' ),
                'pages' => array('couple'),
                'context' => 'normal',
                'priority' => 'high',
                'fields' => array(

                    array(
                        'id' => self:: weddingcity_wishlist_meta_name(),
                        'label' => esc_html__('Wishlist', 'weddingcity'),
                        'desc' => esc_attr__( '', 'weddingcity' ),
                        'std' => '',
                        'type' => 'list-item',
                        'section' => 'option_types',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'min_max_step' => '',
                        'class' => '',
                        'condition' => '',
                        'operator' => 'or',
                        'choices' => array(),
                        'settings' => array(

                            array(
                                'id'          => self:: weddingcity_listing_id_meta_name(),
                                'label'       => esc_html__('Listing', 'weddingcity'),
                                'desc'        => '',
                                'std'         => '',
                                'type'        => 'custom-post-type-select',
                                'section'     => 'option_types',
                                'rows'        => '',
                                'post_type'   => 'listing',
                                'taxonomy'    => '',
                                'min_max_step'=> '',
                                'class'       => '',
                                'condition'   => '',
                                'operator'    => 'and'
                            ),
                            array(
                                'id'          => self:: weddingcity_listing_category_id_meta_name(),
                                'label'       => esc_html__('Listing Category', 'weddingcity'),
                                'desc'        => '',
                                'std'         => '',
                                'type'        => 'taxonomy-select',
                                'section'     => 'option_types',
                                'rows'        => '',
                                'post_type'   => '',
                                'taxonomy'    => ( class_exists( 'WeddingCity_Texonomy' ) )
                                                    ?   WeddingCity_Texonomy:: listing_category_taxonomy() : '',
                                'min_max_step'=> '',
                                'class'       => '',
                                'condition'   => '',
                                'operator'    => 'and'
                            ),
                            array(
                                'id'          => self:: weddingcity_vendor_id_meta_name(),
                                'label'       => esc_html__('Listing Owner', 'weddingcity'),
                                'desc'        => '',
                                'std'         => '',
                                'type'        => 'custom-post-type-select',
                                'section'     => 'option_types',
                                'rows'        => '',
                                'post_type'   => 'vendor',
                                'taxonomy'    => '',
                                'min_max_step'=> '',
                                'class'       => '',
                                'condition'   => '',
                                'operator'    => 'and'
                            ),
                            array(
                                'id'          => self:: weddingcity_wishlist_timestrap_meta_name(),
                                'label'       => esc_html__('Timestrap', 'weddingcity'),
                                'desc'        => '',
                                'std'         => '',
                                'type'        => 'text',
                                'section'     => 'option_types',
                                'rows'        => '',
                                'post_type'   => '',
                                'taxonomy'    => '',
                                'min_max_step'=> '',
                                'class'       => '',
                                'condition'   => '',
                                'operator'    => 'and'
                            ),
                            array(
                                'id'          => self:: weddingcity_wishlist_unique_id_meta_name(),
                                'label'       => esc_html__('Wishlist Unique ID', 'weddingcity'),
                                'desc'        => '',
                                'std'         => '',
                                'type'        => 'text',
                                'section'     => 'option_types',
                                'rows'        => '',
                                'post_type'   => '',
                                'taxonomy'    => '',
                                'min_max_step'=> '',
                                'class'       => '',
                                'condition'   => '',
                                'operator'    => 'and'
                            ),
                        ),
                    ),
                )
            );

            ot_register_meta_box( $_couple_wishlist );
        }

        public static function weddingcity_wishlist_meta_name(){

            return sanitize_key( 'weddingcity_wishlist' );
        }

        public static function weddingcity_wishlist(){

            return parent:: get_data( self:: weddingcity_wishlist_meta_name() );
        }

        public static function weddingcity_wishlist_timestrap_meta_name(){

            return sanitize_key( 'wishlist_timestrap' );
        }

        public static function wishlist_timestrap(){

            return parent:: get_data( self:: weddingcity_wishlist_timestrap_meta_name() );
        }

        public static function weddingcity_wishlist_unique_id_meta_name(){

            return sanitize_key( 'wishlist_unique_id' );
        }

        public static function wishlist_unique_id(){

            return parent:: get_data( self:: weddingcity_wishlist_unique_id_meta_name() );
        }

        public static function weddingcity_vendor_id_meta_name(){

            return sanitize_key( 'wishlist_vendor_id' );
        }

        public static function wishlist_vendor_id(){

            return parent:: get_data( self:: weddingcity_vendor_id_meta_name() );
        }

        public static function weddingcity_listing_id_meta_name(){

            return sanitize_key( 'wishlist_listing_id' );
        }

        public static function wishlist_listing_id(){

            return parent:: get_data( self:: weddingcity_listing_id_meta_name() );
        }

        public static function weddingcity_listing_category_id_meta_name(){

            return sanitize_key( 'wishlist_listing_category' );
        }

        public static function wishlist_listing_category(){

            return parent:: get_data( self:: weddingcity_listing_category_id_meta_name() );
        }
    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Wishlist_Meta::get_instance();
}