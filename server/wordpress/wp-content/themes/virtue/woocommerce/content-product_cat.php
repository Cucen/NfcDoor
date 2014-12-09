<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
if ($woocommerce_loop['columns'] == '3'){ $itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $catimgwidth = 367;} else {$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $catimgwidth = 270;}
// Increase loop count
$woocommerce_loop['loop']++;
$catimgheight = 130;
?>
<div class="<?php echo $itemsize; ?>">
<div class="product-category grid_item">

	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

	<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">

		<?php
			/**
			 * woocommerce_before_subcategory_title hook
			 *
			 * @hooked woocommerce_subcategory_thumbnail - 10
			 */
			//do_action( 'woocommerce_before_subcategory_title', $category );
		?>
		<?php $thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
 
        if ( $thumbnail_id ) {
            $image_cat_url = wp_get_attachment_image_src( $thumbnail_id, 'full');
            $image_cat_url = $image_cat_url[0];
            $cat_image = aq_resize($image_cat_url, $catimgwidth, $catimgheight, true);
            if(empty($cat_image)) {$cat_image = $image_cat_url;}
        } else {
            $cat_image = virtue_img_placeholder();
         }
 
        if ( $cat_image )
            echo '<img src="' . $cat_image . '" alt="' . $category->name . '" />';
     ?>

		<h5>
			<?php
				echo $category->name;

				if ( $category->count > 0 )
					echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
			?>
		</h5>

		<?php
			/**
			 * woocommerce_after_subcategory_title hook
			 */
			do_action( 'woocommerce_after_subcategory_title', $category );
		?>

	</a>

	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

	</div>
</div>