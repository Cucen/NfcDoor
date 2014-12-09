	<?php
/*
Template Name: Portfolio Grid
*/
?>
	<div id="pageheader" class="titleclass">
		<div class="container">
			<?php get_template_part('templates/page', 'header'); ?>
		</div><!--container-->
	</div><!--titleclass-->
	
    <div id="content" class="container">
   		<div class="row">
      <div class="main <?php echo kadence_main_class(); ?>" role="main">
			<?php get_template_part('templates/content', 'page'); ?>
      	<?php global $post; $portfolio_category = get_post_meta( $post->ID, '_kad_portfolio_type', true ); 
			   				   $portfolio_items = get_post_meta( $post->ID, '_kad_portfolio_items', true );
			   				   $portfolio_order = get_post_meta( $post->ID, '_kad_portfolio_order', true ); 
			   				   	if(isset($portfolio_order)) {$p_orderby = $portfolio_order;} else {$p_orderby = 'menu_order';}
			   				   	if($p_orderby == 'menu_order') {$p_order = 'ASC';} else {$p_order = 'DESC';}
			   				   if($portfolio_category == '-1' || empty($portfolio_category)) { $portfolio_cat_slug = ''; $portfolio_cat_ID = ''; } else {
								 $portfolio_cat = get_term_by ('id',$portfolio_category,'portfolio-type' );
							$portfolio_cat_slug = $portfolio_cat -> slug;
							  $portfolio_cat_ID = $portfolio_cat -> term_id;
							}
					
					   		$portfolio_category = $portfolio_cat_slug;
							if($portfolio_items == 'all') { $portfolio_items = '-1'; }
					?>
      

                   <?php 
                   global $post; $portfolio_column = get_post_meta( $post->ID, '_kad_portfolio_columns', true ); 
		                   if ($portfolio_column == '2') {$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; $slidewidth = 559; $slideheight = 559; $md = 2; $sm = 2; $xs = 1; $ss = 1;} 
		                   else if ($portfolio_column == '3'){ $itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 366; $slideheight = 366; $md = 3; $sm = 3; $xs = 2; $ss = 1;} 
		                   else if ($portfolio_column == '6'){ $itemsize = 'tcol-md-2 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $slidewidth = 240; $slideheight = 240; $md = 6; $sm = 4; $xs = 3; $ss = 2;} 
		                   else if ($portfolio_column == '5'){ $itemsize = 'tcol-md-25 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $slidewidth = 240; $slideheight = 240; $md = 5; $sm = 4; $xs = 3; $ss = 2;} 
		                   else {$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 269; $slideheight = 269; $md = 4; $sm = 3; $xs = 2; $ss = 1;}
		            ?> 
                   <?php $portfolio_item_excerpt = get_post_meta( $post->ID, '_kad_portfolio_item_excerpt', true ); $portfolio_item_types = get_post_meta( $post->ID, '_kad_portfolio_item_types', true );  ?>
                   <?php $crop = true; ?>
                   <?php $portfolio_cropheight = get_post_meta( $post->ID, '_kad_portfolio_img_crop', true ); if ($portfolio_cropheight != '') $slideheight = $portfolio_cropheight; ?>
                   <?php $portfolio_lightbox = get_post_meta( $post->ID, '_kad_portfolio_lightbox', true ); if ($portfolio_lightbox == 'yes'){$plb = true;} else {$plb = false;}?>
               <div id="portfoliowrapper" class="rowtight">    
            <?php 
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$temp = $wp_query; 
				  $wp_query = null; 
				  $wp_query = new WP_Query();
				  $wp_query->query(array(
					'paged' => $paged,
					'orderby' => $p_orderby,
					'order' => $p_order,
					'post_type' => 'portfolio',
					'portfolio-type'=>$portfolio_cat_slug,
					'posts_per_page' => $portfolio_items));
					$count =0;
					?>
					<?php if ( $wp_query ) : 
							 
					while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                    <?php
						$terms = get_the_terms( $post->ID, 'portfolio-type' );
						if ( $terms && ! is_wp_error( $terms ) ) : 
							$links = array();
								foreach ( $terms as $term ) { $links[] = $term->name;}
							$links = preg_replace("/[^a-zA-Z 0-9]+/", " ", $links);
							$links = str_replace(' ', '-', $links);	
							$tax = join( " ", $links );		
						else :	
							$tax = '';	
						endif;
						?>
                	<div class="<?php echo $itemsize;?> <?php echo strtolower($tax); ?> all kad_portfolio_fade_in">
                	<div class="portfolio_item grid_item postclass">
						<?php 		if (has_post_thumbnail( $post->ID ) ) {
									$image_url = wp_get_attachment_image_src( 
									get_post_thumbnail_id( $post->ID ), 'full' ); 
									$thumbnailURL = $image_url[0]; 
									$image = aq_resize($thumbnailURL, $slidewidth, $slideheight, true);
									  	if(empty($image)) {$image = $thumbnailURL; } ?>

									<div class="imghoverclass">
	                                       <a href="<?php the_permalink()  ?>" title="<?php the_title(); ?>">
	                                       <img src="<?php echo $image ?>" alt="<?php the_title(); ?>" class="lightboxhover" style="display: block;">
	                                       </a> 
	                                </div>
	                                <?php if($plb) {?><a href="<?php echo $thumbnailURL; ?>" class="kad_portfolio_lightbox_link" title="<?php the_title();?>" rel="lightbox"><i class="icon-search"></i></a><?php }?>
                           				<?php $image = null; $thumbnailURL = null;?>
                           <?php }  ?>
              	<a href="<?php the_permalink() ?>" class="portfoliolink">
              		<div class="piteminfo">   
                          <h5><?php the_title();?></h5>
                           <?php if($portfolio_item_types == true) { $terms = get_the_terms( $post->ID, 'portfolio-type' ); if ($terms) {?> <p class="cportfoliotag"><?php $output = array(); foreach($terms as $term){ $output[] = $term->name;} echo implode(', ', $output); ?></p> <?php } } ?>
                          <?php if($portfolio_item_excerpt == true) {?> <p><?php echo virtue_excerpt(16); ?></p> <?php } ?>
                    </div>
                </a>
                </div>
                    </div>
					<?php endwhile; else: ?>
					 
					<li class="error-not-found"><?php _e('Sorry, no portfolio entries found.', 'virtue');?></li>
						
				<?php endif; ?>
                </div> <!--portfoliowrapper-->
                                    
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
                    <?php 
                      $wp_query = null; 
                      $wp_query = $temp;  // Reset
                    ?>
                    <?php wp_reset_query(); ?>
</div><!-- /.main -->