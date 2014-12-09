<?php
class WP_Mobile_Edition {
	const VERSION               = '2.2.3';  //

    const PHP_MIN               = '5.0';  //
    const WP_MIN                = '3.0';  //

    public $p1_cookie_var       = 'fdx_switcher';       // and "cgi_var"
    public $p1_no_switch        = 0;
    public $p1_desktop_page     = 1;
    public $p1_mobile_page      = 2;                    // $this->p1_mobile_page

	protected $plugin_slug = 'wp-mobile-edition';

	/**
	 * Instance of this class.
	 *
	 * @since    2.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     2.0
	 */
	private function __construct() {
		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );


//----------------------------------------------------------------
        add_action('admin_notices', array( $this, 'fdx_admin_notices_2') );
        add_action('wp_footer', array( $this, 'fdx_switcher_wp_footer'));
        add_filter('stylesheet', array( $this, 'fdx_switcher_stylesheet'));
        add_filter('template', array( $this, 'fdx_switcher_template'));
        add_filter('option_home', array( $this, 'fdx_switcher_option_home_siteurl'));
        add_filter('option_siteurl', array( $this, 'fdx_switcher_option_home_siteurl'));

        //detect
        $switcher_mode = get_option('fdx_switcher_mode');
        if($switcher_mode != 'none'){
        add_action('init', array( $this, 'fdx_mobile_redirect'));
        }

        //--------------ALL
        /* load Option */
        add_action( 'after_setup_theme', array( $this, 'fdx_includes' ), 1 );

       //--------------------shortcode
       add_shortcode('fdx-switch-link', array( $this, 'fdx_show_theme_switch_link'));

        add_action('widgets_init', array( $this, 'fdx_widgets_init'), 1 );

        require_once( 'class-widgets.php' );
        new FDX_Widget_1;
}

	/**
	 * Return the plugin slug.
	 *
	 * @since    2.0
	 *
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     2.0
	 *
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    2.0
	 */
	public static function activate() {

//verifica se o tema pode ser gravado e todos os erros
if (self::fdx_readiness_audit()) {
    self::fdx_directory_copy_themes(dirname(__FILE__) . "/includes/mobile_themes", get_theme_root());

//carrega configurações padrao
self::fdx_switcher_activate();

//---------------
self::fdx_insert_post();

//grava mensagem de inicio
$time = time();
update_option('fdx1_hidden_time_2', $time ); //grava o tempo em
}

$settings = WP_Mobile_Edition_Admin::get_instance();
$settingsdef = $settings->fdx_defaults;

update_option( 'fdx_settings_2', $settingsdef );

 }



	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    2.0
	 */
	public static function deactivate() {
   //reset avisos
    update_option('fdx_warning_2', false);
    update_option('fdx_flash_2', false);
     //-----------remome mensagem inicio
    delete_option('fdx1_hidden_time_2');
	}


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    2.0
	 */
	public function load_plugin_textdomain() {
		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );
	}


//----------------------------------------------------------------------------------
    /**
     * Include front-end files
     *
     * These functions are included on every page load
     * incase other plugins need to access them.
     *
     * @return    void
     *
     * @access    private
     * @since     2.0
     */
     public function fdx_includes() {
     include_once( 'fdx-functions.php' );
     add_action( 'init', 'fdx_mobile_itens' );
     /* add_action( 'init', 'my_taxonomies_product', 0 );  */
     }


function fdx_widgets_init() {
	register_widget('FDX_Widget_1');
}


#################################################################################################

/*
|--------------------------------------------------------------------------
| WARNINGS
|--------------------------------------------------------------------------
*/
public function fdx_admin_notices_2() {
  if($warning=get_option('fdx_warning_2')) {
    print "<div class='error'><h2 style='color:#DD3D36'>";
    print sprintf(__('Critical <strong>%s</strong> Issue', 'wp-mobile-edition'), 'WP Mobile Edition');
    print "</h2><p>$warning</p><p>";
    print sprintf(__('Deactivate and re-activate the <strong>%s</strong> once resolved.', 'wp-mobile-edition'), 'WP Mobile Edition' );
    print "</p></div>";
  }
  if($flash=get_option('fdx_flash_2')) {
    print "<div class='error'><p><strong style='color:#770000'>";
    print sprintf(__('Important <strong>%s</strong> Notice', 'wp-mobile-edition'), 'WP Mobile Edition' );
    print "</strong></p><p>$flash</p></div>";
    update_option('fdx_flash_2', '');
  }
}





