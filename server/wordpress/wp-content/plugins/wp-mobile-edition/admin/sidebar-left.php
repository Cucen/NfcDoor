<?php
# Donation Message #
if( get_site_option( 'fdx1_hidden_time_2' ) && get_site_option( 'fdx1_hidden_time_2' ) < time() ) {
echo '<div class="updated"><form method="post" action=""><input type="hidden" name="fdx_page_2" value="hide_message_2" /><p>';
echo '<strong>'.__('Do you like this Plugin? Rate', $this->plugin_slug).' <span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span> '.__('on', $this->plugin_slug).' WordPress.org</strong> &nbsp;&nbsp;<input type="button" class="button button-primary" onClick="location.href=\''. $this->sbar_wpratelink . '\'" value="' . __( 'Vote & Rate Now', $this->plugin_slug ) . '">&nbsp;&nbsp;&nbsp;';
submit_button( __('Hide this message', $this->plugin_slug ), 'secondary', 'Submit', false, array( 'id' => '' ) ) ;
echo '</p></form></div>';
}
/*---------------------------------------*/
echo '<div id="postbox-container-1" class="postbox-container">';
echo '<div id="side-sortables" class="meta-box-sortables">';

/* class="postbox closed"
----------------------------------------*/
echo '<div class="postbox fdx-responsive"><div class="handlediv" title="'.__('Click to toggle', $this->plugin_slug) .'"><br /></div><h3 class="hndle"><span>'. $this->pluginname . ' <small style="float: right">v'. WP_Mobile_Edition::VERSION . '</small></span></h3>';
echo '<div class="inside">';
echo '<a href="'. $this->sbar_homepage . '" target="_blank"><div id="logo"></div></a>';
echo '<a class="sm_button sm_code" href="'. $this->sbar_homepage . '" target="_blank">' . __( 'Suggest a Feature', $this->plugin_slug ) . '</a>';
echo '<a class="sm_button sm_bug" href="'. $this->sbar_homepage . '" target="_blank">' . __( 'Report a Bug', $this->plugin_slug ) . '</a>';
echo '<a class="sm_button sm_lang" href="' . $this->sbar_glotpress . '" target="_blank">' . __( 'Help translating it', $this->plugin_slug ) . '</a>';
echo '<a class="sm_button sm_star" href="'. $this->sbar_wpratelink . '" target="_blank">'. __( 'Rate the plugin 5 star on WordPress', $this->plugin_slug ) .'.</a>';
echo '<hr><div style="text-align: center; margin-top: 13px"><a href="http://api.addthis.com/oexchange/0.8/forward/facebook/offer?url='. $this->sbar_homepage . '&amp;title='. $this->pluginname .'&amp;pubid=ra-52eb02b34be83059" data-width="850" data-height="500" rel="1" id="pop_1" class="newWindow" title="'. __( 'Share on', $this->plugin_slug ) .' Facebook"><img src="'. plugins_url( 'assets/images/h3_icons/facebook.png', dirname(__FILE__)).'" width="32" height="32" border="0"  alt="*" style="margin-right: 15px" /></a>';
echo'<a href="http://api.addthis.com/oexchange/0.8/forward/google_plusone_share/offer?url='. $this->sbar_homepage .'&amp;pubid=ra-52eb02b34be83059" data-width="500" data-height="600" rel="1" id="pop_2" class="newWindow" title="'. __( 'Share on', $this->plugin_slug ) .' Google Plus"><img src="'. plugins_url( 'assets/images/h3_icons/googleplus.png', dirname(__FILE__)).'" width="32" height="32" border="0" alt="*" style="margin-right: 15px" /></a>';
echo '<a href="http://api.addthis.com/oexchange/0.8/forward/twitter/offer?title=Plugin '. $this->pluginname . '&amp;url='. $this->sbar_homepage .'&amp;pubid=ra-52eb02b34be83059" data-width="500" data-height="690" rel="1" id="pop_5" class="newWindow" title="'. __( 'Share on', $this->plugin_slug ) .' Twitter"><img src="'. plugins_url( 'assets/images/h3_icons/twitter.png', dirname(__FILE__)).'" width="32" height="32" border="0" alt="*" style="margin-right: 15px" /></a>';
echo '<a href="http://api.addthis.com/oexchange/0.8/offer?title='. $this->pluginname . '&amp;url='. $this->sbar_homepage .'&amp;pubid=ra-52eb02b34be83059" data-width="500" data-height="690" rel="1" id="pop_6" class="newWindow" title="'. __( 'Share on', $this->plugin_slug ) .' Addthis"><img src="'. plugins_url( 'assets/images/h3_icons/addthis.png', dirname(__FILE__)).'" width="32" height="32" border="0" alt="*" /></a></div>';
echo '</div></div>';

//----------------------------------------
echo '<div class="postbox fdx-responsive"><div class="handlediv" title="'.__('Click to toggle', $this->plugin_slug) .'"><br /></div><h3 class="hndle"><span>'. __( 'Translation', $this->plugin_slug ) . '</span></h3>';
echo '<div class="inside">';
if (WPLANG == '' || WPLANG == 'en' || WPLANG == 'en_US'  ){
echo '<strong>Would you like to help translating this plugin?</strong><br/> Contribute a translation using the GlotPress web interface - no technical knowledge required (<strong><a href="' . $this->sbar_glotpress . '" target="_blank">how to</a></strong>)';
} else {
echo '<p><div class="dashicons dashicons-admin-users"></div>' .sprintf(__('Translated by: <a href="%s">YOUR NAME</a>', $this->plugin_slug), __('http://YOUR-LINK.COM', $this->plugin_slug) ) . '</p>';
echo '<p>' . __( 'If you find any spelling error in this translation or would like to contribute', $this->plugin_slug ) . ', <a href="' . $this->sbar_glotpress . '" target="_blank">' . __( 'click here', $this->plugin_slug ) . '.</a></p>';
}
echo '</div></div>';

//----------------------------------------
echo '<div class="postbox fdx-responsive"><div class="handlediv" title="'.__('Click to toggle', $this->plugin_slug) .'"><br /></div><h3 class="hndle"><span>'. __( 'Notices', $this->plugin_slug ) . '</span></h3>';
echo '<div class="inside">';

$rss = @fetch_feed( $this->sbar_rss );
     if ( is_object($rss) ) {
        if ( is_wp_error($rss) ) {
            echo 'Newsfeed could not be loaded.';
           } else {
echo '<ul class="sidebnews">';
		foreach ( $rss->get_items(0, 5) as $item ) {
    		$link = $item->get_link();
    		while ( stristr($link, 'http') != $link )
    			$link = substr($link, 1);
    		$link = esc_url(strip_tags($link));
    		$title = esc_attr(strip_tags($item->get_title()));
    		if ( empty($title) )
    			$title = __('Untitled');
			$date = $item->get_date();
            $diff = '';
			if ( $date ) {
                $diff = human_time_diff( strtotime($date, time()) );
				if ( $date_stamp = strtotime( $date ) )
					$date =  date_i18n( get_option( 'date_format' ), $date_stamp );
				else
					$date = '';
			}
echo '<li><a title="'. $date .'" target="_blank" href="'. $link .'">'. $title.' <em class="none">'. $diff.'</em></a></li>';
    }
       echo'</ul>';
   } // if feed error
}
echo '</div></div>';
//----------------------------------------
echo '</div></div>';

/* End of file sidebar-left.php */
/* Location: ./admin/sidebar-left.php */