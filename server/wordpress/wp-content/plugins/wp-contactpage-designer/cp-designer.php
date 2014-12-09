<?php
/*
Plugin Name: Contact Us Page Builder
Plugin URI: http://www.wppluginpros.com
Description: Create Stuuning Popup or Static Contact us forms and pages in minutes with our drag and Drop form builder.
Version: 1.0.5
Author: Aspire2, JiaZhen Wang
Author URI: http://www.wppluginpros.com
*/

define( "CP_DESIGNER_URL", plugins_url( '/', __FILE__ ) );
define( "CP_DESIGNER_PATH", dirname( __FILE__ ) );

require_once( CP_DESIGNER_PATH .'/includes/template.php' );

class CPDesigner {
    public static $_name = 'cp_designer';
	private $_errors = array();
	private $_success = array();
    
    function __construct() {
		
		register_activation_hook( __FILE__, array( &$this, 'activate_plugin' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'deactivate_plugin' ) );
		
		// add short codes
		add_shortcode( 'cp_designer', array( &$this, 'handle_shortcodes' ) );		
		// hook init action
		add_action( 'init', array( &$this, 'init' ) );		
    }
	
	/**
	 * create necessary tables and insert default rows
	 * @global type $wpdb 
	 */
    public static function activate_plugin() {
        global $wpdb;
        
		// create tables
        $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}cpd_templates` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `tmp_name` varchar(100) NOT NULL,
            `tmp_css` varchar(1000) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        $wpdb->query( $wpdb->prepare( $sql ) );
        
        $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}cpd_elements` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `tmp_id` int(11) NOT NULL,
            `css` text NOT NULL,
            `text` text NOT NULL,
            `value` text NOT NULL,
            `params` text NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        $wpdb->query( $wpdb->prepare( $sql ) );
		
		$sql = "SELECT COUNT(id) FROM `{$wpdb->prefix}cpd_templates` WHERE id=1";
		$exist_table = $wpdb->get_var( $wpdb->prepare( $sql ) );
		
