<?php

/**
 *   Custom Post Type Only.
 */

if( ! function_exists( 'WedListing_Post_Type_Listing' ) ){

	add_action( 'init', 'WedListing_Post_Type_Listing', absint('0') );

	function WedListing_Post_Type_Listing() {

		$labels = array(
			'name'                  => _x( 'Listings', 'Post Type General Name', 'weddingcity' ),
			'singular_name'         => _x( 'Listings', 'Post Type Singular Name', 'weddingcity' ),
			'menu_name'             => __( 'Listings', 'weddingcity' ),
			'name_admin_bar'        => __( 'Listings', 'weddingcity' ),
			'archives'              => __( 'Listing Archives', 'weddingcity' ),
			'attributes'            => __( 'Listing Attributes', 'weddingcity' ),
			'parent_item_colon'     => __( 'Listing Parent Item:', 'weddingcity' ),
			'all_items'             => __( 'All Listing', 'weddingcity' ),
			'add_new_item'          => __( 'Add New Listing', 'weddingcity' ),
			'add_new'               => __( 'Add New Listing', 'weddingcity' ),
			'new_item'              => __( 'New Item Listing', 'weddingcity' ),
			'edit_item'             => __( 'Edit Listing', 'weddingcity' ),
			'update_item'           => __( 'Update Listing', 'weddingcity' ),
			'view_item'             => __( 'View Listing', 'weddingcity' ),
			'view_items'            => __( 'View Listing', 'weddingcity' ),
			'search_items'          => __( 'Search Listing', 'weddingcity' ),
			'not_found'             => __( 'Not found Listing', 'weddingcity' ),
			'not_found_in_trash'    => __( 'Not found in Trash Listing', 'weddingcity' ),
			'featured_image'        => __( 'Featured Image For Listing', 'weddingcity' ),
			'set_featured_image'    => __( 'Set featured image For Listing', 'weddingcity' ),
			'remove_featured_image' => __( 'Remove featured image For Listing', 'weddingcity' ),
			'use_featured_image'    => __( 'Use as featured image In Listing', 'weddingcity' ),
			'insert_into_item'      => __( 'Insert into Listing', 'weddingcity' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Listing', 'weddingcity' ),
			'items_list'            => __( 'Listings', 'weddingcity' ),
			'items_list_navigation' => __( 'Listing list navigation', 'weddingcity' ),
			'filter_items_list'     => __( 'Filter Listing', 'weddingcity' ),
		);
		$args = array(
			'label'                 => __( 'Listings', 'weddingcity' ),
			'description'           => __( 'Vendor Can Easy to upload venue or business listing here', 'weddingcity' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'author' ),
			'taxonomies'            => array(), //array( 'post_tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => '20',
			'menu_icon'             => 'dashicons-clipboard',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'map_meta_cap' 			=> true,
			'query_var' 			=> true,
			'rewrite' 				=> array( 'slug' => 'listing', 'with_front' => true	),
		);
		register_post_type( 'listing', $args );

	}
}

if( ! function_exists( 'WedListing_Post_Type_Couple' ) ){

	add_action( 'init', 'WedListing_Post_Type_Couple', absint('0') );

	function WedListing_Post_Type_Couple() {

		$labels = array(
			'name'                  => _x( 'Couple', 'Post Type General Name', 'weddingcity' ),
			'singular_name'         => _x( 'Couple', 'Post Type Singular Name', 'weddingcity' ),
			'menu_name'             => __( 'Couple', 'weddingcity' ),
			'name_admin_bar'        => __( 'Couple', 'weddingcity' ),
			'archives'              => __( 'Couple Archives', 'weddingcity' ),
			'attributes'            => __( 'Couple Attributes', 'weddingcity' ),
			'parent_item_colon'     => __( 'Couple Parent Item:', 'weddingcity' ),
			'all_items'             => __( 'All Couple', 'weddingcity' ),
			'add_new_item'          => __( 'Add New Couple', 'weddingcity' ),
			'add_new'               => __( 'Add New Couple', 'weddingcity' ),
			'new_item'              => __( 'New Item Couple', 'weddingcity' ),
			'edit_item'             => __( 'Edit Couple', 'weddingcity' ),
			'update_item'           => __( 'Update Couple', 'weddingcity' ),
			'view_item'             => __( 'View Couple', 'weddingcity' ),
			'view_items'            => __( 'View Couple', 'weddingcity' ),
			'search_items'          => __( 'Search Couple', 'weddingcity' ),
			'not_found'             => __( 'Not found Couple', 'weddingcity' ),
			'not_found_in_trash'    => __( 'Not found in Trash Couple', 'weddingcity' ),
			'featured_image'        => __( 'Featured Image For Couple', 'weddingcity' ),
			'set_featured_image'    => __( 'Set featured image For Couple', 'weddingcity' ),
			'remove_featured_image' => __( 'Remove featured image For Couple', 'weddingcity' ),
			'use_featured_image'    => __( 'Use as featured image In Couple', 'weddingcity' ),
			'insert_into_item'      => __( 'Insert into Couple', 'weddingcity' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Couple', 'weddingcity' ),
			'items_list'            => __( 'Couple', 'weddingcity' ),
			'items_list_navigation' => __( 'Couple list navigation', 'weddingcity' ),
			'filter_items_list'     => __( 'Filter Couple', 'weddingcity' ),
		);
		$args = array(
			'label'                 => __( 'Couple', 'weddingcity' ),
			'description'           => __( 'Vendor Can Easy to upload venue or business couple here', 'weddingcity' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			'taxonomies'            => array(), //array( 'post_tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => '21',
			'menu_icon'             => 'dashicons-heart',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'map_meta_cap' 			=> true,
			'query_var' 			=> true,
			'rewrite' 				=> array( 'slug' => 'couple', 'with_front' => true	),
		);
		register_post_type( 'couple', $args );

	}
}


if( ! function_exists( 'WedListing_Post_Type_Vendor' ) ){

	add_action( 'init', 'WedListing_Post_Type_Vendor', absint('0') );

	function WedListing_Post_Type_Vendor() {

		$labels = array(
			'name'                  => _x( 'Vendor', 'Post Type General Name', 'weddingcity' ),
			'singular_name'         => _x( 'Vendor', 'Post Type Singular Name', 'weddingcity' ),
			'menu_name'             => __( 'Vendor', 'weddingcity' ),
			'name_admin_bar'        => __( 'Vendor', 'weddingcity' ),
			'archives'              => __( 'Vendor Archives', 'weddingcity' ),
			'attributes'            => __( 'Vendor Attributes', 'weddingcity' ),
			'parent_item_colon'     => __( 'Vendor Parent Item:', 'weddingcity' ),
			'all_items'             => __( 'All Vendor', 'weddingcity' ),
			'add_new_item'          => __( 'Add New Vendor', 'weddingcity' ),
			'add_new'               => __( 'Add New Vendor', 'weddingcity' ),
			'new_item'              => __( 'New Item Vendor', 'weddingcity' ),
			'edit_item'             => __( 'Edit Vendor', 'weddingcity' ),
			'update_item'           => __( 'Update Vendor', 'weddingcity' ),
			'view_item'             => __( 'View Vendor', 'weddingcity' ),
			'view_items'            => __( 'View Vendor', 'weddingcity' ),
			'search_items'          => __( 'Search Vendor', 'weddingcity' ),
			'not_found'             => __( 'Not found Vendor', 'weddingcity' ),
			'not_found_in_trash'    => __( 'Not found in Trash Vendor', 'weddingcity' ),
			'featured_image'        => __( 'Featured Image For Vendor', 'weddingcity' ),
			'set_featured_image'    => __( 'Set featured image For Vendor', 'weddingcity' ),
			'remove_featured_image' => __( 'Remove featured image For Vendor', 'weddingcity' ),
			'use_featured_image'    => __( 'Use as featured image In Vendor', 'weddingcity' ),
			'insert_into_item'      => __( 'Insert into Vendor', 'weddingcity' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Vendor', 'weddingcity' ),
			'items_list'            => __( 'Vendor', 'weddingcity' ),
			'items_list_navigation' => __( 'Vendor list navigation', 'weddingcity' ),
			'filter_items_list'     => __( 'Filter Vendor', 'weddingcity' ),
		);
		$args = array(
			'label'                 => __( 'Vendor', 'weddingcity' ),
			'description'           => __( 'Vendor Can Easy to upload venue or business vendor here', 'weddingcity' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			'taxonomies'            => array(), //array( 'post_tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => '22',
			'menu_icon'             => 'dashicons-store',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'map_meta_cap' 			=> true,
			'query_var' 			=> true,
			'rewrite' 				=> array( 'slug' => 'vendor', 'with_front' => true	),
		);
		register_post_type( 'vendor', $args );

	}
}

// Real Wedding

if( ! function_exists( 'WedListing_Post_Type_Real_Wedding' ) ){

	add_action( 'init', 'WedListing_Post_Type_Real_Wedding', absint('0') );

	function WedListing_Post_Type_Real_Wedding() {

		$labels = array(
			'name'                  => _x( 'Real Wedding', 'Post Type General Name', 'weddingcity' ),
			'singular_name'         => _x( 'Real Wedding', 'Post Type Singular Name', 'weddingcity' ),
			'menu_name'             => __( 'Real Wedding', 'weddingcity' ),
			'name_admin_bar'        => __( 'Real Wedding', 'weddingcity' ),
			'archives'              => __( 'Real Wedding Archives', 'weddingcity' ),
			'attributes'            => __( 'Real Wedding Attributes', 'weddingcity' ),
			'parent_item_colon'     => __( 'Real Wedding Parent Item:', 'weddingcity' ),
			'all_items'             => __( 'All Real Wedding', 'weddingcity' ),
			'add_new_item'          => __( 'Add New Real Wedding', 'weddingcity' ),
			'add_new'               => __( 'Add New Real Wedding', 'weddingcity' ),
			'new_item'              => __( 'New Item Real Wedding', 'weddingcity' ),
			'edit_item'             => __( 'Edit Real Wedding', 'weddingcity' ),
			'update_item'           => __( 'Update Real Wedding', 'weddingcity' ),
			'view_item'             => __( 'View Real Wedding', 'weddingcity' ),
			'view_items'            => __( 'View Real Wedding', 'weddingcity' ),
			'search_items'          => __( 'Search Real Wedding', 'weddingcity' ),
			'not_found'             => __( 'Not found Real Wedding', 'weddingcity' ),
			'not_found_in_trash'    => __( 'Not found in Trash Real Wedding', 'weddingcity' ),
			'featured_image'        => __( 'Featured Image For Real Wedding', 'weddingcity' ),
			'set_featured_image'    => __( 'Set featured image For Real Wedding', 'weddingcity' ),
			'remove_featured_image' => __( 'Remove featured image For Real Wedding', 'weddingcity' ),
			'use_featured_image'    => __( 'Use as featured image In Real Wedding', 'weddingcity' ),
			'insert_into_item'      => __( 'Insert into Real Wedding', 'weddingcity' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Real Wedding', 'weddingcity' ),
			'items_list'            => __( 'Real Wedding', 'weddingcity' ),
			'items_list_navigation' => __( 'Real Wedding list navigation', 'weddingcity' ),
			'filter_items_list'     => __( 'Filter Real Wedding', 'weddingcity' ),
		);
		
		$args = array(
			'label'                 => __( 'Real Wedding', 'weddingcity' ),
			'description'           => __( 'Couple Can upload own wedding photoes, videoes and stories.', 'weddingcity' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			'taxonomies'            => array(),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => '23',
			'menu_icon'             => 'dashicons-format-gallery',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'map_meta_cap' 			=> true,
			'query_var' 			=> true,
			'rewrite' 				=> array( 'slug' => 'real-wedding', 'with_front' => true ),
		);
		register_post_type( 'real-wedding', $args );

	}
}


