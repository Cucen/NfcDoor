<?php

echo "<div style=\"position: absolute; left:775px;width:312px;background-color:#a7c7de;text-decoration:none;z-index:1;padding:0 0px 0 6px;height:50px;line-height:22px;display:block;text-shadow:rgba(255,255,255,0.7) 0 1px 0;\">
<a style=\"text-decoration:none;\" href=\"http://wuk.ch/?piwik_campaign=plugin&piwik_kwd=custom-tables\" rel=\"external\" target=\"_blank\"><img src=\"".plugins_url('custom-tables/img/wuk.png')."\" alt=\"web updates kmu\" border=\"0\" align=\"left\" style=\"padding-right:10px;\"/>". __('The WordPress Specialists', 'wct')."</a>
</div>";
if ($_GET['page'] == 'custom-tables/custom-tables.php') {
	echo "<div style=\"position: absolute; left:650px;min-width:50px;background-color:#e4e4e4;text-decoration:none;z-index:1;padding:0 0px 0 6px;height:25px;line-height:22px;display:block;\"><center><a style=\"text-decoration:none;\" href=\"plugin-editor.php?file=custom-tables/custom-tables.php\">". __('Edit Plugin', 'wct')."</a>&nbsp;</center></div>";
}
else {
	echo "<div style=\"position: absolute; top:5px;left:680px;width:100px;z-index:1;padding:0 0px 0 6px;height:38px;line-height:38px;display:block;\"><center><g:plusone href=\"http://wuk.ch/\"></g:plusone></center></div><script type=\"text/javascript\"> window.___gcfg = {lang: 'de'}; (function() { var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/plusone.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();</script>";
}

/* Messages for Donations */
if ($_GET['wcthide'] != '') {
	$this->settings['nhide'] = $_GET['wcthide'];
	update_option('wuk_custom_tables', $this->settings);
}

$url = $this->generate_pagelink("/[&?]+wcthide=[1-3]*&/","");

if ($this->prem_chk() !== true AND $this->settings['installed'] <= (time()-(60*60*24*30)) AND $this->settings['nhide'] == '') {
	echo "<div class=\"updated\" style=\"width:610px;\"><strong><p>";
	printf( __('Thanks for using this plugin! You\'ve installed this plugin over a month ago. If it works and you are satisfied with the results, isn\'t it worth at least a few dollar? <a href="%s">Donations</a> help me to continue free support and development of this plugin! <a href="%s">Sure, no problem!</a>','wct'),"admin.php?page=wct_support","admin.php?page=wct_support");
	echo "<a href=\"".$url."wcthide=2\" style=\"float:right; display:block; border:none; margin-left:10px;\"><small style=\"font-weight:normal;\">".__('Sure, but I already did!', 'wct')."</small></a> <a href=\"".$url."wcthide=3\" style=\"float:right; display:block; border:none;\"><small style=\"font-weight:normal;\">".__('No thanks, please don\'t ask me anymore!', 'wct')."</small></a></p></strong>
	<div style=\"clear:right;\"></div></div>";

} 
elseif ($this->prem_chk() === true AND $this->settings['nhide'] != '1' AND $this->settings['nhide'] != '4') {
	echo "<div class=\"updated\" style=\"width:610px;\"><strong><p>".__('Thank you very much for your donation. You help me to continue support and development of this plugin and other free software!','wct')."
	<a href=\"".$url."wcthide=1\" style=\"float:right; display:block; border:none; margin-left:10px;\"><small style=\"font-weight:normal;\">".__('Hide this notice', 'wct')."</small></a></p></strong></div>";
}
elseif (class_exists('ckeditor_wordpress') AND $this->settings['nhide'] != '4') {
	echo "<div class=\"updated\" style=\"width:610px;\"><strong><p>";
	echo __('This plugin is not comppatible with CKEditor. You can use both plugins, but are not able to use the Editor Features for easy handling the fields and setup.','wct');
	echo "<a href=\"".$url."wcthide=4\" style=\"float:right; display:block; border:none; margin-left:10px;\"><small style=\"font-weight:normal;\">".__('Sure, but don\'t remind me!', 'wct')."</small></a></p></strong>
	<div style=\"clear:right;\"></div></div>";
}

?>