<?php
/* wrap
*********************************************************************************/
echo '<div class="wrap">';
echo '<h2>'. esc_html( get_admin_page_title() ) . '</h2>';
?>
<h2 class="nav-tab-wrapper fdx-responsive">
<a class="nav-tab nav-tab-active" href="<?php echo admin_url('admin.php?page='.$this->plugin_slug); ?>"><?php _e('Dashboard', $this->plugin_slug); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->plugin_slug . '-'.$this->_p2); ?>"><?php _e('Core Settings', $this->plugin_slug ); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->plugin_slug . '-'.$this->_p3); ?>"><?php _e('Theme Settings', $this->plugin_slug ); ?></a>
</h2>
<?php
//display warning if test were never run



/* poststuff and sidebar
*********************************************************************************/
echo '<div id="poststuff"><div id="post-body" class="metabox-holder columns-2">';
include('sidebar-left.php'); //include
echo '<div class="postbox-container"><div class="meta-box-sortables">';

//------------postbox 1
echo '<div class="postbox closed">';//------------postbox 2
echo '<div class="handlediv" title="' . __('Click to toggle', $this->plugin_slug) . '"><br /></div><h3 class="hndle"><span>'. __('Mobile Emulator', $this->plugin_slug) . '</span>';
echo '</h3><div class="inside">'; ?>
<div id="main-wrapper">

 <?php $urldemo = get_bloginfo('url'); ?>
<div class="ot_iphone_preview">
<div class="ot_loader"></div>
<iframe id="iphone-iframe" name="iphone-iframe" src="<?php echo $urldemo; ?>" width="358" height="535" frameborder="0"></iframe>
<div id="ot_iphone_refresh"><a href="javascript:location.reload(true)"><img width="60" height="60" src="<?php echo plugins_url( 'assets/images/demo/spacer.gif', dirname(__FILE__));?>" border="0" /></a></div>
</div>
<!-- ****************************************** -->
<div class="clear"></div>

          <div id="box_bg">
            <div id="content">
                  <div class="qrcodes">
                <?php
                 $width = $height = 100;
                 $url = urlencode($urldemo);
                 $error = "H"; // handle up to 30% data loss, or "L" (7%), "M" (15%), "Q" (25%)
                 $border = 1;
                 echo "<img src=\"http://chart.googleapis.com/chart?". "chs={$width}x{$height}&cht=qr&chld=$error|$border&chl=$url\" />";?>
                 </div>
              </div>
               </div>
        </div>





<?php
//------------postbox 2
echo '</div></div>';
echo '<div class="postbox">';
echo '<div class="handlediv" title="' . __('Click to toggle', $this->plugin_slug) . '"><br /></div><h3 class="hndle"><span>'. __('Overview', $this->plugin_slug) . '</span>';
echo '</h3><div class="inside">';
?>
<br>
<table style="width:100%;" class="widefat">
<thead><tr><th><strong><?php _e('Switching Shortcodes', $this->plugin_slug); ?></strong></th> </tr></thead>
<tbody><tr><td>
<p><?php _e('Use the following shortcode to show the theme switch link', $this->plugin_slug); ?>:<br><code>[fdx-switch-link]</code></p>
<p><?php _e('Use the following shortcode in templates themes to show the theme switch link', $this->plugin_slug); ?>:<br><code>&lt;?php echo do_shortcode('[fdx-switch-link]'); ?&gt;</code> </p>
<p><?php _e('Or', $this->plugin_slug); ?> <a href="<?php echo admin_url('widgets.php'); ?>">Widgets</a>, <?php _e('or auto added in', $this->plugin_slug); ?> <a href="<?php echo admin_url('admin.php?page='.$this->plugin_slug . '-'.$this->_p2); ?>"><?php _e('Core Settings', $this->plugin_slug ); ?></a>.</p>
 <?php _e('Regardless of this setting, the switcher link will always appear on the mobile theme', $this->plugin_slug); ?>
</td>
</tr>
</tbody>
</table>
            <br>
