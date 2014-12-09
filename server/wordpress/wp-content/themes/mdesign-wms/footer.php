	<!-- Footer -->
	<div id="footer">
	<div class="footer-bloklar" style="background:none;padding:10px 10px;">
	<img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?> Logo" class="logo" />
	</div>
		
		<div class="footer-bloklar">
			<ul class="footer-bloklar">
				<li><a href="<?php bloginfo('home'); ?>/" title="Ana Sayfa">Ana Sayfa</a></li>
				<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
				<li><a href="<?php bloginfo('home'); ?>/sitemap.xml" title="Site Haritası">Sitemap</a></li>
				<li><a href="<?php bloginfo('home'); ?>/feed" title="RSS Feed">Feed</a></li>
			</ul>
		</div>
		
		<div class="footer-bloklar">
			<ul class="footer-bloklar">
				<li style="width:160px;padding:10px 15px">
				<strong>Tasarım:</strong> <a href="http://www.gencgrafikerler.com" title="Grafiker">Cengizhan YILDIZ</a><br />
				<strong>CSS:</strong> Muhammed KAYA<br />
                <strong>Wordpress:</strong> <a href="http://wmscripti.com" title="Script">WM Scripti</a><br />
				</li>
			</ul>
		</div>
		
		<div class="footer-bloklar">
		<span style="margin:7px 15px;display:block">
		&copy; <?php the_time('Y'); ?> Tüm Hakları Saklıdır.<br /><br />
		 <a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
		 <a href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" /></a>
     
		</span>
		</div>	
	</div>
	<!--/Footer -->
</div>
<?php wp_footer(); ?>
</body>
</html>