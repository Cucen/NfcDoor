<br>
<table style="width:100%;" class="widefat">
<thead><tr><th><?php _e('Theme Choices', 'wp-mobile-edition') ?></th> </tr></thead>
<tbody><tr class="alternate">
<td>
<select name="p3_sel1" id="p3_sel1" >
    <option value="black" <?php selected( $settings['p3_sel1'], 'black' ); ?>>Black</option>
    <option value="blue" <?php selected( $settings['p3_sel1'], 'blue' ); ?>>Blue</option>
    <option value="brown" <?php selected( $settings['p3_sel1'], 'brown' ); ?>>Brown</option>
    <option value="green" <?php selected( $settings['p3_sel1'], 'green'); ?>>Green</option>
    <option value="grey" <?php selected( $settings['p3_sel1'], 'grey'); ?>>Grey</option>
    <option value="pink" <?php selected( $settings['p3_sel1'], 'pink'); ?>>Pink</option>
    <option value="red" <?php selected( $settings['p3_sel1'], 'red'); ?>>Red</option>
    <option value="teal" <?php selected( $settings['p3_sel1'], 'teal'); ?>>Teal</option>
</select>




</td>
 </tr>
 </tbody>
 </table>


    <br />

 <table style="width:100%;" class="widefat">
 <thead><tr><th>Top Menu Items</th> </tr></thead>
<tbody><tr class="alternate"><td>
<p><input type="checkbox" checked="checked" disabled="disabled" />1- Front page <em>(Home icon or Site logo)</em></p>
<p><input name="p3_check_t1" id="p3_check_t1" type="checkbox" value="1" <?php checked($settings['p3_check_t1'], 1); ?> />2- <?php _e('Custom navigation menus', $this->plugin_slug) ?> <em>(<a href="<?php echo admin_url('nav-menus.php');?>">WP Mobile Edition</a>) </em></p>
<p><input name="p3_check_t2" id="p3_check_t2" type="checkbox" value="1" <?php checked($settings['p3_check_t2'], 1); ?> />3- <?php _e('Categories', $this->plugin_slug) ?> </p>
<p><input name="p3_check_t3" id="p3_check_t3" type="checkbox" value="1" <?php checked($settings['p3_check_t3'], 1); ?> />4- <?php _e('Site Search', $this->plugin_slug) ?> </p>
<p><input name="p3_check_t5" id="p3_check_t5" type="checkbox" value="1" <?php checked($settings['p3_check_t5'], 1); ?> />5- <?php _e('Blog Index', $this->plugin_slug) ?> </p>
<p><input name="p3_check_t4" id="p3_check_t4" type="checkbox" value="1" <?php checked($settings['p3_check_t4'], 1); ?> />6- <?php _e('Contact Page', $this->plugin_slug) ?></p>
</td>
</tr>
 </tbody>
 </table>