<?php get_header(); ?>
<div class="fdx_topheading">&nbsp;</div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="fdx_content">
<div class="fdx_article_heading"><?php the_title(); ?> </div>

<div class="fdx_article">
<?php the_content();?>
<?php wp_link_pages('before= <blockquote><strong>'.__('pages', 'wp-mobile-edition').':&after=</strong></blockquote>&next_or_number=number&pagelink= %'); ?>



<?php
echo '<div class="sharenav">';
get_template_part('inc/share');
echo '</div>';
?>
</div> </div>
<?php endwhile; endif; ?>
<?php get_footer(); ?>