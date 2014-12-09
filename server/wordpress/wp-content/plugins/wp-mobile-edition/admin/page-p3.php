<?php
$settings = WP_Mobile_Edition_Admin::fdx_get_settings();
/* wrap
*********************************************************************************/
echo '<div class="wrap">';
echo '<h2>'. esc_html( get_admin_page_title() ) . '</h2>';
?>
<h2 class="nav-tab-wrapper fdx-responsive">
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->plugin_slug); ?>"><?php _e('Dashboard', $this->plugin_slug); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->plugin_slug . '-'.$this->_p2); ?>"><?php _e('Core Settings', $this->plugin_slug ); ?></a>
<a class="nav-tab nav-tab-active" href="<?php echo admin_url('admin.php?page='.$this->plugin_slug . '-'.$this->_p3); ?>"><?php _e('Theme Settings', $this->plugin_slug ); ?></a>

</h2>
<?php
//alert
if ( isset($_POST['fdx_page_2']) ) {
echo '<div class="box-shortcode box-green"><strong>' . __( 'Settings Updated', $this->plugin_slug ) . '.</strong></div>';
}


/* poststuff and sidebar
*********************************************************************************/
echo '<div id="poststuff"><div id="post-body" class="metabox-holder columns-2">';
include('sidebar-left.php'); //include
echo '<div class="postbox-container"><div class="meta-box-sortables">';

//form
echo '<form method="post" action="">';
      wp_nonce_field();
echo '<input type="hidden" name="fdx_page_2" value="fdx_form_all_2" />';

$themeInuse = get_option('fdx_switcher_mobile_theme_template');

echo '<div class="postbox">';//------------postbox 1
echo '<div class="handlediv" title="' . __('Click to toggle', $this->plugin_slug) . '"><br /></div><h3 class="hndle"><span>'. __('Settings', $this->plugin_slug) . ' <code>'.$themeInuse.'</code></span>';
echo '</h3><div class="inside">'; ?>

<?php if ( $themeInuse == 'mTheme-Unus'  || $themeInuse == 'mTheme-Unus-demo' ) {
include_once( dirname(__FILE__) . '/p3/mTheme-Unus.php' );

} else { echo '<div class="box-shortcode box-red"><strong>'.__('This theme is incompatible!', $this->plugin_slug).'</strong></div>';
 echo <<<END
<style type="text/css">
#hiddenoff {opacity:0.5 !important;}
</style>
<script>
jQuery(document).ready(function($){
$("#hiddenoff :input").attr("disabled", true);
});
</script>
END;
} ?>

<?php
echo '</div></div>';
echo '<div class="postbox" id="hiddenoff">';//------------postbox 2
echo '<div class="handlediv" title="' . __('Click to toggle', $this->plugin_slug) . '"><br /></div><h3 class="hndle"><span>'. __('General', $this->plugin_slug) . '</span>';
echo '</h3><div class="inside">'; ?>

<br>
<table style="width:100%;" class="widefat">
<thead><tr><th><?php _e('Front page displays', 'wp-mobile-edition') ?></th> </tr></thead>
<tbody><tr class="alternate"><td>

<p><input name="p3_rad1" id="p3_rad1" type="radio" value="0" <?php checked($settings['p3_rad1'], 0); ?> /> <?php _e('Your latest posts', $this->plugin_slug) ?> </p>
<p><input name="p3_rad1" id="p3_rad1" type="radio" value="1" <?php checked($settings['p3_rad1'], 1); ?> /> <?php _e('Custom', $this->plugin_slug) ?> <a href="<?php echo admin_url('edit.php?post_type=mobile');?>"><?php _e('Mobile Pages', 'wp-mobile-edition'); ?></a></p>

</td>
 </tr>
 </tbody>
 </table>



  <br>




<table style="width:100%;" class="widefat">
<thead><tr><th><?php _e('Site Logo / Bookmark Icons', $this->plugin_slug); ?></th> </tr></thead>
<tbody><tr class="alternate"><td>
<p><strong><?php _e('Site Logo', $this->plugin_slug); ?> </strong> <span class="description">(PNG: 100x30 <?php _e('pixels', $this->plugin_slug); ?>, <?php _e('or less', $this->plugin_slug); ?>. )</span></p>
<p><input id="p3_opl1" type="text" name="p3_opl1" value="<?php echo $settings['p3_opl1']; ?>" /><input id="upload_image_button1" type="button" value="Upload" class="button" /></p>
</td>
</tr>


<tr><td>
<p><strong>Favicon </strong> <span class="description">(ico: 32x32 <?php _e('pixels', $this->plugin_slug); ?>)</span></p>
<p><input id="p3_opl2" type="text" name="p3_opl2" value="<?php echo $settings['p3_opl2']; ?>" /><input id="upload_image_button2" type="button" value="Upload" class="button" /></p>
</td>
 </tr>

