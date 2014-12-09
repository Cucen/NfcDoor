<?php	
		if(is_front_page()) {
				global $virtue; $sidebar = $virtue['home_sidebar'];
				if (!empty($sidebar)) {
					dynamic_sidebar($sidebar);
					}
				else  {
					dynamic_sidebar('sidebar-primary');
				} 
		}
		else if( class_exists('woocommerce') and (is_shop() || is_product_category() || is_product_tag())) {
			
				global $virtue; $sidebar = $virtue['shop_sidebar'];
	 			if ($sidebar != '') {
					dynamic_sidebar($sidebar);
					}
				else  {
					dynamic_sidebar('sidebar-primary');
				} 
			
		} elseif( class_exists('woocommerce') and (is_account_page())) {
				    get_template_part('templates/account', 'sidebar');
		} elseif( is_page_template('page-blog.php') || is_page_template('page-sidebar.php') || is_page_template('page-feature-sidebar.php') || (get_post_type() == 'post')) {
		global $post; $sidebar = get_post_meta( $post->ID, '_kad_sidebar_choice', true ); 
	 		if ($sidebar != '') {
					dynamic_sidebar($sidebar);
				}
			else  {
					dynamic_sidebar('sidebar-primary');
				} 
		}
		else if (is_archive()) {
		dynamic_sidebar('sidebar-primary');
		}
		else if(is_category()) {
			dynamic_sidebar('sidebar-primary');
		}
		elseif (is_tag()) {
			dynamic_sidebar('sidebar-primary');
		}
		elseif (is_post_type_archive()) {
			dynamic_sidebar('sidebar-primary');
		}
		 elseif (is_day()) {
			 dynamic_sidebar('sidebar-primary');
		 }
		 elseif (is_month()) {
			 dynamic_sidebar('sidebar-primary');
		 }
		 elseif (is_year()) {
			 dynamic_sidebar('sidebar-primary');
		 }
		 elseif (is_author()) {
			 dynamic_sidebar('sidebar-primary');
		}
		elseif (is_search()) {
			dynamic_sidebar('sidebar-primary');
		}
		else {
		dynamic_sidebar('sidebar-primary');
	}
?>