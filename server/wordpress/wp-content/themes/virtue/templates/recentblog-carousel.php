<div id="blog_carousel_container" class="carousel_outerrim">
    <?php global $post; $text = get_post_meta( $post->ID, '_kad_blog_carousel_title', true ); if(!empty($text)) { echo '<h3 class="title">'.$text.'</h3>'; } else {echo '<h3 class="title">'.__('Recent Posts', 'virtue').'</h3>';} ?>
    <div class="blog-carouselcase fredcarousel">
    <?php if (kadence_display_sidebar()) {$itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $catimgwidth = 266; $catimgheight = 266; $md = 3; $sm = 3; $xs = 2; $ss = 1; } else {$itemsize = 'tcol-md-3 tcol-sm-3 tcol-xs-4 tcol-ss-12'; $catimgwidth = 276; $catimgheight = 276; $md = 4; $sm = 3; $xs = 2; $ss = 1; } ?>
		<div id="carouselcontainer" class="rowtight">
		<div id="blog_carousel" class="blog_carousel caroufedselclass clearfix">
            <?php
				$temp = $wp_query; 
				$wp_query = null; 
				$wp_query = new WP_Query();
				$wp_query->query(array(
					'post__not_in' => array($post->ID),
					'posts_per_page'=>6));
					$count =0;
				 if ( $wp_query ) : 
					while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
				<div class="<?php echo $itemsize;?>">
                	<div <?php post_class('blog_item grid_item'); ?>>
	                    		<?php if (has_post_thumbnail( $post->ID ) ) {
										$image_url = wp_get_attachment_image_src( 
											get_post_thumbnail_id( $post->ID ), 'full' ); 
										$thumbnailURL = $image_url[0]; 
										$image = aq_resize($thumbnailURL, $catimgwidth, $catimgheight, true);
											if(empty($image)) {$image = $thumbnailURL;} 
									}else { $theme_url = get_template_directory_uri(); 
									$image = $theme_url.'/assets/img/post_standard.jpg';
								}?>
						<div class="imghoverclass">
		                    <a href="<?php the_permalink()  ?>" title="<?php the_title(); ?>">
		                        <img src="<?php echo $image ?>" alt="<?php the_title(); ?>" class="iconhover" style="display:block;">
		                    </a> 
		                </div>
                    <?php $image = null; $thumbnailURL = null; ?>	
              <a href="<?php the_permalink() ?>" class="bcarousellink">
				<header>
			        <h5 class="entry-title"><?php the_title(); ?></h5>
			        <div class="subhead">
			        <span class="postday"><?php echo get_the_date(get_option( 'date_format' )); ?></span>
			        </div>
				</header>
		       	<div class="entry-content">
		        <p><?php echo virtue_excerpt(16); ?></p>
		        </div>
				 </a>
                </div>
			</div>
		<?php endwhile; else: ?>
			<div class="error-not-found"><?php _e('Sorry, no blog entries found.', 'virtue');?></div>	
				<?php endif;
				$wp_query = null; 
				$wp_query = $temp;  // Reset
				wp_reset_query(); ?>
			</div>
     <div class="clearfix"></div>
            <a id="prevport_blog" class="prev_carousel icon-chevron-left" href="#"></a>
			<a id="nextport_blog" class="next_carousel icon-chevron-right" href="#"></a>
            </div>
            </div>
</div><!-- Carousel Container-->
<script type="text/javascript">
	 jQuery( window ).load(function () {
	 	var $wcontainer = jQuery('#carouselcontainer');
	 	var $container = jQuery('#blog_carousel');
	 				setWidths();
	 				$container.carouFredSel({
							scroll: { items:1,easing: "swing", duration: 700, pauseOnHover : true},
							auto: {play: true, timeoutDuration: 9000},
							prev: '#prevport_blog',
							next: '#nextport_blog',
							pagination: false,
							swipe: true,
								items: {visible: null
								}
						});
	 				var resizeTimer;
						jQuery(window).resize(function() {
						clearTimeout(resizeTimer);
						resizeTimer = setTimeout(blogCarousel, 100);
						});
		 				function blogCarousel() {
						// set the widths on resize
						$container.trigger("destroy");
						setWidths();
							$container.carouFredSel({
										scroll: {items:1,easing: "swing", duration: 700, pauseOnHover : true},
								auto: {play: true, timeoutDuration: 9000},
								prev: '#prevport_portfolio',
								next: '#nextport_portfolio',
								pagination: false,
								swipe: true,
									items: {visible: null
									}
							});
						};
					function getUnitWidth() {
					var width;
					if(jQuery(window).width() <= 480) {
					width = $wcontainer.width() / <?php echo $ss;?>;
					} else if(jQuery(window).width() <= 768) {
					width = $wcontainer.width() / <?php echo $xs;?>;
					} else if(jQuery(window).width() <= 990) {
					width = $wcontainer.width() / <?php echo $sm;?>;
					} else {
					width = $wcontainer.width() / <?php echo $md;?>;
					}
					return width;
					}

					// set all the widths to the elements
					function setWidths() {
					var unitWidth = getUnitWidth() -1;
					$container.children().css({ width: unitWidth });
					}

});
</script>					