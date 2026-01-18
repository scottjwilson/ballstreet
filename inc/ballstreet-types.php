<?php
/**
 * Custom Post Types for Ball Street Journal
 * 
 * Registers custom post types for Athletes, Schools, and Sponsors
 * Designed to work with ACF relationship fields
 */


/**
 * Register Athletes Custom Post Type
 */
function ballstreet_register_athletes_post_type() {
	$labels = array(
		'name'                  => _x( 'Athletes', 'Post Type General Name', 'ballstreet' ),
		'singular_name'         => _x( 'Athlete', 'Post Type Singular Name', 'ballstreet' ),
		'rewrite'               => array( 'slug' => 'athletes' ),
		'menu_name'             => __( 'Athletes', 'ballstreet' ),
		'name_admin_bar'        => __( 'Athlete', 'ballstreet' ),
		'archives'              => __( 'Athlete Archives', 'ballstreet' ),
		'attributes'            => __( 'Athlete Attributes', 'ballstreet' ),
		'parent_item_colon'     => __( 'Parent Athlete:', 'ballstreet' ),
		'all_items'             => __( 'All Athletes', 'ballstreet' ),
		'add_new_item'          => __( 'Add New Athlete', 'ballstreet' ),
		'add_new'               => __( 'Add New', 'ballstreet' ),
		'new_item'              => __( 'New Athlete', 'ballstreet' ),
		'edit_item'             => __( 'Edit Athlete', 'ballstreet' ),
		'update_item'           => __( 'Update Athlete', 'ballstreet' ),
		'view_item'             => __( 'View Athlete', 'ballstreet' ),
		'view_items'            => __( 'View Athletes', 'ballstreet' ),
		'search_items'          => __( 'Search Athlete', 'ballstreet' ),
		'not_found'             => __( 'Not found', 'ballstreet' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'ballstreet' ),
		'featured_image'        => __( 'Featured Image', 'ballstreet' ),
		'set_featured_image'    => __( 'Set featured image', 'ballstreet' ),
		'remove_featured_image' => __( 'Remove featured image', 'ballstreet' ),
		'use_featured_image'    => __( 'Use as featured image', 'ballstreet' ),
		'insert_into_item'      => __( 'Insert into athlete', 'ballstreet' ),
		'uploaded_to_this_item' => __( 'Uploaded to this athlete', 'ballstreet' ),
		'items_list'            => __( 'Athletes list', 'ballstreet' ),
		'items_list_navigation' => __( 'Athletes list navigation', 'ballstreet' ),
		'filter_items_list'     => __( 'Filter athletes list', 'ballstreet' ),
	);

	$args = array(
		'label'                 => __( 'Athlete', 'ballstreet' ),
		'description'           => __( 'Athlete profiles and information', 'ballstreet' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => "athletes",
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rest_base'             => 'athletes',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	);

	register_post_type( 'athlete', $args );
}
add_action( 'init', 'ballstreet_register_athletes_post_type', 0 );

/**
 * Register Schools Custom Post Type
 */
function ballstreet_register_schools_post_type() {
	$labels = array(
		'name'                  => _x( 'Schools', 'Post Type General Name', 'ballstreet' ),
		'singular_name'         => _x( 'School', 'Post Type Singular Name', 'ballstreet' ),
		'menu_name'             => __( 'Schools', 'ballstreet' ),
		'name_admin_bar'        => __( 'School', 'ballstreet' ),
		'archives'              => __( 'School Archives', 'ballstreet' ),
		'attributes'            => __( 'School Attributes', 'ballstreet' ),
		'parent_item_colon'     => __( 'Parent School:', 'ballstreet' ),
		'all_items'             => __( 'All Schools', 'ballstreet' ),
		'add_new_item'          => __( 'Add New School', 'ballstreet' ),
		'add_new'               => __( 'Add New', 'ballstreet' ),
		'new_item'              => __( 'New School', 'ballstreet' ),
		'edit_item'             => __( 'Edit School', 'ballstreet' ),
		'update_item'           => __( 'Update School', 'ballstreet' ),
		'view_item'             => __( 'View School', 'ballstreet' ),
		'view_items'            => __( 'View Schools', 'ballstreet' ),
		'search_items'          => __( 'Search School', 'ballstreet' ),
		'not_found'             => __( 'Not found', 'ballstreet' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'ballstreet' ),
		'featured_image'        => __( 'Featured Image', 'ballstreet' ),
		'set_featured_image'    => __( 'Set featured image', 'ballstreet' ),
		'remove_featured_image' => __( 'Remove featured image', 'ballstreet' ),
		'use_featured_image'    => __( 'Use as featured image', 'ballstreet' ),
		'insert_into_item'      => __( 'Insert into school', 'ballstreet' ),
		'uploaded_to_this_item' => __( 'Uploaded to this school', 'ballstreet' ),
		'items_list'            => __( 'Schools list', 'ballstreet' ),
		'items_list_navigation' => __( 'Schools list navigation', 'ballstreet' ),
		'filter_items_list'     => __( 'Filter schools list', 'ballstreet' ),
	);

	$args = array(
		'label'                 => __( 'School', 'ballstreet' ),
		'description'           => __( 'School profiles and information', 'ballstreet' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 6,
		'menu_icon'             => 'dashicons-welcome-learn-more',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rest_base'             => 'schools',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	);

	register_post_type( 'school', $args );
}
add_action( 'init', 'ballstreet_register_schools_post_type', 0 );

/**
 * Register Sponsors Custom Post Type
 */
function ballstreet_register_sponsors_post_type() {
	$labels = array(
		'name'                  => _x( 'Sponsors', 'Post Type General Name', 'ballstreet' ),
		'singular_name'         => _x( 'Sponsor', 'Post Type Singular Name', 'ballstreet' ),
		'menu_name'             => __( 'Sponsors', 'ballstreet' ),
		'name_admin_bar'        => __( 'Sponsor', 'ballstreet' ),
		'archives'              => __( 'Sponsor Archives', 'ballstreet' ),
		'attributes'            => __( 'Sponsor Attributes', 'ballstreet' ),
		'parent_item_colon'     => __( 'Parent Sponsor:', 'ballstreet' ),
		'all_items'             => __( 'All Sponsors', 'ballstreet' ),
		'add_new_item'          => __( 'Add New Sponsor', 'ballstreet' ),
		'add_new'               => __( 'Add New', 'ballstreet' ),
		'new_item'              => __( 'New Sponsor', 'ballstreet' ),
		'edit_item'             => __( 'Edit Sponsor', 'ballstreet' ),
		'update_item'           => __( 'Update Sponsor', 'ballstreet' ),
		'view_item'             => __( 'View Sponsor', 'ballstreet' ),
		'view_items'            => __( 'View Sponsors', 'ballstreet' ),
		'search_items'          => __( 'Search Sponsor', 'ballstreet' ),
		'not_found'             => __( 'Not found', 'ballstreet' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'ballstreet' ),
		'featured_image'        => __( 'Featured Image', 'ballstreet' ),
		'set_featured_image'    => __( 'Set featured image', 'ballstreet' ),
		'remove_featured_image' => __( 'Remove featured image', 'ballstreet' ),
		'use_featured_image'    => __( 'Use as featured image', 'ballstreet' ),
		'insert_into_item'      => __( 'Insert into sponsor', 'ballstreet' ),
		'uploaded_to_this_item' => __( 'Uploaded to this sponsor', 'ballstreet' ),
		'items_list'            => __( 'Sponsors list', 'ballstreet' ),
		'items_list_navigation' => __( 'Sponsors list navigation', 'ballstreet' ),
		'filter_items_list'     => __( 'Filter sponsors list', 'ballstreet' ),
	);

	$args = array(
		'label'                 => __( 'Sponsor', 'ballstreet' ),
		'description'           => __( 'Sponsor profiles and information', 'ballstreet' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 7,
		'menu_icon'             => 'dashicons-star-filled',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rest_base'             => 'sponsors',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	);

	register_post_type( 'sponsor', $args );
}
add_action( 'init', 'ballstreet_register_sponsors_post_type', 0 );