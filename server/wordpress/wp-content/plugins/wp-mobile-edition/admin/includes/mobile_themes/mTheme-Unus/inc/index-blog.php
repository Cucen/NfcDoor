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
<div class="commentbuble2"><a href="<?php the_permalink(); ?>#comments"><?php $commentscount = get_comments_number(); echo $commentscount; ?></a></div>
<div class="fdx_thumbimg"><?php  if ( has_post_thumbnail()) {echo the_post_thumbnail('cat-thumb', (array('title' => ''.esc_attr($post->post_title).'')));} ?></div>
<div class="fdx_frame"></div> 
</div>
<div class="fdx_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?><span class="fdx_more"></span></a></div>
</div>
<!--  end posts -->

<?php
endwhile;
 else : ?>

<?php if ( is_search() ) { ?>

<div style="padding:5px; text-align: center">
<h1><?php _e('Nothing found for', 'wp-mobile-edition'); echo ' <strong><a>'. get_search_query();?></a></h1>
<p><strong><?php _e('Try performing a different search', 'wp-mobile-edition') ?>. </strong></p>
</div>

<?php } else { ?>
<div style="padding:5px; text-align: center ">
<h1><?php _e('No items found', 'wp-mobile-edition'); ?></h1>
<p><?php _e('There are currently no items to display. Please check back soon.', 'wp-mobile-edition'); ?></p>
</div>
<?php } ?>

<?php endif; ?>
</div><!-- fdx_content -->