public static function fdx_switcher_trim_domain($domain) {
  $trimmed_domain = trim(strtolower($domain));
  if(substr($trimmed_domain, 0, 7) == 'http://') {
    $trimmed_domain = substr($trimmed_domain, 7);
  } elseif(substr($trimmed_domain, 0, 8) == 'https://') {
    $trimmed_domain = substr($trimmed_domain, 8);
  }
  $trimmed_domain = explode("/", "$trimmed_domain/");
  $trimmed_domain = $trimmed_domain[0];
  return $trimmed_domain;
}



    /**
     * Switcher link
	 *
	 * @since  2.0
	 */
    function fdx_switcher_link($type, $label) {
       //cookie expires when the user closes his browser
        $cookie = $this->p1_cookie_var . "=$type;path=/;expires=";
        $target_url = esc_url("http://" . self::fdx_switcher_domains($type, true) . self::fdx_switcher_current_path_plus_cgi('', $type));
    if ($target_url) {
     $switchpng = plugins_url( 'assets/images/switch.png', dirname(__FILE__));
    return "<a onclick='document.cookie=\"$cookie\";' href='$target_url' title='$label' rel='nofollow'><img src='$switchpng' width='50' height='20' alt=''></a>";
    }
}


/*
|--------------------------------------------------------------------------
|  Add footer
|--------------------------------------------------------------------------
*/
function fdx_switcher_wp_footer($force=false) {
  if(!$force && (get_option('fdx_switcher_mode')=='none' || get_option('fdx_switcher_footer_links')!='true')) {
    return;
  }
  switch (self::fdx_switcher_outcome()) {
      case $this->p1_mobile_page:
  //   print "<div style=\"text-align: center;clear: both\">" . self::fdx_switcher_link('desktop', __('Switch to Desktop Version', $this->plugin_slug) ) . "</div>";
      break;
      case $this->p1_desktop_page:
      print "<div style=\"text-align: center;clear: both\">" . self::fdx_switcher_link('mobile', __('Switch to Mobile Version', $this->plugin_slug)) . "</div>";
      break;
  }
}

/*
|--------------------------------------------------------------------------
| Embed Switch Links in Theme Via Shortcode
|--------------------------------------------------------------------------
@  [fdx-switch-link]
@  <?php echo do_shortcode('[fdx-switch-link]'); ?>
*/
function fdx_show_theme_switch_link() {
  switch (self::fdx_switcher_outcome()) {
    case $this->p1_mobile_page:
      print self::fdx_switcher_link('desktop', __('Switch to Desktop Version', $this->plugin_slug) );
      break;
    case $this->p1_desktop_page:
      print self::fdx_switcher_link('mobile', __('Switch to Mobile Version', $this->plugin_slug));
      break;
  }
}






function fdx_switcher_stylesheet($stylesheet) {
  switch (self::fdx_switcher_outcome()) {
    case $this->p1_mobile_page:
      if($mobile_stylesheet = get_option('fdx_switcher_mobile_theme_stylesheet')) {
        return $mobile_stylesheet;
      }
  }
  return $stylesheet;
}

function fdx_switcher_template($template) {
  switch (self::fdx_switcher_outcome()) {
    case $this->p1_mobile_page:
      if($mobile_template = get_option('fdx_switcher_mobile_theme_template')) {
        return $mobile_template;
      }
  }
  return $template;
}

function fdx_switcher_option_home_siteurl($value) {
  switch (self::fdx_switcher_outcome()) {
    case $this->p1_mobile_page:
      if(($scheme = substr($value, 0, 7))=="http://" || ($scheme = substr($value, 0, 8))=="https://") {
        $path = "";
        if(sizeof($parts=(explode('/', "$value", 4)))==4) {
          $path = '/' . array_pop($parts);
        }
        if (strpos(get_option('fdx_switcher_mode'), 'domain')!==false){
          $domain = self::fdx_switcher_domains('mobile', true);
        } else {
          $domain = $_SERVER['HTTP_HOST'];
        }
        return $scheme . $domain .  $path;
      }
  }
  return $value;
}