		if ( !$exist_table ) {
			// insert demo template
			$sql = file_get_contents( CP_DESIGNER_PATH .'/sql/cpd_templates.sql' );
			$sql = str_replace( '[TABLE_NAME]', "{$wpdb->prefix}cpd_templates", $sql );
			$sql = str_replace( '[SITE_URL]', site_url(), $sql );
			$wpdb->query( $wpdb->prepare( $sql ) );

			$sql = file_get_contents( CP_DESIGNER_PATH .'/sql/cpd_elements.sql' );
			$sql = str_replace( '[TABLE_NAME]', "{$wpdb->prefix}cpd_elements", $sql );
			$wpdb->query( $wpdb->prepare( $sql ) );
		}
    }
    
	/**
	 * 
	 */
    public static function deactivate_plugin() {
        
    }
	
	/**
	 * 
	 */
    public static function uninstall_plugin() {
        global $wpdb;
        
        $sql = "DROP TABLE IF EXISTS `{$wpdb->prefix}cpd_templates`;";
        $wpdb->query( $sql );
        
        $sql = "DROP TABLE IF EXISTS `{$wpdb->prefix}cpd_elements`;";
        $wpdb->query( $sql );
    }
    
    function admin_menus() {
        add_menu_page( 'CP Designer', 'CP Designer', 8, 'cp-designer', array( &$this, 'design_page' ), CP_DESIGNER_URL .'css/img/cpd_logo.png' );
		$page = add_submenu_page( 'cp-designer', 'Contact page visual designer', 'Design', 8, 'cp-designer', array( &$this, 'design_page' ), 0 );
		$setting_page = add_submenu_page( 'cp-designer', 'Contact page form setting', 'Settings', 8, __FILE__, array( &$this, 'setting_page' ) );
		
		add_action( 'admin_print_styles-'. $page, array( &$this, 'add_admin_styles' ) );
		add_action( 'admin_print_scripts-'. $page, array( &$this, 'add_admin_scripts' ) );
		add_action( 'admin_print_styles-'. $setting_page, array( &$this, 'add_setting_styles' ) );
    }
	
	function init() {
		add_action("wp_ajax_popup_ajax", array(&$this, 'ajax_request_handle'));
		wp_enqueue_style( "{$this->_name}-reset-css", CP_DESIGNER_URL .'css/resets.css' );        
        wp_enqueue_style( "{$this->_name}-admin-css", CP_DESIGNER_URL .'css/admin.css' );  
		wp_enqueue_style( "{$this->_name}-custom-css", CP_DESIGNER_URL .'css/_custom.css' );
		wp_enqueue_style( "jquery-ui", CP_DESIGNER_URL .'css/ui-custom/jquery-ui-1.8.16.custom.css' );
		
		wp_enqueue_script( 'jquery' ); 		
		wp_enqueue_script( "jquery-ui", CP_DESIGNER_URL .'js/jquery-ui.min.js', false, '1.8.18' );
		// handle administrator
		if ( is_admin() )  {
			add_action( 'admin_menu', array( &$this, 'admin_menus' ) );  
			// add custom media button
			add_filter( 'media_buttons_context', array( &$this, 'add_media_button' ) );
			// add cp-designer shortcode popup
			add_action( 'admin_footer', array( &$this, 'add_shortcode_popup' ) );
			// add ajax handlers
			add_action( "wp_ajax_cp_designer_save_template", array( &$this, 'save_template' ) );
			add_action( "wp_ajax_cp_designer_get_templates", array( &$this, 'get_templates' ) );
			add_action( "wp_ajax_cp_designer_get_template", array( &$this, 'get_template' ) );
			add_action( "wp_ajax_cp_designer_make_default", array( &$this, 'set_default_template' ) );
			add_action( "wp_ajax_cp_designer_delete_template", array( &$this, 'delete_template' ) );
		} else {
			wp_enqueue_script( "jquery-infieldlabel", CP_DESIGNER_URL .'js/jquery.infieldlabel.min.js', false, '1.7.1' );
			wp_enqueue_script( "cpd_doc_ready", CP_DESIGNER_URL .'js/cpd_doc_ready.js' );
			wp_enqueue_script( "{$this->_name}-formvalidation", CP_DESIGNER_URL .'js/formvalidation.js' );
			$options = $this->get_option( 'general_settings' );
			if( $options['popup_status'] == 1 && $options['template'] != '' && ( $options['popup_source'] != '' || $options['auto_display'] == '1' ) ){
				wp_enqueue_script( "jquery-fancybox", CP_DESIGNER_URL .'js/jquery.fancybox.js' );
				wp_enqueue_script( "{$this->_name}-popup", CP_DESIGNER_URL .'js/popup.js' );
				wp_enqueue_style( "jquery-fancybox", CP_DESIGNER_URL .'css/jquery.fancybox.css' );
				wp_enqueue_style( "{$this->_name}-popup", CP_DESIGNER_URL .'css/popup.css' );
				add_action( 'wp_footer', array( &$this, 'add_contact_form' ) );
				
			}else{
				
			}
		}
		
		// handle submit
		$cpd_action = isset( $_POST['cp_designer'] ) ? $_POST['cp_designer'] : '';
		if ( $cpd_action == 'contact_us' )
			$this->contact_us();
		else if ( $cpd_action == 'update-setting' )
			$this->update_setting();
	}
    
    function add_admin_styles() {
//        wp_enqueue_style( "jquery-ui", CP_DESIGNER_URL .'css/ui-custom/jquery-ui-1.8.16.custom.css' );
        wp_enqueue_style( "colorpicker", CP_DESIGNER_URL .'js/colorpicker/css/colorpicker.css' );
		wp_enqueue_style( "thickbox" );
    }
    
    function add_admin_scripts() {  
		wp_enqueue_script( 'thickbox' );
		
        wp_enqueue_script( "colorpicker-js", CP_DESIGNER_URL .'js/colorpicker/js/colorpicker.js' );
        wp_enqueue_script( "{$this->_name}-admin-script", CP_DESIGNER_URL .'js/admin.js' );        
    }
	
	function add_setting_styles() {
		wp_enqueue_style( "{$this->_name}-admin-setting", CP_DESIGNER_URL .'css/admin-setting.css' );        
	}
    
	function add_media_button( $context ) {
		$button_image = CP_DESIGNER_URL .'/css/img/cpd_logo.png';
		$media_button = "<a href='#TB_inline?width=450&inlineId=cpd_shortcode_popup' id='cpd_media_button' class='thickbox' title='Insert contact page'><img src='$button_image' /></a>";
		
		return $context. $media_button;
	}
	function add_contact_form(){
		$options = $this->get_option('general_settings');
		if( $options['popup_status'] == 1 && $options['template'] != '' && ( $options['popup_source'] != '' || $options['auto_display'] == '1' ) ){
			$template = new ContactFormTemplate(); 
			if( FALSE == $template->load_byName( $options['template'] ) )
				return '';
			ob_start();
			$template->to_html( $this->_success, $this->_errors, '1' );
			$content = ob_get_contents();
			
			ob_clean();
			echo '<div id="cpd_contact_form_container">';
			echo '<input type="hidden" id="cpd_auto_display" value="'.$options['auto_display'].'" />';
			echo '<input type="hidden" id="cpd_event_source" value="'.$options['popup_source'].'" />';
			echo '<input type="hidden" id="cpd_is_home" value="'.$GLOBALS['wp_query']->is_home.'" />';
			echo $content;
			echo '</div>';
		}
	}
	function add_shortcode_popup() {
		$templates = ContactFormTemplate::get_templates();
		?>
		<div id="cpd_shortcode_popup" style="display:none;">
			<p>Please choose the contact page template you want to insert.</p>
			<div>
				Template:&nbsp;
				<select id="cpd_template">
					<?php 
					foreach ( $templates as $tmp )
						echo "<option value='{$tmp->tmp_name}'>{$tmp->tmp_name}</option>";
					?>
				</select>			
				<input type="button" id="insert_cpd_shortcode" value="Insert" style="margin-left: 20px;"/>			
			</div>
		</div>		
		<script type="text/javascript" language="javascript">
			jQuery('#insert_cpd_shortcode').click(function(e) {					
//				parent.tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[cp_designer template="' + jQuery('#cpd_template').val() + '"]');
				window.send_to_editor('[cp_designer template="' + jQuery('#cpd_template').val() + '"]');
				//Close window
				parent.jQuery("#TB_closeWindowButton").click();					
			});
		</script>
		<?php
	}
	
	/**
	 * handle CP Designer->Design 
	 */
    function design_page() {
        require_once( 'admin-design.php' );
    }
	
	/**
	 * handle CP Designer->Settings 
	 */
	function setting_page() {
		require_once( 'admin-setting.php' );
	}
    
	public static function get_default_options() {
		$options = array( 'general_settings' => array(
			'mail_fromaddr' => 'no-email@contact',
			'mail_toaddr' => get_settings('admin_email'),
			'mail_subject' => 'Contact Request',
			'success_msg' => 'Contact request was sent successfully.',
			'error_msg' => 'Sorry. The problem occured while sending message.'
		) );
		return $options;
	}
	
    public static function get_option( $key, $default = false ) {        
        if ( $default === false) {
			$default_options = self::get_default_options();
            return get_option( self::$_name .'-' .$key,  $default_options[$key] );			
		}
        else
            return get_option( self::$_name .'-' .$key,  $default );
    }
    
    public static function update_option( $key, $value ) {
        
        if ( get_option( self::$_name .'-' .$key , '' ) == '' ) {
			$default_options = self::get_default_options();
			add_option( self::$_name .'-' .$key, $default_options[$key] );
		}
        update_option( self::$_name .'-' .$key, $value );
    }
    
    public static function delete_option( $key ) {
        delete_option( self::$_name .'-' .$key );
    }
    
    function save_template() {        
        $template = new ContactFormTemplate( $_POST ); 
        $template->save();
        
        die();
    }
    
    function get_templates() {
        $templates = ContactFormTemplate::get_templates();
        
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<response>';
        foreach ( $templates as $tmp ) :
            echo '<template>';
                echo '<id>'.$tmp->id.'</id>';
                echo '<name>'.$tmp->tmp_name.'</name>';
                echo '<active>'.$tmp->active.'</active>';
            echo '</template>';
        endforeach;
        echo '</response>';
        die();
    }
    
    function get_template() {
        $template = new ContactFormTemplate(); 
        $template->load( $_POST['tmpid'] );
        $template->to_xml();
        die();
    }
    
    function set_default_template() {
        $tmp_name = $_POST['tmp_name'];
        if ( $tmp_name != '' )
            $this->update_option( 'default_template', $tmp_name );
        die();
    }
	
	function delete_template() {
		$tmp_id = $_POST['form'];
		ContactFormTemplate::delete_template_byId( $tmp_id );
		die();
	}
    
    function handle_shortcodes( $atts ) {
        if ( $atts['template'] == '' )
			return '';
		
		$template = new ContactFormTemplate(); 
		if( FALSE == $template->load_byName( $atts['template'] ) )
			return '';
		ob_start();
		$template->to_html( $this->_success, $this->_errors, '0' );
		$content = ob_get_contents();
		ob_clean();
		$content = "<div id='cpd_page_container'>{$content}</div>";
		return $content;
    }

	function update_setting() {
		$keys = array( 
			'mail_fromaddr',
			'mail_toaddr', 
			'mail_subject', 
			'mail_cc',
			'success_msg',
			'error_msg',
			'captcha_pubkey', 
			'captcha_privkey',
			'mailchimp_apikey',
			'mailchmip_list_id',
			'popup_status',
			'popup_source',
			'auto_display',
			'template'
		);
		$options = array();
		foreach ( $keys as $key ) {
			$options[$key] = isset( $_POST[$key] ) ? $_POST[$key] : '';
		}
		$this->update_option( 'general_settings', $options );
	}
	
	function contact_us() {	
		if ( !check_admin_referer( 'cpd_form', 'cpd_security_key' ) )
			return FALSE;
		$temp_id = $_POST['tmpid'];
		$template = new ContactFormTemplate(); 
        $result = $template->load( $temp_id );
        if ( $result == FALSE )
			return;
		$errors = array();
		$emails = array();
		$msg = $template->to_mail( $_POST, $errors, $emails );
		
//		var_dump( $msg );
		
		if ( $msg === FALSE ) {
			$this->_errors[$temp_id] = $errors; 
		} else {
			$options = CPDesigner::get_option( 'general_settings' );
			
			$headers = array(
				"from: {$options['mail_fromaddr']}",
				"cc: {$options['mail_cc']}",
				"content-type: text/html; charset=UTF-8",
			);
			$result = wp_mail( $options['mail_toaddr'], $options['mail_subject'], $msg, $headers );		
			if( $result ) 
				$this->_success[$temp_id] = $options['success_msg'];
			else
				$this->_errors[$temp_id] = array( $options['error_msg'] );			
		}
	}
	
	public function insert_choise() {
        $return = array();
        $vars = array(
            "Days of the Week",
            'Months of the Year',
            'Age',
            'Years (1930+)',
            'Continents',
            'US States',
            'EU Countries',
            'World Countries'
        );
        foreach ($vars as $key => $value) {
            $return[$value] = $this->choise($key);
        }
        return $return;
    }

    protected function choise($num) {
        $array = array(
            $this->read_file_as_array('days'),
            $this->read_file_as_array('months'),
            $this->read_file_as_array('age'),
            $this->for_count(date('Y')),
            $this->read_file_as_array('Continents'),
            $this->read_file_as_array('us-states'),
            $this->read_file_as_array('eu-states'),
            $this->read_file_as_array('world-states')
        );
        return $array[$num];
    }

    public function read_file_as_array( $file ) {
        $html_content = file_get_contents( CP_DESIGNER_PATH .'/importdata/' .$file .'.txt' );
        return preg_split( '/\r\n|\r|\n/', $html_content );
    }

    protected function for_count($number) {
        $arr = array();
        for ($i = 1930; $i <= $number; $i++) {
            $arr[] = $i;
        }
        return $arr;
    }

    protected function edit_address() {
        return array(
            'us-states' => $this->read_file_as_array('us-states'),
            'eu-states' => $this->read_file_as_array('eu-states'),
            'world-states' => $this->read_file_as_array('world-states')
        );
    }
	function ajax_request_handle(){
		if ( !check_admin_referer( 'cpd_form', 'cpd_security_key' ) )
			return FALSE;
		$temp_id = $_POST['tmpid'];
		$template = new ContactFormTemplate(); 
        $result = $template->load( $temp_id );
        if ( $result == FALSE )
			return;
		$errors = array();
		$emails = array();
		$msg = $template->to_mail( $_POST, $errors, $emails );
		
//		var_dump( $msg );
	
		if ( $msg === FALSE ) {
			$this->_errors[$temp_id] = $errors; 
		} else {
			$options = CPDesigner::get_option( 'general_settings' );
			
			$headers = array(
				"from: {$options['mail_fromaddr']}",
				"cc: {$options['mail_cc']}",
				"content-type: text/html; charset=UTF-8",
			);
			$result = wp_mail( $options['mail_toaddr'], $options['mail_subject'], $msg, $headers );	
			if( $result ){
				echo json_encode( array( 
					'success' => 'OK',
					'msg' => $options['success_msg']
				) );
			}else{
				echo json_encode( array( 
					'success' => 'FAIL',
					'msg' => $options['error_msg']
				) );
			}
			exit;
		}
	}
	
}
new CPDesigner();
?>