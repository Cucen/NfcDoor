<?php
define( 'LAYOUT_PATH', get_template_directory() . '/assets/css/skins/' );
define( 'OPTIONS_PATH', get_template_directory_uri() . '/themeoptions/options/' );

// BEGIN Config

if ( !class_exists( "ReduxFramework" ) ) {
        return;
} 

if ( !class_exists( "Redux_Framework_Virtue_config" ) ) {
        class Redux_Framework_Virtue_config {
          public $args = array();
                public $sections = array();
                public $theme;
                public $ReduxFramework;

                public function __construct( ) {
                  // Create the sections and fields
                  $this->setSections();
                  // Set the default arguments
                  $this->setArguments();
                  $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
                }

                public function setSections() {

                $alt_stylesheet_path = LAYOUT_PATH;
$alt_stylesheets = array(); 
if ( is_dir($alt_stylesheet_path) ) {if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) {while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {if(stristr($alt_stylesheet_file, ".css") !== false) {$alt_stylesheets[$alt_stylesheet_file] = $alt_stylesheet_file;}}}}

// For use with a tab example below

    ob_start();
?>
<div id="" class="">
       
        <h4><?php echo __('Copy and Paste this code into the theme options import feature', 'virtue');?></h4>
     <?php $thenewoptions = get_option('virtue');
     if(!empty($thenewoptions['import_old']) && $thenewoptions['import_old'] == 1) {
        if(!empty($thenewoptions['old_options_child'])) {
            $locateoldoptions = 'theme_mods_'.$thenewoptions['old_options_child'];
        } else {
            $locateoldoptions = 'theme_mods_virtue';
        }
     $old_options = get_option($locateoldoptions); if(!empty($old_options)) {
     if(isset($old_options['introduction'])) {unset($old_options['introduction']);}
     if(isset($old_options['0'])) {unset($old_options['0']);}
     if(isset($old_options['info_blog_settings'])) {unset($old_options['info_blog_settings']);}
     if(isset($old_options['info_portfolio_settings'])) {unset($old_options['info_portfolio_settings']);}
     if(isset($old_options['info_shop_settings'])) {unset($old_options['info_shop_settings']);}
     if(isset($old_options['info_main_background'])) {unset($old_options['info_main_background']);}
     if(isset($old_options['info_topbar_background'])) {unset($old_options['info_topbar_background']);}
     if(isset($old_options['info_header_background'])) {unset($old_options['info_header_background']);}
     if(isset($old_options['info_menu_background'])) {unset($old_options['info_menu_background']);}
     if(isset($old_options['info_feature_background'])) {unset($old_options['info_feature_background']);}
     if(isset($old_options['info_footer_background'])) {unset($old_options['info_footer_background']);}
     if(isset($old_options['info_body_background'])) {unset($old_options['info_body_background']);}
     if(isset($old_options['Info_header_Font'])) {unset($old_options['Info_header_Font']);}
     if(isset($old_options['smof_init'])) {unset($old_options['smof_init']);}
     if(isset($old_options['Info_Menu_mobile_Font'])) {unset($old_options['Info_Menu_mobile_Font']);}
     if(isset($old_options['info_basic_styling'])) {unset($old_options['info_basic_styling']);}
     if(isset($old_options['info_language'])) {unset($old_options['info_language']);}
     if(isset($old_options['info_breadcrumbs'])) {unset($old_options['info_breadcrumbs']);}
     if(isset($old_options['info_product_best_settings'])) {unset($old_options['info_product_best_settings']);}
     if(isset($old_options['Info_home_slider'])) {unset($old_options['Info_home_slider']);}
     if(isset($old_options['info_topbar_settings'])) {unset($old_options['info_topbar_settings']);}
     if(isset($old_options['info_product_settings'])) {unset($old_options['info_product_settings']);}
     if(isset($old_options['info_sidebars'])) {unset($old_options['info_sidebars']);}
     if(isset($old_options['info_mobile_slider'])) {unset($old_options['info_mobile_slider']);}
     if(isset($old_options['info_iconmenu_settings'])) {unset($old_options['info_iconmenu_settings']);}
     if(isset($old_options['info_product_feat_settings'])) {unset($old_options['info_product_feat_settings']);}
     if(isset($old_options['info_product_sale_settings'])) {unset($old_options['info_product_sale_settings']);}
     if(isset($old_options['info_portfolio_full_settings'])) {unset($old_options['info_portfolio_full_settings']);}
     if(isset($old_options['info_page_content'])) {unset($old_options['info_page_content']);}
     if(isset($old_options['info_mobile_background'])) {unset($old_options['info_mobile_background']);}
     if(isset($old_options['Info_Menu_primary_Font'])) {unset($old_options['Info_Menu_primary_Font']);}
     if(isset($old_options['Info_body_Font'])) {unset($old_options['Info_body_Font']);}
     if(isset($old_options['Info_Menu_Font'])) {unset($old_options['Info_Menu_Font']);}
     if(isset($old_options['Info_Menu_Secondary_Font'])) {unset($old_options['Info_Menu_Secondary_Font']);}
     if(isset($old_options['info_portfolio_grid'])) {unset($old_options['info_portfolio_grid']);}
     if(isset($old_options['info_custom_carousel_settings'])) {unset($old_options['info_custom_carousel_settings']);}
     if(isset($old_options['sidebars_widgets'])) {unset($old_options['sidebars_widgets']);}
     if(isset($old_options['font_logo_style']['size'])) {
            $old_options['font_logo_style']['font-size'] = $old_options['font_logo_style']['size'];
            unset($old_options['font_logo_style']['size']);
        }
        if(isset($old_options['font_logo_style']['height'])) {
            $old_options['font_logo_style']['line-height'] = $old_options['font_logo_style']['height'];
            unset($old_options['font_logo_style']['height']);
        }
        if(isset($old_options['font_logo_style']['style'])) {unset($old_options['font_logo_style']['style']);}
        if(isset($old_options['font_logo'])) {
            $old_options['font_logo_style']['font-family'] = $old_options['font_logo'];
            unset($old_options['font_logo']);
        }
        // tagline font
        if(isset($old_options['font_tagline_style']['size'])) {
            $old_options['font_tagline_style']['font-size'] = $old_options['font_tagline_style']['size'];
            unset($old_options['font_tagline_style']['size']);
        }
        if(isset($old_options['font_tagline_style']['height'])) {
            $old_options['font_tagline_style']['line-height'] = $old_options['font_tagline_style']['height'];
            unset($old_options['font_tagline_style']['height']);
        }
      if(isset($old_options['font_tagline_style']['style'])) {
          unset($old_options['font_tagline_style']['style']);
      }
        if(isset($old_options['font_tagline'])) {
            $old_options['font_tagline_style']['font-family'] = $old_options['font_tagline'];
            unset($old_options['font_tagline']);
        }
        // H1 font
        if(isset($old_options['font_h1']['size'])) {
            $old_options['font_h1']['font-size'] = $old_options['font_h1']['size'];
            unset($old_options['font_h1']['size']);
        }
        if(isset($old_options['font_h1']['height'])) {
            $old_options['font_h1']['line-height'] = $old_options['font_h1']['height'];
            unset($old_options['font_h1']['height']);
        }
        if(isset($old_options['font_h1']['style'])) {
          unset($old_options['font_h1']['style']);
      }
        if(isset($old_options['font_header'])) {
            $old_options['font_h1']['font-family'] = $old_options['font_header'];
            $old_options['font_h2']['font-family'] = $old_options['font_header'];
            $old_options['font_h3']['font-family'] = $old_options['font_header'];
            $old_options['font_h4']['font-family'] = $old_options['font_header'];
            $old_options['font_h5']['font-family'] = $old_options['font_header'];
            unset($old_options['font_header']);
        }
        // H2 font
        if(isset($old_options['font_h2']['size'])) {
            $old_options['font_h2']['font-size'] = $old_options['font_h2']['size'];
        }
        if(isset($old_options['font_h2']['height'])) {
            $old_options['font_h2']['line-height'] = $old_options['font_h2']['height'];
        }
        if(isset($old_options['font_h2']['style'])) {
         unset($old_options['font_h2']['style']);
        }
        // H3 font
        if(isset($old_options['font_h3']['size'])) {
            $old_options['font_h3']['font-size'] = $old_options['font_h3']['size'];
            unset($old_options['font_h3']['size']);
        }
        if(isset($old_options['font_h3']['height'])) {
            $old_options['font_h3']['line-height'] = $old_options['font_h3']['height'];
            unset($old_options['font_h3']['height']);
        }
        if(isset($old_options['font_h3']['style'])) {
        unset($old_options['font_h3']['style']);
        }
        // H4 font
        if(isset($old_options['font_h4']['size'])) {
            $old_options['font_h4']['font-size'] = $old_options['font_h4']['size'];
            unset($old_options['font_h4']['size']);
        }
        if(isset($old_options['font_h4']['height'])) {
            $old_options['font_h4']['line-height'] = $old_options['font_h4']['height'];
            unset($old_options['font_h4']['height']);
        }
        if(isset($old_options['font_h4']['style'])) {
          unset($old_options['font_h4']['style']);
        }
        // H5 font
        if(isset($old_options['font_h5']['size'])) {
            $old_options['font_h5']['font-size'] = $old_options['font_h5']['size'];
            unset($old_options['font_h5']['size']);
        }
        if(isset($old_options['font_h5']['height'])) {
            $old_options['font_h5']['line-height'] = $old_options['font_h5']['height'];
            unset($old_options['font_h5']['height']);
        }
        if(isset($old_options['font_h5']['style'])) {
          unset($old_options['font_h5']['style']);
        }
        // Body font
        if(isset($old_options['font_p']['size'])) {
            $old_options['font_p']['font-size'] = $old_options['font_p']['size'];
            unset($old_options['font_p']['size']);
        }
        if(isset($old_options['font_p']['height'])) {
            $old_options['font_p']['line-height'] = $old_options['font_p']['height'];
            unset($old_options['font_p']['height']);
        }
        if(isset($old_options['font_p']['style'])) {
          unset($old_options['font_p']['style']);
        }
        if(isset($old_options['font_body'])) {
          $old_options['font_p']['font-family'] = $old_options['font_body'];
          unset($old_options['font_body']);
        }
        // Menu font
        if(isset($old_options['font_primary_menu']['size'])) {
            $old_options['font_primary_menu']['font-size'] = $old_options['font_primary_menu']['size'];
            unset($old_options['font_primary_menu']['size']);
        }
        if(isset($old_options['font_primary_menu']['height'])) {
            $old_options['font_primary_menu']['line-height'] = $old_options['font_primary_menu']['height'];
            unset($old_options['font_primary_menu']['height']);
        }
        if(isset($old_options['font_primary_menu']['style'])) { unset($old_options['font_primary_menu']['style']); }
        if(isset($old_options['font_menu'])) {
            $old_options['font_primary_menu']['font-family'] = $old_options['font_menu'];
            $old_options['font_secondary_menu']['font-family'] = $old_options['font_menu'];
             $old_options['font_mobile_menu']['font-family'] = $old_options['font_menu'];
            unset($old_options['font_menu']);
        }
        // Secondary Menu font
        if(isset($old_options['font_secondary_menu']['size'])) {
            $old_options['font_secondary_menu']['font-size'] = $old_options['font_secondary_menu']['size'];
            unset($old_options['font_secondary_menu']['size']);
        }
        if(isset($old_options['font_secondary_menu']['height'])) {
            $old_options['font_secondary_menu']['line-height'] = $old_options['font_secondary_menu']['height'];
            unset($old_options['font_secondary_menu']['height']);
        }
        if(isset($old_options['font_secondary_menu']['style'])) { unset($old_options['font_secondary_menu']['style']); }
        // Mobile Menu font
        if(isset($old_options['font_mobile_menu']['size'])) {
            $old_options['font_mobile_menu']['font-size'] = $old_options['font_mobile_menu']['size'];
            unset($old_options['font_mobile_menu']['size']);
        }
        if(isset($old_options['font_mobile_menu']['height'])) {
            $old_options['font_mobile_menu']['line-height'] = $old_options['font_mobile_menu']['height'];
            unset($old_options['font_mobile_menu']['height']);
        }
        if(isset($old_options['font_mobile_menu']['style'])) {
          $old_options['font_mobile_menu']['font-style'] = $old_options['font_mobile_menu']['style'];
          unset($old_options['font_mobile_menu']['style']);
        }
        // IMAGES 
        // Logo upload
        $site_url = get_site_url();
        if(isset($old_options['logo_upload'])) {
            $old_options['x1_virtue_logo_upload']['url'] = str_replace('[site_url]', $site_url, $old_options['logo_upload']);
            unset($old_options['logo_upload']);

        }
        if(isset($old_options['x2logo_upload'])) {
            $old_options['x2_virtue_logo_upload']['url'] = str_replace('[site_url]', $site_url, $old_options['x2logo_upload']);
            unset($old_options['x2logo_upload']);
        }
        //banner
        if(isset($old_options['banner_upload'])) {
            $old_options['virtue_banner_upload']['url'] = str_replace('[site_url]', $site_url, $old_options['banner_upload']);
            unset($old_options['banner_upload']);
        }
        //content bg
        if(isset($old_options['content_bg_img'])) {
            $old_options['bg_content_bg_img']['url'] = str_replace('[site_url]', $site_url, $old_options['content_bg_img']);
            unset($old_options['content_bg_img']);
        }
        //header bg
        if(isset($old_options['header_bg_img'])) {
            $old_options['bg_header_bg_img']['url'] = str_replace('[site_url]', $site_url, $old_options['header_bg_img']);
            unset($old_options['header_bg_img']);
        }
        //topbar bg
        if(isset($old_options['topbar_bg_img'])) {
            $old_options['bg_topbar_bg_img']['url'] = str_replace('[site_url]', $site_url, $old_options['topbar_bg_img']);
            unset($old_options['topbar_bg_img']);
        }
        //menu bg
        if(isset($old_options['menu_bg_img'])) {
            $old_options['bg_menu_bg_img']['url'] = str_replace('[site_url]', $site_url, $old_options['menu_bg_img']);
            unset($old_options['menu_bg_img']);
        }
        //mobile bg
        if(isset($old_options['mobile_bg_img'])) {
            $old_options['bg_mobile_bg_img']['url'] = str_replace('[site_url]', $site_url, $old_options['mobile_bg_img']);
            unset($old_options['mobile_bg_img']);
        }
        //footer bg
        if(isset($old_options['footer_bg_img'])) {
            $old_options['bg_footer_bg_img']['url'] = str_replace('[site_url]', $site_url, $old_options['footer_bg_img']);
            unset($old_options['footer_bg_img']);
        }
        //boxed bg
        if(isset($old_options['boxed_bg_img'])) {
            $old_options['bg_boxed_bg_img']['url'] = str_replace('[site_url]', $site_url, $old_options['boxed_bg_img']);
            unset($old_options['boxed_bg_img']);
        }
        //custom_favicon
        if(isset($old_options['custom_favicon'])) {
            $old_options['virtue_custom_favicon']['url'] = str_replace('[site_url]', $site_url, $old_options['custom_favicon']);
            unset($old_options['custom_favicon']);
        }
        // Sidebars
        if(isset($old_options['c_sidebars'])) {
            $sidebarlist = array();
            $i = 1;
            foreach ($old_options['c_sidebars'] as $sidebar) {
                if(empty($sidebar['title'])) {$sidebar['title'] = 'sidebar'.$i;}
                $sidebarlist[] = $sidebar['title'];
                $i++; 
            }
            $old_options['cust_sidebars'] = $sidebarlist;
            unset($old_options['c_sidebars']);
        }
        if(isset($old_options['backups'])) {
            unset($old_options['backups']);
        }
        $old_options['redux-backup'] = '1';

            ?>
                <textarea class="large-text noUpdate" style="min-height:200px;"><?php print_r(json_encode( $old_options)); ?></textarea>
                <?php } else {
                    echo '<textarea>'.__('There are no previous options', 'virtue').'</textarea>';
                }
                }
                ?>
</div>

<?php
$item_info = ob_get_contents();
    
ob_end_clean();

$this->sections[] = array(
    'title' => __('Main Settings', 'virtue'),
    'header' => '',
    'desc' => "<div class='redux-info-field'><h3>".__('Welcome to Virtue Theme Options', 'virtue')."</h3>
                                    <p>".__('This theme was developed by', 'virtue')." <a href=\"http://kadencethemes.com/\" target=\"_blank\">Kadence Themes</a></p>
                                    <p>".__('For theme documentation visit', 'virtue').": <a href=\"http://docs.kadencethemes.com/virtue/\" target=\"_blank\">docs.kadencethemes.com/virtue/</a>
                                    <br />
                                    ".__('For support please visit', 'virtue').": <a href=\"http://wordpress.org/support/theme/virtue\" target=\"_blank\">wordpress.org/support/theme/virtue</a></p></div>",
    'icon_class' => 'icon-large',
    'icon' => 'icon-dashboard',
    'fields' => array(
        array(
            'id'=>'boxed_layout',
            'type' => 'image_select',
            'compiler'=> false,
            'title' => __('Site Layout Style', 'virtue'), 
            'subtitle' => __('Select Boxed or Wide Site Layout Style', 'virtue'),
            'options' => array(
                    'wide' => array('alt' => 'Wide Layout', 'img' => OPTIONS_PATH.'img/1c.png'),
                    'boxed' => array('alt' => 'Boxed Layout', 'img' => OPTIONS_PATH.'img/3cm.png'),
                ),
            'default' => 'wide',
            ),
        array(
            'id'=>'footer_layout',
            'type' => 'image_select',
            'compiler' => false,
            'title' => __('Footer Widget Layout', 'virtue'), 
            'subtitle' => __('Select how many columns for footer widgets', 'virtue'),
            'options' => array(
                    'fourc' => array('alt' => 'Four Column Layout', 'img' => OPTIONS_PATH.'img/footer-widgets-4.png'),
                    'threec' => array('alt' => 'Three Column Layout', 'img' => OPTIONS_PATH.'img/footer-widgets-3.png'),
                    'twoc' => array('alt' => 'Two Column Layout', 'img' => OPTIONS_PATH.'img/footer-widgets-2.png'),
                ),
            'default' => 'fourc',
            ),
        array(
            'id'=>'logo_options',
            'type' => 'info',
            'desc' => __('Logo Options', 'virtue'),
            ),
         array(
            'id'=>'logo_layout',
            'type' => 'image_select',
            'compiler' => false,
            'title' => __('Logo Layout', 'virtue'), 
            'subtitle' => __('Choose how you want your logo to be laid out', 'virtue'),
            'options' => array(
                    'logoleft' => array('alt' => 'Logo Left Layout', 'img' => OPTIONS_PATH.'img/logo_layout_01.png'),
                    'logohalf' => array('alt' => 'Logo Half Layout', 'img' => OPTIONS_PATH.'img/logo_layout_03.png'),
                    'logocenter' => array('alt' => 'Logo Center Layout', 'img' => OPTIONS_PATH.'img/logo_layout_02.png'),
                ),
            'default' => 'logoleft',
            ),
        array(
            'id'=>'x1_virtue_logo_upload',
            'type' => 'media', 
            'url'=> true,
            'title' => __('Logo', 'virtue'),
            'compiler' => 'true',
            'subtitle' => __('Upload your Logo. If left blank theme will use site name.', 'virtue'),
            ),
        array(
            'id'=>'x2_virtue_logo_upload',
            'type' => 'media', 
            'url'=> true,
            'title' => __('Upload Your @2x Logo for Retina Screens', 'virtue'),
            'compiler' => 'true',
            'subtitle' => __('Should be twice the pixel size of your normal logo.', 'virtue'),
            ),
        array(
            'id'=>'font_logo_style',
            'type' => 'typography', 
            'title' => __('Sitename Logo Font', 'virtue'),
            //'compiler'=>true, // Use if you want to hook in your own CSS compiler
            'font-family'=>true, 
            'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            'font-backup'=>false, // Select a backup non-google font in addition to a google font
            'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
            'subsets'=>true, // Only appears if google is true and subsets not set to false
            'font-size'=>true,
            'line-height'=>true,
            'text-align' => false,
            //'word-spacing'=>false, // Defaults to false
            //'all_styles' => true,
            'color'=>true,
            'preview'=>true, // Disable the previewer
            'output' => array('header #logo a.brand', ".logofont"),
            'subtitle'=> __("Choose size and style your sitename, if you don't use an image logo.", 'virtue'),
            'default'=> array(
                'font-family'=>'Pacifico',
                'color'=>"", 
                'font-style'=>'400',
                'font-size'=>'32px', 
                'line-height'=>'40px', ),
            ),
        array(
            'id'=>'logo_below_text',
            'type' => 'textarea',
            'title' => __('Site Tagline - Below Logo"', 'virtue'), 
            'subtitle' => __('An optional line of text below your logo', 'virtue'),
            //'desc' => __('This is the description field, again good for additional info.', 'virtue'),
            'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
            'default' => '',
            ),
        array(
            'id'=>'font_tagline_style',
            'type' => 'typography', 
            'title' => __('Site Tagline Font', 'virtue'),
            //'compiler'=>true, // Use if you want to hook in your own CSS compiler
            'font-family'=>true, 
            'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            'font-backup'=>false, // Select a backup non-google font in addition to a google font
            'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
            'subsets'=>true, // Only appears if google is true and subsets not set to false
            'font-size'=>true,
            'line-height'=>true,
            'text-align' => false,
            'color'=>true,
            'preview'=>true,
            'output' => array('.kad_tagline'), // An array of CSS selectors to apply this font style to dynamically
            'subtitle'=> __("Choose size and style your site tagline", 'virtue'),
            'default'=> array(
                'font-family'=>'Lato',
                'color'=>"#444444", 
                'font-style'=>'400',
                'font-size'=>'14px', 
                'line-height'=>'20px', ),
            ),
        array(
            'id'=>'logo_padding_top',
            'type' => 'slider', 
            'title' => __('Logo Spacing', 'virtue'),
            'desc'=> __('Top Spacing', 'virtue'),
            "default"       => "25",
            "min"       => "0",
            "step"      => "1",
            "max"       => "80",
            ), 
        array(
            'id'=>'logo_padding_bottom',
            'type' => 'slider', 
            'title' => __('Logo Spacing', 'virtue'),
            'desc'=> __('Bottom Spacing', 'virtue'),
            "default"       => "10",
            "min"       => "0",
            "step"      => "1",
            "max"       => "80",
            ),
            array(
            'id'=>'logo_padding_left',
            'type' => 'slider', 
            'title' => __('Logo Spacing', 'virtue'),
            'desc'=> __('Left Spacing', 'virtue'),
            "default"       => "0",
            "min"       => "0",
            "step"      => "1",
            "max"       => "80",
            ), 
            array(
            'id'=>'logo_padding_right',
            'type' => 'slider', 
            'title' => __('Logo Spacing', 'virtue'),
            'desc'=> __('Right Spacing', 'virtue'),
            "default"       => "0",
            "min"       => "0",
            "step"      => "1",
            "max"       => "80",
            ),
        array(
            'id'=>'menu_margin_top',
            'type' => 'slider', 
            'title' => __('Primary Menu Spacing', 'virtue'),
            'desc'=> __('Top Spacing', 'virtue'),
            "default"       => "40",
            "min"       => "0",
            "step"      => "1",
            "max"       => "80",
            ), 
         array(
            'id'=>'menu_margin_bottom',
            'type' => 'slider', 
            'title' => __('Primary Menu Spacing', 'virtue'),
            'desc'=> __('Bottom Spacing', 'virtue'),
            "default"       => "10",
            "min"       => "0",
            "step"      => "1",
            "max"       => "80",
            ), 
         array(
            'id'=>'virtue_banner_upload',
            'type' => 'media', 
            'url'=> true,
            'title' => __('Sitewide Banner', 'virtue'),
            'compiler' => 'true',
            'subtitle' => __('Upload a banner for bottom of header.', 'virtue'),
            ),
         ),
);
$this->sections[] = array(
    'icon' => 'icon-cogs',
    'icon_class' => 'icon-large',
    'title' => __('Topbar Settings', 'virtue'),
    'fields' => array(
        array(
            'id'=>'topbar',
            'type' => 'switch', 
            'title' => __('Use Topbar?', 'virtue'),
            'subtitle'=> __('Choose to show or hide topbar', 'virtue'),
            "default"       => 1,
            ), 
        array(
            'id'=>'topbar_icons',
            'type' => 'switch', 
            'title' => __('Use Topbar Icon Menu?', 'virtue'),
            'subtitle'=> __('Choose to show or hide topbar icon Menu', 'virtue'),
            "default"       => 0,
            ),
        array(
            'id'=>'topbar_icon_menu',
            'type' => 'kad_icons',
            'title' => __('Topbar Icon Menu', 'virtue'),
            'subtitle'=> __('Choose your icons for the topbar icon menu.', 'virtue'),
            //'desc' => __('This field will store all slides values into a multidimensional array to use into a foreach loop.', 'virtue')
        ), 
        array(
            'id'=>'show_cartcount',
            'type' => 'switch', 
            'title' => __('Show Cart total in topbar?', 'virtue'),
            'subtitle'=> __('This only works if using woocommerce', 'virtue'),
            "default"       => 1,
            ), 
        array(
            'id'=>'topbar_search',
            'type' => 'switch', 
            'title' => __('Display Search in Topbar?', 'virtue'),
            'subtitle'=> __('Choose to show or hide search in topbar', 'virtue'),
            "default"       => 1,
            ),
        array(
            'id'=>'topbar_widget',
            'type' => 'switch', 
            'title' => __('Enable widget area in right of Topbar?', 'virtue'),
            'subtitle'=> __('Note this will hide remove search (you can re-enable it my adding it to the widget area)', 'virtue'),
            "default"       => 0,
            ),
        array(
            'id'=>'topbar_layout',
            'type' => 'switch', 
            'title' => __('Topbar Layout Switch', 'virtue'),
            'subtitle'=> __('This moves the left items to the right and right items to the left.', 'virtue'),
            "default"       => 0,
            ),
        ),
);
$this->sections[] = array(
    'icon' => 'icon-picture',
    'icon_class' => 'icon-large',
    'title' => __('Slider Settings', 'virtue'),
    'desc' => "<div class='redux-info-field'><h3>".__('Home Page Slider Options', 'virtue')."</h3></div>",
    'fields' => array(
        array(
            'id'=>'choose_slider',
            'type' => 'select',
            'title' => __('Choose a Home Image Slider', 'virtue'), 
            'subtitle' => __("If you don't want an image slider on your home page choose none.", 'virtue'),
            //'desc' => __('This is the description field, again good for additional info.', 'virtue'),
            'options' => array('none' => 'None','flex' => 'Flex Slider','thumbs' => 'Thumb Slider', 'carousel' => 'Carousel Slider','latest' => 'Latest Posts', 'video' => 'Video'),
            'default' => '',
            'width' => 'width:60%',
            ),
        array(
            'id'=>'home_slider',
            'type' => 'kad_slides',
            'title' => __('Slider Images', 'virtue'),
            'subtitle'=> __('Use large images for best results.', 'virtue'),
            //'desc' => __('This field will store all slides values into a multidimensional array to use into a foreach loop.', 'virtue')
        ),  
        array(
            'id'=>'slider_size',
            'type' => 'slider', 
            'title' => __('Slider Max Height', 'virtue'),
            'desc'=> __('Note: does not work if images are smaller than max.', 'virtue'),
            "default"       => "400",
            "min"       => "100",
            "step"      => "5",
            "max"       => "600",
            ), 
        array(
            'id'=>'slider_size_width',
            'type' => 'slider', 
            'title' => __('Slider Max Width', 'virtue'),
            'desc'=> __('Note: does not work if images are smaller than max.', 'virtue'),
            "default"       => "1170",
            "min"       => "600",
            "step"      => "5",
            "max"       => "1170",
            ), 
        array(
            'id'=>'slider_autoplay',
            'type' => 'switch', 
            'title' => __('Auto Play?', 'virtue'),
            'subtitle'=> __('This determines if a slider automatically scrolls', 'virtue'),
            "default"       => 1,
            ),
        array(
            'id'=>'slider_pausetime',
            'type' => 'slider', 
            'title' => __('Slider Pause Time', 'virtue'),
            'desc'=> __('How long to pause on each slide, in milliseconds.', 'virtue'),
            "default"       => "7000",
            "min"       => "3000",
            "step"      => "1000",
            "max"       => "12000",
            ), 
        array(
            'id'=>'trans_type',
            'type' => 'select',
            'title' => __('Transition Type', 'virtue'), 
            'subtitle' => __("Choose a transition type", 'virtue'),
            'options' => array('fade' => 'Fade','slide' => 'Slide'),
            'default' => 'fade'
            ),
        array(
            'id'=>'slider_transtime',
            'type' => 'slider', 
            'title' => __('Slider Transition Time', 'virtue'),
            'desc'=> __('How long for slide transitions, in milliseconds.', 'virtue'),
            "default"       => "600",
            "min"       => "200",
            "step"      => "100",
            "max"       => "1200",
            ), 
        array(
            'id'=>'slider_captions',
            'type' => 'switch', 
            'title' => __('Show Captions?', 'virtue'),
            'subtitle'=> __('Choose to show or hide captions', 'virtue'),
            "default"       => 0,
            ),
        array(
            'id'=>'video_embed',
            'type' => 'textarea',
            'title' => __('Video Embed Code', 'virtue'), 
            'subtitle' => __('If your using a video on the home page place video embed code here.', 'virtue'),
            'default' => ''
            ),
         ),
);

$this->sections[] = array(
    'icon' => 'icon-tablet',
    'icon_class' => 'icon-large',
    'title' => __('Mobile Slider', 'virtue'),
    'desc' => "<div class='redux-info-field'><h3>".__('Create a more lightweight home slider for your mobile visitors.', 'virtue')."</h3></div>",
    'fields' => array(
    	array(
            'id'=>'mobile_switch',
            'type' => 'switch', 
            'title' => __('Would you like to use this feature?', 'virtue'),
            'subtitle'=> __('Choose if you would like to show a different slider on your home page for your mobile visitors.', 'virtue'),
            "default"       => 0,
            ),
        array(
            'id'=>'choose_mobile_slider',
            'type' => 'select',
            'title' => __('Choose a Slider for Mobile', 'virtue'), 
            'subtitle' => __("Choose which slider you would like to show for mobile viewers.", 'virtue'),
            //'desc' => __('This is the description field, again good for additional info.', 'virtue'),
            'options' => array('none' => 'None','flex' => 'Flex Slider', 'video' => 'Video'),
            'default' => 'none',
            'width' => 'width:60%',
            'required' => array('mobile_switch','=','1'),
            ),
        array(
            'id'=>'home_mobile_slider',
            'type' => 'kad_slides',
            'title' => __('Slider Images', 'virtue'),
            'subtitle'=> __('Use large images for best results.', 'virtue'),
            'required' => array('mobile_switch','=','1'),
            //'desc' => __('This field will store all slides values into a multidimensional array to use into a foreach loop.', 'virtue')
        ),  
        array(
            'id'=>'mobile_slider_size',
            'type' => 'slider', 
            'title' => __('Slider Max Height', 'virtue'),
            'desc'=> __('Note: does not work if images are smaller than max.', 'virtue'),
            "default"       => "300",
            "min"       => "100",
            "step"      => "5",
            "max"       => "800",
            'required' => array('mobile_switch','=','1'),
            ), 
        array(
            'id'=>'mobile_slider_size_width',
            'type' => 'slider', 
            'title' => __('Slider Max Width', 'virtue'),
            'desc'=> __('Note: does not work if images are smaller than max.', 'virtue'),
            "default"       => "480",
            "min"       => "200",
            "step"      => "5",
            "max"       => "800",
            'required' => array('mobile_switch','=','1'),
            ), 
        array(
            'id'=>'mobile_slider_autoplay',
            'type' => 'switch', 
            'title' => __('Auto Play?', 'virtue'),
            'subtitle'=> __('This determines if a slider automatically scrolls', 'virtue'),
            "default"       => 1,
            'required' => array('mobile_switch','=','1'),
            ),
        array(
            'id'=>'mobile_slider_pausetime',
            'type' => 'slider', 
            'title' => __('Slider Pause Time', 'virtue'),
            'desc'=> __('How long to pause on each slide, in milliseconds.', 'virtue'),
            "default"       => "7000",
            "min"       => "3000",
            "step"      => "1000",
            "max"       => "12000",
            'required' => array('mobile_switch','=','1'),
            ), 
        array(
            'id'=>'mobile_trans_type',
            'type' => 'select',
            'title' => __('Transition Type', 'virtue'), 
            'subtitle' => __("Choose a transition type", 'virtue'),
            'options' => array('fade' => 'Fade','slide' => 'Slide'),
            'default' => 'fade',
            'required' => array('mobile_switch','=','1'),
            ),
        array(
            'id'=>'mobile_slider_transtime',
            'type' => 'slider', 
            'title' => __('Slider Transition Time', 'virtue'),
            'desc'=> __('How long for slide transitions, in milliseconds.', 'virtue'),
            "default"       => "600",
            "min"       => "200",
            "step"      => "100",
            "max"       => "1200",
            'required' => array('mobile_switch','=','1'),
            ), 
        array(
            'id'=>'mobile_slider_captions',
            'type' => 'switch', 
            'title' => __('Show Captions?', 'virtue'),
            'subtitle'=> __('Choose to show or hide captions', 'virtue'),
            "default"       => 0,
            'required' => array('mobile_switch','=','1'),
            ),
        array(
            'id'=>'mobile_video_embed',
            'type' => 'textarea',
            'title' => __('Video Embed Code', 'virtue'), 
            'subtitle' => __('If your using a video on the home page place video embed code here.', 'virtue'),
            'default' => '',
            'required' => array('mobile_switch','=','1'),
            ),
         ),
);
$this->sections[] = array(
    'icon' => 'icon-home',
    'icon_class' => 'icon-large',
    'title' => __('Home Layout', 'virtue'),
    'desc' => "",
    'fields' => array(
    	 array(
            'id'=>'home_sidebar_layout',
            'type' => 'image_select',
            'compiler'=> false,
            'title' => __('Display a sidebar on the Home Page?', 'virtue'), 
            'subtitle' => __('This determines if there is a sidebar on the home page.', 'virtue'),
            'options' => array(
                    'full' => array('alt' => 'Full Layout', 'img' => OPTIONS_PATH.'img/1col.png'),
                    'sidebar' => array('alt' => 'Sidebar Layout', 'img' => OPTIONS_PATH.'img/2cr.png'),
                ),
            'default' => 'full',
            ),
    	 array(
            'id'=>'home_sidebar',
            'type' => 'select',
            'title' => __('Choose a Sidebar for your Home Page', 'virtue'), 
            //'subtitle' => __("Choose your Revolution Slider Here", 'virtue'),
            //'desc' => __('This is the description field, again good for additional info.', 'virtue'),
            'data' => 'sidebars',
            'default' => 'sidebar-primary',
            'width' => 'width:60%',
            ),
    	 array(
            "id" => "homepage_layout",
            "type" => "sorter",
            "title" => __('Homepage Layout Manager', 'virtue'),
            "subtitle" => __('Organize how you want the layout to appear on the homepage', 'virtue'),
            //"compiler"=>'true',    
            'options' => array(
            	"disabled" => array(
                    "placebo" => "placebo", //REQUIRED!
                    "block_five"  => __("Latest Blog Posts", 'virtue'),
                    "block_six"   => __("Portfolio Carousel", 'virtue'),
                    "block_seven" => __("Icon Menu", 'virtue'),
                ),
                "enabled" => array(
                    "placebo" => "placebo", //REQUIRED!
                    "block_one"   => __("Page Title", 'virtue'),
                    "block_four"  => __("Page Content", 'virtue'),
                ),
            ),
        ),

         array(
            'id'=>'info_blog_settings',
            'type' => 'info',
            'desc' => __('Home Blog Settings', 'virtue'),
            ),
         array(
            'id'=>'blog_title',
            'type' => 'text',
            'title' => __('Home Blog Title', 'virtue'),
            'subtitle' => __('ex: Latest from the blog', 'virtue'),
            ),
         array(
            'id'=>'home_post_count',
            'type' => 'slider', 
            'title' => __('Choose How many posts on Homepage', 'virtue'),
            //'desc'=> __('Note: does not work if images are smaller than max.', 'virtue'),
            "default"       => "4",
            "min"       => "2",
            "step"      => "2",
            "max"       => "8",
            ),
         array(
            'id'=>'home_post_type',
            'type' => 'select',
            'data' => 'categories',
            'title' => __('Limit posts to a Category', 'virtue'), 
            'subtitle' => __('Leave blank to select all', 'virtue'),
            'width' => 'width:60%',
            //'desc' => __('This is the description field, again good for additional info.', 'virtue'),
            ),
         array(
            'id'=>'info_portfolio_settings',
            'type' => 'info',
            'desc' => __('Home Portfolio Carousel Settings', 'virtue'),
            ),
         array(
            'id'=>'portfolio_title',
            'type' => 'text',
            'title' => __('Home Portfolio Carousel title', 'virtue'),
            'subtitle' => __('ex: Portfolio Carousel title', 'virtue'),
            ),
         array(
            'id'=>'portfolio_type',
            'type' => 'select',
            'data' => 'terms',
            'args' => array('taxonomies'=>'portfolio-type', 'args'=>array()),
            'title' => __('Portfolio Carousel Category Type', 'virtue'), 
            'subtitle' => __('Leave blank to select all types', 'virtue'),
            'width' => 'width:60%',
            //'desc' => __('This is the description field, again good for additional info.', 'virtue'),
            ),
         array(
            'id'=>'home_portfolio_carousel_count',
            'type' => 'slider', 
            'title' => __('Choose how many portfolio items are in carousel', 'virtue'),
            "default"       => "6",
            "min"       => "4",
            "step"      => "1",
            "max"       => "12",
            ),
         array(
            'id'=>'home_portfolio_order',
            'type' => 'select',
            'title' => __('Portfolio Carousel Order by', 'virtue'), 
            'subtitle' => __("Choose how the portfolio items should be ordered in the carousel.", 'virtue'),
            'options' => array('menu_order' => 'Menu Order','title' => 'Title','date' => 'Date','rand' => 'Random'),
            'default' => 'menu_order',
            'width' => 'width:60%',
            ),
         array(
            'id'=>'portfolio_show_type',
            'type' => 'switch', 
            'title' => __('Display Portfolio Types under Title', 'virtue'),
            "default"       => 0,
            ),
           array(
            'id'=>'info_iconmenu_settings',
            'type' => 'info',
            'desc' => __('Home Icon Menu', 'virtue'),
            ),
           array(
            'id'=>'icon_menu',
            'type' => 'kad_icons',
            'title' => __('Icon Menu', 'virtue'),
            'subtitle'=> __('Choose your icons for the icon menu.', 'virtue'),
            //'desc' => __('This field will store all slides values into a multidimensional array to use into a foreach loop.', 'virtue')
        ), 
           array(
            'id'=>'home_icon_menu_column',
            'type' => 'slider', 
            'title' => __('Choose how many columns in each row', 'virtue'),
            "default"       => "3",
            "min"       => "2",
            "step"      => "1",
            "max"       => "6",
            ),
           array(
            'id'=>'info_page_content',
            'type' => 'info',
            'desc' => __('Page Content Options', 'virtue'),
            ),
           array(
            'id'=>'home_post_summery',
            'type' => 'select',
            'title' => __('Latest Post Display', 'virtue'), 
            'subtitle' => __("If Latest Post page is font page. Choose to show full post or post excerpt.", 'virtue'),
            //'desc' => __('This is the description field, again good for additional info.', 'virtue'),
            'options' => array('summery' => 'Post Excerpt','full' => 'Full'),
            'default' => 'summery',
            'width' => 'width:60%',
            ),

    ),
);
$this->sections[] = array(
    'icon' => 'icon-shopping-cart',
    'icon_class' => 'icon-large',
    'title' => __('Shop Settings', 'virtue'),
    'desc' => "<div class='redux-info-field'><h3>".__('Shop Archive Page Settings', 'virtue')."</h3></div>",
    'fields' => array(
    	array(
            'id'=>'shop_layout',
            'type' => 'image_select',
            'compiler'=> false,
            'title' => __('Display the sidebar on shop archives?', 'virtue'), 
            'subtitle' => __('This determines if there is a sidebar on the shop and category pages.', 'virtue'),
            'options' => array(
                    'full' => array('alt' => 'Full Layout', 'img' => OPTIONS_PATH.'img/1col.png'),
                    'sidebar' => array('alt' => 'Sidebar Layout', 'img' => OPTIONS_PATH.'img/2cr.png'),
                ),
            'default' => 'full',
            ),
    	array(
            'id'=>'shop_sidebar',
            'type' => 'select',
            'title' => __('Choose a Sidebar for your shop page', 'virtue'), 
            'data' => 'sidebars',
            'default' => 'sidebar-primary',
            'width' => 'width:60%',
            ),            
    	array(
            'id'=>'products_per_page',
            'type' => 'slider', 
            'title' => __('How many products per page', 'virtue'),
            "default"       => "12",
            "min"       => "2",
            "step"      => "1",
            "max"       => "40",
            ),

    	array(
            'id'=>'shop_rating',
            'type' => 'switch', 
            'title' => __('Show Ratings in Shop and Category Pages', 'virtue'),
            'subtitle' => __('This determines if the rating is displayed in the product archive pages', 'virtue'),
            "default"=> 1,
            ),
        array(
            'id'=>'info_shop_product_title',
            'type' => 'info',
            'desc' => __('Shop Product Title Settings', 'virtue'),
            ),
        array(
            'id'=>'font_shop_title',
            'type' => 'typography', 
            'title' => __('Shop & archive Product title Font', 'virtue'),
            //'compiler'=>true, // Use if you want to hook in your own CSS compiler
            'font-family'=>true, 
            'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            'font-backup'=>false, // Select a backup non-google font in addition to a google font
            'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
            'subsets'=>true, // Only appears if google is true and subsets not set to false
            'font-size'=>true,
            'line-height'=>true,
            'text-align' => false,
            //'word-spacing'=>false, // Defaults to false
            //'all_styles' => true,
            'color'=>true,
            'preview'=>true, // Disable the previewer
            'output' => array('.product_item .product_details h5'),
            'subtitle'=> __("Choose Size and Style for product titles on category and archive pages.", 'virtue'),
            'default'=> array(
                'font-family'=>'Lato',
                'color'=>"", 
                'font-style'=>'700',
                'font-size'=>'16px', 
                'line-height'=>'20px', ),
            ),
        array(
            'id'=>'shop_title_uppercase',
            'type' => 'switch', 
            'title' => __('Set Product Title to Uppercase?', 'virtue'),
            'subtitle' => __('This makes your product titles uppercase on Category pages', 'virtue'),
            "default"=> 0,
            ),
        array(
            'id'=>'shop_title_min_height',
            'type' => 'slider', 
            'title' => __('Product title Min Height', 'virtue'),
            'desc'=> __('If your titles are long increase this to help align your products height.', 'virtue'),
            "default"       => "40",
            "min"       => "20",
            "step"      => "5",
            "max"       => "120",
            ), 
         array(
            'id'=>'info_shop_img_size',
            'type' => 'info',
            'desc' => __('Product Image Sizes', 'virtue'),
            ),
    	array(
            'id'=>'product_img_resize',
            'type' => 'switch', 
            'title' => __('Enable Product Image Crop on Catalog pages', 'virtue'),
            'subtitle' => __('If turned off image dimensions are set by woocommerce settings - recommended width: 270px for Catalog Images', 'virtue'),
            "default"=> 1,
            ),
    	array(
            'id'=>'product_simg_resize',
            'type' => 'switch', 
            'title' => __('Enable Product Image Crop on product Page', 'virtue'),
            'subtitle' => __('If turned off image dimensions are set by woocommerce settings - recommended width: 468px for Single Product Image', 'virtue'),
            "default"=> 1,
            ),
        array(
            'id'=>'info_product_settings',
            'type' => 'info',
            'desc' => __('Product Page Settings', 'virtue'),
            ),
        array(
            'id'=>'product_tabs',
            'type' => 'switch', 
            'title' => __('Display product tabs?', 'virtue'),
            'subtitle'=> __('This determines if product tabs are displayed', 'virtue'),
            "default"       => 1,
            ),
        array(
            'id'=>'related_products',
            'type' => 'switch', 
            'title' => __('Display related products?', 'virtue'),
            'subtitle'=> __('This determines related products are displayed', 'virtue'),
            "default"       => 1,
            ),
    ),
);
$this->sections[] = array(
    'icon' => 'icon-pencil',
    'icon_class' => 'icon-large',
    'title' => __('Basic Styling', 'virtue'),
    'desc' => "<div class='redux-info-field'><h3>".__('Basic Stylng', 'virtue')."</h3></div>",
    'fields' => array(
    	  array(
            'id'=>'skin_stylesheet',
            'type' => 'select',
            'title' => __('Theme Skin Stylesheet', 'virtue'), 
            'subtitle' => __("Note* changes made in options panel will override this stylesheet. Example: Colors set in typography.", 'virtue'),
            //'desc' => __('This is the description field, again good for additional info.', 'virtue'),
            'options' => $alt_stylesheets,
            'default' => 'default.css',
            'width' => 'width:60%',
            ),
    	  array(
            'id'=>'primary_color',
            'type' => 'color',
            'title' => __('Primary Color', 'virtue'), 
            'subtitle' => __('Choose the default Highlight color for your site.', 'virtue'),
            'default' => '',
            'transparent'=>false,
            'validate' => 'color',
            ),
    	  array(
            'id'=>'primary20_color',
            'type' => 'color',
            'title' => __('20% lighter than Primary Color', 'virtue'), 
            'subtitle' => __('This is used for hover effects', 'virtue'),
            'default' => '',
            'transparent'=>false,
            'validate' => 'color',
            ),
    	  array(
            'id'=>'gray_font_color',
            'type' => 'color',
            'title' => __('Sitewide Gray Fonts', 'virtue'), 
            //'subtitle' => __('This is used for hover effects', 'virtue'),
            'default' => '',
            'transparent'=>false,
            'validate' => 'color',
            ),
    	  array(
            'id'=>'footerfont_color',
            'type' => 'color',
            'title' => __('Footer Font Color', 'virtue'), 
            //'subtitle' => __('This is used for hover effects', 'virtue'),
            'default' => '',
            'transparent'=>false,
            'validate' => 'color',
            ),
      ),
);
$this->sections[] = array(
    'icon' => 'icon-edit',
    'icon_class' => 'icon-large',
    'title' => __('Advanced Styling', 'virtue'),
    'desc' => "<div class='redux-info-field'><h3>".__('Main Content Background', 'virtue')."</h3></div>",
    'fields' => array(
    	array(
            'id'=>'content_bg_color',
            'type' => 'color',
            'title' => __('Background Color', 'virtue'), 
            'default' => '',
            'validate' => 'color',
            ),
    	array(
            'id'=>'bg_content_bg_img',
            'type' => 'media', 
            'url'=> true,
            'title' => __('Upload background image or texture', 'virtue'),
            ), 
    	array(
            'id'=>'content_bg_repeat',
            'type' => 'select',
            'title' => __('Image repeat options', 'virtue'), 
            'options' => array('no-repeat' => 'no-repeat', 'repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y'),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'content_bg_placementx',
            'type' => 'select',
            'title' => __('X image placement options', 'virtue'), 
            'options' => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'content_bg_placementy',
            'type' => 'select',
            'title' => __('Y image placement options', 'virtue'), 
            'options' => array('top' => 'top', 'center' => 'center', 'bottom' => 'bottom',),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'info_topbar_background',
            'type' => 'info',
            'desc' => __('Topbar Background', 'virtue'),
            ),
    	array(
            'id'=>'topbar_bg_color',
            'type' => 'color',
            'title' => __('Background Color', 'virtue'), 
            'default' => '',
            'validate' => 'color',
            ),
    	array(
            'id'=>'bg_topbar_bg_img',
            'type' => 'media', 
            'url'=> true,
            'title' => __('Upload background image or texture', 'virtue'),
            ), 
    	array(
            'id'=>'topbar_bg_repeat',
            'type' => 'select',
            'title' => __('Image repeat options', 'virtue'), 
            'options' => array('no-repeat' => 'no-repeat', 'repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y'),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'topbar_bg_placementx',
            'type' => 'select',
            'title' => __('X image placement options', 'virtue'), 
            'options' => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'topbar_bg_placementy',
            'type' => 'select',
            'title' => __('Y image placement options', 'virtue'), 
            'options' => array('top' => 'top', 'center' => 'center', 'bottom' => 'bottom',),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'info_header_background',
            'type' => 'info',
            'desc' => __('Header Background', 'virtue'),
            ),
    	array(
            'id'=>'header_bg_color',
            'type' => 'color',
            'title' => __('Background Color', 'virtue'), 
            'default' => '',
            'validate' => 'color',
            ),
    	array(
            'id'=>'bg_header_bg_img',
            'type' => 'media', 
            'url'=> true,
            'title' => __('Upload background image or texture', 'virtue'),
            ), 
    	array(
            'id'=>'header_bg_repeat',
            'type' => 'select',
            'title' => __('Image repeat options', 'virtue'), 
            'options' => array('no-repeat' => 'no-repeat', 'repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y'),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'header_bg_placementx',
            'type' => 'select',
            'title' => __('X image placement options', 'virtue'), 
            'options' => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'header_bg_placementy',
            'type' => 'select',
            'title' => __('Y image placement options', 'virtue'), 
            'options' => array('top' => 'top', 'center' => 'center', 'bottom' => 'bottom',),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'info_menu_background',
            'type' => 'info',
            'desc' => __('Secondary Menu Background', 'virtue'),
            ),
    	array(
            'id'=>'menu_bg_color',
            'type' => 'color',
            'title' => __('Background Color', 'virtue'), 
            'default' => '',
            'validate' => 'color',
            ),
    	array(
            'id'=>'bg_menu_bg_img',
            'type' => 'media', 
            'url'=> true,
            'title' => __('Upload background image or texture', 'virtue'),
            ), 
    	array(
            'id'=>'menu_bg_repeat',
            'type' => 'select',
            'title' => __('Image repeat options', 'virtue'), 
            'options' => array('no-repeat' => 'no-repeat', 'repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y'),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'menu_bg_placementx',
            'type' => 'select',
            'title' => __('X image placement options', 'virtue'), 
            'options' => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'menu_bg_placementy',
            'type' => 'select',
            'title' => __('Y image placement options', 'virtue'), 
            'options' => array('top' => 'top', 'center' => 'center', 'bottom' => 'bottom',),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'info_mobile_background',
            'type' => 'info',
            'desc' => __('Mobile Menu Background', 'virtue'),
            ),
    	array(
            'id'=>'mobile_bg_color',
            'type' => 'color',
            'title' => __('Background Color', 'virtue'), 
            'default' => '',
            'validate' => 'color',
            ),
    	array(
            'id'=>'bg_mobile_bg_img',
            'type' => 'media', 
            'url'=> true,
            'title' => __('Upload background image or texture', 'virtue'),
            ), 
    	array(
            'id'=>'mobile_bg_repeat',
            'type' => 'select',
            'title' => __('Image repeat options', 'virtue'), 
            'options' => array('no-repeat' => 'no-repeat', 'repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y'),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'mobile_bg_placementx',
            'type' => 'select',
            'title' => __('X image placement options', 'virtue'), 
            'options' => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'mobile_bg_placementy',
            'type' => 'select',
            'title' => __('Y image placement options', 'virtue'), 
            'options' => array('top' => 'top', 'center' => 'center', 'bottom' => 'bottom',),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'info_footer_background',
            'type' => 'info',
            'desc' => __('Footer Background', 'virtue'),
            ),
    	array(
            'id'=>'footer_bg_color',
            'type' => 'color',
            'title' => __('Background Color', 'virtue'), 
            'default' => '',
            'validate' => 'color',
            ),
    	array(
            'id'=>'bg_footer_bg_img',
            'type' => 'media', 
            'url'=> true,
            'title' => __('Upload background image or texture', 'virtue'),
            ), 
    	array(
            'id'=>'footer_bg_repeat',
            'type' => 'select',
            'title' => __('Image repeat options', 'virtue'), 
            'options' => array('no-repeat' => 'no-repeat', 'repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y'),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'footer_bg_placementx',
            'type' => 'select',
            'title' => __('X image placement options', 'virtue'), 
            'options' => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'footer_bg_placementy',
            'type' => 'select',
            'title' => __('Y image placement options', 'virtue'), 
            'options' => array('top' => 'top', 'center' => 'center', 'bottom' => 'bottom',),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'info_body_background',
            'type' => 'info',
            'desc' => __('Body Background', 'virtue'),
            ),
    	array(
            'id'=>'boxed_bg_color',
            'type' => 'color',
            'title' => __('Background Color', 'virtue'), 
            'default' => '',
            'validate' => 'color',
            ),
    	array(
            'id'=>'bg_boxed_bg_img',
            'type' => 'media', 
            'url'=> true,
            'title' => __('Upload background image or texture', 'virtue'),
            ), 
    	array(
            'id'=>'boxed_bg_repeat',
            'type' => 'select',
            'title' => __('Image repeat options', 'virtue'), 
            'options' => array('no-repeat' => 'no-repeat', 'repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y'),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'boxed_bg_placementx',
            'type' => 'select',
            'title' => __('X image placement options', 'virtue'), 
            'options' => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'boxed_bg_placementy',
            'type' => 'select',
            'title' => __('Y image placement options', 'virtue'), 
            'options' => array('top' => 'top', 'center' => 'center', 'bottom' => 'bottom',),
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'boxed_bg_fixed',
            'type' => 'select',
            'title' => __('Fixed or Scroll', 'virtue'), 
            'options' => array('fixed' => 'Fixed', 'scroll'=>'Scroll'),
            'width' => 'width:60%',
            ),
    ),
);
$this->sections[] = array(
    'icon' => 'icon-text-width',
    'icon_class' => 'icon-large',
    'title' => __('Typography', 'virtue'),
    'desc' => "<div class='redux-info-field'><h3>".__('Header Font Options', 'virtue')."</h3></div>",
    'fields' => array(
    	array(
            'id'=>'font_h1',
            'type' => 'typography', 
            'title' => __('H1 Headings', 'virtue'),
            //'compiler'=>true, // Use if you want to hook in your own CSS compiler
            'font-family'=>true, 
            'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            'font-backup'=>false, // Select a backup non-google font in addition to a google font
            'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
            'subsets'=>true, // Only appears if google is true and subsets not set to false
            'font-size'=>true,
            'line-height'=>true,
            'text-align' => false,
            //'word-spacing'=>false, // Defaults to false
            //'all_styles' => true,
            'color'=>true,
            'preview'=>true, // Disable the previewer
            'output' => array('h1'),
            'subtitle'=> __("Choose Size and Style for h1 (This Styles Your Page Titles)", 'virtue'),
            'default'=> array(
                'font-family'=>'Lato',
                'color'=>"", 
                'font-style'=>'400',
                'font-size'=>'38px', 
                'line-height'=>'40px', ),
            ),
		array(
            'id'=>'font_h2',
            'type' => 'typography', 
            'title' => __('H2 Headings', 'virtue'),
            //'compiler'=>true, // Use if you want to hook in your own CSS compiler
              'font-family'=>true, 
            'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            'font-backup'=>false, // Select a backup non-google font in addition to a google font
            'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
            'subsets'=>true, // Only appears if google is true and subsets not set to false
            'font-size'=>true,
            'line-height'=>true,
            'text-align' => false,
            //'word-spacing'=>false, // Defaults to false
            //'all_styles' => true,
            'color'=>true,
            'preview'=>true, // Disable the previewer
            'output' => array('h2'),
            'subtitle'=> __("Choose Size and Style for h2", 'virtue'),
            'default'=> array(
                'font-family'=>'Lato',
                'color'=>"", 
                'font-style'=>'normal',
                'font-size'=>'32px', 
                'line-height'=>'40px', ),
            ),
		array(
            'id'=>'font_h3',
            'type' => 'typography', 
            'title' => __('H3 Headings', 'virtue'),
            //'compiler'=>true, // Use if you want to hook in your own CSS compiler
            'font-family'=>true, 
            'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            'font-backup'=>false, // Select a backup non-google font in addition to a google font
            'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
            'subsets'=>true, // Only appears if google is true and subsets not set to false
            'font-size'=>true,
            'line-height'=>true,
            'text-align' => false,
            //'word-spacing'=>false, // Defaults to false
            //'all_styles' => true,
            'color'=>true,
            'preview'=>true, // Disable the previewer
            'output' => array('h3'),
            'subtitle'=> __("Choose Size and Style for h3", 'virtue'),
            'default'=> array(
                'font-family'=>'Lato',
                'color'=>"", 
                'font-style'=>'400',
                'font-size'=>'28px', 
                'line-height'=>'40px', ),
            ),
		array(
            'id'=>'font_h4',
            'type' => 'typography', 
            'title' => __('H4 Headings', 'virtue'),
            //'compiler'=>true, // Use if you want to hook in your own CSS compiler
            'font-family'=>true, 
            'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            'font-backup'=>false, // Select a backup non-google font in addition to a google font
            'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
            'subsets'=>true, // Only appears if google is true and subsets not set to false
            'font-size'=>true,
            'line-height'=>true,
            'text-align' => false,
            //'word-spacing'=>false, // Defaults to false
            //'all_styles' => true,
            'color'=>true,
            'preview'=>true, // Disable the previewer
            'output' => array('h4'),
            'subtitle'=> __("Choose Size and Style for h4", 'virtue'),
            'default'=> array(
                'font-family'=>'Lato',
                'color'=>"", 
                'font-style'=>'400',
                'font-size'=>'24px', 
                'line-height'=>'40px', ),
            ),
		array(
            'id'=>'font_h5',
            'type' => 'typography', 
            'title' => __('H5 Headings', 'virtue'),
            //'compiler'=>true, // Use if you want to hook in your own CSS compiler
            'font-family'=>true, 
            'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            'font-backup'=>false, // Select a backup non-google font in addition to a google font
            'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
            'subsets'=>true, // Only appears if google is true and subsets not set to false
            'font-size'=>true,
            'line-height'=>true,
            'text-align' => false,
            //'word-spacing'=>false, // Defaults to false
            //'all_styles' => true,
            'color'=>true,
            'preview'=>true, // Disable the previewer
            'output' => array('h5'),
            'subtitle'=> __("Choose Size and Style for h5", 'virtue'),
            'default'=> array(
                'font-family'=>'Lato',
                'color'=>"", 
                'font-style'=>'700',
                'font-size'=>'18px', 
                'line-height'=>'24px', ),
            ),
		array(
            'id'=>'info_body_font',
            'type' => 'info',
            'desc' => __('Body Font Options', 'virtue'),
            ),
		array(
            'id'=>'font_p',
            'type' => 'typography', 
            'title' => __('Body Font', 'virtue'),
            //'compiler'=>true, // Use if you want to hook in your own CSS compiler
            'font-family'=>true, 
            'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            'font-backup'=>false, // Select a backup non-google font in addition to a google font
            'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
            'subsets'=>true, // Only appears if google is true and subsets not set to false
            'font-size'=>true,
            'line-height'=>true,
            'text-align' => false,
            //'word-spacing'=>false, // Defaults to false
            'all_styles' => true,
            'color'=>true,
            'preview'=>true, // Disable the previewer
            'output' => array('body'),
            'subtitle'=> __("Choose Size and Style for paragraphs", 'virtue'),
            'default'=> array(
                'font-family'=>'Verdana, Geneva, sans-serif',
                'color'=>"", 
                'font-style'=>'400',
                'font-size'=>'14px', 
                'line-height'=>'20px', ),
            ),
	),
);
$this->sections[] = array(
    'icon' => 'icon-reorder',
    'icon_class' => 'icon-large',
    'title' => __('Menu Settings', 'virtue'),
    'desc' => "<div class='redux-info-field'><h3>".__('Primary Menu Options', 'virtue')."</h3></div>",
    'fields' => array(
    	array(
            'id'=>'font_primary_menu',
            'type' => 'typography', 
            'title' => __('Primary Menu Font', 'virtue'),
            //'compiler'=>true, // Use if you want to hook in your own CSS compiler
            'font-family'=>true, 
            'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            'font-backup'=>false, // Select a backup non-google font in addition to a google font
            'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
            'subsets'=>true, // Only appears if google is true and subsets not set to false
            'font-size'=>true,
            'line-height'=>true,
            'text-align' => false,
            //'word-spacing'=>false, // Defaults to false
            //'all_styles' => true,
            'color'=>true,
            'preview'=>true, // Disable the previewer
            'output' => array('#nav-main ul.sf-menu a'),
            'subtitle'=> __("Choose Size and Style for primary menu", 'virtue'),
            'default'=> array(
                'font-family'=>'Lato',
                'color'=>"", 
                'font-style'=>'400',
                'font-size'=>'12px', 
                'line-height'=>'18px', ),
            ),
		array(
            'id'=>'info_menu_secondary_font',
            'type' => 'info',
            'desc' => __('Secondary Menu Options', 'virtue'),
            ),
		array(
            'id'=>'font_secondary_menu',
            'type' => 'typography', 
            'title' => __('Secondary Menu Font', 'virtue'),
            //'compiler'=>true, // Use if you want to hook in your own CSS compiler
            'font-family'=>true, 
            'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            'font-backup'=>false, // Select a backup non-google font in addition to a google font
            'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
            'subsets'=>true, // Only appears if google is true and subsets not set to false
            'font-size'=>true,
            'line-height'=>true,
            'text-align' => false,
            //'word-spacing'=>false, // Defaults to false
            //'all_styles' => true,
            'color'=>true,
            'preview'=>true, // Disable the previewer
            'output' => array('#nav-second ul.sf-menu a'),
            'subtitle'=> __("Choose Size and Style for secondary menu", 'virtue'),
            'default'=> array(
                'font-family'=>'Lato',
                'color'=>"", 
                'font-style'=>'400',
                'font-size'=>'18px', 
                'line-height'=>'22px', ),
            ),
		array(
            'id'=>'info_menu_mobile_font',
            'type' => 'info',
            'desc' => __('Mobile Menu Options', 'virtue'),
            ),
		array(
            'id'=>'font_mobile_menu',
            'type' => 'typography', 
            'title' => __('Mobile Menu Font', 'virtue'),
            //'compiler'=>true, // Use if you want to hook in your own CSS compiler
            'font-family'=>true, 
            'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            'font-backup'=>false, // Select a backup non-google font in addition to a google font
            'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
            'subsets'=>true, // Only appears if google is true and subsets not set to false
            'font-size'=>true,
            'line-height'=>true,
            'text-align' => false,
            //'word-spacing'=>false, // Defaults to false
            //'all_styles' => true,
            'color'=>true,
            'preview'=>true, // Disable the previewer
            'output' => array('.kad-nav-inner .kad-mnav, .kad-mobile-nav .kad-nav-inner li a', '.nav-trigger-case'),
            'subtitle'=> __("Choose Size and Style for Mobile Menu", 'virtue'),
            'default'=> array(
                'font-family'=>'Lato',
                'color'=>"", 
                'font-style'=>'400',
                'font-size'=>'16px', 
                'line-height'=>'20px', ),
            ),
		),
);

$this->sections[] = array(
    'icon' => 'icon-wrench',
    'icon_class' => 'icon-large',
    'title' => __('Misc Settings', 'virtue'),
    'desc' => "<div class='redux-info-field'><h3>".__('Misc Settings', 'virtue')."</h3></div>",
    'fields' => array(
        array(
            'id'=>'portfolio_link',
            'type' => 'select',
            'data' => 'pages',
            'width' => 'width:60%',
            'title' => __('All Projects Portfolio Page', 'virtue'), 
            'subtitle' => __('This sets the link in every single portfolio page. *note: You still have to set the page template to portfolio.', 'virtue'),
            ),
        array(
            'id'=>'portfolio_comments',
            'type' => 'switch', 
            'title' => __('Allow Comments on Portfolio Posts', 'virtue'),
            'subtitle' => __('Turn on to allow Comments on Portfolio posts', 'virtue'),
            "default" => 0,
            ),
    	array(
            'id'=>'hide_image_border',
            'type' => 'switch', 
            'title' => __('Hide Image Border', 'virtue'),
            'subtitle' => __('Choose to show or hide image border', 'virtue'),
            "default" => 0,
            ),
      array(
            'id'=>'blog_archive_full',
            'type' => 'select',
            'title' => __('Blog Archive', 'virtue'), 
            'subtitle' => __("Choose to show full post or post excerpt.", 'virtue'),
            'options' => array('summery' => 'Post Excerpt','full' => 'Full'),
            'default' => 'summery',
            'width' => 'width:60%',
            ),
    	array(
            'id'=>'close_comments',
            'type' => 'switch', 
            'title' => __('Show Comments Closed Text?', 'virtue'),
            'subtitle' => __('Choose to show or hide comments closed alert below posts.', 'virtue'),
            "default" => 0,
            ),
        array(
            'id'=>'hide_author',
            'type' => 'switch', 
            'title' => __('Show Author Icon with posts?', 'virtue'),
            'subtitle' => __('Choose to show or hide author icon under post title.', 'virtue'),
            "default" => 1,
            ),
        array(
            'id'=>'show_postlinks',
            'type' => 'switch', 
            'title' => __('Show Previous and Next posts links?', 'virtue'),
            'subtitle' => __('Choose to show or hide previous and next post links in the footer of a single post.', 'virtue'),
            "default" => 0,
            ),
        array(
            'id'=>'virtue_custom_favicon',
            'type' => 'media', 
            'preview'=> true,
            'title' => __('Custom Favicon', 'virtue'),
            'subtitle' => __('Upload a 16px x 16px png/gif/ico image that will represent your website favicon.', 'virtue'),
            ),
        array(
            'id'=>'contact_email',
            'type' => 'text',
            'title' => __('Contact Form Email', 'virtue'),
            'subtitle' => __('Sets the email for the contact page email form.', 'virtue'),
            'default' => 'test@test.com'
            ),
        array(
            'id'=>'footer_text',
            'type' => 'textarea',
            'title' => __('Footer Copyright Text', 'virtue'), 
            'subtitle' => __('Write your own copyright text here. You can use the following shortcodes in your footer text: [copyright] [site-name] [the-year]', 'virtue'),
            'default' => '[copyright] [the-year] [site-name] [theme-credit]',
            ),
        array(
            'id'=>'info_blog_defaults',
            'type' => 'info',
            'desc' => __('Blog Post Defaults', 'virtue'),
            ),
        array(
            'id'=>'post_summery_default',
            'type' => 'select',
            'title' => __('Blog Post Summary Default', 'virtue'), 
            'options' => array('text' => 'Text', 'img_portrait' => 'Portrait Image', 'img_landscape' => 'Landscape Image', 'slider_portrait' => 'Portrait Image Slider' , 'slider_landscape' => 'Landscape Image Slider'),
            'width' => 'width:60%',
            'default' => 'text',
            ),
        array(
            'id'=>'post_head_default',
            'type' => 'select',
            'title' => __('Blog Post Head Content Default', 'virtue'), 
            'options' => array('none' => __('None', 'virtue'), 'flex' => __('Image Slider', 'virtue'), 'image' => __('Image', 'virtue'), 'video' => __('Video', 'virtue')),
            'width' => 'width:60%',
            'default' => 'none',
            ),
        array(
            'id'=>'info_sidebars',
            'type' => 'info',
            'desc' => __('Create Sidebars', 'virtue'),
            ),
        array(
            'id'=>'cust_sidebars',
            'type' => 'multi_text',
            'title' => __('Create Custom Sidebars', 'virtue'),
            'subtitle' => __('Type new sidebar name into textbox', 'virtue'),
            'default' =>__('Extra Sidebar', 'virtue'),
            ),
        array(
            'id'=>'info_wpgallerys',
            'type' => 'info',
            'desc' => __('Wordpress Galleries', 'virtue'),
            ),
        array(
            'id'=>'virtue_gallery',
            'type' => 'switch', 
            'title' => __('Enable Virtue Galleries to override Wordpress', 'virtue'),
            'subtitle' => __('Disable this if using a plugin to customize galleries, for example jetpack tiled gallery.', 'virtue'),
            "default" => 1,
            ),
    ),
);
$this->sections[] = array(
    'icon' => 'icon-code',
    'icon_class' => 'icon-large',
    'title' => __('Advanced Settings', 'virtue'),
    'desc' => "<div class='redux-info-field'><h3>".__('Custom CSS Box', 'virtue')."</h3></div>",
    'fields' => array(
             array(
            'id'=>'custom_css',
            'type' => 'textarea',
            'title' => __('Custom CSS', 'virtue'), 
            'subtitle' => __('Quickly add some CSS to your theme by adding it to this block.', 'virtue'),
            ),
    ),
);

$this->sections[] = array(
        'icon' => 'icon-upload',
        'icon_class' => 'icon-large',
        'title' => __('Theme Update Import', 'virtue'),
        'desc' => __('If updating from version 1.5.6 or earlier use this script to update your theme options.', 'virtue'),
        'fields' => array(
                array(
                'id'=>'import_old',
                'type' => 'switch', 
                'title' => __('Turn on and save to start script', 'virtue'),
                'subtitle' => '',
                "default" => 0,
                ),
                array(
                'id'=>'old_options_child',
                'type' => 'text',
                'title' => __('If using a child theme enter child theme folder', 'virtue'),
                'subtitle' => '',
                'default' => ''
                ),
               array(
                'id'=>'raw_new_info',
                'type' => 'raw',
                'content' => $item_info,
                )
            ),   
        );
}
          public function setArguments() {
            $theme = wp_get_theme();
            $this->args = array(
            'dev_mode' => false,
            'dev_mode_icon_class' => 'icon-large',
            'opt_name' => 'virtue',
            'system_info_icon_class' => 'icon-large',
            'display_name' => $theme->get('Name'),
            'display_version' => $theme->get('Version'),
            'google_api_key' => 'AIzaSyALkgUvb8LFAmrsczX56ZGJx-PPPpwMid0',
            'import_icon' => 'hdd',
            'import_icon_class' => 'icon-large',
            'menu_title' => __('Theme Options', 'virtue'),
            'page_title' => __('Theme Options', 'virtue'),
            'page_slug' => 'kad_options',
            'default_show' => false,
            'default_mark' => '',
            'admin_bar' => false,  
            'page_type' => 'submenu',
            'page_icon' => "kad_logo_header",
            'footer_credit' => __('Thank you for using the Virtue Theme by <a href="http://kadencethemes.com/" target="_blank">Kadence Themes</a>.', 'virtue'),
            );
           $this->args['intro_text'] = 'Upgrade to <a href="http://kadencethemes.com/product/virtue-premium-theme/" target="_blank" >Virtue Premium</a> for more great features. Over 50 more theme options, premium sliders and carousels, breadcrumbs, custom post types and much much more!';
           $this->args['share_icons']['facebook'] = array(
            'link' => 'https://www.facebook.com/KadenceThemes',
            'title' => 'Follow Kadence Themes on Facebook', 
            'icon' => 'icon-facebook',
            );

          }
     }
        new Redux_Framework_Virtue_config();

}



function virtue_override_panel() {
    wp_dequeue_style( 'redux-css' );
    wp_register_style('redux-custom-css', get_template_directory_uri() . '/themeoptions/options/css/style.css', false, 214);    
    wp_enqueue_style( 'redux-custom-css' );
    wp_dequeue_style( 'select2-css' );
    wp_dequeue_script( 'select2-js' );
}
// This example assumes your opt_name is set to redux_demo, replace with your opt_name value
add_action('redux-enqueue-virtue', 'virtue_override_panel');

