<?php
echo '<div class="wrap">';
echo '<h2>'. esc_html( get_admin_page_title() ) . '</h2>';
?>
<h2 class="nav-tab-wrapper fdx-responsive">
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->plugin_slug); ?>"><?php _e('Dashboard', $this->plugin_slug); ?></a>
<a class="nav-tab nav-tab-active" href="<?php echo admin_url('admin.php?page='.$this->plugin_slug . '-'.$this->_p2); ?>"><?php _e('Core Settings', $this->plugin_slug ); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->plugin_slug . '-'.$this->_p3); ?>"><?php _e('Theme Settings', $this->plugin_slug ); ?></a>

</h2>
<?php
/* poststuff and sidebar
*********************************************************************************/
echo '<div id="poststuff"><div id="post-body" class="metabox-holder columns-2">';
include('sidebar-left.php'); //include
echo '<div class="postbox-container"><div class="meta-box-sortables">';

//form
echo '<form method="post" action="">';
echo '<input type="hidden" name="info_update" id="info_update" value="true" />';

echo '<div class="postbox">';//------------postbox 1
echo '<div class="handlediv" title="' . __('Click to toggle', $this->plugin_slug) . '"><br /></div><h3 class="hndle"><span>'. __('Core Settings', $this->plugin_slug). '</span>';
echo '</h3><div class="inside">'; ?>


<br>
<table style="width:100%;" class="widefat">
 <thead><tr><th><strong><?php _e('Switcher Mode', $this->plugin_slug); ?></strong></th> </tr></thead>
<tbody><tr class="alternate"><td>
<p><?php print WP_Mobile_Edition::fdx_switcher_option('fdx_switcher_mode', 'wpmpSwitcherMode();'); ?></p>
</td>
</tr>
<tr class="fdx_links"><td><p><?php print WP_Mobile_Edition::fdx_switcher_option('fdx_switcher_tablet'); ?> <?php _e('Enable Switcher mode for tablets', $this->plugin_slug); ?>.</p></td></tr>
</tbody>
 </table>

 <br>


<table style="width:100%;" class="widefat fdx_theme">
 <thead><tr><th><strong><?php _e('Mobile Theme', $this->plugin_slug); ?></strong></th> </tr></thead>
<tbody>
<tr><td><?php _e('The theme that will be sent to a mobile user.', $this->plugin_slug); ?></td></tr>
<tr class="alternate"><td>
<p><?php print WP_Mobile_Edition::fdx_switcher_option('fdx_switcher_mobile_theme'); ?> <?php _e('Desktop users will receive ', $this->plugin_slug); ?> <code><?php print WP_Mobile_Edition::fdx_switcher_desktop_theme(); ?></code>
</p>
</td>
 </tr>
 </tbody>
 </table>


<br>

<table style="width:100%;" class="widefat fdx_mobile_domain">
<thead><tr class='fdx_desktop_domain'><th><strong><?php _e('Mobile Subdomain', $this->plugin_slug); ?></strong></th> </tr></thead>
<tbody>
<tr><td><?php _e('Subdomain for your mobile site', $this->plugin_slug); ?> (<?php _e('i.e.', $this->plugin_slug); ?> <strong>m.domain.com</strong>, <a href="http://wordpress.org/plugins/wp-mobile-edition/other_notes/" title="<?php _e('Setting up a subdomain is done through your hosting provider', $this->plugin_slug); ?>" target="_blank"><?php _e('learn more', $this->plugin_slug); ?></a>)</td></tr>
<tr class="alternate"><td>
<p><?php print WP_Mobile_Edition::fdx_switcher_option('fdx_switcher_mobile_domains'); ?>  <?php if (strpos(get_option('fdx_switcher_mode'), 'domain')!==false && WP_Mobile_Edition::fdx_switcher_domains('desktop', true) == WP_Mobile_Edition::fdx_switcher_domains('mobile', true)) {
              echo "<span style='color:#770000'>". __("<strong>Warning:</strong> your primary desktop and mobile domains are the same. The switcher will default to 'browser detection' mode unless one is changed.", $this->plugin_slug).'</span>';
            }
          ?>
          </p>
<div style="display: none"> <?php print WP_Mobile_Edition::fdx_switcher_option('fdx_switcher_desktop_domains'); ?> </div>
</td>
</tr>
 </tbody>
 </table>

 <br>


<table style="width:100%;" class="widefat fdx_links">
<thead><tr><th><strong><?php _e('Theme Switch Link', $this->plugin_slug); ?></strong></th> </tr></thead>
<tbody><tr class="alternate"><td>
<p><?php print WP_Mobile_Edition::fdx_switcher_option('fdx_switcher_footer_links'); ?> <?php _e('Enable Manual Switcher Link whilst on Desktop', $this->plugin_slug); ?>.</p>
</td>
</tr>
</tbody>
</table>






<div class="clear"></div>
<!-- ############################################################################################################### -->
<?php
echo '</div></div>';//end postbox
echo '<div class="button_submit">';
echo submit_button( __('Save all options', $this->plugin_slug ), 'primary', 'fdx1_update_settings', false, array( 'id' => '' ) ) ;
echo '</div>';

echo '<div class="button_reset">';
echo submit_button( __('Restore Defaults', $this->plugin_slug ), 'secondary', 'reset' , false, array( 'id' => 'space', 'onclick' => 'return confirm(\'' . esc_js( __( 'Restore Default Settings?',  $this->plugin_slug ) ) . '\');' ) );
echo '</form>';//form 2
echo '</div>';

// meta-box-sortables | postbox-container | post-body | poststuff | wrap
echo '</div></div></div></div></div>';
?>
<script>
  var fdx_pale = 0.3;
  var fdx_speed = 'slow';
  function wpmpSwitcherMode(speed) {
    if (speed==null) {speed=fdx_speed;}
    var value = jQuery("#fdx_switcher_mode").val();
    var browser = value.indexOf("browser")>-1;
    var domain = value.indexOf("domain")>-1;
    jQuery(".fdx_desktop_domain").children().fadeTo(speed, (domain||browser) ? 1 : fdx_pale);
    jQuery(".fdx_mobile_domain").children().fadeTo(speed, domain ? 1 : fdx_pale);
    jQuery(".fdx_theme").children().fadeTo(speed, (domain||browser) ? 1 : fdx_pale);
    jQuery(".fdx_links").children().fadeTo(speed, (domain||browser) ? 1 : fdx_pale);
  }
  wpmpSwitcherMode(-1);
</script>
<?php
/* End of file page-p1.php */
/* Location: ./admin/page-p1.php */