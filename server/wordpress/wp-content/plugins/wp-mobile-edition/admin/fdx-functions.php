<?php
/**
 * Get Option.
 *
 * Helper function to return the option value.
 * If no value has been saved, it returns $default.
 *
 * @param     string    The option ID.
 * @param     string    The default option value.
 * @return    mixed
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'fdx_option' ) ) {

  function fdx_option( $option_id, $default = '' ) {

    /* get the saved options */
    $options = get_option( 'fdx_settings_2' );

    /* look for the saved value */
    if ( isset( $options[$option_id] ) && '' != $options[$option_id] ) {
      return $options[$option_id];
    }

    return $default;

  }

}

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
*/
register_nav_menus( array(
	'fdx_menu' => 'WP Mobile Edition'
//	'fdx_menu_2' => 'WP Mobile Edition: (2)-Topbar'
) );


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
*/
add_image_size( 'cat-thumb', 60, 60, true );



function fdx_mobile_itens() {
	$labels = array(
		'name' => __('Mobile Pages', 'wp-mobile-edition'),
		'singular_name' => __('Mobile Page', 'wp-mobile-edition'),
		'add_new' => __('Add New','wp-mobile-edition'),
		'add_new_item' => __('Add New Mobile Page', 'wp-mobile-edition'),
		'edit_item' => __('Edit Mobile Page', 'wp-mobile-edition'),
		'new_item' => __('New Mobile Page', 'wp-mobile-edition'),
		'view_item' => __('View Mobile Page', 'wp-mobile-edition'),
		'search_items' => __('Search Mobile Page', 'wp-mobile-edition'),
		'not_found' =>  __('Nothing found', 'wp-mobile-edition'),
		'not_found_in_trash' => __('Nothing found in Trash', 'wp-mobile-edition'),
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
 		'rewrite' => true,
		'capability_type' => 'page',
		'hierarchical' => false,
  		'menu_icon' => 'dashicons-admin-page',
 		'supports' => array('title', 'editor', 'thumbnail')
	  );

	register_post_type( 'mobile' , $args );
}

/*
function my_taxonomies_product() {
	$labels = array(
		'name'              => __( 'Mobile Categories' ),
		'singular_name'     => __( 'Mobile Category' ),
		'search_items'      => __( 'Search Mobile Categories' ),
		'all_items'         => __( 'All Mobile Categories' ),
		'parent_item'       => __( 'Parent Mobile Category' ),
		'parent_item_colon' => __( 'Parent Mobile Category:' ),
		'edit_item'         => __( 'Edit Mobile Category' ),
		'update_item'       => __( 'Update Mobile Category' ),
		'add_new_item'      => __( 'Add New Mobile Category' ),
		'new_item_name'     => __( 'New Mobile Category' ),
		'menu_name'         => __( 'Mobile Categories' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
	);
	register_taxonomy( 'mobile-cat', 'mobile', $args );
}
*/
