						<?php
							if ( get_query_var('paged') ) {
								$paged = get_query_var('paged');
								} else if ( get_query_var('page') ) {
								$paged = get_query_var('page');
								} else {
								$paged = 1;
							}
							query_posts( array( 'post_type' => 'mobile', 'paged' => $paged ) );

							global $wp_query;
							query_posts(
							array_merge(
							array(
							'post_type' => 'mobile',
							'orderby' => 'date',
							'order' => 'DESC'
                        	),
							$wp_query->query
							)
							);
						?>
 <div class="fdx_content">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php
if ('fdx_odd' == @$odd_or_even){
  $odd_or_even = 'fdx_even';
}else{
  $odd_or_even = 'fdx_odd';
}
?>
<!-- Start posts -->
<div id="post-<?php the_ID(); ?>" class="fdx_snippet <?php echo $odd_or_even; ?>" >

<div class="fdx_thumb">
<div class="fdx_thumbimg"><?php  if ( has_post_thumbnail()) {echo the_post_thumbnail('cat-thumb', (array('title' => ''.esc_attr($post->post_title).'')));} ?></div>
<a href="<?php the_permalink() ?>"><div class="fdx_frame"></div></a>
</div>

<div class="fdx_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?><span class="fdx_more"></span></a>
<br><?php echo fdx_excerpt(133); ?>

</div>

</div>

<?php
endwhile;
 else : ?>

<div style="padding:5px; text-align: center ">
<h1><?php _e('No items found', 'wp-mobile-edition'); ?></h1>
<p><?php _e('There are currently no items to display. Please check back soon.', 'wp-mobile-edition'); ?></p>
</div>
<?php endif; ?>

</div><!-- fdx_content -->