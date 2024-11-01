<?php

/**
 *  Texonomys Only.
 */


add_action( 'init', 'weddingcity_taxonomy_features', 0 );

function weddingcity_taxonomy_features(){

	$_wc_taxonomy = weddingcity_option( '_wc_taxonomy_switcher_' );

	if( $_wc_taxonomy == 'on' ){

		add_action( 'tgmpa_register', 'weddingcity_taxonomy_switch_required_plugins' );

		add_action( 'init', 'weddingcity__Vendor_Type', 5 );

		add_action( 'init', 'weddingcity__Location_Type', 10 );
	}
}

if ( ! function_exists( 'weddingcity__Location_Type' ) ) {

	// Register Custom Taxonomy
	function weddingcity__Location_Type() {

		$labels = array(
			'name'                       => _x( 'Locations', 'Taxonomy General Name', 'weddingcity' ),
			'singular_name'              => _x( 'Locations', 'Taxonomy Singular Name', 'weddingcity' ),
			'menu_name'                  => __( 'Locations', 'weddingcity' ),
			'all_items'                  => __( 'All Locations', 'weddingcity' ),
			'parent_item'                => __( 'Parent Locations', 'weddingcity' ),
			'parent_item_colon'          => __( 'Parent Locations:', 'weddingcity' ),
			'new_item_name'              => __( 'New Location', 'weddingcity' ),
			'add_new_item'               => __( 'Add New Location', 'weddingcity' ),
			'edit_item'                  => __( 'Edit Location', 'weddingcity' ),
			'update_item'                => __( 'Update Location', 'weddingcity' ),
			'view_item'                  => __( 'View Location', 'weddingcity' ),
			'separate_items_with_commas' => __( 'Separate Locations with commas', 'weddingcity' ),
			'add_or_remove_items'        => __( 'Add or remove Location', 'weddingcity' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'weddingcity' ),
			'popular_items'              => __( 'Popular Location', 'weddingcity' ),
			'search_items'               => __( 'Search Locations', 'weddingcity' ),
			'not_found'                  => __( 'Not Found', 'weddingcity' ),
			'no_terms'                   => __( 'No Locations', 'weddingcity' ),
			'items_list'                 => __( 'Locations list', 'weddingcity' ),
			'items_list_navigation'      => __( 'Locations list navigation', 'weddingcity' ),
		);

		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);

		register_taxonomy( 'location', array( 'listing' ), $args );
	}
}

/**
 *  Not Showing Old Category With Condition...
 */

if ( ! function_exists( 'weddingcity__Vendor_Type' ) ) {

	// Register Custom Taxonomy
	function weddingcity__Vendor_Type() {

		$labels = array(
			'name'                       => _x( 'Vendors', 'Taxonomy General Name', 'weddingcity' ),
			'singular_name'              => _x( 'Vendors', 'Taxonomy Singular Name', 'weddingcity' ),
			'menu_name'                  => __( 'Vendors', 'weddingcity' ),
			'all_items'                  => __( 'All Vendors', 'weddingcity' ),
			'parent_item'                => __( 'Vendors', 'weddingcity' ),
			'parent_item_colon'          => __( 'Vendors:', 'weddingcity' ),
			'new_item_name'              => __( 'Add New Vendors', 'weddingcity' ),
			'add_new_item'               => __( 'Add New Vendors', 'weddingcity' ),
			'edit_item'                  => __( 'Edit Vendors', 'weddingcity' ),
			'update_item'                => __( 'Update Vendors', 'weddingcity' ),
			'view_item'                  => __( 'View Vendors', 'weddingcity' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'weddingcity' ),
			'add_or_remove_items'        => __( 'Add or remove Vendors', 'weddingcity' ),
			'choose_from_most_used'      => __( 'Choose from the most used Vendors', 'weddingcity' ),
			'popular_items'              => __( 'Popular Vendor', 'weddingcity' ),
			'search_items'               => __( 'Search Vendor', 'weddingcity' ),
			'not_found'                  => __( 'Not Found Vendor', 'weddingcity' ),
			'no_terms'                   => __( 'No Vendor', 'weddingcity' ),
			'items_list'                 => __( 'Vendors list', 'weddingcity' ),
			'items_list_navigation'      => __( 'Vendors list navigation', 'weddingcity' ),
		);

		$args = array(
			
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'query_var' 				 => true,
			'rewrite' 					 => array( 'slug' => 'vendors', 'with_front' => true, 'hierarchical' => true  ),
		);

		register_taxonomy( 'vendors', array( 'listing' ), $args );
	}
}


if( ! function_exists( 'weddingcity_taxonomy_switch_required_plugins' ) ){

		function weddingcity_taxonomy_switch_required_plugins() {

			$plugins = array(

			    /**
			     *.  Taxonomy Switcher
			     */
			    
				array(
				    'name'      => esc_html( 'Taxonomy Switcher' ),
				    'slug'      => sanitize_title('Taxonomy Switcher'),
				    'required'  => true,
				),
			);

			$config = array(
				'id'           => 'weddingcity',             // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',                      // Default absolute path to bundled plugins.
				'menu'         => 'tgmpa-install-plugins', // Menu slug.
				'has_notices'  => true,                    // Show admin notices or not.
				'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => false,                   // Automatically activate plugins after installation or not.
				'message'      => '',                      // Message to output right before the plugins table.
			);

			tgmpa( $plugins, $config );
		}
}