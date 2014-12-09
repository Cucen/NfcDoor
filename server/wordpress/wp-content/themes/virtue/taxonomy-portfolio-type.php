	<div id="pageheader" class="titleclass">
		<div class="container">
			<?php get_template_part('templates/page', 'header'); ?>
		</div><!--container-->
	</div><!--titleclass-->
	
    <div id="content" class="container">
   		<div class="row">
      <div class="main <?php echo kadence_main_class(); ?>" role="main">
      	<?php echo category_description(); ?> 
      	<?php if (!have_posts()) : ?>
		  <div class="alert">
		    <?php _e('Sorry, no results were found.', 'virtue'); ?>
		  </div>
		  <?php get_search_form(); ?>
		<?php endif; ?>
		<?php $itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 366; $slideheight = 366; $md = 3; $sm = 3; $xs = 2; $ss = 1; ?>
		<div id="portfoliowrapper" class="rowtight">
		<?php while (have_posts()) : the_post(); ?>
		<div class="<?php echo $itemsize;?>">
                	<div class="grid_item portfolio_item postclass">
					
                        <?php global $post; $postsummery = get_post_meta( $post->ID, '_kad_post_summery', true );
						     if ($postsummery == 'slider') { ?>
                           <div class="flexslider loading imghoverclass clearfix">
                       <ul class="slides ">
                          <?php 
                          global $post;
	                      $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
	                          if(!empty($image_gallery)) {
	                            $attachments = array_filter( explode( ',', $image_gallery ) );
	                              if ($attachments) {
	                              foreach ($attachments as $attachment) {
	                                $attachment_url = wp_get_attachment_url($attachment , 'full');
	                                $image = aq_resize($attachment_url, $slidewidth, $slideheight, true);
	                                  if(empty($image)) {$image = $attachment_url;}?>
	                                  <li><a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>"><img src="<?php echo $image ?>" class="" /></a></li>
	                                <?php }
	                            }
	                          } else {
	                            $attach_args = array('order'=> 'ASC','post_type'=> 'attachment','post_parent'=> $post->ID,'post_mime_type' => 'image','post_status'=> null,'orderby'=> 'menu_order','numberposts'=> -1);
	                            $attachments = get_posts($attach_args);
	                              if ($attachments) {
	                                foreach ($attachments as $attachment) {
	                                  $attachment_url = wp_get_attachment_url($attachment->ID , 'full');
	                                  $image = aq_resize($attachment_url, $slidewidth, $slideheight, true);
	                                    if(empty($image)) {$image = $attachment_url;} ?>
	                                  <li><a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>"><img src="<?php echo $image ?>" class="" /></a></li>
	                                <?php }
	                              } 
	                          }  ?>                            
					</ul>
              	</div> <!--Flex Slides-->
              	<script type="text/javascript">
					            jQuery(window).load(function () {
					                jQuery('.flexslider').flexslider({
					                    animation: "fade",
					                    animationSpeed: 400,
					                    slideshow: true,
					                    slideshowSpeed: 7000,

					                    before: function(slider) {
					                      slider.removeClass('loading');
					                    }  
					                  });
					                });
					      		</script>
					      		<style type="text/css"> .portfolio_item > .loading {height: <?php echo $slideheight;?>px;}</style>
              <?php } else {
								if (has_post_thumbnail( $post->ID ) ) {
									$image_url = wp_get_attachment_image_src( 
									get_post_thumbnail_id( $post->ID ), 'full' ); 
									$thumbnailURL = $image_url[0]; 
									 $image = aq_resize($thumbnailURL, $slidewidth, $slideheight, true);

									if(empty($image)) {$image = $thumbnailURL;} ?>
									<div class="imghoverclass">
	                                       <a href="<?php the_permalink()  ?>" title="<?php the_title(); ?>">
	                                       <img src="<?php echo $image ?>" alt="<?php the_title(); ?>" class="lightboxhover" style="display: block;">
	                                       </a> 
	                                </div>
                           				<?php $image = null; $thumbnailURL = null;?>
                           <?php } } ?>
              	<a href="<?php the_permalink() ?>" class="portfoliolink">
              		<div class="piteminfo">   
                          <h5><?php the_title();?></h5>
                    </div>

                </a>
                </div>
                </div>
		<?php endwhile; ?>
                </div> <!--portfoliowrapper-->
                
                                    
                    <?php if ($wp_query->max_num_pages > 1) : ?>
                            <?php if(function_exists('wp_pagenavi')) { ?>
                            <?php wp_pagenavi(); ?>   
                            <?php } else { ?>      
                            <nav id="post-nav" class="pager">
                                <div class="previous"><?php next_posts_link(__('&larr; Older posts', 'virtue')); ?></div>
                                <div class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'virtue')); ?></div>
                              </nav>
                            <?php } ?> 
                    <?php endif; ?>
                    <?php 
                      $wp_query = null; 
                    ?>
                    <?php wp_reset_query(); ?>
</div><!-- /.main -->