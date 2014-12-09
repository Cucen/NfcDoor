<?php
if (!class_exists('WP_Mobile_Edition')) {
echo '<div style="text-align: center; margin-top: 20px"><h1 style="color: #FF0000">ERROR</h1><h2>The Plugin <a href="http://wordpress.org/plugins/wp-mobile-edition/" target="_blank">WP Mobile Edition</a> this Deactivated!</h2></div>';
die();
}?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="HandheldFriendly" content="True" />
<meta name="MobileOptimized" content="320"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="cleartype" content="on" />
    <title><?php global $page, $paged;
       wp_title( '|', true, 'right' );
    	bloginfo( 'name' );
    	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'wp-mobile-edition'), max( $paged, $page ) );
        echo ' | '.__('Mobile Version', 'wp-mobile-edition');
        ?></title>

<?php
if ( fdx_option('p3_opl4') <> "" ) {echo '<meta name="msapplication-TileImage" content="'.fdx_option('p3_opl4').'">'. "\n";;
                                    echo '<meta name="msapplication-TileColor" content="'.fdx_option('p3_opl5').'">'. "\n";}
if ( fdx_option('p3_opl2') <> "" ) { echo '<link rel="shortcut icon" type="image/x-icon" href="'.fdx_option('p3_opl2').'" />'. "\n";}
if ( fdx_option('p3_opl3') <> "" ) { echo '<link rel="apple-touch-icon" href="'.fdx_option('p3_opl3').'" />';}
?>

<?php if(is_single() || is_page()) { // post e paginas ?>
<meta name="keywords" content="<?php if(function_exists('csv_tags_m')) { csv_tags_m(); } ?>" />
<meta name="description" content="<?php if(function_exists('head_meta_desc_m')) { head_meta_desc_m(); } ?>" />
<?php } elseif(is_home()) { // home ?>
<meta name="keywords" content="mobile, celular," />
<meta name="description" content="<?php bloginfo('description'); ?>  (<?php _e('Mobile Version', 'wp-mobile-edition') ?>)" />
<?php } else { //todas as outras ?>
<meta name="robots" content="noindex,nofollow" />
<?php }?>

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php echo '<link rel="stylesheet" href="'. get_template_directory_uri(). '/css/css.php?files=normalize.css,core.css,style.css,'.fdx_option('p3_sel1').'.css" type="text/css" />'; ?>

<?php
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
?>

<?php
if ( fdx_option('p3_check_1') ){
wp_head();
}
?>

<?php
if ( fdx_option('p3_tex3') <> "" ) {
echo stripslashes(fdx_option('p3_tex3')) . "\n";
}
?>
</head>
<body>
<a name="top" id="top"></a>

<div class="fdx_topnav">
<ul>
<?php if ( fdx_option('p3_opl1') <> "" ){
  echo '<li class="toplogo"><a href="'.get_bloginfo('url').'"><img alt="*" border="0" src="'.fdx_option('p3_opl1').'" /></a></li>';
} else { echo '<li class="fdx_home"><a href="'.get_bloginfo('url').'"><img alt="*" border="0" width="26" height="26" src="'.get_template_directory_uri().'/images/icons/home.png" /></a></li>'; }
?>
<?php  if ( fdx_option('p3_check_t1') ){ ?>
<li class="fdx_contactlink"><a href="#"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/menu.png" border="0" alt="" width="26" height="26"/></a></li>
<?php  } if ( fdx_option('p3_check_t2') ){ ?>
<li class="fdx_catlink"><a href="#"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/cat.png" border="0" alt="" width="26" height="26"/></a></li>
<?php } if ( fdx_option('p3_check_t3') ){ ?>
<li class="fdx_searchlink"><a href="#"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/search.png" border="0" alt="" width="26" height="26"/></a></li>
<?php } if ( fdx_option('p3_check_t5') ){ ?>
<li class="fdx_home2"><a href="<?php echo home_url('/fdx-index/'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/blog.png" border="0" alt="" width="26" height="26"/></a></li>
<?php }  if ( fdx_option('p3_check_t4') ){ ?>
<li style="padding-top: 6px;"><a href="<?php echo home_url('/fdx-contact/'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/mail.png" border="0" alt="" width="26" height="26"/></a></li>
<?php } ?>

</ul>


</div>



<div class="fdx_container">

<?php  if ( fdx_option('p3_check_t3') ){ ?>
<div class="fdx_search">
<div class="fdx_topheading"><?php _e('Search', 'wp-mobile-edition') ?></div>
<div class="fdx_content" style="padding: 10px">
<form role="search" method="get" action="<?php bloginfo('url'); ?>">
<div class="input-group">
<span class="input-group-addon">&rarr;</span><input class="form-control" placeholder="Enter text here" type="text" name="s" id="s">
</div>
</form>
</div>
</div>

<?php  } if ( fdx_option('p3_check_t1') ){ ?>
<div class="fdx_contact">
<div class="fdx_topheading"><?php _e('Menu', 'wp-mobile-edition') ?></div>
<div class="fdx_categories">
<ul>
<?php
//http://codex.wordpress.org/Function_Reference/wp_nav_menu
wp_nav_menu(array(
	'theme_location'  => 'fdx_menu',
	'items_wrap'      => '%3$s',
	'depth'           => 0,
	'walker'          => '')
);
?>
</ul>
</div>
</div>

<?php } if ( fdx_option('p3_check_t2') ){ ?>
<div class="fdx_categories fdx_categories2">
<div class="fdx_topheading"><?php _e('Categories', 'wp-mobile-edition') ?></div>
<ul>
<?php wp_list_categories('orderby=name&title_li=&depth=4'); ?>
</ul>
</div>
<?php } ?>

<?php
if ( fdx_option('p3_tex1') <> "" ) {
echo "<div class=\"clear\"></div>";
echo stripslashes(fdx_option('p3_tex1'));
echo "<div class=\"clear\"></div>";
}
?>