function fdx_switcher_outcome() {
if (is_admin()) {
return;
}

  global $fdx_switcher_outcome;
  if(!isset($fdx_switcher_outcome)) {
    $switcher_mode = get_option('fdx_switcher_mode');
    if (self::fdx_switcher_domains('desktop', true) == self::fdx_switcher_domains('mobile', true)) {
      $switcher_mode = "browser";
    }
    $desktop_domain = self::fdx_switcher_is_domain('desktop');
    $mobile_domain = self::fdx_switcher_is_domain('mobile');
    if($desktop_domain==$mobile_domain) {
      $desktop_domain=!$desktop_domain;
    }
    $desktop_browser = ''; //fdx removed test?
    $mobile_browser = '';  //fdx removed
    if($desktop_browser==$mobile_browser) {
      $desktop_browser=!$desktop_browser;
    }
    $desktop_cookie = self::fdx_switcher_is_cookie('desktop');
    $mobile_cookie = self::fdx_switcher_is_cookie('mobile');
    $cgi = self::fdx_switcher_is_cgi_parameter_present();
    $fdx_switcher_outcome = self::fdx_switcher_outcome_process($switcher_mode, $desktop_domain, $mobile_domain, $desktop_browser, $mobile_browser, $desktop_cookie, $mobile_cookie, $cgi);
  }
  return $fdx_switcher_outcome;
}
function fdx_switcher_outcome_process($switcher_mode, $desktop_domain, $mobile_domain, $desktop_browser, $mobile_browser, $desktop_cookie, $mobile_cookie, $cgi) {
  switch ($switcher_mode) {
    case 'browser':
      if ($cgi=='desktop' || $desktop_cookie) {
        return $this->p1_desktop_page;
      } elseif ($cgi=='mobile' || $mobile_cookie) {
        return $this->p1_mobile_page;
      }
      return $mobile_browser ? $this->p1_mobile_page : $this->p1_desktop_page;
      case 'domain':
      return $mobile_domain ? $this->p1_mobile_page : $this->p1_desktop_page;
      default:
      return $this->p1_no_switch;
  }
}

public static function fdx_switcher_domains($type='desktop', $first_only=false) {
  if(get_option('fdx_switcher_mode')=='browser'){
    $type = 'desktop';
  }
  $domains = strtolower(get_option('fdx_switcher_' . $type . '_domains'));
  $domains = explode(",", $domains);
  $trimmed_domains = array();
  foreach($domains as $domain) {
    if($first_only) {
      return self::fdx_switcher_trim_domain($domain);
    }
    $trimmed_domains[] = self::fdx_switcher_trim_domain($domain);
  }
  return $trimmed_domains;
}
function fdx_switcher_is_domain($type='desktop') {
  $this_domain = strtolower($_SERVER['HTTP_HOST']);
  $domains = self::fdx_switcher_domains($type);
  foreach($domains as $domain) {
    if (substr($this_domain, -strlen($domain)) == $domain) {
      return true;
    }
  }
  return false;
}


    /**
     * Include front-end files
     *
     * These functions are included on every page load
     * incase other plugins need to access them.
     *
     * @return    void
     *
     * @access    public | private
     * @since     2.0
     */
function fdx_switcher_is_cookie($type='desktop') {
  return (isset($_COOKIE[$this->p1_cookie_var]) && $_COOKIE[$this->p1_cookie_var] == $type);
}


function fdx_switcher_is_cgi_parameter_present() {
  if(isset($_GET[$this->p1_cookie_var])) {
    return $_GET[$this->p1_cookie_var];
  }
  return false;
}




	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 *
	 * @since     2.0
	 */
    function fdx_switcher_current_path_plus_cgi($path='', $type='true') {
    if($path) {
    if(strpos(strtolower($path), 'http://')===0 || strpos(strtolower($path), 'https://')===0) {
      $path = explode("/", $path, 4);
      $path = '/' . array_pop($path);
    }
  } else {
    $path = $_SERVER['REQUEST_URI'];
  }
  $path = htmlentities($path);
  foreach(array("true", "desktop", "mobile") as $t) {
    $path = str_replace($this->p1_cookie_var . "=$t&amp;", "", $path);
    $path = str_replace($this->p1_cookie_var . "=$t&", "", $path);
    $path = str_replace("&amp;" . $this->p1_cookie_var . "=$t", "", $path);
    $path = str_replace("&" . $this->p1_cookie_var . "=$t", "", $path);
    $path = str_replace($this->p1_cookie_var . "=$t", "", $path);
  } //surely there's a better way
  if (strpos($path, "?") === false) {
    return $path . "?" . $this->p1_cookie_var . "=$type";
  } elseif (substr($path, -1) == "?") {
    return $path . $this->p1_cookie_var . "=$type";
  }
  return $path . "&amp;" . $this->p1_cookie_var . "=$type";
}


