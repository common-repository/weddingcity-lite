<?php

/** 
 *  New
 */
if ( ! function_exists( 'weddingcity_couple_category' ) ) {

// Register Custom Taxonomy
function weddingcity_couple_category() {

	$labels = array(
		'name'                       => _x( 'Couple Category', 'Taxonomy General Name', 'weddingcity' ),
		'singular_name'              => _x( 'Couple Category', 'Taxonomy Singular Name', 'weddingcity' ),
		'menu_name'                  => __( 'Couple Categories', 'weddingcity' ),
		'all_items'                  => __( 'All Couple Category', 'weddingcity' ),
		'parent_item'                => __( 'Parent Couple Category', 'weddingcity' ),
		'parent_item_colon'          => __( 'Parent Couple Category:', 'weddingcity' ),
		'new_item_name'              => __( 'New Couple Category', 'weddingcity' ),
		'add_new_item'               => __( 'Add New Couple Category', 'weddingcity' ),
		'edit_item'                  => __( 'Edit Couple Category', 'weddingcity' ),
		'update_item'                => __( 'Update Couple Category', 'weddingcity' ),
		'view_item'                  => __( 'View Couple Category', 'weddingcity' ),
		'separate_items_with_commas' => __( 'Separate Couple Category with commas', 'weddingcity' ),
		'add_or_remove_items'        => __( 'Add or remove Couple Category', 'weddingcity' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'weddingcity' ),
		'popular_items'              => __( 'Popular Couple Category', 'weddingcity' ),
		'search_items'               => __( 'Search Couple category', 'weddingcity' ),
		'not_found'                  => __( 'Not Found', 'weddingcity' ),
		'no_terms'                   => __( 'No Couple Category', 'weddingcity' ),
		'items_list'                 => __( 'Couple category list', 'weddingcity' ),
		'items_list_navigation'      => __( 'Couple category list navigation', 'weddingcity' ),
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
	register_taxonomy( WeddingCity_Texonomy:: couple_category_taxonomy(), array( 'couple' ), $args );

}
add_action( 'init', 'weddingcity_couple_category', 0 );

}


/** 
 *  New
 */
if ( ! function_exists( 'weddingcity_couple_location' ) ) {

// Register Custom Taxonomy
function weddingcity_couple_location() {

	$labels = array(
		'name'                       => _x( 'Couple Location', 'Taxonomy General Name', 'weddingcity' ),
		'singular_name'              => _x( 'Couple Location', 'Taxonomy Singular Name', 'weddingcity' ),
		'menu_name'                  => __( 'Couple Locations', 'weddingcity' ),
		'all_items'                  => __( 'All Couple Location', 'weddingcity' ),
		'parent_item'                => __( 'Parent Couple Location', 'weddingcity' ),
		'parent_item_colon'          => __( 'Parent Couple Location:', 'weddingcity' ),
		'new_item_name'              => __( 'New Couple Location', 'weddingcity' ),
		'add_new_item'               => __( 'Add New Couple Location', 'weddingcity' ),
		'edit_item'                  => __( 'Edit Couple Location', 'weddingcity' ),
		'update_item'                => __( 'Update Couple Location', 'weddingcity' ),
		'view_item'                  => __( 'View Couple Location', 'weddingcity' ),
		'separate_items_with_commas' => __( 'Separate Couple Location with commas', 'weddingcity' ),
		'add_or_remove_items'        => __( 'Add or remove Couple Location', 'weddingcity' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'weddingcity' ),
		'popular_items'              => __( 'Popular Couple Location', 'weddingcity' ),
		'search_items'               => __( 'Search Couple Location', 'weddingcity' ),
		'not_found'                  => __( 'Not Found', 'weddingcity' ),
		'no_terms'                   => __( 'No Couple Location', 'weddingcity' ),
		'items_list'                 => __( 'Couple Location list', 'weddingcity' ),
		'items_list_navigation'      => __( 'Couple Location list navigation', 'weddingcity' ),
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
	register_taxonomy( WeddingCity_Texonomy:: couple_location_taxonomy(), array( 'couple' ), $args );

}
add_action( 'init', 'weddingcity_couple_location', 0 );

}



if ( ! function_exists( 'weddingcity_couple_tag' ) ) {

// Register Custom Taxonomy
function weddingcity_couple_tag() {

	$labels = array(
		'name'                       => _x( 'Couple Tag', 'Taxonomy General Name', 'weddingcity' ),
		'singular_name'              => _x( 'Couple Tag', 'Taxonomy Singular Name', 'weddingcity' ),
		'menu_name'                  => __( 'Couple Tags', 'weddingcity' ),
		'all_items'                  => __( 'All Couple Tag', 'weddingcity' ),
		'parent_item'                => __( 'Parent Couple Tag', 'weddingcity' ),
		'parent_item_colon'          => __( 'Parent Couple Tag:', 'weddingcity' ),
		'new_item_name'              => __( 'New Couple Tag Name', 'weddingcity' ),
		'add_new_item'               => __( 'Add New Couple Tag', 'weddingcity' ),
		'edit_item'                  => __( 'Edit Couple Tag', 'weddingcity' ),
		'update_item'                => __( 'Update Couple Tag', 'weddingcity' ),
		'view_item'                  => __( 'View Couple Tag', 'weddingcity' ),
		'separate_items_with_commas' => __( 'Separate Couple Tag with commas', 'weddingcity' ),
		'add_or_remove_items'        => __( 'Add or remove Couple Tag', 'weddingcity' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'weddingcity' ),
		'popular_items'              => __( 'Popular Couple Tag', 'weddingcity' ),
		'search_items'               => __( 'Search Couple Tag', 'weddingcity' ),
		'not_found'                  => __( 'Not Found', 'weddingcity' ),
		'no_terms'                   => __( 'No Couple Tag', 'weddingcity' ),
		'items_list'                 => __( 'Couple Tag list', 'weddingcity' ),
		'items_list_navigation'      => __( 'Couple Tag list navigation', 'weddingcity' ),
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
	register_taxonomy( WeddingCity_Texonomy:: couple_tag_taxonomy(), array( 'couple' ), $args );

}
add_action( 'init', 'weddingcity_couple_tag', 0 );

}