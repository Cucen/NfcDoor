<?php
// Fix for qtranslate
if (has_filter('the_editor', 'qtrans_modifyRichEditor')) {
	remove_filter('the_editor', 'qtrans_modifyRichEditor');
}

echo "<style type=\"text/css\">
.theEditor { color: black !important; }";

if (get_bloginfo('version','raw') >= '3.3') {
	if ($_GET['wcttab'] == "content" OR (strpos("wct_form",$_GET['page']) !== false AND $_GET['wcttab'] != "eviw")) {
		echo "
		#editorcontainer { width: 820px !important; }
		#quicktags { width: 820px !important;visibility:hidden !important; display:none !important; }
		#ed_toolbar { visibility:hidden !important; display:none !important; }
		textarea { width:220px !important;}";
	}
	else {
		echo "
		.wp-editor-area, .wp-editor-tools { width: 710px !important; }
		#content { width: 720px !important; }
		#qt_content_toolbar { width: 703px !important;visibility:visible !important; display:block !important; 
		#edButtonHTML { visibility:hidden !important;  }
		#edButtonPreview { visibility:hidden !important; }";
	}

}
else {
	if ($_GET['wcttab'] == "content" OR (strpos("wct_form",$_GET['page']) !== false AND $_GET['wcttab'] != "eviw")) {
		echo "
		#editorcontainer { width: 820px !important; }
		#quicktags { width: 820px !important;visibility:hidden !important; display:none !important; }
		#ed_toolbar { visibility:hidden !important; display:none !important; }
		textarea { width:820px !important;}";
	}
	else {
		echo "
		#editorcontainer { width: 720px !important; }
		#quicktags { width: 720px !important;visibility:visible !important; display:block !important; }
		#ed_toolbar { visibility:visible !important; display:block !important; }
		#edButtonHTML { visibility:hidden !important;  }
		#edButtonPreview { visibility:hidden !important; }";
	}
}
echo "</style>";
add_filter('admin_head', array( &$this, 'ShowTinyMCE'));

?>