function fdx_switcher_set_cookie($type) {
  setcookie($this->p1_cookie_var, $type, time()+60*60*24*365, '/');
}


function fdx_switcher_interstitial($type) {
  return call_user_func('fdx_switcher_' . $type . '_interstitial');
}

public static function fdx_switcher_options_write() {
  $message = __('Settings Updated', 'wp-mobile-edition');
  foreach(array(
    'fdx_switcher_mode'=>false,
    'fdx_switcher_desktop_domains'=>false,
    'fdx_switcher_mobile_domains'=>false,
    'fdx_switcher_mobile_theme'=>false,
    'fdx_switcher_footer_links'=>true,
    'fdx_switcher_tablet'=>true,
  ) as $option=>$checkbox) {
    if(isset($_POST[$option])){
      $value = $_POST[$option];
      if(!is_array($value)) {
  			$value = trim($value);
      }
			$value = stripslashes_deep($value);
      update_option($option, $value);
    } elseif ($checkbox) {
      update_option($option, 'false');
    }
  }
  $option = 'fdx_switcher_mobile_theme';
  $theme_data = wp_get_theme(get_option($option));
  if(isset($theme_data['Stylesheet']) && isset($theme_data['Template'])) {
    update_option($option . "_stylesheet", $theme_data['Stylesheet']);
    update_option($option . "_template", $theme_data['Template']);
  }
  if (strpos(get_option('fdx_switcher_mode'), 'none')===false) {
    foreach(array('fdx_switcher_mobile_domains', 'fdx_switcher_desktop_domains') as $option) {
      $trimmed_domains=array();
      foreach(explode(",", get_option($option)) as $domain) {
        $domain = trim($domain);
        $trimmed_domain = self::fdx_switcher_trim_domain($domain);
        $trimmed_domains[] = $trimmed_domain;
      }
      update_option($option, join(', ', $trimmed_domains));
    }
  }

  if (get_option('fdx_switcher_desktop_domains')=='' || get_option('fdx_switcher_mobile_domains')=='') {
    switch(get_option('fdx_switcher_mode')) {
    case 'domain':
        update_option('fdx_switcher_mode', 'none');
        $message = __('You must provide the mobile domain. Switching has been disabled.', 'wp-mobile-edition');
        break;
    }
  }
  return $message;
}

public static function fdx_switcher_option($option, $onchange='') {
  switch ($option) {
    case 'fdx_switcher_mode':
      return self::fdx_switcher_option_dropdown(
        $option,
        array(
          'none'=>__('Disabled', 'wp-mobile-edition'),
          'browser'=>__('Browser Detection', 'wp-mobile-edition'),
          'domain'=>__('Subdomain', 'wp-mobile-edition'),
        ),
        $onchange
      );

    case 'fdx_switcher_mobile_theme':
      return self::fdx_switcher_option_themes($option);

     case 'fdx_switcher_desktop_domains':
     case 'fdx_switcher_mobile_domains':
      return self::fdx_switcher_option_text(
        $option,
        $onchange
      );

      case 'fdx_switcher_footer_links':
      return self::fdx_switcher_option_checkbox(
        $option,
        $onchange
      );

      case 'fdx_switcher_tablet':
      return self::fdx_switcher_option_checkbox(
        $option,
        $onchange
      );

  }
}


public static function fdx_switcher_option_dropdown($option, $options, $onchange='') {
  if ($onchange!='') {
    $onchange = 'onchange="' . esc_attr($onchange) . '" onkeyup="' . esc_attr($onchange) . '"';
  }
  $dropdown = "<select id='$option' name='$option' $onchange>";
  foreach($options as $value=>$description) {
    if(get_option($option)==$value) {
      $selected = ' selected="true"';
    } else {
      $selected = '';
    }
    $dropdown .= '<option value="' . esc_attr($value) . '"' . $selected . '>' . __($description, 'wp-mobile-edition') . '</option>';
  }
  $dropdown .= "</select>";
  return $dropdown;
}

public static function fdx_switcher_option_text($option, $onchange='') {
  if ($onchange!='') {
    $onchange = 'onchange="' . esc_attr($onchange) . '" onkeyup="' . esc_attr($onchange) . '"';
  }
  $text = '<input type="text" id="' . $option . '" name="' . $option . '" value="' . esc_attr(get_option($option)) . '" ' . $onchange . '/>';
  return $text;
}

