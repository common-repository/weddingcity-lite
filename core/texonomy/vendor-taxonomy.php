<?php

/** 
 *  New
 */
if ( ! function_exists( 'weddingcity_vendor_category' ) ) {

// Register Custom Taxonomy
function weddingcity_vendor_category() {

	$labels = array(
		'name'                       => _x( 'Vendor Category', 'Taxonomy General Name', 'weddingcity' ),
		'singular_name'              => _x( 'Vendor Category', 'Taxonomy Singular Name', 'weddingcity' ),
		'menu_name'                  => __( 'Vendor Categories', 'weddingcity' ),
		'all_items'                  => __( 'All Vendor Category', 'weddingcity' ),
		'parent_item'                => __( 'Parent Vendor Category', 'weddingcity' ),
		'parent_item_colon'          => __( 'Parent Vendor Category:', 'weddingcity' ),
		'new_item_name'              => __( 'New Vendor Category', 'weddingcity' ),
		'add_new_item'               => __( 'Add New Vendor Category', 'weddingcity' ),
		'edit_item'                  => __( 'Edit Vendor Category', 'weddingcity' ),
		'update_item'                => __( 'Update Vendor Category', 'weddingcity' ),
		'view_item'                  => __( 'View Vendor Category', 'weddingcity' ),
		'separate_items_with_commas' => __( 'Separate Vendor Category with commas', 'weddingcity' ),
		'add_or_remove_items'        => __( 'Add or remove Vendor Category', 'weddingcity' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'weddingcity' ),
		'popular_items'              => __( 'Popular Vendor Category', 'weddingcity' ),
		'search_items'               => __( 'Search Vendor category', 'weddingcity' ),
		'not_found'                  => __( 'Not Found', 'weddingcity' ),
		'no_terms'                   => __( 'No Vendor Category', 'weddingcity' ),
		'items_list'                 => __( 'Vendor category list', 'weddingcity' ),
		'items_list_navigation'      => __( 'Vendor category list navigation', 'weddingcity' ),
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
	register_taxonomy( WeddingCity_Texonomy:: vendor_category_taxonomy(), array( 'vendor' ), $args );

}
add_action( 'init', 'weddingcity_vendor_category', 0 );

}


/** 
 *  New
 */
if ( ! function_exists( 'weddingcity_vendor_location' ) ) {

// Register Custom Taxonomy
function weddingcity_vendor_location() {

	$labels = array(
		'name'                       => _x( 'Vendor Location', 'Taxonomy General Name', 'weddingcity' ),
		'singular_name'              => _x( 'Vendor Location', 'Taxonomy Singular Name', 'weddingcity' ),
		'menu_name'                  => __( 'Vendor Locations', 'weddingcity' ),
		'all_items'                  => __( 'All Vendor Location', 'weddingcity' ),
		'parent_item'                => __( 'Parent Vendor Location', 'weddingcity' ),
		'parent_item_colon'          => __( 'Parent Vendor Location:', 'weddingcity' ),
		'new_item_name'              => __( 'New Vendor Location', 'weddingcity' ),
		'add_new_item'               => __( 'Add New Vendor Location', 'weddingcity' ),
		'edit_item'                  => __( 'Edit Vendor Location', 'weddingcity' ),
		'update_item'                => __( 'Update Vendor Location', 'weddingcity' ),
		'view_item'                  => __( 'View Vendor Location', 'weddingcity' ),
		'separate_items_with_commas' => __( 'Separate Vendor Location with commas', 'weddingcity' ),
		'add_or_remove_items'        => __( 'Add or remove Vendor Location', 'weddingcity' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'weddingcity' ),
		'popular_items'              => __( 'Popular Vendor Location', 'weddingcity' ),
		'search_items'               => __( 'Search Vendor Location', 'weddingcity' ),
		'not_found'                  => __( 'Not Found', 'weddingcity' ),
		'no_terms'                   => __( 'No Vendor Location', 'weddingcity' ),
		'items_list'                 => __( 'Vendor Location list', 'weddingcity' ),
		'items_list_navigation'      => __( 'Vendor Location list navigation', 'weddingcity' ),
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
	register_taxonomy( WeddingCity_Texonomy:: vendor_location_taxonomy(), array( 'vendor' ), $args );

}
add_action( 'init', 'weddingcity_vendor_location', 0 );

}



if ( ! function_exists( 'weddingcity_vendor_tag' ) ) {

// Register Custom Taxonomy
function weddingcity_vendor_tag() {

	$labels = array(
		'name'                       => _x( 'Vendor Tag', 'Taxonomy General Name', 'weddingcity' ),
		'singular_name'              => _x( 'Vendor Tag', 'Taxonomy Singular Name', 'weddingcity' ),
		'menu_name'                  => __( 'Vendor Tags', 'weddingcity' ),
		'all_items'                  => __( 'All Vendor Tag', 'weddingcity' ),
		'parent_item'                => __( 'Parent Vendor Tag', 'weddingcity' ),
		'parent_item_colon'          => __( 'Parent Vendor Tag:', 'weddingcity' ),
		'new_item_name'              => __( 'New Vendor Tag Name', 'weddingcity' ),
		'add_new_item'               => __( 'Add New Vendor Tag', 'weddingcity' ),
		'edit_item'                  => __( 'Edit Vendor Tag', 'weddingcity' ),
		'update_item'                => __( 'Update Vendor Tag', 'weddingcity' ),
		'view_item'                  => __( 'View Vendor Tag', 'weddingcity' ),
		'separate_items_with_commas' => __( 'Separate Vendor Tag with commas', 'weddingcity' ),
		'add_or_remove_items'        => __( 'Add or remove Vendor Tag', 'weddingcity' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'weddingcity' ),
		'popular_items'              => __( 'Popular Vendor Tag', 'weddingcity' ),
		'search_items'               => __( 'Search Vendor Tag', 'weddingcity' ),
		'not_found'                  => __( 'Not Found', 'weddingcity' ),
		'no_terms'                   => __( 'No Vendor Tag', 'weddingcity' ),
		'items_list'                 => __( 'Vendor Tag list', 'weddingcity' ),
		'items_list_navigation'      => __( 'Vendor Tag list navigation', 'weddingcity' ),
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
	register_taxonomy( WeddingCity_Texonomy:: vendor_tag_taxonomy(), array( 'vendor' ), $args );

}
add_action( 'init', 'weddingcity_vendor_tag', 0 );

}