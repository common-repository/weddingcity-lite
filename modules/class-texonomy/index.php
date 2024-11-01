<?php

/**
 *  WeddingCity Email Builder
 */

if( ! class_exists( 'WeddingCity_Texonomy' ) ){

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Texonomy{

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

            add_action( 'wp_enqueue_scripts', array( $this, 'weddingcity_texonomy_script' ) );

            add_action( 'wp_ajax_weddingcity_texonomy_venue_action',  array( $this, 'weddingcity_texonomy_venue_action' ) );

            add_action( 'wp_ajax_nopriv_weddingcity_texonomy_venue_action', array( $this, 'weddingcity_texonomy_venue_action' ) );

            add_action( 'wp_ajax_weddingcity_get_category_data',  array( $this, 'weddingcity_get_category_data' ) );

            add_action( 'wp_ajax_nopriv_weddingcity_get_category_data', array( $this, 'weddingcity_get_category_data' ) );
        }

        public static function weddingcity_texonomy_script(){

            if(     isset( $_GET['dashboard'] ) && !empty( $_GET['dashboard'] ) && 

                    (   
                        $_GET['dashboard'] == 'update-listing' || $_GET['dashboard'] == 'add-listing' || 
                        $_GET['dashboard'] == 'couple-profile' || $_GET[ 'dashboard' ] == 'vendor-profile' || $_GET[ 'dashboard' ] == 'real-wedding'
                    )
            ){

                wp_enqueue_style( 'weddingcity-texonomy', plugin_dir_url( __FILE__ ).'style.css', array(), WEDDINGCITY_PLUGIN_VERSION, 'all' );

                wp_enqueue_script( 'weddingcity-texonomy', plugin_dir_url( __FILE__ ).'script.js', array('jquery'), WEDDINGCITY_PLUGIN_VERSION, true );
            }
        }

        public static function weddingcity_get_category_data(){

            $_taxonomy = '';

            if( $_POST[ 'taxonomy' ] == sanitize_title( self::listing_location_taxonomy() ) ){

                $_taxonomy = sanitize_key( self::listing_location_taxonomy() );

            }elseif( $_POST[ 'taxonomy' ] ==  sanitize_title( self::vendor_location_taxonomy() ) ){

                $_taxonomy = sanitize_key( self::vendor_location_taxonomy() );

            }elseif( $_POST[ 'taxonomy' ] == sanitize_title( self:: realwedding_location_taxonomy() ) ){

                $_taxonomy = sanitize_key( self::realwedding_location_taxonomy() );

            }elseif( $_POST[ 'taxonomy' ] == sanitize_title( self:: couple_location_taxonomy() ) ){

                $_taxonomy = sanitize_key( self::couple_location_taxonomy() );
            }

            if( isset( $_POST['country'] ) ){

                die( json_encode( array(

                    'html' =>      WeddingCity_Texonomy:: create_select_option(

                                      $get_parents = WeddingCity_Texonomy:: get_texonomy_child( $_taxonomy, absint( $_POST['country'] ) ),

                                      $label = array('0' => 'Select State'),

                                      $default_select = '',

                                      $print = false
                                  )
                ) ) );

            }elseif( isset( $_POST['state'] ) ){

                die( json_encode( array(


                    'html' =>      WeddingCity_Texonomy:: create_select_option(

                                      $get_parents = WeddingCity_Texonomy:: get_texonomy_child(  $_taxonomy, absint( $_POST['state'] )  ),

                                      $label = array('0' => esc_html__( 'Select City', 'wedddingcity' ) ),

                                      $default_select = '',

                                      $print = false
                                  )
                ) ) );
            }            
        }

        public static function weddingcity_texonomy_venue_action(){

            $error = false;

            if( absint( $_POST[ 'vendor_type' ] ) == absint( '0' ) ){

                $error = true;

                die( json_encode( array(
                    
                        'error' => $error,
                ) ) );
            }

            if( WeddingCity_Loader:: array_condition( weddingcity_option( 'show_aminities' ) ) ){

                    foreach( weddingcity_option( 'show_aminities' ) as $key => $value ){

                        $_child = WeddingCity_Texonomy:: get_texonomy_child( WeddingCity_Texonomy:: listing_category_taxonomy(), $value );

                        if( $value == absint( $_POST[ 'vendor_type' ] ) ||  array_key_exists( absint( $_POST[ 'vendor_type' ] ) , $_child )  ){

                            $error = true;
                        }
                    }

                    $vendor_type = absint( $_POST[ 'vendor_type' ] );
                
                    die( json_encode( array(
                            'error' => $error,
                    ) ) );
            }
        }

        /**
         *  Listing Category Texonomy Name Here
         */
        public static function listing_category_taxonomy(){

            return sanitize_key( 'listing-category' );  // category
        }

        /**
         *  Listing Location Texonomy Name Here
         */
        public static function listing_location_taxonomy(){

            return sanitize_key( 'listing-location' );  // location
        }

        /**
         *  Listing Tags Texonomy Name Here
         */
        public static function listing_tag_taxonomy(){

            return sanitize_key( 'listing-tag' );  // tags
        }

        /**
         *  Real Wedding Category
         */
        public static function realwedding_category_taxonomy(){

            return sanitize_key( 'realwedding-category' );  // tags
        }

        /**
         *  Real Wedding Location
         */
        public static function realwedding_location_taxonomy(){

            return sanitize_key( 'realwedding-location' );  // tags
        }

        /**
         *  Real Wedding Tag
         */
        public static function realwedding_tag_taxonomy(){

            return sanitize_key( 'realwedding-tag' );  // tags
        }

        /**
         *  Vendor Category
         */
        public static function vendor_category_taxonomy(){

            return sanitize_key( 'vendor-category' );  // tags
        }

        /**
         *  Vendor Location
         */
        public static function vendor_location_taxonomy(){

            return sanitize_key( 'vendor-location' );  // tags
        }

        /**
         *  Vendor Tag
         */
        public static function vendor_tag_taxonomy(){

            return sanitize_key( 'vendor-tag' );  // tags
        }

        /**
         *  Couple Category
         */
        public static function couple_category_taxonomy(){

            return sanitize_key( 'couple-category' );  // category
        }

        /**
         *  Couple Location
         */
        public static function couple_location_taxonomy(){

            return sanitize_key( 'couple-location' );  // location
        }

        /**
         *  Couple Tag
         */
        public static function couple_tag_taxonomy(){

            return sanitize_key( 'couple-tag' );  // tags
        }

        /**
         *      Get Texonomy
         */
        public static function get_texonomy( $texonomy ){

            if( empty( $texonomy ) )
                return;

            $terms =  

            get_terms( $texonomy, array(

                'hide_empty'    => false,
                'orderby'       => 'name', 
                'order'         => 'ASC',
                'hierarchical'  => absint( '1' ),

            ) );

            $args = array();

            if( is_array( $terms ) && ! empty( $terms ) && count( $terms ) >= absint( '1' ) ){

                foreach( $terms as $key ){

                    $args[ absint( $key->term_id ) ] = esc_html( $key->name );
                }
            }

            return $args;
        }

        public static function get_texonomy_parent( $texonomy ){

            if( empty( $texonomy ) )
                return;

            $terms =  get_terms( $texonomy, array(

                        'hide_empty'    => false,
                        'orderby'       => 'name',
                        'order'         => 'ASC',
                        'parent'        => absint('0')
            ) );

            $args = array();

            if( is_array( $terms ) && ! empty( $terms ) && count( $terms ) >= absint( '1' ) ){

                foreach( $terms as $key ){

                    $args[ absint( $key->term_id ) ] = esc_html( $key->name );
                }
            }

            return $args;
        }

        public static function get_texonomy_child( $texonomy, $child ){

            if( empty( $texonomy ) )
                return;

            $terms =  get_terms( $texonomy, array(

                        'hide_empty'    => false,
                        'orderby'       => 'name', 
                        'order'         => 'ASC',
                        'parent'        => ''
            ) );

            $args = array();

            if( $child != '' ){

                if( is_array( $terms ) && ! empty( $terms ) && count( $terms ) >= absint( '1' ) ){

                    foreach( $terms as $key ){

                        if( $key->parent == $child ){

                            $args[ absint( $key->term_id ) ] = esc_html( $key->name );

                        }
                    }
                }
            }

            return $args;
        }

        public static function get_texonomy_child_args( $texonomy, $texonomy_id, $return_args ){

                $term_children = get_term_children( absint( $texonomy_id ), $texonomy );

                $counter = absint( '0' );

                foreach( $term_children as $key => $value ){

                        $counter += get_term_by( 'id', $value, $texonomy )->$return_args;
                }

                return absint( $counter );
        }

        public static function create_select_option_e( $args, $default, $select = '' ){

            echo self:: create_select_option( $args, $default, $select = '' );
        }

        public static function create_select_option( $args, $default, $select = '' ){

            $_get_args = '';

            if( ! empty( $default ) ){

                if( WeddingCity_Loader:: array_condition( $default ) ){

                    foreach( $default as $key => $value ){

                        $_get_args .= sprintf( '<option value="%1$s">%2$s</option>', $key, $value );
                    }
                }

            }

            if( empty( $args ) )
                return;

            if( WeddingCity_Loader:: array_condition( $args ) ){

                foreach( $args as $key => $value ){

                    $_get_args .=

                    sprintf( '<option value="%2$s" %3$s>%1$s</option>', 
                        $value,
                            $key,
                                ( $key == $select ) ? esc_html( 'selected' ) : ''
                    );
                }
            }

            return $_get_args;
        }

        public static function get_parents_vendors(){

            return self:: get_texonomy_parent( self:: listing_category_taxonomy() );
        }

        public static function get_parents_locations(){

            return self:: get_texonomy_parent( self:: listing_location_taxonomy() );
        }


        public static function get_realwedding_category_list( $default = '', $label = '' ){

            return

            self:: create_select_option(

                self:: get_texonomy( self:: realwedding_category_taxonomy() ), 

                ( ! empty( $label ) ) ? $label : '',

                $default
            );
        }

        public static function get_vendors_list( $default = '', $label = '' ){

            return

            self:: create_select_option(

                self:: get_texonomy( self:: listing_category_taxonomy() ), 

                ( ! empty( $label ) ) ? $label : '',

                $default
            );
        }

        public static function get_location_list( $_taxonomy, $default = '', $_lable = '' ){

            return

            self:: create_select_option(

                self:: get_texonomy_parent( $_taxonomy ), 

                ( ! empty( $label ) ) ? $label : '',

                $default
            );
        }

        public static function get_location_child_list( $_taxonomy, $default = '', $label = '' ){

            return 

            self:: create_select_option(

                  self:: get_texonomy_child( $_taxonomy, $default ),

                  ( ! empty( $label ) ) ? $label : '',

                  $default
            ) ;
        }

        public static function weddingcity_get_term_name( $texonomy, $args_id, $result ){

            if( empty( $texonomy ) )
                return;

            $terms =  get_terms( $texonomy, array(

                        'hide_empty'    => false,
                        'orderby'       => 'name', 
                        'order'         => 'ASC',
                        'hierarchical'  => absint( '1' ),
            ) );

            $return = '';

            if( is_array( $terms ) && ! empty( $terms ) && count( $terms ) >= absint( '1' ) ){

                foreach( $terms as $key ){

                    if( $key->term_id == $args_id ){

                        if( $result != '' ){

                            $return = $key->$result;

                        }else{

                            $return = $key->name;
                        }
                    }
                }
            }

            return $return;
        }


        /**
         * 
         *   Return Vendor Texonomy Categorie link
         * 
         */
        public static function get_taxonomy_singular_link( $_post_id, $_category ){

            return

            esc_url(

                get_term_link(

                    WeddingCity_Texonomy:: weddingcity_get_term_name( $_category, 

                        // 1
                        wp_get_post_terms( $_post_id, $_category, array('fields' => 'ids') )[ 0 ],

                        // 2
                        'slug'
                    ), 

                    $_category 
                )
            );
        }


        /**
         *  Taxonomy Icon
         */
        public static function get_taxonomy_icon( $_post_id, $_category ){

            if( empty( $_post_id ) )
                return;

            $_category_icon = 

            get_term_meta(

                absint( array_values( wp_get_post_terms( $_post_id, $_category, array( 'fields' => 'ids' ) ) )[ 0 ] ),

                'weddingcity_texonomy_icon', 

                true 
            );

            if( $_category_icon != '0' ){

                return  esc_html( $_category_icon );

            }else{

                return

                get_term_meta(

                    absint( array_values( wp_get_post_terms( $_post_id, $_category, array( 'fields' => 'ids' ) ) )[ 0 ] ),

                    'term_icon', 

                    true 
                );
            }
        }

    }

    /**
    *  Kicking this off by calling 'get_instance()' method
    */
    WeddingCity_Texonomy::get_instance();
}

