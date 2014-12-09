<?php
// Custom post types
function portfolio_post_init() {
  $portfoliolabels = array(
    'name' =>  __('Portfolio', 'virtue'),
    'singular_name' => __('Portfolio Item', 'virtue'),
    'add_new' => __('Add New', 'virtue'),
    'add_new_item' => __('Add New Portfolio Item', 'virtue'),
    'edit_item' => __('Edit Portfolio Item', 'virtue'),
    'new_item' => __('New Portfolio Item', 'virtue'),
    'all_items' => __('All Portfolio', 'virtue'),
    'view_item' => __('View Portfolio Item', 'virtue'),
    'search_items' => __('Search Portfolio', 'virtue'),
    'not_found' =>  __('No Portfolio Item found', 'virtue'),
    'not_found_in_trash' => __('No Portfolio Items found in Trash', 'virtue'),
    'parent_item_colon' => '',
    'menu_name' => __('Portfolio', 'virtue')
  );

  $portargs = array(
    'labels' => $portfoliolabels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite'  => array( 'slug' => 'portfolio' ), /* you can specify its url slug */
    'has_archive' => false, 
    'capability_type' => 'post', 
    'hierarchical' => false,
    'menu_position' => 8,
    'menu_icon' =>  'dashicons-format-gallery',
    'supports' => array( 'title', 'editor', 'author', 'page-attributes', 'thumbnail', 'comments' )
  ); 
  // Initialize Taxonomy Labels
	$worklabels = array(
		'name' => __( 'Portfolio Type', 'virtue' ),
		'singular_name' => __( 'Type', 'virtue' ),
		'search_items' =>  __( 'Search Type', 'virtue' ),
		'all_items' => __( 'All Type', 'virtue' ),
		'parent_item' => __( 'Parent Type', 'virtue' ),
		'parent_item_colon' => __( 'Parent Type:', 'virtue' ),
		'edit_item' => __( 'Edit Type', 'virtue' ),
		'update_item' => __( 'Update Type', 'virtue' ),
		'add_new_item' => __( 'Add New Type', 'virtue' ),
		'new_item_name' => __( 'New Type Name', 'virtue' ),
	);
	// Register Custom Taxonomy
	register_taxonomy('portfolio-type',array('portfolio'), array(
		'hierarchical' => true, // define whether to use a system like tags or categories
		'labels' => $worklabels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
	));

  register_post_type( 'portfolio', $portargs );
}
add_action( 'init', 'portfolio_post_init', 1 );
	
