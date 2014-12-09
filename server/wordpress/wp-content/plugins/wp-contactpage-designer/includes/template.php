<?php
require_once( 'element.php' );

class ContactFormTemplate {
    private $_id;
    private $_name;
    private $_size;
	private $_css;
    private $_elements;
	private $_form_elements;
    
    function __construct( $options = array() ) {
        $this->_id = '';
        $this->_name = $options['tmp_name'];
		$this->_css = $options['tmp_css'];
//        $this->_size = $options['tmp_size'];
        
        // get elements
        $index = 0;
        $this->_elements = array();
        
        while ( array_key_exists( $index, $options ) ) {
            $this->_elements[] = $options[$index];
            $index++;
        }
    }
	
	function create_element( $options ) {
		$new_param = array();
		$new_css = array();
		
		$element_css = explode('||',$options->css);
		foreach ($element_css as $css) :
			$css = explode( '::', $css );
			$new_css[$css[0]] = $css[1];
		endforeach;

		$element_params = explode('||',$options->params);
		foreach ($element_params as $param) :
			$param = explode('::',$param);
			$new_param[$param[0]] = $param[1];
		endforeach;

		switch ( $new_param['tag'] ) :
			case 'INPUT' :
				$element = new InputElement( $new_param, $new_css, $options->text, $options->value );
				break;
			case 'IMG' :
				if ( $new_param['class'] == 'captcha' ) {
					$options = CPDesigner::get_option( 'general_settings' );					
					$element = new CaptchaElement( $new_param, $new_css, $options->text, $options->value );
					$element->set_key( $options['captcha_pubkey'], $options['captcha_privkey'] );
				} else if ( $new_param['class'] == 'map' ) {
					$element = new MapElement( $new_param, $new_css, $options->text, $options->value );
				} else {
					$element = new ImageElement( $new_param, $new_css, $options->text, $options->value );
				}
				break;
			case 'TEXTAREA':
				$element = new TextAreaElement( $new_param, $new_css, $options->text, $options->value );
				break;
			case 'DIV' :
				$data = $new_param['data'];				
				$options->value = empty( $options->value ) ? 'world-states' : $options->value;
				if ($data == 'CreateDate')
					$element = new DateElement( $new_param, $new_css, $options->text, $options->value );	
				break;
			default:
				$element = new OtherElement( $new_param, $new_css, $options->text, $options->value );
		endswitch;
		
		return $element;
	}
    
    public function load( $template_id ) {  
        global $wpdb;
        
        $template = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}cpd_templates WHERE id={$template_id}" ) );
        if ( is_null( $template ) )
            return FALSE;
        $this->_id = $template_id;
        $this->_name = $template->tmp_name;
        $this->_css = $template->tmp_css;
//        $this->_size = $template->tmp_size;
        
        $elements = $wpdb->get_results( $wpdb->prepare( "SELECT css, text, value, params FROM {$wpdb->prefix}cpd_elements WHERE tmp_id={$template_id}" ) );
		
