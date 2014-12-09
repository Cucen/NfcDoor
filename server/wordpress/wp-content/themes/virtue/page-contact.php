<?php
/*
Template Name: Contact
*/
?>

	<script type="text/javascript">
	jQuery(document).ready(function ($) {
		$("#contactForm").validate();
	});
	</script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.validate.js"></script>
	<?php global $post; $map = get_post_meta( $post->ID, '_kad_contact_map', true ); 
	if ($map == 'yes') { ?>
		    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
		    <?php global $post; $address = get_post_meta( $post->ID, '_kad_contact_address', true ); 
							    $maptype = get_post_meta( $post->ID, '_kad_contact_maptype', true ); 
							    $height = get_post_meta( $post->ID, '_kad_contact_mapheight', true ); 
							    if($height != '') {$mapheight = $height;} else {$mapheight = 300;}
							    $mapzoom = get_post_meta( $post->ID, '_kad_contact_zoom', true ); 
							    if($mapzoom != '') $zoom = $mapzoom; else $zoom = 15; 
		    ?>
		    <script type="text/javascript">
					jQuery(window).load(function() {
		
					jQuery('#map_address').gmap3({
			map: {
			    address:"<?php echo $address;?>",
				options: {
              		zoom:<?php echo $zoom;?>,
					draggable: true,
					mapTypeControl: true,
					mapTypeId: google.maps.MapTypeId.<?php echo $maptype;?>,
					scrollwheel: false,
					panControl: true,
					rotateControl: false,
					scaleControl: true,
					streetViewControl: true,
					zoomControl: true
				}
			},
			marker:{
            values:[
            		 {address: "<?php echo $address;?>",
			 	    data:"<div class='mapinfo'>'<?php echo $address;?>'</div>",
			 	},
            ],
            options:{
              draggable: false,
            },
			events:{
              click: function(marker, event, context){
                var map = jQuery(this).gmap3("get"),
                  infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
                if (infowindow){
                  infowindow.open(map, marker);
                  infowindow.setContent(context.data);
                } else {
                  jQuery(this).gmap3({
                    infowindow:{
                      anchor:marker, 
                      options:{content: context.data}
                    }
                  });
                }
              },
              closeclick: function(){
                var infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
                if (infowindow){
                  infowindow.close();
                }
			  }
			}
          }
        });
        
      });
			</script>
		    <?php echo '<style type="text/css" media="screen">#map_address {height:'.$mapheight.'px; margin-bottom:20px;}</style>'; ?>
    <?php } ?>
<?php global $virtue;
	if(isset($_POST['submitted'])) {
	if(trim($_POST['contactName']) === '') {
		$nameError = __('Please enter your name.', 'virtue');
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}

	if(trim($_POST['email']) === '')  {
		$emailError = __('Please enter your email address.', 'virtue');
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
		$emailError = __('You entered an invalid email address.', 'virtue');
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	if(trim($_POST['comments']) === '') {
		$commentError = __('Please enter a message.', 'virtue');
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}

	if(!isset($hasError)) {
		if (isset($virtue['contact_email'])) {
			$emailTo = $virtue['contact_email'];
		} else {
			$emailTo = get_option('admin_email');
		}
		$sitename = get_bloginfo('name');
		$subject = '['.$sitename . __(" Contact", "virtue").'] '. __("From ", "virtue"). $name;
		$body = __('Name', 'virtue').": $name \n\nEmail: $email \n\nComments: $comments";
		$headers = __("From", "virtue").': '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		wp_mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}

} ?>
  	<div id="pageheader" class="titleclass">
		<div class="container">
			<?php get_template_part('templates/page', 'header'); ?>
			</div><!--container-->
	</div><!--titleclass-->
<?php if ($map == 'yes') { ?>
            <div id="pageheader" class="titleclass">
            	<div class="container">
		            <div id="map_address">
		            </div>
	            </div><!--container-->
            </div><!--titleclass-->
  <?php } ?>

	<div id="content" class="container">
   		<div class="row">
   		<?php global $post; $form = get_post_meta( $post->ID, '_kad_contact_form', true );
      	if ($form == 'yes') { ?>
	  		<div id="main" class="col-md-6" role="main"> 
	  	<?php } else { ?>
      		<div id="main" class="col-md-12" role="main">
      <?php } ?>
      <?php get_template_part('templates/content', 'page'); ?>
      </div>
      <?php if ($form == 'yes') { ?>
      		<div class="contactformcase col-md-6">
      			<?php global $post; $contactformtitle = get_post_meta( $post->ID, '_kad_contact_form_title', true ); if ($contactformtitle != '') { 
      				echo '<h3>'. $contactformtitle .'</h3>';
      			} ?>
				<?php if(isset($emailSent) && $emailSent == true) { ?>
							<div class="thanks">
								<p><?php _e('Thanks, your email was sent successfully.', 'virtue');?></p>
							</div>
						<?php } else { ?>
							<?php if(isset($hasError) || isset($captchaError)) { ?>
								<p class="error"><?php _e('Sorry, an error occured.', 'virtue');?><p>
							<?php } ?>

						<form action="<?php the_permalink(); ?>" id="contactForm" method="post">
							<div class="contactform">
							<p>
								<label for="contactName"><b><?php _e('Name:', 'virtue'); ?></b></label><?php if(isset($nameError)) { ?>
									<span class="error"><?php $nameError;?></span>
								<?php } ?>
								
								<input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required requiredField full" />
                               
							</p>

							<p>
								<label for="email"><b><?php _e('Email: ', 'virtue'); ?></b></label> <?php if(isset($emailError)) { ?>
									<span class="error"><?php $emailError;?></span>
								<?php } ?>
								<input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required requiredField email full" />
							</p>

							<p><label for="commentsText"><b><?php _e('Message: ', 'virtue'); ?></b></label>	<?php if(isset($commentError)) { ?>
									<span class="error"><?php $commentError;?></span>
								<?php } ?>
								<textarea name="comments" id="commentsText" rows="10" class="required requiredField"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
							</p>

							<p>
								<input type="submit" class="kad-btn kad-btn-primary" id="submit" tabindex="5" value="<?php _e('Send Email', 'virtue'); ?>" ></input>
							</p>
						</div><!-- /.contactform-->
						<input type="hidden" name="submitted" id="submitted" value="true" />
					</form>
				<?php } ?>
      </div><!--contactform-->
      <?php } ?>