<tr class="alternate"><td>
<p><strong><?php _e('iPhone & iPod Touch Icon', $this->plugin_slug); ?> </strong> <span class="description">(PNG: 152x152 <?php _e('pixels', $this->plugin_slug); ?>)</span></p>
<p><input id="p3_opl3" type="text" name="p3_opl3" value="<?php echo $settings['p3_opl3']; ?>" /><input id="upload_image_button3" type="button" value="Upload" class="button" /><br><small><?php _e('Auto resizable for', $this->plugin_slug); ?>: 114x114 / 72x72 / 57x57 <?php _e('pixels', $this->plugin_slug); ?></small></p>
</td>
 </tr>


<tr><td>
<p><strong>Win8 <?php _e('icon', $this->plugin_slug); ?> </strong> <span class="description">(PNG: 144x144 <?php _e('pixels', $this->plugin_slug); ?> + <?php _e('tile color', $this->plugin_slug); ?>)</span></p>
<p><input id="p3_opl4" type="text" name="p3_opl4" value="<?php echo $settings['p3_opl4']; ?>" /><input id="upload_image_button4" type="button" value="Upload" class="button" /></p>

<p> <input type="text" value="<?php echo $settings['p3_opl5']; ?>" id="p3_opl5" name="p3_opl5" class="fdx-color-field" /> </p>
</td>
</tr>


 </tbody>
 </table>
   <br>

<table style="width:100%;" class="widefat">
 <thead><tr><th><?php _e('Social Links', 'wp-mobile-edition') ?></th> </tr></thead>
<tbody><tr class="alternate"><td>
<p><?php _e('Enter your URL if you have one. (include http://)', 'wp-mobile-edition') ?>. <strong><?php _e('Leave blank to disable', 'wp-mobile-edition') ?></strong></p>

<p> <input id='p3_txt1' type='text' name='p3_txt1' value='<?php echo $settings['p3_txt1']; ?>' /> &larr;Feed</p>
<p> <input id='p3_txt2' type='text' name='p3_txt2' value='<?php echo $settings['p3_txt2']; ?>' /> &larr;Twitter</p>
<p> <input id='p3_txt3' type='text' name='p3_txt3' value='<?php echo $settings['p3_txt3']; ?>' /> &larr;Facebook</p>
<p> <input id='p3_txt4' type='text' name='p3_txt4' value='<?php echo $settings['p3_txt4']; ?>' /> &larr;Google plus</p>
<p> <input id='p3_txt5' type='text' name='p3_txt5' value='<?php echo $settings['p3_txt5']; ?>' /> &larr;Linkedin</p>
</td>
 </tr>
 </tbody>
 </table>


  <br />

<table style="width:100%;" class="widefat">
 <thead><tr><th><?php _e('Compatibility', 'wp-mobile-edition') ?></th> </tr></thead>
<tbody><tr class="alternate"><td>
<strong><?php _e('Remove these Shortcodes', $this->plugin_slug) ?> </strong><br>
<p> <input id='p3_txt6' type='text' name='p3_txt6' value='<?php echo $settings['p3_txt6']; ?>' /> &larr;<?php _e('Enter a comma separated list of shortcodes to remove, without', $this->plugin_slug); ?> "[&nbsp;]".</p>
</td>
 </tr>
 </tbody>
 </table>



<br>
<table style="width:100%;" class="widefat">
<thead><tr><th><strong><?php _e('Ads', $this->plugin_slug); ?></strong></th> </tr></thead>
<tbody>
<tr><td><?php _e('You can enter your Mobile AdSense here or insert your own banner ad code. These boxes accept both javascript & html. We suggest sizing ads either 298x70px or below.', 'wp-mobile-edition') ?> <strong><?php _e('Leave blank to disable', 'wp-mobile-edition') ?></strong></td></tr>
<tr class="alternate"><td><strong><?php _e('Top Advertisement', $this->plugin_slug); ?>:</strong><br>
<textarea id='p3_tex1' name='p3_tex1' style='width:100%;height:100px;'/>
<?php echo $settings['p3_tex1']; ?>
</textarea>
</td>
 </tr>
<tr class="alternate"><td><strong><?php _e('Bottom Advertisement', $this->plugin_slug); ?>:</strong><br>

<textarea id='p3_tex2' name='p3_tex2' style='width:100%;height:100px;'/>
<?php echo $settings['p3_tex2']; ?>
</textarea>
</td>
</tr>
</tbody>
</table>



