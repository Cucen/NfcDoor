<div id="portfolio_carousel_container" class="carousel_outerrim">
    <?php global $post; $text = get_post_meta( $post->ID, '_kad_portfolio_carousel_title', true ); if(!empty($text)) { echo '<h3 class="title">'.$text.'</h3>'; } else {echo '<h3 class="title">'.__('Recent Projects', 'virtue').'</h3>';} ?>
        <div class="portfolio-carouselcase fredcarousel">
            <?php $itemsize = 'tcol-lg-3 tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 269; $slideheight = 269; $md = 4; $sm = 3; $xs = 2; $ss = 1; ?>
				<div id="carouselcontainer" class="rowtight">
            	<div id="portfolio-carousel" class="clearfix caroufedselclass">
                <?php $temp = $wp_query; 
				  $wp_query = null; 
				  $wp_query = new WP_Query();
				  $wp_query->query(array(
					'orderby' => 'date',
					'order' => 'DESC',
					'post_type' => 'portfolio',
					'posts_per_page' => '8'));
					$count = 0;
					if ( $wp_query ) : 
					while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
						<div class="<?php echo $itemsize; ?>">
							<div class="grid_item portfolio_item all postclass">
								<?php if (has_post_thumbnail( $post->ID ) ) {
										$image_url = wp_get_attachment_image_src( 
										get_post_thumbnail_id( $post->ID ), 'full' ); 
										$thumbnailURL = $image_url[0]; 
										 $image = aq_resize($thumbnailURL, $slidewidth, $slideheight, true);
											if(empty($image)) {$image = $thumbnailURL;}?>
										<div class="imghoverclass">
		                                       <a href="<?php the_permalink();  ?>" title="<?php the_title(); ?>">
		                                       <img src="<?php echo $image ?>" alt="<?php the_title(); ?>" class="lightboxhover" style="display: block;">
		                                       </a> 
		                                </div>
	                           				<?php $image = null; $thumbnailURL = null;?>
                           			<?php } ?>
              				<a href="<?php the_permalink() ?>" class="portfoliolink">
              					<div class="piteminfo">   
                          			<h5><?php the_title();?></h5>
			                    </div>
			                </a>
			          	</div>
                 </div>
					<?php endwhile; else: ?>
					 
					<div class="error-not-found"><?php _e('Sorry, no portfolio entries found.', 'virtue');?></div>
						
				<?php endif;
				$wp_query = null; 
				$wp_query = $temp;  // Reset
				wp_reset_query(); ?>
				</div>									
			</div>
    <div class="clearfix"></div>
    	<a id="prevport_portfolio" class="prev_carousel icon-chevron-left" href="#"></a>
		<a id="nextport_portfolio" class="next_carousel icon-chevron-right" href="#"></a>
    </div>
</div><!-- Porfolio Container-->
<script type="text/javascript">
	 jQuery( window ).load(function () {
	 	var $wcontainer = jQuery('#carouselcontainer');
	 	var $container = jQuery('#portfolio-carousel');
	 				setWidths();
	 				$container.carouFredSel({
							scroll: { items:1,easing: "swing", duration: 700, pauseOnHover : true},
							auto: {play: true, timeoutDuration: 9000},
							prev: '#prevport_portfolio',
							next: '#nextport_portfolio',
							pagination: false,
							swipe: true,
								items: {visible: null
								}
						});
		 				var resizeTimer;
						jQuery(window).resize(function() {
						clearTimeout(resizeTimer);
						resizeTimer = setTimeout(portfolioCarousel, 100);
						});
		 				function portfolioCarousel() {
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