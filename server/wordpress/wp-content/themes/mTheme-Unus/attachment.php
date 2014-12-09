<?php get_header(); ?>
<div class="fdx_topheading">
<?php previous_post_link( '%link', '<span class="fdx_prev">&lsaquo; '.__('return', 'wp-mobile-edition').'</span>' ); ?>
</div>
<div class="fdx_content">
<div class="fdx_article_heading" style="text-align: center"><?php the_title(); ?> </div>


<div class="fdx_article" style="text-align: center">
<?php echo wp_get_attachment_image( $post->ID, 'full' ); ?></div>


<?php
echo '<div class="sharenav">';
previous_image_link(false, '<span class="icoprev"></span>');
get_template_part('inc/share');
next_image_link(false, '<span class="iconext"></span>');
echo '</div>';
?>
</div>

<?php get_footer(); ?>