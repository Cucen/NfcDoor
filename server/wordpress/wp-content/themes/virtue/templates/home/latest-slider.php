<div class="sliderclass">
  <?php  global $virtue; 
         if(isset($virtue['slider_size'])) {$slideheight = $virtue['slider_size'];} else { $slideheight = 400; }
        if(isset($virtue['slider_size_width'])) {$slidewidth = $virtue['slider_size_width'];} else { $slidewidth = 1140; }
        ?>
        <div id="imageslider" class="container">
          <div class="flexslider loading" style="max-width:<?php echo $slidewidth;?>px; margin-left: auto; margin-right:auto;">
            <ul class="slides">
    <?php $temp = $wp_query; 
          $wp_query = null; 
          $wp_query = new WP_Query();
          $wp_query->query(array(
            'posts_per_page' => 4));
          $count =0;
          if ( $wp_query ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
                  if (has_post_thumbnail( $post->ID ) ) {
                              $image_url = wp_get_attachment_image_src( 
                              get_post_thumbnail_id( $post->ID ), 'full' ); 
                              $thumbnailURL = $image_url[0]; 
                              $image = aq_resize($thumbnailURL, $slidewidth, $slideheight, true);
                              if(empty($image)) { $image = $thumbnailURL; } 
                    ?>
                      <li> 
                        <a href="<?php the_permalink(); ?>">
                          <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />
                                <div class="flex-caption">
                                <div class="captiontitle headerfont"><?php the_title(); ?></div>
                                </div> 
                        </a>
                      </li>
                  <?php } endwhile; else: ?>
            <li class="error-not-found"><?php _e('Sorry, no blog entries found.', 'virtue'); ?></li>
          <?php endif; ?>
        <?php $wp_query = null; $wp_query = $temp;  // Reset ?>
        <?php wp_reset_query(); ?>
        </ul>
      </div> <!--Flex Slides-->
  </div><!--Container-->
</div><!--sliderclass-->

      <?php 
          if(isset($virtue['trans_type'])) {$transtype = $virtue['trans_type'];} else { $transtype = 'slide';}
          if(isset($virtue['slider_transtime'])) {$transtime = $virtue['slider_transtime'];} else {$transtime = '300';}
          if(isset($virtue['slider_autoplay'])) {$autoplay = $virtue['slider_autoplay'];} else {$autoplay = 'true';}
          if(isset($virtue['slider_pausetime'])) {$pausetime = $virtue['slider_pausetime'];} else {$pausetime = '7000';}
      ?>
      <script type="text/javascript">
            jQuery(window).load(function () {
                jQuery('.flexslider').flexslider({
                    animation: "<?php echo $transtype ?>",
                    animationSpeed: <?php echo $transtime ?>,
                    slideshow: <?php echo $autoplay ?>,
                    slideshowSpeed: <?php echo $pausetime ?>,
                    smoothHeight: true,

                    before: function(slider) {
                      slider.removeClass('loading');
                    }  
                  });
                });
      </script>