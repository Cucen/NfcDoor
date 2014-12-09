<?php
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-widget');
wp_enqueue_script('jquery-ui-position');
wp_enqueue_script('jquery');
global $wp_scripts;
?>
<!DOCTYPE html>
<head>
<title><?php _e("Insert Video", "virtue"); ?></title>
 <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
<base target="_self" />
<?php wp_print_scripts(); ?>
<script type="text/javascript">
 var url = '<?php echo plugins_url(); ?>';
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
		var video = jQuery('#icon-dialog textarea#video').val();
		var width = jQuery('#icon-dialog input#width').val(); 		 
		 
		var output = '';
			if(width)
			output += '<img src="'+url+'/virtue-toolkit/images/t.gif" class="kadvideo mceItem" title="video width='+width+'" />';
			else {
			output += '<img src="'+url+'/virtue-toolkit/images/t.gif" class="kadvideo mceItem" title="video" />';
			}
			output += video;
			output += '<img src="'+url+'/virtue-toolkit/images/t.gif" class="kadvideoend mceItem" title="/video" />';
			
		tinyMCEPopup.execCommand('mceInsertContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ButtonDialog.init, ButtonDialog);
 
</script>
<style type="text/css" media="screen"> #icon-dialog label {font-size:12px; display:block; padding:4px;}  #icon-dialog textarea#video{display:block; height:100px; width:270px; font-size:10px;} #icon-dialog input#width{display:inline-block; height:25px; width:100px; font-size:12px; margin-bottom:10px;} #icon-dialog a#insert {margin-top:10px;}

</style>

</head>
<body>
	<div id="icon-dialog">
		<form action="/" method="get" accept-charset="utf-8">
        	<div>
				<label for="tabs"><?php _e("(Optional) Max Width", "virtue"); ?></label>
				<input type="text" name="width" value="" id="width" /><span style="display:inline-block; padding-left:5px;">(*<?php _e("note just use number", "virtue"); ?>)</span>
			</div>
			<div>
				<label for="tabs"><?php _e("Video Iframe Code", "virtue"); ?></label>
				<textarea name="video" id="video" /></textarea>
			</div>
			<div>	
				<a href="javascript:ButtonDialog.insert(ButtonDialog.local_ed)" id="insert" style="display: block; line-height: 24px; text-align:center"><?php _e("Insert", "virtue"); ?></a>
			</div>
		</form>
	</div>
</body>
</html>