public static function fdx_switcher_option_checkbox($option, $onchange='') {
  if ($onchange!='') {
    $onchange = 'onchange="' . esc_attr($onchange) . '"';
  }
  $checkbox = '<input type="checkbox" id="' . $option . '" name="' . $option . '" value="true" ' . (get_option($option)==='true'?'checked="true"':'') . ' ' . $onchange . ' />';
  return $checkbox;
}

public static function fdx_switcher_option_themes($option) {
  $mobile_themes = array();
  $non_mobile_themes = array();
  foreach(wp_get_themes() as $name=>$theme) {
    if(strpos($name, 'mTheme')!==false) {
      $mobile_themes[$name] = $name;
    }
  }
  $options = array_merge($mobile_themes, $non_mobile_themes);
  return self::fdx_switcher_option_dropdown($option, $options);
}


// funcões isoladas
public static function fdx_switcher_desktop_theme() {
  $info = wp_get_theme();
  return $info->title;
}


################################################################

 /*
 |--------------------------------------------------------------------------
 | SETUP - Check Compatibility
 |--------------------------------------------------------------------------
 */
public static function fdx_readiness_audit() {
 global $wp_version;
  $ready = true;
  $why_not = array();
//php min
 if (version_compare(PHP_VERSION, self::PHP_MIN, '<')) {
    $ready = false;
    $why_not[] = sprintf(__('<strong>PHP</strong> versions less than <code>%1s</code> are not supported by this plugin, and you have version <code>%2s</code>', 'wp-mobile-edition'), self::PHP_MIN ,PHP_VERSION);
  }
//wp min
  if (version_compare($wp_version, self::WP_MIN, '<')) {
   $ready = false;
    $why_not[] = sprintf(__('<strong>WordPress</strong> versions less than <code>%1s</code> are not supported by this plugin, and you have version <code>%2s</code>', 'wp-mobile-edition'), self::WP_MIN ,$wp_version);
  }

  $theme_dir = str_replace('/', DIRECTORY_SEPARATOR, get_theme_root());
  $theme_does = '';
  if (!file_exists($theme_dir)) {
  	$theme_does = __("That directory does not exist.", 'wp-mobile-edition');
  } elseif (!is_writable($theme_dir)) {
  	$theme_does = __("That directory is not writable.", 'wp-mobile-edition');
  } elseif (!is_executable($theme_dir) && DIRECTORY_SEPARATOR=='/') {
  	$theme_does = __("That directory is not executable.", 'wp-mobile-edition');
  }
  if($theme_does!='') {
    $ready = false;
    $why_not[] = sprintf(__('<strong>Not able to install theme files</strong> to %s.', 'wp-mobile-edition'), $theme_dir) . '<hr> ' . $theme_does . '<hr>' . __('Please ensure that the web server has write- and execute-access to it.', 'wp-mobile-edition');
  }

  if (!$ready) {
    update_option('fdx_warning_2', join("<hr />", $why_not));
  }
  return $ready;
}

/*
|--------------------------------------------------------------------------
| SETUP - Create/Update Default Mobile Theme
|--------------------------------------------------------------------------
*/
public static function fdx_directory_copy_themes($source_dir, $destination_dir, $benign=true) {
  if(file_exists($destination_dir)) {
  	$dir_does = '';
	  if (!is_writable($destination_dir)) {
	  	$dir_does = "That directory is not writable.";
	  } elseif (!is_executable($destination_dir) && DIRECTORY_SEPARATOR=='/') {
	  	$dir_does = "That directory is not executable.";
	  }
	  if($dir_does!='') {
      update_option('fdx_warning_2', sprintf(__('<strong>Could not install theme files</strong> to ', 'wp-mobile-edition'), $destination_dir) . ' ' . $dir_does . ' ' . __('Please ensure that the web server has write- and execute-access to it.', 'wp-mobile-edition'));
      return;
    }
  } elseif (!is_dir($destination_dir)) {
    if ($destination_dir[0] != ".") {
	    mkdir($destination_dir);
	  }
  }
  $dir_handle = opendir($source_dir);
  while($source_file = readdir($dir_handle)) {
    if ($source_file[0] == ".") {
      continue;
    }
    // if mobile theme is there: update
    if (file_exists($destination_child = "$destination_dir/$source_file") && $benign) {
     self::fdx_directory_copy_themes(dirname(__FILE__) . "/includes/mobile_themes", get_theme_root(), false);
      continue;
    }
    //if no, create new
    if (is_dir($source_child = "$source_dir/$source_file")) {
      self::fdx_directory_copy_themes($source_child, $destination_child, $benign);
      continue;
    }

    if (file_exists($destination_child) && !is_writable($destination_child)) {
      update_option('fdx_warning_2', sprintf(__('<strong>Could not install file</strong> to %s.', 'wp-mobile-edition'), $destination_child) . ' ' . __('Please ensure that the web server has write- access to that file.', 'wp-mobile-edition'));
      continue;
    }
    copy($source_child, $destination_child);
  }
  closedir($dir_handle);
}

