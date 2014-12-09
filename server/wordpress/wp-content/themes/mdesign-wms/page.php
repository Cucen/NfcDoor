<?php get_header(); ?>

<div id="ortalama">

	<!-- Sol Kısım -->
	<div id="sol-kisim">

		<!-- Yazı -->
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="yazi">
		<div class="yazi_baslik"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
		
		<div class="yazi_ic">
		
		<?php the_content(''); ?>
			<div class="temizlik"></div>
		<br/>
			<div class="yazi_bilgileri"><span class="yazar_icon"><?php the_author(); ?></span></div>
			<div class="yazi_bilgileri"><span class="goruntulenme_icon"><strong><?php global $sayfa_sayac; $toplam_okunma = $sayfa_sayac->toplam_okunma_ver(); $sayfa_sayac->toplam_okunma_yaz(); ?></strong> Okunma</span></div>
   			<div class="yazi_bilgileri"><span class="tarih_icon"><?php the_time('j'); ?> <strong><?php the_time('F'); ?></strong> <?php the_time('Y'); ?></span></div>

			<div class="temizlik"></div>
		</div>
		
		<div class="yazi_alt"></div>
		</div>
        <?php endwhile; else: ?>
		<?php endif; ?>
		<!--/Yazı -->
	
	</div>
	<!--/Sol Kısım -->
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>