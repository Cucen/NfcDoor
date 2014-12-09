<?php get_header(); ?>
<div class="fdx_topheading"><?php _e('Index', 'wp-mobile-edition') ?></div>

<div class="fdx_content">
<?php if (have_posts()) : ?>

 <?php
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
       query_posts('post_type=post&paged=' . $paged);
        while (have_posts()) : the_post(); ?>

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

 <?php endwhile;endif; ?>
</div><!-- fdx_content -->

<?php get_footer(); ?>