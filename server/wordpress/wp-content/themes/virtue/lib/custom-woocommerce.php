<?php 
/*-----------------------------------------------------------------------------------*/
/* This theme supports WooCommerce */
/*-----------------------------------------------------------------------------------*/

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
  add_theme_support( 'woocommerce' );
}
/*-----------------------------------------------------------------------------------*/
/* WooCommerce Functions */
/*-----------------------------------------------------------------------------------*/

if (class_exists('woocommerce')) {

  // Disable WooCommerce styles
  if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
  add_filter( 'woocommerce_enqueue_styles', '__return_false' );
  } else {
    define( 'WOOCOMMERCE_USE_CSS', false );
  }
  // Disable WooCommerce Lightbox
  update_option( 'woocommerce_enable_lightbox', false );
    
}
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
// Redefine woocommerce_output_related_products()
function kad_woo_related_products_limit() {
  global $product, $woocommerce;
  $related = $product->get_related();
  $args = array(
    'post_type'           => 'product',
    'no_found_rows'       => 1,
    'posts_per_page'      => 4,
    'ignore_sticky_posts'   => 1,
    //'orderby'               => $orderby,
    'post__in'              => $related,
    'post__not_in'          => array($product->id)
  );
  return $args;
}
add_filter( 'woocommerce_related_products_args', 'kad_woo_related_products_limit' );
// Number of products per page
add_filter('loop_shop_per_page', 'wooframework_products_per_page');
if (!function_exists('wooframework_products_per_page')) {
  function wooframework_products_per_page() {
    global $virtue;
    if ( isset( $virtue['products_per_page'] ) ) {
      return $virtue['products_per_page'];
    }
  }
}

// Display product tabs?
add_action('wp_head','wooframework_tab_check');
if ( ! function_exists( 'wooframework_tab_check' ) ) {
  function wooframework_tab_check() {
    global $virtue;
    if ( isset( $virtue[ 'product_tabs' ] ) && $virtue[ 'product_tabs' ] == "0" ) {
      remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
    }
  }
}

// Display related products?
add_action('wp_head','wooframework_related_products');
if ( ! function_exists( 'wooframework_related_products' ) ) {
  function wooframework_related_products() {
    global $virtue;
    if ( isset( $virtue[ 'related_products' ] ) && $virtue[ 'related_products' ] == "0" ) {
      remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    }
  }
}
//add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
function woocommerce_category_image() {
    if ( is_product_category() ){
      global $wp_query;
      $cat = $wp_query->get_queried_object();
      $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
      $image = wp_get_attachment_url( $thumbnail_id );
      global $virtue; if( isset( $virtue[ 'shop_layout' ] ) && $virtue[ 'shop_layout' ] == "sidebar" ) {$cat_width = 770;} else {$cat_width = 1140;}
      $sizeimage = aq_resize($image, $cat_width, 300, true);
      if ( $image ) {
        echo '<div class="cat_main_img"><img src="' . $sizeimage . '" alt="" /></div>';
    }
  }
}
add_filter('add_to_cart_fragments', 'kad_woocommerce_header_add_to_cart_fragment');
function kad_woocommerce_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
    ob_start(); ?>

    <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php esc_attr_e('View your shopping cart', 'virtue'); ?>">
        <i class="icon-shopping-cart" style="padding-right:5px;"></i>  <?php _e('Your Cart', 'virtue');?> <span class="kad-cart-dash">-</span> <?php echo $woocommerce->cart->get_cart_total(); ?>
    </a>
    <?php
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
}
