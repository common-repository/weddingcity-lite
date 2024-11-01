<?php

/** 
 *  New
 */
if ( ! function_exists( 'weddingcity_listing_category' ) ) {

// Register Custom Taxonomy
function weddingcity_listing_category() {

	$labels = array(
		'name'                       => _x( 'Listing Category', 'Taxonomy General Name', 'weddingcity' ),
		'singular_name'              => _x( 'Listing Category', 'Taxonomy Singular Name', 'weddingcity' ),
		'menu_name'                  => __( 'Listing Categories', 'weddingcity' ),
		'all_items'                  => __( 'All Listing Category', 'weddingcity' ),
		'parent_item'                => __( 'Parent Listing Category', 'weddingcity' ),
		'parent_item_colon'          => __( 'Parent Listing Category:', 'weddingcity' ),
		'new_item_name'              => __( 'New Listing Category', 'weddingcity' ),
		'add_new_item'               => __( 'Add New Listing Category', 'weddingcity' ),
		'edit_item'                  => __( 'Edit Listing Category', 'weddingcity' ),
		'update_item'                => __( 'Update Listing Category', 'weddingcity' ),
		'view_item'                  => __( 'View Listing Category', 'weddingcity' ),
		'separate_items_with_commas' => __( 'Separate Listing Category with commas', 'weddingcity' ),
		'add_or_remove_items'        => __( 'Add or remove Listing Category', 'weddingcity' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'weddingcity' ),
		'popular_items'              => __( 'Popular Listing Category', 'weddingcity' ),
		'search_items'               => __( 'Search Listing category', 'weddingcity' ),
		'not_found'                  => __( 'Not Found', 'weddingcity' ),
		'no_terms'                   => __( 'No Listing Category', 'weddingcity' ),
		'items_list'                 => __( 'Listing category list', 'weddingcity' ),
		'items_list_navigation'      => __( 'Listing category list navigation', 'weddingcity' ),
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
	register_taxonomy( WeddingCity_Texonomy:: listing_category_taxonomy(), array( 'listing' ), $args );

}
add_action( 'init', 'weddingcity_listing_category', 0 );

}


/** 
 *  New
 */
if ( ! function_exists( 'weddingcity_listing_location' ) ) {

// Register Custom Taxonomy
function weddingcity_listing_location() {

	$labels = array(
		'name'                       => _x( 'Listing Location', 'Taxonomy General Name', 'weddingcity' ),
		'singular_name'              => _x( 'Listing Location', 'Taxonomy Singular Name', 'weddingcity' ),
		'menu_name'                  => __( 'Listing Locations', 'weddingcity' ),
		'all_items'                  => __( 'All Listing Location', 'weddingcity' ),
		'parent_item'                => __( 'Parent Listing Location', 'weddingcity' ),
		'parent_item_colon'          => __( 'Parent Listing Location:', 'weddingcity' ),
		'new_item_name'              => __( 'New Listing Location', 'weddingcity' ),
		'add_new_item'               => __( 'Add New Listing Location', 'weddingcity' ),
		'edit_item'                  => __( 'Edit Listing Location', 'weddingcity' ),
		'update_item'                => __( 'Update Listing Location', 'weddingcity' ),
		'view_item'                  => __( 'View Listing Location', 'weddingcity' ),
		'separate_items_with_commas' => __( 'Separate Listing Location with commas', 'weddingcity' ),
		'add_or_remove_items'        => __( 'Add or remove Listing Location', 'weddingcity' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'weddingcity' ),
		'popular_items'              => __( 'Popular Listing Location', 'weddingcity' ),
		'search_items'               => __( 'Search Listing Location', 'weddingcity' ),
		'not_found'                  => __( 'Not Found', 'weddingcity' ),
		'no_terms'                   => __( 'No Listing Location', 'weddingcity' ),
		'items_list'                 => __( 'Listing Location list', 'weddingcity' ),
		'items_list_navigation'      => __( 'Listing Location list navigation', 'weddingcity' ),
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
	register_taxonomy( WeddingCity_Texonomy:: listing_location_taxonomy(), array( 'listing' ), $args );

}
add_action( 'init', 'weddingcity_listing_location', 0 );

}



if ( ! function_exists( 'weddingcity_listing_tag' ) ) {

// Register Custom Taxonomy
function weddingcity_listing_tag() {

	$labels = array(
		'name'                       => _x( 'Listing Tag', 'Taxonomy General Name', 'weddingcity' ),
		'singular_name'              => _x( 'Listing Tag', 'Taxonomy Singular Name', 'weddingcity' ),
		'menu_name'                  => __( 'Listing Tags', 'weddingcity' ),
		'all_items'                  => __( 'All Listing Tag', 'weddingcity' ),
		'parent_item'                => __( 'Parent Listing Tag', 'weddingcity' ),
		'parent_item_colon'          => __( 'Parent Listing Tag:', 'weddingcity' ),
		'new_item_name'              => __( 'New Listing Tag Name', 'weddingcity' ),
		'add_new_item'               => __( 'Add New Listing Tag', 'weddingcity' ),
		'edit_item'                  => __( 'Edit Listing Tag', 'weddingcity' ),
		'update_item'                => __( 'Update Listing Tag', 'weddingcity' ),
		'view_item'                  => __( 'View Listing Tag', 'weddingcity' ),
		'separate_items_with_commas' => __( 'Separate Listing Tag with commas', 'weddingcity' ),
		'add_or_remove_items'        => __( 'Add or remove Listing Tag', 'weddingcity' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'weddingcity' ),
		'popular_items'              => __( 'Popular Listing Tag', 'weddingcity' ),
		'search_items'               => __( 'Search Listing Tag', 'weddingcity' ),
		'not_found'                  => __( 'Not Found', 'weddingcity' ),
		'no_terms'                   => __( 'No Listing Tag', 'weddingcity' ),
		'items_list'                 => __( 'Listing Tag list', 'weddingcity' ),
		'items_list_navigation'      => __( 'Listing Tag list navigation', 'weddingcity' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( WeddingCity_Texonomy:: listing_tag_taxonomy(), array( 'listing' ), $args );

}
add_action( 'init', 'weddingcity_listing_tag', 0 );

}