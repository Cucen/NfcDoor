<?php
/*
Template Name: Blog
*/
?>

	<div id="pageheader" class="titleclass">
		<div class="container">
			<?php get_template_part('templates/page', 'header'); ?>
		</div><!--container-->
	</div><!--titleclass-->
	
    <div id="content" class="container">
   		<div class="row">
			<?php if(kadence_display_sidebar()) {$display_sidebar = true; $fullclass = '';} else {$display_sidebar = false; $fullclass = 'fullwidth';}
   			global $post; if(get_post_meta( $post->ID, '_kad_blog_summery', true ) == 'full') {$summery = 'full'; $postclass = "single-article fullpost";} else {$summery = 'normal'; $postclass = 'postlist';} ?>
      <div class="main <?php echo kadence_main_class();?> <?php echo $postclass .' '. $fullclass; ?>" role="main">
      		<?php  global $post; $blog_category = get_post_meta( $post->ID, '_kad_blog_cat', true ); 
      				if($blog_category == '-1' || $blog_category == '') {
      					$blog_cat_slug = '';
					} else {
					$blog_cat = get_term_by ('id',$blog_category,'category');
					$blog_cat_slug = $blog_cat -> slug;
					}

					$blog_items = get_post_meta( $post->ID, '_kad_blog_items', true ); 
					if($blog_items == 'all') {$blog_items = '-1';} 
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$temp = $wp_query; 
					$wp_query = null; 
					$wp_query = new WP_Query();
					$wp_query->query(array(
						'paged' => $paged,
						'category_name'=>$blog_cat_slug,
						'posts_per_page' => $blog_items));
					$count =0;

					if ( $wp_query ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
					<?php if($summery == 'full') {
							if($display_sidebar){
								get_template_part('templates/content', 'fullpost'); 
							} else {
								get_template_part('templates/content', 'fullpostfull');
							}
						} else {
							if($display_sidebar){
						 	get_template_part('templates/content', get_post_format()); 
						 } else {
						 	get_template_part('templates/content', 'fullwidth');
						 }
						} 
                    endwhile; else: ?>
						<li class="error-not-found"><?php _e('Sorry, no blog entries found.', 'virtue'); ?></li>
					<?php endif; ?>
                
				<?php if ($wp_query->max_num_pages > 1) : ?>
				<?php $bignumber = 999999999;
				$pagargs = array(
					'base' => str_replace( $bignumber, '%#%', esc_url( get_pagenum_link( $bignumber ) ) ),
					'format'       => '?page=%#%',
					'total' => $wp_query->max_num_pages,
					'current' => max( 1, get_query_var('paged') ),
					'prev_next'    => True,
					'prev_text'    => '«',
					'next_text'    => '»',
					'type'         => 'plain',
				); ?>
				<div class="wp-pagenavi">
				<?php echo paginate_links( $pagargs ); ?>
				</div>
				
				<?php endif; ?>
				<?php $wp_query = null; $wp_query = $temp;  // Reset ?>
				<?php wp_reset_query(); ?>

</div><!-- /.main -->