        $this->_form_elements = array();		
        foreach ($elements as $k => $element) {		
			$form_element = $this->create_element( $element );
			if ( !is_null( $form_element ) )
				$this->_form_elements[] = $form_element;
		}
		return TRUE;
    }
    
    public function load_byName( $name ) {
        global $wpdb;
        
        $template = $wpdb->get_row( $wpdb->prepare( "SELECT id FROM {$wpdb->prefix}cpd_templates WHERE tmp_name='{$name}'" ) );
        if ( is_null( $template ) )
            return FALSE;
        return $this->load( $template->id );
    }
    
    public function save() {
        global $wpdb;
        
        // delete old template
        self::delete_template_byName( $this->_name );
        
        // create new template
        $wpdb->insert( "{$wpdb->prefix}cpd_templates",
                array( 'tmp_name' => $this->_name, 'tmp_css' => $this->_css ),
                array( '%s', '%s' )
        );
        
        // save template elements
        $this->_id = $wpdb->insert_id;
        foreach ( $this->_elements as $element ):
            $wpdb->insert( "{$wpdb->prefix}cpd_elements",
                array( 
                    'css' => $element['css'], 
                    'text' => $element['text'], 
                    'value' => $element['value'], 
                    'params' => $element['param'], 
                    'tmp_id' => $this->_id 
                ),
                array( '%s', '%s', '%s', '%s', '%d' )
            );
        endforeach;
    }
    
    public static function get_templates() {
        global $wpdb;
        
        $query = "SELECT * FROM `{$wpdb->prefix}cpd_templates` ";
        $templates = $wpdb->get_results( $wpdb->prepare( $query ) );
        
        return $templates;
    }
    
    public static function delete_template_byId( $id ) {
        global $wpdb;
        
        $query = "DELETE FROM `{$wpdb->prefix}cpd_templates` WHERE `id` = '{$id}' ";
        $wpdb->query( $wpdb->prepare( $query ) );
        
        $query = "DELETE FROM `{$wpdb->prefix}cpd_elements` WHERE `tmp_id` = '{$id}' ";
        $wpdb->query( $wpdb->prepare( $query ) );
    }
    
    public static function delete_template_byName( $tmp_name ) {
        global $wpdb;
        
        $query = "SELECT id FROM `{$wpdb->prefix}cpd_templates` WHERE `tmp_name` = '{$tmp_name}' ";
        $template_id = $wpdb->get_var( $query );
        if ( !is_null( $template_id ) )
            self::delete_template_byId( $template_id );
    }
    
    public function to_xml() {
//		$size = explode(':', $this->_size );
		
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<response>';
//		echo '<tmp_size>';
//			echo "<height>{$size[1]}</height>";
//			echo "<width>{$size[0]}</width>";
//		echo '</tmp_size>';
		echo "<tmp_name><![CDATA[{$this->_name}]]></tmp_name>";
		echo "<tmp_css><![CDATA[" .stripslashes( $this->_css ) ."]]></tmp_css>";
		
		foreach ($this->_form_elements as $element) :
			echo '<element><![CDATA[';
			$element->to_html();
			echo ']]></element>';
		endforeach;
		echo '</response>';
    }
	
	public function to_html( $success, $errors, $is_popup='0' ) {
//		require_once( CP_DESIGNER_PATH .'/includes/libs/captcha/recaptchalib.php' );
		
//		$size = explode( ':', $this->_size );
//		$size = "width:{$size[0]}px; height:{$size[1]}px; padding:0; margin:0;";
		?>
		<div class="CPD">			
			<form id="cpdFormSumit" method="post" onsubmit="return CPD.valudateForm(this.id);" >
				<?php
				if ( array_key_exists( $this->_id, $success ) ) {
					echo "<div class='submit-success'>";					
					echo $success[$this->_id];				
					echo "</div>";
				}
				if ( array_key_exists( $this->_id, $errors ) ) {
					echo "<div class='submit-error'>";					
					echo implode( '<br/>', $errors[$this->_id] );					
					echo "</div>";
				}
				?>
				<ul style='position: relative;<?php echo stripslashes( $this->_css ); ?>'>
					<?php 
					foreach ( $this->_form_elements as $element ) {
						$element->to_form();
					}
					?>
				</ul>
				<input type="hidden" name="tmpid" value="<?php echo $this->_id;?>" />
				<input type="hidden" name="cp_designer" value="contact_us"/>
				<?php wp_nonce_field( 'cpd_form', 'cpd_security_key' ); ?>
			</form>
			<script type="text/javascript" language="javascript">
				jQuery(document).ready(function(){
					try{
						CPD = new CPD();
						CPD.init({
							isPopup:<?php echo '"' .$is_popup .'"';?>,
							baseUrl: <?php echo '"' .CP_DESIGNER_URL .'"';?>,						
							ajaxUrl: <?php echo '"' .  admin_url('admin-ajax.php') .'"';?>						
						});
					}catch(e){
						
					}
					
				});  
			</script>
		</div>
		<?php
    }
	
	public function to_mail( $post_data, &$errors, &$emails ) {
//		require_once( CP_DESIGNER_PATH .'/includes/libs/captcha/recaptchalib.php' );
		
        $required = array();
        $msg .= '<html><body><table>';
		
        foreach ( $this->_form_elements as $element ) {
            $type = $element->get_type();
			$class_name = get_class( $element );
            if ( $type == 'email' )
                $emails[] = $post_data[$element->get_name()]; 
			
            if ( $element->is_required() ) {
				if ( $class_name == 'AddressElement' ) {
					$required[] = $post_data['street_address'];
					$required[] = $post_data['street_address2'];
					$required[] = $post_data['cityAddress'];
					$required[] = $post_data['regionAddress'];
					$required[] = $post_data['zipCodeAddress'];
					$required[] = $post_data['CountryAddress'];
				} else {
					$required[] = $post_data[$element->get_name()];
				}
			}
			
            if ( $class_name == 'CaptchaElement' ) {
				if ( !$element->is_valid( $post_data['recaptcha_challenge_field'], $post_data['recaptcha_response_field'] ) )
					$errors[] = 'Please input the correct captcha code';
			}
			
			$msg .= $element->to_mail( $post_data );
        }
		$msg .= '</table></body></html>';

        if ( @in_array( "", $required ) ) {
			$errors[] = 'Please fill the required fields!';
        }
		
		if ( count( $errors ) > 0 )
			return FALSE;
		
		return $msg;
    }

    protected function replace_tags($string) {
        preg_match_all("/\{(.*?)\}+/", $string, $res);

        $streplace = array();
        if (is_array($res[1])) {
            foreach ($res[1] as $val):
                if (array_key_exists($val, $_POST)) {
                    $streplace["{" . $val . "}"] = $_POST[$val];
                }
                if ($val == 'br') {
                    $streplace["{" . $val . "}"] = '\n';
                }

            endforeach;
        }
        return str_replace(array_keys($streplace), array_values($streplace), $string);
    }
	
	function is_valid_mail($email){
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
}
?>
