	<!-- Sağ Kısım -->
	<div id="sag-kisim">
	
		<!-- Sosyal Ağ -->
		<div class="sag-menu-baslik">sosyal ağ</div>
		
		<div class="sag-menu-icerik">
		<a href="<?php echo get_option('facebook'); ?>" title="Facebook" class="facebook"></a>
		<a href="<?php echo get_option('twitter'); ?>" title="Twitter" class="twitter"></a>
		<a href="<?php echo get_option('dribbble'); ?>" title="Dribbble" class="dribbble"></a>
		<a href="<?php bloginfo('rss_url'); ?>" title="RSS" class="rss"></a>
		<a href="<?php echo get_option('flickr'); ?>" title="Flickr" class="flickr"></a>
		<a href="<?php echo get_option('myspace'); ?>" title="MySpace" class="myspace"></a>
		<div class="temizlik"></div>
		</div>
		<div class="sag-menu-alt"></div>
		<!--/Sosyal Ağ -->
	
		<div class="temizlik"></div>
	
		<!-- Kategoriler -->
		<div class="sag-menu-baslik">kategoriler</div>
		<div class="sag-menu-icerik">
			<ul id="kategoriler">
			<?php wp_list_categories('show_option_all&orderby=name&title_li=&depth=1'); ?>
			</ul>
		<div class="temizlik"></div>
		</div>
		<div class="sag-menu-alt"></div>
		<!--/Kategoriler -->
		
		
		<!-- Hit Yazılar -->
		<div class="sag-menu-baslik">hit yazılar</div>
		<div class="sag-menu-icerik">
		<?php
		global $sayfa_sayac;
		$ayarlar['type'] = 'encoktoplamda';
		$ayarlar['adet'] = 10;
		$ayarlar['kelimekes'] = 80;
		 
		echo '<ul id="hit-yazilar">';
		$sayfa_sayac->sayfa_sayac_widget($ayarlar,true,'widget');
		echo '</ul>';
		 
		### AYARLAR ###
		$ayarlar['type'] = enson;
		$ayarlar['adet'] = 10;
		$ayarlar['kelimekes'] = 80;
		$ayarlar['kategori'] = 1;
		$ayarlar['kategoricikar'] = 50;
		$ayarlar['yazicikar'] = 124;
		 
		$ayarlar;
		true;
		widget;
        ?>
		<div class="temizlik"></div>
		</div>
		<div class="sag-menu-alt"></div>
		<!--/Hit Yazılar -->
		
	<div class="temizlik"></div>
	
		<!-- Etiketler -->
		<div class="sag-menu-baslik">etiketler</div>
		<div class="sag-menu-icerik">
			<ul id="etiketler">
			<li><?php wp_tag_cloud('smallest=13&largest=13&unit=px&number=20&format=flat&orderby=count&order=RAND'); ?></li>
			</ul>
		<div class="temizlik"></div>
		</div>
		<div class="sag-menu-alt"></div>
		<!--/Etiketler -->
	
	<div class="temizlik"></div>
	
		<?php
	if (get_option('enable_tavsiye')=='yes') {
	echo '<!-- Tavsiye Bağlantılar -->
		<div class="sag-menu-baslik">tavsiye bağlantılar</div>
		<div class="sag-menu-icerik">

			<ul id="tavsiye-baglantilar">';
	echo get_option('tavsiyekodlar');
	echo '
			</ul>
			
		<div class="temizlik"></div>
		</div>
		<div class="sag-menu-alt"></div>
		<!--/Tavsiye Bağlantılar -->';
	}
	?>
		
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?><?php endif; ?>
		
	</div>

	<!--/Sağ Kısım -->

	<div class="temizlik"></div>