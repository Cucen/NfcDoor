<div class="fdx_postfooter">
<?php
if (  is_home() || is_archive() ) {

previous_posts_link('<span class="fdx_next">'.__('next', 'wp-mobile-edition').'  &rsaquo;</span>' ); next_posts_link( '<span class="fdx_prev">&nbsp;&lsaquo; '.__('prev', 'wp-mobile-edition').'</span>' );

} else { ?>
<div class="fdx_top_arrow"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/top_arrow.png" alt=""/></div>
<div class="fdx_top"><span class="fdx_topicon"><a class="backToTop" href="#top"><?php _e('top', 'wp-mobile-edition') ?></a></span></div>
<?php } ?>
</div>

<?php
if ( fdx_option('p3_tex2') <> "" ) {
echo "<div class=\"clear\"></div>";
echo stripslashes(fdx_option('p3_tex2'));
echo "<div class=\"clear\"></div>";
}
?>

<div class="fdx_switch">

<div class="switch-link"><?php echo do_shortcode('[fdx-switch-link]'); ?></div>

<div class="fdx_social">
<?php
if ( fdx_option('p3_txt4') <> "" ) { echo '<a href="'.fdx_option('p3_txt4').'"><img alt="*" border="0" width="24" height="24" src="'. get_template_directory_uri(). '/images/icons/google.png" /></a>';}
if ( fdx_option('p3_txt5') <> "" ) { echo '<a href="'.fdx_option('p3_txt5').'"><img alt="*" border="0" width="24" height="24" src="'. get_template_directory_uri(). '/images/icons/in.png" /></a>';}
if ( fdx_option('p3_txt3') <> "" ) { echo '<a href="'.fdx_option('p3_txt3').'"><img alt="*" border="0" width="24" height="24" src="'. get_template_directory_uri(). '/images/icons/face.png" /></a>';}
if ( fdx_option('p3_txt2') <> "" ) { echo '<a href="'.fdx_option('p3_txt2').'"><img alt="*" border="0" width="24" height="24" src="'. get_template_directory_uri(). '/images/icons/twitter.png" /></a>';}
if ( fdx_option('p3_txt1') <> "" ) { echo '<a href="'.fdx_option('p3_txt1').'"><img alt="*" border="0" width="24" height="24" src="'. get_template_directory_uri(). '/images/icons/rss.png" /></a>';
} else { ?> <a href="<?php echo bloginfo('atom_url'); ?>"><img alt="*" border="0" width="24" height="24" src="<?php echo get_template_directory_uri();?>/images/icons/rss.png" /></a>
<?php } ?>
</div>
<div class="clear"></div>
</div>

<div class="fdx_footer"><div class="fdx_copyright"><a href="http://fabrix.net/wp-mobile-edition/" target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/menu_fdx.png" width="16" height="16" border="0" alt="*" /></a></div>
<?php edit_post_link('Edit', '<code>', '</code>'); ?>
</div>
</div> <!-- /fdx_container -->
<script type='text/javascript' src='//cdn.jsdelivr.net/jquery/2.1.1/jquery.min.js'></script>

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/total_script.js" charset="utf-8"></script>
<?php
if ( fdx_option('p3_tex4') <> "" ) {
echo stripslashes(fdx_option('p3_tex4'));
}
?>
<?php
if ( fdx_option('p3_check_2') ){
wp_footer();
}
?>
</body>
</html>