<?php
echo '</div></div>';
echo '<div class="postbox closed">';//------------postbox 4
echo '<div class="handlediv" title="' . __('Click to toggle', $this->plugin_slug) . '"><br /></div><h3 class="hndle"><span>'. __('Advanced', $this->plugin_slug) . '</span>';
echo '</h3><div class="inside">'; ?>
<br>
<table style="width:100%;" class="widefat">
<thead><tr><th><strong><?php _e('Custom Code', $this->plugin_slug); ?></strong></th></tr></thead>
<tbody>
<tr><td>HTML, CSS, JavaScript, <?php _e('Statistics', $this->plugin_slug); ?>, <strong><?php _e('Leave blank to disable', 'wp-mobile-edition') ?></strong></td></tr>
<tr class="alternate"><td>
<strong><?php _e('End of', 'wp-mobile-edition') ?> <em>&lt;/head&gt;</em></strong> <br>
<textarea id='p3_tex3' name='p3_tex3' style='width:100%;height:100px;'/>
<?php echo $settings['p3_tex3']; ?>
</textarea>
</td>
</tr>
<tr class="alternate"><td><strong><?php _e('End of', 'wp-mobile-edition') ?> <em>&lt;/body&gt;</em></strong><br>
<textarea id='p3_tex4' name='p3_tex4' style='width:100%;height:100px;'/>
<?php echo $settings['p3_tex4']; ?>
</textarea>
</td>
</tr>
</tbody>
</table>

<br>


 <table style="width:100%;" class="widefat">
 <thead><tr><th><?php _e('WP Themes Function', $this->plugin_slug); ?></th> </tr></thead>
<tbody><tr class="alternate"><td>
<p><input name="p3_check_1" id="p3_check_1" type="checkbox" value="1" <?php checked($settings['p3_check_1'], 1); ?> /> <?php _e('Enable the Function', $this->plugin_slug) ?> <code>wp_head();</code> [<a href="https://codex.wordpress.org/Plugin_API/Action_Reference/wp_head" target="_blank">?</a>]</p>

<p><input name="p3_check_2" id="p3_check_2" type="checkbox" value="1" <?php checked($settings['p3_check_2'], 1); ?> /> <?php _e('Enable the Function', $this->plugin_slug) ?> <code>wp_footer();</code> [<a href="https://codex.wordpress.org/Plugin_API/Action_Reference/wp_footer" target="_blank">?</a>]</p>

</td>
</tr>
</tbody>
</table>









<?php
echo '</div></div>';//end postbox
//------------------------------------------------------ buttons
echo '<div class="button_submit">';
echo submit_button( __('Save all options', $this->plugin_slug ), 'primary', 'Submit', false, array( 'id' => '' ) ) ;
echo '</div>';
echo '</form>'; //form 1

echo '<div class="button_reset">';
echo '<form method="post" action="">';
echo '<input type="hidden" name="fdx_page_2" value="fdx_reset_2" />';
echo submit_button( __('Restore Defaults', $this->plugin_slug ), 'secondary', 'Submit' , false, array( 'id' => 'space', 'onclick' => 'return confirm(\'' . esc_js( __( 'Restore Default Settings?',  $this->plugin_slug ) ) . '\');' ) );
echo '</form>';//form 2
echo '</div>';
//------------ meta-box-sortables | postbox-container | post-body | poststuff | wrap
echo '</div></div></div></div></div>';
?>
<script>
jQuery(document).ready(function() {
        jQuery('#upload_image_button1').click(function() {
            tb_show('<?php echo $this->pluginname . ' : Logo'?>', 'media-upload.php?TB_iframe=true');
            window.send_to_editor = function(html) {
                url = jQuery(html).attr('href');
                jQuery('#p3_opl1').val(url);
                tb_remove();
            };
        return false;
        });

    jQuery('#upload_image_button2').click(function() {
            tb_show('<?php echo $this->pluginname . ' : Favicon'?>', 'media-upload.php?TB_iframe=true');
            window.send_to_editor = function(html) {
                url = jQuery(html).attr('href');
                jQuery('#p3_opl2').val(url);
                tb_remove();
            };
        return false;
        });

    jQuery('#upload_image_button3').click(function() {
            tb_show('<?php echo $this->pluginname . ' : Apple Touch Icon'?>', 'media-upload.php?TB_iframe=true');
            window.send_to_editor = function(html) {
                url = jQuery(html).attr('href');
                jQuery('#p3_opl3').val(url);
                tb_remove();
            };
        return false;
        });

    jQuery('#upload_image_button4').click(function() {
            tb_show('<?php echo $this->pluginname . ' : Win8 icon'?>', 'media-upload.php?TB_iframe=true');
            window.send_to_editor = function(html) {
                url = jQuery(html).attr('href');
                jQuery('#p3_opl4').val(url);
                tb_remove();
            };
        return false;
        });
});

jQuery(document).ready(function($){
    $('.fdx-color-field').wpColorPicker();
});
</script>
<?php
/* End of file page-p3.php */
/* Location: ./admin/page-p3.php */