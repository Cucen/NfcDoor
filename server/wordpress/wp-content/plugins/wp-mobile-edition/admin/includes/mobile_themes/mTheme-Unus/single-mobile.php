<?php get_header(); ?>
<div class="fdx_topheading">
<span class="fdx_prev">&lsaquo; <a href="<?php bloginfo('url'); ?>">Home</a></span>
</div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="fdx_content">
<div class="fdx_article_intro">
<div class="fdx_thumb">
<div class="fdx_thumbimg"><?php  if ( has_post_thumbnail()) {
                echo the_post_thumbnail('cat-thumb', (array('title' => ''.esc_attr($post->post_title).'')));
                    } ?></div>
<div class="fdx_frame"></div>
</div>

<div class="fdx_article_heading">
<div class="fdx_article_title_text"><?php the_title(); ?></div>

</div>
</div>

<div class="fdx_article" style="border-bottom: none">
<?php the_content();?>

<?php
echo '<div class="sharenav">';
      $prevPost = get_previous_post();
      $nextPost = get_next_post();
if ($prevPost) { ?>
<a href="<?php $prevPost = get_previous_post(false); $prevURL = get_permalink($prevPost->ID); echo $prevURL; ?>" title="<?php _e('prev', 'wp-mobile-edition') ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/prev.png" width="24" height="24" border="0" alt="&laquo;" /></a>
<?php }
get_template_part('inc/share');
if ($nextPost) { ?>
<a href="<?php $nextPost = get_next_post(false); $nextURL = get_permalink($nextPost->ID); echo $nextURL; ?>" title="<?php _e('next', 'wp-mobile-edition') ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/next.png" width="24" height="24" border="0" alt="&raquo;" /></a>
<?php }
echo '</div>';
?>
</div>




</div>

<?php endwhile; endif; ?>


<?php get_footer(); ?>