<div class="sliderclass">
    <div id="imageslider" class="container">
      <?php global $virtue; 
                      if(isset($virtue['slider_size'])) {$slideheight = $virtue['slider_size'];} else { $slideheight = 400; }
                      if(isset($virtue['slider_size_width'])) {$slidewidth = $virtue['slider_size_width'];} else { $slidewidth = 1170; }
                      if(isset($virtue['slider_captions'])) { $captions = $virtue['slider_captions']; } else {$captions = '';}
                      if(isset($virtue['home_slider'])) {$slides = $virtue['home_slider']; } else {$slides = '';}
                      ?>
          <div id="flex" class="flexslider loading" style="max-width:<?php echo $slidewidth;?>px; margin-left: auto; margin-right:auto;">
                <ul class="slides">
                    <?php foreach ($slides as $slide) :
                    if(!empty($slide['target']) && $slide['target'] == 1) {$target = '_blank';} else {$target = '_self';}
                    $image = aq_resize($slide['url'], $slidewidth, $slideheight, true);
                    if(empty($image)) {$image = $slide['url'];} ?>
                      <li> 
                        <?php if($slide['link'] != '') echo '<a href="'.$slide['link'].'" target="'.$target.'">'; ?>
                          <img src="<?php echo $image; ?>" alt="<?php echo esc_attr($slide['title']); ?>" />
                              <?php if ($captions == '1') { ?> 
                                <div class="flex-caption">
                                <?php if ($slide['title'] != '') echo '<div class="captiontitle headerfont">'.$slide['title'].'</div>'; ?>
                                <?php if ($slide['description'] != '') echo '<div><div class="captiontext headerfont"><p>'.$slide['description'].'</p></div></div>';?>
                                </div> 
                              <?php } ?>
                        <?php if($slide['link'] != '') echo '</a>'; ?>
                      </li>
                  <?php endforeach; ?>
                       </ul>
              </div> <!--Flex Slides-->
              <div id="thumbnails" class="flexslider" style="max-width:<?php echo $slidewidth;?>px; margin-left: auto; margin-right:auto;">
                   <ul class="slides">
                       <?php global $virtue; $slides = $virtue['home_slider'];
                          foreach ($slides as $slide) : ?>
                            <?php $imgurl = $slide['url'];
                                  $thumbslide = aq_resize( $imgurl, 180, 100, true ); //resize & crop the image
							                    ?>
                              <li> 
                                  <img src="<?php echo $thumbslide ?>" />
                              </li>
                          <?php endforeach; ?>
                    </ul>
                 </div><!--Flex thumb-->
</div><!--Container-->
<?php  global $virtue; 
          $transtype = $virtue['trans_type']; if ($transtype == '') $transtype = 'slide';
          $transtime = $virtue['slider_transtime']; if ($transtime == '') $transtime = '300'; 
          $autoplay = $virtue['slider_autoplay']; if ($autoplay == '') $autoplay = 'true'; 
          $pausetime = $virtue['slider_pausetime']; if ($pausetime == '') $pausetime = '7000'; 
      ?>
<script type="text/javascript">
             jQuery(window).load(function() {
              jQuery('#thumbnails').flexslider({
              animation: "slide",
              controlNav: false,
              animationLoop: false,
              slideshow: false,       
              itemWidth: 180,
              itemMargin: 5,
              asNavFor: '#flex'
              });
         
              jQuery('#flex').flexslider({
              animation: "<?php echo $transtype ?>",
              controlNav: false,
              animationLoop: false,
              animationSpeed: <?php echo $transtime ?>,
              slideshow: <?php echo $autoplay ?>,
              slideshowSpeed: <?php echo $pausetime ?>,
              sync: "#thumbnails",
              before: function(slider) {
                      slider.removeClass('loading');
                    }  
              });
              
            });
         </script>
</div><!--feat-->