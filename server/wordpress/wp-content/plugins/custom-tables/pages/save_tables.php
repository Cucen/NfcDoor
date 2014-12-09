<?php

if ($_POST['submit'] != '' AND $_POST['viptID'] == '0') {
	/* Update of Achrive DB */
	if ($_POST['wctoverlay'] != '1') { $_POST['wctoverlay'] = '0'; }
	if ($_POST['wctheaderline'] != '1') { $_POST['wctheaderline'] = '0'; }
	if ($_POST['wctsheme'] != '1') { $_POST['wctsheme'] = '0'; }
	if ($_POST['wctdle'] == '1' AND $_POST['wctdlc'] == '1') { $dl = '3'; }
	elseif ($_POST['wctdle'] == '1') { $dl = '1'; }
	elseif ($_POST['wctdlc'] == '1') { $dl = '2'; }
	else { $dl = '0'; }
	if ($_POST['wctglobaledit'] == '1') { $ge = '1'; } else { $ge = '0'; }
	$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_list` SET `globaledit`='".$ge."', `overlay`='".mres($_POST['wctoverlay'])."', `editlink`='".mres($_POST['wceditlink'])."', `headerline`='".mres($_POST['wctheaderline'])."', `sheme`='".mres($_POST['wctsheme'])."',`dl`='".$dl."' WHERE `id`='0' LIMIT 1;");
}
elseif ($_POST['submit'] != '' AND $_POST['wctdelete'] != '1') {
	if ($_GET['wcttab2'] == 'sortfields') {
		$tablet = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".mres($_POST['viptID'])."`;");
		$array=array(); foreach($tablet as $member=>$data) { $array[$member]=$data; }
		$felderm = explode("PRIMARY KEY",$array['Create Table']);

		$query = "ALTER TABLE `".$wpdb->prefix."wct".mres($_POST['viptID'])."` ";
		preg_match("/(.*`id`.*)/",$felderm[0],$treffer);
		$query .= "\nCHANGE COLUMN `id` ".trim($treffer[0]);

		preg_match("/(.*`status`.*)/",$felderm[0],$treffer);
		$query .= "\nCHANGE COLUMN `status` ".trim($treffer[0]);
		$lastfield = "status";

		foreach($_POST['fields'] as $wert) {
			preg_match("/(.*`".$wert."`.*)/",$felderm[0],$treffer);
			$query .= "\nCHANGE COLUMN `".$wert."` ".substr(trim($treffer[0]),0,-1)." AFTER `".$lastfield."`,";
			$lastfield = $wert;
		}
		$wpdb->get_row(substr($query,0,-1).";");
	}
	elseif ($_GET['wcttab2'] == 'relation') {
		$s_table = $_POST['viptID'];
		foreach($_POST as $var => $wert) {
			if (substr($var,0,4) == "rel_") {
				$s_field = rtrim(substr($var,4,36));
				$t_table = $wert;
				$z_field = $_POST['tete_'.$s_field];
				$z_field2 = $_POST['tete2_'.$s_field];
				$exists = $wpdb->get_row("SELECT `r_id` FROM `".$wpdb->prefix."wct_relations` WHERE `s_table`='".mres($s_table)."' AND `s_field`='".mres($s_field)."';");
				if ($t_table == '') {
					$wpdb->get_row("DELETE FROM `".$wpdb->prefix."wct_relations` WHERE `s_table`='".mres($s_table)."' AND `s_field`='".mres($s_field)."';");
					$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct".mres($s_table)."` DROP FOREIGN KEY `".mres($s_field)."`");
				}
				elseif (count($exists) >= '1') {
					$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_relations` SET `z_field`='".mres($z_field)."', `z_field2`='".mres($z_field2)."', `t_table`='".mres($t_table)."', `t_field`='id' WHERE `s_table`='".mres($s_table)."' AND `s_field`='".mres($s_field)."';");
					$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct".mres($s_table)."` DROP FOREIGN KEY `".mres($s_field)."`");
					$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct".mres($s_table)."` ADD FOREIGN KEY (".mres($s_field).") REFERENCES ".$wpdb->prefix."wct".mres($t_table)." (".mres($z_field).") ON UPDATE CASCADE ON DELETE CASCADE");
				}
				else {
					$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_relations` SET `z_field`='".mres($z_field)."', `z_field2`='".mres($z_field2)."', `s_table`='".mres($s_table)."', `s_field`='".mres($s_field)."', `t_table`='".mres($t_table)."', `t_field`='id';");
					$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct".mres($s_table)."` ADD FOREIGN KEY (".mres($s_field).") REFERENCES ".$wpdb->prefix."wct".mres($t_table)." (".mres($z_field).") ON UPDATE CASCADE ON DELETE CASCADE");
				}
			}
		}	
	}
	elseif ($_GET['wcttab2'] == 'sindex') {
		$tablet = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".mres($_POST['viptID2'])."`;");
		$array=array(); foreach($tablet as $member=>$data) { $array[$member]=$data; }
		$felderm = explode("PRIMARY KEY",$array['Create Table']);
		$felder = array_slice(explode("`",$felderm[0]),5);
		$indexes = explode("`",$felderm[1]);

		/* check for all fields */
		for ($x=0;$felder[$x] !='';$x++) {
			$r['wcti_'.$felder[$x]] = '0';
			$j['wcti_'.$felder[$x]] = '0';
			if (strpos($felder[$x+1],"text") !== false OR strpos($felder[$x+1],"varchar") !== false) { $o['wcti_'.$felder[$x]] = '1'; }
			$x++;
		}

		/* set status for all fields */
		foreach($_POST as $var => $wert) {
			if (strpos($var,"wcti_") !== false) {
				$r[$var] = $wert;
				
				$var2 = str_replace("wcti_","wctiu_",$var);
				if ($_POST[$var2] == '1') { $d[$var] = '1'; }
			}
		}
		
		/* find existing indexes */
		for ($x=3;$indexes[$x] !='';$x++) {
			$j['wcti_'.$indexes[$x]] = '1';
			$x = $x + 3;
		}

		foreach ($r as $var => $wert) {
			if ($wert != $j[$var] AND $j[$var] != '1') {
				if ($d[$var] == '1') { $addnew .= "ADD UNIQUE INDEX `".str_replace("wcti_","",$var)."` (`".str_replace("wcti_","",$var)."`),"; }
				elseif ($o[$var] == '1') { $addnew .= "ADD FULLTEXT INDEX `".str_replace("wcti_","",$var)."` (`".str_replace("wcti_","",$var)."`(32)),"; }
				else { $addnew .= "ADD INDEX `".str_replace("wcti_","",$var)."` (`".str_replace("wcti_","",$var)."`),"; }
			}
			elseif ($wert != $j[$var] AND $j[$var] == '1') {
				/* delete index */
				$addnew .= "DROP INDEX `".str_replace("wcti_","",$var)."`,";
			}

		}
		if ($addnew != '') { $wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct".mres($_POST['viptID2'])."` ".mres(substr($addnew,0,strlen($addnew)-1)).";"); }
	}
	elseif ($_GET['wcttab2'] == 'wcs') {
		$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_list` SET `searchaddon`='".mres(stripslashes(html_entity_decode(str_replace(array("&lt;","&gt;"),array("<",">"),$_POST['searchq']))))."' WHERE `id`='".mres($_POST['viprID'])."' LIMIT 1;");
	}
	elseif ($_GET['page'] == 'wct_table_create' AND $_GET['wcttab2'] == 'clonetable' AND $_POST['source'] != '') {
		$source = (integer)$_POST['source'];
		echo "<br/><br/>".__('Please give it some time...','wct');
		$tabl = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wct_list`  WHERE id='".mres($source)."' LIMIT 1;");
		if(count($tabl) == '1') {
			unset($string);
			if ($_POST['what'] == 't') {
				$string = "`name`='Clone ".mres($tabl->name)."', `secret`='".md5("wct-".time())."',";
			}
			else {
				foreach ($tabl as $var => $wert) {
					if ($var == 'name') { $wert = "Clone ".$wert; }
					if ($var == 'secret') { $wert = md5("wct-".time()); }
					$string .= " `".mres($var)."`='".mres($wert)."',";
				}
			}
			$befehl = "INSERT INTO `".$wpdb->prefix."wct_list` SET ".substr(str_replace(" `id`='".$source."', ","",$string),0,-1).";";
			$wpdb->get_row($befehl);
			$clonetableid = $wpdb->insert_id;
			$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".mres($source)."`;");
			if(count($table) == '1') {
				$befehl = str_replace("`".$wpdb->prefix."wct".mres($source)."`","`".$wpdb->prefix."wct".mres($clonetableid)."`",$table->{'Create Table'});
				$wpdb->get_row($befehl);
			}
			if ($_POST['what'] == 'd') {
				$table = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wct".mres($source)."`;");
				foreach($table as $row) {
					unset($string);
					foreach ($row as $var => $wert) {
						$string .= "`".mres($var)."`='".mres($wert)."', ";
					}
					$befehl = "INSERT INTO `".$wpdb->prefix."wct".mres($clonetableid)."` SET ".substr($string,0,-2).";";
					$wpdb->get_row($befehl);
				}
			}
			exit("<meta http-equiv=\"refresh\" content=\"0;url=admin.php?page=wct_table_".$clonetableid."\">");
		}
		exit("<meta http-equiv=\"refresh\" content=\"0;url=admin.php?page=wct_table_create&wcttab2=clonetable&done=false\">");
	}
	elseif ($_GET['page'] == 'wct_table_create') {
		/* Table not existing, creating */
		$enumindex = 0;
		if ($_POST['wctoverlay'] != '1') { $_POST['wctoverlay'] = '0'; }
		if ($_POST['wctheaderline'] != '1') { $_POST['wctheaderline'] = '0'; }
		if ($_POST['wctsheme'] != '1') { $_POST['wctsheme'] = '0'; }
		if ($_POST['wctdle'] == '1' AND $_POST['wctdlc'] == '1') { $dl = '3'; }
		elseif ($_POST['wctdle'] == '1') { $dl = '1'; }
		elseif ($_POST['wctdlc'] == '1') { $dl = '2'; }
		else { $dl = '0'; }
		if ($_POST['wctglobaledit'] == '1') { $ge = '1'; } else { $ge = '0'; }

		$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_list` SET `globaledit`='".$ge."', `editlink`='".mres($_POST['wceditlink'])."', `name`='".mres($_POST['vipName'])."', `secret`='".md5("wct_".time())."', `overlay`='".mres($_POST['wctoverlay'])."', `headerline`='".mres($_POST['wctheaderline'])."', `sheme`='".mres($_POST['wctsheme'])."', `dl`='".$dl."';");
		$tableid = $wpdb->insert_id;
		$create = "CREATE TABLE `".$wpdb->prefix."wct".$tableid."` (\n`id` int(11) NOT NULL AUTO_INCREMENT,`status` enum('active','draft','passive') NOT NULL DEFAULT 'active',\n";

		foreach ($_POST['vipInfo'] as $var => $wert) {
			/*Filter for: Put only alphanumberic values as fieldnames into the database*/
			$wert = filter_var(strtolower(str_replace(" ","_",$wert)), FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9_-]+$/")));
			if ($wert != '') {
				if ($_POST['vipInfoB'][$var] == 'varchar32') { $create .= "`".mres($wert)."` varchar(32) CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL,\n"; }
				elseif ($_POST['vipInfoB'][$var] == 'varchar64') { $create .= "`".mres($wert)."` varchar(64) CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL,\n"; }
				elseif ($_POST['vipInfoB'][$var] == 'varchar128') { $create .= "`".mres($wert)."` varchar(128) CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL,\n"; }
				elseif ($_POST['vipInfoB'][$var] == 'varchar160') { $create .= "`".mres($wert)."` varchar(160) CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL,\n"; }
				elseif ($_POST['vipInfoB'][$var] == 'varchar254') { $create .= "`".mres($wert)."` varchar(254) CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL,\n"; }
				elseif ($_POST['vipInfoB'][$var] == 'int11') { $create .= "`".mres($wert)."` int(11)  NULL DEFAULT NULL,\n"; }
				elseif ($_POST['vipInfoB'][$var] == 'int10') { $create .= "`".mres($wert)."` int(10)  NULL DEFAULT NULL,\n"; }
				elseif ($_POST['vipInfoB'][$var] == 'int12') { $create .= "`".mres($wert)."` int(12)  NULL DEFAULT NULL,\n"; }
				elseif ($_POST['vipInfoB'][$var] == 'smallint6') { $create .= "`".mres($wert)."` smallint(6)  NULL DEFAULT NULL,\n"; }
				elseif ($_POST['vipInfoB'][$var] == 'float82') { $create .= "`".mres($wert)."` float(8,2) NULL DEFAULT NULL,\n"; }
				elseif ($_POST['vipInfoB'][$var] == 'enum') {
					$create .= "`".mres($wert)."` enum(";
						$enum = preg_replace(array("/[\s]+,/","/,[\s]+/"),array(",",","),stripslashes($_POST['enum'][$enumindex]));
						if (strpos($enum,"'") === false) { $enum = "'".str_replace(",","','",$enum)."'"; }
						if (substr($enum,0,1) == "\"" OR substr($enum,0,1) == "'") { $create .= $enum; }
						else { $create .= "'".$enum."'"; }
						$enumindex++;
					$create .= ") CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL,\n";
				}
				elseif ($_POST['vipInfoB'][$var] == 'set') {
					$create .= "`".mres($wert)."` set(";
						$enum = preg_replace(array("/[\s]+,/","/,[\s]+/"),array(",",","),stripslashes($_POST['enum'][$enumindex]));
						if (strpos($enum,"'") === false) { $enum = "'".str_replace(",","','",$enum)."'"; }
						if (substr($enum,0,1) == "\"" OR substr($enum,0,1) == "'") { $create .= $enum; }
						else { $create .= "'".$enum."'"; }
						$enumindex++;
					$create .= ") CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL,\n";
				}
				elseif ($_POST['vipInfoB'][$var] == 'text') {
					$create .= "`".mres($wert)."` text CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL,\n";
				}
				else { 
					$abfrage =  $wpdb->get_row("SELECT `name` FROM `".$wpdb->prefix."wct_fields` WHERE `definition`='".$feld2[$i]."' AND `special`='0' LIMIT 1;");
					if (count($abfrage) == '1') {
						$create .= "`".mres($wert)."` ".$abfrage->name." NULL DEFAULT NULL,\n";
					}
					else {
						$create .= "`".mres($wert)."` text CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL,\n";
					}
				}				
			}
		}

		$create .=  "PRIMARY KEY (`id`)\n) DEFAULT CHARSET=".DB_CHARSET.";";
		$wpdb->get_row($create);
		$_GET['page'] = 'wct_table_'.$tableid;
	}
	elseif($_POST['wctfren'] != '' AND $_POST['wctrfield'] != '') {

		$_POST['enums'] = preg_replace(array("/[\s]+,/","/,[\s]+/","/\\\'/"),array(",",",",""),$_POST['enums']);
		$enumeintraege = explode(",",$_POST['enums']);
		if ($_POST['resort'] == '1') { sort($enumeintraege); }
		$_POST['enums'] = "'".implode("','",$enumeintraege)."'";
		if ($_POST['wcthidden'] == "enum" OR $_POST['wcthidden'] == "set") {
			$enum = preg_replace(array("/[\s]+,/","/,[\s]+/"),array(",",","),stripslashes($_POST['enums']));
			if (strpos($enum,"'") === false) { $enum = "'".str_replace(",","','",$enum)."'"; }

			$_POST['wcthidden'] = $_POST['wcthidden']."(".$enum.")";
		}
		else { $_POST['wcthidden'] = mres($_POST['wcthidden']); }

		/* Alter a DB field */
		$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct".mres($_POST['viptID2'])."` CHANGE COLUMN `".mres($_POST['wctfren'])."` `".mres(preg_replace("/[^a-zA-Z0-9_]/" , "" , $_POST['wctrfield']))."` ".$_POST['wcthidden']." NULL DEFAULT NULL;");
	}
	elseif ($_POST['vipName'] != '') {

		$enumindex = 0;
		/* Update of the table, create new fields  if needed and drop old ones */
		if ($_POST['wctoverlay'] != '1') { $_POST['wctoverlay'] = '0'; }
		if ($_POST['wctheaderline'] != '1') { $_POST['wctheaderline'] = '0'; }
		if ($_POST['wctsheme'] != '1') { $_POST['wctsheme'] = '0'; }
		if ($_POST['wctdle'] == '1' AND $_POST['wctdlc'] == '1') { $dl = '3'; }
		elseif ($_POST['wctdle'] == '1') { $dl = '1'; }
		elseif ($_POST['wctdlc'] == '1') { $dl = '2'; }
		else { $dl = '0'; }
		if ($_POST['wctglobaledit'] == '1') { $ge = '1'; } else { $ge = '0'; }
		$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_list` SET `globaledit`='".$ge."', `editlink`='".mres($_POST['wceditlink'])."', `menu`='".mres($_POST['wcmen'])."', `name`='".mres($_POST['vipName'])."', `overlay`='".mres($_POST['wctoverlay'])."', `headerline`='".mres($_POST['wctheaderline'])."', `sheme`='".mres($_POST['wctsheme'])."', `dl`='".$dl."' WHERE `id`='".mres($_POST['viptID'])."' LIMIT 1;");

		$zeile = '0';
		$_POST['vipInfo'] = preg_replace("/[^a-zA-Z0-9_]/" , "" , $_POST['vipInfo']);
		$weg= array_diff($_POST['vipInfoC'],$_POST['vipInfo']);
		foreach ($weg as $var => $wert) {
			if ($zeile >= '1') { $out .= ",\n"; } $zeile++;
			$out .= "DROP COLUMN `".$wert."`";
		}

		$dazu = array_diff($_POST['vipInfo'],$_POST['vipInfoC']);
		foreach ($dazu as $var => $wert) {
			$wert = filter_var(strtolower(str_replace(" ","_",$wert)), FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9_-]+$/")));
			if ($wert != '') {
				foreach ($_POST['vipInfo'] as $a => $b) {
					if (strtolower($b) == $wert) {
						$gefunden = $_POST['vipInfoB'][$a];
					}
				}
				if ($zeile >= '1') { $out .= ",\n"; } $zeile++;

				if ($gefunden == 'varchar32') { $out .= "ADD COLUMN `".mres($wert)."` varchar(32) CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL"; }
				elseif ($gefunden == 'varchar64') { $out .= "ADD COLUMN `".mres($wert)."` varchar(64) CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL"; }
				elseif ($gefunden == 'varchar128') { $out .= "ADD COLUMN `".mres($wert)."` varchar(128) CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL"; }
				elseif ($gefunden == 'varchar160') { $out .= "ADD COLUMN `".mres($wert)."` varchar(160) CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL"; }
				elseif ($gefunden == 'varchar254') { $out .= "ADD COLUMN `".mres($wert)."` varchar(254) CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL"; }
				elseif ($gefunden == 'int11') { $out .= "ADD COLUMN `".mres($wert)."` int(11) NULL DEFAULT NULL"; }
				elseif ($gefunden == 'int10') { $out .= "ADD COLUMN `".mres($wert)."` int(10) NULL DEFAULT NULL"; }
				elseif ($gefunden == 'int12') { $out .= "ADD COLUMN `".mres($wert)."` int(12) NULL DEFAULT NULL"; }
				elseif ($gefunden == 'smallint6') { $out .= "ADD COLUMN `".mres($wert)."` smallint(6) NULL DEFAULT NULL"; }
				elseif ($gefunden == 'float82') { $out .= "ADD COLUMN `".mres($wert)."` float(8,2) NULL DEFAULT NULL"; }
				elseif ($gefunden == 'enum') {
					$out .= "ADD COLUMN `".mres($wert)."` enum(";
						$enum = stripslashes($_POST['enum'][$enumindex]);
						if (substr($enum,0,1) == "\"" OR substr($enum,0,1) == "'") { $out .= $enum; }
						else { $out .= "'".str_replace(",","','",$enum)."'"; }
						$enumindex++;
					$out .= ") NULL DEFAULT NULL";
				}
				elseif ($gefunden == 'set') {
					$out .= "ADD COLUMN `".mres($wert)."` set(";
						$enum = stripslashes($_POST['enum'][$enumindex]);
						if (substr($enum,0,1) == "\"" OR substr($enum,0,1) == "'") { $out .= $enum; }
						else { $out .= "'".str_replace(",","','",$enum)."'"; }
						$enumindex++;
					$out .= ") NULL DEFAULT NULL";
				}
				elseif ($gefunden == 'text') {
					$out .= "ADD COLUMN `".mres($wert)."` text CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL";
				}
				else {
					$abfrage =  $wpdb->get_row("SELECT `name` FROM `".$wpdb->prefix."wct_fields` WHERE `definition`='".$feld2[$i]."' AND `special`='0' LIMIT 1;");
					if (count($abfrage) == '1') {
						$out .= "ADD COLUMN `".mres($wert)."` ".$abfrage->name." NULL DEFAULT NULL";
					}
					else {
						$out .= "ADD COLUMN `".mres($wert)."` text CHARACTER SET ".DB_CHARSET." NULL DEFAULT NULL";
					}
				}
			}
		}
		if ($out != '') { $wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct".mres($_POST['viptID'])."` ".$out.";"); }
	}
}
elseif ($_POST['wctdelete'] == '1') {
	/* Table will be deleted from index and itself with the data */
	$wpdb->get_row("DELETE FROM `".$wpdb->prefix."wct_list` WHERE `id`='".mres($_POST['vipID'])."' LIMIT 1;");
	$wpdb->get_row("DROP TABLE `".$wpdb->prefix."wct".mres($_POST['vipID'])."`;");
	$_GET['page'] = 'wct_table_create';
}

?>