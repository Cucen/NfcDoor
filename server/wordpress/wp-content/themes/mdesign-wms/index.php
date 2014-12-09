<?php get_header(); ?>

<div id="ortalama">

	<!-- Sol Kısım -->
	<div id="sol-kisim">
    
		<!-- Yazılar -->
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="yazi">
		<div class="yazi_baslik"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a><span class="yorum_sayisi"><?php comments_number('0', '1', '%'); ?></span></div>
		
		<div class="yazi_ic">
		
        <?php if( get_post_meta($post->ID, "resim", true) ): ?>
		<img src="<?php echo get_post_meta($post->ID, "resim", true); ?>" class="yazi_resim" alt="<?php the_title(); ?>" />
        <?php else: ?>
		<img src="<?php bloginfo('template_directory'); ?>/images/resim_yok.png" class="yazi_resim" alt="Resim" />        
        <?php endif; ?>
		<?php the_content(''); ?>
			<div class="temizlik"></div>
		<br/>
            <div class="yazi_bilgileri"><span class="kategori_icon"><?php the_category(' , ') ?></span></div>
			<div class="yazi_bilgileri"><span class="yazar_icon"><?php the_author(); ?></span></div>
			<div class="yazi_bilgileri"><span class="goruntulenme_icon"><strong><?php global $sayfa_sayac; $sayfa_sayac->toplam_okunma_yaz(); ?></strong> Okunma</span></div>
   			<div class="yazi_bilgileri"><span class="tarih_icon"><?php the_time('j'); ?> <strong><?php the_time('F'); ?></strong> <?php the_time('Y'); ?></span></div>

			<a href="<?php the_permalink() ?>" title="Devamını oku..." class="devami"></a>
			
			<div class="temizlik"></div>
		</div>
		
		<div class="yazi_alt"></div>
		</div>
        <?php endwhile; else: ?>
		<?php endif; ?>
		<!--/Yazılar -->
	
	<div id="sayfalama">
	<?php wp_pagenavi(); ?>
	</div>
	
	
	</div>
	<!--/Sol Kısım -->
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>