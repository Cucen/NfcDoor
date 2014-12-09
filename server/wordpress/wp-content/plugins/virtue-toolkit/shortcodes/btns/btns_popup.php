<?php
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-widget');
wp_enqueue_script('jquery-ui-position');
wp_enqueue_script('jquery');
global $wp_scripts;
?>
<!DOCTYPE html>
<head>
<title><?php _e("Insert Button", "virtue"); ?></title>
 <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
<base target="_self" />
<?php wp_print_scripts(); ?>
<script type="text/javascript">
 
var ButtonDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ButtonDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var text = jQuery('#icon-dialog input#text').val();
		var tcolor = jQuery('#icon-dialog select#text-color').val();
		var texthex = jQuery('#icon-dialog input#text-color-hex').val();
		var bcolor = jQuery('#icon-dialog select#btn-color').val();
		var btnhex = jQuery('#icon-dialog input#btn-color-hex').val();
		var btnlink = jQuery('#icon-dialog input#btn-link').val();
		var btarget = jQuery('#icon-dialog select#btn-target').val();		 		 
		 
		var output = '';
		
		// setup the output of our shortcode
		output = '[btn ';
			output += 'text="' + text + '" ';
			if(texthex)
				output += ' tcolor=' + texthex + ' ';
				else {
					output += 'tcolor=' + tcolor + ' ';
				}
			if(btnhex) {
				output += ' bcolor=' + btnhex + ' ';
			} else {
				if(bcolor) {
					output += 'bcolor=' + bcolor + ' ';
					} else {
						output += '';
					}
			}
			output += 'link="' + btnlink +'" ';
			output += 'target="' + btarget +'"';
			output += ']';
			
		tinyMCEPopup.execCommand('mceInsertContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ButtonDialog.init, ButtonDialog);
 
</script>

<style type="text/css" media="screen"> .kad-popup {padding: 0 8px 8px; font-size: 0;} #icon-dialog {font-size: 12px;} #icon-dialog label {font-size:14px; display:block; padding:4px;} #icon-dialog label.hex {font-size:12px; line-height:24px; display:inline-block; padding:6px 4px 6px 12px;} #icon-dialog select {display:block; height:28px; width:300px; font-size:12px;} #icon-dialog input {display:block; width:300px; height:24px;} #icon-dialog input.btn-hex {display:inline-block; width:120px; height:24px;} #icon-dialog a#insert {margin-top:15px;} .linebreak {margin-bottom:6px; border-bottom: solid 1px #d7d7d7; padding-bottom:6px}

</style>

</head>
<body class="kad-popup">
	<div id="icon-dialog">
		<form action="/" method="get" accept-charset="utf-8">
        <div class="linebreak">
			<div>
				<label for="btn-text"><?php _e("Button Text", "virtue"); ?></label>
				<input type="text" name="btn_text" value="" id="text" />
			</div>
            </div>
            <div class="linebreak">
			<div>
				<label for="btn-color"><?php _e("Text Color", "virtue"); ?></label>
				<select name="btn-color" id="text-color">
                	<option value="#FFF"><?php _e("White", "virtue"); ?></option>
                    <option value="#F2F2F2"><?php _e("Off-White", "virtue"); ?></option>
                	<option value="#000"><?php _e("Black", "virtue"); ?></option>
                    <option value="#CDCDCD"><?php _e("Light-Gray", "virtue"); ?></option>
					<option value="#999"><?php _e("Gray", "virtue"); ?></option>
                    <option value="#444"><?php _e("Dark-Gray", "virtue"); ?></option>
                    <option value="#CCC"><?php _e("Silver", "virtue"); ?></option>
                    <option value="#FF0000"><?php _e("Red", "virtue"); ?></option>
                    <option value="#0000FF"><?php _e("Blue", "virtue"); ?></option>
                    <option value="#008000"><?php _e("Green", "virtue"); ?></option>
                    <option value="#FFFF00"><?php _e("Yellow", "virtue"); ?></option>
                    <option value="#FFA500"><?php _e("Orange", "virtue"); ?></option>
                    <option value="#FF00FF"><?php _e("Pink", "virtue"); ?></option>
                    <option value="#800080"><?php _e("Purple", "virtue"); ?></option>
                    <option value="#8B4513"><?php _e("Brown", "virtue"); ?></option>
                    <option value="#800000"><?php _e("Maroon", "virtue"); ?></option>
                 </select>
			</div>
            <div>
				<label class="hex" for="text-color-hex"><?php _e("Or Type Hex Color", "virtue"); ?></label>
				<input type="text"class="btn-hex" name="text-color-hex" value="" id="text-color-hex" />
			</div>
            </div>
            <div class="linebreak">
			<div>
				<label for="btn-color"><?php _e("Button Color", "virtue"); ?></label>
				<select name="btn-color" id="btn-color">
                	<option value=""><?php _e("Primary Color", "virtue"); ?></option>
                	<option value="#000"><?php _e("Black", "virtue"); ?></option>
                    <option value="#CDCDCD"><?php _e("Light-Gray", "virtue"); ?></option>
					<option value="#999"><?php _e("Gray", "virtue"); ?></option>
                    <option value="#444"><?php _e("Dark-Gray", "virtue"); ?></option>
                    <option value="#CCC"><?php _e("Silver", "virtue"); ?></option>
                    <option value="#FFF"><?php _e("White", "virtue"); ?></option>
                    <option value="#F2F2F2"><?php _e("Off-White", "virtue"); ?></option>
                    <option value="#FF0000"><?php _e("Red", "virtue"); ?></option>
                    <option value="#0000FF"><?php _e("Blue", "virtue"); ?></option>
                    <option value="#008000"><?php _e("Green", "virtue"); ?></option>
                    <option value="#FFFF00"><?php _e("Yellow", "virtue"); ?></option>
                    <option value="#FFA500"><?php _e("Orange", "virtue"); ?></option>
                    <option value="#FF00FF"><?php _e("Pink", "virtue"); ?></option>
                    <option value="#800080"><?php _e("Purple", "virtue"); ?></option>
                    <option value="#8B4513"><?php _e("Brown", "virtue"); ?></option>
                    <option value="#800000"><?php _e("Maroon", "virtue"); ?></option>
                    
                 </select>
			</div>
			<div>
				<label class="hex" for="btn-color-hex"><?php _e("Or Type Hex Color", "virtue"); ?></label>
				<input type="text" class="btn-hex" name="btn-color-hex" value="" id="btn-color-hex" />
			</div>
            </div>
            <div class="linebreak">
			<div>
				<label for="btn-link"><?php _e("Button Link", "virtue"); ?></label>
				<input type="text" name="btn-link" value="" id="btn-link" />
			</div>
            </div>
            <div class="linebreak">
			<div>
				<label for="btn-target"><?php _e("Button Link Target", "virtue"); ?></label>
				<select name="btn-target" id="btn-target">
                	<option value="_self"><?php _e("Same Window", "virtue"); ?></option>
                	<option value="_blank"><?php _e("New Window/Tab", "virtue"); ?></option>                    
                 </select>
			</div>
			</div>
			<div>	
				<a href="javascript:ButtonDialog.insert(ButtonDialog.local_ed)" id="insert" style="display: block; line-height: 24px; text-align:center"><?php _e("Insert", "virtue"); ?></a>
			</div>
		</form>
	</div>
</body>
</html>