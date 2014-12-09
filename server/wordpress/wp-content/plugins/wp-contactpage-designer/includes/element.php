<?php

abstract class FormElement {
    protected $_tag;
    protected $_param;
	protected $_css;
    protected $_text;
	protected $_value;
    
    function __construct( $param, $css, $text, $value ) {
		$this->_param = $param;
		$this->_css = $css;
		$this->_text = $text;
		$this->_value = $value;
    }
	
	function get_style() {
		$el_style = '';
		foreach ( array_slice( $this->_css, 2 ) as $style => $css ) :
			$el_style .= $style . ':' . $css . ';';
		endforeach;
		
		return $el_style;
	}
	
	function get_list_style() {
		$el_style = 'position:absolute; list-style-type:none;';
		foreach ( array_slice( $this->_css, 0, 2 ) as $style => $css )
			$el_style .= $style . ':' . $css . ';';
		return $el_style;
	}
	
	public function get_type() {
		return $this->_param['type'];
	}
	
	public function get_name() {
		return $this->_param['name'];
	}
	
	public function is_required() {
		return stripos( $this->_param['class'], 'required' ) !== FALSE || $this->_param['required'] == 'required';
	}
	
	public function to_html() {
		if ( $this->is_required() )
			echo "<li style='" .$this->get_list_style() ."' class='required'>";
		else
			echo "<li style='" .$this->get_list_style() ."'>";
		
		$this->html_content();
		echo "</li>";
	}
	
	public function form_content() {
		$this->html_content();
	}	
	
	public function to_form() {
		if ( $this->is_required() )
			echo "<li style='" .$this->get_list_style() ."' class='required'>";
		else
			echo "<li style='" .$this->get_list_style() ."'>";
		$this->form_content();
		echo "</li>";
	}
	
	abstract function html_content();		
	
	public function to_mail( $post_data ) {
		return "<tr>
					<th style='padding-right:20px;'>{$this->_param['name']}</th>
					<td>{$post_data[$this->_param['name']]}</td>
				</tr>";			
	}
}

class OtherElement extends FormElement {
    
	public function html_content() {
		echo "<{$this->_param['tag']} name='{$this->_param['name']}' style='" .$this->get_style() ."' >" .stripslashes( $this->_text ) ."</{$this->_param['tag']}>";
	}

	public function to_mail( $post_data ) {
		if ( $this->_param['tag'] == 'P' || $this->_param['tag'] == 'SELECT' )
			return parent::to_mail ( $post_data );
		else
			return '';
	}
}

class InputElement extends FormElement {
    
	public function html_content() {
		if ( $this->_param['class'] == 'required' )
			echo "<input class='required' placeholder='{$this->_param['placeholder']}' title='{$this->_param['title']}' style='" .$this->get_style() . "' type='{$this->_param['type']}' value='{$this->_value}' name='{$this->_param['name']}' />";
		else
			echo "<input placeholder='{$this->_param['placeholder']}' title='{$this->_param['title']}' style='" .$this->get_style() . "' type='{$this->_param['type']}' value='{$this->_value}' name='{$this->_param['name']}' />";
	}
	
	public function to_mail( $post_data ) {
		if ( $this->_param['type'] == 'submit' )
			return '';
		else
			return parent::to_mail( $post_data );
	}
}

class TextAreaElement extends FormElement {
    
	public function html_content() {
		if ( $this->_param['class'] == 'required' )
			echo "<TEXTAREA placeholder='{$this->_param['placeholder']}' class='required' name='{$this->_param['name']}' style='" . $this->get_style() . "'>{$this->_text}</TEXTAREA>";		
		else
			echo "<TEXTAREA placeholder='{$this->_param['placeholder']}' name='{$this->_param['name']}' style='" . $this->get_style() . "'>{$this->_text}</TEXTAREA>";		
	}
}

class ImageElement extends FormElement {
    
	public function html_content() {
		echo "<img style='position:relative;" .$this->get_style() ."' src='{$this->_param['src']}' />";
	}
	
	public function to_mail( $post_data ) {
		return '';
	}
}

class MapElement extends FormElement {
    
	public function form_content() {
		echo "<img src='{$this->_param['src']}' />";
	}
	
	public function html_content() {
		echo "<img class='map' src='{$this->_param['src']}' />";
	}
	
	public function to_mail( $post_data ) {
		return '';
	}
}

class DateElement extends FormElement {
    
	public function html_content() {
		$required = $this->_param['required'] == 'required' ? "class='required'" : '';
		echo "<div class='date' data='CreateDate' format='{$this->_param['format']}' $required><input $required placeholder='{$this->_param['placeholder']}' style='" .$this->get_style() . "' type='text' name='{$this->_param['name']}' /></div>";
	}
}
?>
