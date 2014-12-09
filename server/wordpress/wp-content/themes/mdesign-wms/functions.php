<?php
if ( function_exists('register_sidebar') )
register_sidebar(array(
'before_widget' => '
		<!-- Bileşen -->
		<div class="sag-menu-baslik">',
'after_widget' => '		<div class="temizlik"></div>
		</div>
		<div class="sag-menu-alt"></div>
		<!--/Bileşen -->
		
',
'before_title' => '',
'after_title' => '</div>
		<div class="sag-menu-icerik">
',
));

function wp_mdesign_menu() {
    // Üstü Menü Özellikleri:
        add_menu_page(__('mDesign v1.0 Ayar Paneli','mdesign'), __('mDesign Ayarları','mdesign'), 6, basename(__FILE__) , 'wp_mdesign_admin', get_bloginfo('template_url').'/images/md.png');
    // Alt menü özellikleri:
        add_submenu_page(basename(__FILE__), __('mDesign Ayarlar','mdesign'),  __('mDesign Ayarlar','mdesign') , 6, basename(__FILE__) , 'wp_mdesign_admin');
}
add_action('admin_menu', 'wp_mdesign_menu');
 
$mdesign_options = (
    array(
 
        array(__('<h5>Tema ile ilgili sorun yaşıyorsanız. <a href="http://wmscripti.com/temalar/mdesign-wordpress-blog-temasi.html" title="Teknik Destek">Buraya</a> tıklayarak bizden yardım alabilirsiniz.</h5><h3>Tema Kullanım Ayarları</h3>','mdesign'), array(
            array('facebook', __('http://www.facebook.com/','mdesign'), __('<b>Facebook:</b>','mdesign'),'',''),
            array('twitter', __('http://twitter.com/','mdesign'), __('<b>Twitter:</b>','mdesign'),'',''),
            array('dribbble', __('http://dribbble.com/','mdesign'), __('<b>Dribbble:</b>','mdesign'),'',''),
            array('flickr', __('http://www.flickr.com/','mdesign'), __('<b>Flickr:</b>','mdesign'),'',''),
            array('myspace', __('http://www.myspace.com/','mdesign'), __('<b>MySpace:</b>','mdesign'),'',''),
            array('headkodlar', __('','mdesign'), __('<b>Sayaç veya Diğer Kodlar:</b>','mdesign'),'<i>Head etiketinden önce eklenecek kodları yazınız.</i>','textarea'),
            )
        ),
        array(__('Reklam Ayarı','mdesign'), array(
            array('enable_ustreklam', 'yes', __('<b>Reklam aktif olsun mu?</b>','mdesign'),__('','mdesign'),'yesno'),
            array('reklambaslik', __('Reklam Alanı','mdesign'), __('<b>Reklam başlık:</b>','mdesign'),'<i>Reklamın title ve alt etiketine eklenecek başlığı girin.</i>',''),
            array('reklamresim', __('/wp-content/themes/mdesign-wms/images/reklam.png','mdesign'), __('<b>Reklam resim:</b>','mdesign'),'<i>Resim dosyası 468x60 formatında olmalıdır.</i>',''),
            array('reklamlink', __('http://wmscripti.com','mdesign'), __('<b>Reklam link:</b>','mdesign'),'<i>Reklama tıklandığında gideceği linki yazınız.</i>',''),
            )
        ),
        array(__('Tavsiye Bağlantılar','mdesign'), array(
            array('enable_tavsiye', 'yes', __('<b>Tavsiye bağlantılar aktif olsun mu?</b>','mdesign'),__('','mdesign'),'yesno'),
			array('tavsiyekodlar', __('<!--Tavsiye Bağlantı 1-->
<li><a href="#"><img src="/wp-content/themes/mdesign-wms/images/tavsiye.png" alt="Tavsiye-1" /></a></li>

<!--Tavsiye Bağlantı 2-->
<li><a href="#"><img src="/wp-content/themes/mdesign-wms/images/tavsiye.png" alt="Tavsiye-2" /></a></li>

<!--Tavsiye Bağlantı 3-->
<li><a href="#"><img src="/wp-content/themes/mdesign-wms/images/tavsiye.png" alt="Tavsiye-3" /></a></li>

<!--Tavsiye Bağlantı 4-->
<li><a href="#"><img src="/wp-content/themes/mdesign-wms/images/tavsiye.png" alt="Tavsiye-4" /></a></li>','mdesign'), __('<b>Tavsiye bağlantı kodları:</b><br/><i><u>Örnek Kod:</u> &lt;li&gt;&lt;a href="<font color="red">Gidilecek Link</font>"&gt;&lt;img src="<font color="red">Resim Linki</font>" alt="<font color="red">Site Adı</font>" /&gt;&lt;/a&gt;&lt;/li&gt;&lt;/i&gt;','mdesign'),'<i>Tavsiye bağlantıları bu kısımdan ekleyebilirsiniz.</i>','textarea'),
            )
        )
    )
);
 
foreach($mdesign_options as $section) {
    foreach($section[1] as $option) {
        add_option($option[0], $option[1]);
    }
}
 
function wp_mdesign_admin_css() {
    ?>
 
    <?php
}
add_action('admin_head', 'wp_mdesign_admin_css');
 
function wp_mdesign_admin() {
 
    global $mdesign_options;
 
    if ($_POST['save_mdesign_options']) {
 
        foreach($mdesign_options as $section) {
            foreach($section[1] as $option) {
                update_option($option[0],stripslashes($_POST[$option[0]]));
            }
        }
 
        /* Başarılı */
        echo '<div id="message" class="updated fade"><p><strong>'.__('Ayarlarınız başarılı bir şekilde kaydedilmiştir.','mdesign').'</strong></p></div>';
    }
    ?>
    <div class="wrap">
        <h2><?php _e('mDesign v1.0 Blog Teması Ayar Paneli', 'mdesign'); ?></h2>
        <form method="post" action="admin.php?page=functions.php" id="mdesign_form">
            <?php
            foreach($mdesign_options as $section) {
                echo '<h3>'.$section[0].'</h3><div class="mdesign_section"><table cellspacing="0" cellpadding="0" class="form-table">';
                foreach($section[1] as $option) {
                    echo '<tr valign="top">';
 
                    echo '<th><label for="'.$option[0].'">'.$option[2].'</label></th><td>';
 
                    if ($option[4]=='yesno') {
                        $yes = '';
                        $no = '';
                        if (get_option($option[0])=='yes') $yes='selected="selected"'; else $no='selected="selected"';
                        echo '<select name="'.$option[0].'">
                            <option value="yes" '.$yes.'>'.__('Evet','mdesign').'</option>
                            <option value="no" '.$no.'>'.__('Hayır','mdesign').'</option>
                        </select>';
                    } elseif ($option[4]=='textarea') {
                        echo '<textarea id="'.$option[0].'" name="'.$option[0].'" cols="40" rows="4">'.get_option($option[0]).'</textarea>';
                    } elseif ($option[4]=='select_options') {
                        $selected = '';
                        echo '<select name="'.$option[0].'">';
 
                        $names = explode('|', $option[5]);
                        $values = explode('|', $option[6]);
                        $selected = get_option($option[0]);
 
                        $loop = 0;
 
                        if ($names) {
                            foreach ($names as $name) {
 
                                echo '<option value="'.$values[$loop].'" ';
 
                                if ($selected==$values[$loop]) echo 'selected="selected"';
 
                                echo '>'.$name.'</option>';
 
                                $loop++;
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<input type="text" id="'.$option[0].'" name="'.$option[0].'" size="50" value="'.get_option($option[0]).'" />';
                    }
 
                    if ($option[3]) echo '<br/><span class="setting-description">'.$option[3].'</span>';
 
                    echo '</td></tr>';
                }
                echo '</table></div><br class="clear" />';
            }
            ?>
            <p class="submit" style="text-align:right"><input type="submit" value="<?php _e('Kaydet', 'mdesign'); ?>" name="save_mdesign_options" /></p>
        </form>
    </div>
    <?php } ?>