<?php
		$themeList	= wp_get_themes();
				$module_html = '';
 				if( $themeList && is_array($themeList) && count($themeList) > 0 ){
					$module_html .= '<table style="width:100%;" class="widefat"><thead><tr><th><strong>'.__('Mobile Themes Compatibles', $this->plugin_slug).'</strong></th><th>'.__('Version', $this->plugin_slug).'</th></tr></thead>';
					foreach( $themeList as $theme_slug => $theme){
                //----------------------------------------------------------------------------
				   	$theme_tags = $theme->display( 'Tags', FALSE );
				if( $theme_tags && is_array($theme_tags) && count($theme_tags) > 0 && (
					array_search('WP-Mobile-Edition-mTheme', 	$theme_tags) !== false ||
					array_search('wp-mobile-edition-mtheme', 	$theme_tags) !== false
				)){
				    $module_html .= '
					<tr>
								<td><strong>' . $theme->display( 'Name', FALSE ) . '</strong> <small><em>('.$theme_slug.')</em></small></td>
                                <td><strong>' . $theme->display( 'Version', FALSE ) . '</strong></td>
							</tr>
						';
                  }
               //----------------------------------------------------------------------------
                   $module_html .= '';
					}
					$module_html .= '
						</tbody>
                        </table>
					';
				}else{
					$module_html .= __('Sorry, no theme found.', 'wp_mobilizer');
				}
			 	echo $module_html;
?>





<?php
echo '</div></div>';
echo '<div class="postbox" id="hiddenoff">';//------------postbox 3
echo '<div class="handlediv" title="' . __('Click to toggle', $this->plugin_slug) . '"><br /></div><h3 class="hndle"><span>'. __('Mobile Themes', $this->plugin_slug) . '</span>';
echo '</h3><div class="inside">'; ?>

<div id="fdx-tablegrid">
<ul>
<li>
<table class="widefat fdx-hover-s">
<thead><tr><th><a href="http://dev.fabrix.net/run/demo/" target="_blank" title="Demo"><strong>mTheme-Unus</strong></a></th></tr></thead>
<tbody>
<tr>
<td class="alternate"><img src="<?php echo plugins_url( 'assets/images/screenshots/mtheme1.png', dirname(__FILE__));?>" alt="*" width="200" height="150"></td>
</tr>
</tbody>
 </table>
 </li>
 <li>
<table class="widefat">
<thead><tr><th>mTheme-Duo</th></tr></thead>
<tbody>
<tr>
<td class="alternate"><img src="<?php echo plugins_url( 'assets/images/screenshots/t1.png', dirname(__FILE__));?>" alt="*" width="200" height="150"></td>
</tr>
</tbody>
 </table>
</li>
<li>
 <table class="widefat">
<thead><tr><th>mTheme-Triginta</th></tr></thead>
<tbody>
<tr>
<td class="alternate"><img src="<?php echo plugins_url( 'assets/images/screenshots/t1.png', dirname(__FILE__));?>" alt="*" width="200" height="150"></td>
</tr>
</tbody>
 </table>
 </li>
 <li>
<table class="widefat">
<thead><tr><th>mTheme-Quattuor</th></tr></thead>
<tbody>
<tr>
<td class="alternate"><img src="<?php echo plugins_url( 'assets/images/screenshots/t1.png', dirname(__FILE__));?>" alt="*" width="200" height="150"></td>
</tr>
</tbody>
 </table>
 </li>
 <li>
<table class="widefat">
<thead><tr><th>mTheme-Quinque</th></tr></thead>
<tbody>
<tr>
<td class="alternate"><img src="<?php echo plugins_url( 'assets/images/screenshots/t1.png', dirname(__FILE__));?>" alt="*" width="200" height="150"></td>
</tr>
</tbody>
 </table>
</li>
<li>
 <table class="widefat">
<thead><tr><th>mTheme-Septem</th></tr></thead>
<tbody>
<tr>
<td class="alternate"><img src="<?php echo plugins_url( 'assets/images/screenshots/t1.png', dirname(__FILE__));?>" alt="*" width="200" height="150"></td>
</tr>
</tbody>
 </table>
 </li>
</ul>
 </div>

<div class="clear"></div>
<?php
//--------------------
echo '</div></div>';
//------------ meta-box-sortables | postbox-container | post-body | poststuff | wrap
echo '</div></div></div></div></div>';
//-----------------------------------------

