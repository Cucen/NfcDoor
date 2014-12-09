<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen,projection" />
    <script src="<?php bloginfo('template_directory'); ?>/js/cufon-yui.js" type="text/javascript"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/cufon-fonts.js" type="text/javascript"></script>
	<script type="text/javascript">
    Cufon.replace('#kategoriler,#hit-yazilar,#etiketler', { fontFamily: 'PF BeauSans Pro Regular - wmscripti.com', hover: true });
    Cufon.replace('#ustbilgi', { fontFamily: 'PF BeauSans Pro Light - wmscripti.com', hover: true });
    Cufon.replace('.yazi_baslik', { fontFamily: 'PF BeauSans Pro Bold - wmscripti.com', hover: true });
    Cufon.replace('#menu,.sag-menu-baslik', { fontFamily: 'PF BeauSans Pro SemiBold - wmscripti.com', hover: true });
    </script>
<?php wp_head(); ?>
<?php echo get_option('headkodlar'); ?>
</head>
<body>

<!-- Header -->
<div id="ustbilgi"><span style="float:right"><?php $toplam_yazi = wp_count_posts( 'post' ); $toplam_yazi = $toplam_yazi->publish; $toplam_kategori = wp_count_terms('category'); $toplam_yorum = get_comment_count(); $toplam_yorum = $toplam_yorum['approved']; echo 'Web sitemizde '; echo $toplam_kategori; echo ' kategoride '; echo $toplam_yazi; echo ' makaleye yazılmış '; echo $toplam_yorum; echo' yorum bulunmaktadır.'; ?></span></div>
<div id="header">
<div class="header-isik">

	<!-- LOGO -->
	<div id="logo">
	<a href="<?php bloginfo('home'); ?>/" title="<?php bloginfo('name'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?> Logo" /></a>
	<?php
	if (get_option('enable_ustreklam')=='yes') {
	echo '<a href="'.get_option('reklamlink').'" title="'.get_option('reklambaslik').'"><img src="'.get_option('reklamresim').'" alt="'.get_option('reklambaslik').'" class="reklam" /></a>';
	}
	?>
	</div>
	<!--/LOGO -->

	
	<!-- Menü -->
	<div id="menu">
		<ul>
			<li><a href="<?php echo get_option('home'); ?>/">Ana Sayfa</a></li>
			<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
		</ul>
		<!-- Arama Kutusu -->
		<div id="arama_kutusu">
			<form action="<?php bloginfo('home'); ?>/">
				<input type="hidden" name="post_type" value="post" />
				<input type="text" name="s" value="ne aramıştınız?" onfocus="if(this.beenchanged!=true){ this.value = ''}"
onblur="if(this.beenchanged!=true) { this.value='ne aramıştınız?' }" onchange="this.beenchanged = true;" />
				<input type="submit"  value="" />
			</form>
		</div>
		<!--/Arama Kutusu -->
	</div>
	<!--/Menü -->

	
</div></div>
<!--/Header -->

<div class="temizlik"></div>