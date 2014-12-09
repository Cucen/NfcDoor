<?php
class WP_Mobile_Edition_Admin {
        private $pluginname			= 'WP Mobile Edition'; // $this->pluginname
        private $_p2 	            = 'wp-mobile-core';
        private $_p3 	            = 'wp-mobile-theme';
		private $accesslvl			= 'manage_options';

        public $fdx_defaults     = array(
                 'p3_check_1'         => 0,
                 'p3_check_2'         => 0,
                 //top menu
                 'p3_check_t1'         => 1,
                 'p3_check_t2'         => 1,
                 'p3_check_t3'         => 1,
                 'p3_check_t4'         => 1,
                 'p3_check_t5'         => 0,

                 'p3_rad1'            => 0,
                 //theme
                 'p3_sel1'            => 'blue',
                 //
                 'p3_txt1'            => '',
                 'p3_txt2'            => '',
                 'p3_txt3'            => '',
                 'p3_txt4'            => '',
                 'p3_txt5'            => '',
                 'p3_txt6'            => '',
                 'p3_opl1'            => '',
                 'p3_opl2'            => '', //Favicon
                 'p3_opl3'            => '',
                 'p3_opl4'            => '',
                 'p3_opl5'            => '#bada55',
                 'p3_tex1'            => '',
                 'p3_tex2'            => '',
                 'p3_tex3'            => '',
                 'p3_tex4'            => ''
        );

//--------------------------------------------------------
        private $sbar_homepage       = 'http://wordpress.org/extend/plugins/wp-mobile-edition';
        private $sbar_wpratelink     = 'http://wordpress.org/support/view/plugin-reviews/wp-mobile-edition?rate=5#postform';
        private $sbar_glotpress      = 'http://dev.fabrix.net/translate/projects/wp-mobile-edition';
        private $sbar_rss            = 'http://feeds.feedburner.com/fdxplugins/';


	/**
	 * Instance of this class.
	 *
	 * @since    2.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     2.0
	 */
	private function __construct() {
		/* if( ! is_super_admin() ) {
			return;
		} */
		$plugin = WP_Mobile_Edition::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

        //**********************************************
        include_once( 'class-process.php' );
        new FDX_Process_2();

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     2.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		/* if( ! is_super_admin() ) {
			return;
		} */
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     2.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {
  		   if ( isset( $_GET['page'] ) && strpos( $_GET['page'], $this->plugin_slug ) !== false ) {
            wp_enqueue_style('dashboard');
            wp_enqueue_style('postbox');
            wp_enqueue_style('thickbox');
            wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', dirname(__FILE__ )), array(), WP_Mobile_Edition::VERSION );
		}
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     2.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {
		if ( isset( $_GET['page'] ) && strpos( $_GET['page'], $this->plugin_slug ) !== false ) {
		    wp_enqueue_script('dashboard');
            wp_enqueue_script('postbox');
            wp_enqueue_script('thickbox');
            wp_enqueue_script('media-upload');
            wp_enqueue_script('wp-color-picker');
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', dirname(__FILE__) ), array( 'jquery' ), WP_Mobile_Edition::VERSION );
		}
	}


	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    2.0
	 */
	public function add_plugin_admin_menu() {
    	 add_menu_page(
			    __( $this->pluginname, $this->plugin_slug ) . ' - ' . __( 'Dashboard', $this->plugin_slug ), //Page Title
				__( $this->pluginname, $this->plugin_slug ),
				$this->accesslvl,
				$this->plugin_slug,
				array( $this, 'fdx_options_subpanel_p1' ),
				'dashicons-smartphone'
			);
         add_submenu_page(
					$this->plugin_slug,
					__( $this->pluginname, $this->plugin_slug ) . ' - ' . __( 'Core Settings', $this->plugin_slug ),
					__( 'Core Settings', $this->plugin_slug ),
					$this->accesslvl,
                    $this->plugin_slug . '-'.$this->_p2,
					array( $this, 'fdx_options_subpanel_p2' )
			);
  	   	add_submenu_page(
					$this->plugin_slug,
					__( $this->pluginname, $this->plugin_slug ) . ' - ' . __( 'Theme Settings', $this->plugin_slug ),
					__( 'Theme Settings', $this->plugin_slug ),
					$this->accesslvl,
                    $this->plugin_slug . '-'.$this->_p3,
					array( $this, 'fdx_options_subpanel_p3' )
			);
				//Make the dashboard the first submenu item and the item to appear when clicking the parent.
				global $submenu;
				if ( isset( $submenu[$this->plugin_slug] ) ) {
					$submenu[$this->plugin_slug][0][0] = __( 'Dashboard', $this->plugin_slug );
				}

  	}


	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    2.0
	 */
public function fdx_options_subpanel_p1() {
  include_once( 'page-p1.php' );
}

public function fdx_options_subpanel_p2() {
    if(sizeof($_POST)>0) {
    print '<div class="box-shortcode box-green"><strong>' . WP_Mobile_Edition::fdx_switcher_options_write() . '</strong></div>';
  }
include_once( 'page-p2.php' );
}


public function fdx_options_subpanel_p3() {
include_once( 'page-p3.php' );
}

/*
 * Get settings defaults
 */
function fdx_get_settings() {
	$settings = $this->fdx_defaults;
	$wordpress_settings = get_option( 'fdx_settings_2' );
	if ( $wordpress_settings ) {
		foreach( $wordpress_settings as $key => $value ) {
			$settings[ $key ] = $value;
		}
	}
	return $settings;
}



}