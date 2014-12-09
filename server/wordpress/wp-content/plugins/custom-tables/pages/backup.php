<?php

// Nobody should be in this file without going trought WordPress
if (!isset($wpdb)) exit();

if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
	if ($_FILES['userfile']['error']) {
		switch ($_FILES['userfile']['error']) {
			case 1:
			case 2: echo __('Filesize is higher than your PHP installation allows, please contact your Hostingpartner', 'wct'); break;
			case 3: echo __('Fileupload was interupted and only a part of the file was uploaded' , 'wct'); break;
			case 4: echo __('No file was uploaded?!?', 'wct'); break;
		}
	}
	else {
		if ($_FILES['userfile']['type'] == 'text/wct') {
			$handle = fopen ($_FILES['userfile']['tmp_name'], 'r');
			$content = fread($handle, filesize($_FILES['userfile']['tmp_name']));
			if (strpos($content,"WordPress Custom Tables Backup") !== false) {
				eval($content);
				echo __('Backup File has been imported.', 'wct');
			}
			else {
				echo __('Backup File need to be from Custom Tables Plugin!', 'wct');
			}
			fclose($handle);
		}
		else {
			echo __('Please upload only valid Custom Tables Backup Files!', 'wct');
		}
		unlink($_FILES['userfile']['tmp_name']);
	}
}

$c = md5("fDe-,".time()."w");
$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_list` set `secret`='".$c."' WHERE `id`='0' LIMIT 1;");

echo "<div style=\"width:350px;\"><h2>" . __('Backup', 'wct') ."</h2>
	<a style=\"text-decoration:none;\" target=\"_blank\" href=\"".plugins_url('custom-tables/dl.php')."?s=".$c."\"><img src=\"".plugins_url('custom-tables/img/dbbackup.png')."\" border=\"0\" alt=\"Excel\" /> ".__('Take Backup of Settings and all Tables','wct')."</a></div>
	<div style=\"float:left;width:350px;height:300px;\"><h2>" . __('Restore', 'wct') ."</h2>
	<form enctype=\"multipart/form-data\" action=\"admin.php?page=wct_backuprestore\" method=\"post\">".
	__('Please select Backup File to upload and restore', 'wct').": <input name=\"userfile\" type=\"file\" value=\"\">
	<input type=\"submit\" name=\"fileupload\" value=\"". __('Upload File', 'wct')."\"></form></div>";

?>