<?php

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
		$wpdb->show_errors();
		if (end(explode(".",strtolower($_FILES['userfile']['name']))) == "csv" OR strtolower($_FILES['userfile']['type']) == 'text/csv' OR strtolower($_FILES['userfile']['type']) == 'application/vnd.ms-excel' OR strtolower($_FILES['userfile']['type']) == 'application/csv') {
			$handle = fopen ($_FILES['userfile']['tmp_name'], 'r');
			$i = '0';
			while ($_POST['separator'] == "s" AND ($data = fgetcsv($handle, 1000, ';', '"')) !== false) {
				$i++;
				if ($i != '1') {
					$data = preg_replace(
						array(
							"/([0-9]{2})\.([0-9]{2})\.([0-9]{4})/e",
							"/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/e",
							"/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/e"
						),
						array(
							"mktime('1','1','1','$2','$1','$3')",
							"mktime('1','1','1','$2','$3','$1')",
							"mktime('1','1','1','$1','$2','$3')"
						),
						$data);
					$query = "REPLACE INTO `".$wpdb->prefix."wct".$tableid."` VALUES (\"". mb_convert_encoding(implode("\",\"", $data),"UTF-8","Windows-1252") ."\")";
					$wpdb->get_row($query);
				}
			}
			while ($_POST['separator'] == "c" AND ($data = fgetcsv($handle, 1000, ',', '"')) !== false) {
				$i++;
				if ($i != '1') {
					$data = preg_replace(
						array(
							"/([0-9]{2})\.([0-9]{2})\.([0-9]{4})/e",
							"/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/e",
							"/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/e"
						),
						array(
							"mktime('1','1','1','$2','$1','$3')",
							"mktime('1','1','1','$2','$3','$1')",
							"mktime('1','1','1','$1','$2','$3')"
						),
						$data);
					$query = "REPLACE INTO `".$wpdb->prefix."wct".$tableid."` VALUES (\"". mb_convert_encoding(implode("\",\"", $data),"UTF-8","Windows-1252") ."\")";
					$wpdb->get_row($query);
				}
			}
			if ($i != '0') { printf(__('%s File has been imported sucessfully.', 'wct'), "CSV"); }
			else { printf(__('%s File could not imported.', 'wct'), "CSV"); }
			fclose($handle);
		}
		elseif (end(explode(".",strtolower($_FILES['userfile']['name']))) == "xml") {
			if (!$xmlObj=simplexml_load_file($_FILES['userfile']['tmp_name'],'SimpleXMLElement', LIBXML_NOCDATA)) {
				printf(__('Please upload only valid %s Files!', 'wct'), "XML");
			}

			foreach($xmlObj->content->row as $row) {
				$query = "REPLACE INTO `".$wpdb->prefix.$xmlObj->name."` VALUES (".substr($row[0],0,strlen($row[0])-1).")";
				$wpdb->get_row($query);
			}
			printf(__('%s File has been imported sucessfully.', 'wct'), "XML");
		}
		else {
			printf(__('Please upload only valid %s Files!', 'wct'), "CSV");
		}
		$wpdb->hide_errors();
		unlink($_FILES['userfile']['tmp_name']);
	}
}

$qry = $wpdb->get_row("SELECT `secret` FROM `".$wpdb->prefix."wct_list` WHERE `id`='".$tableid."' LIMIT 1;");

echo "<div style=\"width:350px;\"><h2>" . __('Export', 'wct') ." ". __('Table', 'wct') . "</h2>". __('Klick on a Icon to export table', 'wct')."<br />".
     "<a target=\"_blank\" href=\"".plugins_url('custom-tables/dl.php')."?i=".$tableid."&l=".$qry->secret."&t=csv\"><img src=\"".plugins_url('custom-tables/img/csv.gif')."\" border=\"0\" alt=\"CSV\" /></a>".
     "&nbsp;<a target=\"_blank\" href=\"".plugins_url('custom-tables/dl.php')."?i=".$tableid."&l=".$qry->secret."&t=xml\"><img src=\"".plugins_url('custom-tables/img/xml.png')."\" border=\"0\" alt=\"XML\" /></a>".
     "&nbsp;&nbsp;&nbsp;<a target=\"_blank\" href=\"".plugins_url('custom-tables/dl.php')."?i=".$tableid."&l=".$qry->secret."&t=excel\"><img src=\"".plugins_url('custom-tables/img/excel.png')."\" border=\"0\" alt=\"Excel\" /></a>".
     "</div><div style=\"float:left;width:350px;height:300px;\"><h2>" . __('Import', 'wct') ." ". __('Table', 'wct') . "</h2>".
     "<form enctype=\"multipart/form-data\" action=\"admin.php?page=wct_table_".$tableid."&wcttab=importexport\" method=\"post\">".
     __('Please select CSV or XML File to upload and import', 'wct').": <input name=\"userfile\" type=\"file\" size=\"35\" value=\"\"><br/>".
     "<b>CSV ".__('Separator','wct').":</b> <select name=\"separator\"><option value=\"c\">".__('Comma','wct')."</option><option value=\"s\">".__('Semicolon','wct')."</option></select> <input type=\"submit\" name=\"fileupload\" value=\"". __('Upload File', 'wct')."\"></form></div>";

?>
