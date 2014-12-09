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
		if (strtolower($_FILES['userfile']['type']) == 'text/wct' OR end(explode(".",strtolower($_FILES['userfile']['name']))) == "wct") {
			$handle = fopen ($_FILES['userfile']['tmp_name'], 'r');
			$content = fread($handle, filesize($_FILES['userfile']['tmp_name']));
			if (strpos($content,"WordPress Custom Tables") !== false) {

				// Bugfix for strange characters
				$content = explode("//",str_replace(
					array(chr(239),chr(187),chr(191)),
					'',
					$content
				),2);
				$content = "//".$content[1];

				// Do the import
				$wpdb->show_errors();
				eval($content);
				$wpdb->hide_errors();
				echo __('Backup File has been imported.', 'wct');
			}
			else {
				echo __('Backup File need to be from Custom Tables Plugin!', 'wct');
			}
			fclose($handle);
		}
		elseif (strtolower($_FILES['userfile']['type']) == 'application/sql' OR end(explode(".",strtolower($_FILES['userfile']['name']))) == "sql") {

			exit("This Feature will come soon. At the moment the creation of the table is missing.");

			$handle = fopen ($_FILES['userfile']['tmp_name'], 'r');
			$content = fread($handle, filesize($_FILES['userfile']['tmp_name']));

			// Säuberung von Unnötigem
			$content = preg_replace (array("%/\*(.*)\*/%Us","%^--(.*)\n%mU","%^$\n%mU"), array('','',''), $content);

			preg_match_all("/(TABLE|INTO) [`]{0,1}.*?[`]{0,1}\.{0,1}[`]{0,1}(.+?)[`]{0,1}\s{1}/",$content,$matches);

			//doppelte array werte noch filtern!

			foreach ($matches[2] as $var => $wert) {
				echo $wert;
			}
			$import = explode (";", mres($matches)); 
			$wpdb->show_errors();
			foreach ($import as $imp){
				if ($imp != '' && $imp != ' '){
					$wpdb->get_row($imp);
				}
			}
			$wpdb->hide_errors();
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
	<input type=\"submit\" name=\"fileupload\" value=\"". __('Upload File', 'wct')."\"></form>

<font color=\"#FF0000\"><br/>SQL Files are NOT WORKING right now,<br/>please wait for a fix!</font></div>";

echo "<div>".
	__('Here you can make a backup of all settings and tables within this plugin!','wct')."<br/><br/>".__('A restore will not delete existing tables which are not included in the backup. The restore will restore the Tables which was there by the backup and all content (it deletes existing tables with the same ID and override the content). Please make a backup befor overriding important data!')."<br/><br/>".
	__('SQL Files which containing one CREATE Table statement and then INSERT statements can be imported here, but without support by any problems. If you need to import a table within this plugin and have problems, you can buy 15 Minutes support and I will create you a wct file to import.','wct')."<br/><br/>".
	__('If you also want do have a Table within the Plugin including complete setup and Design finished, please get in support contact with me. The files provided then can also be uploaded here.','wct')."</div>";

$key = $this->prem_chk('','1');
if ($key != '') {
	$parts = explode('-',$key);
	$key = md5("wct-".$parts[1].$parts[2]);
}

echo "<div class=\"clear\"></div>
<div style=\"float:left;width:480px;\"><h2>" . __('Import', 'wct') ." CSV ".__('File','wct')."</h2><iframe scrolling=\"auto\" name=\"iframe\" src=\"".plugins_url('custom-tables/iframe.php')."?s=1&key=".$key."\" style=\"width:470px;height:420px;\"></iframe></div>".
     "<div><h2>" . __('Import', 'wct') ." ". __('Instructions', 'wct') . "</h2>".
     __('To import a CSV, make sure that you do not touch the first line in the exported CSV. Each modification will be wiped out in the import process. You cannot create new fields or rename them trotught the CSV file!','wct')."<br/><br/>".
     __('The file to import need to be saved as a CSV (Delimiter splitted) File (fields splitted with ; and optional enquoted &quot; fields). Excel is supporting this save possibility in all known versions.','wct')."</div>";


?>