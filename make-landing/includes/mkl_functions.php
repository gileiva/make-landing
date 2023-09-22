<?php

/*
 * The "Make Landings Plugin's" functions
 */

// Adding to core
add_action('init', 'mkl_make_landing_page' );

// The function that call to register_post_type
function mkl_make_landing_page() {

  // The plugin's labels
  $labels = array(
    'name'                  => _x( 'Landings', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Landing Page', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Landing', 'text_domain' ),
		'name_admin_bar'        => __( 'Landing', 'text_domain' ),
		'archives'              => __( 'Landing Archives', 'text_domain' ),
		'attributes'            => __( 'Landing Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Landing:', 'text_domain' ),
		'all_items'             => __( 'All Landings', 'text_domain' ),
		'add_new_item'          => __( 'Add New Landing', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Landing', 'text_domain' ),
		'edit_item'             => __( 'Edit Landing', 'text_domain' ),
		'update_item'           => __( 'Update Landing', 'text_domain' ),
		'view_item'             => __( 'View Landing', 'text_domain' ),
		'view_items'            => __( 'View Landings', 'text_domain' ),
		'search_items'          => __( 'Search Landing', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
  );

  // The plugin's keys that add value to "Make Landings"
  $args = array(
    
    'labels'              => $labels,
    'description'         => 'A plugin that organizes and categorizes your landing pages. Make powerful landings following our recommendations.',
    
    'public'              => true,
    'menu_position'       => 5,
    'show_in_nav_menus'   => true,
    'supports'            => array('title', 'editor', 'excerpt', 'custom-fields', 'revisions', 'page-attributes', 'post-formats'),
    'hierarchical'        => true,
    'show_ui'             => true,
    'menu_icon'             => 'dashicons-admin-page',
    'show_in_menu'          => true,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
  );

  register_post_type('landings', $args);
}

// Add taxonomies to define landing types

add_action( 'init', 'mkl_landing_invitaciones', 0 );  

function mkl_landing_invitaciones() {

  $labels = array(
    'name'             => _x( 'Types', 'taxonomy general name' ),
    'singular_name'    => _x( 'Type', 'taxonomy singular name' ),
    'search_items'     =>  __( 'Search' ),
    'all_items'        => __( 'All Types' ),
    'parent_item'      => __( 'Parent Type' ),
    'parent_item_colon'=> __( 'Parent Type Plus:' ),
    'edit_item'        => __( 'Edit Type' ),
    'update_item'      => __( 'Update Type' ),
    'add_new_item'     => __( 'Add New Type' ),
    'new_item_name'    => __( 'New Type Name' ),
  );
  
  /* Register taxonomies and define hierarchical*/
  register_taxonomy( 'type', array( 'landings' ), array(
    'hierarchical'       => true,
    'labels'             => $labels,
    'show_ui'            => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'type' ),
  ));
  
}

/* Add landings option to dropdown "Homepage Displays"*/

function mkl_add_landings_to_dropdown( $pages ){
    $args = array(
        'post_type' => 'landings'
    );
    $items = get_posts($args);
    $pages = array_merge($pages, $items);

    return $pages;
}
add_filter( 'get_pages', 'mkl_add_landings_to_dropdown' );

function mkl_enable_front_page_landings( $query ){
    if('' == $query->query_vars['post_type'] && 0 != $query->query_vars['page_id'])
        $query->query_vars['post_type'] = array( 'page', 'landings' );
}
add_action( 'pre_get_posts', 'mkl_enable_front_page_landings' );

