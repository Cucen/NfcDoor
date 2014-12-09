<?php
/**
 * Plugin Name: Form Maker
 * Plugin URI: http://web-dorado.com/products/form-maker-wordpress.html
 * Description: This plugin is a modern and advanced tool for easy and fast creating of a WordPress Form. The backend interface is intuitive and user friendly which allows users far from scripting and programming to create WordPress Forms.
 * Version: 1.7.15
 * Author: http://web-dorado.com/
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
define('WD_FM_DIR', WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)));
define('WD_FM_URL', plugins_url(plugin_basename(dirname(__FILE__))));

// Plugin menu.
function form_maker_options_panel() {
  add_menu_page('Form Maker', 'Form Maker', 'manage_options', 'manage_fm', 'form_maker', WD_FM_URL . '/images/FormMakerLogo-16.png');

  $manage_page = add_submenu_page('manage_fm', 'Manager', 'Manager', 'manage_options', 'manage_fm', 'form_maker');
  add_action('admin_print_styles-' . $manage_page, 'form_maker_manage_styles');
  add_action('admin_print_scripts-' . $manage_page, 'form_maker_manage_scripts');

  $submissions_page = add_submenu_page('manage_fm', 'Submissions', 'Submissions', 'manage_options', 'submissions_fm', 'form_maker');
  add_action('admin_print_styles-' . $submissions_page, 'form_maker_submissions_styles');
  add_action('admin_print_scripts-' . $submissions_page, 'form_maker_submissions_scripts');

  $blocked_ips_page = add_submenu_page('manage_fm', 'Blocked IPs', 'Blocked IPs', 'manage_options', 'blocked_ips_fm', 'form_maker');
  add_action('admin_print_styles-' . $blocked_ips_page, 'form_maker_manage_styles');
  add_action('admin_print_scripts-' . $blocked_ips_page, 'form_maker_manage_scripts');

  $themes_page = add_submenu_page('manage_fm', 'Themes', 'Themes', 'manage_options', 'themes_fm', 'form_maker');
  add_action('admin_print_styles-' . $themes_page, 'form_maker_manage_styles');
  add_action('admin_print_scripts-' . $themes_page, 'form_maker_manage_scripts');

  $licensing_plugins_page = add_submenu_page('manage_fm', 'Licensing/Donation', 'Licensing/Donation', 'manage_options', 'licensing_fm', 'form_maker');

  $featured_plugins_page = add_submenu_page('manage_fm', 'Featured Plugins', 'Featured Plugins', 'manage_options', 'featured_plugins_fm', 'form_maker');
  add_action('admin_print_styles-' . $featured_plugins_page, 'form_maker_featured_plugins_styles');

  $uninstall_page = add_submenu_page('manage_fm', 'Uninstall', 'Uninstall', 'manage_options', 'uninstall_fm', 'form_maker');
  add_action('admin_print_styles-' . $uninstall_page, 'form_maker_styles');
  add_action('admin_print_scripts-' . $uninstall_page, 'form_maker_scripts');
}
add_action('admin_menu', 'form_maker_options_panel');

function form_maker() {
  require_once(WD_FM_DIR . '/framework/WDW_FM_Library.php');
  $page = WDW_FM_Library::get('page');
  if (($page != '') && (($page == 'manage_fm') || ($page == 'submissions_fm') || ($page == 'blocked_ips_fm') || ($page == 'themes_fm') || ($page == 'licensing_fm') || ($page == 'featured_plugins_fm') || ($page == 'uninstall_fm') || ($page == 'formmakerwindow'))) {
    require_once (WD_FM_DIR . '/admin/controllers/FMController' . ucfirst(strtolower($page)) . '.php');
    $controller_class = 'FMController' . ucfirst(strtolower($page));
    $controller = new $controller_class();
    $controller->execute();
  }
}

add_action('wp_ajax_get_stats', 'form_maker'); //Show statistics
add_action('wp_ajax_generete_csv', 'form_maker_ajax'); // Export csv.
add_action('wp_ajax_generete_xml', 'form_maker_ajax'); // Export xml.
add_action('wp_ajax_FormMakerPreview', 'form_maker_ajax');
add_action('wp_ajax_formmakerwdcaptcha', 'form_maker_ajax'); // Generete captcha image and save it code in session.
add_action('wp_ajax_nopriv_formmakerwdcaptcha', 'form_maker_ajax'); // Generete captcha image and save it code in session for all users.
// add_action('wp_ajax_paypal_info', 'form_maker_ajax'); // Paypal info in submissions page.
add_action('wp_ajax_fromeditcountryinpopup', 'form_maker_ajax'); // Open country list.
add_action('wp_ajax_product_option', 'form_maker_ajax'); // Open product options on add paypal field.
add_action('wp_ajax_frommapeditinpopup', 'form_maker_ajax'); // Open map in submissions.
add_action('wp_ajax_show_matrix', 'form_maker_ajax'); // Edit matrix in submissions.
add_action('wp_ajax_FormMakerEditCSS', 'form_maker_ajax'); // Edit css from form options.
add_action('wp_ajax_FormMakerSQLMapping', 'form_maker_ajax'); // Add/Edit SQLMaping from form options.

// add_action('wp_ajax_checkpaypal', 'form_maker_ajax'); // Notify url from Paypal Sandbox.
// add_action('wp_ajax_nopriv_checkpaypal', 'form_maker_ajax'); // Notify url from Paypal Sandbox for all users.


function form_maker_ajax() {
  require_once(WD_FM_DIR . '/framework/WDW_FM_Library.php');
  $page = WDW_FM_Library::get('action');
  if ($page != 'formmakerwdcaptcha') {
    if (function_exists('current_user_can')) {
      if (!current_user_can('manage_options')) {
        die('Access Denied');
      }
    }
    else {
      die('Access Denied');
    }
  }
  if ($page != '') {
    require_once (WD_FM_DIR . '/admin/controllers/FMController' . ucfirst($page) . '.php');
    $controller_class = 'FMController' . ucfirst($page);
    $controller = new $controller_class();
    $controller->execute();
  }
}

// Add the Form Maker button.
function form_maker_add_button($buttons) {
  array_push($buttons, "Form_Maker_mce");
  return $buttons;
}

// Register Form Maker button.
function form_maker_register($plugin_array) {
  $url = WD_FM_URL . '/js/form_maker_editor_button.js';
  $plugin_array["Form_Maker_mce"] = $url;
  return $plugin_array;
}

function form_maker_admin_ajax() {
  ?>
  <script>
    var form_maker_admin_ajax = '<?php echo add_query_arg(array('action' => 'formmakerwindow'), admin_url('admin-ajax.php')); ?>';
    var plugin_url = '<?php echo WD_FM_URL; ?>';
  </script>
  <?php
}
add_action('admin_head', 'form_maker_admin_ajax');

function do_output_buffer() {
  ob_start();
}
add_action('init', 'do_output_buffer');

function Form_maker_fornt_end_main($content) {
  global $form_maker_generate_action;
  if ($form_maker_generate_action) {
    $pattern = '[\[Form id="([0-9]*)"\]]';
    $count_forms_in_post = preg_match_all($pattern, $content, $matches_form);
    if ($count_forms_in_post) {
      require_once (WD_FM_DIR . '/frontend/controllers/FMControllerForm_maker.php');
      $controller = new FMControllerForm_maker();
      for ($jj = 0; $jj < $count_forms_in_post; $jj++) {
        $padron = $matches_form[0][$jj];
        $replacment = $controller->execute($matches_form[1][$jj]);
        $content = str_replace($padron, $replacment, $content);
      }
    }
  }
  return $content;
}
add_filter('the_content', 'Form_maker_fornt_end_main', 5000);



// Add the Form Maker button to editor.
add_action('wp_ajax_formmakerwindow', 'form_maker_ajax');
add_filter('mce_external_plugins', 'form_maker_register');
add_filter('mce_buttons', 'form_maker_add_button', 0);

for ($ii = 0; $ii < 100; $ii++) {
  remove_filter('the_content', 'do_shortcode', $ii);
  remove_filter('the_content', 'wpautop', $ii);
}
add_filter('the_content', 'wpautop', 10);
add_filter('the_content', 'do_shortcode', 11);


// Form Maker Widget.
if (class_exists('WP_Widget')) {
  require_once(WD_FM_DIR . '/admin/controllers/FMControllerWidget.php');
  add_action('widgets_init', create_function('', 'return register_widget("FMControllerWidget");'));
}

// Activate plugin.
function form_maker_activate() {
  $version = get_option("wd_form_maker_version");
  $new_version = '1.7.14';
  if (!$version) {
    add_option("wd_form_maker_version", $new_version, '', 'no');
    global $wpdb;
    if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "formmaker'") == $wpdb->prefix . "formmaker") {
      require_once WD_FM_DIR . "/form_maker_update.php";
      form_maker_update_until_mvc();
      form_maker_update_contact();
      form_maker_update('');
    }
    else {
      require_once WD_FM_DIR . "/form_maker_insert.php";
      from_maker_insert();
    }
  }
  elseif (version_compare($version, $new_version, '<')) {
    require_once WD_FM_DIR . "/form_maker_update.php";
    form_maker_update($version);
    update_option("wd_form_maker_version", $new_version);
  }
  require_once WD_FM_DIR . "/form_maker_insert.php";
  install_demo_forms();
}
register_activation_hook(__FILE__, 'form_maker_activate');

if (!isset($_GET['action']) || $_GET['action'] != 'deactivate') {
  add_action('admin_init', 'form_maker_activate');
}

// Form Maker manage page styles.
function form_maker_manage_styles() {
  wp_admin_css('thickbox');
  wp_enqueue_style('form_maker_tables', WD_FM_URL . '/css/form_maker_tables.css', array(), get_option("wd_form_maker_version"));
  wp_enqueue_style('form_maker_first', WD_FM_URL . '/css/form_maker_first.css', array(), get_option("wd_form_maker_version"));
  wp_enqueue_style('form_maker_calendar-jos', WD_FM_URL . '/css/calendar-jos.css');
  wp_enqueue_style('jquery-ui', WD_FM_URL . '/css/jquery-ui-1.10.3.custom.css');
  wp_enqueue_style('jquery-ui-spinner', WD_FM_URL . '/css/jquery-ui-spinner.css');
  wp_enqueue_style('form_maker_style', WD_FM_URL . '/css/style.css', array(), get_option("wd_form_maker_version"));
  wp_enqueue_style('form_maker_codemirror', WD_FM_URL . '/css/codemirror.css');
  wp_enqueue_style('form_maker_layout', WD_FM_URL . '/css/form_maker_layout.css', array(), get_option("wd_form_maker_version"));
}
// Form Maker manage page scripts.
function form_maker_manage_scripts() {
  wp_enqueue_script('thickbox');
  global $wp_scripts;
  if (isset($wp_scripts->registered['jquery'])) {
    $jquery = $wp_scripts->registered['jquery'];
    if (!isset($jquery->ver) OR version_compare($jquery->ver, '1.8.2', '<')) {
      wp_deregister_script('jquery');
      wp_register_script('jquery', FALSE, array('jquery-core', 'jquery-migrate'), '1.10.2' );
    }
  }
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-sortable');
  wp_enqueue_script('jquery-ui-widget');
  wp_enqueue_script('jquery-ui-slider');
  wp_enqueue_script('jquery-ui-spinner');

  // wp_enqueue_script('mootools', WD_FM_URL . '/js/mootools.js', array(), '1.12');
  wp_enqueue_script('gmap_form_api', 'https://maps.google.com/maps/api/js?sensor=false');
  wp_enqueue_script('gmap_form', WD_FM_URL . '/js/if_gmap_back_end.js');

  wp_enqueue_script('form_maker_admin', WD_FM_URL . '/js/form_maker_admin.js', array(), get_option("wd_form_maker_version"));
  wp_enqueue_script('form_maker_manage', WD_FM_URL . '/js/form_maker_manage.js', array(), get_option("wd_form_maker_version"));

  wp_enqueue_script('form_maker_codemirror', WD_FM_URL . '/js/layout/codemirror.js', array(), '2.3');
  wp_enqueue_script('form_maker_clike', WD_FM_URL . '/js/layout/clike.js', array(), '1.0.0');
  wp_enqueue_script('form_maker_formatting', WD_FM_URL . '/js/layout/formatting.js', array(), '1.0.0');
  wp_enqueue_script('form_maker_css', WD_FM_URL . '/js/layout/css.js', array(), '1.0.0');
  wp_enqueue_script('form_maker_javascript', WD_FM_URL . '/js/layout/javascript.js', array(), '1.0.0');
  wp_enqueue_script('form_maker_xml', WD_FM_URL . '/js/layout/xml.js', array(), '1.0.0');
  wp_enqueue_script('form_maker_php', WD_FM_URL . '/js/layout/php.js', array(), '1.0.0');
  wp_enqueue_script('form_maker_htmlmixed', WD_FM_URL . '/js/layout/htmlmixed.js', array(), '1.0.0');

  wp_enqueue_script('Calendar', WD_FM_URL . '/js/calendar/calendar.js', array(), '1.0');
  wp_enqueue_script('calendar_function', WD_FM_URL . '/js/calendar/calendar_function.js');
  // wp_enqueue_script('form_maker_calendar_setup', WD_FM_URL . '/js/calendar/calendar-setup.js');
}

// Form Maker submissions page styles.
function form_maker_submissions_styles() {
  wp_admin_css('thickbox');
  wp_enqueue_style('form_maker_tables', WD_FM_URL . '/css/form_maker_tables.css', array(), get_option("wd_form_maker_version"));
  wp_enqueue_style('form_maker_calendar-jos', WD_FM_URL . '/css/calendar-jos.css');
  wp_enqueue_style('jquery-ui', WD_FM_URL . '/css/jquery-ui-1.10.3.custom.css', array(), '1.10.3');
  wp_enqueue_style('jquery-ui-spinner', WD_FM_URL . '/css/jquery-ui-spinner.css', array(), '1.10.3');
  wp_enqueue_style('jquery.fancybox', WD_FM_URL . '/js/fancybox/jquery.fancybox.css', array(), '2.1.5');
  wp_enqueue_style('form_maker_style', WD_FM_URL . '/css/style.css', array(), get_option("wd_form_maker_version"));
}
// Form Maker submissions page scripts.
function form_maker_submissions_scripts() {
  wp_enqueue_script('thickbox');
  global $wp_scripts;
  if (isset($wp_scripts->registered['jquery'])) {
    $jquery = $wp_scripts->registered['jquery'];
    if (!isset($jquery->ver) OR version_compare($jquery->ver, '1.8.2', '<')) {
      wp_deregister_script('jquery');
      wp_register_script('jquery', FALSE, array('jquery-core', 'jquery-migrate'), '1.10.2' );
    }
  }
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-sortable');
  wp_enqueue_script('jquery-ui-widget');
  wp_enqueue_script('jquery-ui-slider');
  wp_enqueue_script('jquery-ui-spinner');
  wp_enqueue_script('jquery-ui-mouse');
  wp_enqueue_script('jquery-ui-core');

  // wp_enqueue_script('mootools', WD_FM_URL . '/js/mootools.js', array(), '1.12');

  wp_enqueue_script('form_maker_admin', WD_FM_URL . '/js/form_maker_admin.js', array(), get_option("wd_form_maker_version"));
  wp_enqueue_script('form_maker_manage', WD_FM_URL . '/js/form_maker_manage.js', array(), get_option("wd_form_maker_version"));
  wp_enqueue_script('form_maker_submissions', WD_FM_URL . '/js/form_maker_submissions.js', array(), get_option("wd_form_maker_version"));

  wp_enqueue_script('main', WD_FM_URL . '/js/main.js', array(), get_option("wd_form_maker_version"));
  wp_enqueue_script('main_div_front_end', WD_FM_URL . '/js/main_div_front_end.js', array(), get_option("wd_form_maker_version"));

  wp_enqueue_script('Calendar', WD_FM_URL . '/js/calendar/calendar.js', array(), '1.0');
  wp_enqueue_script('calendar_function', WD_FM_URL . '/js/calendar/calendar_function.js');
  // wp_enqueue_script('form_maker_calendar_setup', WD_FM_URL . '/js/calendar/calendar-setup.js');
  
  // Fancybox.
  wp_enqueue_script('jquery.fancybox.pack', WD_FM_URL . '/js/fancybox/jquery.fancybox.pack.js', array(), '2.1.5');
  wp_localize_script('main_div_front_end', 'fm_objectL10n', array(
    'plugin_url' => WD_FM_URL
  ));
}

// Form Maker Featured plugins page styles.
function form_maker_featured_plugins_styles() {
  wp_enqueue_style('Featured_Plugins', WD_FM_URL . '/css/form_maker_featured_plugins.css');
}

function form_maker_styles() {
  wp_enqueue_style('form_maker_tables', WD_FM_URL . '/css/form_maker_tables.css', array(), get_option("wd_form_maker_version"));
}
function form_maker_scripts() {
  wp_enqueue_script('form_maker_admin', WD_FM_URL . '/js/form_maker_admin.js', array(), get_option("wd_form_maker_version"));
}

$form_maker_generate_action = 0;
function form_maker_generate_action() {
  global $form_maker_generate_action;
  $form_maker_generate_action = 1;
}
add_filter('wp_head', 'form_maker_generate_action', 10000);

function form_maker_front_end_scripts() {
  // global $wp_scripts;
  // if (isset($wp_scripts->registered['jquery'])) {
    // $jquery = $wp_scripts->registered['jquery'];
    // if (!isset($jquery->ver) OR version_compare($jquery->ver, '1.8.2', '<')) {
      // wp_deregister_script('jquery');
      // wp_register_script('jquery', FALSE, array('jquery-core', 'jquery-migrate'), '1.10.2' );
    // }
  // }
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-widget');
  wp_enqueue_script('jquery-ui-slider');
  wp_enqueue_script('jquery-ui-spinner');
  wp_enqueue_script('jquery-effects-shake');

  wp_enqueue_style('jquery-ui', WD_FM_URL . '/css/jquery-ui-1.10.3.custom.css');
  wp_enqueue_style('jquery-ui-spinner', WD_FM_URL . '/css/jquery-ui-spinner.css');

  // wp_enqueue_script('mootools', WD_FM_URL . '/js/mootools.js', array(), '1.12');
  wp_enqueue_script('gmap_form_api', 'https://maps.google.com/maps/api/js?sensor=false');
  wp_enqueue_script('gmap_form', WD_FM_URL . '/js/if_gmap_front_end.js');
  wp_enqueue_script('jelly.min', WD_FM_URL . '/js/jelly.min.js');
  wp_enqueue_script('file-upload', WD_FM_URL . '/js/file-upload.js');
  // wp_enqueue_style('gmap_styles_', WD_FM_URL . '/css/style_for_map.css');

  wp_enqueue_script('Calendar', WD_FM_URL . '/js/calendar/calendar.js');
  wp_enqueue_script('calendar_function', WD_FM_URL . '/js/calendar/calendar_function.js');
  // wp_enqueue_script('form_maker_calendar_setup', WD_FM_URL . '/js/calendar/calendar-setup.js');
  wp_enqueue_style('form_maker_calendar-jos', WD_FM_URL . '/css/calendar-jos.css');
  wp_enqueue_style('form_maker_frontend', WD_FM_URL . '/css/form_maker_frontend.css');

  wp_register_script('main_div_front_end', WD_FM_URL . '/js/main_div_front_end.js', array(), get_option("wd_form_maker_version"));
  wp_register_script('main_front_end', WD_FM_URL . '/js/main_front_end.js', array(), get_option("wd_form_maker_version"));
  wp_localize_script('main_div_front_end', 'fm_objectL10n', array(
    'plugin_url' => WD_FM_URL
  ));
  wp_localize_script('main_front_end', 'fm_objectL10n', array(
    'plugin_url' => WD_FM_URL
  ));
}
add_action('wp_enqueue_scripts', 'form_maker_front_end_scripts');

// Languages localization.
function form_maker_language_load() {
  load_plugin_textdomain('form_maker', FALSE, basename(dirname(__FILE__)) . '/languages');
}
add_action('init', 'form_maker_language_load');

?>