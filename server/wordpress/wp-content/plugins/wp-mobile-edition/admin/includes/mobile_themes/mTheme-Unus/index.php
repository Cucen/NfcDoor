<?php get_header(); ?>
<div class="fdx_topheading">&nbsp;</div>
<?php
if ( fdx_option('p3_rad1') == "1" ) {
get_template_part('inc/index-mobile');
} else {
get_template_part('inc/index-blog');
}
get_footer();
?>