/*
|--------------------------------------------------------------------------
| SETUP - Insert page
|--------------------------------------------------------------------------
*/
Public static function fdx_insert_post() {
// Create post object
$my_post1 = array(
  'post_title'    => '*WP Mobile Edition (Contact)',
  'post_name'     => 'fdx-contact',
  'post_content'  => __('This page is required for plugin WP Mobile Edition.', 'wp-mobile-edition'),
  'post_status'   => 'publish',
  'post_type'     => 'page'
);

$my_post2 = array(
  'post_title'    => '*WP Mobile Edition (Blog Index)',
  'post_name'     => 'fdx-index',
  'post_content'  => __('This page is required for plugin WP Mobile Edition.', 'wp-mobile-edition'),
  'post_status'   => 'publish',
  'post_type'     => 'page'
);

$page_exists1 = get_page_by_title( $my_post1['post_title'] );
$page_exists2 = get_page_by_title( $my_post2['post_title'] );

if( $page_exists1 == null ) {
// Insert the post into the database
wp_insert_post( $my_post1 );
}

if( $page_exists2 == null ) {
wp_insert_post( $my_post2 );
}
}

/*
|--------------------------------------------------------------------------
| SETUP - Save Default Settings
|--------------------------------------------------------------------------
*/
public static function fdx_switcher_activate() {
  $default_desktop_domain=self::fdx_switcher_trim_domain(get_option('home'));
  $default_desktop_domains = array();
  $default_mobile_domains = array();

  $default_desktop_domains[] = $default_desktop_domain;
  if(($tld=substr($default_desktop_domain, 0, -4))==".com" || $tld==".org" || $tld==".net") {
    $default_mobile_domains[] = substr($default_desktop_domain, 0, -4) . ".mobi";
  }
  if(substr($default_desktop_domain, 0, 4)=="www.") {
    $default_desktop_domains[] = substr($default_desktop_domain, 4);
    $default_mobile_domains[] = "m." . substr($default_desktop_domain, 4);
  } else {
    $default_mobile_domains[] = "m." . $default_desktop_domain;
  }
  $default_theme = 'mTheme-Unus';

  foreach(array(
    'fdx_switcher_mode' => 'browser',
    'fdx_switcher_desktop_domains' => implode(", ", $default_desktop_domains),
    'fdx_switcher_mobile_domains' => implode(", ", $default_mobile_domains),
    'fdx_switcher_mobile_theme' => $default_theme,
    'fdx_switcher_mobile_theme_stylesheet' => $default_theme,
    'fdx_switcher_mobile_theme_template' => $default_theme,
    'fdx_switcher_footer_links' => 'true',
    'fdx_switcher_tablet'=>'true',
     ) as $name=>$value) {
    if (get_option($name)=='') {
      update_option($name, $value);
    }
  }

}



/*
|--------------------------------------------------------------------------
| Redirects by User-Agent Detection
|--------------------------------------------------------------------------
*/
function fdx_mobile_redirect(){

$desktop_cookie = self::fdx_switcher_is_cookie('desktop');
$mobile_cookie = self::fdx_switcher_is_cookie('mobile');
if(!$mobile_cookie && !$desktop_cookie){

include_once( 'includes/Mobile_Detect.php' );
$detect = new Mobile_Detect();
$target_url = "http://" . self::fdx_switcher_domains('mobile', true) . self::fdx_switcher_current_path_plus_cgi();

if (get_option('fdx_switcher_tablet') != 'true') {
     if ($detect->isMobile() && !$detect->isTablet()){
      self::fdx_switcher_set_cookie('mobile');
      wp_redirect( $target_url );
      exit;
      }
  } else {
   if ($detect->isMobile()){
      self::fdx_switcher_set_cookie('mobile');
      wp_redirect( $target_url );
      exit;
        }
     }
   }
}


}//end class