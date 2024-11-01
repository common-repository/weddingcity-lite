<?php

/** 
 *  New
 */
if ( ! function_exists( 'weddingcity_realwedding_category' ) ) {

// Register Custom Taxonomy
function weddingcity_realwedding_category() {

	$labels = array(
		'name'                       => _x( 'RealWedding Category', 'Taxonomy General Name', 'weddingcity' ),
		'singular_name'              => _x( 'RealWedding Category', 'Taxonomy Singular Name', 'weddingcity' ),
		'menu_name'                  => __( 'RealWedding Categories', 'weddingcity' ),
		'all_items'                  => __( 'All RealWedding Category', 'weddingcity' ),
		'parent_item'                => __( 'Parent RealWedding Category', 'weddingcity' ),
		'parent_item_colon'          => __( 'Parent RealWedding Category:', 'weddingcity' ),
		'new_item_name'              => __( 'New RealWedding Category', 'weddingcity' ),
		'add_new_item'               => __( 'Add New RealWedding Category', 'weddingcity' ),
		'edit_item'                  => __( 'Edit RealWedding Category', 'weddingcity' ),
		'update_item'                => __( 'Update RealWedding Category', 'weddingcity' ),
		'view_item'                  => __( 'View RealWedding Category', 'weddingcity' ),
		'separate_items_with_commas' => __( 'Separate RealWedding Category with commas', 'weddingcity' ),
		'add_or_remove_items'        => __( 'Add or remove RealWedding Category', 'weddingcity' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'weddingcity' ),
		'popular_items'              => __( 'Popular RealWedding Category', 'weddingcity' ),
		'search_items'               => __( 'Search RealWedding category', 'weddingcity' ),
		'not_found'                  => __( 'Not Found', 'weddingcity' ),
		'no_terms'                   => __( 'No RealWedding Category', 'weddingcity' ),
		'items_list'                 => __( 'RealWedding category list', 'weddingcity' ),
		'items_list_navigation'      => __( 'RealWedding category list navigation', 'weddingcity' ),
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
	register_taxonomy( WeddingCity_Texonomy:: realwedding_category_taxonomy(), array( 'real-wedding' ), $args );

}
add_action( 'init', 'weddingcity_realwedding_category', 0 );

}


/** 
 *  New
 */
if ( ! function_exists( 'weddingcity_realwedding_location' ) ) {

// Register Custom Taxonomy
function weddingcity_realwedding_location() {

	$labels = array(
		'name'                       => _x( 'RealWedding Location', 'Taxonomy General Name', 'weddingcity' ),
		'singular_name'              => _x( 'RealWedding Location', 'Taxonomy Singular Name', 'weddingcity' ),
		'menu_name'                  => __( 'RealWedding Locations', 'weddingcity' ),
		'all_items'                  => __( 'All RealWedding Location', 'weddingcity' ),
		'parent_item'                => __( 'Parent RealWedding Location', 'weddingcity' ),
		'parent_item_colon'          => __( 'Parent RealWedding Location:', 'weddingcity' ),
		'new_item_name'              => __( 'New RealWedding Location', 'weddingcity' ),
		'add_new_item'               => __( 'Add New RealWedding Location', 'weddingcity' ),
		'edit_item'                  => __( 'Edit RealWedding Location', 'weddingcity' ),
		'update_item'                => __( 'Update RealWedding Location', 'weddingcity' ),
		'view_item'                  => __( 'View RealWedding Location', 'weddingcity' ),
		'separate_items_with_commas' => __( 'Separate RealWedding Location with commas', 'weddingcity' ),
		'add_or_remove_items'        => __( 'Add or remove RealWedding Location', 'weddingcity' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'weddingcity' ),
		'popular_items'              => __( 'Popular RealWedding Location', 'weddingcity' ),
		'search_items'               => __( 'Search RealWedding Location', 'weddingcity' ),
		'not_found'                  => __( 'Not Found', 'weddingcity' ),
		'no_terms'                   => __( 'No RealWedding Location', 'weddingcity' ),
		'items_list'                 => __( 'RealWedding Location list', 'weddingcity' ),
		'items_list_navigation'      => __( 'RealWedding Location list navigation', 'weddingcity' ),
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
	register_taxonomy( WeddingCity_Texonomy:: realwedding_location_taxonomy(), array( 'real-wedding' ), $args );

}
add_action( 'init', 'weddingcity_realwedding_location', 0 );

}



if ( ! function_exists( 'weddingcity_realwedding_tag' ) ) {

// Register Custom Taxonomy
function weddingcity_realwedding_tag() {

	$labels = array(
		'name'                       => _x( 'RealWedding Tag', 'Taxonomy General Name', 'weddingcity' ),
		'singular_name'              => _x( 'RealWedding Tag', 'Taxonomy Singular Name', 'weddingcity' ),
		'menu_name'                  => __( 'RealWedding Tags', 'weddingcity' ),
		'all_items'                  => __( 'All RealWedding Tag', 'weddingcity' ),
		'parent_item'                => __( 'Parent RealWedding Tag', 'weddingcity' ),
		'parent_item_colon'          => __( 'Parent RealWedding Tag:', 'weddingcity' ),
		'new_item_name'              => __( 'New RealWedding Tag Name', 'weddingcity' ),
		'add_new_item'               => __( 'Add New RealWedding Tag', 'weddingcity' ),
		'edit_item'                  => __( 'Edit RealWedding Tag', 'weddingcity' ),
		'update_item'                => __( 'Update RealWedding Tag', 'weddingcity' ),
		'view_item'                  => __( 'View RealWedding Tag', 'weddingcity' ),
		'separate_items_with_commas' => __( 'Separate RealWedding Tag with commas', 'weddingcity' ),
		'add_or_remove_items'        => __( 'Add or remove RealWedding Tag', 'weddingcity' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'weddingcity' ),
		'popular_items'              => __( 'Popular RealWedding Tag', 'weddingcity' ),
		'search_items'               => __( 'Search RealWedding Tag', 'weddingcity' ),
		'not_found'                  => __( 'Not Found', 'weddingcity' ),
		'no_terms'                   => __( 'No RealWedding Tag', 'weddingcity' ),
		'items_list'                 => __( 'RealWedding Tag list', 'weddingcity' ),
		'items_list_navigation'      => __( 'RealWedding Tag list navigation', 'weddingcity' ),
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
	register_taxonomy( WeddingCity_Texonomy:: realwedding_tag_taxonomy(), array( 'real-wedding' ), $args );

}
add_action( 'init', 'weddingcity_realwedding_tag', 0 );

}